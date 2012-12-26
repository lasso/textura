<?php
/**
 * HTML Base base class provide common functions
 * 
 * PHP version 5
 * 
 * @example   simple.php How to use
 * @filesource
 * @category  Elements
 * @package   Elements
 * @author    Jens Peters <jens@history-archive.net>
 * @copyright 2011 Jens Peters
 * @license   http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @version   1.1
 * @link      http://launchpad.net/htmlbuilder
 */
namespace HTMLBuilder\Elements;
use HTMLBuilder\Validator;
use HTMLBuilder\Exceptions\Exception;

/**
 * HTML Base base class provide common functions
 * 
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 * @category   Elements
 * @example    simple.php see HOW TO USE
 * @example    debug.php see HOW TO DEBUG
 * @package    Elements
 * @subpackage Base
 * @author     Jens Peters <jens@history-archiv.net>
 * @license    http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @link       http://launchpad.net/htmlbuilder
 */
abstract class Root extends Attributes {

    /**
     * HTML block elements
     * @var string
     */
    const BLOCK = "block";

    /**
     * HTML inline elements
     * @var string
     */
    const INLINE = "inline";

    /**
     * The tag name based an the classname
     * @var string
     */
    protected $_tag;

    /**
     * Block or inline element? 
     * @var boolean
     */
    protected $_isBlock = true;

    /**
     * List of children
     * @var SplFixedArray
     */
    protected $_children;

    /**
     * Allowed children types to insert
     * if no restriction the value is false
     * @var false|array
     */
    protected $_allowedChildren = false;

    /**
     * Which tag has to be inserted as child
     * @var array
     */
    protected $_mandatoryChildren = array ();

    /**
     * Counter for html string ident
     * @var int
     */
    protected static $_identCounter = 0;

    /**
     * Has to be implemented to set allowed chilredn an mandatory ones
     */
    abstract public function initElement();

    /**
     * Constructor
     * 
     * @param string $innerHTML (optional) the elements innerHTML
     * @param string $tagId (optional) the tag attribute id     
     * 
     */
    public function __construct($innerHTML = null, $tagId = null) {

        $this->initElement();
        $this->_children = new \SplFixedArray();

        parent::__construct($innerHTML, $tagId);
    }

    /**
     * Build html string
     *
     * @throws Exception if mandatory childrens are missing
     * 
     * @return string
     */
    public function build() {

        $mandatoryInside = array ();

        //start
        $build = '<' . $this->getTag();

        //add _attributes
        $build .= $this->generateAttributeString();

        $hasChildren = $this->hasChildren();
        if ($hasChildren) {

            self::$_identCounter++;
            foreach ($this->_children as $child) {

                /* @var $child Base */
                if (in_array($child->getTag(), $this->_mandatoryChildren)) {
                    $mandatoryInside[] = $child->getTag();
                }

                $ident = $this->_generateIdentString(self::$_identCounter);
                $child = $ident . $child->build();
                $this->_innerHTML .= "\n" . $child;
            }

            $diff = array_diff($mandatoryInside, $this->_mandatoryChildren);
            if (count($diff) != 0) {

                $message = sprintf('Mandatory child(s) missing in %1$s: %2$s', $this->getTag(), implode(",", $mandatoryInside));
                throw new Exception($message, Exception::MANDATORY_TAG_MISSING);
            }
        }

        //closing
        if ($this->_isSelfclosing === false) {

            $count     = (self::$_identCounter - 1);
            $ident     = $this->_generateIdentString($count);
            $linebreak = "";

            if ($hasChildren) {
                $linebreak = chr(10) . $ident;
                self::$_identCounter--;
            }

            $build .= '>' . $this->_innerHTML . $linebreak . '</' . $this->getTag() . '>';
        } else {
            $build .= ' />' . $this->_innerHTML;
        }
        return $build;
    }

    /**
     * Generating tabs for identation of the html tags
     *
     * @param int $count the number of generated tabs
     * 
     * @return string
     */
    private function _generateIdentString($count) {

        $str = "";
        for ($i = 0; $i < $count; $i++) {
            $str .= chr(32) . chr(32) . chr(32) . chr(32);
        }
        return $str;
    }

