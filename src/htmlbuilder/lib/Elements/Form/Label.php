<?php
/**
 * The <label> tag defines a label for an input element. 
 * 
 * The label element does not render as anything special for the user. 
 * However, it provides a usability improvement for mouse users, because 
 * if the user clicks on the text within the label element, it toggles 
 * the control. The for attribute of the <label> tag should be equal 
 * to the id attribute of the related element to bind them together. 
 * {@link http://www.w3schools.com/tags/tag_label.asp }
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
use HTMLBuilder\Elements\Root;
use HTMLBuilder\Validator;
use HTMLBuilder\Elements\Attributes;

/**
 * The <label> tag defines a label for an input element. 
 * 
 * The label element does not render as anything special for the user. 
 * However, it provides a usability improvement for mouse users, because 
 * if the user clicks on the text within the label element, it toggles 
 * the control. The for attribute of the <label> tag should be equal 
 * to the id attribute of the related element to bind them together. 
 * {@link http://www.w3schools.com/tags/tag_label.asp }
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
class Label extends Root {

    /**
     * Id of the element the labels belongs to
     * @var string
     */
    protected $for;

    public function initElement() {

        $this->_isBlock = false;
        $this->_allowedChildren = self::INLINE;
    }

    /**
     * Id of the element the labels belongs to
     * @param string $for
     */
    public final function setFor($for) {

        $validators = Validator::CLEANSTRING;

        if ($this->validateSetter($validators, $for)) {
            $this->for = $for;
        }

        return $this;
    }

    /**
     * Id of the element the labels belongs to
     * @return the $for
     */
    public final function getFor() {

        return $this->for;
    }
}