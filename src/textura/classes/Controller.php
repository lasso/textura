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

abstract class Controller {

  // Define some properties that the used may read but not change
  private static $RESERVED_INSTANCE_VARS = array('application', 'request', 'response');

  // List of user defined properties
  private $instance_vars;

  /**
   * Constructor
   */
  public function __construct() {
    $this->instance_vars = array();
  }

  public static function getDefaultAction() {
    return Router::getDefaultAction(self);
  }

  /**
   * Returns the list of used defined properties
   *
   * @return array
   */
  public function getInstanceVars() {
    return $this->instance_vars;
  }

  /**
   * Magic getter. Can be used to either retrieve either a built-in property or
   * a user-defined property. If $key cannot be found, null is returned.
   *
   * @param string $key
   * @return mixed
   */
  public function __get($key) {
    switch ($key) {
      case 'application': return Current::application();
      case 'request' : return Current::request();
      case 'response' : return Current::response();
      default:
        if (array_key_exists($key, $this->instance_vars)) return $this->instance_vars[$key];
        return null;
    }
  }

  /**
   * Magic setter. This method allows the user to set his/her own properties. The properties
   * can be named anything as long as the name can be represented a normal PHP variable.
   *
   * @param string $key
   * @param mixed $value
   * @throws LogicException     If the user tries to set a reserved property
   */
  public function __set($key, $value) {
    if (in_array($key, self::$RESERVED_INSTANCE_VARS)) {
      throw new LogicException("Cannot set reserved property $key");
    }
    $this->instance_vars[$key] = $value;
  }

  public function __toString() {
    return get_class($this);
  }

}

?>