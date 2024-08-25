<?php

namespace DatabaseDriver\NoSQL;

use DatabaseDriver\Core\DatabaseDriver;

abstract class NoSQLDriver extends DatabaseDriver
{
    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function create($collection, $data)
    {
        return $this->client->$collection->insertOne($data);
    }

    public function read($collection, $filters = [], $limit = null, $offset = null)
    {
        $options = [];
        if ($limit) {
            $options['limit'] = $limit;
        }
        if ($offset) {
            $options['skip'] = $offset;
        }
        return $this->client->$collection->find($filters, $options)->toArray();
    }

    public function update($collection, $data, $filters = [])
    {
        return $this->client->$collection->updateMany($filters, ['$set' => $data]);
    }

    public function delete($collection, $filters = [])
    {
        return $this->client->$collection->deleteMany($filters);
    }

    public function executeRawQuery($query, $params = [])
    {
        // Implementation depends on NoSQL database capabilities.
        throw new \Exception("Raw query execution not supported for this NoSQL driver.");
    }
}
