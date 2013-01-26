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
 * This class represent a controller that can be used to configure Textura.
 */
class Installer extends Controller {

  /**
   * The index action allows the user to configure Textura and write a configuration file.
   */
  public function index() {
    $this->error = null;
    $this->enabled = $this->canWriteConfig();
    $this->config_path = $this->getConfigPath();
    $this->form = $this->getInstallerForm($this->enabled);
    if ($this->request->isPost()) {
      $data = $this->request->post_params;
      $db_path_ok = empty($data['db_location']) || $this->checkWritable($data['db_location']);
      if ($this->form->validate($data) && $db_path_ok) {
        $this->writeConfig($data);
      }
      else {
        $errors = array();
        foreach ($this->form->getValidationErrors() as $current_error) {
          $errors[] = $current_error;
        }
        if (!$db_path_ok) {
          $errors[] = 'The database path ' . $data['db_location'] . ' is not writeable';
        }
        $this->error = implode('<br>', $errors);
        // Repopulate form
        $this->form->updateAttribute('controller_class', 'value', $data['controller_class']);
        $this->form->updateAttribute('default_action', 'value', $data['default_action']);
        $this->form->updateAttribute('db_location', 'value', $data['db_location']);
        if (array_key_exists('cbAllowDebugging', $data)) {
          $this->form->updateAttribute('cbAllowDebugging', 'checked', true);
        }
        if (array_key_exists('cbShowErrors', $data)) {
          $this->form->updateAttribute('cbShowErrors', 'checked', true);
        }
        if (array_key_exists('cbShowBacktraces', $data)) {
          $this->form->updateAttribute('cbShowBacktraces', 'checked', true);
        }
        if (array_key_exists('cbFormBuilder', $data)) {
          $this->form->updateAttribute('cbFormBuilder', 'checked', true);
        }
        if (array_key_exists('cbThemeBuilder', $data)) {
          $this->form->updateAttribute('cbThemeBuilder', 'checked', true);
        }
      }

    }
    ViewHelper::renderTemplate(
      $this->getInstallerFilePath('index.haml'),
      $this,
      $this->response
    );
  }

  /**
   * Sends the style sheet for the installer controller to the browser
   */
  public function style() {
    $this->response->setHeader('Content-Type', 'text/css');
    $this->response->appendToBody(file_get_contents($this->getInstallerFilePath('textura.css')));
  }

  /**
   * Returns whether the specified path exists and is readable.
   *
   * @param string $path
   * @return boolean
   */
  private function checkReadable($path) {
    return file_exists($path) && is_readable($path);
  }

  /**
   * Returns whether the specified path is writable. If path already exist, the method
   * checks whether the file can be overwritten, otherwise it checks whether the parent
   * directory can be written to.
   *
   * @param string $path
   * @return boolean
   */
  private function checkWritable($path) {
    if (file_exists($path)) {
      return is_writable($path);
    }
    else {
      // File does not exist.Check if parent firectory is writable
      return is_writable(dirname($path));
    }
  }

  /**
   * Returns whether the static location of the config file can be written to.
   *
   * @return boolean
   */
  private function canWriteConfig() {
    return $this->checkWritable($this->getConfigPath());
  }

  /**
   * Creates a controller file from the specified parameters.
   *
   * @param string $controller_class
   * @param string $default_action
   */
  private function createController($controller_class, $default_action) {
    $data =
      sprintf(
        "<?php\n" .
        "class %s extends \Textura\Controller {\n" .
        "  public function %s() {\n" .
        "    \$this->response->appendToBody('Textura is configured. Yay!');\n" .
        "  }\n" .
        "}\n" .
        "?>",
        $controller_class,
        $default_action
      );
    file_put_contents(
      PathBuilder::buildPath(TEXTURA_SITE_DIR, 'controllers', "$controller_class.php"),
      $data
    );
  }

  /**
   * Returns the static path to the configuration path.
   *
   * @return string
   */
  private function getConfigPath() {
    return PathBuilder::buildPath(TEXTURA_SITE_DIR, 'config.yml');
  }

  /**
   * Returns the full path to the specified filename in Texturas "install" directory.
   *
   * @param string $filename
   * @return string
   */
  private function getInstallerFilePath($filename) {
    return PathBuilder::buildPath(dirname(__FILE__), 'installer', $filename);
  }

