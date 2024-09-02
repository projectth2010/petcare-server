<?php

namespace DatabaseDriver\Model;

class Pet extends BaseModel
{
    public function __construct(MySQLDriver $db)
    {
        parent::__construct($db, 'Pet');
    }
}
