<?php
/**
 * The <sub> tag defines subscript text. Subscript text appears half a character below the baseline. 
 * 
 * Subscript text can be used for chemical formulas, like H2O.
 * {@link http://www.w3schools.com/tags/tag_sup.asp }
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
namespace HTMLBuilder\Elements\Text;
use HTMLBuilder\Elements\Attributes;

use HTMLBuilder\Elements\Root;

/**
 * The <sub> tag defines subscript text. Subscript text appears half a character below the baseline. 
 * 
 * Subscript text can be used for chemical formulas, like H2O.
 * {@link http://www.w3schools.com/tags/tag_sup.asp }
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
class Sub extends Root {

    public function initElement() {

        $this->_isBlock = false;
        $this->_allowedChildren = self::INLINE;
    }
}