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
  private $session;

  private function __construct() {
    $this->cookies = $_COOKIE;
    $this->files = $_FILES;
    $this->get_params = $_GET;
    $this->post_params = $_POST;
    $this->server_params = $_SERVER;
    $this->session = isset($_SESSION) ? $_SESSION : null;
    unset($_COOKIE);
    unset($_FILES);
    unset($_GET);
    unset($_POST);
    unset($_REQUEST);
    unset($_SERVER);
    unset($_SESSION);

    # FIXME: Should be done in .htaccess
    if (!isset($this->server_params['PATH_INFO'])) $this->server_params['PATH_INFO'] = '/index';
  }

  public static function init() {
    return new self();
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
      case 'session':
        return $this->session;
      case 'user_agent':
        return $this->server_params['HTTP_USER_AGENT'];
      default:
        trigger_error("Unknown request property $key", E_USER_WARNING);
        return null;
    }
  }

}

?>