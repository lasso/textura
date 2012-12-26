<?php
/**
 * The <blockquote> tag defines a long quotation.
 * 
 * A browser inserts white space before and after a blockquote element. 
 * It also insert margins for the blockquote element.
 * {@link http://www.w3schools.com/tags/tag_blockquote.asp }
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
use HTMLBuilder\Validator;
use HTMLBuilder\Elements\Root;

/**
 * The <blockquote> tag defines a long quotation.
 * 
 * A browser inserts white space before and after a blockquote element. 
 * It also insert margins for the blockquote element.
 * {@link http://www.w3schools.com/tags/tag_blockquote.asp }
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
class Blockquote extends Root {

    protected $cite = "";

    public function initElement() {

        $this->_allowedChildren = Root::BLOCK;
    }

    /**
     * @param string $cite
     */
    public final function setCite($cite) {

        $validators = Validator::URL;
        if ($this->validateSetter($validators, $cite)) {
            $this->cite = $cite;
        }
        return $this;
    }

    /**
     * @return the $cite
     */
    public final function getCite() {

        return $this->cite;
    }
}