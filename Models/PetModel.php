<?php

namespace DatabaseDriver\Model;

use DatabaseDriver\SQL\MySQLDriver;

class Pet extends BaseModel
{
    // protected static $db;

    public function __construct(MySQLDriver $db)
    {
        parent::__construct($db, 'pet');  // 'Pet' is the table name
    }

    // Initialize the database connection
    public static function init()
    {
        if (!self::$db) {
            // Initialize the MySQLDriver with environment variables
            self::$db = new MySQLDriver(
                getenv('DB_HOST'),
                getenv('DB_DATABASE'),
                getenv('DB_USERNAME'),
                getenv('DB_PASSWORD')
            );
        }
    }

    /**
     * Fetch pet by ID
     *
     * @param int $id
     * @return array|null
     */
    public static function getPetById($id)
    {
        self::init();
        // Build the filter for searching by pet ID
        $filters = ['id' => $id];
        // Use the SQLDriver's `read` method to query the pet by ID
        $result = self::$db->read('pet', $filters, 1);  // Assuming 'pets' is your table name

        // Return the first match or null if not found
        return $result ? $result[0] : null;
    }

    /**
     * Fetch all pets with optional filters
     *
     * @param array $filters
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public static function getAllPets($filters = [], $limit = 100, $offset = 0)
    {
        self::init();
        // Fetch all pets with optional filters
        return self::$db->read('pet', $filters, $limit, $offset);
    }


    /**
     * Count total number of pets in the database.
     *
     * @return int
     */
    public static function countAll()
    {
        self::init();
        return self::$db->count('pet'); // Assuming your database driver has a `count` method
    }

    /**
     * Count the number of filtered pets based on a search query.
     *
     * @param string $searchValue
     * @return int
     */
    public static function countFiltered($searchValue)
    {
        self::init();
        $filters = [
            '$or' => [
                ['name' => ['LIKE' => '%' . $searchValue . '%']],
                ['breed' => ['LIKE' => '%' . $searchValue . '%']]
            ]
        ];
        return self::$db->count('pet', $filters);
    }

    /**
     * Fetch pets with pagination.
     *
     * @param int $start
     * @param int $length
     * @return array
     */
    public static function getAllPaginated($start, $length)
    {
        self::init();
        return self::$db->read('pet', [], $length, $start); // No filters, just pagination
    }

    /**
     * Search pets with pagination.
     *
     * @param string $searchValue
     * @param int $start
     * @param int $length
     * @return array
     */
    public static function search($searchValue, $start, $length)
    {
        self::init();
        $filters = [
            '$or' => [
                ['name' => ['LIKE' => '%' . $searchValue . '%']],
                ['breed' => ['LIKE' => '%' . $searchValue . '%']]
            ]
        ];
        return self::$db->read('pet', $filters, $length, $start); // Apply filters and pagination
    }
}
