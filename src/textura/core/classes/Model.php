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
 * Abstract class representing a database model.
 */
abstract class Model {

  // Available property types. Thes are the types that can be used by any model regardless of
  // what database is used
  const PROPERTY_TYPE_INTEGER     = 1;
  const PROPERTY_TYPE_JSON        = 2;
  const PROPERTY_TYPE_FLOAT       = 3;
  const PROPERTY_TYPE_MODEL       = 4;      // Refers to another model class
  const PROPERTY_TYPE_SERIALIZED  = 5;
  const PROPERTY_TYPE_STRING      = 6;

  /**
   * @var array Properties defined by database schema.
   */
  private $instance_properties;

  /**
   * @var string database schema (table) name
   */
  private static $table = null;

  /**
   * @var array Properties defined outside of database schema. Override this property to
   *   provide custom handling of values for specific properties.
   */
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

  /**
   * Constructor
   */
  public function __construct() {
    $this->instance_properties = array();
    $available_properties = Model\ModelManager::getInstance()->getPropertyNames(get_class($this));
    foreach ($available_properties as $current_property) {
      $this->instance_properties[$current_property] = null;
    }
  }

  /**
   * Returns an array of available properties.
   *
   * @return array
   */
  public function properties() {
    return $this->instance_properties;
  }

  /**
   * Deletes the current model object from the database. Calling this method will *not* destroy the
   * model object itself.
   */
  public function delete() {
    Model\ModelManager::getInstance()->deleteModelInstance($this);
  }

  /**
   * Saves the current model object to the underlying data store.
   *
   * @return boolean true if the save operation succeeds, false otherwise
   */
  public function save() {
    return Model\ModelManager::getInstance()->saveModelInstance($this);
  }

  /**
   * Magic property getter
   *
   * @param string $key
   * @return mixed
   * @throws \LogicException if the property does not exist
   */
  public function __get($key) {
    if (array_key_exists($key, $this->instance_properties)) return $this->instance_properties[$key];
    else throw new \LogicException('Class ' . get_class($this) . " has no property $key.");
  }

  /**
   * Magic property setter
   *
   * @param string $key
   * @param mixed $value
   * @throws \LogicException if the property does not exist
   */
  public function __set($key, $value) {
    if (array_key_exists($key, $this->instance_properties)) {
      $this->instance_properties[$key] = $value;
    }
    else {
      throw new \LogicException('Class ' . get_class($this) . " has no property $key.");
    }
  }

}
?>