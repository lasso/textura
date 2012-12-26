<?php
/**
 * The <table> tag defines an HTML table.
 * 
 * A simple HTML table consists of the table element and one or 
 * more tr, th, and td elements. The tr element defines a table 
 * row, the th element defines a table header, and the td element 
 * defines a table cell. A more complex HTML table may also include 
 * caption, col, colgroup, thead, tfoot, and tbody elements. 
 * {@link http://www.w3schools.com/tags/tag_table.asp }
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
use HTMLBuilder\Elements\Root;
use HTMLBuilder\Validator;

/**
 * The <table> tag defines an HTML table.
 * 
 * A simple HTML table consists of the table element and one or 
 * more tr, th, and td elements. The tr element defines a table 
 * row, the th element defines a table header, and the td element 
 * defines a table cell. A more complex HTML table may also include 
 * caption, col, colgroup, thead, tfoot, and tbody elements. 
 * {@link http://www.w3schools.com/tags/tag_table.asp }
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
class Table extends Root {

    const FRAME_VIOD = "void";

    const FRAME_ABOVE = "above";

    const FRAME_BELOW = "below";

    const FRAME_HSIDES = "hsides";

    const FRAME_LHS = "lhs";

    const FRAME_RHS = "rhs";

    const FRAME_VSIDES = "vsides";

    const FRAME_BOX = "box";

    const FRAME_BORDER = "border";

    const RULES_NONE = "none";

    const RULES_GROUPS = "groups";

    const RULES_ROWS = "rows";

    const RULES_COLS = "cols";

    const RULES_ALL = "all";

    /**
     * Specifies the width of the borders around a table
     * @var string
     */
    protected $border = "";

    /**
     * Specifies the space between the cell wall and the cell content
     * @var string
     */
    protected $cellpadding = "";

    /**
     * Specifies the space between cells
     * 
     * @var string
     */
    protected $cellspacing = "";

    /**
     * Specifies which parts of the outside borders that should be visible
     * @var string
     */
    protected $frame = "";

    /**
     * Specifies which parts of the inside borders that should be visible
     * @var string
     */
    protected $rules = "";

    /**
     * Specifies a summary of the content of a table
     * @var string
     */
    protected $summary = "";

    /**
     * Specifies the width of a table
     * @var string
     */
    protected $width = "";

    public function initElement() {

        $this->_allowedChildren = array (
                                        "caption",
                                        "col",
                                        "colgroup",
                                        "thead",
                                        "tfoot",
                                        "tbody"
        );
    }

    /**
     * Specifies the width of the borders around a table
     * 
     * @param string $border
     */
    public final function setBorder($border) {

        $this->border = $border;
        return $this;
    }

    /**
     * Specifies the space between the cell wall and the cell content
     * 
     * @param string $cellpadding
     */
    public final function setCellpadding($cellpadding) {

        $this->cellpadding = $cellpadding;
        return $this;
    }

    /**
     * Specifies the space between cells
     * 
     * @param string $cellspacing
     */
    public final function setCellspacing($cellspacing) {

        $this->cellspacing = $cellspacing;
        return $this;
    }

    /**
     * Specifies which parts of the outside borders that should be visible
     * 
     * @param string $frame
     */
    public final function setFrame($frame) {

        $types      = $this->_getClassConstants("^FRAME_(.*)$");
        $validators = array (
                            Validator::WHITELIST,
                            $types
        );

        if ($this->validateSetter($validators, $frame)) {
            $this->frame = $frame;
        }

        return $this;
    }

    /**
     * Specifies which parts of the inside borders that should be visible
     * 
     * @param string $rules
     */
    public final function setRules($rules) {

        $types      = $this->_getClassConstants("^RULES_(.*)$");
        $validators = array (
                            Validator::WHITELIST,
                            $types
        );

        if ($this->validateSetter($validators, $rules)) {
            $this->rules = $rules;
        }

        return $this;
    }

    /**
     * Specifies a summary of the content of a table
     * 
     * @param string $summary
     */
    public final function setSummary($summary) {

        $this->summary = $summary;
        return $this;
    }

    /**
     * Specifies the width of a table
     * 
     * @param string $width
     */
    public final function setWidth($width) {

        $this->width = $width;
        return $this;
    }

    /**
     * Specifies the width of the borders around a table
     * 
     * @return the $border
     */
    public final function getBorder() {

        return $this->border;
    }

    /**
     * Specifies the space between the cell wall and the cell content
     * 
     * @return the $cellpadding
     */
    public final function getCellpadding() {

        return $this->cellpadding;
    }

    /**
     * Specifies the space between cells
     * 
     * @return the $cellspacing
     */
    public final function getCellspacing() {

        return $this->cellspacing;
    }

    /**
     * Specifies which parts of the outside borders that should be visible
     * 
     * @return the $frame
     */
    public final function getFrame() {

        return $this->frame;
    }

    /**
     * Specifies which parts of the inside borders that should be visible
     * 
     * @return the $rules
     */
    public final function getRules() {

        return $this->rules;
    }

    /**
     * Specifies a summary of the content of a table
     * 
     * @return the $summary
     */
    public final function getSummary() {

        return $this->summary;
    }

    /**
     * Specifies the width of a table
     * 
     * @return the $width
     */
    public final function getWidth() {

        return $this->width;
    }
}