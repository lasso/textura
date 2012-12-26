<?php
/**
 * HTML tag attributes base class 
 * 
 * PHP version 5
 * 
 * @filesource
 * @category  Elements
 * @package   Elements
 * @author    Jens Peters <jens@history-archive.net>
 * @copyright 2011 Jens Peters
 * @license   http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @version   1.1
 * @link      http://launchpad.net/htmlbuilder
 */
namespace HTMLBuilder\Elements;
use HTMLBuilder\Autoloader;
use HTMLBuilder\Validator;
use HTMLBuilder\Exceptions\Exception;

/**
 * HTML tag attributes base class contains common methods.
 * 
 * @SuppressWarnings(PHPMD.ShortVariable)
 * @category   Elements
 * @package    Elements
 * @subpackage Base
 * @author     Jens Peters <jens@history-archiv.net>
 * @license    http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @link       http://launchpad.net/htmlbuilder
 * 
 * @TODO implement protected $xml:lang workaround
 * Specifies a language code for the content in an element, in XHTML documents.    
 */
abstract class Attributes extends Events {

    /**
     * Text orientation left to right
     * @var string
     */
    const DIR_LTR = "ltr";

    /**
     * Text orientation right to left
     * @var string
     */
    const DIR_RTL = "rtl";

    /**
     * Some tags does not support standard attributes
     * @var array
     */
    private $_forbiddenCoreAttribute = array (
                                            "base",
                                            "head",
                                            "html",
                                            "meta",
                                            "param",
                                            "script",
                                            "style",
                                            "title"
    );

    /**
     * Some tags does not support language attributes
     * @var array
     */
    private $_forbiddenLangAttribute = array (
                                            "base",
                                            "br",
                                            "frame",
                                            "frameset",
                                            "hr",
                                            "iframe",
                                            "param",
                                            "script"
    );

    /**
     * Decide whether to end with &gt;/tag&lt; or /&lt;
     * @var boolean
     */
    protected $_isSelfclosing = false;

    /**
     * These properties are excluded in some methods
     * @var array
     */
    private $_excludes = array (
                                "_validatingFields",
                                "_excludes",
                                "_innerHTML"
    );

    /**
     * Element's innerHTML
     * @var string
     */
    protected $_innerHTML = "";

    /**
     * Specifies a unique id for an element
     * @var string
     */
    protected $id = "";

    /**
     * Specifies an inline style for an element
     * @var string
     */
    protected $style = "";

    /**
     * Specifies a classname for an element
     * @var string
     */
    protected $class = "";

    /**
     * Specifies extra information about an element (displayed as a tool tip)
     * @var string
     */
    protected $title = "";

    /**
     * Specifies the text direction for the content in an element, using DIR_ constants
     * @var string
     */
    protected $dir = "";

    /**
     * Specifies a language code for the content in an element.
     * @var string
     */
    protected $lang = "";

    /**
     * Specifies the tab order of an element
     * 
     * @var string
     */
    protected $tabindex = "";

    /**
     * Specifies a keyboard shortcut to access an element
     * @var string
     */
    protected $accesskey = "";

    /**
     * Init some validation
     *
     * @param string $innerHTML (optional) the elements _innerHTML
     * @param string $tagId     (optional) the tag attribute id
     */
    public function __construct($innerHTML = null, $tagId = null) {

        if (isset($tagId)) {
            $this->id = $tagId;
        }

        if (isset($innerHTML)) {
            $this->_innerHTML = $innerHTML;
        }
    }

    /**
     * Generating elements attributes string
     * 
     * @return string 
     */
    protected function generateAttributeString() {

        $build = "";
        foreach ($this as $key => $value) {

            if (!in_array($key, $this->_excludes) && $key[0] !== "_" && $value != "") {
                $build .= ' ' . $key . '="' . $value . '"';
            }
        }
        return $build;
    }

    /**
     * Validation of setters
     * 
     * @param string $type  The validation type
     * @param mixed  $value The property value
     * 
     * @return Attributes fluent inteface
     * @throws Exception
     */
    protected function validateSetter($type, $value) {
        
        switch(true) {
            case is_array($type) && count($type) == 2 :
                $name = print_r($type, true);
                $result = Validator::validateValue($type[0], $value, $type[1]);
            break;

            default:
                $name = $type;
                $result = Validator::validateValue($type, $value);
            break;
        }

        if (!$result) {
            $msg = sprintf('Error Setting attribute, %1$s -> %2$s', $value, $name);
            throw new Exception($msg, Exception::VALUE_NOT_ALLOWED);
        }

        return true;
    }

    /**
     * Specifies an inline style for an element
     * 
     * @param array $styles Associative array containing CSS styles
     * 
     * @return $this fluent interfacce
     */
    public function setStyle(array $styles) {

        $style = "";
        $start = 0;
        $end   = (count($styles) - 1);

        foreach ($styles as $key => $value) {

            $endSign = ";";
            if ($start < $end) {
                $endSign .= " ";
            }

            $style .= $key . ": " . $value . $endSign;
            $start++;
        }
        $this->style = $style;

        return $this;
    }

