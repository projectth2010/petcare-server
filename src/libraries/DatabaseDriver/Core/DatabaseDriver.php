<?php

namespace DatabaseDriver\Core;

abstract class DatabaseDriver
{
    abstract public function create($table, $data);
    abstract public function read($table, $filters = [], $limit = null, $offset = null);
    abstract public function update($table, $data, $filters = []);
    abstract public function delete($table, $filters = []);
    abstract public function executeRawQuery($query, $params = []);
}
