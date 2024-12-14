<?php

namespace DatabaseDriver\Model;

use DatabaseDriver\SQL\MySQLDriver;

class Admin extends BaseModel
{


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
        $result = self::$db->read('Admin', $filters, 1);

        // Return the first match or null if not found
        return $result ? $result[0] : null;
    }
}
