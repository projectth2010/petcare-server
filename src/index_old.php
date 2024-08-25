<?php

require_once 'DatabaseDriver/SQL/MySQLDriver.php';
require_once 'DatabaseDriver/SQL/PostgreSQLDriver.php';
require_once 'DatabaseDriver/NoSQL/MongoDBDriver.php';

require_once 'EnvLoader.php';

use EnvLoader\EnvLoader;
use DatabaseDriver\SQL\MySQLDriver;
// use DatabaseDriver\SQL\PostgreSQLDriver;
use DatabaseDriver\NoSQL\MongoDBDriver;


// Load the .env file
EnvLoader::load(__DIR__ . '/.env');

// Example with MySQL
$mysqlDriver = new MySQLDriver('localhost', 'test_db', 'root', 'password');

// Create example
$mysqlDriver->create('users', ['name' => 'John', 'email' => 'john@example.com']);

// Read example with multiple conditions (AND)
$users = $mysqlDriver->read('users', [
    ['name' => 'John'],
    ['email' => 'john@example.com']
]);
print_r($users);

/*** 
// Example with MongoDB
$mongoDriver = new MongoDBDriver('mongodb://localhost:27017', 'test_db');

// Create example
$mongoDriver->create('users', ['name' => 'Jane', 'email' => 'jane@example.com']);

// Read example with OR condition
$users = $mongoDriver->read('users', ['$or' => [
    ['name' => 'Jane'],
    ['email' => 'jane@example.com']
]]);
print_r($users);
 */
