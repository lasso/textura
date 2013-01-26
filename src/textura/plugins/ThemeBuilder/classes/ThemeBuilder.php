<?php
/*
Copyright 2012, 2013 Lars Olsson <lasso@lassoweb.se>

This file is part of Textura.

Textura is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Textura is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*/

/**
 * Textura
 *
 * @package Textura
 */

namespace Textura;

/**
 * Class for building themes.
 */
class ThemeBuilder {

  /**
   * @var string directory for dynamic CSS content
   */
  private $css_dir;

  /**
   * @var array array of ThemeColumn objects representing columns in the theme
   */
  private $columns;

  /**
   * @var integer number of pixels compromising a "column unit"
   */
  private $column_width;

  /**
   * @var integer number of pixels between columns
   */
  private $gutter_width;

  /**
   * @var array array of custom LESS files
   */
  private $included_css;

  /**
   * @var string directory for dynamic Haml content
   */
  private $template_dir;

  /**
   * @var integer number of columns in theme
   */
  private $width;

  /**
   * Constructor
   *
   * @param string $base_template base template to use when rendering
   * @param string $template_dir directory for dynamic Haml content
   * @param string $css_dir directory for dynamic CSS content
   */
  public function __construct($base_template, $template_dir, $css_dir) {
    $this->base_template = $base_template;
    $this->css_dir = $css_dir;
    $this->columns = array();
    $this->column_width = null;
    $this->gutter_width = null;
    $this->included_css = array();
    $this->template_dir = $template_dir;
    $this->width = 0;
  }

  /**
   * Add a column to the current theme builder.
   *
   * @param ThemeColumn $column a ThemeColumn object
   * @throws \LogicException if a column with the same id is already present in the theme builder.
   */
  public function addColumn(ThemeColumn $column) {
    if ($this->hasColumn($column->getId())) {
      throw new \LogicException("Column {$column->id} already exists");
    }
    $this->columns[] = $column;
    $this->calculateTotalWidth();
  }

  /**
   * Returns the number of columns for the current theme builder.
   *
   * @return integer
   */
  public function getWidth() {
    return $this->width;
  }

  /**
   * Renders the view associated with the current theme builder. CSS files and HAML templates are
   * automatically generated if needed.
   *
   * @return string
   * @throws \LogicException if the theme builder lacks all kinds of content.
   */
  public function render() {
    // Ensure that css_dir is set so that we can generate a dynamic CSS file
    if (count($this->columns) === 0) {
      throw new \LogicException("Cannot render without at least one column.");
    }

    // Write CSS file
    $this->writeCSS();

    // Write HAML template
    $this->writeTemplate();

    return $this->renderTemplate();
  }

  /**
   * Returns a hash for the current theme builder. This is used to decide whether CSS files and
   * HAML templates need to be generated or not in various situations.
   *
   * @return string
   */
  public function getHash() {
    $hash = '';
    $hash .= $this->base_template;
    foreach ($this->columns as $column) {
      $hash .= $column->getHash();
    }
    foreach ($this->included_css as $css) {
      $hash .= $css . filemtime($css);
    }
    $hash .= $this->column_width;
    $hash .= $this->gutter_width;
    return sha1($hash);
  }

  /**
   * Add styles from LESS file.
   *
   * @param string $path
   */
  public function includeCSS($path) {
    $this->included_css[] = $path;
  }

  /**
   * Sets the base Haml template to use for rendering.
   *
   * @param string $path
   */
  public function setBaseTemplate($path) {
    $this->base_template = $path;
  }

  /**
   * Sets the number of pixels used as a column "unit".
   *
   * @param integer $width_in_pixels
   */
  public function setColumnWidth($width_in_pixels) {
    $this->column_width = intval($width_in_pixels);
  }

  /**
   * Sets the directory to use for dynamically created CSS files.
   *
   * @param string $path
   */
  public function setCSSDir($path) {
    $this->css_dir = $path;
  }

  /**
   * Sets the contents for a specific column.
   *
   * @param string $column_id name identifying the column
   * @param string $contents contents to display in the column
   * @throws \LogicException if the column cannot be found
   */
  public function setContents($column_id, $contents) {
    $column = $this->getColumn($column_id);
    if (!$column instanceof ThemeColumn) {
      throw new \LogicException("Unknown column $column_id");
    }
    $column->setContents($contents);
  }

  /**
   * Sets the spacing width between columns.
   *
   * @param integer $width_in_pixels
   */
  public function setGutterWidth($width_in_pixels) {
    $this->gutter_width = intval($width_in_pixels);
  }

  /**
   * Sets the directory where dynamtic HAML templates should be stored.
   *
   * @param string $path
   */
  public function setTemplateDir($path) {
    $this->template_dir = $path;
  }

