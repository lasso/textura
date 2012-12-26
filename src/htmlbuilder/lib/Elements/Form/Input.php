<?php
/**
 * An input field can vary in many ways, depending on the type attribute.
 * 
 * An input field can be a text field, a checkbox, a password field, a 
 * radio button, a button, and more. {@link http://www.w3schools.com/tags/tag_input.asp }
 * 
 * PHP version 5
 * 
 * @example   simple.php How to use
 * @filesource
 * @category  Element
 * @package   Elements
 * @author    Jens Peters <jens@history-archive.net>
 * @copyright 2011 Jens Peters
 * @license   http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @version   1.1
 * @link      http://launchpad.net/htmlbuilder
 */
namespace HTMLBuilder\Elements\Form;
use HTMLBuilder\Validator;

/**
 * An input field can vary in many ways, depending on the type attribute.
 * 
 * An input field can be a text field, a checkbox, a password field, a 
 * radio button, a button, and more. {@link http://www.w3schools.com/tags/tag_input.asp }
 * 
 * @category   Element
 * @example    simple.php see HOW TO USE
 * @example    debug.php see HOW TO DEBUG
 * @package    Elements
 * @subpackage Form
 * @author     Jens Peters <jens@history-archiv.net>
 * @license    http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @link       http://launchpad.net/htmlbuilder
 */
class Input extends RootForm {

    /**
     * Input type: button
     * @var string
     */
    const TYPE_BUTTON = "button";

    /**
     * Input type: checkbox
     * @var string
     */
    const TYPE_CHECKBOX = "checkbox";

    /**
     * Input type: file
     * @var string
     */
    const TYPE_FILE = "file";

    /**
     * Input type: hidden
     * @var string
     */
    const TYPE_HIDDEN = "hidden";

    /**
     * Input type: image
     * @var string
     */
    const TYPE_IMAGE = "image";

    /**
     * Input type: password
     * @var string
     */
    const TYPE_PASSWORD = "password";

    /**
     * Input type: radio
     * @var string
     */
    const TYPE_RADIO = "radio";

    /**
     * Input type: reset
     * @var string
     */
    const TYPE_RESET = "reset";

    /**
     * Input type: submit
     * @var string
     */
    const TYPE_SUBMIT = "submit";

    /**
     * Input type: text
     * @var string
     */
    const TYPE_TEXT = "text";

    /**
     * Specifies the MIME_type of files that can be submitted 
     * through a file upload (only for type="file")
     * @var string 
     */
    protected $accept = "";

    /**
     * Specifies an alternate text for an image input (only for type="image")
     * @var string
     */
    protected $alt = "";

    /**
     * Specifies that an input element should be preselected when the page loads (for type="checkbox" or type="radio")
     * @var string 
     */
    protected $checked = "";

    /**
     * Specifies the maximum length (in characters) of an input field (for type="text" or type="password")
     * @var int 
     */
    protected $maxlength = "";

    /**
     * Specifies that an input field should be read-only (for type="text" or type="password")
     * use readonly="readonly" to be XHTML conform
     * @var string
     */
    protected $readonly = "";

    /**
     * Specifies the width of an input field
     * @var int
     */
    protected $size = "";

    /**
     * Specifies the URL to an image to display as a submit button (only for type="image")
     * @var string
     */
    protected $src = "";

    /**
     * Specifies the type of an input element
     * possible values:
     * <ul>
     * <li>button {@link Input::TYPE_BUTTON}</li>
     * <li>checkbox {@link Input::TYPE_CHECKBOX}</li>
     * <li>file {@link Input::TYPE_FILE}</li>
     * <li>hidden {@link Input::TYPE_HIDDEN}</li>
     * <li>image {@link Input::TYPE_IMAGE}</li>
     * <li>password {@link Input::TYPE_PASSWORD}</li>
     * <li>radio {@link Input::TYPE_RADIO}</li>
     * <li>reset {@link Input::TYPE_RESET}</li>
     * <li>submit {@link Input::TYPE_SUBMIT}</li>
     * <li>text {@link Input::TYPE_TEXT}</li>
     * </ul>	
     * @var string
     */
    protected $type = "";

    /**
     * Specifies the value of an input element
     * 
     * @var string
     */
    protected $value = "";

    /**
     * Script to be run when an element is selected
     * @var string
     */
    protected $onselect = "";

    public function initElement() {

        $this->_isBlock       = false;
        $this->_isSelfclosing = true;
    }

    /**
     * Specifies the types of files that can be submitted through a file upload (only for type="file")
     * 
     * @param string $accept
     */
    public final function setAccept($accept) {

        $this->accept = $accept;

        return $this;
    }

    /**
     * Specifies an alternate text for an image input (only for type="image")
     * 
     * @param string $alt
     */
    public final function setAlt($alt) {

        $this->alt = $alt;
        return $this;
    }

    /**
     * Specifies that an input element should be preselected when the page loads (for type="checkbox" or type="radio")
     * 
     * @param boolean $checked
     */
    public final function setChecked($checked) {

        if ($this->validateSetter(Validator::BOOLEAN, $checked)) {

            if ($checked) {
                $this->checked = "checked";
            } else {
                $this->checked = "";
            }
        }
        return $this;
    }

