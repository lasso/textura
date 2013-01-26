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
 * Class acting as a base class for all "theme elements"
 */
class ThemeElement {

  /**
   * @var string contents of this elemnent
   */
  protected $contents;

  /**
   * Returns the contents of the current element.
   *
   * @return string
   */
  public function getContents() {
    if ($this->contents instanceof ThemeElement) {
      return $this->contents->getContents();
    }
    else {
      return $this->contents;
    }
  }

  /**
   * Returns a hash of the current element.
   *
   * @return string
   */
  public function getHash() {
    if ($this->contents instanceof ThemeElement) {
      return $this->contents->getHash();
    }
    else {
      return sha1sum($this->contents);
    }
  }

  /**
   * Sets the contents of the current element.
   *
   * @param ThemeElement|String $theme_element_or_string
   */
  public function setContents($theme_element_or_string) {
    $this->contents = $theme_element_or_string;
  }

}
?>