    /**
     * Specifies a unique id for an element
     * 
     * @param string $id Element id
     * 
     * @throws Exception if not supported
     * 
     * @return $this fluent interfacce
     */
    public final function setId($id) {

        if (!Validator::validateValue(Validator::BLACKLIST, $this->_forbiddenCoreAttribute)) {
            throw new Exception("Tag does not support core values", Exception::NOT_ALLOWED_CORE_ATTR);
        }

        if ($this->validateSetter(Validator::CLEANSTRING, $id)) {
            $this->id = $id;
        }
        return $this;
    }

    /**
     * Specifies a classname for an element
     * 
     * @param string $class Css class / classes
     * 
     * @throws Exception if not supported
     * 
     * @return $this fluent interfacce
     */
    public final function setClass($class) {

        if (!Validator::validateValue(Validator::BLACKLIST, $this->_forbiddenCoreAttribute)) {
            throw new Exception("Tag does not support core attributes", Exception::NOT_ALLOWED_CORE_ATTR);
        }

        $this->class = $class;
        return $this;
    }

    /**
     * Specifies extra information about an element (displayed as a tool tip)
     * 
     * @param string $title Elements title attribute
     * 
     * @throws Exception if not supported
     * 
     * @return $this fluent interfacce
     */
    public final function setTitle($title) {

        if (!Validator::validateValue(Validator::BLACKLIST, $this->_forbiddenCoreAttribute)) {
            throw new Exception("Tag does not support core attributes", Exception::NOT_ALLOWED_CORE_ATTR);
        }

        $this->title = $title;
        return $this;
    }

    /**
     * Specifies the text direction for the content in an element, using DIR_ constants
     * 
     * @param string $dir the direction of the content
     * 
     * @throws Exception if not supported
     * 
     * @return $this fluent interfacce
     */
    public final function setDir($dir) {

        if (!Validator::validateValue(Validator::BLACKLIST, $this->_forbiddenLangAttribute)) {
            throw new Exception("Tag does not support language attributes", Exception::NOT_ALLOWED_CORE_ATTR);
        }

        $types      = $this->_getClassConstants("^DIR_(.*)$");
        $validators = array (
                            Validator::WHITELIST,
                            $types
        );

        if ($this->validateSetter($validators, $dir)) {
            $this->dir = $dir;
        }

        return $this;
    }

    /**
     * Specifies a keyboard shortcut to access an element
     * 
     * @param string $accesskey keyboard access key
     * 
     * @return $this fluent interfacce
     */
    public final function setAccesskey($accesskey) {

        $validators = "[0-9a-zA-Z]{1}";

        if ($this->validateSetter($validators, $accesskey)) {
            $this->accesskey = $accesskey;
        }

        return $this;
    }

    /**
     * Specifies the tab order of an element
     * 
     * @param int $tabindex the tabulator index
     * 
     * @return $this fluent interfacce
     */
    public final function setTabindex($tabindex) {

        $validators = Validator::NUMBER;

        if ($this->validateSetter($validators, (int) $tabindex)) {
            $this->tabindex = $tabindex;
        }

        return $this;
    }

    /**
     * Getting acces key value
     * 
     * @return the $accesskey
     */
    public final function getAccesskey() {

        return $this->accesskey;
    }

    /**
     * Specifies a language code for the content in an element.
     * 
     * @param string $lang language code for the element
     * 
     * @return $this fluent interfacce
     */
    public final function setLang($lang) {

        $this->lang = $lang;
        return $this;
    }

    /**
     * Specifies a language code for the content in an element.
     * 
     * @return the $lang
     */
    public final function getLang() {

        return $this->lang;
    }

    /**
     * Set the element inner html
     * 
     * @param string $_innerHTML the element inner html
     * 
     * @return $this fluent interfacce
     */
    public function setInnerHTML($_innerHTML) {

        $this->_innerHTML = $_innerHTML;
        return $this;
    }

    /**
     * Specifies a unique id for an element
     * 
     * @return the $id
     */
    public final function getId() {

        return $this->id;
    }

    /**
     * Specifies an inline style for an element
     * 
     * @return the $style
     */
    public final function getStyle() {

        return $this->style;
    }

    /**
     * Specifies a classname for an element
     * 
     * @return the $class
     */
    public final function getClass() {

        return $this->class;
    }

    /**
     * Specifies extra information about an element (displayed as a tool tip)
     * 
     * @return the $title
     */
    public final function getTitle() {

        return $this->title;
    }

    /**
     * Specifies the text direction for the content in an element, using DIR_ constants
     * 
     * @return the $dir
     */
    public final function getDir() {

        return $this->dir;
    }

    /**
     * Getting elements inner html
     * 
     * @return the $_innerHTML
     */
    public function getInnerHTML() {

        return $this->_innerHTML;
    }

    /**
     * Specifies the tab order of an element
     * 
     * @return the $tabindex
     */
    public final function getTabindex() {

        return $this->tabindex;
    }

    /**
     * Getting object class constants
     *
     * @param string $filter regex
     * 
     * @return array
     */
    public function _getClassConstants($filter = "") {

        $constants = array ();
        $refl      = new \ReflectionClass($this);
        $temp      = $refl->getConstants();

        foreach ($temp as $key => $value) {
            if ($filter !== "" && preg_match("/" . $filter . "/is", $key)) {
                $constants[] = $value;
            } else {
                $constants[] = $value;
            }
        }
        return $constants;
    }
}