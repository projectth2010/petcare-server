<?php

namespace Controllers;

use ResponseJSON\ResponseJSON;
use ViewTemplate\View;

class AdminController
{

    public function index()
    {
        $view = new View();

        // Passing data to the view and rendering
        $view->render('admin/admin', ['message' => 'Welcome to the Admin Dashboard!']);
    }

    public function login()
    {
        $view = new View();

        // Passing data to the view and rendering
        $view->render('admin/login', ['message' => 'Welcome to the Admin Dashboard!']);
    }

    public function dashboard()
    {
        $view = new View();

        // Passing data to the view and rendering
        $view->render('admin/dashboard', ['message' => 'Welcome to the Admin Dashboard!']);
    }
}
