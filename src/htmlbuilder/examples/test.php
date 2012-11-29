<?php
/**
 * Simple examples
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
use HTMLBuilder\Elements\General\Div;
use HTMLBuilder\Elements\General\Span;
use HTMLBuilder\Elements\Text\P;
use HTMLBuilder\Elements\Lists\Ul;
use HTMLBuilder\Elements\Lists\Li;

// Register Library
require_once '../lib/Autoloader.php';
HTMLBuilder\Autoloader::register("../lib/");

// 1. simple div
$node1 = new Div();
$node1->setInnerHTML("I am an block element");
$node1->setId("iamanid");

echo $node1["id"];