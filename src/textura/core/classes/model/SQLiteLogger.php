<?php
/*
Copyright 2012, 2013 Lars Olsson <lasso@lassoweb.se>

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
 * Class implementing logging to a SQLite database.
 */
class SQLiteLogger {

  const MSG_TYPE_DEV    = 1;  // Development message
  const MSG_TYPE_DEBUG  = 2;  // Debug message
  const MSG_TYPE_INFO   = 3;  // Informational message
  const MSG_TYPE_WARN   = 4;  // Warning message
  const MSG_TYPE_ERROR  = 5;  // Error message

  /**
   * @var Textura\SQLiteDBAdapter adapter instance to use for connecting to the database
   */
  private $adapter;

  /**
   *
   * @var string table to write log messages to
   */
  private $table;

  /**
   * Constructor
   *
   * @param \Textura\Model\SQLiteDBAdapter $adapter
   * @param string $table
   */
  function __construct(SQLiteDBAdapter $adapter, $table) {
    $this->adapter = $adapter;
    $this->table = $table;
    if (!$this->adapter->tableExists($this->table)) $this->createLogTable();
  }

  /**
   * Logs a message with severity "debug"
   *
   * @param string $message
   */
  public function debug($message) {
    $this->log($message, self::MSG_TYPE_DEBUG);
  }

  /**
   * Logs a message with severity "dev"
   *
   * @param string $message
   */
  public function dev($message) {
    $this->log($message, self::MSG_TYPE_DEV);
  }

  /**
   * Logs a message with severity "error"
   *
   * @param string $message
   */
  public function error($message) {
    $this->log($message, self::MSG_TYPE_ERROR);
  }

  /**
   * Logs a message with severity "info"
   *
   * @param string $message
   */
  public function info($message) {
    $this->log($message, self::MSG_TYPE_INFO);
  }

  /**
   * Logs a message
   *
   * @param string $message
   * @param integer $severity
   */
  public function log($message, $severity = self::MSG_TYPE_DEV) {
    $query =
      'INSERT INTO ' . \SQLite3::escapeString($this->table) .
      ' (timestamp, severity, message) VALUES (' .
      $this->adapter->normalizeValue(time()) . ', ' .
      $this->adapter->normalizeValue($severity) . ', ' .
      $this->adapter->normalizeValue($message) . ')';
    $this->adapter->query($query, false);
  }

  /**
   * Logs a message with severity "warn"
   *
   * @param string $message
   */
  public function warn($message) {
    $this->log($message, self::MSG_TYPE_WARN);
  }

  /**
   * Creates table used for log messages.
   */
  private function createLogTable() {
    $query =
      'CREATE TABLE ' . \SQLite3::escaoeString($this->table) .
      '(timestamp TEXT NOT NULL, severity INTEGER NOT NULL, message TEXT NOT NULL)';
    $this->adapter->exec($query);
  }

}
?>