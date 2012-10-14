<?php
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