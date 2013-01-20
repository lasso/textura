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
 * Class for building forms dynamically.
 */
class FormBuilder {

  /**
   * @var string id to use for the <FORM>-element
   */
  private $form_id;

  /**
   * @var string action (url) where form data should be sent
   */
  private $action;

  /**
   * @var integer method to use when sending form data
   */
  private $method;

  /**
   * @var string encoding to use when sending form data
   */
  private $enctype;

  /**
   * @var array form elements used by the current FormBuilder object
   */
  private $elems;

  /**
   * @var array keeps track of how many of each element type that the current FormBuilder
   *   object uses
   */
  private $elem_counts;

  /**
   * @var Textura\Validator Validator object used for form validation
   */
  private $validator;

  /**
   * @var boolean keeps track of whether the current FormBuilder object uses client side validation
   *   or not
   */
  private $use_client_side_validation;

  /**
   * Constructor
   *
   * @param string $form_id id used by <FORM> tag
   * @param string $action action (URL) where to send form data
   * @param string $method method to use when sending form data (GET or POST)
   * @param string $enctype encoding to use when sending form data
   */
  public function __construct($form_id, $action = null, $method = null, $enctype = null) {
    require_once(PathBuilder::buildPath(TEXTURA_SRC_DIR, 'htmlbuilder', 'lib', 'Autoloader.php'));
    \HtmlBuilder\Autoloader::register(
      PathBuilder::ensureTrailingSlash(
        PathBuilder::buildPath(TEXTURA_SRC_DIR, 'htmlbuilder', 'lib')
      )
    );
    $this->form_id = $form_id;
    $this->setAction($action);
    $this->setMethod($method);
    $this->setEncType($enctype);
    $this->elems = array();
    $this->elem_counts = array(
      'button'          =>  0,
      'checkbox'        =>  0,
      'custom_content'  =>  0,
      'file'            =>  0,
      'hidden'          =>  0,
      'password'        =>  0,
      'radio'           =>  0,
      'select'          =>  0,
      'submit'          =>  0,
      'text'            =>  0,
      'textarea'        =>  0,
    );
    $this->validator = new Validator();
    $this->use_client_side_validation = false;
  }

  /**
   * Adds a button to the current FormBuilder object.
   *
   * @param array $params
   */
  public function addButton(array $params = array()) {
    $this->addElem('button', $params);
  }

  /**
   * Adds a checkbox to the current FormBuilder object.
   *
   * @param array $params
   */
  public function addCheckbox(array $params = array()) {
    if (!array_key_exists('name', $params)) $params['name'] = $this->getUniqueId('checkbox');
    if (!array_key_exists('label', $params)) $params['label'] = null;
    if (!array_key_exists('value', $params)) $params['value'] = 1;
    if (!array_key_exists('checked', $params)) $params['checked'] = false;
    if (!array_key_exists('id', $params)) $params['id'] = $params['name'];
    $this->addElem('checkbox', $params);
  }

  /**
   * Adds custom content to the current FormBuilder object.
   *
   * @param array $params
   */
  public function addCustomContent(array $params = array()) {
    if (!array_key_exists('id', $params)) $params['id'] = $this->getUniqueId('custom_content');
    $this->addElem('custom_content', $params);
  }

  /**
   * Adds a file upload control to the current FormBuilder object.
   * @param array $params
   * @throws \LogicException
   * @ignore
   */
  public function addFile(array $params = array()) {
    throw new \LogicException("Not yet implemented");
  }

  /**
   * Adds a hidden field to the current FormBuilder object.
   *
   * @param array $params
   */
  public function addHidden(array $params = array()) {
    if (!array_key_exists('name', $params)) $params['name'] = $this->getUniqueId('hidden');
    if (!array_key_exists('label', $params)) $params['label'] = null;
    if (!array_key_exists('id', $params)) $params['id'] = $params['name'];
    if (!array_key_exists('value', $params)) $params['value'] = '';
    $this->addElem('hidden', $params);
  }

