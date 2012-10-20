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

abstract class DBAdapter {

  // Constants for unified data types
  const TYPE_INTEGER = 1;
  const TYPE_FLOAT = 2;
  const TYPE_STRING = 3;

  abstract public function __construct(array $params);

  abstract protected function connect();

  abstract public function query($query);

  abstract public function tableExists($table);

  abstract protected function validateParams(array $params);

  abstract public function insertRow($table, array $values);

  abstract public function selectRows($table, array $conditions, array $fields = null);

  abstract public function updateRow($table, array $primary_keys, array $values);
}
?>