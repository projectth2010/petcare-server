<?php

namespace DatabaseDriver\Model;

use DatabaseDriver\SQL\MySQLDriver;

class Admin extends BaseModel
{

    // protected static $db;

    public function __construct(MySQLDriver $db)
    {
        parent::__construct($db, 'Admin');
    }

    // Initialize the database connection
    public static function init()
    {
        if (!self::$db) {

            // Adjust these parameters as per your database credentials
            self::$db = new MySQLDriver(getenv('DB_HOST'), getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
        }
    }

    /**
     * Fetch admin by username
     *
     * @param string $username
     * @return array|null
     */
    public static function getAdminByUsername($username, $pass)
    {

        self::init();
        // Build the filter for searching by username
        $filters = ['Username' => $username, 'Password' => $pass];
        // Use the SQLDriver's `read` method to query the admin by username
        $result = self::$db->read('admin', $filters, 1);

        // Return the first match or null if not found
        return $result ? $result[0] : null;
    }
}
