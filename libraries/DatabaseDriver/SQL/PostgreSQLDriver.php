<?php

namespace DatabaseDriver\SQL;

use DatabaseDriver\SQL\SQLDriver;

class PostgreSQLDriver extends SQLDriver
{
    public function __construct($host, $dbname, $user, $password)
    {
        $dsn = "pgsql:host=$host;dbname=$dbname";
        parent::__construct($dsn, $user, $password);
    }
}
