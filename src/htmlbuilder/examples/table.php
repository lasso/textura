<?php
/**
 * Table helper example
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
use HTMLBuilder\RenderHelper\Table\Table;

// Register Library
require_once '../lib/Autoloader.php';
HTMLBuilder\Autoloader::register("../lib/");

// Table with optional caption
$table = new Table(4, "I am a table");
$table->setBorder(1);

$content = array (
                "Row 1.1", 
                "Row 1.2", 
                "Row 1.3", 
                "Row 1.4"
);
$table->insertBodyRow($content);

// Setting colspans
$content  = array (
                "Going over two cols", 
                "One", 
                "Two"
);
$colspans = array (
                2, 
                1, 
                1
);
$table->insertBodyRow($content, $colspans);

// Setting rowspans
$content  = array (
                "Going over three rows", 
                "Second", 
                "Third", 
                "Fourth"
);
$colspans = array ();
$table->insertBodyRow($content, $colspans, 3);

$content  = array (
                "1. Row spanned 1", 
                "1. Row spanned 2", 
                "1. Row spanned 3"
);
$colspans = array ();
$table->insertBodyRow($content, $colspans, 2, 1);

$content = array (
                "2. Row spanned 1", 
                "2. Row spanned 2"
);
$table->insertBodyRow($content);

echo $table;