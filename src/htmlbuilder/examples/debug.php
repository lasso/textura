<?php
/**
 * Debugging examples
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
use HTMLBuilder\Elements\General\Span;
use HTMLBuilder\Elements\General\Div;
use HTMLBuilder\Elements\General\Pre;
use HTMLBuilder\Elements\Lists\Ul;
use HTMLBuilder\Elements\Lists\Li;

// Register Library
require_once '../lib/Autoloader.php';
HTMLBuilder\Autoloader::register("../lib/");

$node     = new Ul();
$li_one   = new Li("Test 1", "abc");
$li_two   = new Li("Test 2", "xyz");
$li_three = new Li("XZ");
$span     = new Span("Hallo");

$li_three->insertChild($span);
$node->insertChildren($li_one, $li_two, $li_three);

$html = new Pre($node->debug());

echo $html;