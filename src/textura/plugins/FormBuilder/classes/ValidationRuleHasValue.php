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
 * Validation rule for ensuring that a field has a value.
 */
class ValidationRuleHasValue extends ValidationRule {

  /**
   * @var string message to use when validation fails
   */
  private $message;

  /**
   * Constructor
   *
   * @param type $message
   */
  public function __construct($message = null) {
    $this->message = $message;
  }

  /**
   * Returns the message associated with the current validation rule.
   *
   * @return string
   */
  public function getMessage() {
    return strval($this->message);
  }

  /**
   * Renders the current validation rule (for client side validation only)
   *
   * @return string
   */
  public function render() {
    $validate = "function(v) { return v.length > 0; }";
    $message = json_encode($this->message);
    return "{\n" .
           "'validate' : $validate,\n" .
           "'message'  : $message\n" .
           "}";
  }

  /**
   * Validates a value against the current validation rule.
   *
   * @param mixed $value
   * @return boolen true if validation succeeds, false otherwise
   */
  public function validate($value) {
    return !!$value;
  }

}