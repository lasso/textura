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

class FormBuilder {

  private $form_id;
  private $action;
  private $method;
  private $enctype;
  private $elems;
  private $elem_counts;
  private $validator;
  private $use_client_side_validation;

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
      'button'    =>  0,
      'checkbox'  =>  0,
      'file'      =>  0,
      'hidden'    =>  0,
      'radio'     =>  0,
      'select'    =>  0,
      'submit'    =>  0,
      'text'      =>  0,
      'textarea'  =>  0,
    );
    $this->validator = new Validator();
    $this->use_client_side_validation = false;
  }

  public function addButton(array $params = array()) {
    $this->addElem('button', $params);
  }

  public function addCheckbox(array $params = array()) {
    if (!array_key_exists('name', $params)) $params['name'] = $this->getUniqueId('checkbox');
    if (!array_key_exists('label', $params)) $params['label'] = null;
    if (!array_key_exists('value', $params)) $params['value'] = 1;
    if (!array_key_exists('checked', $params)) $params['checked'] = false;
    if (!array_key_exists('id', $params)) $params['id'] = $params['name'];
    $this->addElem('checkbox', $params);
  }

  public function addFile(array $params = array()) {
    // Not implemented yet
  }

  public function addHidden(array $params = array()) {
    if (!array_key_exists('name', $params)) $params['name'] = $this->getUniqueId('hidden');
    if (!array_key_exists('label', $params)) $params['label'] = null;
    if (!array_key_exists('id', $params)) $params['id'] = $params['name'];
    if (!array_key_exists('value', $params)) $params['value'] = '';
    $this->addElem('hidden', $params);
  }

  public function addRadio(array $params = array()) {
    $this->addElem('radio', $params);
  }

  public function addSelect(array $params = array()) {
    $this->addElem('select', $params);
  }

  public function addSubmit(array $params = array()) {
    if (!array_key_exists('name', $params)) $params['name'] = $this->getUniqueId('submit');
    if (!array_key_exists('label', $params)) $params['label'] = null;
    if (!array_key_exists('id', $params)) $params['id'] = $params['name'];
    if (!array_key_exists('value', $params)) $params['value'] = '';
    $this->addElem('submit', $params);
  }

  public function addText(array $params = array()) {
    if (!array_key_exists('name', $params)) $params['name'] = $this->getUniqueId('text');
    if (!array_key_exists('label', $params)) $params['label'] = null;
    if (!array_key_exists('id', $params)) $params['id'] = $params['name'];
    if (!array_key_exists('value', $params)) $params['value'] = '';
    $this->addElem('text', $params);
  }

  public function addTextarea(array $params = array()) {
    $this->elems[] = array('textarea', $params);
    $this->addElem('textarea', $params);
  }

  public function addValidation($key, $type, $params = array()) {
    $this->validator->addValidation($key, $type, $params);
  }

  public function getValidationErrors() {
    return $this->validator->getValidationErrors();
  }

  public function getUseClientSideValidation() {
    return $this->use_client_side_validation;
  }

  public function setAction($action) {
    $this->action = $action;
  }

  public function setMethod($method) {
    if (strtolower($method) === 'get') {
      $this->method = \HTMLBuilder\Elements\Form\Form::METHOD_GET;
    }
    else {
      $this->method = \HTMLBuilder\Elements\Form\Form::METHOD_POST;
    }
  }

  public function setEncType($enctype) {
    $this->enctype = $enctype;
  }

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
    $form = new \HTMLBuilder\RenderHelper\Form\Form($this->action, $this->method);
    $form->getForm()->setId($this->form_id);
    foreach ($this->elems as $current_elem) {
      $type = $current_elem[0];
      $params = $current_elem[1];
      switch ($type) {
        case 'button':
          $form->addInputButton(
            $params['label'], $params['name'], $params['id'], $params['value']
          );
          break;
        case 'checkbox':
          $form->addInputCheckbox(
            $params['label'], $params['name'], $params['value'], $params['checked'], $params['id']
          );
          break;
        case 'hidden':
          $form->addInputHidden(
            $params['label'], $params['name'], $params['id'], $params['value']
          );
          break;
        case 'submit':
          $form->addInputSubmit(
            $params['label'], $params['name'], $params['id'], $params['value']
          );
          break;
        case 'text':
          $form->addInputText(
            $params['label'], $params['name'], $params['id'], $params['value']
          );
          break;
        default:
          throw new \LogicException("Unknown element type $type");
      }
    }
    $output = $form->render();
    if ($this->getUseClientSideValidation() && $this->validator->hasValidations()) {
      $output .= "\n" . $this->validator->render($this->form_id);
    }
    return $output;
  }

  public function validate(array $values) {
    return $this->validator->validate($values);
  }

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

  private function getUniqueId($type) {
    return $type . '_' . ($this->elem_counts[$type] + 1);
  }
}
?>