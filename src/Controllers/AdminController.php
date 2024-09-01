<?php

namespace Controllers;

use ResponseJSON\ResponseJSON;
use ViewTemplate\View;
use Redirect\Redirect;
use Middleware\AuthMiddleware;

class AdminController
{

    private $validUsername = 'admin';
    private $validPassword = 'password';

    public function index()
    {
        // Apply middleware to check if the user is logged in
        AuthMiddleware::handle();

        // Render the dashboard or other views
        Redirect::to('/admin/dashboard');
    }

    public function login()
    {
        $view = new View();
        $error = null;

        // Check if form was submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            // Simple validation against hardcoded credentials
            if ($username === $this->validUsername && $password === $this->validPassword) {
                // Set session for the logged-in user
                $_SESSION['user'] = $username;

                // Redirect to dashboard
                Redirect::to('/admin/dashboard');
            } else {
                // Invalid login, show an error
                $error = 'Invalid username or password.';
            }
        }

        // Render the login view with optional error message
        $view->render('admin/login', ['message' => 'Please login', 'error' => $error]);
    }

    public function dashboard()
    {
        // Apply middleware to check if the user is logged in
        AuthMiddleware::handle();

        // Render dashboard
        $view = new View();
        $view->render('admin/dashboard', [
            'message' => 'Welcome to the Admin Dashboard!',
            'user' => $_SESSION['user']
        ]);
    }

    public function logout()
    {
        // Destroy the session to log out the user
        session_destroy();

        // Redirect to login page
        Redirect::to('/admin/login');
    }

    /**
     * Display the Members page.
     */
    public function member()
    {
        $view = new View();
        // Fetch data or logic for members can be placed here
        $view->render('admin/members', ['message' => 'Viewing Members']);
    }

    /**
     * Display the House Members page.
     */
    public function housemembers()
    {
        $view = new View();
        // Fetch data or logic for house members can be placed here
        $view->render('admin/housemembers', ['message' => 'Viewing House Members']);
    }

    /**
     * Display the Facilities page.
     */
    public function facilities()
    {
        $view = new View();
        // Fetch data or logic for facilities can be placed here
        $view->render('admin/facilities', ['message' => 'Viewing Facilities']);
    }

    /**
     * Display the Pets page.
     */
    public function pets()
    {
        $view = new View();
        // Fetch data or logic for pets can be placed here
        $view->render('admin/pets', ['message' => 'Viewing Pets']);
    }

    /**
     * Display the FAQs page.
     */
    public function faqs()
    {
        $view = new View();
        // Fetch data or logic for FAQs can be placed here
        $view->render('admin/faqs', ['message' => 'Frequently Asked Questions']);
    }

    /**
     * Display the Questionnaires page.
     */
    public function questionair()
    {
        $view = new View();
        // Fetch data or logic for questionnaires can be placed here
        $view->render('admin/questionair', ['message' => 'Viewing Questionnaires']);
    }
}
