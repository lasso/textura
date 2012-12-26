<?php
/**
 * The <button> tag defines a push button.
 *
 * Inside a button element you can put content, like text or images. This is 
 * the difference between this element and buttons created with the input 
 * element. Always specify the type attribute for the button. The default 
 * type for Internet Explorer is "button", while in other browsers (and 
 * in the W3C specification) it is "submit". {@link http://www.w3schools.com/tags/tag_button.asp }
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
namespace HTMLBuilder\Elements\Form;
use HTMLBuilder\Validator;
use HTMLBuilder\Elements\Root;

/**
 * The <button> tag defines a push button.
 *
 * Inside a button element you can put content, like text or images. This is 
 * the difference between this element and buttons created with the input 
 * element. Always specify the type attribute for the button. The default 
 * type for Internet Explorer is "button", while in other browsers (and 
 * in the W3C specification) it is "submit". {@link http://www.w3schools.com/tags/tag_button.asp }
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
class Button extends RootForm {

    /**
     * Type button to use in setType()
     * @var string
     */
    const TYPE_BUTTON = "button";

    /**
     * Type submit to use in setType()
     * @var string
     */
    const TYPE_SUBMIT = "submit";

    /**
     * Type reset to use in setType()
     * @var string
     */
    const TYPE_RESET = "reset";

    /**
     * Specifies the type of a button
     * @var string
     */
    protected $type = "";

    /**
     * Specifies the underlying value of a button
     * @var string
     */
    protected $value = "";

    /**
     * (non-PHPdoc)
     * 
     * @see HTMLBuilder\Elements.Root::initElement()
     */
    public function initElement() {

        $this->_isBlock = false;
        $this->_allowedChildren = array (
                                        "abbr",
                                        "acronym",
                                        "address",
                                        "applet",
                                        "b",
                                        "basefont",
                                        "bdo",
                                        "big",
                                        "blockquote",
                                        "br",
                                        "center",
                                        "cite",
                                        "code",
                                        "dfn",
                                        "dl",
                                        "dir",
                                        "div",
                                        "em",
                                        "font",
                                        "h1",
                                        "h2",
                                        "h3",
                                        "h4",
                                        "h5",
                                        "h6",
                                        "hr",
                                        "i",
                                        "img",
                                        "kbd",
                                        "map",
                                        "menu",
                                        "noframes",
                                        "noscript",
                                        "object",
                                        "ol",
                                        "p",
                                        "pre",
                                        "q",
                                        "samp",
                                        "script",
                                        "small",
                                        "span",
                                        "strong",
                                        "sub",
                                        "sup",
                                        "table",
                                        "tt",
                                        "ul",
                                        "var"
        );
    }

    /**
     * Specifies the type of a button
     * 
     * @param string $type
     * 
     * @return $this fluent interfacce
     */
    public final function setType($type) {

        $types = $this->_getClassConstants("^TYPE_(.*)$");

        $validators = array (
                            Validator::WHITELIST,
                            $types
        );

        if ($this->validateSetter($validators, $type)) {
            $this->type = $type;
        }

        return $this;
    }

    /**
     * Specifies the underlying value of a button
     * 
     * @param string $value
     * 
     * @return $this fluent interfacce
     */
    public final function setValue($value) {

        $this->value = $value;
        return $this;
    }

    /**
     * Specifies the type of a button
     * 
     * @return the $type
     */
    public final function getType() {

        return $this->type;
    }

    /**
     * Specifies the underlying value of a button
     * 
     * @return the $value
     */
    public final function getValue() {

        return $this->value;
    }
}