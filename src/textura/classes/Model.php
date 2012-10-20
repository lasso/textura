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

  /**
   * Loads a single model instance by primary key. If no model instance can be found,
   * null is returned.
   *
   * @param mixed $id
   * @return Model
   */
  public static function load($id) {
    return Model\ModelManager::getInstance()->loadSingleModelInstance(get_called_class(), $id);
  }

  /**
   * Loads all  available instances of a particular model
   *
   * @return array
   */
  public static function loadAll() {
    return Model\ModelManager::getInstance()->loadModelInstances(get_called_class(), array());
  }

  /**
   * Loads model instances where $conditions are true. If no model instances matching the
   * conditions can be found, an empty array is returned.
   *
   * @param array $conditions
   * @return array An array with model instances
   *
   */
  public static function loadBy(array $conditions) {
    return Model\ModelManager::getInstance()->loadModelInstances(get_called_class(), $conditions);
  }

  public function __construct() {
    $this->instance_properties = array();
    $available_properties = Model\ModelManager::getInstance()->getPropertyNames(get_class($this));
    foreach ($available_properties as $current_property) {
      $this->instance_properties[$current_property] = null;
    }
  }

  public function properties() {
    return $this->instance_properties;
  }

  public function save() {
    return Model\ModelManager::getInstance()->saveModelInstance($this);
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