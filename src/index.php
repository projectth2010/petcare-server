<?php
require_once 'libraries/router/Router.php';
require_once 'Controllers/AuthController.php';
require_once 'controllers/UserController.php';

use Router\Router;
use Controllers\AuthController;
use Controllers\UserController;

$router = new Router();
$router->map('POST', '/register', AuthController::class, 'register');
$router->map('POST', 'login', [AuthController::class, 'login']);
$router->map('PUT', '/update-account', [UserController::class, 'updateAccount']);
$router->map('PUT', '/update-info', [UserController::class, 'updateInfo']);
$router->map('GET', '/get-user', [UserController::class, 'getUser']);
$router->map('GET', '/get-info', [UserController::class, 'getInfo']);
$router->map('POST', '/update-image', [UserController::class, 'updateImage']);

$router->dispatch();