    /**
     * Specifies the maximum length (in characters) of an input field (for type="text" or type="password")
     * 
     * @param int $maxlength
     */
    public final function setMaxlength($maxlength) {

        $validators = Validator::NUMBER;

        if ($this->validateSetter($validators, $maxlength)) {
            $this->maxlength = $maxlength;
        }

        return $this;
    }

    /**
     * Specifies that an input field should be read-only (for type="text" or type="password")
     * use readonly="readonly" to be XHTML conform
     * 
     * @param boolean $readonly
     */
    public final function setReadonly($readonly) {

        if ($this->validateSetter(Validator::BOOLEAN, $readonly)) {

            if ($readonly) {
                $this->readonly = "readonly";
            } else {
                $this->readonly = "";
            }
        }
        return $this;
    }

    /**
     * Specifies the width of an input field
     * @param int $size
     */
    public final function setSize($size) {

        $this->size = $size;
        return $this;
    }

    /**
     * Specifies the URL to an image to display as a submit button (only for type="image")
     * @param string $src
     */
    public final function setSrc($src) {

        $validators = Validator::URL;
        if ($this->validateSetter($validators, $src)) {
            $this->src = $src;
        }

        return $this;
    }

    /**
     * Specifies the type of an input element
     * possible values:
     * <ul>
     * <li>button {@link Input::TYPE_BUTTON}</li>
     * <li>checkbox {@link Input::TYPE_CHECKBOX}</li>
     * <li>file {@link Input::TYPE_FILE}</li>
     * <li>hidden {@link Input::TYPE_HIDDEN}</li>
     * <li>image {@link Input::TYPE_IMAGE}</li>
     * <li>password {@link Input::TYPE_PASSWORD}</li>
     * <li>radio {@link Input::TYPE_RADIO}</li>
     * <li>reset {@link Input::TYPE_RESET}</li>
     * <li>submit {@link Input::TYPE_SUBMIT}</li>
     * <li>text {@link Input::TYPE_TEXT}</li>
     * </ul>	
     * @param string $type
     */
    public final function setType($type) {

        $inputTypes = $this->_getClassConstants("^TYPE_(.*)$");
        $validators = array (
                            Validator::WHITELIST,
                            $inputTypes
        );

        if ($this->validateSetter($validators, $type)) {
            $this->type = $type;
        }

        return $this;
    }

    /**
     * Specifies the value of an input element
     * 
     * @param string $value
     */
    public final function setValue($value) {

        $validators = "";

        if ($this->validateSetter($validators, $value)) {
            $this->value = $value;
        }

        return $this;
    }

    /**
     * Specifies the types of files that can be submitted through a file upload (only for type="file")
     * 
     * @return the $accept
     */
    public final function getAccept() {

        return $this->accept;
    }

    /**
     * Specifies an alternate text for an image input (only for type="image")
     * 
     * @return the $alt
     */
    public final function getAlt() {

        return $this->alt;
    }

    /**
     * Specifies that an input element should be preselected when the page loads (for type="checkbox" or type="radio")
     * 
     * @return the $checked
     */
    public final function getChecked() {

        return $this->checked;
    }

    /**
     * Specifies the maximum length (in characters) of an input field (for type="text" or type="password")
     * 
     * @return the $maxlength
     */
    public final function getMaxlength() {

        return $this->maxlength;
    }

    /**
     * Specifies that an input field should be read-only (for type="text" or type="password")
     * use readonly="readonly" to be XHTML conform
     * 
     * @return the $readonly
     */
    public final function getReadonly() {

        return $this->readonly;
    }

    /**
     * Specifies the width of an input field
     * 
     * @return the $size
     */
    public final function getSize() {

        return $this->size;
    }

    /**
     * Specifies the URL to an image to display as a submit button (only for type="image")
     * 
     * @return the $src
     */
    public final function getSrc() {

        return $this->src;
    }

    /**
     * Specifies the type of an input element
     * possible values:
     * <ul>
     * <li>button {@link Input::TYPE_BUTTON}</li>
     * <li>checkbox {@link Input::TYPE_CHECKBOX}</li>
     * <li>file {@link Input::TYPE_FILE}</li>
     * <li>hidden {@link Input::TYPE_HIDDEN}</li>
     * <li>image {@link Input::TYPE_IMAGE}</li>
     * <li>password {@link Input::TYPE_PASSWORD}</li>
     * <li>radio {@link Input::TYPE_RADIO}</li>
     * <li>reset {@link Input::TYPE_RESET}</li>
     * <li>submit {@link Input::TYPE_SUBMIT}</li>
     * <li>text {@link Input::TYPE_TEXT}</li>
     * </ul>	
     * 
     * @return the $type
     */
    public final function getType() {

        return $this->type;
    }

    /**
     * Specifies the value of an input element
     * 
     * @return the $value
     */
    public final function getValue() {

        return $this->value;
    }
}