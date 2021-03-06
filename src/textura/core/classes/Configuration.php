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
 * This class represents the configuration of a Textura application
 */
class Configuration {

  /**
   * @var array current configuration
   */
  private $configuration;

  /**
   * Constructor
   *
   * @param string $config_file_path      If a soecific configuration file should be loaded
   */
  public function __construct($config_file_path = null) {
    $this->configuration = array();
    if (!is_null($config_file_path)) $this->loadConfig($config_file_path);
  }

  /**
   * Loads a configuration file
   *
   * @param string $config_file_path      The configuration file to load
   * @throws \LogicException               If the configuration file cannot be found
   */
  public function loadConfig($config_file_path) {
    if (file_exists($config_file_path) && is_readable($config_file_path)) {
      require_once(PathBuilder::buildPath(TEXTURA_SRC_DIR, 'spyc', 'spyc.php'));
      $this->configuration = \Spyc::YAMLLoad($config_file_path);
    }
    else {
      throw new \LogicException("Unable to load configuration file $config_file_path");
    }
  }

  /**
   * Saves the current configuration to the specified path.
   *
   * @param string $config_file_path
   * @throws \LogicException if the configuration file cannot be saved
   */
  public function saveConfig($config_file_path) {

    if (file_exists($config_file_path)) {
      $config_is_writable = is_writable($config_file_path);
    }
    else {
      // File does not exist.Check if parent firectory is writable
      $config_is_writable = is_writable(dirname($config_file_path));
    }

    if ($config_is_writable) {
      require_once(PathBuilder::buildPath(TEXTURA_SRC_DIR, 'spyc', 'spyc.php'));
      file_put_contents($config_file_path, \Spyc::YAMLDump($this->configuration));
    }
    else {
      throw new \LogicException("Unable to save configuration file $config_file_path");
    }
  }

  /**
   * Returns a specific configuration option. Keys support namespaces by using dot notation, so both
   * mykey and mynamespace.mykey are valid keys.
   *
   * If a key cannot be found, null is returned.
   *
   * @param string $key
   * @return mixed
   */
  public function get($key) {
    $parts = explode('.', $key);
    $current = $this->configuration;
    foreach ($parts as $current_part) {
      if (array_key_exists($current_part, $current)) $current = $current[$current_part];
      else return null;
    }
    return $current;
  }

  /**
   * Sets a specific configuration option. Keys support namespaces by using dot notation, so both
   * mykey and mynamespace.mykey are valid keys.
   *
   * @param string $key
   * @param mixed $value
   */
  public function set($key, $value) {
    $parts = explode('.', $key);
    $num_parts = count($parts);
    $current = &$this->configuration;
    for ($i = 0; $i < $num_parts - 1; $i++) {
      if (!array_key_exists($parts[$i], $current)) $current[$parts[$i]] = array();
      $current = &$current[$parts[$i]];

    }
    $current[$parts[$num_parts - 1]] = $value;
  }

  /**
   * Returns a "default" configuration for Textura.
   *
   * The default configuration will allow the user to configure Textura using a web interface.
   *
   * @return \self
   */
  public static function getDefaultConfiguration() {
    $instance = new self();
    $instance->set(
      'controllers.controller_map',
      array(
        array(
          'class'           =>  'Textura\Installer',
          'path'            =>  '/',
          'active'          =>  true,
          'default_action'  =>  'index'
        )
      )
    );
    $instance->set(
      'debugging',
      array(
        'allow_debugging' => true,
        'show_errors'     => true,
        'show_backtraces' => true
      )
    );
    $instance->set(
      'plugins',
      array(
        array('name' => 'FormBuilder')
      )
    );
    return $instance;
  }

}
?>