<?php
/**
 * Common element events
 * 
 * PHP version 5
 * 
 * @example   simple.php How to use
 * @filesource
 * @category  Elements
 * @package   Elements
 * @author    Jens Peters <jens@history-archive.net>
 * @copyright 2011 Jens Peters
 * @license   http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @version   1.0
 * @link      http://launchpad.net/htmlbuilder
 */
namespace HTMLBuilder\Elements;
use HTMLBuilder\Validator;
use HTMLBuilder\Exceptions\Exception;

/**
 * Common element events
 * 
 * @category   Elements
 * @example    simple.php see HOW TO USE
 * @example    debug.php see HOW TO DEBUG
 * @package    Elements
 * @subpackage Base
 * @author     Jens Peters <jens@history-archiv.net>
 * @license    http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @link       http://launchpad.net/htmlbuilder
 */
abstract class Events {

    /**
     * Some tags does not keyboard events
     * @var array
     */
    private $_forbiddenKbdEvents = array (
                                        "base",
                                        "bdo",
                                        "br",
                                        "frame",
                                        "frameset",
                                        "head",
                                        "html",
                                        "iframe",
                                        "meta",
                                        "param",
                                        "script",
                                        "style",
                                        "title"
    );

    /**
     * Some tags does not mouse events
     * @var array
     */
    private $_forbiddenMouseEvents = array (
                                            "base",
                                            "bdo",
                                            "br",
                                            "frame",
                                            "frameset",
                                            "head",
                                            "html",
                                            "iframe",
                                            "meta",
                                            "param",
                                            "script",
                                            "style",
                                            "title"
    );

    /**
     * Script to be run on a mouse click
     * @var string
     */
    protected $onclick = "";

    /**
     * Script to be run on a mouse double-click
     * @var string
     */
    protected $ondblclick = "";

    /**
     * Script to be run when mouse button is pressed	
     * @var string
     */
    protected $onmousedown = "";

    /**
     * Script to be run when mouse button is released
     * @var string
     */
    protected $onmouseup = "";

    /**
     * Script to be run when mouse pointer moves over an element
     * @var string
     */
    protected $onmouseover = "";

    /**
     * Script to be run when mouse pointer moves
     * @var string
     */
    protected $onmousemove = "";

    /**
     * Script to be run when mouse pointer moves out of an element
     * @var string
     */
    protected $onmouseout = "";

    /**
     * Script to be run when a key is pressed and released
     * @var string
     */
    protected $onkeypress = "";

    /**
     * Script to be run when a key is pressed
     * @var string
     */
    protected $onkeydown = "";

    /**
     * Script to be run when a key is released
     * @var string
     */
    protected $onkeyup = "";

    /**
     * Script to be run on a mouse click
     * 
     * @param string $onclick
     * 
     * @throws Exception if not suppoerted by the element
     * @return $this fluent interface
     */
    public final function setOnclick($onclick) {

        if (!Validator::validateValue(Validator::BLACKLIST, $this->_forbiddenMouseEvents)) {
            throw new Exception("Tag does not mouse events", Exception::NOT_ALLOWED_EVENT);
        }

        $this->onclick = $onclick;
        return $this;
    }

    /**
     * Script to be run on a mouse double-click
     * 
     * @param string $ondblclick
     * 
     * @throws Exception if not suppoerted by the element
     * @return $this fluent interface
     */
    public final function setOndblclick($ondblclick) {

        if (!Validator::validateValue(Validator::BLACKLIST, $this->_forbiddenMouseEvents)) {
            throw new Exception("Tag does not mouse events", Exception::NOT_ALLOWED_EVENT);
        }

        $this->ondblclick = $ondblclick;
        return $this;
    }

    /**
     * Script to be run when mouse button is pressed
     * 
     * @param string $onmousedown
     * 
     * @throws Exception if not suppoerted by the element
     * @return $this fluent interface
     */
    public final function setOnmousedown($onmousedown) {

        if (!Validator::validateValue(Validator::BLACKLIST, $this->_forbiddenMouseEvents)) {
            throw new Exception("Tag does not mouse events", Exception::NOT_ALLOWED_EVENT);
        }

        $this->onmousedown = $onmousedown;
        return $this;
    }

    /**
     * Script to be run when mouse button is released
     * 
     * @param string $onmouseup
     * 
     * @throws Exception if not suppoerted by the element
     * @return $this fluent interface
     */
    public final function setOnmouseup($onmouseup) {

        if (!Validator::validateValue(Validator::BLACKLIST, $this->_forbiddenMouseEvents)) {
            throw new Exception("Tag does not kyboard events", Exception::NOT_ALLOWED_EVENT);
        }

        $this->onmouseup = $onmouseup;
        return $this;
    }

