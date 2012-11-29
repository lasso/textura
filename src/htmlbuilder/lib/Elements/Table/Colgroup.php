<?php
/**
 * The <colgroup> tag is used to group columns in a table for formatting.
 * 
 * The <colgroup> tag is useful for applying styles to entire columns, 
 * instead of repeating the styles for each cell, for each row. The 
 * <colgroup> tag can only be used inside a table element. {@link http://www.w3schools.com/tags/tag_colgroup.asp }
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
namespace HTMLBuilder\Elements\Table;
use HTMLBuilder\Validator;
use HTMLBuilder\Elements\Root;

/**
 * The <colgroup> tag is used to group columns in a table for formatting.
 * 
 * The <colgroup> tag is useful for applying styles to entire columns, 
 * instead of repeating the styles for each cell, for each row. The 
 * <colgroup> tag can only be used inside a table element. {@link http://www.w3schools.com/tags/tag_colgroup.asp }
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
class Colgroup extends RootRow {

    protected $span = "";

    public function initElement() {

        $this->_allowedChildren = array (
                                        "col"
        );
    }

    /**
     * @param string $span
     */
    public final function setSpan($span) {

        $validators = Validator::NUMBER;

        if ($this->validateSetter($validators, $span)) {
            $this->span = $span;
        }

        return $this;
    }

    /**
     * @return the $span
     */
    public final function getSpan() {

        return $this->span;
    }

}