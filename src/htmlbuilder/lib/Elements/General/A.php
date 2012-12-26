<?php
/**
 * The <a> tag defines an anchor. 
 * 
 * <p>An anchor can be used in two ways:</p>
 * <ol>
 * <li>To create a link to another document, by using the href attribute</li>
 * <li>To create a bookmark inside a document, by using the name attribute</li>
 * </ol>
 * <p>The a element is usually referred to as a link or a hyperlink. 
 * The most important attribute of the a element is the href attribute, 
 * which indicates the link’s destination.</p>
 * 
 * <p>By default, links will appear as follows in all browsers:</p>
 * <ul>
 * <li>An unvisited link is underlined and blue</li>
 * <li>A visited link is underlined and purple</li>
 * <li>An active link is underlined and red</li>
 * </ul>
 * {@link http://www.w3schools.com/tags/tag_a.asp }
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
use HTMLBuilder\Elements\Attributes;
use HTMLBuilder\Elements\Root;

/**
 * The <a> tag defines an anchor. 
 * 
 * <p>An anchor can be used in two ways:</p>
 * <ol>
 * <li>To create a link to another document, by using the href attribute</li>
 * <li>To create a bookmark inside a document, by using the name attribute</li>
 * </ol>
 * <p>The a element is usually referred to as a link or a hyperlink. 
 * The most important attribute of the a element is the href attribute, 
 * which indicates the link’s destination.</p>
 * 
 * <p>By default, links will appear as follows in all browsers:</p>
 * <ul>
 * <li>An unvisited link is underlined and blue</li>
 * <li>A visited link is underlined and purple</li>
 * <li>An active link is underlined and red</li>
 * </ul>
 * {@link http://www.w3schools.com/tags/tag_a.asp }
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

class A extends Root {

    const SHAPE_RECT = "rect";

    const SHAPE_CIRCLE = "circle";

    const SHAPE_POLY = "poly";

    const SHAPE_DEFAULT = "default";

    /**
     * Specifies the character-set of a linked document
     * @var string
     */
    protected $charset = "";

    /**
     * Specifies the coordinates of a link
     * @var string
     */
    protected $coords = "";

    /**
     * Specifies the destination of a link
     * @var string
     */
    protected $href = "";

    /**
     * Specifies the language of a linked document
     * @var string
     */
    protected $hreflang = "";

    /**
     * Specifies the relationship between the current document and the linked document
     * @var string
     */
    protected $rel = "";

    /**
     * Specifies the relationship between the linked document and the current document
     * @var string
     */
    protected $rev = "";

    /**
     * Specifies the shape of a link
     * @var string
     */
    protected $shape = "";

    /**
     * Specifies where to open the linked document
     * @var string
     */
    protected $target = "";

    /**
     * Specifies the name of an anchor
     * @var string
     */
    protected $name = "";

    public function initElement() {

        $this->_isBlock = false;
        $this->_allowedChildren = self::INLINE;
    }

    /**
     * Specifies the character-set of a linked document
     * 
     * @param string $charset
     */
    public final function setCharset($charset) {

        $this->charset = $charset;
        return $this;
    }

    /**
     * Specifies the coordinates of a link
     * 
     * @param string $coords
     */
    public final function setCoords($coords) {

        $this->coords = $coords;
        return $this;
    }

    /**
     * Specifies the destination of a link
     * 
     * @param string $href
     */
    public final function setHref($href) {

        $this->href = $href;
        return $this;
    }

    /**
     * Specifies the language of a linked document
     * 
     * @param string $hreflang
     */
    public final function setHreflang($hreflang) {

        $this->hreflang = $hreflang;
        return $this;
    }

    /**
     * Specifies the relationship between the current document and the linked document
     * 
     * @param string $rel
     */
    public final function setRel($rel) {

        $this->rel = $rel;
        return $this;
    }

    /**
     * Specifies the relationship between the linked document and the current document
     * 
     * @param string $rev
     */
    public final function setRev($rev) {

        $this->rev = $rev;
        return $this;
    }

    /**
     * Specifies the shape of a link
     * 
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
     * Specifies where to open the linked document
     * 
     * @param string $target
     */
    public final function setTarget($target) {

        $this->target = $target;
        return $this;
    }

    /**
     * Specifies the name of an anchor
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
     * Specifies the character-set of a linked document
     * 
     * @return the $charset
     */
    public final function getCharset() {

        return $this->charset;
    }

    /**
     * Specifies the coordinates of a link
     * 
     * @return the $coords
     */
    public final function getCoords() {

        return $this->coords;
    }

    /**
     * Specifies the destination of a link
     * 
     * @return the $href
     */
    public final function getHref() {

        return $this->href;
    }

    /**
     * Specifies the language of a linked document
     * 
     * @return the $hreflang
     */
    public final function getHreflang() {

        return $this->hreflang;
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
     * Specifies the shape of a link
     * 
     * @return the $shape
     */
    public final function getShape() {

        return $this->shape;
    }

    /**
     * Specifies where to open the linked document
     * 
     * @return the $target
     */
    public final function getTarget() {

        return $this->target;
    }

    /**
     * Specifies the name of an anchor
     * 
     * @return the $name
     */
    public final function getName() {

        return $this->name;
    }
}