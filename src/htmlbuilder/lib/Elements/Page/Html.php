<?php
/**
 * The <html> tag tells the browser that this is an HTML document.
 * 
 * The html element is the outermost element in HTML and XHTML documents. 
 * The html element is also known as the root element. 
 * {@link http://www.w3schools.com/tags/tag_html.asp }
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
namespace HTMLBuilder\Elements\Page;
use HTMLBuilder\Elements\Root;
use HTMLBuilder\Validator;
use HTMLBuilder\Exceptions\Exception;

/**
 * The <html> tag tells the browser that this is an HTML document.
 * 
 * The html element is the outermost element in HTML and XHTML documents. 
 * The html element is also known as the root element. 
 * {@link http://www.w3schools.com/tags/tag_html.asp }
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

class Html extends Root {

    /**
     * Constructor
     */
    public function initElement() {

        $this->_allowedChildren = array (
                                        "head",
                                        "body"
        );
    }
}