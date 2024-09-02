<?php

namespace DatabaseDriver\Model;

use DatabaseDriver\SQL\MySQLDriver;

class BaseModel
{
    protected static $db;
    protected $table;

    public function __construct(MySQLDriver $db, $table)
    {
        $this->db = $db;
        $this->table = $table;
    }

    public function insert(array $data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO $this->table ($columns) VALUES ($placeholders)";
        $stmt = $this->db->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute();
    }

    public function update($id, array $data, $primaryKey = 'id')
    {
        $setString = '';
        foreach ($data as $key => $value) {
            $setString .= "$key = :$key, ";
        }
        $setString = rtrim($setString, ', ');

        $sql = "UPDATE $this->table SET $setString WHERE $primaryKey = :id";
        $stmt = $this->db->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindValue(":id", $id);

        return $stmt->execute();
    }

    public function delete($id, $primaryKey = 'id')
    {
        $sql = "DELETE FROM $this->table WHERE $primaryKey = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $id);

        return $stmt->execute();
    }

    public function find($id, $primaryKey = 'id')
    {
        $sql = "SELECT * FROM $this->table WHERE $primaryKey = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function findAll()
    {
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }
}
