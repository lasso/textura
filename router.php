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

// Bootstrapping
require_once(
  implode(
    DIRECTORY_SEPARATOR,
    array('src', 'textura', 'core', 'classes', 'PathBuilder.php')
  )
);

define('TEXTURA_ROOT_DIR', dirname(__FILE__));
define('TEXTURA_SITE_DIR', \Textura\PathBuilder::buildPath(TEXTURA_ROOT_DIR, 'site'));
define('TEXTURA_CONTROLLER_DIR', \Textura\PathBuilder::buildPath(TEXTURA_SITE_DIR, 'controllers'));
define('TEXTURA_MODEL_DIR', \Textura\PathBuilder::buildPath(TEXTURA_SITE_DIR, 'models'));
define('TEXTURA_SRC_DIR', \Textura\PathBuilder::buildPath(TEXTURA_ROOT_DIR, 'src'));
define('TEXTURA_CORE_DIR',
  \Textura\PathBuilder::buildPath(TEXTURA_ROOT_DIR, 'src', 'textura', 'core')
);
define(
  'TEXTURA_PLUGIN_DIR',
  \Textura\PathBuilder::buildPath(TEXTURA_ROOT_DIR, 'src', 'textura', 'plugins')
);

// Initialize the singleton instance of Textura. This will also register all plugins and setup
// autoloading.
require_once(\Textura\PathBuilder::buildPath(TEXTURA_CORE_DIR, 'classes', 'Textura.php'));
\Textura\Textura::getInstance();

// Initialize global state
\Textura\Current::init(
  \Textura\Textura::getInstance(),
  \Textura\Request::init(),
  \Textura\Response::init()
);

// Route request
\Textura\Router::route(\Textura\Current::request(), \Textura\Current::response());
?>