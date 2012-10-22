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

class PathBuilder {

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
  public static function buildRoute($controller_class, $action, array $params = array()) {
    $route = $params;
    array_unshift($route, $action);
    $controller_path = Router::getControllerPath($controller_class);
    if (strlen($controller_path) > 1) $controller_path = ltrim($controller_path, '/');
    array_unshift($route, $controller_path);
    array_unshift(
      $route,
      rtrim(
        substr(
          Current::request()->server_params['PHP_SELF'],
          0,
          strlen(Current::request()->server_params['PHP_SELF']) -
            (strlen(Current::request()->server_params['PATH_INFO']) + strlen('router,php'))
        ),
        '/')
    );
    return implode('/', $route);
  }

}

?>
