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

namespace Textura;

class FileLogger {

  const MSG_TYPE_DEV    = 1;  // Development message
  const MSG_TYPE_DEBUG  = 2;  // Debug message
  const MSG_TYPE_INFO   = 3;  // Informational message
  const MSG_TYPE_WARN   = 4;  // Warning message
  const MSG_TYPE_ERROR  = 5;  // Error message

  private $path;

  public function __construct($path) {
    $realpath = realpath(dirname($path));
    if (!$realpath || !is_writeable($realpath)) {
      throw new \LogicException("Unable to write to logfile path $path");
    }
    $this->path = $path;
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

  public function log($message, $severity = null) {
    $handle = fopen($this->path, 'a');
    if (!$handle) throw new \LogicException("Unable to open logfile path {$this->path}");
    $timestamp = strftime('%c');
    $prefix = $severity ? (' [' . strtoupper($this->getSeverityAsString($severity)) . ']') : '';
    fwrite($handle, $timestamp . $prefix . " $message\n");
    fclose($handle);
  }

  public function warn($message) {
    $this->log($message, self::MSG_TYPE_WARN);
  }

  private function getSeverityAsString($severity) {
    switch ($severity) {
      case self::MSG_TYPE_DEBUG: return 'debug';
      case self::MSG_TYPE_DEV: return 'dev';
      case self::MSG_TYPE_ERROR: return 'error';
      case self::MSG_TYPE_INFO: return 'info';
      case self::MSG_TYPE_WARN: return 'warn';
      default: throw new \LogicException("Unknown severity $severity");
    }
  }

}

?>