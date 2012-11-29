<?php
/**
 * Helper class to register HTML node to smarty
 * 
 * PHP version 5
 * 
 * @filesource
 * @category  TemplatingEngines
 * @package   TemplatingEngines
 * @author    Jens Peters <jens@history-archive.net>
 * @copyright 2011 Jens Peters
 * @license   http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @version   1.0
 * @link      http://launchpad.net/htmlbuilder
 */
namespace HTMLBuilder\TemplatingEngines;
use HTMLBuilder\Elements\Root;
/**
 * Helper class to register HTML node to smarty
 * 
 * @category   TemplatingEngines
 * @package    TemplatingEngines
 * @author     Jens Peters <jens@history-archiv.net>
 * @license    http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @link       http://launchpad.net/htmlbuilder
 */
abstract class TemplateHelperSmarty extends TemplateHelper {

    /**
     * Constructor
     * 
     * @param mixed $engine e.g. Smarty
     */
    public function __construct($engine) {

        $this->engine = $engine;

        $reflect   = new \ReflectionClass($this);
        $functions = $reflect->getMethods(\ReflectionMethod::IS_PUBLIC);

        foreach ($functions as $function) {

            $function = $function->name;
            if ($function === '__construct') {
                continue;
            }

            switch(true) {
                case preg_match("/^modifier_(.*)$/is", $function):
                    $this->_registerFunction($function, "modifier");
                    break;

                default:
                    $this->_registerFunction($function);
                    break;
            }
        }
    }

    /**
     * Setting note property by concatening the setter
     * 
     * @param Root   $node     The node which property to set
     * @param string $property Property name
     * @param string $value    Property value
     * 
     * @return void
     */
    protected function _setNodeProperty(Root $node, $property, $value) {

        $attributes = $node->getAttributeNames();

        if ($property !== "members" && in_array($property, $attributes)) {
            $setter = "set" . ucfirst($property);
            $node->$setter($value);
        }
    }

    /**
     * Registers template functions
     * 
     * @param string $name Name of template function
     * @param string $type (Optional) Template function or modifier
     * 
     * @return void
     */
    protected function _registerFunction($name, $type = "function") {

        // if a modifier remove the prefix in template
        $templateName = $name;
        if (preg_match("/^modifier_(.*)$/is", $name, $matches)) {
            $templateName = $matches[1];
        }

        $plugin = array(
                        $this,
                        $name);

        // register engine
        $this->engine->registerPlugin($type, $templateName, $plugin);
    }

}