<?php

namespace DatabaseDriver\SQL;

use PDO;
use DatabaseDriver\Core\DatabaseDriver;

abstract class SQLDriver extends DatabaseDriver
{
    protected $connection;

    public function __construct($dsn, $user, $password)
    {
        $this->connection = new PDO($dsn, $user, $password);
    }

    public function create($table, $data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->connection->prepare($query);
        return $stmt->execute($data);
    }

    public function read($table, $filters = [], $limit = null, $offset = null)
    {
        $query = "SELECT * FROM $table";
        if (!empty($filters)) {
            $whereClause = $this->buildWhereClause($filters);
            $query .= " WHERE $whereClause";
        }
        if ($limit) {
            $query .= " LIMIT $limit";
        }
        if ($offset) {
            $query .= " OFFSET $offset";
        }
        $stmt = $this->connection->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($table, $data, $filters = [])
    {
        $setClause = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));
        $query = "UPDATE $table SET $setClause";
        if (!empty($filters)) {
            $whereClause = $this->buildWhereClause($filters);
            $query .= " WHERE $whereClause";
        }
        $stmt = $this->connection->prepare($query);
        return $stmt->execute($data);
    }

    public function delete($table, $filters = [])
    {
        $query = "DELETE FROM $table";
        if (!empty($filters)) {
            $whereClause = $this->buildWhereClause($filters);
            $query .= " WHERE $whereClause";
        }
        return $this->connection->exec($query);
    }

    public function executeRawQuery($query, $params = [])
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function buildWhereClause($filters)
    {
        $whereConditions = [];
        foreach ($filters as $key => $filter) {
            if ($key === '$and') {
                $andConditions = array_map(fn($condition) => $this->buildWhereClause($condition), $filter);
                $whereConditions[] = '(' . implode(' AND ', $andConditions) . ')';
            } elseif ($key === '$or') {
                $orConditions = array_map(fn($condition) => $this->buildWhereClause($condition), $filter);
                $whereConditions[] = '(' . implode(' OR ', $orConditions) . ')';
            } else {
                $whereConditions[] = "$key = :$key";
            }
        }
        return implode(' AND ', $whereConditions);
    }
}
