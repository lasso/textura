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
 * This class represents the response sent to the browser
 */
class Response {

  private $headers;
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
    $this->clearBody();
  }

  /**
   * Clears the body of the response
   */
  public function clearBody() {
    $this->body = '';
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
    $this->setHeader('Content-Length', strlen($this->body)); // Add content length header
    $this->sendHeaders();
    $this->sendBody();
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
   * Send a 404 status code with the specified message to the browser
   *
   * @param string $message     The message to send to the browser
   */
  public function send500(\Exception $error, $message = 'Internal server error') {
    $this->clear();
    $this->setHeader('Status', 500);
    $this->appendToBody($message);
    if (Current::application()->getConfigurationOption('debugging.show_backtrace')) {
      $this->appendToBody(
        '<p style="font-weight: bold; margin-bottom: 0px;">Error: ' . $error->getMessage() . '</p> ' .
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
   * Sends the headers to the browser
   */
  private function sendHeaders() {
    foreach ($this->headers as $key => $value) {
      header("$key: $value");
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