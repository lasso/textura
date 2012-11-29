<?php
/**
 * The <link> tag defines the relationship between a document and an external resource.
 * 
 * The <link> tag is most used to link to style sheets. {@link http://www.w3schools.com/tags/tag_link.asp }
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
use HTMLBuilder\Elements\Root;
use HTMLBuilder\Validator;

/**
 * The <link> tag defines the relationship between a document and an external resource.
 * 
 * The <link> tag is most used to link to style sheets. {@link http://www.w3schools.com/tags/tag_link.asp }
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

class Link extends Root {

    const MEDIA_SCREEN = "screen";

    const MEDIA_TTY = "tty";

    const MEDIA_TV = "tv";

    const MEDIA_PROJECTION = "projection";

    const MEDIA_HANDHELD = "handheld";

    const MEDIA_PRINT = "print";

    const MEDIA_BRAILLE = "braille";

    const MEDIA_AURAL = "aural";

    const MEDIA_ALL = "all";

    const REL_ALTERNATE = "alternate";

    const REL_APPENDIX = "appendix";

    const REL_BOOKMARK = "bookmark";

    const REL_CHAPTER = "chapter";

    const REL_CONTENTS = "contents";

    const REL_COPYRIGHT = "copyright";

    const REL_GLOSSARY = "glossary";

    const REL_HELP = "help";

    const REL_HOME = "home";

    const REL_INDEX = "index";

    const REL_NEXT = "next";

    const REL_PREV = "prev";

    const REL_SECTION = "section";

    const REL_START = "start";

    const REL_STYLESHEET = "stylesheet";

    const REL_SUBSECTIONS = "subsection";

    /**
     * Specifies the character encoding of the linked document
     * @var string
     */
    protected $charset;

    /**
     * Specifies the location of the linked document
     * @var string
     */
    protected $href;

    /**
     * Specifies the language of the text in the linked document
     * @var string
     */
    protected $hreflang;

    /**
     * Specifies on what device the linked document will be displayed
     * @var string
     */
    protected $media;

    /**
     * Specifies the relationship between the current document and the linked document
     * @var string
     */
    protected $rel;

    /**
     * Specifies the relationship between the linked document and the current document
     * @var string
     */
    protected $rev;

    /**
     * Specifies the MIME type of the linked document
     * @var string
     */
    protected $type;

    public function initElement() {

        $this->_isSelfclosing = true;
    }

    /**
     * Specifies the character encoding of the linked document
     * 
     * @param string $charset
     */
    public final function setCharset($charset) {

        $this->charset = $charset;
        return $this;
    }

    /**
     * Specifies the location of the linked document
     * 
     * @param string $href
     */
    public final function setHref($href) {

        $validators = Validator::URL;
        if ($this->validateSetter($validators, $href)) {
            $this->href = $href;
        }
        return $this;
    }

    /**
     * Specifies the language of the text in the linked document
     * 
     * @param string $hreflang
     */
    public final function setHreflang($hreflang) {

        $this->hreflang = $hreflang;
        return $this;
    }

    /**
     * Specifies on what device the linked document will be displayed
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
     * Specifies the relationship between the current document and the linked document
     * 
     * @param string $rel
     */
    public final function setRel($rel) {

        $types      = $this->_getClassConstants("^REL_(.*)$");
        $validators = array (
                            Validator::WHITELIST,
                            $types
        );

        if ($this->validateSetter($validators, $rel)) {
            $this->rel = $rel;
        }

        return $this;
    }

    /**
     * Specifies the relationship between the linked document and the current document
     * 
     * @param string $rev
     */
    public final function setRev($rev) {

        $types      = $this->_getClassConstants("^REL_(.*)$");
        $validators = array (
                            Validator::WHITELIST,
                            $types
        );

        if ($this->validateSetter($validators, $rev)) {
            $this->rev = $rev;
        }
        return $this;
    }

    /**
     * Specifies the MIME type of the linked document
     * 
     * @param string $type
     */
    public final function setType($type) {

        $this->type = $type;
        return $this;
    }

    /**
     * Specifies the character encoding of the linked document
     * 
     * @return the $charset
     */
    public final function getCharset() {

        return $this->charset;
    }

    /**
     * Specifies the location of the linked document
     * 
     * @return the $href
     */
    public final function getHref() {

        return $this->href;
    }

    /**
     * Specifies the language of the text in the linked document
     * 
     * @return the $hreflang
     */
    public final function getHreflang() {

        return $this->hreflang;
    }

    /**
     * Specifies on what device the linked document will be displayed
     * 
     * @return the $media
     */
    public final function getMedia() {

        return $this->media;
    }

    /**
     * Specifies the relationship between the current document and the linked document
     * 
     * @return the $rel
     */
    public final function getRel() {

        return $this->rel;
    }

    /**
     * Specifies the relationship between the linked document and the current document
     * 
     * @return the $rev
     */
    public final function getRev() {

        return $this->rev;
    }

    /**
     * Specifies the MIME type of the linked document
     * 
     * @return the $type
     */
    public final function getType() {

        return $this->type;
    }
}