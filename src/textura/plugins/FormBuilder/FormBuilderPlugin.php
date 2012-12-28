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
 * Plugin for building forms dynamically.
 */
class FormBuilderPlugin implements Plugin {

  /**
   * @var Textura\FormBuilderPlugin references the one and only instance of this class
   */
  private static $instance = null;

  /**
   * Returns the paths from where the current plugin's classes will be loaded.
   *
   * @return array
   */
  public function getPaths() {
    $wd = realpath(dirname(__FILE__));
    return
      array(
        PathBuilder::buildPath($wd, 'classes')
      );
  }

  /**
   * This method is automatically called by Textura whenever a plugin is registered.
   */
  public function register() {
    // Nothing to see here. Move along!
  }

  /**
   * Returns a single instance of the FormBuilderPlugin class.
   *
   * @return Textura\FormBuilderPlugin
   */
  public static function getInstance() {
    if (self::$instance == null) {
      self::$instance = new self();
    }
    return self::$instance;
  }

}

?>