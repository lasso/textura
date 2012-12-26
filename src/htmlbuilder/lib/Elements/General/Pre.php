<?php
/**
 * The &lt;pre&gt; tag defines preformatted text.
 *
 * Text in a pre element is displayed in a fixed-width font (usually Courier), 
 * and it preserves both spaces and line breaks. {@link http://www.w3schools.com/tags/tag_pre.asp }
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
use HTMLBuilder\Validator;

use HTMLBuilder\Elements\Root;
use HTMLBuilder\Elements\Attributes;

/**
 * The &lt;pre&gt; tag defines preformatted text.
 *
 * Text in a pre element is displayed in a fixed-width font (usually Courier), 
 * and it preserves both spaces and line breaks. {@link http://www.w3schools.com/tags/tag_pre.asp }
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
class Pre extends Root {

    public function initElement() {

        $this->_allowedChildren = self::INLINE;
    }
}