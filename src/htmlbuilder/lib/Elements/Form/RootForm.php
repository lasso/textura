<?php
/**
 * Common Form Attributes
 * 
 * PHP version 5
 * 
 * @example   simple.php How to use
 * @filesource
 * @category  Elements
 * @package   Elements
 * @author    Jens Peters <jens@history-archive.net>
 * @copyright 2011 Jens Peters
 * @license   http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @version   1.1
 * @link      http://launchpad.net/htmlbuilder
 */
namespace HTMLBuilder\Elements\Form;
use HTMLBuilder\Elements\Root;
use HTMLBuilder\Validator;

/**
 * Common Form Attributes
 * 
 * @category   Elements
 * @example    simple.php see HOW TO USE
 * @example    debug.php see HOW TO DEBUG
 * @package    Elements
 * @subpackage Form
 * @author     Jens Peters <jens@history-archiv.net>
 * @license    http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @link       http://launchpad.net/htmlbuilder
 */
abstract class RootForm extends Root {

    /**
     * Specifies that an input element should be disabled when the page loads
     * @var string
     */
    protected $disabled = "";

    /**
     * The content of a field changes
     * @var string
     */
    protected $onchange = "";

    /**
     * An element loses focus
     * @var string
     */
    protected $onblur = "";

    /**
     * An element gets focus
     * @var string
     */
    protected $onfocus = "";

    /**
     * Script to be run when a form is reset
     * @var string
     */
    protected $onreset = "";

    /**
     * Script to be run when a element is selected
     * @var string
     */
    protected $onselect = "";

    /**
     * Script to be run when a form is submit
     * @var string
     */
    protected $onsubmit = "";

    /**
     * Element name
     * @var string
     */
    protected $name = "";

    /**
     * Element name
     * 
     * @param string $name
     */
    public final function setName($name) {

        if ($this->validateSetter(Validator::FORMNAME, $name)) {
            $this->name = $name;
        }
        return $this;
    }

    /**
     * Element name
     * 
     * @return the $name
     */
    public final function getName() {

        return $this->name;
    }

    /**
     * Specifies that an input element should be disabled when the page loads
     * 
     * @param boolean $disabled
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
     * An element loses focus
     * 
     * @return the $onblur
     */
    public final function getOnblur() {

        return $this->onblur;
    }

    /**
     * The content of a field changes
     * 
     * @param string $onchange
     */
    public final function setOnchange($onchange) {

        $this->onchange = $onchange;
        return $this;
    }

    /**
     * Specifies that an input element should be disabled when the page loads
     * 
     * @return the $disabled
     */
    public final function getDisabled() {

        return $this->disabled;
    }

    /**
     * The content of a field changes
     * 
     * @return the $onchange
     */
    public final function getOnchange() {

        return $this->onchange;
    }

    /**
     * @return the $onfocus
     */
    public final function getOnfocus() {

        return $this->onfocus;
    }

    /**
     * Script to be run when a form is reset
     * 
     * @return the $onreset
     */
    public final function getOnreset() {

        return $this->onreset;
    }

    /**
     * Script to be run when a element is selected
     * 
     * @return the $onselect
     */
    public final function getOnselect() {

        return $this->onselect;
    }

    /**
     * Script to be run when a form is submit
     * 
     * @return the $onsubmit
     */
    public final function getOnsubmit() {

        return $this->onsubmit;
    }

    /**
     * An element loses focus
     * 
     * @param string $onblur
     */
    public final function setOnblur($onblur) {

        $this->onblur = $onblur;
        return $this;
    }

    /**
     * An element gets focus
     * 
     * @param string $onfocus
     */
    public final function setOnfocus($onfocus) {

        $this->onfocus = $onfocus;
        return $this;
    }

    /**
     * Script to be run when a form is reset
     * 
     * @param string $onreset
     */
    public final function setOnreset($onreset) {

        $this->onreset = $onreset;
        return $this;
    }

    /**
     * Script that run if the element is selected
     * 
     * @param boolean $onselect
     */
    public final function setOnselect($onselect) {

        $this->onselect = $onselect;
        return $this;
    }

    /**
     * Script to be run when a form is submit
     * 
     * @param string $onsubmit
     */
    public final function setOnsubmit($onsubmit) {

        $this->onsubmit = $onsubmit;
        return $this;
    }

}