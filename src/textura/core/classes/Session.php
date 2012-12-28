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

namespace Textura;

/**
 * Class that represents a user session
 */
class Session {

  /**
   * @var array properties which the user can read from but not write to
   */
  private static $RESERVED_INSTANCE_VARS = array('session_id', 'session_name');

  /**
   * @var string path to directory where sessions are saved
   */
  private static $SESSION_SAVE_PATH = null;

  /**
   * @var string session name
   */
  private static $SESSION_NAME = null;

  /**
   * @var array session variables
   */
  private $instance_vars;

  /**
   * @var string session id
   */
  private $id;

  /**
   * @var string session save path
   */
  private $path;

  /**
   * @var boolen true whenever session has unsaved data, false otherwise
   */
  private $dirty;

  /**
   * Private constructor. Use Session::init instead.
   */
  private function __construct() {
    if (is_null(self::$SESSION_SAVE_PATH)) {
      // Initialize session save path according to the following rules:
      // 1. If the configuration option session.save_path is set, that path is used.
      // 2. Else, if the PHP option session_save_path is set, that path is used.
      // 3. As a last resort, the path obtained from sys_get_temp_dir is used.
      $session_save_path = Current::application()->getConfigurationOption('session.save_path');
      if (!$session_save_path) $session_save_path = ini_get('session.save_path');
      if (!$session_save_path) $session_save_path = sys_get_temp_dir();
      self::$SESSION_SAVE_PATH = PathBuilder::ensureTrailingSlash(strval($session_save_path));
      // Initialize session name
      $session_name = Current::application()->getConfigurationOption('session.name');
      if (!$session_name) $session_name = 'textura_session';
      self::$SESSION_NAME = strval($session_name);
    }
    $this->instance_vars = array();
    // Look for existing session cookie
    $session_id = Current::request()->getCookie(self::$SESSION_NAME);
    if ($session_id) {
      $this->id = $session_id;
      $this->path = self::$SESSION_SAVE_PATH . "sess_{$this->id}";
      $this->read();
    }
    else {
      $this->id = $this->generateId();
      $this->path = self::$SESSION_SAVE_PATH . "sess_{$this->id}";
    }
    $this->dirty = false;
  }

  /**
   * Initializes a new session.
   *
   * @return \self
   */
  public static function init() {
    return new self();
  }

  /**
   * Clears all variables from session.
   */
  public function clear() {
    $this->instance_vars = array();
  }

  /**
   * Writes current session to disc.
   */
  public function commit() {
    if ($this->dirty) {
      if ($this->write() === false) {
        trigger_error(
          "Failed to write session data for session {$this->id} to {$this->path}",
          E_USER_NOTICE
        );
      }
    }
  }

  /**
   * Destroys session. Calling this method will give the user a new session cookie on next request.
   */
  public function destroy() {
    $this->clear();
    unlink($this->path);
    $this->id = $this->generateId();
    $this->path = $this->path = self::$SESSION_SAVE_PATH . "sess_{$this->id}";
    $this->dirty = false;
  }

  /**
   * Returns all session variables.
   *
   * @return array
   */
  public function getInstanceVars() {
    return $this->instance_vars;
  }

  /**
   * Returns a unique id to use as a session id.
   *
   * @return string
   */
  private function generateId() {
    return md5(uniqid(microtime()) . Current::request()->ip . Current::request()->user_agent);
  }

  /**
   * Reads session data from disc.
   *
   * @throws \LogicException if session cannot be found.
   */
  private function read() {
    if (!file_exists($this->path)) return false;
    if (!is_readable($this->path)) return false;
    $handle = fopen($this->path, 'rb');
    if ($handle === false) {
      throw new \LogicException(
        "Cannot open session file {$this->path} for reading."
      );
    }
    flock($handle, LOCK_SH);
    $this->instance_vars = unserialize(fread($handle, filesize($this->path)));
    flock($handle, LOCK_UN);
    fclose($handle);
    return true;
  }

  /**
   * Serializes session to disc.
   *
   * @throws \LogicException if session file cannot be written.
   */
  private function write() {
    if (!is_writable(dirname($this->path))) return false;
    $data = serialize($this->instance_vars);
    $handle = fopen($this->path, 'wb');
    if ($handle === false) {
      throw new \LogicException(
        "Cannot open session file {$this->path} for writing."
      );
    }
    flock($handle, LOCK_EX);
    fwrite($handle, $data);
    flock($handle, LOCK_UN);
    fclose($handle);
    $this->dirty = false;
    return true;
  }

  /**
   * Magic getter. If key is 'session_id' the session id is returned. If key is 'session_name'
   * the session name is returned. For any other keys, checks the currect session data and
   * returns the current value. If key cannot be found in current session data, returns null.
   *
   * @param string $key
   * @return mixed
   */
  public function __get($key) {
    if ($key === 'session_id') return $this->id;
    if ($key === 'session_name') return self::$SESSION_NAME;
    return array_key_exists($key, $this->instance_vars) ? $this->instance_vars[$key] : null;
  }

  /**
   * Magic setter. Sets a variable in the session.
   *
   * @param string $key
   * @param mixed $value
   * @throws \LogicException if the user tries to set a reserved property.
   */
  public function __set($key, $value) {
    if (in_array($key, self::$RESERVED_INSTANCE_VARS)) {
      throw new \LogicException("Cannot set reserved property $key");
    }
    $this->instance_vars[$key] = $value;
    $this->dirty = true;
  }

}
?>