<?php
/**
 * Custom html rendering exeption 
 * 
 * PHP version 5
 * 
 * @filesource
 * @category  Exception
 * @package   Exception
 * @author    Jens Peters <jens@history-archive.net>
 * @copyright 2011 Jens Peters
 * @license   http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @version   1.1
 * @link      http://launchpad.net/htmlbuilder
 */
namespace HTMLBuilder\Exceptions;

/**
 * Custom html rendering exeption
 * 
 * @category Exception
 * @package  Exception
 * @author   Jens Peters <jens@history-archiv.net>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @link     http://launchpad.net/htmlbuilder
 */
class Exception extends \Exception {

    private $errorCodes = array ();

    private $codeText = "";

    const UNKNOWN = 0;

    const UNSUPPORTED_ARGUMENT = 1;

    const VALUE_NOT_ALLOWED = 2;

    const PROPERTY_NOT_KNOWN = 3;

    const MANDATORY_TAG_MISSING = 4;

    const HTML_TYPE_NOTFOUND = 5;

    const DEPRECATED_TAG = 6;

    const INSERT_NOT_ALLOWED = 7;

    const NOT_ALLOWED_CORE_ATTR = 8;

    const NOT_ALLOWED_EVENT = 9;

    /**
     * Constructor
     * 
     * @param string $message The error message
     * @param int    $code    Error code see class constants
     */
    public function __construct($message, $code = 0) {

        $this->errorCodes[self::UNKNOWN]               = "UNKNOWN";
        $this->errorCodes[self::UNSUPPORTED_ARGUMENT]  = "UNSUPPORTED_ARGUMENT";
        $this->errorCodes[self::VALUE_NOT_ALLOWED]     = "VALUE_NOT_ALLOWED";
        $this->errorCodes[self::PROPERTY_NOT_KNOWN]    = "PROPERTY_NOT_KNOWN";
        $this->errorCodes[self::MANDATORY_TAG_MISSING] = "MANDATORY_TAG_MISSING";
        $this->errorCodes[self::HTML_TYPE_NOTFOUND]    = "HTML_TYPE_NOTFOUND";
        $this->errorCodes[self::DEPRECATED_TAG]        = "DEPRECATED_TAG";
        $this->errorCodes[self::INSERT_NOT_ALLOWED]    = "INSERT_NOT_ALLOWED";
        $this->errorCodes[self::NOT_ALLOWED_CORE_ATTR] = "NOT_ALLOWED_CORE_ATTR";
        $this->errorCodes[self::NOT_ALLOWED_EVENT]     = "NOT_ALLOWED_EVENT";

        $this->codeText = $this->errorCodes[$code];

        parent::__construct($message, $code);
    }

    /**
     * Getting custom messages
     * 
     * @return string custom error message
     */
    public function getCustomMessage() {

        return "[" . $this->getCode() . ":" . $this->codeText . "]\n" . $this->getMessage();
    }
}