    /**
     * Check if the inserted element is not blacklisted
     * @param Base $node
     * @throws Exception
     */
    private function _checkAllowdChild($node) {

        $message = "Cannot insert %$1s element " . get_class($node) . " into " . $this->getTag();
        switch($this->_allowedChildren) {

            case self::INLINE :
                $message = sprintf($message, self::INLINE);
            break;

            case self::BLOCK :
            default:
                $message = sprintf($message, self::BLOCK);
            break;
        }
        throw new Exception($message, Exception::INSERT_NOT_ALLOWED);
    }

    /**
     * Inserting a single child
     * 
     * @param Base $node The node to insert
     * 
     * @throws Exception
     * 
     * @return void
     */
    public function insertChild(Root $node) {

        switch(true) {
            case is_string($this->_allowedChildren) :
                $this->_checkAllowdChild($node);
            break;

            case is_array($this->_allowedChildren) :
                if (!in_array($node->getTag(), $this->_allowedChildren)) {
                    throw new Exception("Cannot insert element " . $node->getTag() . " into " . $this->getTag(), Exception::INSERT_NOT_ALLOWED);
                }
            break;

            case is_bool($this->_allowedChildren) :
            default:
            break;
        }

        $excludes = array (
                        "li",
                        "select"
        );
        if (!in_array($this->getTag(), $excludes) && $this->_isBlock === false && $node->isBlock() === true) {
            throw new Exception("Cannot insert block element " . get_class($node) . " into inline " . $this->getTag(), Exception::INSERT_NOT_ALLOWED);
        }

        $end = $this->_children->count();
        $this->_children->setSize($end + 1);
        $this->_children[$end] = $node;

        return $this;
    }

    /**
     * Inserting generic list of children via func_get_args   
     * 
     * Commit a comma separated list $node1,$node2... The node that should be inserted    
     * 
     * @throws Exception if the arguments dows not match the HB_Node type
     * 
     * @return void
     */
    public function insertChildren(/* generic list of Elements */) {

        $children = func_get_args();
        foreach ($children as $child) {

            if ($child instanceof Root) {
                $this->insertChild($child);
            } else {
                throw new Exception("Argument not of type Node: " . $child, Exception::UNSUPPORTED_ARGUMENT);
            }
        }
        return $this;
    }

    /**
     * Getter for children
     * 
     * @return array
     */
    public function getChildren() {

        return $this->_children;
    }

    /**
     * Check if the node has children
     * 
     * @return boolean
     */
    public function hasChildren() {

        return (bool) $this->_children->count() > 0;
    }

    /**
     * Returning the number of children
     * 
     * @return int no of children
     */
    public function countChildren() {

        return $this->_children->count();
    }

    /**
     * Returning html type 
     * 
     * @return the $_isBlock
     */
    public function isBlock() {

        return $this->_isBlock;
    }

    /**
     * Returning html tag 
     * 
     * @return the $_tag
     */
    public function getTag() {

        if (!isset($this->_tag)) {

            // stripping namespace for tag name
            $tag        = explode("\\", get_class($this));
            $this->_tag = strtolower($tag[(count($tag) - 1)]);
        }

        return $this->_tag;
    }

    public function getAttributes() {

        $attributes = array ();

        foreach ($this as $key => $value) {
            if ($key[0] != "_") {
                $attributes[$key] = $value;
            }
        }
        return $attributes;
    }

    public function getAttributeNames() {

        $attributes = array_keys($this->getAttributes());

        return $attributes;
    }

    /**
     * Magic to string function can be used for debugging
     * 
     * @example debug.php see HOW TO USE
     * @return string node properties
     */
    public function __toString() {

        return $this->build() . "\n";
    }

    /**
     * Convert to node to array
     * 
     * @return array node properties
     */
    public function __toArray() {

        $return = array ();
        $return["element"] = $this->getTag();

        foreach ($this as $key => $value) {
            if ($value !== "" && $key[0] != "_") {
                $return["attributes"][$key] = $value;
            }
        }

        foreach ($this->_children as $child) {

            $return["children"][] = $child->__toArray();
        }

        return $return;
    }

    /**
     * Function can be used for debugging
     * 
     * @example debug.php see HOW TO USE
     * 
     * @return string node properties
     */
    public function debug() {

        $ret = $this->__toArray();
        $ret = print_r($ret, true);

        $ret = preg_replace("/Array/is", "\n", $ret);
        $ret = preg_replace("/(\(|\))\n/is", "\n", $ret);
        $ret = preg_replace("/(\n[ ]*\n)/is", "", $ret);

        return $ret;
    }
}