  /**
   * Adds a password field to the current FormBuilder object.
   *
   * @param array $params
   */
  public function addPassword(array $params = array()) {
    if (!array_key_exists('name', $params)) $params['name'] = $this->getUniqueId('text');
    if (!array_key_exists('label', $params)) $params['label'] = null;
    if (!array_key_exists('id', $params)) $params['id'] = $params['name'];
    if (!array_key_exists('value', $params)) $params['value'] = '';
    $this->addElem('password', $params);
  }

  /**
   * Adds a radio button to the current FormBuilder object.
   *
   * @param array $params
   */
  public function addRadio(array $params = array()) {
    $this->addElem('radio', $params);
  }

  /**
   * Adds a select box to the current FormBuilder object.
   *
   * @param array $params
   */
  public function addSelect(array $params = array()) {
    if (!array_key_exists('name', $params)) $params['name'] = $this->getUniqueId('select');
    if (!array_key_exists('label', $params)) $params['label'] = null;
    if (!array_key_exists('id', $params)) $params['id'] = $params['name'];
    if (!array_key_exists('options', $params)) $params['options'] = array();
    if (!array_key_exists('multiple', $params)) $params['multiple'] = false;
    if (!array_key_exists('size', $params)) $params['size'] = null;
    $this->addElem('select', $params);
  }

  /**
   * Adds a submit button to the current FormBuilder object.
   *
   * @param array $params
   */
  public function addSubmit(array $params = array()) {
    if (!array_key_exists('name', $params)) $params['name'] = $this->getUniqueId('submit');
    if (!array_key_exists('label', $params)) $params['label'] = null;
    if (!array_key_exists('id', $params)) $params['id'] = $params['name'];
    if (!array_key_exists('value', $params)) $params['value'] = '';
    $this->addElem('submit', $params);
  }

  /**
   * Adds a text field to the current FormBuilder object.
   *
   * @param array $params
   */
  public function addText(array $params = array()) {
    if (!array_key_exists('name', $params)) $params['name'] = $this->getUniqueId('text');
    if (!array_key_exists('label', $params)) $params['label'] = null;
    if (!array_key_exists('id', $params)) $params['id'] = $params['name'];
    if (!array_key_exists('value', $params)) $params['value'] = '';
    $this->addElem('text', $params);
  }

  /**
   * Adds a text area to the current FormBuilder object.
   *
   * @param array $params
   */
  public function addTextarea(array $params = array()) {
    if (!array_key_exists('name', $params)) $params['name'] = $this->getUniqueId('textarea');
    if (!array_key_exists('label', $params)) $params['label'] = null;
    if (!array_key_exists('id', $params)) $params['id'] = $params['name'];
    if (!array_key_exists('value', $params)) $params['value'] = '';
    $this->addElem('textarea', $params);
  }

  /**
   * Adds validation to a field in the current FormBuilder object.
   *
   * @param string $key
   * @param string $type
   * @param array $params
   */
  public function addValidation($key, $type, $params = array()) {
    $this->validator->addValidation($key, $type, $params);
  }

  /**
   * Returns an array of validation errors (if any) in the current FormBuilder object. This method
   * should only be called after validate() has been called on the current FormBuilder object.
   *
   * @return array
   */
  public function getValidationErrors() {
    return $this->validator->getValidationErrors();
  }

  /**
   * Returns whether the current FormBuilder object uses client side validation or not.
   *
   * @return boolean true if the current FormBuilder object uses client side validation,
   *   false otherwise
   */
  public function getUseClientSideValidation() {
    return $this->use_client_side_validation;
  }

  /**
   * Sets the action (URL) to where the form belonging to the current FormBuilder object
   *   should be sent.
   *
   * @param string $action
   */
  public function setAction($action) {
    $this->action = $action;
  }

