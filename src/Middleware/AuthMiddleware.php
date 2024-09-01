<?php

namespace Middleware;

use Redirect\Redirect;

class AuthMiddleware
{
    public static function handle()
    {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if the user is logged in (session variable exists)
        if (!isset($_SESSION['user'])) {
            // User is not logged in, redirect to the login page
            Redirect::to('/admin/login');
            exit;
        }
    }
}
