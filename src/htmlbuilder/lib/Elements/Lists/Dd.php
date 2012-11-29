<?php
/**
 * The <dd> tag is used to describe an item in a definition list.
 * 
 * The <dd> tag is used in conjunction with <dl> (defines the definition list) 
 * and <dt> (defines the item in the list). Inside a <dd> tag you can put paragraphs, 
 * line breaks, images, links, lists, etc. {@link http://www.w3schools.com/tags/tag_dd.asp }
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
 * The <dd> tag is used to describe an item in a definition list.
 * 
 * The <dd> tag is used in conjunction with <dl> (defines the definition list) 
 * and <dt> (defines the item in the list). Inside a <dd> tag you can put paragraphs, 
 * line breaks, images, links, lists, etc. {@link http://www.w3schools.com/tags/tag_dd.asp }
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
class Dd extends Root {

    public function initElement() {
    }
}