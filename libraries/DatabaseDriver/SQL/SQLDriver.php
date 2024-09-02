<?php

namespace DatabaseDriver\SQL;

use PDO;
use PDOException; // Importing PDOException correctly
use Exception;    // Using the global Exception class
use DatabaseDriver\Core\DatabaseDriver;

abstract class SQLDriver extends DatabaseDriver
{
    protected $connection;

    public function __construct($dsn, $user, $password)
    {
        // Enable PDO exceptions for better error handling
        $this->connection = new PDO($dsn, $user, $password);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        var_dump($this->connection);
    }



    public function create($table, $data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->connection->prepare($query);
        return $stmt->execute($data);
    }



    public function update($table, $data, $filters = [])
    {
        try {
            $setClause = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));
            $query = "UPDATE $table SET $setClause";
            if (!empty($filters)) {
                $whereClause = $this->buildWhereClause($filters);
                $query .= " WHERE $whereClause";
            }
            $stmt = $this->connection->prepare($query);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function delete($table, $filters = [])
    {
        try {
            $query = "DELETE FROM $table";
            if (!empty($filters)) {
                $whereClause = $this->buildWhereClause($filters);
                $query .= " WHERE $whereClause";
            }
            return $this->connection->exec($query);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Find a record by its ID.
     * 
     * @param string $table - The name of the table
     * @param int|string $id - The ID of the record to find
     * @param string $primaryKey - The name of the primary key column (default is 'id')
     * @return array|false - The found record or false if not found
     */
    public function findById($table, $id, $primaryKey = 'id')
    {
        $query = "SELECT * FROM $table WHERE $primaryKey = :id LIMIT 1";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function executeRawQuery($query, $params = [])
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function read($table, $filters = [], $limit = null, $offset = null)
    {
        $params = [];
        $whereClause = $this->buildWhereClause($filters, $params, "_");


        $query = "SELECT * FROM $table WHERE $whereClause";
        if ($limit) {
            $query .= " LIMIT $limit";
        }
        if ($offset) {
            $query .= " OFFSET $offset";
        }

        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function buildWhereClause($filters, &$params, $prefix = '')
    {
        $whereConditions = [];
        $index = 0; // To ensure unique placeholder names

        foreach ($filters as $key => $filter) {
            if ($key === '$and') {
                $andConditions = array_map(fn($condition) => $this->buildWhereClause($condition, $params, $prefix . $index++), $filter);
                $whereConditions[] = '(' . implode(' AND ', $andConditions) . ')';
            } elseif ($key === '$or') {
                $orConditions = array_map(fn($condition) => $this->buildWhereClause($condition, $params, $prefix . $index++), $filter);
                $whereConditions[] = '(' . implode(' OR ', $orConditions) . ')';
            } else {
                // Generate a unique placeholder name
                $uniqueKey = $key . $prefix . $index++;

                if (is_array($filter)) {
                    foreach ($filter as $operator => $value) {
                        $whereConditions[] = "$key $operator :$uniqueKey";
                        $params[":$uniqueKey"] = $value; // Bind the value to the placeholder
                    }
                } else {
                    $whereConditions[] = "$key = :$uniqueKey";
                    $params[":$uniqueKey"] = $filter; // Bind the value to the placeholder
                }
            }
        }

        return implode(' AND ', $whereConditions);
    }
}
