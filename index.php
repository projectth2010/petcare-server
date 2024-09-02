<?php
error_log(E_ALL);

// base lib
require_once 'libraries/response-json/ResponseJSON.php';
require_once 'libraries/router/Router.php';
require_once 'libraries/ViewTemplate/View.php';
require_once 'libraries/Redirect/Redirect.php';
require_once 'libraries/env-loader/EnvLoader.php';
require_once 'libraries/DatabaseDriver/Core/DatabaseDriver.php';
require_once 'libraries/DatabaseDriver/SQL/SQLDriver.php';
require_once 'libraries/DatabaseDriver/SQL/MySQLDriver.php';
require_once 'libraries/DatabaseDriver/Model/BaseModel.php';

// middleware
require_once 'Middleware/AuthMiddleware.php';
require_once 'Middleware/AuthAPIMiddleware.php';

// data models
require_once 'Models/AdminModel.php';
// require_once 'Models/MemberModel.php';
require_once 'Models/PetModel.php';

require_once 'Controllers/AuthController.php';
require_once 'controllers/UserController.php';
require_once 'controllers/WelcomeController.php';
require_once 'controllers/AdminController.php';
require_once 'controllers/PetController.php';


use Router\Router;
use Controllers\AuthController;
use Controllers\UserController;
use Controllers\AdminController;
use Controllers\WelcomeController;
use Controllers\PetController;

Middleware\AuthMiddleware::start();

// Load environment variables
EnvLoader\EnvLoader::load(__DIR__ . '/.env');

/**
 * $router->map('GET', '/admin', ['Controllers\AdminController', 'index']);
 * $router->map('GET', '/user/{id}', function ($id) {
 *     echo "User ID: $id";
 * });
 * $router->map('POST', '/login', ['Controllers\AuthController', 'login']);
 */
$router = new Router();
/** mobile api */
$router->map('GET', '/petcare/api/v1', [WelcomeController::class, 'index']);
$router->map('POST', '/petcare/api/v1/register', [AuthController::class, 'register']);
$router->map('POST', '/petcare/api/v1/login', [AuthController::class, 'login']);
$router->map('PUT', '/petcare/api/v1/update-account', [UserController::class, 'updateAccount']);
$router->map('PUT', '/petcare/api/v1/update-info', [UserController::class, 'updateInfo']);
$router->map('GET', '/petcare/api/v1/get-user', [UserController::class, 'getUser']);
$router->map('GET', '/petcare/api/v1/get-info', [UserController::class, 'getInfo']);
$router->map('POST', '/petcare/api/v1/update-image', [UserController::class, 'updateImage']);

$router->map('GET', '/petcare/api/v1/pets', [PetController::class, 'gets']);

/** admin */
$router->map('GET', '/petcare/admin/', [AdminController::class, 'index']);
$router->map('GET', '/petcare/admin/login', [AdminController::class, 'login']);
$router->map('POST', '/petcare/admin/login', function () {
    (new AdminController())->login();
});

$router->map('GET', '/petcare/admin/dashboard', function () {
    Middleware\AuthMiddleware::handle();
    (new AdminController())->dashboard();
});

$router->map('GET', '/petcare/admin/logout', function () {
    (new AdminController())->logout();
});

/** admin level control system */
$router->map('GET', '/petcare/admin/members', function () {
    Middleware\AuthMiddleware::handle();
    (new AdminController())->members();
});
$router->map('GET', '/petcare/admin/housemembers', function () {
    Middleware\AuthMiddleware::handle();
    (new AdminController())->housemembers();
});
$router->map('GET', '/petcare/admin/facilities', function () {
    Middleware\AuthMiddleware::handle();
    (new AdminController())->facilities();
});
$router->map(
    'GET',
    '/petcare/admin/pets',
    function () {
        Middleware\AuthMiddleware::handle();
        (new AdminController())->pets();
    }
);
$router->map('GET', '/petcare/admin/faqs', function () {
    Middleware\AuthMiddleware::handle();
    (new AdminController())->faqs();
});
$router->map('GET', '/petcare/admin/questionair', function () {
    Middleware\AuthMiddleware::handle();
    (new AdminController())->questionair();
});

$router->dispatch();
