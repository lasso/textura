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

class SQLiteDBAdapter extends DBAdapter {

  private $connection;
  private $filename;
  private $flags;
  private $encryption_key;
  private $logger;

  public function __construct(array $params) {
    $filtered_params = $this->validateParams($params);
    $this->filename = $filtered_params['filename'];
    $this->flags =
            array_key_exists('flags', $filtered_params) ?
            $filtered_params['flags'] :
            null;
    $this->encryption_key =
            array_key_exists('encryption_key', $filtered_params) ?
            $filtered_params['encryption_key'] :
            null;
    $this->log_queries =
      isset($filtered_params['log_queries']) ?
      $filtered_params['log_queries'] :
      false;
    // Check if query logging should be enabled
    $this->logger =
      isset($filtered_params['log_queries'])
      && isset($filtered_params['log_method'])
      && in_array($filtered_params['log_method'], array('db', 'file')) ?
      $filtered_params['log_method'] == 'file' ?
      new \Textura\FileLogger($filtered_params['log_placement']) :
      null : // No support for db logging of queries yet
      null;
  }

  /**
   * Connects to the database
   */
  protected function connect() {
    if (!empty($this->flags) && !empty($this->encryption_key)) {
      $this->connection = new \SQLite3($this->filename, $this->flags, $this->encryption_key);
    } elseif (!empty($this->flags)) {
      $this->connection = new \SQLite3($this->filename, $this->flags);
    } elseif (!empty($this->encryption_key)) {
      $this->connection = new \SQLite3(
                      $this->filename,
                      SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE,
                      $this->encryption_key
      );
    }
    else {
      $this->connection = new \SQLite3($this->filename);
    }
  }

  /**
   * Executes a query that does not return any rows.
   *
   * @param string $query
   */
  public function exec($query, $log_query = true) {
    if (!$this->isConnected()) $this->connect();
    if ($this->logger && $log_query) $this->logger->info($query);
    $this->connection->exec($query);
  }

  /**
   * Gets available fields (name, data_type) from a table. If the table does not exist, an
   * exception will be thrown.
   *
   * @param string $table
   * @return array
   * @throws \LogicException
   */
  public function getFields($table) {
    if (!$this->tableExists($table)) {
      throw new \LogicException("Table $table does not exist!");
    }
    $query = sprintf("PRAGMA table_info(%s)", \SQLite3::escapeString($table));
    $result = $this->query($query);
    $fields = array();
    foreach ($result as $current_row) {
      $fields[$current_row['name']] =
        array(
          'allow_null' => !(bool)$current_row['notnull'],
          'default' => $current_row['dflt_value'],
          'primary_key' => (bool)$current_row['pk'],
          'type' => $this->convertFieldType($current_row['type'])
        );
    }
    return $fields;
  }

  /**
   * Sends a query to the DB and returns the result as an associative array
   *
   * @param string $query
   * @return array
   */
  public function query($query, $log_query = true) {
    if (!$this->isConnected()) $this->connect();
    if ($this->logger && $log_query) $this->logger->info($query);
    return $this->getResultAsArray($this->connection->query($query));
  }

  /**
   * Returns whether there exists an open connection to the DB or not
   * @return type
   */
  public function isConnected() {
    return $this->connection instanceof \SQLite3;
  }

  public function insertRow($table, array $values) {
    $query = 'INSERT INTO ' . \SQLite3::escapeString($table) . '(';
    $num_values = count($values);
    $index = 1;
    foreach (array_keys($values) as $key) {
      $query .= \SQLite3::escapeString($key);
      if ($index++ < $num_values) $query .= ', ';
    }
    $query .= ') VALUES (';
    $index = 1;
    foreach (array_values($values) as $value) {
      $query .= $this->normalizeValue($value);
      if ($index++ < $num_values) $query .= ', ';
    }
    $query .= ')';
    $this->connection->exec($query);
    return $this->connection->lastInsertRowID();
  }

  public function normalizeValue($value) {
    if (is_string($value)) {
      return "'" . \SQLite3::escapeString($value) . "'";
    }
    else {
      return $value;
    }
  }

