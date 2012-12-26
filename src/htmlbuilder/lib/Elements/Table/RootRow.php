<?php
/**
 * Common row attributes
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
 * Common row attributes
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
abstract class RootRow extends Root {

    const ALIGN_LEFT = "left";

    const ALIGN_CENTER = "center";

    const ALIGN_RIGHT = "right";

    const ALIGN_JUSTIFY = "justify";

    const ALIGN_CHAR = "char";

    const VALIGN_TOP = "top";

    const VALIGN_MIDDLE = "middle";

    const VALIGN_BOTTOM = "bottom";

    const VALIGN_BASELINE = "baseline";

    protected $align = "";

    protected $char = "";

    protected $charoff = "";

    protected $valign = "";

    /**
     * @param string $align
     */
    public final function setAlign($align) {

        $types      = $this->_getClassConstants("^ALIGN_(.*)$");
        $validators = array (
                            Validator::WHITELIST,
                            $types
        );

        if ($this->validateSetter($validators, $align)) {
            $this->align = $align;
        }

        return $this;
    }

    /**
     * @param string $char
     */
    public final function setChar($char) {

        $this->char = $char;
        return $this;
    }

    /**
     * @param string $charoff
     */
    public final function setCharoff($charoff) {

        $this->charoff = $charoff;
        return $this;
    }

    /**
     * @param string $valign
     */
    public final function setValign($valign) {

        $types      = $this->_getClassConstants("^VALIGN_(.*)$");
        $validators = array (
                            Validator::WHITELIST,
                            $types
        );

        if ($this->validateSetter($validators, $valign)) {
            $this->valign = $valign;
        }

        return $this;
    }

    /**
     * Getter
     * 
     * @return the $align
     */
    public final function getAlign() {

        return $this->align;
    }

    /**
     * Getter
     * 
     * @return the $char
     */
    public final function getChar() {

        return $this->char;
    }

    /**
     * Getter
     * 
     * @return the $charoff
     */
    public final function getCharoff() {

        return $this->charoff;
    }

    /**
     * Getter
     * 
     * @return the $valign
     */
    public final function getValign() {

        return $this->valign;
    }

}