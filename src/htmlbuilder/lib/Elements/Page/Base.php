<?php
/**
 * The <base> tag specifies a default address or a default target for all links on a page.
 * 
 * The <base> tag goes inside the head element. {@link http://www.w3schools.com/tags/tag_base.asp }
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
 * The <base> tag specifies a default address or a default target for all links on a page.
 * 
 * The <base> tag goes inside the head element. {@link http://www.w3schools.com/tags/tag_base.asp }
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

class Base extends Root {

    /**
     * Specifies a base URL for all relative URLs on a page.
     * <b>Note: The base URL must be an absolute URL!</b>
     * @var string
     */
    protected $href = "";

    /**
     * Specifies a base URL for all relative URLs on a page.
     * <b>Note: The base URL must be an absolute URL!</b>
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
     * Specifies a base URL for all relative URLs on a page.
     * <b>Note: The base URL must be an absolute URL!</b>
     * 
     * @return the $href
     */
    public final function getHref() {

        return $this->href;
    }

    /* (non-PHPdoc)
     * @see HTMLBuilder\Elements.Root::initElement()
     */
    public function initElement() {
    }

}