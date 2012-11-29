<?php
/**
 * The <select> tag is used to create a select list (drop-down list).
 *
 * The <option> tags inside the select element define the available 
 * options in the list. {@link http://www.w3schools.com/tags/tag_select.asp }
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

/**
 * The <select> tag is used to create a select list (drop-down list).
 *
 * The <option> tags inside the select element define the available 
 * options in the list. {@link http://www.w3schools.com/tags/tag_select.asp }
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
use HTMLBuilder\Validator;

/**
 * The <select> tag is used to create a select list (drop-down list).
 * 
 * The <option> tags inside the select element define the available 
 * options in the list. {@link http://www.w3schools.com/tags/tag_select.asp }
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
class Select extends RootForm {

    /**
     * Specifies that multiple options can be selected
     * @var fixed
     */
    protected $multiple = "";

    /**
     * Specifies the number of visible options in a drop-down list
     * @var int
     */
    protected $size = "";

    public function initElement() {

        $this->_isBlock = false;
        $this->_allowedChildren = array (
                                        "option",
                                        "optgroup"
        );
    }

    /**
     * Specifies that multiple options can be selected
     * 
     * @param boolean $multiple
     */
    public final function setMultiple($multiple) {

        if ($this->validateSetter(Validator::BOOLEAN, $multiple)) {

            if ($multiple) {
                $this->multiple = "multiple";
            } else {
                $this->multiple = "";
            }
        }

        return $this;
    }

    /**
     * Specifies the number of visible options in a drop-down list
     * 
     * @param int $size
     */
    public final function setSize($size) {

        $validators = Validator::NUMBER;

        if ($this->validateSetter($validators, $size)) {
            $this->size = $size;
        }
        return $this;
    }

    /**
     * Specifies that multiple options can be selected
     * 
     * @return the $multiple
     */
    public final function getMultiple() {

        return $this->multiple;
    }

    /**
     * Specifies the number of visible options in a drop-down list
     * 
     * @return the $size
     */
    public final function getSize() {

        return $this->size;
    }
}