<?php
/**
 * The <option> tag defines an option in a select list.
 *
 * The option element goes inside the select element. 
 * {@link http://www.w3schools.com/tags/tag_option.asp }
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
 * @version   1.0
 * @link      http://launchpad.net/htmlbuilder
 */
namespace HTMLBuilder\Elements\Form;
use HTMLBuilder\Validator;
use HTMLBuilder\Elements\Root;

/**
 * The <option> tag defines an option in a select list.
 *
 * The option element goes inside the select element. 
 * {@link http://www.w3schools.com/tags/tag_option.asp }
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

class Option extends Root {

    /**
     * Specifies a shorter label for an option
     * @var string
     */
    protected $label = "";

    /**
     * Specifies that an option should be disabled
     * @var fixed
     */
    protected $disabled = "";

    /**
     * Specifies that an option should be selected by default
     * @var fixed
     */
    protected $selected = "";

    /**
     * Specifies the value to be sent to a server when a form is submitted
     * @var string
     */
    protected $value = "";

    public function initElement() {
    }

    /**
     * (non-PHPdoc)
     * @see HTMLBuilder\Elements.iDisabled::setDisabled()
     */
    public final function setDisabled($disabled) {

        if ($this->validateSetter(Validator::BOOLEAN, $disabled)) {

            if ($disabled) {
                $this->disabled = "disabled";
            } else {
                $this->disabled = "";
            }
        }
        return $this;
    }

    /**
     * Specifies a shorter label for an option
     * 
     * @param string $label
     */
    public final function setLabel($label) {

        $this->label = $label;
        return $this;
    }

    /**
     * Specifies that an option should be selected by default
     * 
     * @param string $selected
     */
    public final function setSelected($selected) {

        if ($this->validateSetter(Validator::BOOLEAN, $selected)) {

            if ($selected) {
                $this->selected = "selected";
            } else {
                $this->selected = "";
            }
        }
        return $this;
    }

    /**
     * Specifies the value to be sent to a server when a form is submitted
     * 
     * @param string $value
     */
    public final function setValue($value) {

        $this->value = $value;
        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see HTMLBuilder\Elements.iDisabled::getDisabled()
     */
    public final function getDisabled() {

        return $this->disabled;
    }

    /**
     * Specifies a shorter label for an option
     * 
     * @return the $label
     */
    public final function getLabel() {

        return $this->label;
    }

    /**
     * Specifies that an option should be selected by default
     * 
     * @return the $onselect
     */
    public final function getSelected() {

        return $this->selected;
    }

    /**
     * Specifies the value to be sent to a server when a form is submitted
     * 
     * @return the $value
     */
    public final function getValue() {

        return $this->value;
    }
}