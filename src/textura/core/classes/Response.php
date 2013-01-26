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
 */

namespace Textura;

/**
 * This class represents the response sent to the browser
 */
class Response {

  /**
   * @var array response cookies
   */
  private $cookies;

  /**
   * @var array response headers
   */
  private $headers;

  /**
   * @var string response body
   */
  private $body;

  /**
   * Contructior. This method is private, use Response::init to initialize
   * the response object instead.
   */
  private function __construct() {
    $this->clear(); // Will make sure we have an "empty" response
    $this->setHeader('Content-Type', 'text/html'); // Use text/html by default
    $this->setHeader('Status', 200); // Status is 200 OK by default
  }

  /**
   * Initializes a new Response object
   *
   * @return Textura\Response
   */
  public static function init() {
    return new self();
  }

  /**
   * Appends data to the body of the response
   *
   * @param mixed $data     Should be a string, but will be converted to a string if
   * of any other type.
   */
  public function appendToBody($data) {
    if (is_string($data)) $this->body .= $data;
    else $this->body .= strval($data);
  }

  /**
   * Clears the reponse of all data (both headers and body)
   */
  public function clear() {
    $this->clearHeaders();
    $this->clearCookies();
    $this->clearBody();
  }

  /**
   * Clears the body of the response
   */
  public function clearBody() {
    $this->body = '';
  }

  /**
   * Clears the cookies of the response
   */
  public function clearCookies() {
    $this->cookies = array();
  }

  /**
   * Clears the headers of the response
   */
  public function clearHeaders() {
    $this->headers = array();
  }

  /**
   * Returns all headers of the response
   *
   * @return array
   */
  public function getAllHeaders() {
    return $this->headers;
  }

  /**
   * Returns a specific header of the response. If the header is not set, null is returned.
   *
   * @param string $key
   * @return mixed
   */
  public function getHeader($key) {
    return array_key_exists($key, $this->headers) ? $this->headers[$key] : null;
  }

  /**
   * Sends the response to the browser
   */
  public function send() {
    // Make sure session data is saved to disc at this point.
    // It cannot be touched by anything after this call.
    if (Current::haveController() && Current::controller()->useSession()) {
      Current::session()->commit();
    }
    $this->setHeader('Content-Length', strlen($this->body)); // Add content length header
    $this->setSessionCookie(); // Sets session cookie (only if needed)
    $this->sendHeaders();
    $this->sendCookies();
    $this->sendBody();
    exit; // No code should be run after data is sent!
  }

  /**
   * Send a 404 status code with the specified message to the browser
   *
   * @param string $message     The message to send to the browser
   */
  public function send404($message = 'Not found') {
    $this->clear();
    $this->setHeader('Status', 404);
    $this->appendToBody($message);
    if (Current::request()->debug) {
      Debugger::debug_request(Current::request(), $this);
    }
    $this->send();
  }

  /**
   * Send a 500 status code with the specified message to the browser
   *
   * @param \Exception $error     The execption that was thrown. This parameter is used for
   *                              printing errors/printing beacktraces is enabled.
   * @param string $message       The message to send to the browser
   */
  public function send500(\Exception $error, $message = 'Internal server error') {
    $this->clear();
    $this->setHeader('Status', 500);
    $this->appendToBody($message);
    if (Current::application()->getConfigurationOption('debugging.show_errors')) {
      $this->appendToBody(
        '<p style="font-weight: bold; margin-bottom: 0px;">Error: ' . $error->getMessage() . '</p> '
      );
    }
    if (Current::application()->getConfigurationOption('debugging.show_backtraces')) {
      $this->appendToBody(
        '<p style="font-weight: bold; margin-bottom: 0px;">Backtrace</p>' .
        '<p style="margin-top: 0px; white-space: pre-wrap;">' . $error->getTraceAsString() . '</p>'
      );
    }
    if (Current::request()->debug) {
      Debugger::debug_request(Current::request(), $this);
    }
    $this->send();
  }

