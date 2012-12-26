<?php
/**
 * The <legend> tag defines a caption for the fieldset element. 
 * 
 * {@link http://www.w3schools.com/tags/tag_legend.asp }
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
namespace HTMLBuilder\Elements\General;
use HTMLBuilder\Elements\Root;
use HTMLBuilder\Elements\Attributes;
use HTMLBuilder\Validator;

/**
 * The <legend> tag defines a caption for the fieldset element. 
 * 
 * {@link http://www.w3schools.com/tags/tag_legend.asp }
 * 
 * @category   Element
 * @example    simple.php see HOW TO USE
 * @example    debug.php see HOW TO DEBUG
 * @package    Elements
 * @subpackage Fieldset
 * @author     Jens Peters <jens@history-archiv.net>
 * @license    http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @link       http://launchpad.net/htmlbuilder
 */
class Legend extends Root {

    public function initElement() {

        $this->_allowedChildren = self::INLINE;
    }
}