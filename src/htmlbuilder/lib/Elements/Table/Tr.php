<?php
/**
 * The <tr> tag defines a row in an HTML table.
 * 
 * A tr element contains one or more th or td elements.
 * {@link http://www.w3schools.com/tags/tag_tr.asp }
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
use HTMLBuilder\Validator;
use HTMLBuilder\Elements\Root;

/**
 * The <tr> tag defines a row in an HTML table.
 * 
 * A tr element contains one or more th or td elements.
 * {@link http://www.w3schools.com/tags/tag_tr.asp }
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
class Tr extends RootRow {

    public function initElement() {

        $this->_allowedChildren = array (
                                        "th",
                                        "td"
        );
    }
}