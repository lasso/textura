<?php
/**
 * The <del> tag defines text that has been deleted from a document.
 * 
 * {@link http://www.w3schools.com/tags/tag_del.asp }
 * 
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
use HTMLBuilder\Elements\Root;
use HTMLBuilder\Validator;

/**
 * The <del> tag defines text that has been deleted from a document.
 * 
 * {@link http://www.w3schools.com/tags/tag_del.asp }
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
class Del extends Root {

    protected $cite = "";

    protected $datetime = "";

    public function initElement() {

        $this->_isBlock = false;
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
     * @param string $datetime
     */
    public final function setDatetime($datetime) {

        $this->datetime = $datetime;
        return $this;
    }

    /**
     * @return the $cite
     */
    public final function getCite() {

        return $this->cite;
    }

    /**
     * @return the $datetime
     */
    public final function getDatetime() {

        return $this->datetime;
    }

}