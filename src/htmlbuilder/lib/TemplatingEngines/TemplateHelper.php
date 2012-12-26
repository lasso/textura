<?php
/**
 * Abstract class for template engine helpers
 * 
 * PHP version 5
 * 
 * @filesource
 * @category  TemplatingEngines
 * @package   TemplatingEngines
 * @author    Jens Peters <jens@history-archive.net>
 * @copyright 2011 Jens Peters
 * @license   http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @version   1.1
 * @link      http://launchpad.net/htmlbuilder
 */
namespace HTMLBuilder\TemplatingEngines;

/**
 * Abstract class for template engine helpers
 *
 * @category TemplatingEngines
 * @package  TemplatingEngines
 * @author   Jens Peters <jens@history-archiv.net>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @link     http://launchpad.net/htmlbuilder
 */
abstract class TemplateHelper {

    /**
     * The templating engine
     * @var mixed
     */
    protected $engine;

    /**
     * Registers a builder function to templates
     * 
     * @param string $name Name of the function
     * @param string $type (optional) Function or modifier
     * 
     * @abstract     
     * 
     * @return void
     */
    abstract protected function _registerFunction($name, $type = "function");
}