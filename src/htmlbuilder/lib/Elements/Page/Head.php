<?php
/**
 * The head element is a container for all the head elements. 
 * 
 * Elements inside <head> can include scripts, instruct the browser where 
 * to find style sheets, provide meta information, and more. The following 
 * tags can be added to the head section: <base>, <link>, <meta>, <script>, 
 * <style>,  and <title>. The <title> tag defines the title of the document, 
 * and is the only required element in the head section! {@link http://www.w3schools.com/tags/tag_head.asp }
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
 * @version   1.0
 * @link      http://launchpad.net/htmlbuilder
 */
namespace HTMLBuilder\Elements\Page;
use HTMLBuilder\Validator;

use HTMLBuilder\Elements\Root;

/**
 * The head element is a container for all the head elements. 
 * 
 * Elements inside <head> can include scripts, instruct the browser where 
 * to find style sheets, provide meta information, and more. The following 
 * tags can be added to the head section: <base>, <link>, <meta>, <script>, 
 * <style>,  and <title>. The <title> tag defines the title of the document, 
 * and is the only required element in the head section! {@link http://www.w3schools.com/tags/tag_head.asp }
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

class Head extends Root {

    /**
     * Specifies a URL to a document that contains a set of rules. The rules can be read by browsers to clearly understand the information in the <meta> tag's content attribute
     * @var string
     */
    protected $profile;

    public function initElement() {

        $this->_allowedChildren   = array (
                                        "base",
                                        "link",
                                        "meta",
                                        "object",
                                        "script",
                                        "style",
                                        "title"
        );
        $this->_mandatoryChildren = array (
                                        "title"
        );
    }

    /**
     * Specifies a URL to a document that contains a set of rules. The rules can be read by browsers to clearly understand the information in the <meta> tag's content attribute
     * 
     * @param string $profile
     */
    public final function setProfile($profile) {

        $validators = Validator::URL;
        if ($this->validateSetter($validators, $profile)) {
            $this->profile = $profile;
        }

        return $this;
    }

    /**
     * Specifies a URL to a document that contains a set of rules. The rules can be read by browsers to clearly understand the information in the <meta> tag's content attribute
     * 
     * @return the $profile
     */
    public final function getProfile() {

        return $this->profile;
    }
}