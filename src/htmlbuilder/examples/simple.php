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

// 2. styled paragraph
$style = array (
    "color" => "red", 
    "margin-top" => "0.5em",
    "margin-bottom" => "0.5em");

$node2 = new P();
$node2->setStyle($style);
$node2->setInnerHTML("I am a styled paragraph element");

// 3. nested elements
$node3 = new Ul();
$li1   = new Li("Test 1", "css-class-goes-here");
$li2   = new Li("Test 2");
$li3   = new Li("Test 3");

$ul = new Ul();
$l1 = new Li("Nested 1");
$l2 = new Li("Nested 2");
$ul->insertChildren($l1, $l2);

$li3->insertChildren($ul);
$node3->insertChildren($li1, $li2, $li3);

echo $node1;
echo $node2;
echo $node3;