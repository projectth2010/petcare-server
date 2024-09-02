<?php

namespace Controllers;

use ResponseJSON\ResponseJSON;

class WelcomeController
{

    public function __construct() {}

    public function index()
    {
        ResponseJSON::send([], 200, 'Welcome Api 1.0');
    }
}
