<?php
/*
Copyright 2012 Lars Olsson <lasso@lassoweb,se>

This file is part of Textura.

Textura is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Textura is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*/

namespace Textura\Model;

class DBManager implements \Textura\Singleton {

  private $adapter;

  private static $instance = null;

  private function __construct() {
    $this->adapter =
      $this->getAdapterInstance(
        \Textura\Current::application()->getConfigurationOption('database.adapter'),
        \Textura\Current::application()->getConfigurationOption('database.params')
      );
  }

  public static function getInstance() {
    if (is_null(self::$instance)) self::$instance = new self;
    return self::$instance;
  }

  public function deleteSingleRow($table, array $primary_keys) {

  }

  public function deleteRows($table, array $conditions) {

  }

  public function getFields($table) {
    return $this->adapter->getFields($table);
  }

  public function insertRow($table, array $values) {
    return $this->adapter->insertRow($table, $values);
  }

  public function selectRows($table, array $conditions, array $fields = null) {
    return $this->adapter->selectRows($table, $conditions, $fields);
  }

  public function updateRow($table, array $primary_keys, array $values) {
    return $this->adapter->updateRow($table, $primary_keys, $values);
  }

  /**
   * Returns a new adapter instance
   *
   * @param string $adapter
   * @param array $params
   * @return mixed
   * @throws \LogicException     If the adapter cannot be found
   */
  private function getAdapterInstance($adapter, $params) {
    switch (strtolower($adapter)) {
      case 'sqlite':
      case 'sqlite3':
        $class = '\Textura\SQLiteDBAdapter';
        break;
      default:
        throw new \LogicException("Unknown database adapter $adapter");
    }
    $reflecttion_class =new \ReflectionClass($class);
    return $reflecttion_class->newInstance($params);
  }

}
?>