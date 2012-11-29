<?php
/**
 * Form renderer can be used to render a form
 * 
 * PHP version 5
 * 
 * @filesource
 * @category  RenderHelper
 * @package   RenderHelper
 * @author    Jens Peters <jens@history-archive.net>
 * @copyright 2011 Jens Peters
 * @license   http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @version   1.0
 * @link      http://launchpad.net/htmlbuilder
 */
namespace HTMLBuilder\RenderHelper\Form;
use HTMLBuilder\Elements\Form\Optgroup;
use HTMLBuilder\Elements\Form\Option;
use HTMLBuilder\Elements\Form\RootForm;
use HTMLBuilder\RenderHelper\RenderBase;
use HTMLBuilder\Elements\Form as FormElements;
use HTMLBuilder\Elements\Lists\Ul;
use HTMLBuilder\Elements\Lists\Li;
use HTMLBuilder\HelperFunctions;

/**
 * Form renderer can be used to render a form
 *
 * @category   RenderHelper
 * @package    RenderHelper
 * @subpackage Form
 * @author     Jens Peters <jens@history-archiv.net>
 * @license    http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @link       http://launchpad.net/htmlbuilder
 */
class Form extends RenderBase {

    /**
     * Form element
     * @var Form
     */
    protected $form;
    
    /**
     * For setting additional values / attributes
     * @var RootForm
     */
    protected $lastElement;

    /**
     * Constructor
     * 
     * @param $action
     * @param $method
     * @param $cssClass
     */
    public function __construct($action, $method = FormElements\Form::METHOD_POST, $cssClass = "") {

        $this->form = new FormElements\Form();
        $this->form->setAction($action)->setMethod($method);
        
        if($cssClass != "") {
            $this->form->setClass($cssClass);
        }
    }

