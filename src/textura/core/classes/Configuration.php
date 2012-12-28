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
    if (is_null($config_file_path)) {
      $config_file_path = PathBuilder::buildPath(TEXTURA_SITE_DIR, 'config.yml');
    }
    $this->loadConfig($config_file_path);
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
    $current = $this->configuration;
    for ($i = 0; $i < $num_parts - 1; $i++) {
      if (!array_key_exists($parts[$i], $current)) $current[$parts[$i]] = array();
      $current = $current[$parts[$i]];
    }
    $current[$parts[$num_parts - 1]] = $value;
  }

}
?>