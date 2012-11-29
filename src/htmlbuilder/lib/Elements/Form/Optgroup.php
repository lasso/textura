<?php
/**
 * The <optgroup> tag is used to group together related options in a select list. 
 * 
 * If you have a long list of options, groups of related options are easier 
 * to handle for the user {@link http://www.w3schools.com/tags/tag_optgroup.asp }
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
 * The <optgroup> tag is used to group together related options in a select list. 
 * 
 * If you have a long list of options, groups of related options are easier 
 * to handle for the user {@link http://www.w3schools.com/tags/tag_optgroup.asp }
 * 
 * @category   Element
 * @example    simple.php see HOW TO USE
 * @example    debug.php see HOW TO DEBUG
 * @package    Elements
 * @subpackage General
 * @author     Jens Peters <jens@history-archiv.net>
 * @license    http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @link       http://launchpad.net/htmlbuilder
 */

class Optgroup extends Root {

    /**
     * Specifies a description for a group of options
     * @var string
     */
    protected $label = "";

    /**
     * Specifies that an option group should be disabled
     * @var string
     */
    protected $disabled = "";

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
     * Specifies a description for a group of options
     * 
     * @param string $label
     */
    public final function setLabel($label) {

        $this->label = $label;
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
     * Specifies a description for a group of options
     * 
     * @return the $label
     */
    public final function getLabel() {

        return $this->label;
    }
}