    /**
     * Add text input element
     * 
     * @param string $label        Element label
     * @param string $name         Element name
     * @param string $id           (optional) Element id
     * @param string $defaultValue (optional) Elements default value
     * 
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function addInputText($label, $name, $id = "", $defaultValue = "") {

        $this->_addInput($label, $name, $id, FormElements\Input::TYPE_TEXT, $defaultValue);
        return $this;
    }

    /**
     * Add radio input element
     * 
     * @param string $label   Element label
     * @param string $name    Element name
     * @param string $value   Elements default value
     * @param string $checked (optional) Element checked
     * @param string $id      (optional) Element id
     * 
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function addInputRadio($label, $name, $value, $checked = false, $id = "") {

        $this->_addInputEnum($label, $name, FormElements\Input::TYPE_RADIO, $value, $checked, $id);
        return $this;
    }

    /**
     * Add checkbox input element
     * 
     * @param string $label     Element label
     * @param string $name      Element name
     * @param string $value     Elements default value
     * @param string $checked   (optional) Element checked
     * @param string $id        (optional) Element id
     * 
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function addInputCheckbox($label, $name, $value, $checked = false, $id = "") {

        $this->_addInputEnum($label, $name, FormElements\Input::TYPE_CHECKBOX, $value, $checked, $id);
        return $this;
    }

    /**
     * Add password input element
     * 
     * @param string $label        Element label
     * @param string $name         Element name
     * @param string $id           (optional) Element id
     * @param string $defaultValue (optional) Elements default value
     * 
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function addInputPassword($label, $name, $id = "", $defaultValue = "") {

        $this->_addInput($label, $name, $id, FormElements\Input::TYPE_PASSWORD, $defaultValue);
        return $this;
    }

    /**
     * Add image input element
     * 
     * @param string $label        Element label
     * @param string $name         Element name
     * @param string $id           (optional) Element id
     * @param string $defaultValue (optional) Elements default value
     * 
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function addInputImage($label, $name, $id = "", $defaultValue = "") {

        $this->_addInput($label, $name, $id, FormElements\Input::TYPE_IMAGE, $defaultValue);
        return $this;
    }

    /**
     * Add reset input element
     * 
     * @param string $label        Element label
     * @param string $name         Element name
     * @param string $id           (optional) Element id
     * @param string $defaultValue (optional) Elements default value
     * 
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function addInputReset($label, $name, $id = "", $defaultValue = "") {

        $this->_addInput($label, $name, $id, FormElements\Input::TYPE_RESET, $defaultValue);
        return $this;
    }

    /**
     * Add hidden input element
     * 
     * @param string $label        Element label
     * @param string $name         Element name
     * @param string $id           (optional) Element id
     * @param string $defaultValue (optional) Elements default value
     * 
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function addInputHidden($label, $name, $id = "", $defaultValue = "") {

        $this->_addInput($label, $name, $id, FormElements\Input::TYPE_HIDDEN, $defaultValue);
        return $this;
    }

    /**
     * Add submit input element
     * 
     * @param string $label        Element label
     * @param string $name         Element name
     * @param string $id           (optional) Element id
     * @param string $defaultValue (optional) Elements default value
     * 
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function addInputSubmit($label, $name, $id = "", $defaultValue = "") {

        $this->_addInput($label, $name, $id, FormElements\Input::TYPE_SUBMIT, $defaultValue);
        return $this;
    }

    /**
     * Add file input element
     * 
     * @param string $label        Element label
     * @param string $name         Element name
     * @param string $id           (optional) Element id
     * @param string $defaultValue (optional) Elements default value
     * 
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function addInputFile($label, $name, $id = "", $defaultValue = "") {

        $this->_addInput($label, $name, $id, FormElements\Input::TYPE_FILE, $defaultValue);
        return $this;
    }

    /**
     * Add button input element
     * 
     * @param string $label        Element label
     * @param string $name         Element name
     * @param string $id           (optional) Element id
     * @param string $defaultValue (optional) Elements default value
     * 
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function addInputButton($label, $name, $id = "", $defaultValue = "") {

        $this->_addInput($label, $name, $id, FormElements\Input::TYPE_BUTTON, $defaultValue);
        return $this;
    }

    /**
     * Adding textarea to list
     * 
     * @param string $label        Element label
     * @param string $name         Element name
     * @param string $id           (optional) Element id
     * @param string $defaultValue (optional) Elements default value
     * 
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function addInputTextarea($label, $name, $id = "", $defaultValue = "") {

        $label = new FormElements\Label($label);
        $label->setFor($id);

        $input = new FormElements\Textarea(null, $id);
        $input->setName($name)->setInnerHTML($defaultValue);

        $this->form->insertChildren($label, $input);
    }

    /**
     * Adding select box to list
     * 
     * @example form.php see HOW TO USE
     * 
     * @param string       $label        Element label
     * @param string       $name         Element name
     * @param string       $options	    Options Elements    
     * @param string|array $defaultValue (optional) Elements default value (if multiple allowed use an array)
     * @param string       $id           (optional) Element id
     * @param boolean      $multiple     (optional) If more than one entry can be selected 
     * @param int|boolean  $multiline    (optional) Number of lines to see
     * 
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function addSelect($label, $name, array $options, $defaultValue = "", $id = "", $multiple = false, $multiline = false) {

        $label = new FormElements\Label($label);
        $label->setFor($id);

        $input = new FormElements\Select(null, $id);
        $input->setName($name)->setMultiple($multiple);

        if ($multiline !== false) {
            $input->setSize($multiline);
        }

        $isAssoc = HelperFunctions::isAssociative($options);
        foreach ($options as $key => $value) {

            switch(true) {

                case is_array($value) :
                    $option = new Optgroup();
                    $option->setLabel($key);

                    foreach ($value as $optKey => $optValue) {

                        $opt = new Option($optKey);
                        $opt->setInnerHTML($optValue)->setSelected($this->_setSelected($defaultValue, $optKey));

                        $option->insertChild($opt);
                    }
                break;
                
                default:
                    $option = new Option($key);
                    $option->setInnerHTML($value)->setSelected($this->_setSelected($defaultValue, $key));
                break;
            }
            
            // for non index based options set value too 
            if($option->getTag() != "optgroup" && $isAssoc === true) {
                $option->setValue($key);    
            }
            
            $input->insertChild($option);
        }
        $this->lastElement = $input;

        $this->form->insertChildren($label, $input);
    }

    /**
     * Check if the option shuold be pre selected
     * 
     * @param string|array $defaultValue
     * @param string       $value
     * 
     * @return boolean 
     */
    private function _setSelected($defaultValue, $value) {

        switch(true) {
            case is_array($defaultValue) :
                return in_array($defaultValue, $value);
            break;

            default:
                return $defaultValue == $value;
            break;
        }
    }

