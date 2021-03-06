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
 * Interface for classes acting as plugins for Textura
 */
interface Plugin extends Singleton {

  /**
   * Returns the base path of the plugin. The base path should reflect the location of the directory
   * of the plugin file.
   *
   * @return string base path for plugin
   */
  public function getBasePath();

  /**
   * Returns an array of paths where the classes needed by the plugin can be loaded from
   *
   * @return array array of paths from where to load classes.
   */
  public function getPaths();

  /**
   * Called whenever a plugin is registered in Textura. If your plugin needs any type if magic
   * initialization you should place your code in this method.
   */
  public function register();

}
?>