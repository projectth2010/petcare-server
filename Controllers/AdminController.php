<?php

namespace Controllers;

use ResponseJSON\ResponseJSON;
use ViewTemplate\View;
use Redirect\Redirect;
use Middleware\AuthMiddleware;

use DatabaseDriver\Model\Admin;
use DatabaseDriver\Model\Pet;
use DatabaseDriver\Model\Member;

use Controllers\BaseController;

use Session\SessionManager;

class AdminController extends BaseController
{

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

            $username = $_POST['u'] ?? '';
            $password = $_POST['p'] ?? '';

            // Fetch admin data from the database 
            $admin = Admin::getAdminByUsername($username, $password);

            if (is_array($admin) && count($admin) > 0) {

                // Verify the password using bcrypt
                // Set session for the logged-in user
                $_SESSION['user'] = $admin['Username'];
                $_SESSION['username'] = $admin['Username'];
                $_SESSION['user_level'] = $admin['level'];

                // Redirect to dashboard
                Redirect::to('/admin/dashboard');
            } else {
                // Invalid username
                $error = 'Invalid username.';
            }
        }

        // Render the login view with optional error message
        $view->render('admin/login', ['message' => 'Please login', 'error' => $error]);
    }

    public function dashboard()
    {
        // Render dashboard
        $view = new View();
        $view->render('admin/dashboard/dashboard', [
            'message' => 'Welcome to the Admin Dashboard!',
            'user' => $_SESSION['user'],
            'self' => $this // Pass dynamic menu
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
    public function members()
    {
        $view = new View();
        // Fetch data or logic for members can be placed here
        $view->render('admin/member/member', [
            'message' => 'Viewing Members',
            'self' => $this // Pass dynamic menu
        ]);
    }

    /**
     * Display the Customer page.
     */
    public function customers()
    {
        $view = new View();
        // Fetch data or logic for members can be placed here
        $view->render('admin/customer/customer', [
            'message' => 'Viewing Customers',
            'self' => $this // Pass dynamic menu
        ]);
    }

    /**
     * Display the House Members page.
     */
    public function housemembers()
    {
        $view = new View();
        // Fetch data or logic for house members can be placed here
        $view->render('admin/housemember/housemember', [
            'message' => 'Viewing House Members',
            'self' => $this // Pass dynamic menu
        ]);
    }

    /**
     * Display the Facilities page.
     */
    public function facilities()
    {
        $view = new View();
        // Fetch data or logic for facilities can be placed here
        $view->render('admin/facility/facility', [
            'message' => 'Viewing Facilities',
            'self' => $this // Pass dynamic menu
        ]);
    }

    /**
     * Display the Pets page.
     */
    public function pets()
    {
        $view = new View();
        // Fetch data or logic for pets can be placed here
        $view->render('admin/pet/pet', [
            'message' => 'Viewing Pets',
            'self' => $this // Pass dynamic menu
        ]);
    }

    /**
     * Display the FAQs page.
     */
    public function faqs()
    {
        $view = new View();
        // Fetch data or logic for FAQs can be placed here
        $view->render('admin/faq/faq', [
            'message' => 'Frequently Asked Questions',
            'self' => $this // Pass dynamic menu
        ]);
    }

    /**
     * Display the Questionnaires page.
     */
    public function questionair()
    {
        $view = new View();
        // Fetch data or logic for questionnaires can be placed here
        $view->render('admin/quiz/questionair', [
            'message' => 'Viewing Questionnaires',
            'self' => $this // Pass dynamic menu
        ]);
    }
}
