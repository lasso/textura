<?php
/**
 * Smarty example
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
require_once 'Smarty/libs/Smarty.class.php';
require_once '../lib/Autoloader.php';
use HTMLBuilder\ext\TemplatingEngines\SmartyFunctions as Engine;

// Init Smarty
$smarty = new Smarty();
$smarty->force_compile  = true;
$smarty->debugging      = false;
$smarty->caching        = false;
$smarty->cache_lifetime = 120;
$smarty->setTemplateDir("..");
$smarty->setCompileDir("../temp/templates_c/");

// Register Library, extension dir contains custom Smarty library
HTMLBuilder\Autoloader::register("../lib/", "../ext/");

// List arrays
$simple   = array("Test1", "Test2", "Test3");
$extended = array("Look at source code to see attributes.");
$builder  = new Engine($smarty);

$smarty->assign("simple", $simple);
$smarty->assign("extended", $extended);

$smarty->display(__DIR__ . '/smarty.tpl');
