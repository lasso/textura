<?php
/**
 * The <param> tag is used to define parameters or variables for an object or applet element.
 *
 * {@link http://www.w3schools.com/tags/tag_param.asp }
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
use HTMLBuilder\Validator;
use HTMLBuilder\Elements\Root;

/**
 * The <param> tag is used to define parameters or variables for an object or applet element.
 *
 * {@link http://www.w3schools.com/tags/tag_param.asp }
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
class Param extends Root {

    const VALUETYPE_DATA = "data";

    const VALUETYPE_REF = "ref";

    const VALUETYPE_OBJECT = "object";

    /**
     * Specifies the MIME type for a parameter
     * @var string
     */
    protected $type = "";

    /**
     * Specifies the value of a parameter
     * @var string
     */
    protected $value = "";

    /**
     * Specifies the type of the value
     * @var string
     */
    protected $valuetype = "";

    /**
     * Defines the name for a parameter (to use in script)
     * @var string
     */
    protected $name = "";

    /**
     * Defines the name for a parameter (to use in script)
     * 
     * @param string $name
     */
    public final function setName($name) {

        if ($this->validateSetter(Validator::CLEANSTRING, $name)) {
            $this->name = $name;
        }
        return $this;
    }

    /**
     * Defines the name for a parameter (to use in script)
     * 
     * @return the $name
     */
    public final function getName() {

        return $this->name;
    }

    public function initElement() {

    }

    /**
     * Specifies the MIME type for a parameter
     * 
     * @param string $type
     */
    public final function setType($type) {

        $this->type = $type;
        return $this;
    }

    /**
     * Specifies the value of a parameter
     * 
     * @param string $value
     */
    public final function setValue($value) {

        $this->value = $value;
        return $this;
    }

    /**
     * Specifies the type of the value
     * 
     * @param string $valuetype
     */
    public final function setValuetype($valuetype) {

        $types      = $this->_getClassConstants("^VALUETYPE_(.*)$");
        $validators = array (
                            Validator::WHITELIST,
                            $types
        );

        if ($this->validateSetter($validators, $valuetype)) {
            $this->valuetype = $valuetype;
        }

        return $this;
    }

    /**
     * Specifies the MIME type for a parameter
     * 
     * @return the $type
     */
    public final function getType() {

        return $this->type;
    }

    /**
     * Specifies the value of a parameter
     * 
     * @return the $value
     */
    public final function getValue() {

        return $this->value;
    }

    /**
     * Specifies the type of the value
     * 
     * @return the $valuetype
     */
    public final function getValuetype() {

        return $this->valuetype;
    }
}