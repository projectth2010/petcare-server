<?php

namespace DatabaseDriver\Model;

use DatabaseDriver\SQL\MySQLDriver;

class BaseModel
{
    protected $table;

    public function __construct(MySQLDriver $db, $table)
    {
        $this->db = $db;
        $this->table = $table;
    }

    protected static ?MySQLDriver $db = null; // Make sure this is initialized to null

    // Initialize the database connection
    public static function init()
    {
        // Only initialize the connection if it's not already set
        if (self::$db === null) {
            self::$db = new MySQLDriver(
                getenv('DB_HOST'),
                getenv('DB_DATABASE'),
                getenv('DB_USERNAME'),
                getenv('DB_PASSWORD')
            );
        }
    }
}
