<?php
/**
 * The <hr> tag creates a horizontal line in an HTML page.
 *
 * The hr element can be used to separate content in an HTML page.
 * {@link http://www.w3schools.com/tags/tag_hr.asp }
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
namespace HTMLBuilder\Elements\General;
use HTMLBuilder\Elements\Root;

/**
 * The <hr> tag creates a horizontal line in an HTML page.
 *
 * The hr element can be used to separate content in an HTML page.
 * {@link http://www.w3schools.com/tags/tag_hr.asp }
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
class Hr extends Root {

    public function initElement() {

        $this->_isSelfclosing = true;
    }
}