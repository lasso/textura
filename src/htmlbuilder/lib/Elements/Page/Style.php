<?php
/**
 * The <style> tag is used to define style information for an HTML document.
 * 
 * Inside the style element you specify how HTML elements should render in a browser.
 * The required type attribute defines the content of the style element. The only 
 * possible value is "text/css". The style element always goes inside the head section.
 * {@link http://www.w3schools.com/tags/tag_style.asp }
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
namespace HTMLBuilder\Elements\Page;
use HTMLBuilder\Elements\Root;
use HTMLBuilder\Validator;

/**
 * The <style> tag is used to define style information for an HTML document.
 * 
 * Inside the style element you specify how HTML elements should render in a browser.
 * The required type attribute defines the content of the style element. The only 
 * possible value is "text/css". The style element always goes inside the head section.
 * {@link http://www.w3schools.com/tags/tag_style.asp }
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

class Style extends Root {

    const MEDIA_SCREEN = "screen";

    const MEDIA_TTY = "tty";

    const MEDIA_TV = "tv";

    const MEDIA_PROJECTION = "projection";

    const MEDIA_HANDHELD = "handheld";

    const MEDIA_PRINT = "print";

    const MEDIA_BRAILLE = "braille";

    const MEDIA_AURAL = "aural";

    const MEDIA_ALL = "all";

    /**
     * Specifies the MIME type of the style sheet
     * @var fixed
     */
    protected $type = "";

    /**
     * Specifies styles for different media types
     * @var unknown_type
     */
    protected $media = "";

    public function initElement() {
    }

    /**
     * Specifies styles for different media types
     * 
     * @param string $media
     */
    public final function setMedia($media) {

        $types      = $this->_getClassConstants("^MEDIA_(.*)$");
        $validators = array (
                            Validator::WHITELIST,
                            $types
        );

        if ($this->validateSetter($validators, $media)) {
            $this->media = $media;
        }

        return $this;
    }

    /**
     * Specifies the MIME type of the style sheet
     * 
     * @param boolean $type
     */
    public final function setType($type) {

        $validators = array (
                            Validator::WHITELIST,
                            array (
                                "text/css"
                            )
        );

        if ($this->validateSetter($validators, $type)) {
            $this->type = $type;
        }

        return $this;
    }

    /**
     * Specifies styles for different media types
     * 
     * @return the $media
     */
    public final function getMedia() {

        return $this->media;
    }

    /**
     * Specifies the MIME type of the style sheet
     * 
     * @return the $type
     */
    public final function getType() {

        return $this->type;
    }
}