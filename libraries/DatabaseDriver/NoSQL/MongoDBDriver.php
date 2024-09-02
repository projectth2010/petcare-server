<?php

namespace DatabaseDriver\NoSQL;

use MongoDB\Client;

class MongoDBDriver extends NoSQLDriver
{
    public function __construct($uri, $dbname)
    {
        $client = new Client($uri);
        parent::__construct($client->$dbname);
    }
}
