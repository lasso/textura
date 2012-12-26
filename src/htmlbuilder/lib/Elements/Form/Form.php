<?php
/**
 * The <form> tag is used to create an HTML form for user input.
 * 
 * A form can contain input elements like text fields, checkboxes, 
 * radio-buttons, submit buttons and more. A form can also contain 
 * select menus, textarea, fieldset, legend, and label elements.
 * Forms are used to pass data to a server. {@link http://www.w3schools.com/tags/tag_form.asp }
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
namespace HTMLBuilder\Elements\Form;
use HTMLBuilder\Validator;

/**
 * The <form> tag is used to create an HTML form for user input.
 * 
 * A form can contain input elements like text fields, checkboxes, 
 * radio-buttons, submit buttons and more. A form can also contain 
 * select menus, textarea, fieldset, legend, and label elements.
 * Forms are used to pass data to a server. {@link http://www.w3schools.com/tags/tag_form.asp }
 * 
 * @category   Element
 * @example    simple.php see HOW TO USE
 * @example    debug.php see HOW TO DEBUG
 * @package    Elements
 * @subpackage Form
 * @author     Jens Peters <jens@history-archiv.net>
 * @license    http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @link       http://launchpad.net/htmlbuilder
 */
class Form extends RootForm
{

    /**
     * Form method: post
     * @var string
     */
    const METHOD_POST = "post";

    /**
     * Form method: get
     * @var string
     */
    const METHOD_GET = "get";

    /**
     * Form enctyoe: application/x-www-form-urlencoded
     * @var string
     */
    const ENCTYPE_APP = "application/x-www-form-urlencoded";

    /**
     * Form enctyoe: multipart/form-data
     * @var string
     */
    const ENCTYPE_MULTI = "multipart/form-data";

    /**
     * Form enctyoe: text/plain
     * @var string
     */
    const ENCTYPE_TEXT = "text/plain";

    /**
     * Specifies where to send the form-data when a form is submitted
     * @var string 
     */
    protected $action = "";

    /**
     * Specifies how to send form-data, possible values:
     * <ul>
     * <li>get</li>
     * <li>post</li>
     * </ul>
     * @var string 
     */
    protected $method = "";

    /**
     * Specifies the MIME type of files that can be submitted through a file upload
     * @var string 
     * @deprecated because of not supported by most browsers (@link http://www.w3schools.com/tags/att_form_accept.asp)
     */
    protected $accept = "";

    /**
     * Specifies the character-sets the server can handle for form-data
     * @var string
     */
    protected $accept_charset = "";

    /**
     * Specifies how form-data should be encoded before sending it to a server
     * <ul>
     * <li>text/plain</li>
     * <li>multipart/form-data</li>
     * <li>application/x-www-form-urlencoded</li>
     * </ul>
     * @var string 
     */
    protected $enctype = "";

    /**
     * Script to be run when a form is submitted
     * @var string
     */
    protected $onsubmit = "";

    /**
     * Script to be run when a form is reset
     * @var string
     */
    protected $onreset = "";

    public function initElement()
    {

        $this->_allowedChildren = array (
                                        "input", 
                                        "textarea", 
                                        "button", 
                                        "select", 
                                        "option", 
                                        "optgroup", 
                                        "fieldset", 
                                        "label"
        );
    }

    /**
     * Specifies the MIME_type of files that can be submitted through a file upload
     * 
     * @param string $accept
     * @deprecated because of not supported by most browsers (@link http://www.w3schools.com/tags/att_form_accept.asp)
     */
    public final function setAccept($accept)
    {
        throw new Exception("Deprecated because of not supported by most browsers", Exception::DEPRECATED_TAG);
    }

    /**
     * The accept-charset attribute specifies the character encodings that are to be used for the form submission.
     * 
     * @param string $accept_charset
     */
    public final function setAccept_charset($accept_charset)
    {

        $this->accept_charset = $accept_charset;
        return $this;
    }

    /**
     * Specifies where to send the form-data when a form is submitted
     * 
     * @param string $action The form action
     * 
     * @return Form
     */
    public final function setAction($action)
    {

        $validators = Validator::URL;
        if ($this->validateSetter($validators, $action)) {
            $this->action = $action;
        }
        
        return $this;
    }

    /**
     * Setting form method
     *
     * @param string $method The form method
     *
     * @link Form::METHOD_POST
     * @link Form::METHOD_GET
     *
     * @return Form
     */
    public final function setMethod($method)
    {

        $validators = array (
                            Validator::WHITELIST, 
                            $this->_getClassConstants("^METHOD_(.*)$")
        );
        
        if ($this->validateSetter($validators, $method)) {
            $this->method = $method;
        }
        return $this;
    }

    /**
     * Setting form enctype
     *
     * @param string $enctype the encryption type
     *
     * @link self::ENCTYPE_TEXT
     * @link self::ENCTYPE_APP
     * @link self::ENCTYPE_MULTI
     * 
     * @return Form
     */
    public final function setEnctype($enctype)
    {

        $validators = array (
                            Validator::WHITELIST, 
                            $this->_getClassConstants("^ENCTYPE_(.*)$")
        );
        
        if ($this->validateSetter($validators, $enctype)) {
            $this->enctype = $enctype;
        }
        return $this;
    }

    /**
     * Specifies where to send the form-data when a form is submitted
     * 
     * @return the $action
     */
    public final function getAction()
    {

        return $this->action;
    }

    /**
     * Setting form method
     *
     * @param string $method The form method
     *
     * @link Form::METHOD_POST
     * @link Form::METHOD_GET
     *
     * @return the $method
     */
    public final function getMethod()
    {

        return $this->method;
    }

    /**
     * Specifies the MIME_type of files that can be submitted through a file upload
     * 
     * @return the $accept
     */
    public final function getAccept()
    {

        return $this->accept;
    }

    /**
     * Specifies the MIME_type of files that can be submitted through a file upload
     * 
     * @return the $accept_charset
     */
    public final function getAccept_charset()
    {

        return $this->accept_charset;
    }

    /**
     * Setting form enctype
     *
     * @param string $enctype the encryption type
     *
     * @link self::ENCTYPE_TEXT
     * @link self::ENCTYPE_APP
     * @link self::ENCTYPE_MULTI
     * 
     * @return the $enctype
     */
    public final function getEnctype()
    {

        return $this->enctype;
    }
}