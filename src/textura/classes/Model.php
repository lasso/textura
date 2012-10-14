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

abstract class Model {

  private $instance_properties;

  private static $table = null;
  private static $properties = array();

  public function __construct() {
    $this->instance_properties = array();
    $available_properties = ModelManager::getInstance()->getPropertyNames(get_class($this));
    foreach ($available_properties as $current_property) {
      $this->instance_properties[$current_property] = null;
    }
  }

  public function properties() {
    return $this->instance_properties;
  }

  public function save() {
    return ModelManager::getInstance()->saveModelInstance($this);
  }

  public function __get($key) {
    if (array_key_exists($key, $this->instance_properties)) return $this->instance_properties[$key];
    else throw new \LogicException('Class ' . get_class($this) . " has no property $key.");
  }

  public function __set($key, $value) {
    if (array_key_exists($key, $this->instance_properties)) $this->instance_properties[$key] = $value;
    else throw new \LogicException('Class ' . get_class($this) . " has no property $key.");
  }

}
?>