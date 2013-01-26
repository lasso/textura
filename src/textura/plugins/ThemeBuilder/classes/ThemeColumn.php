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
 * Class implementing a column in a theme
 */
class ThemeColumn  extends ThemeElement {

  /**
   * @var string unique id used for this column
   */
  private $id;

  /**
   * @var integer number of "columns units" this column spans
   */
  private $width;

  /**
   * Constructor
   *
   * @param string $id unique id
   * @param integer $width number of "column units" to span
   */
  public function __construct($id, $width) {
    $this->id = $id;
    $this->width = $width;
  }

  /**
   * Returns a hash for the current column.
   *
   * @return string
   */
  public function getHash() {
    return sha1('id' . $this->id . 'width' . $this->width);
  }

  /**
   * Returns the id of the current column.
   *
   * @return string
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Returns the number of "column units" the current column spans.
   *
   * @return integer
   */
  public function getWidth() {
    return $this->width;
  }

}
?>