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

class ValidationRuleInInterval extends ValidationRule {

  private $min_value;
  private $max_value;
  private $message;

  public function __construct($min_value = null, $max_value = null, $message = null) {
    $this->min_value = $min_value;
    $this->max_value = $max_value;
    $this->message = $message;
  }

  public function getMessage() {
    return strval($this->message);
  }

  public function render() {
    if (!is_null($this->min_value) && !is_null($this->max_value)) {
      $validate = "function(v) { return v >= {$this->min_value} && v <= {$this->max_value}; }";
    }
    elseif (!is_null($this->min_value)) {
      $validate = "function(v) { return v >= {$this->min_value}; }";
    }
    elseif (!is_null($this->max_value)) {
      $validate = "function(v) { return v <= {$this->max_value}; }";
    }
    else {
      $validate = "function(v) { return true; }";
    }
    $message = json_encode($this->message);
    return "{\n" .
           "'validate' : $validate,\n" .
           "'message'  : $message\n" .
           "}";
  }

  public function validate($value) {
    if (!is_null($this->min_value) && !is_null($this->max_value)) {
      return $value >= $this->min_value && $value <= $this->max_value;
    }
    elseif (!is_null($this->min_value)) {
      return $value >= $this->min_value;
    }
    elseif (!is_null($this->max_value)) {
      return $value <= $this->max_value;
    }
    else {
      return true;
    }
  }

}