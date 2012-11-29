<?php
/**
 * The <br> tag inserts a single line break. 
 *
 * The <br> tag is an empty tag which means that it has no end tag. 
 * {@link http://www.w3schools.com/tags/tag_br.asp }
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
use HTMLBuilder\Validator;

/**
 * The <br> tag inserts a single line break. 
 *
 * The <br> tag is an empty tag which means that it has no end tag. 
 * {@link http://www.w3schools.com/tags/tag_br.asp }
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
class Br extends Root {

    const CLEAR_LEFT = "left";

    const CLEAR_ALL = "all";

    const CLEAR_RIGHT = "right";

    const CLEAR_NONE = "none";

    protected $clear = "";

    public function initElement() {

        $this->_isBlock       = false;
        $this->_isSelfclosing = true;
    }

    /**
     * @param string $clear
     */
    public final function setClear($clear) {

        $types      = $this->_getClassConstants("^CLEAR_(.*)$");
        $validators = array (
                            Validator::WHITELIST,
                            $types
        );

        if ($this->validateSetter($validators, $clear)) {
            $this->clear = $clear;
        }

        return $this;
    }

    /**
     * @return the $clear
     */
    public final function getClear() {

        return $this->clear;
    }
}