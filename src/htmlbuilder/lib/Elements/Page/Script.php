<?php
/**
 * The <script> tag is used to define a client-side script, such as a JavaScript.
 * 
 * The script element either contains scripting statements or it points to an 
 * external script file through the src attribute. The required type attribute 
 * specifies the MIME type of the script. Common uses for JavaScript are image 
 * manipulation, form validation, and dynamic changes of content.
 * {@link http://www.w3schools.com/tags/tag_script.asp }
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
namespace HTMLBuilder\Elements\Page;
use HTMLBuilder\Validator;

use HTMLBuilder\Elements\Root;

/**
 * The <script> tag is used to define a client-side script, such as a JavaScript.
 * 
 * The script element either contains scripting statements or it points to an 
 * external script file through the src attribute. The required type attribute 
 * specifies the MIME type of the script. Common uses for JavaScript are image 
 * manipulation, form validation, and dynamic changes of content.
 * {@link http://www.w3schools.com/tags/tag_script.asp }
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
class Script extends Root {

    /**
     * Specifies the character encoding used in an external script file
     * @var string
     */
    protected $charset = "";

    /**
     * Specifies that the execution of a script should be deferred (delayed) until after the page has been loaded
     * @var string
     */
    protected $defer = "";

    /**
     * Specifies the URL of an external script file
     * @var string
     */
    protected $src = "";

    /**
     * Specifies the MIME type of a script
     * @var string
     */
    protected $type = "";

    public function initElement() {

        $this->_isBlock = false;
    }

    /**
     * Specifies the character encoding used in an external script file
     * 
     * @param string $charset
     */
    public final function setCharset($charset) {

        $this->charset = $charset;
        return $this;
    }

    /**
     * Specifies that the execution of a script should be deferred (delayed) until after the page has been loaded
     * 
     * @param boolean $defer
     */
    public final function setDefer($defer) {

        if ($this->validateSetter(Validator::BOOLEAN, $defer)) {

            if ($defer) {
                $this->defer = "defer";
            } else {
                $this->defer = "";
            }
        }
        return $this;
    }

    /**
     * Specifies the URL of an external script file
     * 
     * @param string $src
     */
    public final function setSrc($src) {

        $validators = Validator::URL;
        if ($this->validateSetter($validators, $src)) {
            $this->src = $src;
        }
        return $this;
    }

    /**
     * Specifies the MIME type of a script
     * 
     * @param string $type
     */
    public final function setType($type) {

        $this->type = $type;
        return $this;
    }

    /**
     * Specifies the character encoding used in an external script file
     * 
     * @return the $charset
     */
    public final function getCharset() {

        return $this->charset;
    }

    /**
     * Specifies that the execution of a script should be deferred (delayed) until after the page has been loaded
     * 
     * @return the $defer
     */
    public final function getDefer() {

        return $this->defer;
    }

    /**
     * Specifies the URL of an external script file
     * 
     * @return the $src
     */
    public final function getSrc() {

        return $this->src;
    }

    /**
     * Specifies the MIME type of a script
     * 
     * @return the $type
     */
    public final function getType() {

        return $this->type;
    }
}