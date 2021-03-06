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
 * This class works as a container for the few globals pieces of data that are needed in Textura
 */
class Current {

  /**
   * @var string current action
   */
  private static $action = null;

  /**
   * @var Textura\Textura current application
   */
  private static $application = null;

  /**
   * @var Textura\Controller current controller
   */
  private static $controller = null;

  /**
   * @var Textura\Request current request
   */
  private static $request = null;

  /**
   * @var Textura\Response current response
   */
  private static $response = null;

  /**
   * @var Textura\Session current session
   */
  private static $session = null;

  /**
   * Initializes the Textura\Current object. The Textura\Current object is a convenient way to
   * reach any part of Textura from anywhere. It has methods for getting the current application,
   * the current controller, the current request, the current response and the current session.
   *
   * @param \Textura\Textura $application
   * @param \Textura\Request $request
   * @param \Textura\Response $response
   * @throws \LogicException if already initialized. This should *never* happen.
   */
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
   * Returns whetehr we have a controller ready or not.
   *
   * @return boolean
   */
  public static function haveController() {
    return !is_null(self::$controller);
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

  /**
   * Returns the current session
   *
   * @return Textura\Session
   * @throws \LogicException if sessions are disabled by the controller.
   */
  public static function session() {
    if (is_null(self::$session)) {
      throw new \LogicException('Session not initialized.');
    }
    return self::$session;
  }

  /**
   * Sets the active controller and action. This method will also check if the controller needs a
   * session and initialize one if needed.
   *
   * @param \Textura\Controller $controller
   * @param type $action
   */
  public static function setActiveControllerAndAction(Controller $controller, $action) {
    self::$controller = $controller;
    self::$action = $action;

    // Check if the controller uses sessions. If it does, initialize a session
    if ($controller->useSession()) self::initSession();

    // Now that session has been initialized it is finally safe to clear all globals
    self::clearGlobals();
  }

  /**
   * Constructor
   */
  private function __construct() {}

  /**
   * Clears all globals since they are *EVIL*.
   */
  private function clearGlobals() {
    unset($_COOKIE);
    unset($_FILES);
    unset($_GET);
    unset($_POST);
    unset($_REQUEST);
    unset($_SERVER);
    unset($_SESSION);
  }

  /**
   * Initializes a new śession.
   */
  private function initSession() {
    self::$session = Session::init(); // Initialize session object
  }

}

?>