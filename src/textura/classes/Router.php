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

class Router {

  private static $controller_map = null;  // Map holding the list of active controllers
  private static $default_actions = null; // Map holding default actions for active controllers

  /**
   * Routes a request and emits a response.
   *
   * Rules for routing:
   *
   * 1) If an exact match is found, the specified action is called directly
   * 2) If no exact match is found, the "default" action for the current controller is called
   * 3) If no default action is found and the path differs from /, the "parent" path is called
   * 4) Repeat
   *
   * @param \Textura\Request $request     The request to process
   * @param \Textura\Response $response   The response to send
   * @return null                         This method always returns null
   */
  public static function route(Request $request, Response $response) {
    // Initialize controller map (if needed)
    if (is_null(self::$controller_map)) self::initializeControllerMap();

    // Start routing process
    $path = null;
    $exit = false;
    do {
      // Extract current path
      $path = is_null($path) ? rtrim($request->path_info, '/') : dirname($path);
      // Check if current path is mapped to any controller.
      if (array_key_exists($path, self::$controller_map)) {
        // Alright, we got a matching controller. Lets initialize it
        $controller = new self::$controller_map[$path];
        // Extract params
        $params = self::extractParams(rtrim($path, '/'), $request);
        // First param will always be the action. If we got no params, try the "default" action
        // for the controller
        $action = empty($params) ? self::getDefaultAction($controller) : array_shift($params);
        try {
          // Check if action is callable
          $action_is_callable = is_callable(array($controller, $action));
          if (!$action_is_callable) {
            // Try default action for the same controller (unless we are already there)
            $default_action = self::getDefaultAction($controller);
            if ($action != $default_action && is_callable(array($controller, $default_action))) {
              array_unshift($params, $action); // Put the previous action back in parameter list
              $action = $default_action;
            }
            else {
              // No default action. Lets try our parent instead
              if ($path != '/') continue;
              // No possible action found. Lets quit
              $response->setHeader('Status', 404);
              $response->appendToBody('Not found');
              if ($request->debug)
                \Textura\Debugger::debug_request($request, $response);
              $response->send();
              return;
            }
          }
          // Action exists. Lets call it
          $reflection_method = new \ReflectionMethod($controller, $action);
          @$reflection_method->invokeArgs($controller, $params);  // We cannot stop the user
                                                                  // from sending the wrong
                                                                  // number of params

          // Check if the action has a view connected to it. If it has, render the template
          // and append the rendered data to the response
          $template_path = self::getTemplatePath($path, $action);
          if ($template_path) {
            self::renderTemplate($controller, $template_path, $response);
          }
          // Check if debugging is enabled
          if ($request->debug) \Textura\Debugger::debug_request($request, $response);
        } catch (Exception $e) {
          $response->appendToBody('<hr>' . $e->getMessage() . '<hr>');
        }
        $response->send();
        return;
      }
      if ($path == '/')
        $exit = true;
    } while (!$exit);
    $response->setHeader('Status', 404);
    $response->appendToBody('Not found');
    if ($request->debug)
      \Textura\Debugger::debug_request($request, $response);
  }

  /**
   * Returns the default action for a controller class
   *
   * @param mixed $obj_or_string      Either class name or a controller object
   * @return string
   * @throws \LogicException          If the controller class does not exist
   */
  public static function getDefaultAction($obj_or_string) {
    $classname = is_object($obj_or_string) ? get_class($obj_or_string) : $obj_or_string;
    if (array_key_exists($classname, self::$default_actions)) return self::$default_actions[$classname];
    throw new \LogicException("No such controller");
  }

  /**
   * Extracts the parameters from a specific path.
   *
   * @param string $path                  The path to extract parameters from
   * @param \Textura\Request $request     The current request
   * @return array                        An array with parameters
   */
  private static function extractParams($path, Request $request) {
    return array_diff(explode('/', rtrim($request->path_info, '/')), explode('/', $path));
  }

  /**
   * Returns the template file path for a specific request path/action
   *
   * @param string $path      The request path
   * @param string $action    The current action
   * @return string           The path where the template file should be found
   */
  private static function getTemplatePath($path, $action) {
    $view_path = PathBuilder::build_path(TEXTURA_SITE_DIR, 'views', ltrim($path, '/'), $action) . '.haml';
    return (file_exists($view_path) && is_readable($view_path) ? $view_path : null);
  }

  /**
   * Renders a HAML template for the specified path
   *
   * @param string $template_path
   * @param Response $response
   */
  private static function renderTemplate($controller, $template_path, $response) {
    require_once(PathBuilder::build_path(TEXTURA_SRC_DIR, 'phamlp', 'haml', 'HamlParser.php'));
    $haml_parser = new \HamlParser();
    ob_start();
    // Extract $controller instance vars into global scope so that they can be referenced by HAML
    $instance_vars = $controller->getInstanceVars();
    extract($instance_vars);
    // Eval HAML
    eval(preg_replace('/^\<\?php\s/', '', $haml_parser->haml2PHP($template_path), 1));
    $response->appendToBody(ob_get_contents());
    ob_end_clean();
    // Remove instance variables from global scope again
    foreach ($instance_vars as $current_instance_var)
      unset($current_instance_vars);
  }

  /**
   * This method is responsible for initializing the controller map. It will also calculate
   * default actions for all controllers.
   */
  private static function initializeControllerMap() {
    self::$controller_map = array();
    self::$default_actions = array();
    $controller_map_configuration =
      Current::application()->getConfigurationOption('controllers.controller_map');
    foreach ($controller_map_configuration as $controller) {
      if ($controller['active']) {
        self::$controller_map[$controller['path']] = $controller['class'];
        self::$default_actions[$controller['class']] =
          array_key_exists('default_path', $controller) ?
          $controller['default_action'] :
          'index';
      }
    }
  }

}

?>