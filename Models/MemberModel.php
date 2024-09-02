<?php

namespace DatabaseDriver\Model;

class Member extends BaseModel
{
    public function __construct(MySQLDriver $db)
    {
        parent::__construct($db, 'Member');
    }
}
