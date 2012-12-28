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
 * Abstract class, representing a validation rule
 */
abstract class ValidationRule {

  /**
   * Returns the message associated with the current rule.
   */
  abstract function getMessage();

  /**
   * Renders the current validation rule (only used with client side validation).
   */
  abstract function render();

  /**
   * Validates a value against the current validation rule.
   * @param mixed $value value to validate against the current validation rule
   */
  abstract function validate($value);

}