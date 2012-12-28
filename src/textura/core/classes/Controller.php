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

namespace Textura;

/**
 * This class works as the base class for all controllers in Textura.
 */
abstract class Controller {

  /**
   * @var array list of roperties that the user may read but not change
   */
  private static $RESERVED_INSTANCE_VARS =
    array('action', 'application', 'controller', 'request', 'response', 'session');

  /**
   * @var boolean true to use sessions, false to disable sessions (for the current controller)
   */
  protected static $use_session = false;

  /**
   * @var string scope for session. Can be set to either 'global', 'application' or 'controller'
   */
  protected static $session_scope = 'application';

  /**
   * @var array list of user defined properties
   */
  private $instance_vars;

  /**
   * Constructor
   */
  public function __construct() {
    $this->instance_vars = array();
  }

  /**
   * Clears all instance variables.
   */
  public function clearInstanceVars() {
    $this->instance_vars = array();
  }

  /**
   * Returns the "default action" for the current controller object.
   *
   * @return string
   */
  public static function getDefaultAction() {
    return Router::getDefaultAction(self);
  }

  /**
   * Returns the list of used defined properties
   *
   * @return array
   */
  public function getInstanceVars() {
    $reserved_instance_vars = array();
    foreach (self::$RESERVED_INSTANCE_VARS as $current_reserved_instance_var) {
      // Only expose session if controller uses sessions
      if ($current_reserved_instance_var == 'session') {
        if ($this->useSession()) {
          $reserved_instance_vars[$current_reserved_instance_var] =
            Current::$current_reserved_instance_var();
        }
      }
      else {
        $reserved_instance_vars[$current_reserved_instance_var] =
          Current::$current_reserved_instance_var();
      }
    }
    return array_merge($reserved_instance_vars, $this->instance_vars);
  }

  /**
   * Returns the session "scope". The session scope can be one of three predefined values:
   * 'global'       When using this value, the session cookie associated with the request will have
   *                the path '/'.
   * 'application'  When using this value, the session cookie associated with the request will have
   *                the path returned by PathBuilder::getTexturaBaseURL().
   * 'controller'  When using this value, the session cookie associated with the request will have
   *                the path returned by PathBuilder::buildRoute($current_controller_class).
   *
   * @return string
   * @throws \LogicException If sessions are not used for the current controller
   */
  public function getSessionScope() {
    if (!static::useSession()) {
      throw new \LogicException("Session not initialized");
    }
    return static::$session_scope;
  }

  /**
   * Returns a route to an action in another controller
   *
   * @return string
   * @throws \LogicException
   */
  public function r() {
    $num_args = func_num_args();
    if ($num_args < 2) {
      throw new \LogicException("Not enough parameters");
    }
    $args = func_get_args();
    $controller_class = $args[0] instanceof Controller ? get_class($args[0]) : $args[0];
    if ($num_args > 2) {
      if ($num_args == 3 && is_array($args[2])) {
        // Action with parameters, parameters as array
        return PathBuilder::buildRoute($controller_class, $args[1], $args[2]);
      }
      else {
        // Action with parameters, paramaters as separate arguments
        $params = array();
        for ($i = 2; $i < $num_args; $i++) $params[] = $args[$i];
        return PathBuilder::buildRoute($controller_class, $args[1], $params);
      }
    }
    else {
      // Action without parameters
      return PathBuilder::buildRoute($controller_class, $args[1]);
    }
  }

  /**
   * Returns a route to an action within the current controller
   *
   * @return string
   * @throws \LogicException
   */
  public function rs() {
    $num_args = func_num_args();
    if ($num_args < 1) {
      throw new \LogicException("Not enough parameters");
    }
    $args = func_get_args();
    if ($num_args > 1) {
      if ($num_args == 2 && is_array($args[1])) {
        // Action with parameters, parameters as array
        return PathBuilder::buildRoute(get_class($this), $args[0], $args[1]);
      }
      else {
        // Action with parameters, paramaters as separate arguments
        $params = array();
        for ($i = 1; $i < $num_args; $i++) $params[] = $args[$i];
        return PathBuilder::buildRoute(get_class($this), $args[0], $params);
      }
    }
    else {
      // Action without parameters
      return PathBuilder::buildRoute(get_class($this), $args[0]);
    }
  }

  /**
   * Returns a route to some static content.
   *
   * @return string
   * @throws \LogicException
   */
  public function rst() {
    $num_args = func_num_args();
    if ($num_args < 1) {
      throw new \LogicException("Not enough parameters");
    }
    $args = func_get_args();
    return PathBuilder::BuildStaticRoute($args);
  }

  /**
   * Returns whether the current controller class uses a session or not.
   *
   * @return boolean
   */
  public function useSession() {
    return static::$use_session;
  }

  /**
   * Magic getter. Can be used to either retrieve either a built-in property or
   * a user-defined property. If $key cannot be found, null is returned.
   *
   * @param string $key
   * @return mixed
   */
  public function __get($key) {
    if (in_array($key, self::$RESERVED_INSTANCE_VARS)) return Current::$key();
    return array_key_exists($key, $this->instance_vars) ? $this->instance_vars[$key] : null;
  }

  /**
   * Magic setter. This method allows the user to set his/her own properties. The properties
   * can be named anything as long as the name can be represented a normal PHP variable.
   *
   * @param string $key
   * @param mixed $value
   * @throws \LogicException     If the user tries to set a reserved property
   */
  public function __set($key, $value) {
    if (in_array($key, self::$RESERVED_INSTANCE_VARS)) {
      throw new \LogicException("Cannot set reserved property $key");
    }
    $this->instance_vars[$key] = $value;
  }

  /**
   * Returns a string representation of the current object.
   *
   * @return string
   */
  public function __toString() {
    return get_class($this);
  }

}

?>