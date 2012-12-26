<?php
/**
 * The <span> tag is used to group inline-elements in a document.
 * 
 * The <span> tag provides no visual change by itself. The <span> 
 * tag provides a way to add a hook to a part of a text or a part 
 * of a document. When the text is hooked in a span element you 
 * can add styles to the content, or manipulate the content with 
 * for example JavaScript. {@link http://www.w3schools.com/tags/tag_span.asp }
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
use HTMLBuilder\Elements\Root;
use HTMLBuilder\Elements\Attributes;

/**
 * The <span> tag is used to group inline-elements in a document.
 * 
 * The <span> tag provides no visual change by itself. The <span> 
 * tag provides a way to add a hook to a part of a text or a part 
 * of a document. When the text is hooked in a span element you 
 * can add styles to the content, or manipulate the content with 
 * for example JavaScript. {@link http://www.w3schools.com/tags/tag_span.asp }
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
class Span extends Root {

    public function initElement() {

        $this->_isBlock = false;
        $this->_allowedChildren = self::INLINE;
    }
}