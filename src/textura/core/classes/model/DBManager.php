<?php
/*
Copyright 2012 Lars Olsson <lasso@lassoweb.se>

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

/**
 * Textura
 *
 * @package Textura
 * @subpackage Model
 */

namespace Textura\Model;

/**
 * Class acting as an intermediary between the model manager and the database adapter. This class
 * is responsible for setting up the requested database adapter and forwarding request from clients
 * to the database adapter.
 */
class DBManager implements \Textura\Singleton {

  /**
   * @var Textura\Model\DBAdapter database adapter
   */
  private $adapter;

  /**
   * @var Textura\Model\DBManager the one and only instance of this class
   */
  private static $instance = null;

  /**
   * Constructor
   */
  private function __construct() {
    $this->adapter =
      $this->getAdapterInstance(
        \Textura\Current::application()->getConfigurationOption('database.adapter'),
        \Textura\Current::application()->getConfigurationOption('database.params')
      );
  }

  /**
   * Returns the one and only instance of this class.
   *
   * @return Textura\Model\DBManager
   */
  public static function getInstance() {
    if (is_null(self::$instance)) self::$instance = new self;
    return self::$instance;
  }

  /**
   * Deletes zero or more rows from the underlying database.
   *
   * @param string $table table name
   * @param array $conditions conditions for WHERE clause
   */
  public function deleteRows($table, array $conditions) {
    return $this->adapter->deleteRows($table, $conditions);
  }

  /**
   * Returns an array containing the field of the specified table from the underlying database.
   *
   * @param string $table table name
   * @return array
   */
  public function getFields($table) {
    return $this->adapter->getFields($table);
  }

  /**
   * Inserts a row into the specified table in the underlying database.
   *
   * @param string $table table name
   * @param array $values values to insert
   * @return integer id of inserted row
   */
  public function insertRow($table, array $values) {
    return $this->adapter->insertRow($table, $values);
  }

  /**
   * Select zero or more rows from the specified table from the underlying database.
   *
   * @param string $table table name
   * @param array $conditions conditions for WHERE clause
   * @param array $fields fields to select. If left unspecified, all fields are selected.
   * @return boolean
   */
  public function selectRows($table, array $conditions, array $fields = null) {
    return $this->adapter->selectRows($table, $conditions, $fields);
  }

  /**
   * Updates one or more rows in the specified table in the underlying database.
   *
   * @param string $table table name
   * @param array $conditions conditions used in WHERE clause
   * @param array $values values to set in the database
   * @return boolean
   */
  public function updateRows($table, array $conditions, array $values) {
    return $this->adapter->updateRows($table, $conditions, $values);
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
        $class = '\Textura\Model\SQLiteDBAdapter';
        break;
      default:
        throw new \LogicException("Unknown database adapter $adapter");
    }
    $reflecttion_class =new \ReflectionClass($class);
    return $reflecttion_class->newInstance($params);
  }

}
?>