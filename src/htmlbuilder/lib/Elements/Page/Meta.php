<?php
/**
 * Metadata is information about data.
 * 
 * The <meta> tag provides metadata about the HTML document. Metadata will 
 * not be displayed on the page, but will be machine parsable. Meta elements 
 * are typically used to specify page description, keywords, author of the 
 * document, last modified, and other metadata. The <meta> tag always goes 
 * inside the head element. The metadata can be used by browsers (how to 
 * display content or reload page), search engines (keywords), or other web services.
 * {@link http://www.w3schools.com/tags/tag_meta.asp }
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
 * Metadata is information about data.
 * 
 * The <meta> tag provides metadata about the HTML document. Metadata will 
 * not be displayed on the page, but will be machine parsable. Meta elements 
 * are typically used to specify page description, keywords, author of the 
 * document, last modified, and other metadata. The <meta> tag always goes 
 * inside the head element. The metadata can be used by browsers (how to 
 * display content or reload page), search engines (keywords), or other web services.
 * {@link http://www.w3schools.com/tags/tag_meta.asp }
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

class Meta extends Root {

    const HTTPEQUIV_CONTENT_TYPE = "content-type";

    const HTTPEQUIV_CONTENT_STYLE_TYPE = "content-style-type";

    const HTTPEQUIV_EXPIRES = "expires";

    const HTTPEQUIV_SET_COOKIE = "set-cookie";

    const HTTPEQUIV_OTHERS = "others";

    const NAME_AUTHOR = "author";

    const NAME_DESCRIPTION = "description";

    const NAME_KEYWORDS = "keywords";

    const NAME_GENERATOR = "generator";

    const NAME_REVISED = "revised";

    const NAME_OTHERS = "others";

    /**
     * Specifies the content of the meta information
     * @var string
     */
    protected $content;

    /**
     * Provides an HTTP header for the information in the content attribute
     * @var string
     */
    protected $http_equiv;

    /**
     * Specifies a scheme to be used to interpret the value of the content attribute
     * @var string
     */
    protected $scheme;

    /**
     * Provides a name for the information in the content attribute
     * @var string
     */
    protected $name = "";

    /**
     * Provides a name for the information in the content attribute
     * 
     * @param string $name
     */
    public final function setName($name) {

        $types      = $this->_getClassConstants("^NAME_(.*)$");
        $validators = array (
                            Validator::WHITELIST,
                            $types
        );

        if ($this->validateSetter($validators, $name)) {
            $this->name = $name;
        }
        return $this;
    }

    /**
     * Provides a name for the information in the content attribute
     * 
     * @return the $name
     */
    public final function getName() {

        return $this->name;
    }

    public function initElement() {

        $this->_isSelfclosing = true;
    }

    /**
     * Specifies the content of the meta information
     * 
     * @param string $content
     */
    public function setContent($content) {

        $this->content = $content;
        return $this;
    }

    /**
     * Provides an HTTP header for the information in the content attribute
     * 
     * @param string $http_equiv
     */
    public final function setHttp_equiv($http_equiv) {

        $types      = $this->_getClassConstants("^HTTPEQUIV_(.*)$");
        $validators = array (
                            Validator::WHITELIST,
                            $types
        );

        if ($this->validateSetter($validators, $http_equiv)) {
            $this->http_equiv = $http_equiv;
        }

        return $this;
    }

    /**
     * Specifies a scheme to be used to interpret the value of the content attribute
     * 
     * @param string $scheme
     */
    public final function setScheme($scheme) {

        $this->scheme = $scheme;
        return $this;
    }

    /**
     * Specifies the content of the meta information
     * 
     * @return the $content
     */
    public function getContent() {

        return $this->content;
    }

    /**
     * Provides an HTTP header for the information in the content attribute
     * 
     * @return the $http_equiv
     */
    public final function getHttp_equiv() {

        return $this->http_equiv;
    }

    /**
     * Specifies a scheme to be used to interpret the value of the content attribute
     * 
     * @return the $scheme
     */
    public final function getScheme() {

        return $this->scheme;
    }
}