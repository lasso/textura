<?php
/**
 * The <textarea> tag defines a multi-line text input control. 
 * 
 * A text area can hold an unlimited number of characters, and the text renders 
 * in a fixed-width font (usually Courier). The size of a textarea can be specified 
 * by the cols and rows attributes, or even better; through CSS' height and 
 * width properties. {@link http://www.w3schools.com/tags/tag_textarea.asp }
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

/**
 * The <textarea> tag defines a multi-line text input control. 
 * 
 * A text area can hold an unlimited number of characters, and the text renders 
 * in a fixed-width font (usually Courier). The size of a textarea can be specified 
 * by the cols and rows attributes, or even better; through CSS' height and 
 * width properties. {@link http://www.w3schools.com/tags/tag_textarea.asp }
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
class Textarea extends RootForm {

    /**
     * Specifies the visible width of a text-area
     * @var int
     */
    protected $cols = "";

    /**
     * Script to be run when an element is selected
     * @var string
     */
    protected $onselect = "";

    /**
     * Specifies the visible number of rows in a text-area
     * @var int
     */
    protected $rows = "";

    public function initElement() {

        $this->_isBlock = false;
    }

    /**
     * Specifies the visible width of a text-area
     * 
     * @param int $cols
     */
    public final function setCols($cols) {

        $validators = Validator::NUMBER;

        if ($this->validateSetter($validators, $cols)) {
            $this->cols = $cols;
        }

        return $this;
    }

    /**
     * Specifies the visible number of rows in a text-area
     * 
     * @param int $rows
     */
    public final function setRows($rows) {

        $validators = Validator::NUMBER;

        if ($this->validateSetter($validators, $rows)) {
            $this->rows = $rows;
        }

        return $this;
    }

    /**
     * Specifies the visible width of a text-area
     * 
     * @return the $cols
     */
    public final function getCols() {

        return $this->cols;
    }

    /**
     * Script to be run when an element is selected
     * 
     * @return the $onselect
     */
    public final function getOnselect() {

        return $this->onselect;
    }

    /**
     * Specifies the visible number of rows in a text-area
     * 
     * @return the $rows
     */
    public final function getRows() {

        return $this->rows;
    }

}