<?php

namespace DatabaseDriver\SQL;

use DatabaseDriver\SQL\SQLDriver;

class MySQLDriver extends SQLDriver
{
    public function __construct($host, $dbname, $user, $password)
    {

        if (!$host || !$dbname || !$user) {
            throw new \Exception('Database configuration is missing in environment variables.');
        }

        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
        parent::__construct($dsn, $user, $password);
    }
}