  /**
   * Sets the method to use when sending form data. Should be set to either GET or POST.
   *
   * @param string $method
   */
  public function setMethod($method) {
    if (strtolower($method) === 'get') {
      $this->method = \HTMLBuilder\Elements\Form\Form::METHOD_GET;
    }
    else {
      $this->method = \HTMLBuilder\Elements\Form\Form::METHOD_POST;
    }
  }

  /**
   * Sets the encoding type for the form belong to the current FormBuilder object.
   *
   * @param string $enctype
   */
  public function setEncType($enctype) {
    $this->enctype = $enctype;
  }

  /**
   * Sets whether the current FormBuilder object should use client side validation or not.
   *
   * @param boolena $bool true to use client side validation, false to not use
   *   client side validation.
   */
  public function setUseClientSideValidation($bool) {
    $this->use_client_side_validation = (bool) $bool;
  }

  /**
   * Renders the form, including javscript methods for validation
   *
   * @return type
   * @throws \LogicException
   */
  public function render() {
    if (!$this->action) throw new \LogicException('Form must have a valid action.');
    $fieldset = new \HTMLBuilder\Elements\General\Fieldset();
    $fieldset->setId($this->form_id . '_fieldset');
    foreach ($this->elems as $current_elem) {
      $type = $current_elem[0];
      $params = $current_elem[1];
      if ($type != 'custom_content') {
        $div = new \HTMLBuilder\Elements\General\Div();
        $div->setClass('form_elem');
        $label = new \HTMLBuilder\Elements\Form\Label();
        $label->setFor($params['id']);
        $label->setInnerHTML($params['label']);
        $label->setClass("form_elem_label form_elem_label_$type");
        $div->insertChild($label);
      }
      switch ($type) {
        case 'custom_content':
          $div = new \HTMLBuilder\Elements\General\Div();
          $div->setId($params['id']);
          if (array_key_exists('content', $params)) {
            $div->setInnerHTML($params['content']);
          }
          if (array_key_exists('class', $params)) {
            $div->setClass($params['class']);
          }
          break;
        case 'button':
        case 'reset':
        case 'submit':
          $field = new \HTMLBuilder\Elements\Form\Button();
          $field->setId($params['id']);
          $field->setInnerHTML($params['value']);
          $field->setName($params['name']);
          $field->setType($type);
          break;
        case 'hidden':
        case 'password':
        case 'text':
          $field = new \HTMLBuilder\Elements\Form\Input();
          $field->setId($params['id']);
          $field->setName($params['name']);
          $field->setType($type);
          $field->setValue($params['value']);
          break;
        case 'select': {
          $field = new \HTMLBuilder\Elements\Form\Select();
          $field->setId($params['id']);
          $field->setName($params['name']);
          $field->setMultiple($params['multiple']);
          if ($params['size']) $field->setSize($params['size']);
          foreach ($params['options'] as $current_option) {
            $option_elem = new \HTMLBuilder\Elements\Form\Option();
            if (isset($current_option['selected'])) {
              $option_elem->setSelected($current_option['selected']);
            }
            if (isset($current_option['value'])) {
              $option_elem->setValue($current_option['value']);
            }
            if (isset($current_option['text'])) {
              $option_elem->setInnerHTML($current_option['text']);
            }
            $field->insertChild($option_elem);
          }
          break;
        }
        case 'textarea':
          $field = new \HTMLBuilder\Elements\Form\Textarea();
          $field->setId($params['id']);
          $field->setName($params['name']);
          $field->setInnerHTML($params['value']);
          break;
      }
      if ($type != 'custom_content') {
        $field->setClass("form_elem_field form_elem_field_$type");
        $div->insertChild($field);
      }
      $fieldset->InsertChild($div);
    }

    $form = new \HTMLBuilder\Elements\Form\Form();
    $form->setId($this->form_id);
    $form->setAction($this->action);
    $form->setMethod($this->method);
    $form->insertChild($fieldset);

    $output = $form->build();
    $script_jquery = new \HTMLBuilder\Elements\Page\Script();
    $script_jquery->setSrc('https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
    $script_jquery->setType('text/javascript');
    $output .= "\n" . $script_jquery->build();
    $script_elem = new \HTMLBuilder\Elements\Page\Script();
    $script_elem->setType('text/javascript');
    $script_elem_contents = array();
    $script_elem_contents[] = "$('#" . $this->form_id . "').bind('submit', function() {";
    if ($this->getUseClientSideValidation() && $this->validator->hasValidations()) {
      $script_elem_contents[] = $this->validator->render($this->form_id);
    }
    // Since HTMLBuilder has insane settings that keeps us from creating a select box having a
    // name containing [] we must use jQuery to transform the post into what we want.
    $script_elem_contents[] = "$('#{$this->form_id} select[multiple=\"multiple\"]')." .
                              "each(function(idx, elem) {";
    $script_elem_contents[] = '  $elem = $(elem);';
    $script_elem_contents[] = '  $options = $(elem).find(\'option:selected\');';
    $script_elem_contents[] = '  if ($options.length > 0) {';
    $script_elem_contents[] = '    new_elem_name = $elem.attr("id") + "[];"';
    $script_elem_contents[] = '    $options.each(function(idx2, elem2) {';
    $script_elem_contents[] = "      $('#{$this->form_id}').append('<input name=\"' + " .
                              "new_elem_name + '\" value=\"' + elem2.value + '\">');";
    $script_elem_contents[] = "    })";
    $script_elem_contents[] = '    $elem.attr(\'disabled\', \'disabled\');';
    $script_elem_contents[] = '  }';
    $script_elem_contents[] = "})";
    $script_elem_contents[] = "})";
    $script_elem->setInnerHTML(implode("\n", $script_elem_contents));
    $output .= "\n" . $script_elem->build() . "\n";
    return $output;
  }

  /**
   * Updates an attribute for an element in the current element list. This is useful when something
   * needs to be changed after the original structure has been created.
   *
   * @param string $elem_id The id of the element to change
   * @param string $attribute The name of the attribute to change
   * @param string $value The new value of the attribute
   * @return boolean True if the update succeeded, false otherwise
   */
  public function updateAttribute($elem_id, $attribute, $value) {
    for ($i = 0; $i < count($this->elems); $i++) {
      $params = $this->elems[$i][1];
      if ($params['id'] == $elem_id) {
        // Found the element. Lets update the attribute
        $this->elems[$i][1][strval($attribute)] = $value;
        return true;
      }
    }
    // Did not find the element
    return false;
  }

  /**
   * Validates the data sent using the current FormBuilder object.
   *
   * @param array $values the values to validate
   * @return boolean true if validation succeeds, false otherwise
   */
  public function validate(array $values) {
    return $this->validator->validate($values);
  }

  /**
   * Adds an element to the current FormBuilder object.
   *
   * @param string $type
   * @param array $params
   */
  private function addElem($type, $params) {
    // Increment counter that keeps track of how many elements of each type that exist.
    $this->elem_counts[$type]++;

    // Check for validations
    if (array_key_exists('validations', $params)) {
      $this->elem_validations[$params['id']] = $params['validations'];
      unset($params['validations']);
    }

    // Add element to element array
    $this->elems[] = array($type, $params);
  }

  /**
   * Tries to fetch data for a field by inspecting the POST data sent with the current request.
   * If data for the requested field is available in the POST data, that data will be returned. If
   * the data is not avaialable, null will be returned instead.
   *
   * @param string $field
   * @return mixed.
   */
  public function getValueFromPost($field) {
    if (Current::request()->isPost() && array_key_exists($field, Current::request()->post_params)) {
      return Current::request()->post_params[$field];
    }
    else {
      return null;
    }
  }

  /**
   * Returns an unique name for a specific element type.
   *
   * @param string $type
   * @return string
   */
  private function getUniqueId($type) {
    return $type . '_' . ($this->elem_counts[$type] + 1);
  }
}
?>