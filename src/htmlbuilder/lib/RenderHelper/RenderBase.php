<?php
/**
 * RenderBase renderer blueprint
 * 
 * PHP version 5
 * 
 * @filesource
 * @category  RenderHelper
 * @package   RenderHelper
 * @author    Jens Peters <jens@history-archive.net>
 * @copyright 2011 Jens Peters
 * @license   http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @version   1.1
 * @link      http://launchpad.net/htmlbuilder
 */
namespace HTMLBuilder\RenderHelper;

/**
 * RenderBase renderer blueprint
 *
 * @category RenderHelper
 * @package  RenderHelper
 * @author   Jens Peters <jens@history-archiv.net>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @link     http://launchpad.net/htmlbuilder
 */
abstract class RenderBase {

    /**
     * Render method
     *
     * @return string
     */
    abstract public function render();

    /**
     * Magical toString calling render method
     * 
     * @return void
     */
    public function __toString() {

        return $this->render();
    }
}