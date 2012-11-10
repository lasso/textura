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

class Session {

  private static $RESERVED_INSTANCE_VARS = array('session_id', 'session_name');

  private $instance_vars;

  // Private constructor. Use Session::init instead.
  private function __construct() {
    $this->instance_vars = array();
  }

  public static function init() {
    return new self();
  }

  public function getInstanceVars() {
    return $this->instance_vars;
  }

  public function __get($key) {
    if (in_array($key, self::$RESERVED_INSTANCE_VARS)) return $key();
    return array_key_exists($key, $this->instance_vars) ? $this->instance_vars[$key] : null;
  }

  public function __set($key, $value) {
    if (in_array($key, self::$RESERVED_INSTANCE_VARS)) {
      throw new \LogicException("Cannot set reserved property $key");
    }
    $this->instance_vars[$key] = $value;
  }

}
?>