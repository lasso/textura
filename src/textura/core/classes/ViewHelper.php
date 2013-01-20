<?php
/*
Copyright 2012 Lars Olsson <lasso@lassoweb.se>

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
 * This helper renders HAML templates.
 */
class ViewHelper {

  /**
   * Renders a HAML template.
   *
   * @param string $template_path path to HAML file
   * @param \Textura\Controller $controller_obj a Textura controller containing variables to use in the
   *   HAML template
   * @param \Textura\Response $response_obj a Textura Response object that should handle the output
   * @param array $extra_vars any other variables that should be available in the HAML template
   */
  public static function renderTemplate(
    $template_path,
    Controller $controller_obj = null,
    Response $response_obj = null,
    array $extra_vars = null
  ) {
    $use_controller_instance_vars = isset($controller_obj);
    $use_extra_vars = isset($extra_vars);
    require_once(PathBuilder::buildPath(TEXTURA_SRC_DIR, 'phamlp', 'haml', 'HamlParser.php'));
    $haml_parser = new \HamlParser();
    ob_start();
    // Check if variables from the controller and/or the extra vars array should be used. If they
    // should, extract them into the global scope so that HAML can see them
    $template_vars =
      $use_controller_instance_vars ?
      $controller_obj->getInstanceVars() :
      array();
    if ($use_extra_vars) $template_vars = array_merge($template_vars, $extra_vars);
    if (!empty($template_vars)) extract($template_vars);
    // Eval HAML
    eval(preg_replace('/^\<\?php\s/', '', $haml_parser->haml2PHP($template_path), 1));
    $content = ob_get_contents();
    ob_end_clean();
    // Remove instance variables from global scope again (if needed)
    if (!empty($template_vars)) {
      foreach ($template_vars as $current_template_var) unset($current_template_var);
    }
    if (isset($response_obj)) $response_obj->appendToBody($content);
    else return $content;
  }

}
?>