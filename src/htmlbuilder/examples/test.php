<?php

// PHP HTML Builder is located in htmlbuilder subdirectory
require_once('../lib/Autoloader.php');
HTMLBuilder\Autoloader::register("../lib/");

// Create a form
$form = new HTMLBuilder\Elements\Form\Form();

// Create a select box
$select = new HTMLBuilder\Elements\Form\Select();
$select->setName('select1[]');
$select->setMultiple(true);

// Create some options for the select box
for ($i = 1; $i < 4; $i++) {
  $new_option = new HTMLBuilder\Elements\Form\Option();
  $new_option->setValue($i);
  $new_option->setInnerHTML("Option $i");
  // Insert the option into the select box
  $select->insertChild($new_option);
}

// Insert the select box into the form
$form->insertChild($select);

echo $form;