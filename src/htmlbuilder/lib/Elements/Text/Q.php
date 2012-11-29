<?php
/**
 * The <q> tag defines a short quotation.
 * 
 * The browser will insert quotation marks around the quotation.
 * {@link http://www.w3schools.com/tags/tag_q.asp }
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
use HTMLBuilder\Validator;
use HTMLBuilder\Elements\Root;

/**
 * The <q> tag defines a short quotation.
 * 
 * The browser will insert quotation marks around the quotation.
 * {@link http://www.w3schools.com/tags/tag_q.asp }
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
class Q extends Root {

    protected $cite = "";

    public function initElement() {

        $this->_isBlock = false;
        $this->_allowedChildren = self::INLINE;
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