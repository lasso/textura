<?php

namespace Textura;

class SQLiteDBAdapter extends DBAdapter {

  private $connection;
  private $filename;
  private $flags;
  private $encryption_key;

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
   * @param type $sql
   */
  public function exec($sql) {
    if (!$this->isConnected()) $this->connect();
    $this->connection->exec($sql);
  }

  /**
   * Gets available fields (name, data_type) from a table. If the table does not exist, an
   * exception will be thrown.
   *
   * @param string $table
   * @return array
   * @throws LogicException
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
  public function query($query) {
    if (!$this->isConnected()) $this->connect();
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
      $cval = \SQLite3::escapeString($value);
      if (is_string($cval)) $cval = "'$cval'";
      $query .= $cval;
      if ($index++ < $num_values) $query .= ', ';
    }
    $query .= ')';
    $this->connection->exec($query);
    return $this->connection->lastInsertRowID();
  }

  public function updateRow($table, $primary_key, array $values) {}

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
    $optional_params = array('flags', 'encryption_key');
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