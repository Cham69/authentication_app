<?php
// index.php

require 'core/SessionManager.php';
SessionManager::start();

date_default_timezone_set('Asia/Colombo');
require 'vendor/autoload.php';

$router = new AltoRouter();
$router->setBasePath('/authentication_app'); // Important!

// Define routes
$router->map('GET', '/', function() {
    require 'views/home.php';
});

$router->map('GET', '/signup', function() {
    if (!SessionManager::isAuthenticated()) {
        require 'views/signup.php';
        exit;
    }
    header('Location: /authentication_app/dashboard');
    require 'views/dashboard.php';
});

$router->map('GET', '/signin', function() {
    if (!SessionManager::isAuthenticated()) {
        require 'views/signin.php';
        exit;
    }
    header('Location: /authentication_app/dashboard');
    require 'views/dashboard.php';
});

$router->map('GET', '/dashboard', function() {
    if (!SessionManager::isAuthenticated()) {
        header('Location: /authentication_app/signin');
        exit;
    }
    require 'views/dashboard.php';
});

$router->map('POST', '/user/store', function() {
    require 'controllers/UserController.php';
    $user = new UserController();
    $user->store();
});

$router->map('POST', '/user/authenticate', function() {
    require 'controllers/UserController.php';
    $user = new UserController();
    $user->authenticate();
});

$router->map('POST', '/logout', function() {
    require 'controllers/UserController.php';
    $user = new UserController();
    $user->logout();
});

// Match current request
$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    http_response_code(404);
    require 'views/404.php';
}
