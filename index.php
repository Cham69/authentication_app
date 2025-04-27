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

$router->map('GET', '/forgotpassword', function() {
    require 'views/forgot-password.php';
});

$router->map('GET', '/reset-password', function() {
    require 'views/reset-password.php';
});

$router->map('GET', '/signup', function() {
    // If the user is already authenticated, redirect to the dashboard
    if (SessionManager::isAuthenticated()) {
        header('Location: /authentication_app/dashboard');
        exit;
    }

    if (SessionManager::registeredOnly()) {
        // If the user is already registered but not verified, redirect to the email verification page
        header('Location: /authentication_app/email-verify');
        exit;
    }

    require 'views/signup.php';

});

$router->map('GET', '/signin', function() {
    if (SessionManager::isAuthenticated()) {
        header('Location: /authentication_app/dashboard');
        exit;
    }

    if (SessionManager::registeredOnly()) {
        // If the user is already registered but not verified, redirect to the email verification page
        header('Location: /authentication_app/email-verify');
        exit;
    }

    require 'views/signin.php';
});

$router->map('GET', '/email-verify', function() {

    if (!SessionManager::registeredOnly()) {
        // If the user is already verified, redirect to the dashboard
        if (SessionManager::isAuthenticated()) {
            header('Location: /authentication_app/dashboard');
            exit;
        }

        // If not authenticated, redirect to the sign-in page
        header('Location: /authentication_app/signin');
        exit;
    }

    // If registered but not verified, show the email verification page
    require 'views/email-verify.php';
});

$router->map('GET', '/dashboard', function() {
    require 'views/dashboard.php';
    if (!SessionManager::isAuthenticated()) {

        if (SessionManager::registeredOnly()) {
            // If the user is already registered but not verified, redirect to the email verification page
            header('Location: /authentication_app/email-verify');
            exit;
        }
        
        header('Location: /authentication_app/signin');
        exit;
    }

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

$router->map('POST', '/user/verify', function() {
    require 'controllers/UserController.php';
    $user = new UserController();
    $user->verifyUser();
});

$router->map('POST', '/logout', function() {
    require 'controllers/UserController.php';
    $user = new UserController();
    $user->logout();
});

$router->map('POST', '/user/resend', function() {
    require 'controllers/UserController.php';
    $user = new UserController();
    $user->sendEmailVerification('resend');
});

$router->map('POST', '/reset-password', function() {
    require 'controllers/UserController.php';
    $user = new UserController();
    $user->sendResetPassword();
});

// Match current request
$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    http_response_code(404);
    require 'views/404.php';
}
