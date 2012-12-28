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

class SQLiteLogger {

  const MSG_TYPE_DEV    = 1;  // Development message
  const MSG_TYPE_DEBUG  = 2;  // Debug message
  const MSG_TYPE_INFO   = 3;  // Informational message
  const MSG_TYPE_WARN   = 4;  // Warning message
  const MSG_TYPE_ERROR  = 5;  // Error message

  private $adapter;
  private $table;

  function __construct(SQLiteDBAdapter $adapter, $table) {
    $this->adapter = $adapter;
    $this->table = $table;
    if (!$this->adapter->tableExists($this->table)) $this->createLogTable();
  }

  public function debug($message) {
    $this->log($message, self::MSG_TYPE_DEBUG);
  }

  public function dev($message) {
    $this->log($message, self::MSG_TYPE_DEV);
  }

  public function error($message) {
    $this->log($message, self::MSG_TYPE_ERROR);
  }

  public function info($message) {
    $this->log($message, self::MSG_TYPE_INFO);
  }

  public function log($message, $severity = self::MSG_TYPE_DEV) {
    $query =
      'INSERT INTO ' . \SQLite3::escapeString($this->table) .
      ' (timestamp, severity, message) VALUES (' .
      $this->adapter->normalizeValue(time()) . ', ' .
      $this->adapter->normalizeValue($severity) . ', ' .
      $this->adapter->normalizeValue($message) . ')';
    $this->adapter->query($query, false);
  }

  public function warn($message) {
    $this->log($message, self::MSG_TYPE_WARN);
  }

  private function createLogTable() {
    $query =
      'CREATE TABLE ' . \SQLite3::escaoeString($this->table) .
      '(timestamp TEXT NOT NULL, severity INTEGER NOT NULL, message TEXT NOT NULL)';
    $this->adapter->exec($query);
  }

}
?>