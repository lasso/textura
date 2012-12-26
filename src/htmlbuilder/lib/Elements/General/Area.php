<?php
/**
 * The <area> tag defines an area inside an image-map (an image-map is an image with clickable areas).
 *
 * The area element is always nested inside a <map> tag. <b>Note</b>: The usemap attribute in the 
 * <img> tag is associated with the map element's name attribute, and creates a relationship between 
 * the image and the map. {@link http://www.w3schools.com/tags/tag_area.asp }
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
 * The <area> tag defines an area inside an image-map (an image-map is an image with clickable areas).
 *
 * The area element is always nested inside a <map> tag. <b>Note</b>: The usemap attribute in the 
 * <img> tag is associated with the map element's name attribute, and creates a relationship between 
 * the image and the map. {@link http://www.w3schools.com/tags/tag_area.asp }
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
class Area extends Root {

    const SHAPE_RECT = "rect";

    const SHAPE_CIRCLE = "circle";

    const SHAPE_POLY = "poly";

    const SHAPE_DEFAULT = "default";

    /**
     * Specifies an alternate text for an area
     * @var string
     */
    protected $alt = "";

    /**
     * Specifies the coordinates of an area
     * @var string
     */
    protected $coords = "";

    /**
     * Specifies the destination of a link in an area
     * @var string
     */
    protected $href = "";

    /**
     * Specifies that an area has no associated link
     * @var string
     */
    protected $nohref = "";

    /**
     * Specifies the shape of an area
     * @var string
     */
    protected $shape = "";

    public function initElement() {
    }

    /**
     * Specifies the shape of an area
     * @param string $shape
     */
    public final function setShape($shape) {

        $types      = $this->_getClassConstants("^SHAPE_(.*)$");
        $validators = array (
                            Validator::WHITELIST,
                            $types
        );

        if ($this->validateSetter($validators, $shape)) {
            $this->shape = $shape;
        }

        return $this;
    }

    /**
     * Specifies an alternate text for an area
     * 
     * @param string $alt
     */
    public final function setAlt($alt) {

        $this->alt = $alt;
        return $this;
    }

    /**
     * Specifies the coordinates of an area
     * 
     * @param string $coords
     */
    public final function setCoords($coords) {

        // @TODO implement validator
        $this->coords = $coords;
        return $this;
    }

    /**
     * Specifies the destination of a link in an area
     * 
     * @param string $href
     */
    public final function setHref($href) {

        $this->href = $href;
        return $this;
    }

    /**
     * Specifies that an area has no associated link
     * 
     * @param boolean $nohref
     */
    public final function setNohref($nohref) {

        if ($this->validateSetter(Validator::BOOLEAN, $nohref)) {

            if ($nohref) {
                $this->nohref = "nohref";
            } else {
                $this->nohref = "";
            }
        }
        return $this;
    }

    /**
     * Specifies an alternate text for an area
     * 
     * @return the $alt
     */
    public final function getAlt() {

        return $this->alt;
    }

    /**
     * Specifies the coordinates of an area
     * 
     * @return the $coords
     */
    public final function getCoords() {

        return $this->coords;
    }

    /**
     * Specifies the destination of a link in an area
     * 
     * @return the $href
     */
    public final function getHref() {

        return $this->href;
    }

    /**
     * Specifies that an area has no associated link
     * 
     * @return the $nohref
     */
    public final function getNohref() {

        return $this->nohref;
    }

    /**
     * Specifies the shape of an area
     * 
     * @return the $shape
     */
    public final function getShape() {

        return $this->shape;
    }
}