<?php
require_once 'libraries/router/Router.php';
require_once 'Controllers/AuthController.php';
require_once 'controllers/UserController.php';

use Router\Router;
use Controllers\AuthController;
use Controllers\UserController;

$router = new Router();
$router->map('POST', '/register', AuthController::class, 'register');
