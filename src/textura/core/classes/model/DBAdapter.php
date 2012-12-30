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
 * Abstract class representing a database adapter.
 */
abstract class DBAdapter {

  // Constants defining operators that the adapter should handle
  const OP_EQ   = '=';
  const OP_GET  = '>=';
  const OP_GT   = '>';
  const OP_IN   = 'in';
  const OP_LET  = '<=';
  const OP_LT   = '<';

  // Constants for column types that the adapter should handle
  const TYPE_INTEGER  = 1;
  const TYPE_FLOAT    = 2;
  const TYPE_MODEL    = 3;
  const TYPE_STRING   = 4;

  /**
   * Constructor
   *
   * @param array $params parameters used to connect to the database
   */
  abstract public function __construct(array $params);

  /**
   * Connects to the database.
   */
  abstract protected function connect();

  /**
   * Sends a custom SQL query to the underlying database.
   *
   * @param string $query the query to send to the underlying database
   */
  abstract public function query($query);

  /**
   * Returns whether the underlying database has a specified schema (table) or not.
   *
   * @param string $table table name
   * @return boolean true if the table exists in the database, false otherwise
   */
  abstract public function tableExists($table);

  /**
   * Returns whether an operator is a valid operator for database query.
   *
   * @param string $operator
   * @return boolean true if the specified operator is valid, false otherwise
   */
  protected function isValidOperator($operator) {
    return
      $operator === self::OP_GET ||
      $operator === self::OP_GT ||
      $operator === self::OP_IN ||
      $operator === self::OP_LET ||
      $operator === self::OP_LT;
  }

  /**
   * Inserts a row inte a database table in the underlying database.
   *
   * @param string $table table name
   * @param array $values values to insert into the table
   */
  abstract public function insertRow($table, array $values);

  /**
   * Performs a SELECT query on the underlying database.
   *
   * @param string $table table name
   * @param array $conditions conditions for WHERE clause
   * @param array $fields fields to select. If left unspecified, all fields are selected.
   */
  abstract public function selectRows($table, array $conditions, array $fields = null);

  /**
   * Updates one or more rows in the underlying database.
   *
   * @param string $table table name
   * @param array $conditions conditions used in WHERE clause
   * @param array $values values to update the table with
   */
  abstract public function updateRows($table, array $conditions, array $values);

  /**
   * Returns whether the provided connection parmeters are valid or not.
   *
   * @param array $params connection parameters
   * @return boolean true if parameters are valid, false otherwise
   */
  abstract protected function validateParams(array $params);

  /**
   * Deletes zero or more rows from the underlying database.
   *
   * @param string $table table name
   * @param array $conditions conditions to use in WHERE clause
   */
  abstract public function deleteRows($table, array $conditions);
}
?>