  /**
   * Calculates the total number of "column uits" in the theme.
   */
  private function calculateTotalWidth() {
    $total_width = 0;
    foreach ($this->columns as $column) {
      $total_width += $column->getWidth();
    }
    $this->width = $total_width;
  }

  /**
   * Returns a column by id. If the column is not present in the theme, null is returned.
   *
   * @param string $column_id
   * @return ThemeColumn
   */
  private function getColumn($column_id) {
    $found_column = null;
    foreach ($this->columns as $column) {
      if ($column->getId() == $column_id) {
        $found_column = $column;
        break;
      }
    }
    return $found_column;
  }

  /**
   * Returns whether a specific column exists in the theme.
   *
   * @param string $column_id
   * @return boolean
   */
  private function hasColumn($column_id) {
    return $this->getColumn($column_id) instanceof ThemeColumn;
  }

  /**
   * Converts a LESS file to a CSS file.
   *
   * @param string $input_path path to less file
   * @param string $output_path destination path. If omitted, the original LESS file will be
   *   overwritten by the CSS file.
   */
  public function less2CSS($input_path, $output_path = null) {
    $less = new \lessc();
    $input = file_get_contents($input_path);
    $output = $less->compile($input);
    if ($output_path) {
      file_put_contents($output_path, $output, LOCK_EX);
    }
    else {
      file_put_contents($input_path, $output, LOCK_EX);
    }
  }

  /**
   * Renders the HAML template associated with the current theme builder
   *
   * @return string
   */
  private function renderTemplate() {
    $instance_vars = \Textura\Current::controller()->getInstanceVars();
    $instance_vars['style_hash'] = $this->getHash();

    // Get content blocks
    foreach ($this->columns as $column) {
      $instance_vars[$column->getId() . '_content'] = $column->getContents();
    }

    require_once(\Textura\PathBuilder::buildPath(TEXTURA_SRC_DIR, 'phamlp', 'haml', 'HamlParser.php'));
    $haml_parser = new \HamlParser();
    ob_start();
    // Extract $controller instance vars into global scope so that they can be referenced by HAML
    extract($instance_vars);
    // Eval HAML
    $template_path = \Textura\PathBuilder::buildPath($this->template_dir, $this->getHash());
    eval(preg_replace('/^\<\?php\s/', '', $haml_parser->haml2PHP($template_path), 1));
    $result = ob_get_contents();
    ob_end_clean();
    // Remove instance variables from global scope again
    foreach ($instance_vars as $current_instance_var) {
      unset($current_instance_vars);
    }

    return $result;
  }

  /**
   * Writes a CSS file for the current theme.
   */
  private function writeCSS() {
    $path = \Textura\PathBuilder::buildPath($this->css_dir, $this->getHash());
    if (file_exists($path)) return; // CSS file written on previous occasion
    // Calculate path to grid.less
    $grid_plugin =
      PathBuilder::buildPath(
        dirname(dirname(__FILE__)), 'semantic.gs', 'stylesheets', 'less', 'grid.less'
      );
    $handle = fopen($path, 'w');
    if ($handle) {
      // Include user CSS
      foreach ($this->included_css as $css) {
        fwrite($handle, "@import '$css';\n");
      }
      // Include semantic.gs
      fwrite($handle, "@import '{$grid_plugin}';\n\n");
      if (!is_null($this->column_width)) {
        fwrite($handle, "@column-width: {$this->column_width};\n");
      }
      if (!is_null($this->gutter_width)) {
        fwrite($handle, "@gutter-width: {$this->gutter_width};\n");
      }
      fwrite($handle, "@columns: {$this->getWidth()};\n");
      foreach ($this->columns as $column) {
        fwrite ($handle, "#{$column->getId()} { .column({$column->getWidth()}); }\n");
      }
      fclose($handle);
    }
    $this->less2CSS($path);
  }

  /**
   * Writes a HAML template file for the current theme.
   */
  private function writeTemplate() {
    $path = \Textura\PathBuilder::buildPath($this->template_dir, $this->getHash());
    if (file_exists($path)) return; // Template file written on previous occasion
    $template_data = file_get_contents($this->base_template);
    $matches = array();
    preg_match('/^.*\n(.*)%body/is', $template_data, $matches);
    $indent = strlen($matches[1]) + 2;
    $prefix = str_repeat(' ', $indent);
    $prefix_content = $prefix . '  ';
    foreach ($this->columns as $column) {
      $template_data .= "\n" . $prefix . '%div#' . $column->getId();
      $template_data .= "\n" . $prefix_content . '= $' . $column->getId() . '_content';
    }
    file_put_contents($path, $template_data);
  }

}
?>