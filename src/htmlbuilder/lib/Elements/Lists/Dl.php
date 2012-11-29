<?php
/**
 * The <dl> tag defines a definition list.
 * 
 * The <dl> tag is used in conjunction with <dt> (defines the item in the list) 
 * and <dd> (describes the item in the list). {@link http://www.w3schools.com/tags/tag_dl.asp }
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
namespace HTMLBuilder\Elements\Lists;
use HTMLBuilder\Elements\Root;

/**
 * The <dl> tag defines a definition list.
 * 
 * The <dl> tag is used in conjunction with <dt> (defines the item in the list) 
 * and <dd> (describes the item in the list). {@link http://www.w3schools.com/tags/tag_dl.asp }
 * 
 * @category   Element
 * @example    simple.php see HOW TO USE
 * @example    debug.php see HOW TO DEBUG
 * @package    Elements
 * @subpackage Lists
 * @author     Jens Peters <jens@history-archiv.net>
 * @license    http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @link       http://launchpad.net/htmlbuilder
 */
class Dl extends Root {

    public function initElement() {

        $this->_allowedChildren = array (
                                        "dd",
                                        "dt"
        );
    }
}