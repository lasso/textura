<?php
/**
 * The <noscript> tag is used to provide an alternate content for users 
 * that have disabled scripts in their browser or have a browser that 
 * doesn’t support client-side scripting.
 * 
 * The noscript element can contain all the elements that you can find 
 * inside the body element of a normal HTML page. The content inside 
 * the noscript element will only be displayed if scripts are not 
 * supported, or are disabled in the user’s browser. {@link http://www.w3schools.com/tags/tag_noscript.asp }
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
namespace HTMLBuilder\Elements\General;
use HTMLBuilder\Elements\Attributes;

use HTMLBuilder\Elements\Root;

/**
 * The <noscript> tag is used to provide an alternate content for users 
 * that have disabled scripts in their browser or have a browser that 
 * doesn’t support client-side scripting.
 * 
 * The noscript element can contain all the elements that you can find 
 * inside the body element of a normal HTML page. The content inside 
 * the noscript element will only be displayed if scripts are not 
 * supported, or are disabled in the user’s browser. {@link http://www.w3schools.com/tags/tag_noscript.asp }
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
class Noscript extends Root {

    public function initElement() {

        $this->_allowedChildren = Root::BLOCK;
    }
}