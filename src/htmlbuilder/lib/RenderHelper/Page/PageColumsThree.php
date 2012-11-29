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
use HTMLBuilder\Elements\General\Div;
use HTMLBuilder\Elements\Page\Base;
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
class PageColumsThree extends Page {

    /**
     * Page header
     * @var Div
     */
    protected $header;

    /**
     * Left div container
     * @var Div
     */
    protected $containerLeft;

    /**
     * Center div container
     * @var Div
     */
    protected $containerCenter;

    /**
     * Right div container
     * @var Div
     */
    protected $containerRight;

    /**
     * Page footer
     * @var Div
     */
    protected $footer;

    /* (non-PHPdoc)
     * @see HTMLBuilder\Renderer.Page::init()
     */
    public function init($title, $description, $keywords = "", $url = "") {

        parent::init($title, $description, $keywords, $url);

        $this->header          = new Div(null, "header");
        $this->containerLeft   = new Div(null, "left");
        $this->containerCenter = new Div(null, "center");
        $this->containerRight  = new Div(null, "right");
        $this->footer          = new Div(null, "footer");

        $style = array("clear" => "both");

        $this->setContainerWidths();
        $this->footer->setStyle($style);

        $this->body->insertChildren($this->header, $this->containerLeft, $this->containerCenter, $this->containerRight, $this->footer);
    }

    /**
     * Setting container widths
     * @param string $width1
     * @param string $width2
     * @param string $width3
     */
    public function setContainerWidths($width1 = "20em", $width2 = "29em", $width3 = "auto") {

        $float1 = array (
                        "float" => "left",
                        "width" => $width1
        );
        $float2 = array (
                        "float" => "left",
                        "width" => $width2
        );
        $float3 = array (
                        "float" => "left",
                        "width" => $width3
        );

        $this->containerLeft->setStyle($float1);
        $this->containerCenter->setStyle($float2);
        $this->containerRight->setStyle($float3);
    }

    /**
     * @param Div $header
     */
    public final function addToHeader(Root $header) {

        $this->header->insertChild($header);
        return $this;
    }

    /**
     * @param Root $containerLeft
     */
    public final function addToContainerLeft(Root $containerLeft) {

        $this->containerLeft->insertChild($containerLeft);
        return $this;
    }

    /**
     * @param Root $containerCenter
     */
    public final function addToContainerCenter(Root $containerCenter) {

        $this->containerCenter->insertChild($containerCenter);
        return $this;
    }

    /**
     * @param Root $containerRight
     */
    public final function addToContainerRight(Root $containerRight) {

        $this->containerRight->insertChild($containerRight);
        return $this;
    }

    /**
     * @param Root $footer
     */
    public final function addToFooter(Root $footer) {

        $this->footer->insertChild($footer);
        return $this;
    }

    /**
     * @return the $header
     */
    public final function getHeader() {

        return $this->header;
    }

    /**
     * @return the $containerLeft
     */
    public final function getContainerLeft() {

        return $this->containerLeft;
    }

    /**
     * @return the $containerCenter
     */
    public final function getContainerCenter() {

        return $this->containerCenter;
    }

    /**
     * @return the $containerRight
     */
    public final function getContainerRight() {

        return $this->containerRight;
    }

    /**
     * @return the $footer
     */
    public final function getFooter() {

        return $this->footer;
    }
}