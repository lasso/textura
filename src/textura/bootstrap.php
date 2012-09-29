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

function autoload($class_name) {
  $class_name_parts = explode('\\', $class_name);
  if ($class_name_parts[0] == 'Textura')
    array_shift($class_name_parts);
  $num_parts = count($class_name_parts);

  if ($num_parts > 1) {
    foreach ($class_name_parts as $k => $v) {
      if ($k < ($num_parts - 1))
        $class_name_parts[$k] = strtolower($v);
    }
  }

  $possible_paths =
          array(
              array(TEXTURA_SRC_DIR, 'textura', 'classes'),
              array(TEXTURA_SRC_DIR, 'textura', 'interfaces'),
              array(TEXTURA_SITE_DIR),
              array(TEXTURA_CONTROLLER_DIR),
              array(TEXTURA_MODEL_DIR),
  );

  foreach ($possible_paths as $current_possible_path) {
    $possible_full_path = \Textura\PathBuilder::build_path(array_merge($current_possible_path, $class_name_parts)) . '.php';
    if (file_exists($possible_full_path) && is_readable($possible_full_path)) {
      require_once($possible_full_path);
      return;
    }
  }
  trigger_error("Failed to load class $class_name", E_USER_WARNING);
}

spl_autoload_register('autoload');
?>