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

/**
 * Textura
 *
 * @package Textura
 */

namespace Textura;

/**
 * Class for handling paths in a uniform way
 */
class PathBuilder {

  /**
   * @var string keeps track of Textura's "base" url
   */
  private static $textura_base_url;

  /**
   * Builds a path in the file system from parameters sent to the method.
   *
   * @return string
   */
  public static function buildPath() {
    $args = func_get_args();
    if (count($args) == 1 && is_array($args[0])) $args = $args[0];
    return implode(DIRECTORY_SEPARATOR, array_map('strval', $args));
  }

  /**
   * Return the route to a particular controller/action/parameter list.
   *
   * @param string $controller_class
   * @param string $action
   * @param array $params
   * @return string
   */
  public static function buildRoute($controller_class, $action = null, array $params = array()) {
    $route = empty($params) ? $params : array_map('trim', $params, array('/'));
    if (!empty($action)) {
      $action = trim($action, '/');
      if (!empty($action)) array_unshift($route, $action);
    }
    $controller_path = trim(Router::getControllerPath($controller_class), '/');
    if (!empty($controller_path)) array_unshift($route, $controller_path);
    array_unshift($route, self::getTexturaBaseURL());
    return implode('/', $route);
  }

  /**
   * Builds a route to static content within the application.
   *
   * @param array $params
   * @return string
   */
  public static function buildStaticRoute($params = array()) {
    $route = empty($params) ? $params : array_map('trim', $params, array('/'));
    array_unshift($route, 's'); // paths under /s gets rewritten to static files directory
    array_unshift($route, self::getTexturaBaseURL());
    return implode('/', $route);
  }

  /**
   * Takes a string and makes sure it ends in a specific char. This is useful when building paths.
   *
   * @param string $string
   * @param string $slash_char
   * @return string
   */
  public static function ensureTrailingSlash($string, $slash_char = '/') {
    return substr($string, strlen($string) -1, 1) == $slash_char ? $string : $string . $slash_char;
  }

  /**
   * Returns Texturas "base" url, ie the root of all requests passed through the framework
   *
   * @return string
   */
  public static function getTexturaBaseURL() {
    if (!isset(self::$textura_base_url)) {
      self::$textura_base_url = dirname(Current::request()->server_params['SCRIPT_NAME']);
    }
    return self::$textura_base_url;
  }

}

?>