    /**
     * Script to be run when mouse pointer moves over an element
     * 
     * @param string $onmouseover
     * 
     * @throws Exception if not suppoerted by the element
     * @return $this fluent interface
     */
    public final function setOnmouseover($onmouseover) {

        if (!Validator::validateValue(Validator::BLACKLIST, $this->_forbiddenMouseEvents)) {
            throw new Exception("Tag does not kyboard events", Exception::NOT_ALLOWED_EVENT);
        }

        $this->onmouseover = $onmouseover;
        return $this;
    }

    /**
     * Script to be run when mouse pointer moves
     * 
     * @param string $onmousemove
     * 
     * @throws Exception if not suppoerted by the element
     * @return $this fluent interface
     */
    public final function setOnmousemove($onmousemove) {

        if (!Validator::validateValue(Validator::BLACKLIST, $this->_forbiddenMouseEvents)) {
            throw new Exception("Tag does not kyboard events", Exception::NOT_ALLOWED_EVENT);
        }

        $this->onmousemove = $onmousemove;
        return $this;
    }

    /**
     * Script to be run when mouse pointer moves out of an element
     * 
     * @param string $onmouseout
     * 
     * @throws Exception if not suppoerted by the element
     * @return $this fluent interface
     */
    public final function setOnmouseout($onmouseout) {

        if (!Validator::validateValue(Validator::BLACKLIST, $this->_forbiddenMouseEvents)) {
            throw new Exception("Tag does not kyboard events", Exception::NOT_ALLOWED_EVENT);
        }

        $this->onmouseout = $onmouseout;
        return $this;
    }

    /**
     * Script to be run when a key is pressed
     * 
     * @param string $onkeypress
     * 
     * @throws Exception if not suppoerted by the element
     * @return $this fluent interface
     */
    public final function setOnkeypress($onkeypress) {

        if (!Validator::validateValue(Validator::BLACKLIST, $this->_forbiddenKbdEvents)) {
            throw new Exception("Tag does not kyboard events", Exception::NOT_ALLOWED_EVENT);
        }

        $this->onkeypress = $onkeypress;
        return $this;
    }

    /**
     * Script to be run when a key is pressed
     * 
     * @param string $onkeydown
     * 
     * @throws Exception if not suppoerted by the element
     * @return $this fluent interface
     */
    public final function setOnkeydown($onkeydown) {

        if (!Validator::validateValue(Validator::BLACKLIST, $this->_forbiddenKbdEvents)) {
            throw new Exception("Tag does not kyboard events", Exception::NOT_ALLOWED_EVENT);
        }

        $this->onkeydown = $onkeydown;
        return $this;
    }

    /**
     * Script to be run when a key is released
     * 
     * @param string $onkeyup
     * 
     * @throws Exception if not suppoerted by the element
     * @return $this fluent interface
     */
    public final function setOnkeyup($onkeyup) {

        if (!Validator::validateValue(Validator::BLACKLIST, $this->_forbiddenKbdEvents)) {
            throw new Exception("Tag does not kyboard events", Exception::NOT_ALLOWED_EVENT);
        }

        $this->onkeyup = $onkeyup;
        return $this;
    }

    /**
     * Script to be run on a mouse click
     * 
     * @return the $onclick
     */
    public final function getOnclick() {

        return $this->onclick;
    }

    /**
     * Script to be run on a mouse double-click
     * 
     * @return the $ondblclick
     */
    public final function getOndblclick() {

        return $this->ondblclick;
    }

    /**
     * Script to be run when mouse button is pressed
     * 
     * @return the $onmousedown
     */
    public final function getOnmousedown() {

        return $this->onmousedown;
    }

    /**
     * Script to be run when mouse button is released
     * 
     * @return the $onmouseup
     */
    public final function getOnmouseup() {

        return $this->onmouseup;
    }

    /**
     * Script to be run when mouse pointer moves over an element
     * 
     * @return the $onmouseover
     */
    public final function getOnmouseover() {

        return $this->onmouseover;
    }

    /**
     * Script to be run when mouse pointer moves
     * 
     * @return the $onmousemove
     */
    public final function getOnmousemove() {

        return $this->onmousemove;
    }

    /**
     * Script to be run when mouse pointer moves out of an element
     * 
     * @return the $onmouseout
     */
    public final function getOnmouseout() {

        return $this->onmouseout;
    }

    /**
     * Script to be run when a key is pressed
     * 
     * @return the $onkeypress
     */
    public final function getOnkeypress() {

        return $this->onkeypress;
    }

    /**
     * Script to be run when a key is pressed
     * 
     * @return the $onkeydown
     */
    public final function getOnkeydown() {

        return $this->onkeydown;
    }

    /**
     * Script to be run when a key is released
     * 
     * @return the $onkeyup
     */
    public final function getOnkeyup() {

        return $this->onkeyup;
    }
}