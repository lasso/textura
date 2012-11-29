<?php
/**
 * Table renderer can be used to render a table
 * 
 * PHP version 5
 * 
 * @filesource
 * @category  RenderHelper
 * @package   RenderHelper
 * @author    Jens Peters <jens@history-archive.net>
 * @copyright 2011 Jens Peters
 * @license   http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @version   1.0
 * @link      http://launchpad.net/htmlbuilder
 */
namespace HTMLBuilder\RenderHelper\Table;
use HTMLBuilder\Exceptions\Exception;
use HTMLBuilder\RenderHelper\RenderBase;
use HTMLBuilder\Elements\Table as TableElements;

/**
 * Table renderer can be used to render a table
 *
 * @category   RenderHelper
 * @package    RenderHelper
 * @subpackage Table
 * @author     Jens Peters <jens@history-archiv.net>
 * @license    http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @link       http://launchpad.net/htmlbuilder
 */
class Table extends RenderBase {

    /**
     * The table object
     * @var TableElements\Table
     */
    protected $table;

    /**
     * Number of table colums
     * @var int
     */
    protected $noOfColums = 0;

    /**
     * The table head objects
     * @var array
     */
    protected $thead = array ();

    /**
     * The table body objects
     * @var array
     */
    protected $tbody = array ();

    /**
     * The table foot objects
     * @var array
     */
    protected $tfoot = array ();

    /**
     * Helper variable to get the last inserted rowspans
     * @var array
     */
    protected $lastRowspan = array (
                                    "head" => array (),
                                    "body" => array (),
                                    "foot" => array ()
    );

    /**
     * Helper variable to count open head rowspan
     * @var array
     */
    protected $lastRowspanCounter = array (
                                        "head" => array (),
                                        "body" => array (),
                                        "foot" => array ()
    );

    /**
     * Constructor
     * 
     * @param $noOfColums Number of table colum 
     * @param $caption    Table caption
     */
    public function __construct($noOfColums, $caption = null) {

        $this->noOfColums = $noOfColums;
        $this->table      = new TableElements\Table();

        if (isset($caption)) {
            $caption = new TableElements\Caption($caption);
            $this->table->insertChild($caption);
        }
    }

    /**
     * Setting table border
     * 
     * @param int $border
     * 
     * @return $this fluent interface
     */
    public function setBorder($border) {

        $this->table->setBorder($border);
        return $this;
    }

    /**
     * Insert row to table head
     *
     * @param array $row        Array containing the row values, if associated array the key are the cell id
     * @param array $colspan    Set colspans of the row
     * @param int   $rowspan    Set rowspan of the row
     * @param int   $rowspanPos Column position of the rowspan
     * 
     * @return $this fluent interface
     */
    public function insertHeadRow(array $row, array $colspan = array(), $rowspan = 0, $rowspanPos = 0) {

        $this->_insertRow("body", $row, $colspan, $rowspan, $rowspanPos);
        return $this;
    }

    /**
     * Insert row to table body
     *
     * @param array $row        Array containing the row values, if associated array the key are the cell id
     * @param array $colspan    Set colspans of the row
     * @param int   $rowspan    Set rowspan of the row
     * @param int   $rowspanPos Column position of the rowspan
     * 
     * @return $this fluent interface
     */
    public function insertBodyRow(array $row, array $colspan = array(), $rowspan = 0, $rowspanPos = 0) {

        $this->_insertRow("body", $row, $colspan, $rowspan, $rowspanPos);
        return $this;
    }

    /**
     * Insert row to table foot
     *
     * @param array $row        Array containing the row values, if associated array the key are the cell id
     * @param array $colspan    Set colspans of the row
     * @param int   $rowspan    Set rowspan of the row
     * @param int   $rowspanPos Column position of the rowspan
     * 
     * @return $this fluent interface
     */
    public function insertFootRow(array $row, array $colspan = array(), $rowspan = 0, $rowspanPos = 0) {

        $this->_insertRow("body", $row, $colspan, $rowspan, $rowspanPos);
        return $this;
    }

    /**
     * Insert row to table
     *
     * @param string $where      Head / Body / Foot
     * @param array  $row        Array containing the row values, if associated array the key are the cell id
     * @param array  $colspan    Set colspans of the row
     * @param int    $rowspan    Set rowspan of the row
     * @param int    $rowspanPos Column position of the rowspan
     * 
     * @throws Exception if inseting is not allowed
     * 
     * @return $this fluent interface
     */
    private function _insertRow($where, array $row, array $colspan = array(), $rowspan = 0, $rowspanPos = 0) {

        // @TODO simplify, own Exception
        $colspans = count($colspan);
        if ($colspans > 0 && count($row) != $colspans) {
            throw new Exception(sprintf('Number of columns: %1$s does not match colspans: %2$s', count($row), $colspans));
        }

        $rowElm     = new TableElements\Tr();
        $counter = 0;
        foreach ($row as $key => $value) {

            if (count($colspan) == 0 && isset($this->lastRowspan[$where][$counter]) && $this->lastRowspan[$where][$counter] == 0 && count($row) != $this->noOfColums) {
                throw new Exception(sprintf('Number of columns: %1$s does not match initial value: %2$s', count($row), $this->noOfColums));
            }

            if (isset($this->lastRowspan[$where][$counter]) && $counter == $rowspanPos && $this->lastRowspan[$where][$counter] > 0) {

                if ($this->lastRowspan[$where][$counter] > 0 && $rowspan != 0) {
                    throw new Exception(sprintf('Rowspan already open!'));
                }

                $openSpans = 0;
                foreach ($this->lastRowspan[$where] as $span) {
                    if ($span != 0) {
                        $openSpans++;
                    }
                }

                $diff = ($this->noOfColums - $openSpans);
                if (count($row) != $diff) {
                    throw new Exception(sprintf('Cannot insert %1$s columns while rowspan is opened, insert exactly %2$s', count($row), $diff));
                }

                if (($this->lastRowspanCounter[$where][$counter] - 2) == 0) {
                    $this->lastRowspan[$where][$counter]        = 0;
                    $this->lastRowspanCounter[$where][$counter] = 0;
                }

                $this->lastRowspanCounter[$where][$counter] = ($this->lastRowspanCounter[$where][$counter] - 1);
            }

            $td = new TableElements\Td($value);

            if (isset($colspan[$counter]) && $colspan[$counter] != 1) {
                $td->setColspan($colspan[$counter]);
            }

            if (!preg_match("/[0-9]*/is", $key)) {
                $td->setId($key);
            }

            if ($rowspan != 0 && $counter == $rowspanPos) {
                $td->setRowspan($rowspan);
                $this->lastRowspan[$where][$counter]        = $rowspan;
                $this->lastRowspanCounter[$where][$counter] = $rowspan;
                $rowspan = 0;
            }

            $rowElm->insertChild($td);
            $counter++;
        }
        $this->tbody[] = $rowElm;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see HTMLBuilder\RenderHelper.RenderBase::render()
     */
    public function render() {

        if (count($this->thead) > 0) {
            $head = new TableElements\Thead();
            foreach ($this->thead as $value) {
                $head->insertChild($value);
            }
            $this->table->insertChild($head);
        }

        if (count($this->tfoot) > 0) {
            $foot = new TableElements\Tfoot();
            foreach ($this->tfoot as $value) {
                $foot->insertChild($value);
            }
            $this->table->insertChild($foot);
        }

        if (count($this->tbody) > 0) {
            $body = new TableElements\Tbody();
            foreach ($this->tbody as $value) {
                $body->insertChild($value);
            }
            $this->table->insertChild($body);
        }

        return $this->table->build();
    }
}