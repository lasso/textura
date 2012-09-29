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

class Response {

  private $headers;
  private $body;

  private function __construct() {
    $this->clear(); // Will make sure we have an "empty" response
    $this->setHeader('Content-Type', 'text/html'); // Use text/html by default
    $this->setHeader('Status', 200); // Status is 200 OK by default
  }

  public static function init() {
    return new self();
  }

  public function appendToBody($data) {
    if (is_string($data)) $this->body .= $data;
    else $this->body .= strval($data);
  }

  public function clear() {
    $this->clearHeaders();
    $this->clearBody();
  }

  public function clearBody() {
    $this->body = '';
  }

  public function clearHeaders() {
    $this->headers = array();
  }

  public function getAllHeaders() {
    return $this->headers;
  }

  public function getHeader($key) {
    return array_key_exists($key, $this->headers) ? $this->headers[$key] : null;
  }

  public function send() {
    $this->setHeader('Content-Length', strlen($this->body)); // Add content length header
    $this->sendHeaders();
    $this->sendBody();
  }

  private function sendBody() {
    echo $this->body;
  }

  private function sendHeaders() {
    foreach ($this->headers as $key => $value) {
      header("$key: $value");
    }
  }

  public function setBody($data) {
    if (is_string($data)) $this->body = $data;
    else $this->body = strval($data);
  }

  public function setHeader($key, $value) {
    $this->headers[strval($key)] = strval($value);
  }

}
?>