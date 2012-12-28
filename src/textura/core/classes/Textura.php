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

namespace Textura;

require_once(
  dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR .
  'interfaces' . DIRECTORY_SEPARATOR . 'Singleton.php'
);
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Configuration.php');

/**
 * This class represents the Textura "application"
 */
class Textura implements Singleton {

  /**
   * @var Textura\Textura references the one and only instance of this class
   */
  private static $instance = null;

  /**
   * @var Textura\Configuration current configuration
   */
  private $configuration;

  /**
   * @var array currently registered plugins
   */
  private $plugins;

  /**
   * Constructor
   */
  protected function __construct() {
    $this->configuration = new Configuration();
    $this->initPlugins();
  }

  /**
   * Loads classes from Textura core and Textura plugins automatically.
   *
   * @param string $class_name class to load
   * @return void
   */
  public static function autoload($class_name) {
    $class_name_parts = explode('\\', $class_name);
    if ($class_name_parts[0] == 'Textura')
      array_shift($class_name_parts);
    $num_parts = count($class_name_parts);

    if ($num_parts > 1) {
      foreach ($class_name_parts as $k => $v) {
        if ($k < ($num_parts - 1))
          $class_name_parts[$k] = strtolower($v);
      }
    }

    $possible_paths =
            array(
                array(TEXTURA_CORE_DIR, 'classes'),
                array(TEXTURA_CORE_DIR, 'classes', 'model'),
                array(TEXTURA_CORE_DIR, 'interfaces'),
                array(TEXTURA_SITE_DIR),
                array(TEXTURA_CONTROLLER_DIR),
                array(TEXTURA_MODEL_DIR),
    );

    foreach ($possible_paths as $current_possible_path) {
      $possible_full_path =
        PathBuilder::buildPath(
          array_merge($current_possible_path, $class_name_parts)
        ) . '.php';
      if (file_exists($possible_full_path) && is_readable($possible_full_path)) {
        require_once($possible_full_path);
        return;
      }
    }

    // Class not found in core. Lets try loaded plugins
    $possible_plugin_paths = Textura::getInstance()->getPluginPaths();

    foreach ($possible_plugin_paths as $current_possible_plugin_path) {
      $possible_full_path =
        PathBuilder::buildPath(
          array_merge(array($current_possible_plugin_path), $class_name_parts)
        ) . '.php';
      if (file_exists($possible_full_path) && is_readable($possible_full_path)) {
        require_once($possible_full_path);
        return;
      }
    }
  }

  /**
   * Returns the (single) instance of the Textura class.
   *
   * @return Textura
   */
  public static function getInstance() {
    if (self::$instance == null) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  /**
   * Returns a specified configuration option. If the option does not exist, null is returned.
   *
   * @param string $key
   * @return mixed
   */
  public function getConfigurationOption($key) {
    return $this->configuration->get($key);
  }

  /**
   * Sets a specified configuration option. If the option does not exist it will be created.
   *
   * @param string $key
   * @param mixed $value
   */
  public function setConfigurationOption($key, $value) {
    $this->configuration->set($key, $value);
  }

  /**
   * Return all paths registered by plugins.
   *
   * @return array
   */
  public function getPluginPaths() {
    $paths = array();
    foreach ($this->plugins as $plugin) {
      $paths = array_merge($paths, $plugin->getPaths());
    }
    return $paths;
  }

  /**
   * Loads all plugins requested by configuration file.
   */
  private function initPlugins() {
    $this->plugins = array();
    $plugins = $this->getConfigurationOption('plugins');
    if (is_array($plugins)) {
      foreach ($plugins as $plugin) {
        $this->registerPlugin(
          $plugin['name'],
          array_key_exists('custom_dir', $plugin) ? $plugin['custom_dir'] : null,
          array_key_exists('custom_file', $plugin) ? $plugin['custom_file'] : null,
          array_key_exists('custom_class', $plugin) ? $plugin['custom_class'] : null
        );
      }
    }
  }

  /**
   * Register a plugin to be used by the framework.
   *
   * @param string $name Name of plugin to load.
   * @param string $custom_dir custom directory where plugin can be found. If null, uses
   *   TEXTURA_PLUGIN_DIR/$name.
   * @param string $custom_file custom file name where plugin can be found. If null, uses
   *   plugin_dir/$name.php.
   * @param string $custom_class custom class name that should be loaded. If null, uses
   *   "{$name}Plugin".
   * @param string $custom_namespace custom namespace that should be used to initialize the plugin
   *   class. If null, the "Textura" namespace is assumed.
   * @throws \LogicException if the plugin cannot be loaded for some reason.
   */
  private function registerPlugin(
    $name, $custom_dir = null, $custom_file = null, $custom_class = null, $custom_namespace = null
  ) {
    $absolute_path =
      !is_null($custom_dir) ?
      strval($custom_dir) :
      PathBuilder::buildPath(TEXTURA_PLUGIN_DIR, $name);
    $real_path = realpath($absolute_path);
    if (!$real_path) throw new \LogicException("Cannot find plugin path $absolute_path");
    if (!is_dir($real_path)) {
      throw new \LogicException("$real_path is not a directory");
    }
    if (!is_readable($real_path)) {
      throw new \LogicException("$real_path is not readable");
    }
    if (array_key_exists($name, $this->plugins)) {
      throw new \LogicException("Plugin $name already registered");
    }
    foreach ($this->plugins as $plugin) {
      if ($real_path == $plugin->getBasePath()) {
        throw new \LogicException(
          "Plugin path $real_path is already registered by another plugin."
        );
      }
    }
    $file = !is_null($custom_file) ? $custom_file : "{$name}Plugin.php";
    require_once(PathBuilder::buildPath($real_path, $file));
    $class = !is_null($custom_class) ? $custom_class : "{$name}Plugin";
    $namespace = !is_null($custom_namespace) ? $custom_namespace : 'Textura';
    $reflection_class = new \ReflectionClass("$namespace\\$class");
    $initializer = $reflection_class->getMethod('getInstance');
    $instance = $initializer->invokeArgs(null, array());
    $instance->register();
    $this->plugins[] = $instance;
  }

}

// Add Textura as a handler for autoloading classes
spl_autoload_register(array('Textura\Textura', 'autoload'));
?>