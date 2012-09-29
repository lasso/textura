<?php
/*
Copyright 2012 Lars Olsson <lasso@lassoweb,se>

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

/**
 * This class represents the Textura "application"
 */
class Textura implements Singleton {

  // References the one and only instance of this class
  private static $instance = null;

  // Current configuration
  private $configuration;

  protected function __construct() {
    $this->configuration = new Configuration();
  }

  public static function getInstance() {
    if (self::$instance == null) {
      self::$instance = new Textura();
    }
    return self::$instance;
  }

  public function getConfigurationOption($key) {
    return $this->configuration->get($key);
  }

  public function setConfigurationOption($key, $value) {
    return $this->configuration->set($key, $value);
  }

}
?>