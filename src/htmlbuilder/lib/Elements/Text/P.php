<?php
/**
 * The <p> tag defines a paragraph.
 *
 * The p element automatically creates some space before and after itself. 
 * The space is automatically applied by the browser, or you can specify it in a style sheet.
 * {@link http://www.w3schools.com/tags/tag_p.asp }
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
namespace HTMLBuilder\Elements\Text;
use HTMLBuilder\Elements\Attributes;

use HTMLBuilder\Elements\Root;

/**
 * The <p> tag defines a paragraph.
 *
 * The p element automatically creates some space before and after itself. 
 * The space is automatically applied by the browser, or you can specify it in a style sheet.
 * {@link http://www.w3schools.com/tags/tag_p.asp }
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

class P extends Root {

    public function initElement() {

        $this->_allowedChildren = self::INLINE;
    }
}