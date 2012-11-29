<?php
/**
 * Common helper functions
 * 
 * PHP version 5
 * 
 * @example   simple.php How to use
 * @filesource
 * @category  Main
 * @package   Main
 * @author    Jens Peters <jens@history-archive.net>
 * @copyright 2011 Jens Peters
 * @license   http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @version   1.0
 * @link      http://launchpad.net/htmlbuilder
 */
namespace HTMLBuilder;

/**
 * Common helper functions
 * 
 * @category Main
 * @package  Main
 * @author   Jens Peters <jens@history-archiv.net>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @link     http://launchpad.net/htmlbuilder
 */
class HelperFunctions
{
    public static function isAssociative(array $array)
    {
        return ($array !== array_values($array));
    }
}