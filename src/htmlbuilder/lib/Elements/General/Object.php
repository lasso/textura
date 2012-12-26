<?php
/**
 * The <object> tag is used to include objects such as images, audio, videos, Java applets, ActiveX, PDF, and Flash. 
 * 
 * The object element was intended to replace the img and applet elements. 
 * However, because of bugs and a lack of browser support this has not happened. 
 * The object support in browsers depend on the object type. Unfortunately, the 
 * major browsers use different codes to load the same object type. Luckily, the 
 * object element provides a solution. If the object element is not displayed, 
 * the code between the <object> and </object> tags will be executed. 
 * This way we can have several nested object elements (one for each browser).
 * {@link http://www.w3schools.com/tags/tag_object.asp }
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
namespace HTMLBuilder\Elements\General;
use HTMLBuilder\Validator;

use HTMLBuilder\Elements\Root;

/**
 * The <object> tag is used to include objects such as images, audio, videos, Java applets, ActiveX, PDF, and Flash. 
 * 
 * The object element was intended to replace the img and applet elements. 
 * However, because of bugs and a lack of browser support this has not happened. 
 * The object support in browsers depend on the object type. Unfortunately, the 
 * major browsers use different codes to load the same object type. Luckily, the 
 * object element provides a solution. If the object element is not displayed, 
 * the code between the <object> and </object> tags will be executed. 
 * This way we can have several nested object elements (one for each browser).
 * {@link http://www.w3schools.com/tags/tag_object.asp }
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
class Object extends Root {

    /**
     * A space separated list of URL's to archives. The archives contains resources relevant to the object
     * @var string
     */
    protected $archive = "";

    /**
     * Defines a class ID value as set in the Windows Registry or a URL
     * @var string
     */
    protected $classid = "";

    /**
     * Defines where to find the code for the object
     * @var string
     */
    protected $codebase = "";

    /**
     * The internet media type of the code referred to by the classid attribute
     * @var string
     */
    protected $codetype = "";

    /**
     * Defines a URL that refers to the object's data
     * @var string
     */
    protected $data = "";

    /**
     * Defines that the object should only be declared, not created or instantiated until needed
     * @var string
     */
    protected $declare = "";

    /**
     * Defines the height of the object
     * @var string
     */
    protected $height = "";

    /**
     * Defines a text to display while the object is loading
     * @var string
     */
    protected $standby = "";

    /**
     * Defines the MIME type of data specified in the data attribute
     * @var string
     */
    protected $type = "";

    /**
     * Specifies a URL of a client-side image map to be used with the object
     * @var string
     */
    protected $usemap = "";

    /**
     * Defines the width of the object
     * @var string
     */
    protected $width = "";

    /**
     * Defines the name for an object (to use in scripts)
     * @var string
     */
    protected $name = "";

    /**
     * Defines the name for an object (to use in scripts)
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
     * Defines the name for an object (to use in scripts)
     * 
     * @return the $name
     */
    public final function getName() {

        return $this->name;
    }

    public function initElement() {

        $this->_isBlock = false;
    }

    /**
     * A space separated list of URL's to archives. The archives contains resources relevant to the object
     * 
     * @param string $archive
     */
    public final function setArchive($archive) {

        $this->archive = $archive;
        return $this;
    }

    /**
     * Defines a class ID value as set in the Windows Registry or a URL
     * 
     * @param string $classid
     */
    public final function setClassid($classid) {

        $this->classid = $classid;
        return $this;
    }

    /**
     * Defines where to find the code for the object
     * 
     * @param string $codebase
     */
    public final function setCodebase($codebase) {

        $validators = Validator::URL;
        if ($this->validateSetter($validators, $codebase)) {
            $this->codebase = $codebase;
        }
        return $this;
    }

    /**
     * The internet media type of the code referred to by the classid attribute
     * 
     * @param string $codetype
     */
    public final function setCodetype($codetype) {

        $this->codetype = $codetype;
        return $this;
    }

    /**
     * Defines a URL that refers to the object's data
     * 
     * @param string $data
     */
    public final function setData($data) {

        $validators = Validator::URL;
        if ($this->validateSetter($validators, $data)) {
            $this->data = $data;
        }
        return $this;
    }

    /**
     * Defines that the object should only be declared, not created or instantiated until needed
     * 
     * @param boolean $declare
     */
    public final function setDeclare($declare) {

        if ($this->validateSetter(Validator::BOOLEAN, $declare)) {

            if ($declare) {
                $this->declare = "declare";
            } else {
                $this->declare = "";
            }
        }
        return $this;
    }

    /**
     * Defines the height of the object
     * 
     * @param string $height
     */
    public final function setHeight($height) {

        $this->height = $height;
        return $this;
    }

    /**
     * Defines a text to display while the object is loading
     * 
     * @param string $standby
     */
    public final function setStandby($standby) {

        $this->standby = $standby;
        return $this;
    }

    /**
     * Defines the MIME type of data specified in the data attribute
     * 
     * @param string $type
     */
    public final function setType($type) {

        $this->type = $type;
        return $this;
    }

    /**
     * Specifies a URL of a client-side image map to be used with the object
     * 
     * @param string $usemap
     */
    public final function setUsemap($usemap) {

        $validators = Validator::URL;
        if ($this->validateSetter($validators, $usemap)) {
            $this->usemap = $usemap;
        }
        return $this;
    }

    /**
     * Defines the width of the object
     * 
     * @param string $width
     */
    public final function setWidth($width) {

        $this->width = $width;
        return $this;
    }

    /**
     * A space separated list of URL's to archives. The archives contains resources relevant to the object
     * 
     * @return the $archive
     */
    public final function getArchive() {

        return $this->archive;
    }

    /**
     * Defines a class ID value as set in the Windows Registry or a URL
     * 
     * @return the $classid
     */
    public final function getClassid() {

        return $this->classid;
    }

    /**
     * Defines where to find the code for the object
     * 
     * @return the $codebase
     */
    public final function getCodebase() {

        return $this->codebase;
    }

    /**
     * The internet media type of the code referred to by the classid attribute
     * 
     * @return the $codetype
     */
    public final function getCodetype() {

        return $this->codetype;
    }

    /**
     * Defines a URL that refers to the object's data
     * 
     * @return the $data
     */
    public final function getData() {

        return $this->data;
    }

    /**
     * Defines that the object should only be declared, not created or instantiated until needed
     * 
     * @return the $declare
     */
    public final function getDeclare() {

        return $this->declare;
    }

    /**
     * Defines the height of the object
     * 
     * @return the $height
     */
    public final function getHeight() {

        return $this->height;
    }

    /**
     * Defines a text to display while the object is loading
     * 
     * @return the $standby
     */
    public final function getStandby() {

        return $this->standby;
    }

    /**
     * Defines the MIME type of data specified in the data attribute
     * 
     * @return the $type
     */
    public final function getType() {

        return $this->type;
    }

    /**
     * Specifies a URL of a client-side image map to be used with the object
     * 
     * @return the $usemap
     */
    public final function getUsemap() {

        return $this->usemap;
    }

    /**
     * Defines the width of the object
     * 
     * @return the $width
     */
    public final function getWidth() {

        return $this->width;
    }
}