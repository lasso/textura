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

class ModelManager implements Singleton {

  private $db_manager;
  private $model_map;

  private static $instance = null;

  private function __construct() {
    $this->db_manager = DBManager::getInstance();
    $this->model_map = array();
  }

  public static function getInstance() {
    if (is_null(self::$instance)) self::$instance = new self;
    return self::$instance;
  }

  public function getMap() {
    return $this->model_map;
  }

  public function getProperties($model_class) {
    // First, check if model is already loaded. If it is, just return the property list.
    if (array_key_exists($model_class, $this->model_map)) {
      echo "1";
      return $this->model_map[$model_class]['properties'];
    }
    // The model is not loaded yet. Try to load it.
    if ($this->loadModel($model_class)) {
      // Model successfully loaded. Return the property list.
      return $this->model_map[$model_class]['properties'];
    }
    else {
      // Could not load model.
      trigger_error("Unable to find model definition for $model_class");
      return null;
    }
  }

  public function getPropertyNames($model_class) {
    return array_keys($this->getProperties($model_class));
  }

  public function getTable($model_class) {
    // First, check if model is already loaded. If it is, just return the table name.
    if (array_key_exists($model_class, $this->model_map)) {
      return $this->model_map[$model_class]['table'];
    }
    // The model is not loaded yet. Try to load it.
    if ($this->loadModel($model_class)) {
      // Model successfully loaded. Return the table.
      return $this->model_map[$model_class]['table'];
    }
    else {
      // Could not load model.
      trigger_error("Unable to find model definition for $model_class");
      return null;
    }
  }

  /**
   * Saves a model instance
   *
   * @param \Textura\Model $model_instance
   */
  public function saveModelInstance($model_instance) {
    $model_class = get_class($model_instance);
    $table = $this->model_map[$model_class]['table'];
    $primary_key_field = $this->model_map[$model_class]['primary_key'];
    $properties = $model_instance->properties();
    unset($properties[$primary_key_field]);
    if (empty($model_instance->$primary_key_field)) {
      $model_instance->$primary_key_field = $this->db_manager->insertRow($table, $properties);
    }
    else {
      $this->db_manager->updateRow($table, $model_instance->$primary_key_field, $properties);
    }
  }

  private function loadModel($model_class) {
    $reflection_class = new \ReflectionClass($model_class);
    $static_props = $reflection_class->getStaticProperties();
    // Check if model defines a table name. If it does, try to use that table name.
    // If the model does not define a table name, try to use
    // the model name (lowercased) as the table name.
    $table =
      !empty($static_props['table']) ?
      strval($static_props['table']) :
      strtolower(strval($model_class)); // TODO: Need to handle classes with special chars
    // Try loading fields from database
    $properties = $this->db_manager->getFields($table);
    // Check for overrides of field types in the model
    if (!empty($static_props['properties'])) {
      $properties = array_merge_recursive($properties, $static_props['properties']);
    }

    // Locate primary key so that we can more easily find out if a model instance is saved or not
    $primary_key = null;
    foreach ($properties as $current_key => $current_value) {
      if ($current_value['primary_key']) $primary_key = $current_key;
    }

    if (empty($primary_key)) {
      throw new LogExecption("Cannot load model $model_class. It has no primary key!");
    }

    // Update model map
    $this->model_map[$model_class] =
      array(
        'table' => $table,
        'primary_key' => $primary_key,
        'properties' => $properties
      );
    return true;
  }

}

?>