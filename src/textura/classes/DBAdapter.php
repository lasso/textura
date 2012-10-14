<?php
namespace Textura;

abstract class DBAdapter {

  // Constants for unified data types
  const TYPE_INTEGER = 1;
  const TYPE_FLOAT = 2;
  const TYPE_STRING = 3;

  abstract public function __construct(array $params);

  abstract protected function connect();

  abstract public function query($query);

  abstract public function tableExists($table);

  abstract protected function validateParams(array $params);

  abstract public function insertRow($table, array $values);

  abstract public function updateRow($table, $primary_key_value, array $values);
}
?>