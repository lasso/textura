<?php
/**
 * The <img> tag embeds an image in an HTML page.
 * 
 * Notice that images are not technically inserted into an 
 * HTML page, images are linked to HTML pages. The <img> 
 * tag creates a holding space for the referenced image.
 * The <img> tag has two required attributes: src and alt.
 * {@link http://www.w3schools.com/tags/tag_img.asp }
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
 * The <img> tag embeds an image in an HTML page.
 * 
 * Notice that images are not technically inserted into an 
 * HTML page, images are linked to HTML pages. The <img> 
 * tag creates a holding space for the referenced image.
 * The <img> tag has two required attributes: src and alt.
 * {@link http://www.w3schools.com/tags/tag_img.asp }
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

class Img extends Root {

    /**
     * Specifies the height of an image
     * @var string
     */
    protected $height = "";

    /**
     * Specifies an image as a server-side image-map
     * @var fixed
     */
    protected $ismap = "";

    /**
     * Specifies the URL to a document that contains a long description of an image
     * @var string
     */
    protected $longdesc = "";

    /**
     * Specifies an alternate text for an image
     * @var string
     */
    protected $alt = "";

    /**
     * Specifies the URL of an image
     * @var string
     */
    protected $src = "";

    /**
     * Specifies an image as a client-side image-map
     * @var string
     */
    protected $usemap = "";

    /**
     * Specifies the width of an image
     * @var string
     */
    protected $width = "";

    /**
     * Script to be run when loading of an image is interrupted
     * @var string
     */
    protected $onabort = "";

    public function initElement() {

        $this->_isBlock       = false;
        $this->_isSelfclosing = true;
    }

    /**
     * Specifies the height of an image
     * 
     * @param string $height
     */
    public final function setHeight($height) {

        $this->height = $height;
        return $this;
    }

    /**
     * Specifies an image as a server-side image-map
     * 
     * @param boolean $ismap
     */
    public final function setIsmap($ismap) {

        if ($this->validateSetter(Validator::BOOLEAN, $ismap)) {

            if ($ismap) {
                $this->ismap = "ismap";
            } else {
                $this->ismap = "";
            }
        }
        return $this;
    }

    /**
     * Specifies the URL to a document that contains a long description of an image
     * 
     * @param string $longdesc
     */
    public final function setLongdesc($longdesc) {

        $validators = Validator::URL;
        if ($this->validateSetter($validators, $longdesc)) {
            $this->longdesc = $longdesc;
        }
        return $this;
    }

    /**
     * Specifies the URL of an image
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
     * Specifies an image as a client-side image-map
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
     * Specifies the width of an image
     * 
     * @param string $width
     */
    public final function setWidth($width) {

        $this->width = $width;
        return $this;
    }

    /**
     * Script to be run when loading of an image is interrupted
     * 
     * @param string $onabort
     */
    public final function setOnabort($onabort) {

        $this->onabort = $onabort;
        return $this;
    }

    /**
     * Specifies an alternate text for an image
     * 
     * @param string $alt
     */
    public final function setAlt($alt) {

        $this->alt = $alt;
        return $this;
    }

    /**
     * Specifies the height of an image
     * 
     * @return the $height
     */
    public final function getHeight() {

        return $this->height;
    }

    /**
     * Specifies an image as a server-side image-map
     * 
     * @return the $ismap
     */
    public final function getIsmap() {

        return $this->ismap;
    }

    /**
     * Specifies the URL to a document that contains a long description of an image
     * 
     * @return the $longdesc
     */
    public final function getLongdesc() {

        return $this->longdesc;
    }

    /**
     * Specifies the URL of an image
     * 
     * @return the $src
     */
    public final function getSrc() {

        return $this->src;
    }

    /**
     * Specifies an image as a client-side image-map
     * 
     * @return the $usemap
     */
    public final function getUsemap() {

        return $this->usemap;
    }

    /**
     * Specifies the width of an image
     * 
     * @return the $width
     */
    public final function getWidth() {

        return $this->width;
    }

    /**
     * Script to be run when loading of an image is interrupted
     * 
     * @return the $onabort
     */
    public final function getOnabort() {

        return $this->onabort;
    }

    /**
     * Specifies an alternate text for an image
     * 
     * @return the $alt
     */
    public final function getAlt() {

        return $this->alt;
    }
}