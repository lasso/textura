<?php
/**
 * Page renderer can be used to render a complete html page
 * 
 * PHP version 5
 * 
 * @filesource
 * @category  RenderHelper
 * @package   RenderHelper
 * @author    Jens Peters <jens@history-archive.net>
 * @copyright 2011 Jens Peters
 * @license   http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @version   1.0
 * @link      http://launchpad.net/htmlbuilder
 */
namespace HTMLBuilder\RenderHelper\Page;
use HTMLBuilder\RenderHelper\RenderBase;
use HTMLBuilder\Elements\Page\Script;
use HTMLBuilder\Elements\Page\Link;
use HTMLBuilder\Elements\Page\Base;
use HTMLBuilder\Elements\Page\Meta;
use HTMLBuilder\Elements\Page\Html;
use HTMLBuilder\Elements\Page\Body;
use HTMLBuilder\Elements\Page\Head;
use HTMLBuilder\Elements\Page\Title;
use HTMLBuilder\Elements\Root;

/**
 * Page renderer can be used to render a complete html page
 *
 * @category   RenderHelper
 * @package    RenderHelper
 * @subpackage Page
 * @author     Jens Peters <jens@history-archiv.net>
 * @license    http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @link       http://launchpad.net/htmlbuilder
 */
class Page extends RenderBase {

    /**
     * Page doctype
     * @var string
     */
    protected $doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';

    /**
     * Html html
     * @var Html
     */
    protected $html;

    /**
     * Html head
     * @var Head
     */
    protected $head;

    /**
     * Array containing css files
     * @var array
     */
    protected $css = array ();

    /**
     * Array containing javascript files
     * @var array
     */
    protected $javascript = array ();

    /**
     * Html body
     * @var Body
     */
    protected $body;

    /**
     * Constructor
     */
    public function __construct() {

        $this->html = new Html();
        $this->head = new Head();
        $this->body = new Body();
    }

    /**
     * Initialize class
     * 
     * @param string $title 	  Page title
     * @param string $description Page description
     * @param string $keywords	  Page keywords (optional)
     * @param string $url 		  Page url (optional)
     * 
     * @return void
     */
    public function init($title, $description, $keywords = "", $url = "") {

        $title = new Title($title);

        $description1 = new Meta();
        $description1->setName("description")->setContent($description);

        if ($url == "") {
            $url = "http://" . $_SERVER["HTTP_HOST"];
        }
        $base = new Base();
        $base->setHref($url);

        $this->head->insertChildren($title, $description1, $base);

        if ($keywords != "") {
            $keywords1 = new Meta();
            $keywords1->setName("keywords")->setContent($keywords);
            $this->head->insertChild($keywords1);
        }
    }

    /**
     * Render page
     * 
     * @return void
     */
    public function render() {

        foreach ($this->css as $css) {

            $link = new Link();
            $link->setType("text/css")->setRel(Link::REL_STYLESHEET)->setHref($css);

            $this->head->insertChildren($link);
        }

        foreach ($this->javascript as $js) {

            $script = new Script();
            $script->setSrc($js)->setType("text/javascript");

            $this->head->insertChildren($link);
        }

        $this->html->insertChildren($this->head, $this->body);

        echo $this->doctype . "\n";
        echo $this->html . "\n";
    }

    /**
     * Setter for head
     * 
     * @param Head $head HTML Head Element
     * 
     * @return $this
     */
    public function setHead(Head $head) {

        $this->head = $head;

        return $this;
    }

    /**
     * Setter for body
     * 
     * @param Body $body HTML Body Element
     * 
     * @return $this
     */
    public function setBody(Body $body) {

        $this->body = $body;

        return $this;
    }

    /**
     * Adder for head
     * 
     * @param Root $element Element
     * 
     * @return $this
     */
    public function addHead(Root $element) {

        $this->head->insertChild($element);
        return $this;
    }

    /**
     * Adder for body
     * 
     * @param Root $element Element
     * 
     * @return $this
     */
    public function addBody(Root $element) {

        $this->body->insertChild($element);
        return $this;
    }

    /**
     * Setting css files array
     * 
     * @param array $css
     * 
     * @return Page This object
     */
    public final function setCss(array $css) {

        $this->css = $css;
        return $this;
    }

    /**
     * Setting javascript files
     * 
     * @param array $javascript
     * 
     * @return Page This object
     */
    public final function setJavascript(array $javascript) {

        $this->javascript = $javascript;
        return $this;
    }

    /**
     * Adding css files
     * 
     * @param array $css
     * 
     * @return Page This object
     */
    public final function addCss($css) {

        $this->css[] = $css;
        return $this;
    }

    /**
     * Adding javascript files
     * 
     * @param array $javascript
     * 
     * @return Page This object
     */
    public final function addJavascript($javascript) {

        $this->javascript[] = $javascript;
        return $this;
    }
}