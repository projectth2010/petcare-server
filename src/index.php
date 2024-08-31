<?php
error_log(E_ALL);

require_once 'libraries/response-json/ResponseJSON.php';
require_once 'libraries/router/Router.php';
require_once 'libraries/ViewTemplate/View.php';

require_once 'Controllers/AuthController.php';
require_once 'controllers/UserController.php';
require_once 'controllers/WelcomeController.php';
require_once 'controllers/AdminController.php';

use Router\Router;
use Controllers\AuthController;
use Controllers\UserController;
use Controllers\AdminController;
use Controllers\WelcomeController;

/**
 * $router->map('GET', '/admin', ['Controllers\AdminController', 'index']);
 * $router->map('GET', '/user/{id}', function ($id) {
 *     echo "User ID: $id";
 * });
 * $router->map('POST', '/login', ['Controllers\AuthController', 'login']);
 */
$router = new Router();
/** mobile api */
$router->map('GET', '/', [WelcomeController::class, 'index']);
$router->map('POST', '/register', [AuthController::class, 'register']);
$router->map('POST', '/login', [AuthController::class, 'login']);
$router->map('PUT', '/update-account', [UserController::class, 'updateAccount']);
$router->map('PUT', '/update-info', [UserController::class, 'updateInfo']);
$router->map('GET', '/get-user', [UserController::class, 'getUser']);
$router->map('GET', '/get-info', [UserController::class, 'getInfo']);
$router->map('POST', '/update-image', [UserController::class, 'updateImage']);

/** admin */
$router->map('GET', '/admin/', [AdminController::class, 'index']);
$router->map('GET', '/admin/login', [AdminController::class, 'login']);
$router->map('GET', '/admin/dashboard', [AdminController::class, 'dashboard']);

/** admin level control system */
$router->map('GET', '/admin/members', [AdminController::class, 'member']);
$router->map('GET', '/admin/housemembers', [AdminController::class, 'housemembers']);
$router->map('GET', '/admin/facilities', [AdminController::class, 'facilities']);
$router->map('GET', '/admin/pets', [AdminController::class, 'pets']);
$router->map('GET', '/admin/faqs', [AdminController::class, 'faqs']);
$router->map('GET', '/admin/pets', [AdminController::class, 'pets']);
$router->map('GET', '/admin/questionair', [AdminController::class, 'questionair']);

$router->dispatch();
