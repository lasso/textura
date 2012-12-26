<?php
/**
 * The body element defines the document's body.
 * 
 * The body element contains all the contents of an HTML document, 
 * such as text, hyperlinks, images, tables, lists, etc. {@link http://www.w3schools.com/tags/tag_body.asp }
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

/**
 * The body element defines the document's body.
 * 
 * The body element contains all the contents of an HTML document, 
 * such as text, hyperlinks, images, tables, lists, etc. {@link http://www.w3schools.com/tags/tag_body.asp }
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

class Body extends Root {

    /**
     * Script to be run when a document load
     * @var string
     */
    protected $onload = "";

    /**
     * Script to be run when a document unload
     * @var string
     */
    protected $onunload = "";

    public function initElement() {
    }

    /**
     * Script to be run when a document load
     * 
     * @param string $onload
     */
    public final function setOnload($onload) {

        $this->onload = $onload;
        return $this;
    }

    /**
     * Script to be run when a document unload
     * 
     * @param string $onunload
     */
    public final function setOnunload($onunload) {

        $this->onunload = $onunload;
        return $this;
    }

    /**
     * Script to be run when a document load
     * 
     * @return the $onload
     */
    public final function getOnload() {

        return $this->onload;
    }

    /**
     * Script to be run when a document unload
     * 
     * @return the $onunload
     */
    public final function getOnunload() {

        return $this->onunload;
    }
}