  public function selectRows($table, array $conditions, array $fields = null) {
    if (empty($fields)) {
      $fields_as_string = '*';
    }
    else {
      for ($i = 0; $i < count($fields); $i++) {
        $fields[$i] = \SQLite3::escapeString($fields[$i]);
      }
      $fields_as_string = implode(', ', $fields);
    }
    $query = "SELECT $fields_as_string FROM " . \SQLite3::escapeString($table);
    $num_conditions = count($conditions);
    if ($num_conditions > 0) {
      $query .=  ' WHERE ';
      $index = 1;
      foreach ($conditions as $key => $value) {
        // If value is an array, the first element is the operation and the second element
        // is the value.
        if (is_array($value)) {
          $op = strtolower($value[0]);
          if (!$this->isValidOperator($op)) {
            throw new \LogicException("Invalid operator $op");
          }
          $val = $value[1];
          if ($op === DBAdapter::OP_IN) {
            // List operator
            if (!is_array($val)) throw new \LogicException("$val is not an array");
            $num_arr_elems = count($val);
            if ($num_arr_elems === 0) throw new \LogicException("$val is empty");
            $query .= \SQLite3::escapeString($key) . ' IN (';
            $index2 = 1;
            foreach (array_values($val) as $arr_elem) {
              $query .= $this->normalizeValue($arr_elem);
              if ($index2++ < $num_arr_elems) $query .= ', ';
            }
            $query .= ')';
          }
          else {
            // Normal comparison operator
            $query .= \SQLite3::escapeString($key) . " $op " . $this->normalizeValue($val);
          }
        }
        else {
          // Not an array, use equality comparison
          $query .= \SQLite3::escapeString($key) . ' = ' . $this->normalizeValue($value);
        }
        if ($index++ < $num_conditions) $query .= ' AND ';
      }
    }
    return $this->query($query);
  }

  public function updateRow($table, array $primary_keys, array $values) {
    $query = 'UPDATE ' . \SQLite3::escapeString($table) . ' SET ';
    $num_values = count($values);
    $index = 1;
    foreach ($values as $key => $value) {
      $query .= \SQLite3::escapeString($key) . ' = ' . $this->normalizeValue($value);
      if ($index++ < $num_values) $query .= ', ';
    }
    $query .= ' WHERE ';
    $num_keys = count($primary_keys);
    $index = 1;
    foreach ($primary_keys as $key => $value) {
      $query .= \SQLite3::escapeString($key) . ' = ' . $this->normalizeValue($value);
      if ($index++ < $num_keys) $query .= ' AND ';
    }
    $this->connection->exec($query);
  }

  /**
   * Returns whether a specific table exists or not
   *
   * @param string $table
   * @return boolean
   */
  public function tableExists($table) {
    $query =
      sprintf(
        "SELECT COUNT(*) FROM sqlite_master WHERE type = 'table' AND name = '%s'",
        \SQLite3::escapeString($table)
      );
    if (!$this->isConnected()) $this->connect();
    return ($this->connection->querySingle($query) > 0);
  }

  protected function validateParams(array $params) {
    $filtered_params = array();
    $required_params = array('filename');
    $optional_params = array(
      'flags', 'encryption_key', 'log_queries', 'log_method', 'log_placement'
    );
    foreach ($required_params as $current_required_param) {
      if (!array_key_exists($current_required_param, $params)) {
        throw new \LogicException("Required param $current_required_param missing");
      }
      $filtered_params[$current_required_param] = $params[$current_required_param];
    }
    foreach ($optional_params as $current_optional_param) {
      if (array_key_exists($current_optional_param, $params)) {
        $filtered_params[$current_optional_param] = $params[$current_optional_param];
      }
    }
    return $filtered_params;
  }

  /**
   * Returns the result from a DB queray as an associative array.
   *
   * @param \SQLite3Result $result
   * @return array
   */
  private function getResultAsArray(\SQLite3Result $result) {
    $result_as_array = array();
    while ($result_as_array[]= $result->fetchArray(SQLITE3_ASSOC)) {}
    array_pop($result_as_array);
    $result->finalize();
    return $result_as_array;
  }

  private function convertFieldType($type) {
    switch ($type) {
      case 'INT':
      case 'INTEGER':
        return DBAdapter::TYPE_INTEGER;
      case 'REAL':
        return DBAdapter::TYPE_FLOAT;
      case 'TEXT':
        return DBAdapter::TYPE_STRING;
      default:
        return DBAdapter::TYPE_STRING;
    }
  }

}

?>