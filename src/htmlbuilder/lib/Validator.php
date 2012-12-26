<?php
/**
 * Validator helper class
 * 
 * PHP version 5
 * 
 * @filesource
 * @category  Main
 * @package   Main
 * @author    Jens Peters <jens@history-archive.net>
 * @copyright 2011 Jens Peters
 * @license   http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @version   1.1
 * @link      http://launchpad.net/htmlbuilder
 */
namespace HTMLBuilder;

/**
 * ValidatorHelper class
 * 
 * @category Main
 * @package  Main
 * @author   Jens Peters <jens@history-archiv.net>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @link     http://launchpad.net/htmlbuilder
 */
class Validator {

    /**
     * Simple number
     * @var string
     */
    const NUMBER = "NUMBER";

    /**
     * Clean string
     * @var string
     */
    const CLEANSTRING = "CLEANSTRING";
    
    /**
     * Form element name string
     * @var string
     */
    const FORMNAME = "FORMNAME";

    /**
     * Boolean
     * @var string
     */
    const BOOLEAN = "BOOLEAN";

    /**
     * Whitelist
     * @var string
     */
    const WHITELIST = "WHITELIST";

    /**
     * Blacklist
     * @var string
     */
    const BLACKLIST = "BLACKLIST";

    /**
     * Url checker
     * @var string
     */
    const URL = "URL";

    /**
     * Validating value
     * 
     * @param string $type      Type of validation represented by the class constants
     * @param mixed  $value     The value to proof
     * @param array  $whitelist Optional: Array whitelist
     * 
     * @return boolean
     */
    public static function validateValue($type, $value, array $whitelist = array()) {

        switch($type) {

            case self::NUMBER:
                return self::_number($value);
                break;

            case self::CLEANSTRING:
                return self::_cleanString($value);
                break;
                
            case self::FORMNAME:
              	return self::_cleanString($value, true);
            break;

            case self::BOOLEAN:
                return self::_boolean($value);
                break;

            case self::WHITELIST:
                return in_array($value, $whitelist);
                break;

            case self::BLACKLIST:
                return !in_array($value, $whitelist);
                break;

            case self::URL:
                return self::_url($value);
                break;

            default:
                return self::_regex($type, $value);
                break;
        }
    }

    /**
     * Regex based validation
     * 
     * @param string $type  The regex expression
     * @param string $value What to proof
     * 
     * @return boolean
     */
    private static function _regex($type, $value) {

        $regex = "/" . $type . "/is";
        return (bool) preg_match($regex, $value);
    }

    /**
     * Validates boolean
     * 
     * @param mixed $value What to proof
     * 
     * @return boolean
     */
    private static function _boolean($value) {

        switch(true) {

            case $value === true:
            case $value === 1:
            case $value === 0:
            case $value === "true":
            case $value === "":
            case $value === false:
            case $value === "false":
                return true;
                break;

            default:
                return false;
                break;
        }
    }

    /**
     * Validating clean string, only [a-zA-Z0-9-_] are allowed
     * 
     * @param mixed $value What to proof
     * 
     * @return boolean
     */
    private static function _cleanString($value, $isFormName = false) {
    	
    	$regex = "/^[a-zA-Z0-9-_]*$/is";
    	if($isFormName) {
    		$regex = "/^[a-zA-Z0-9-_\[\]]*$/is";
    	}

        if ($value === true 
            || $value === false
            || $value === null
            || ! (bool) preg_match($regex, (string) $value)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Validating a real number
     * 
     * @param mixed $value What to proof
     * 
     * @return boolean
     */
    private static function _number($value) {

        if (preg_match("/^[0-9]+$/is", $value)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Url syntax checker
     * 
     * @param string $value What to proof
     * 
     * @return boolean
     */
    private static function _url($value) {

        return (bool) preg_match('@^(#)|(/.*)|(http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?)$@i', $value);
    }

}