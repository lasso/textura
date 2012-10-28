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
 * This class works as a container for the few globals pieces of data that are needed in Textura
 */
class Current {

  // Declare static variables
  private static $action = null;
  private static $application = null;
  private static $controller = null;
  private static $request = null;
  private static $response = null;

  public static function init(Textura $application, Request $request, Response $response) {
    // Never allow initialization more than once!
    if (!is_null(self::$application)) throw new \LogicException("Already initialized");
    self::$action = null;
    self::$application = $application;
    self::$controller = null;
    self::$request = $request;
    self::$response = $response;
  }

  /**
   * Returns the current action
   *
   * @return string
   * @throws \LogicException
   */
  public static function action() {
    if (is_null(self::$action)) {
      throw new \LogicException('Action not set');
    }
    return self::$action;
  }

  /**
   * Returns the current application
   *
   * @return Textura
   */
  public static function application() {
    return self::$application;
  }

  /**
   * Returns the current controller.
   *
   * @return Controller
   * @throws \LogicException
   */
  public static function controller() {
    if (is_null(self::$controller)) {
      throw new \LogicException('Controller not set');
    }
    return self::$controller;
  }

  /**
   * Returns the current request
   *
   * @return Request
   */
  public static function request() {
    return self::$request;
  }

  /**
   * Returns the current response
   *
   * @return Response
   */
  public static function response() {
    return self::$response;
  }

  public function setActiveControllerAndAction(Controller $controller, $action) {
    self::$controller = $controller;
    self::$action = $action;
  }

  /**
   * Constructor
   */
  private function __construct() {}
}

?>