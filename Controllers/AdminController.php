<?php

namespace Controllers;

use ResponseJSON\ResponseJSON;
use ViewTemplate\View;
use Redirect\Redirect;
use Middleware\AuthMiddleware;

use DatabaseDriver\Model\Admin;
use DatabaseDriver\Model\Pet;
use DatabaseDriver\Model\Member;

class AdminController
{

    private $validUsername = 'admin';
    private $validPassword = 'password';
    private $level = 9;


    /**
     * Generate dynamic menu for the sidebar.
     */
    public function menus()
    {
        return [
            [
                'title' => 'Settings',
                'icon' => 'fas fa-cogs',
                'level' => 9, // Admin access only
                'submenu' => [
                    ['title' => 'ผู้ใช้งานระบบ', 'url' => './users', 'active' => false, 'level' => 9], // Admin only
                    ['title' => 'สิ่งอำนวยความสะดวก', 'url' => './facilities', 'active' => true, 'level' => 3], // Owner and Admin
                    ['title' => 'ชนิดสัตว์เลี้ยง', 'url' => './pets', 'active' => false, 'level' => 3], // Owner and Admin
                    ['title' => 'รายการคำถามบ่อย Faq', 'url' => './helpsetting', 'active' => false, 'level' => 2], // Supervisor and higher
                ]
            ],
            [
                'title' => 'ป้ายประชาสัมพันธ์',
                'icon' => 'fas fa-bullhorn',
                'level' => 2, // Supervisor and higher
                'submenu' => [
                    ['title' => 'รายการ ภาพประชาสัมพันธ์', 'url' => './banners', 'active' => false, 'level' => 2] // Supervisor and higher
                ]
            ],
            [
                'title' => 'การจัดการข้อมูล',
                'icon' => 'fas fa-database',
                'level' => 1, // Available to all
                'submenu' => [
                    ['title' => 'Dashboard', 'url' => './dashboard', 'active' => false, 'level' => 1], // All users
                    ['title' => 'สมาชิกประเภทบ้านฝาก', 'url' => './members', 'active' => false, 'level' => 2], // Supervisor and higher
                    ['title' => 'สมาชิกประเภทลูกค้า', 'url' => './customers', 'active' => false, 'level' => 1] // All users
                ]
            ],
            [
                'title' => 'จัดการคำถาม คำตอบ บ้านฝาก',
                'icon' => 'fas fa-question-circle',
                'level' => 2, // Supervisor and higher
                'submenu' => [
                    ['title' => 'หัวข้อคำถาม', 'url' => './quizs', 'active' => false, 'level' => 2] // Supervisor and higher
                ]
            ],
            [
                'title' => 'รายการบ้านฝาก',
                'icon' => 'fas fa-home',
                'level' => 3, // Owner and Admin
                'submenu' => [
                    ['title' => 'รายการจองบ้านฝาก', 'url' => './bookings', 'active' => false, 'level' => 3], // Owner and Admin
                    ['title' => 'รายการ Check-In บ้านฝาก', 'url' => './bookingcheckins', 'active' => false, 'level' => 3] // Owner and Admin
                ]
            ]
        ];
    }

    public function generateMenu($menuItems, $userLevel)
    {
        $html = '<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">';

        foreach ($menuItems as $menuItem) {
            // Check if the user has access to this menu based on their level
            if ($userLevel >= $menuItem['level']) {
                $hasSubmenu = isset($menuItem['submenu']) && !empty($menuItem['submenu']);
                $isActive = isset($menuItem['active']) && $menuItem['active'] ? 'active' : '';
                $submenuIcon = $hasSubmenu ? '<i class="right fas fa-angle-left"></i>' : '';

                // Main menu item
                $html .= '
                <li class="nav-item ' . ($hasSubmenu ? 'menu-open' : '') . '">
                    <a href="' . $menuItem['url'] . '" class="nav-link ' . $isActive . '">
                        <i class="nav-icon ' . $menuItem['icon'] . '"></i>
                        <p>' . $menuItem['title'] . $submenuIcon . '</p>
                    </a>';

                // Submenu items, if any
                if ($hasSubmenu) {
                    $html .= '<ul class="nav nav-treeview">';
                    foreach ($menuItem['submenu'] as $submenuItem) {
                        // Check if user has access to the submenu item
                        if ($userLevel >= $submenuItem['level']) {
                            $isSubActive = isset($submenuItem['active']) && $submenuItem['active'] ? 'active' : '';
                            $html .= '
                            <li class="nav-item">
                                <a href="' . $submenuItem['url'] . '" class="nav-link ' . $isSubActive . '">
                                    <i class="fas fa-circle nav-icon"></i>
                                    <p>' . $submenuItem['title'] . '</p>
                                </a>
                            </li>';
                        }
                    }
                    $html .= '</ul>';
                }

                $html .= '</li>';
            }
        }

        $html .= '</ul>';
        return $html;
    }


    public function index()
    {
        // Apply middleware to check if the user is logged in
        AuthMiddleware::handle();

        // Render the dashboard or other views
        Redirect::to('/petcare/admin/dashboard');
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
                $_SESSION['user'] = $admin['username'];
                $_SESSION['user_level'] = $admin['level'];

                // Redirect to dashboard
                Redirect::to('/petcare/admin/dashboard');
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
        $view->render('admin/dashboard', [
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
        Redirect::to('/petcare/admin/login');
    }

    /**
     * Display the Members page.
     */
    public function member()
    {
        $view = new View();
        // Fetch data or logic for members can be placed here
        $view->render('admin/members', [
            'message' => 'Viewing Members',
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
        $view->render('admin/housemembers', [
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
        $view->render('admin/facilities', [
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
        $view->render('admin/pets', [
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
        $view->render('admin/faqs', [
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
        $view->render('admin/questionair', [
            'message' => 'Viewing Questionnaires',
            'self' => $this // Pass dynamic menu
        ]);
    }
}
