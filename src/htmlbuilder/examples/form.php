<?php
/**
 * Form helper example
 * 
 * PHP version 5
 * 
 * @filesource
 * @category  Examples
 * @package   Examples
 * @author    Jens Peters <jens@history-archive.net>
 * @copyright 2011 Jens Peters
 * @license   http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @version   ##VERSION##
 * @link      http://launchpad.net/htmlbuilder
 */
use HTMLBuilder\Elements\Form as FormElements;
use HTMLBuilder\RenderHelper\Form\Form;

// Register Library
require_once '../lib/Autoloader.php';
HTMLBuilder\Autoloader::register("../lib/");

// Form with action
$form = new Form($_SERVER["PHP_SELF"], 
                 FormElements\Form::METHOD_POST, 
                 "default-form");

// Simple text input with label
$form->addInputText("Surname", "surname");

// with id and default value
$form->addInputText("eMail", "email", "emailId", "Your eMail");

// checkboxes
$form->addInputCheckbox("Agbs", "agbs", "accepted");
$form->addInputCheckbox("Newsletter", "newsletter", "subscribe", true);

// select
$select = array (
                "female" => "Female", 
                "male" => "Male"
);
$form->addSelect("Gender", "gender", $select);

// select with optgroups & selected elements
$select = array (
                "Group 1" => array (
                                    "Subgroup 1", 
                                    "Subgroup 2"
                ), 
                "Group 2" => array (
                                    "foo" => "bar"
                )
);
$form->addSelect("Grouping", "groups", $select, "foo", "", false, 5);

// submit input button
$form->addInputSubmit("", "sendName", "sendId", "Send");

// reset buttun but as &lt;button&gt;
$form->addButtonReset("Reset", "reset", "", "resetValue");

// output by calling __toString()
echo $form;