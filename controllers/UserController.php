<?php
// controllers/UserController.php
require_once 'models/User.php';

class UserController
{
    private $secret_key;

    public function __construct()
    {
        require_once 'config/recaptcha.php';
        $this->secret_key = $secret_key;
    }

    public function store()
    {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);

        $firstName = trim($input['firstName']);
        $lastName = trim($input['lastName']);
        $email = trim($input['email']);
        $password = $input['password'];
        $confirmPassword = $input['confirmPassword'];

        // if(!empty($email)){
        //     echo json_encode(['success' => false, 'message' => 'This email is already taken! Try a different email or sign in instead']);
        //     exit;
        // }

        if (empty($firstName) || empty($email) || empty($password) || empty($confirmPassword)) {

            if(empty($firstName)){
                $firstNameMsg = 'First name is required (Backend validation)';
            }else{
                $firstNameMsg = '';
            }

            if(empty($email)){
                $emailMsg = 'Email is required (Backend validation)';
            }else{
                $emailMsg = '';
            }

            if(empty($password)){
                $passwordMsg = 'Password is required (Backend validation)';
            }else{
                $passwordMsg = '';
            }

            if(empty($confirmPassword)){
                $confirmPasswordMsg = 'Confirm Password is required (Backend validation)';
            }else{
                $confirmPasswordMsg = '';
            }

            http_response_code(400);
            echo json_encode(['success' => false, 
                            'message' => ['firstNameErr' => $firstNameMsg, 'emailErr' => $emailMsg, 'passwordErr' => $passwordMsg, 'confirmPasswordErr' => $confirmPasswordMsg], 
                            'type' => 'empty_fields']);
            exit;
        }

        if ($password !== $confirmPassword) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Oops! Password and confirm password does not match', 'type' => 'password_missmatch']);
            exit;
        }

        $hasLowerCase = !!preg_match('/[a-z]/', $password);
        $hasUpperCase = !!preg_match('/[A-Z]/', $password);
        $hasDigit = !!preg_match('/\d/', $password);
        $passwordLength = strlen($password) >= 8;
        $specialChars = !!preg_match('/[^A-Za-z0-9]/', $password);

        if($hasLowerCase && $hasUpperCase && $hasDigit && $passwordLength && $specialChars){
            $otp = random_int(100000, 999999);
            
            $user = new User();

            $existingUser = $user->getUserByEmail($email);
            if ($existingUser) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'This email is already taken! Try a different email or sign in instead', 'type' => 'email_taken', 'redirect_url' => '/authentication_app/signup']);
                exit;
            }

            // reCAPTCHA response from frontend
            $recaptchaResponse = $input['recaptcha_response'] ?? null;
            $secretKey = $this->secret_key;

            // Verify reCAPTCHA with Google
            $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$recaptchaResponse");
            $responseData = json_decode($verifyResponse);

            if (!$responseData->success) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'reCAPTCHA verification failed', 'type' => 'recaptcha_failed']);
                exit;
            }

            $created = $user->store($firstName, $lastName, $email, $password, $otp);

            if($created){
                SessionManager::login($email);
                SessionManager::set('first_name', $firstName);
                SessionManager::set('last_name', $lastName);
            }

            $statusCode = $created ? '201':'500';
            http_response_code($statusCode);

            echo json_encode([
                'success' => $created ? $created : 'false',
                'message' => $created ? 'Registration successfull!' : 'Registration failed!',
                'type' => $created ? 'registration_successful' : 'registration_failed! Please try again',
                'redirect_url' => $created ? '/authentication_app/dashboard': '/authentication_app/signup'
            ]);

        }else{
            http_response_code(400);
            echo json_encode(['success' => false, 
            'message' => ['lowerCase' => $hasLowerCase, 'upperCase' => $hasUpperCase, 'hasDigit' => $hasDigit, 'passwordLength' => $passwordLength, 'specialChars' => $specialChars, 'errorMsg' => 'Password validation failed (Backend)'], 
            'type' => 'password_invalid']);
            exit;
        }

    }

    public function authenticate()
    {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);

        $email = trim($input['email']);
        $password = $input['password'];

        // reCAPTCHA response from frontend
        $recaptchaResponse = $input['recaptcha_response'] ?? null;
        $secretKey = $this->secret_key;

        // Verify reCAPTCHA with Google
        $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$recaptchaResponse");
        $responseData = json_decode($verifyResponse);

        if (empty($email) || empty($password)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => '* All fields are required (backend)', 'type' => 'empty_fields']);
            exit;
        }

        if ($responseData->success) {
            $user = new User();
            $authenticatedUser = $user->authenticate($email, $password);

            if ($authenticatedUser) {
                SessionManager::login($authenticatedUser['email']);
                SessionManager::set('first_name', $authenticatedUser['first_name']);
                SessionManager::set('last_name', $authenticatedUser['last_name']);
                http_response_code(200);
                echo json_encode(['success' => true, 'message' => 'Authenticated successfully. You will be redirected to your dashboard!', 'redirect_url' => '/authentication_app/dashboard']);
            } else {
                http_response_code(401);
                echo json_encode(['success' => false, 'message' => 'The email or password is incorrect', 'type' => 'invalid_credentials']);
                exit;
            }
        }else{
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'reCAPTCHA verification failed', 'type' => 'recaptcha_failed']);
            exit;
        }

    }

    public function logout()
    {
        SessionManager::logout();
        header('Location: /authentication_app/signin');
        exit;
    }

    public function validatePasswordInput(){

    }
}