  /**
   * Sends the body to the browser
   */
  private function sendBody() {
    echo $this->body;
  }

  /**
   * Sends all cookies associated with the current Response object.
   */
  private function sendCookies() {
    foreach ($this->cookies as $cookie_name => $cookie_params) {
      setcookie(
        $cookie_name,
        $cookie_params['value'],
        $cookie_params['expire'],
        $cookie_params['path'],
        $cookie_params['domain'],
        $cookie_params['secure'],
        $cookie_params['httponly']
      );
    }
  }

  /**
   * Sends the headers to the browser
   */
  private function sendHeaders() {
    foreach ($this->headers as $key => $value) {
      header("$key: $value");
    }
  }

  /**
   * redirects the client to another location.
   *
   * @param string $location
   * @param integer $status
   * @param string $message
   */
  public function sendRedirect($location, $status = 302, $message = 'Found') {
    $this->clear();
    $this->setHeader('Status', $status);
    $this->setHeader('Location', $location);      // TODO: Force absolute URL?
    $this->appendToBody($message);
    $this->send();
  }

  /**
   * Adds a cookie to the response to the client
   *
   * @param string $cookie_name cookie name
   * @param mixed $cookie_value cookie value
   * @param string $cookie_expire cookie expire date. By default, Textura does not set an explicit
   *   expiration date. When this parameter is set, Textura uses the Expires parameter in the
   *   Set-Cookie HTTP header to set an expire date.
   * @param string $cookie_path cookie path. By default, Textura will use the path returned by
   *   Textura\PathBuilder::getTexturaBaseURL().
   * @param string $cookie_domain cookie domain
   * @param boolean $cookie_secure is cookie HTTPS only?
   * @param boolean $cookie_httponly is cookie invisible to XHR requests?
   */
  public function setCookie(
    $cookie_name,
    $cookie_value,
    $cookie_expire = null,
    $cookie_path = null,
    $cookie_domain = null,
    $cookie_secure = false,
    $cookie_httponly = false
  ) {
    $path = strval($cookie_path);
    // If a path has not been explicitly set, use Textura base URL
    $path = !empty($path) ? $path : PathBuilder::getTexturaBaseURL();
    $this->cookies[$cookie_name] =
      array(
        'value'     => strval($cookie_value),
        'expire'    => intval($cookie_expire),
        'path'      => $path,
        'domain'    => strval($cookie_domain),
        'secure'    => (bool) $cookie_secure,
        'httponly'  => (bool) $cookie_secure
      );
  }

  /**
   * Sets session cookue (if currently active controller uses session).
   */
  private function setSessionCookie() {
    // Check if current controller uses session. If it does, add session cookie header.
    if (Current::haveController() && Current::controller()->useSession()) {
      switch (Current::controller()->getSessionScope()) {
        case 'global':
          $session_scope = '/';
          break;
        case 'application':
          $session_scope = PathBuilder::getTexturaBaseURL();
          break;
        case 'controller':
          $session_scope = PathBuilder::buildRoute(get_class(Current::controller()));
          break;
        deafault:
          $controller_session_scope = Current::controller()->getSessionScope();
          throw new \LogicException("Non valid session scope $controller_session_scope detected.");
      }
      // Set session cookie
      $this->setCookie(
        Current::session()->session_name,
        Current::session()->session_id,
        null,
        PathBuilder::ensureTrailingSlash($session_scope)
      );
    }
  }

  /**
   * replaces the body of the response with $data
   *
   * @param mixed $data     Should be a strong, but will be converted to a string otherwise
   */
  public function setBody($data) {
    if (is_string($data)) $this->body = $data;
    else $this->body = strval($data);
  }

  /**
   * Sets a header in the response
   *
   * @param string $key       The headers to set
   * @param mixed $value      The value to use for the header
   */
  public function setHeader($key, $value) {
    $this->headers[strval($key)] = strval($value);
  }

}
?>