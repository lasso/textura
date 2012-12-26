<?php
/**
 * The <thead> tag is used to group the header content in an HTML table.
 * 
 * <p>The thead element should be used in conjunction with the tbody and tfoot elements.</p>
 * <p>The tbody element is used to group the body content in an HTML table and the tfoot 
 * element is used to group the footer content in an HTML table.</p>
 * <p><b>Note:</b> <tfoot> must appear before <tbody> within a table, so that a browser 
 * can render the foot before receiving all the rows of data.</p>
 * <p>Notice that these elements will not affect the layout of the table by default. 
 * However, you can use CSS to let these elements affect the table's layout.</p>
 * {@link http://www.w3schools.com/tags/tag_thead.asp }
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

/**
 * The <thead> tag is used to group the header content in an HTML table.
 * 
 * <p>The thead element should be used in conjunction with the tbody and tfoot elements.</p>
 * <p>The tbody element is used to group the body content in an HTML table and the tfoot 
 * element is used to group the footer content in an HTML table.</p>
 * <p><b>Note:</b> <tfoot> must appear before <tbody> within a table, so that a browser 
 * can render the foot before receiving all the rows of data.</p>
 * <p>Notice that these elements will not affect the layout of the table by default. 
 * However, you can use CSS to let these elements affect the table's layout.</p>
 * {@link http://www.w3schools.com/tags/tag_thead.asp }
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
class THead extends RootRow {

    public function initElement() {

        $this->_allowedChildren = array (
                                        "tr"
        );
    }
}