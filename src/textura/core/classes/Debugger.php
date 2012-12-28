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
 * Class for debugging requests. This class will be loaded automatically by Textura whenever
 * debugging is activated in the config file.
 */
class Debugger {

  /**
   * Adds debugging information for the current requst to the current response
   *
   * @param \Textura\Request $request
   * @param \Textura\Response $response
   */
  public static function debug_request(Request $request, Response $response) {
    ob_start();
    echo "<hr>";
    echo "<pre>";
    echo "<strong>Cookies</strong>\n";
    var_dump($request->cookies);
    echo "\n\n<strong>Files</strong>\n";
    var_dump($request->files);
    echo "\n\n<strong>GET parameters</strong>\n";
    var_dump($request->get_params);
    echo "\n\n<strong>POST parameters</strong>\n";
    var_dump($request->post_params);
    echo "\n\n<strong>Server parameters</strong>\n";
    var_dump($request->server_params);
    echo "\n\n<strong>Session</strong>\n";
    var_dump($request->session);
    echo "\n\n<strong>Global vars</strong>\n";
    var_dump($GLOBALS);
    $response->appendToBody(ob_get_contents());
    ob_end_clean();
  }

}

?>
