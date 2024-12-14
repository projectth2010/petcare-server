<?php



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
require_once 'Models/MemberModel.php';
require_once 'Models/CustomerModel.php';
require_once 'Models/PetModel.php';

require_once 'Controllers/AuthController.php';
require_once 'Controllers/UserController.php';
require_once 'Controllers/WelcomeController.php';
require_once 'Controllers/AdminController.php';
require_once 'Controllers/PetController.php';

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
$router->map('GET', '/api/v1', [WelcomeController::class, 'index']);
$router->map('POST', '/api/v1/register', [AuthController::class, 'register']);
$router->map('POST', '/api/v1/login', [AuthController::class, 'login']);
$router->map('PUT', '/api/v1/update-account', [UserController::class, 'updateAccount']);
$router->map('PUT', '/api/v1/update-info', [UserController::class, 'updateInfo']);
$router->map('GET', '/api/v1/get-user', [UserController::class, 'getUser']);
$router->map('GET', '/api/v1/get-info', [UserController::class, 'getInfo']);
$router->map('POST', '/api/v1/update-image', [UserController::class, 'updateImage']);

$router->map('GET', '/api/v1/pets', function () {
    (new PetController())->gets();
});
$router->map('POST', '/api/v1/pet', function () {
    (new PetController())->create();
});


/** admin */
$router->map('GET', '/admin/', [AdminController::class, 'index']);
$router->map('GET', '/admin/login', [AdminController::class, 'login']);
$router->map('POST', '/admin/login', function () {
    (new AdminController())->login();
});

$router->map('GET', '/admin/dashboard', function () {
    Middleware\AuthMiddleware::handle();
    (new AdminController())->dashboard();
});

$router->map('GET', '/admin/logout', function () {
    (new AdminController())->logout();
});

/** admin level control system */
$router->map('GET', '/admin/members', function () {
    Middleware\AuthMiddleware::handle();
    (new AdminController())->members();
});
$router->map('GET', '/admin/housemembers', function () {
    Middleware\AuthMiddleware::handle();
    (new AdminController())->housemembers();
});
$router->map('GET', '/admin/facilities', function () {
    Middleware\AuthMiddleware::handle();
    (new AdminController())->facilities();
});
$router->map(
    'GET',
    '/admin/pets',
    function () {
        Middleware\AuthMiddleware::handle();
        (new AdminController())->pets();
    }
);
$router->map('GET', '/admin/faqs', function () {
    Middleware\AuthMiddleware::handle();
    (new AdminController())->faqs();
});
$router->map('GET', '/admin/questionair', function () {
    Middleware\AuthMiddleware::handle();
    (new AdminController())->questionair();
});

$router->dispatch();
// phpinfo();
