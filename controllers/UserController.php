<?php
// controllers/UserController.php
require_once 'models/User.php';

class UserController
{
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

            $created = $user->store($firstName, $lastName, $email, $password, $otp);

            $statusCode = $created ? '201':'500';
            http_response_code($statusCode);

            echo json_encode([
                'success' => $created ? $created : 'false',
                'message' => $created ? 'Registration successfull!' : 'Registration failed!',
                'type' => $created ? 'registration_successful' : 'registration_failed! Please try again',
                'redirect_url' => $created ? '/authentication_app': '/authentication_app/signup'
            ]);

        }else{
            http_response_code(400);
            echo json_encode(['success' => false, 
            'message' => ['lowerCase' => $hasLowerCase, 'upperCase' => $hasUpperCase, 'hasDigit' => $hasDigit, 'passwordLength' => $passwordLength, 'specialChars' => $specialChars, 'errorMsg' => 'Password validation failed (Backend)'], 
            'type' => 'password_invalid']);
            exit;
        }

    }

    public function validatePasswordInput(){

    }
}
