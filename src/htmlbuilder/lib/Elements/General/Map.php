<?php
/**
 * The <map> tag is used to define a client-side image-map. 
 * 
 * An image-map is an image with clickable areas. The name 
 * attribute is required in the map element. This attribute 
 * is associated with the <img>'s usemap attribute and creates 
 * a relationship between the image and the map. The map element 
 * contains a number of area elements, that defines the clickable 
 * areas in the image map. {@link http://www.w3schools.com/tags/tag_map.asp }
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
 * The <map> tag is used to define a client-side image-map. 
 * 
 * An image-map is an image with clickable areas. The name 
 * attribute is required in the map element. This attribute 
 * is associated with the <img>'s usemap attribute and creates 
 * a relationship between the image and the map. The map element 
 * contains a number of area elements, that defines the clickable 
 * areas in the image map. {@link http://www.w3schools.com/tags/tag_map.asp }
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

class Map extends Root {

    /**
     * Specifies the name for an image-map
     * 
     * @var string
     */
    protected $name = "";

    /**
     * Specifies the name for an image-map
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
     * Specifies the name for an image-map
     * @return the $name
     */
    public final function getName() {

        return $this->name;
    }

    public function initElement() {

        $this->_allowedChildren = array (
                                        "area"
        );
        $this->_isBlock = false;
    }
}