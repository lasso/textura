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

/**
 * Request object. Losely based on Rack::Request (from Ruby)
 * @see http://rack.rubyforge.org/doc/classes/Rack/Request.html
 */
class Request {

  private $cookies;
  private $files;
  private $get_params;
  private $post_params;
  private $server_params;
  private $validation_errors;

  private function __construct() {
    $this->cookies = $_COOKIE;
    $this->files = $_FILES;
    $this->get_params = $_GET;
    $this->post_params = $_POST;
    $this->server_params = $_SERVER;
    $this->validation_errors = array();

    # FIXME: Should be done in .htaccess
    if (!isset($this->server_params['PATH_INFO'])) $this->server_params['PATH_INFO'] = '/index';
  }

  public static function init() {
    return new self();
  }

  /**
   * Returns the list of validation errors (if any) for the current request
   *
   * @return array
   */
  public function getValidationErrors() {
    return $this->validation_errors;
  }

  /**
   * Returns whether the current request is a GET request
   *
   * @return boolean
   */
  public function isGet() {
    return strtolower($this->server_params['REQUEST_METHOD']) == 'get';
  }

  /**
   * Returns whether the current request is a DELETE request
   *
   * @return boolean
   */
  public function isDelete() {
    return strtolower($this->server_params['REQUEST_METHOD']) == 'delete';
  }

  /**
   * Returns whether the current request is a HEAD request
   *
   * @return boolean
   */
  public function isHead() {
    return strtolower($this->server_params['REQUEST_METHOD']) == 'head';
  }

  /**
   * Returns whether the current request is a POST request
   *
   * @return boolean
   */
  public function isPost() {
    return strtolower($this->server_params['REQUEST_METHOD']) == 'post';
  }

  /**
   * Returns whether the current request is a PUT request
   *
   * @return boolean
   */
  public function isPut() {
    return strtolower($this->server_params['REQUEST_METHOD']) == 'put';
  }

  /**
   * Returns whether the current request is a PUT request
   *
   * @return boolean
   */
  public function isTrace() {
    return strtolower($this->server_params['REQUEST_METHOD']) == 'trace';
  }

  /**
   * Returns whether the current request is considered a "valid" GET request or not.
   *
   * @param array $required_params
   * @return boolean
   */
  public function isValidGet($required_params = array()) {
    return $this->isValid('get', $required_params);
  }

  /**
   * Returns whether the current request is considered a "valid" POST request or not.
   *
   * @param array $required_params
   * @return boolean
   */
  public function isValidPost($required_params = array()) {
    return $this->isValid('post', $required_params);
  }

  /**
   * Returns whether the current request is considered a "valid" XHR request or not.
   *
   * @param array $required_params
   * @param string $name      If this parameter is set, only the specified request method will be
   *                          considered valid. If it is not set, any request method will be
   *                          considered valid.
   * @return boolean
   */
  public function isValidXhr($required_params = array(), $request_method = null) {
    return
      $this->isXhr()
      && $this->isValid(
        (
          $request_method ?
          strtolower($request_method) :
          $this->request_method
        ),
        $required_params
      );
  }

  /**
   * Returns whether the current request is an AJAX request
   *
   * @return boolean
   */
  public function isXhr() {
    return
      isset($this->server_params['HTTP_X_REQUESTED_WITH']) &&
      strtolower($this->server_params['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest";
  }

  /**
   * Magic getter. Allows for some shortcuts in the code.
   *
   * @param string $key
   * @return mixed
   */
  public function __get($key) {
    switch ($key) {
      case 'content_length':
        return (
                isset($this->server_params['CONTENT_LENGTH']) ?
                        $this->server_params['CONTENT_LENGTH'] :
                        null
                );
      case 'cookies':
        return $this->cookies;
      case 'debug': // Returns whether the browser has requested that debug information shpuld be shown
        if (!Current::application()->getConfigurationOption('debugging.allow_debugging')) {
          return false; // Debugging turned off globally
        }
        return
          isset($this->cookies['textura_debug']) && $this->cookies['textura_debug'] ||
          isset($this->params['textura_debug']) && $this->params['textura_debug'];
      case 'files':
        return $this->files;
      case 'get_params':
        return $this->get_params;
      case 'ip':
        if (isset($this->server_params['HTTP_X_FORWARDED_FOR'])) {
          $addresses = explode(',', $this->server_params['HTTP_X_FORWARDED_FOR']);
          $found_address = null;
          foreach ($addresses as $current_address) {
            if (preg_match('/\d\./', $current_address)) {
              $found_address = $current_address;
              break;
            }
          }
          return ($found_address ? $found_address : $this->server_params['REMOTE_ADDR']);
        }
        else {
          return $this->server_params['REMOTE_ADDR'];
        }
      case 'params':
        return array_merge($this->get_params, $this->post_params);
      case 'path_info':
        return $this->server_params['PATH_INFO'];
      case 'port':
        return $this->server_params['SERVER_PORT'];
      case 'post_params':
        return $this->post_params;
      case 'request_method':
        return $this->server_params['REQUEST_METHOD'];
      case 'server_params':
        return $this->server_params;
      case 'user_agent':
        return $this->server_params['HTTP_USER_AGENT'];
      default:
        trigger_error("Unknown request property $key", E_USER_WARNING);
        return null;
    }
  }

  /**
   * Returns whether the current request is considered "valid" or not. A request is considered valid
   * if it uses the correct request type and and all required parameters are present.
   *
   * @param string $request_method
   * @param array $required_params
   * @return boolean
   */
  private function isValid($request_method, $required_params = array()) {
    // Reset validation errors
    $this->validation_errors = array();

    $meth = 'is' . ucfirst(strtolower($request_method));
    if (!$this->$meth()) {
      $this->validation_errors[] = array('WRONG_REQUEST_TYPE', null);
    }
    if (count($required_params) > 0) {
      $haystack = strtolower($request_method) . '_params';
      foreach ($required_params as $current_required_param) {
        if (!array_key_exists($current_required_param, $this->$haystack)) {
          $this->validation_errors[] = array('MISSING_PARAMETER', $current_required_param);
        }
      }
    }
    return count($this->validation_errors) === 0;
  }

}

?>