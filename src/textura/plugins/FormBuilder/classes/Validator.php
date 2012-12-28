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
 * Class for handling form validations
 */
class Validator {

  /**
   * @var array array of current validation errors
   */
  private $errors;

  /**
   * @var array array of current validation rules
   */
  private $validations;

  /**
   * Constructor
   */
  public function __construct() {
    $this->validations = array();
    $this->errors = array();
  }

  /**
   * Adds a validation rule to the current Validator object.
   *
   * @param string $key the field that should be associated with the validation rule
   * @param string $type the type of validation rule
   * @param array $params validation rule parameters
   */
  public function addValidation($key, $type, $params = array()) {
    $message = isset($params['message']) ? $params['message']: null;
    switch ($type) {
      case 'has_value':
        $rule = new ValidationRuleHasValue($message);
        break;
      case 'in_interval':
        $min_value = isset($params['min_value']) ? $params['min_value'] : null;
        $max_value = isset($params['max_value']) ? $params['max_value'] : null;
        $rule = new ValidationRuleInInterval($min_value, $max_value, $message);
        break;
      case 'in_list':
        $valid_options =
          isset($params['valid_options']) && is_array($params['valid_options']) ?
          $params['valid_options'] :
          array();
        $rule = new ValidationRuleInList($valid_options, $message);
        break;
      case 'is_float':
        $rule = new ValidationRuleIsNumber(ValidationRuleIsNumber::FLOAT, $message);
        break;
      case 'is_integer':
        $rule = new ValidationRuleIsNumber(ValidationRuleIsNumber::INTEGER, $message);
      case 'is_number':
        $rule = new ValidationRuleIsNumber(ValidationRuleIsNumber::ANY, $message);
        break;
      case 'matches_regexp':
        $regexp = isset($params['regexp']) ? $params['regexp'] : null;
        $rule = new ValidationRuleMatchesRegexp($regexp, $message);
        break;
    }
    if (!array_key_exists($key, $this->validations)) {
      $this->validations[$key] = array();
    }
    $this->validations[$key][] = $rule;
  }

  /**
   * Returns an array of validation errors (if any). This method should only be called after
   * the validate() method has been called.
   *
   * @return array
   */
  public function getValidationErrors() {
    return $this->errors;
  }

  /**
   * Returns whether the current validator has any validations.
   *
   * @return boolean
   */
  public function hasValidations() {
    return count($this->validations) > 0;
  }

  /**
   * Return a string representing the javascript used to represent the validator. If the validator
   * does not contain  any validations this method will return an emoty string.
   *
   * @param string $form_id The id of the form to bind the validator to.
   * @return string
   */
  public function render($form_id) {
    if (!$this->hasValidations()) return '';
    $validator_name = "validator_$form_id";
    $script_contents = array();
    $script_contents[] = "form_errors_$form_id = [];";
    $script_contents[] = "var $validator_name = new Object();";
    foreach ($this->validations as $key => $validation_array) {
      $script_contents[] = "$validator_name.$key = [];";
      for ($i = 0; $i < count($validation_array); $i++) {
        $script_contents[] = "$validator_name.$key" . "[$i]" . " = " .
          $validation_array[$i]->render();
      }
    }
    $script_contents[] = "for (var key in $validator_name) {";
    $script_contents[] = "  for (var index in $validator_name" . "[key]) {";
    $script_contents[] = "    value = $('#$form_id #' + key).val();";
    $script_contents[] = "    if (!$validator_name" . "[key][index].validate(value)) {";
    $script_contents[] = "      form_errors_" . $form_id . "[form_errors_" . $form_id .
                            ".length] = " . $validator_name . "[key][index].message;";
    $script_contents[] = "    }";
    $script_contents[] = "  }";
    $script_contents[] = "}";
    $script_contents[] = "if (form_errors_$form_id.length > 0) {";
    $script_contents[] = "  alert(form_errors_$form_id.join(\"\\n\"));";
    $script_contents[] = "  return false;";
    $script_contents[] = "}";
    return implode("\n", $script_contents);
  }

  /**
   * Validates an array of values against the set of validation rules associated with the current
   * Validator objet.
   *
   * @param array $values
   * @return boolen true if the validation succeeded, false otherwise.
   */
  public function validate(array $values) {
    $this->errors = array();
    foreach ($this->validations as $key => $validation_array) {
      foreach ($validation_array as $validation_obj) {
        if (!$validation_obj->validate($values[$key])) {
          $this->errors[] = $validation_obj->getMessage();
        }
      }
    }
    return count($this->errors) === 0;
  }

}
?>