<?php
/**
 * The <acronym> tag defines an acronym.
 * 
 * An acronym can be spoken as if it were a word, example NATO, NASA, ASAP, GUI.
 * By marking up acronyms you can give useful information to browsers, spellcheckers, 
 * screen readers, translation systems and search-engines.
 * {@link http://www.w3schools.com/tags/tag_acronym.asp }
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
 * The <acronym> tag defines an acronym.
 * 
 * An acronym can be spoken as if it were a word, example NATO, NASA, ASAP, GUI.
 * By marking up acronyms you can give useful information to browsers, spellcheckers, 
 * screen readers, translation systems and search-engines.
 * {@link http://www.w3schools.com/tags/tag_acronym.asp }
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
class Acronym extends Root {

    public function initElement() {

        $this->_isBlock = false;
        $this->_allowedChildren = self::INLINE;
    }
}