  /**
   * Returns a form that is used to configure Textura.
   *
   * @param boolean $enabled
   * @return \Textura\FormBuilder
   */
  private function getInstallerForm($enabled = true) {
    $form = new FormBuilder('installer_form', $this->rs('index'));
    $form->addCustomContent(
      array(
        'class'   =>  'small',
        'content' =>  'Fields marked with <strong>*</strong> are required, all aother fields ' .
                      'may be left blank.'
      )
    );
    $form->addCustomContent(
      array(
        'class'   =>  'section',
        'content' =>  'Controllers'
      )
    );
    $form->addText(
      array(
        'label'     =>  'Name of controller class*',
        'name'      =>  'controller_class',
        'value'     =>  'MainController',
        'disabled'  =>  !$enabled
      )
    );
    $form->addText(
      array(
        'label' =>  'Name of default action*',
        'name'  =>  'default_action',
        'value' =>  'index',
        'disabled'  =>  !$enabled
      )
    );
    $form->addCustomContent(
      array(
        'class'   =>  'section',
        'content' =>  'Database'
      )
    );
    $form->addText(
      array(
        'label' =>  'Location for SQLite database',
        'name'  =>  'db_location',
        'value' =>  PathBuilder::buildPath(TEXTURA_SITE_DIR, 'textura.sqlite'),
        'disabled'  =>  !$enabled
      )
    );
    $form->addCustomContent(
      array(
        'class'   =>  'section',
        'content' =>  'Debugging'
      )
    );
    $form->addCheckbox(
      array(
        'label'     =>  'Allow debugging',
        'name'      =>  'cbAllowDebugging',
        'disabled'  =>  !$enabled
      )
    );
    $form->addCheckbox(
      array(
        'label'     =>  'Show errors',
        'name'      =>  'cbShowErrors',
        'disabled'  =>  !$enabled
      )
    );
    $form->addCheckbox(
      array(
        'label'     =>  'Show backtraces',
        'name'      =>  'cbShowBacktraces',
        'disabled'  =>  !$enabled
      )
    );
    $form->addCustomContent(
      array(
        'class'   =>  'section',
        'content' =>  'Plugins'
      )
    );
    $form->addCheckbox(
      array(
        'label'     =>  'FormBuilder',
        'name'      =>  'cbFormBuilder',
        'disabled'  =>  !$enabled
      )
    );
    $form->addCheckbox(
      array(
        'label'     =>  'ThemeBuilder',
        'name'      =>  'cbThemeBuilder',
        'disabled'  =>  !$enabled
      )
    );
    $form->addSubmit(
      array(
        'id'        =>  'btnSubmit',
        'value'     =>  'Create configuration file',
        'disabled'  =>  !$enabled
      )
    );
    $form->addValidation(
      'controller_class',
      'matches_regexp',
      array('regexp' => '/\w/', 'message' => 'Controller name must be a word.')
    );
    $form->addValidation(
      'default_action',
      'matches_regexp',
      array('regexp' => '/\w/', 'message' => 'Default action must be a word.')
    );
    $form->setUseClientSideValidation(false);
    return $form;
  }

  /**
   * Writes a configuration file for textura using the provided data.
   *
   * @param array $data
   */
  private function writeConfig(array $data) {
    $configuration = new Configuration();
    $configuration->set(
      'controllers.controller_map',
      array(
        array(
          'class'           =>  $data['controller_class'],
          'path'            =>  '/',
          'active'          =>  true,
          'default_action'  =>  $data['default_action']
        )
      )
    );
    if (!empty($data['db_location'])) {
      $configuration->set(
        'database',
        array(
          'adapter' =>  'sqlite',
          'params'  =>  array('filename' => $data['db_location'])
        )
      );
    }
    $configuration->set(
      'debugging',
      array(
        'allow_debugging' => array_key_exists('cbAllowDebugging', $data),
        'show_errors'     => array_key_exists('cbShowErrors', $data),
        'show_backtraces' => array_key_exists('cbShowBacktraces', $data)
      )
    );
    $plugins = array();
    if (array_key_exists('cbFormBuilder', $data)) $plugins[] = array('name' => 'FormBuilder');
    if (array_key_exists('cbThemeBuilder', $data)) $plugins[] = array('name' => 'ThemeBuilder');
    $configuration->set('plugins', $plugins);

    $configuration->saveConfig($this->getConfigPath());

    $this->createController($data['controller_class'], $data['default_action']);

    $this->response->sendRedirect(PathBuilder::getTexturaBaseURL());
  }

}
?>