    /**
     * Add button button element
     * 
     * @param string $label        Element label
     * @param string $name         Element name
     * @param string $id           (optional) Element id
     * @param string $defaultValue (optional) Elements default value
     * 
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function addButtonButton($label, $name, $id = "", $defaultValue = "") {

        $this->_addButton($label, $name, $id, FormElements\Button::TYPE_BUTTON, $defaultValue);
        return $this;
    }

    /**
     * Add button reset element
     * 
     * @param string $label        Element label
     * @param string $name         Element name
     * @param string $id           (optional) Element id
     * @param string $defaultValue (optional) Elements default value
     * 
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function addButtonReset($label, $name, $id = "", $defaultValue = "") {

        $this->_addButton($label, $name, $id, FormElements\Button::TYPE_RESET, $defaultValue);
        return $this;
    }

    /**
     * Add button submit element
     * 
     * @param string $label        Element label
     * @param string $name         Element name
     * @param string $id           (optional) Element id
     * @param string $defaultValue (optional) Elements default value
     * 
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function addButtonSubmit($label, $name, $id = "", $defaultValue = "") {

        $this->_addButton($label, $name, $id, FormElements\Button::TYPE_SUBMIT, $defaultValue);
        return $this;
    }

    /**
     * Adding input to list
     * 
     * @param string $label    Element label
     * @param string $name     Element name     
     * @param string $type     Element type
     * @param string $value    Elements value
     * @param string $checked  Elements value
     * @param string $id       Element id
     * 
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    private function _addInputEnum($label, $name, $type, $value, $checked, $id) {

        $label = new FormElements\Label($label);
        $label->setFor($id);

        $input = new FormElements\Input(null, $id);
        $input->setName($name)->setType($type)->setValue($value)->setChecked($checked);
        $this->lastElement = $input;
        
        $this->form->insertChildren($label, $input);
    }

    /**
     * Adding input to list
     * 
     * @param string $label Element label
     * @param string $name  Element name
     * @param string $id    Element id
     * @param string $type  Element type
     * @param string $defaultValue (optional) Elements default value
     * 
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    private function _addInput($label, $name, $id, $type, $defaultValue = "") {

        $input = new FormElements\Input(null, $id);
        $input->setName($name)->setType($type)->setValue($defaultValue);

        $excludes = array (
                        FormElements\Input::TYPE_BUTTON,
                        FormElements\Input::TYPE_SUBMIT,
                        FormElements\Input::TYPE_RESET
        );

        $labelObj = new FormElements\Label();
        if (!in_array($type, $excludes)) {
            $labelObj->setInnerHTML($label);
            $labelObj->setFor($id);
        }        
        $this->lastElement = $input;
        
        $this->form->insertChildren($labelObj, $input);
    }

    /**
     * Adding button to list
     * 
     * @param string $label Element label
     * @param string $name  Element name
     * @param string $id    Element id
     * @param string $type  Element type
     * @param string $defaultValue (optional) Elements default value
     * 
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    private function _addButton($label, $name, $id, $type, $defaultValue = "") {

        $input = new FormElements\Button($label, $id);
        $input->setName($name)->setType($type)->setValue($defaultValue);
        $this->lastElement = $input;
        
        $this->form->insertChildren($input);
    }

    /* (non-PHPdoc)
     * @see HTMLBuilder\RenderHelper.RenderBase::render()
     */
    public function render() {

        return $this->form->build();
    }
    
	/**
     * @return the $form
     */
    public function getForm()
    {
        return $this->form;
    }
	/**
     * @return the $lastElement
     */
    public function getLastElement()
    {

        return $this->lastElement;
    }

    
}