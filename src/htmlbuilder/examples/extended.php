<?php
/**
 * Extended example with try catch
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
use HTMLBuilder\Elements\General\Hr;
use HTMLBuilder\Elements\Text\P;
use HTMLBuilder\Elements\Lists\Dt;
use HTMLBuilder\Elements\Lists\Ul;
use HTMLBuilder\Elements\General\Pre;
use HTMLBuilder\Exceptions\Exception;

// Register Library
require_once '../lib/Autoloader.php';
HTMLBuilder\Autoloader::register("../lib/");

try {
    
    $unorderedList = new Ul();
    $entry         = new Dt();    
    $unorderedList->insertChild($entry);
    
} catch (Exception $e) {
    
    $msg  = "Use Exception class constants, e.g.\n\n";
    $msg .= "if(\$e-getCode() === Exception::INSERT_NOT_ALLOWED)\n\n";
    $msg .= "Get the complete message:\n" . $e->getCustomMessage();

    $output = new Pre($msg);
    
    echo $output;
}