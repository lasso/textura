<?php
/**
 * The <caption> tag defines a table caption.
 * 
 * The <caption> tag must be inserted immediately after the <table> 
 * tag. You can specify only one caption per table. Usually the 
 * caption will be centered above the table.
 * {@link http://www.w3schools.com/tags/tag_caption.asp }
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
namespace HTMLBuilder\Elements\Table;
use HTMLBuilder\Elements\Root;
use HTMLBuilder\Elements\Attributes;

/**
 * The <caption> tag defines a table caption.
 * 
 * The <caption> tag must be inserted immediately after the <table> 
 * tag. You can specify only one caption per table. Usually the 
 * caption will be centered above the table.
 * {@link http://www.w3schools.com/tags/tag_caption.asp }
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
class Caption extends Root {

    public function initElement() {

        $this->_isBlock = false;
        $this->_allowedChildren = self::INLINE;
    }
}