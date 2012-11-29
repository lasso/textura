<?php
/**
 * Smarty general functions container
 * 
 * PHP Version 5
 * 
 * @filesource
 * @category  Templates
 * @package   TemplatingEngines
 * @author    Jens Peters <jens@history-archive.net>
 * @copyright 2011 Jens Peters
 * @license   http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @version   ##VERSION##
 * @link      http://launchpad.net/htmlbuilder
 */
namespace HTMLBuilder\ext\TemplatingEngines;
use HTMLBuilder\Elements\Lists\Ul;
use HTMLBuilder\Elements\Lists\Li;
use HTMLBuilder\TemplatingEngines;

/**
 * Smarty general functions container
 * 
 * @category Templates
 * @package  TemplatingEngines
 * @author   Jens Peters <jens@history-archiv.net>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @link     http://launchpad.net/htmlbuilder
 */
class SmartyFunctions extends TemplatingEngines\TemplateHelperSmarty {

    /**
     * Building an ul list
     *      
     * @param array $params List of params
     * 
     * @example smarty.tpl 
     * 
     * @return string
     */
    public function ulist($params) {

        $list = new Ul();

        // dynamically build setter
        foreach ($params as $key => $param) {
            $this->_setNodeProperty($list, $key, $param);
        }

        // Insert li elements
        if (isset($params["members"]) && is_array($params["members"])) {

            foreach ($params["members"] as $member) {
                $li = new Li($member);
                $list->insertChild($li);
            }
        }
        return $list->build();
    }
}