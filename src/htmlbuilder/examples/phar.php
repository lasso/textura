<?php
/**
 * Phar example
 * 
 * PHP version 5
 * 
 * @filesource
 * @category  Examples
 * @package   Examples
 * @author    Jens Peters <jens@history-archive.net>
 * @copyright 2011 Jens Peters
 * @license   http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @version   ##VERSION##
 * @link      http://launchpad.net/htmlbuilder
 */
// $pharlib = "phar://##PATH##/HTMLBuilder.phar";
// require_once $pharlib;
// HTMLBuilder\Autoloader::register($pharlib);

use HTMLBuilder\Elements\General;

$node = new General\Div();
$node->setInnerHTML("I am an block element");

echo $node;