<?php
/**
 * Common cell attributes
 * 
 * PHP version 5
 * 
 * @example   simple.php How to use
 * @filesource
 * @category  Element
 * @package   Elements
 * @author    Jens Peters <jens@history-archive.net>
 * @copyright 2011 Jens Peters
 * @license   http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @version   1.1
 * @link      http://launchpad.net/htmlbuilder
 */
namespace HTMLBuilder\Elements\Table;
use HTMLBuilder\Validator;

/**
 * Common cell attributes
 * 
 * @category   Element
 * @example    simple.php see HOW TO USE
 * @example    debug.php see HOW TO DEBUG
 * @package    Elements
 * @subpackage General
 * @author     Jens Peters <jens@history-archiv.net>
 * @license    http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @link       http://launchpad.net/htmlbuilder
 */
abstract class RootCell extends RootRow {

    const SCOPE_ROW = "row";

    const SCOPE_COL = "col";

    const SCOPE_ROWGROUP = "rowgroup";

    const SCOPE_COLGROUP = "colgroup";

    protected $abbr = "";

    protected $axis = "";

    protected $colspan = "";

    protected $headers = "";

    protected $rowspan = "";

    protected $scope = "";

    /**
     * @param string $abbr
     */
    public final function setAbbr($abbr) {

        $this->abbr = $abbr;
        return $this;
    }

    /**
     * @param string $axis
     */
    public final function setAxis($axis) {

        $this->axis = $axis;
        return $this;
    }

    /**
     * @param string $colspan
     */
    public final function setColspan($colspan) {

        $validators = Validator::NUMBER;

        if ($this->validateSetter($validators, $colspan)) {
            $this->colspan = $colspan;
        }

        return $this;
    }

    /**
     * @param string $headers
     */
    public final function setHeaders($headers) {

        $this->headers = $headers;
        return $this;
    }

    /**
     * @param string $rowspan
     */
    public final function setRowspan($rowspan) {

        $validators = Validator::NUMBER;

        if ($this->validateSetter($validators, $rowspan)) {
            $this->rowspan = $rowspan;
        }

        return $this;
    }

    /**
     * @param string $scope
     */
    public final function setScope($scope) {

        $types      = $this->_getClassConstants("^SCOPE_(.*)$");
        $validators = array (
                            Validator::WHITELIST,
                            $types
        );

        if ($this->validateSetter($validators, $scope)) {
            $this->scope = $scope;
        }

        return $this;
    }

    /**
     * @return the $abbr
     */
    public final function getAbbr() {

        return $this->abbr;
    }

    /**
     * @return the $axis
     */
    public final function getAxis() {

        return $this->axis;
    }

    /**
     * @return the $colspan
     */
    public final function getColspan() {

        return $this->colspan;
    }

    /**
     * @return the $headers
     */
    public final function getHeaders() {

        return $this->headers;
    }

    /**
     * @return the $rowspan
     */
    public final function getRowspan() {

        return $this->rowspan;
    }

    /**
     * @return the $scope
     */
    public final function getScope() {

        return $this->scope;
    }
}