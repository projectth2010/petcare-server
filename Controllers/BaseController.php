<?php

namespace Controllers;

use ResponseJSON\ResponseJSON;
use ViewTemplate\View;
use Redirect\Redirect;
use Middleware\AuthMiddleware;

use DatabaseDriver\Model\Admin;
use DatabaseDriver\Model\Pet;
use DatabaseDriver\Model\Member;

use Session\SessionManager;

class BaseController
{

    /**
     * Generate dynamic menu for the sidebar.
     */
    public function menus()
    {
        return [
            [
                'title' => 'Settings',
                'icon' => 'fas fa-cogs',
                'level' => 2, // Admin access only
                'submenu' => [
                    // ['title' => 'ผู้ใช้งานระบบ', 'url' => './users', 'active' => false, 'level' => 2], // Admin only
                    ['title' => 'สิ่งอำนวยความสะดวก', 'url' => './facilities', 'active' => true, 'level' => 2], // Owner and Admin
                    ['title' => 'ชนิดสัตว์เลี้ยง', 'url' => './pets', 'active' => false, 'level' => 2], // Owner and Admin
                    ['title' => 'รายการคำถามบ่อย Faq', 'url' => './faqs', 'active' => false, 'level' => 2], // Supervisor and higher
                ]
            ],
            [
                'title' => 'ป้ายประชาสัมพันธ์',
                'icon' => 'fas fa-bullhorn',
                'level' => 2, // Supervisor and higher
                'submenu' => [
                    ['title' => 'รายการ ภาพประชาสัมพันธ์', 'url' => './banners', 'active' => false, 'level' => 2], // Supervisor and higher
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
                'level' => 2, // Owner and Admin
                'submenu' => [
                    ['title' => 'รายการจองบ้านฝาก', 'url' => './bookings', 'active' => false, 'level' => 2], // Owner and Admin
                    ['title' => 'รายการ Check-In บ้านฝาก', 'url' => './bookingcheckins', 'active' => false, 'level' => 2] // Owner and Admin
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
}
