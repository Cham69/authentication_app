<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" 
        rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" 
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="./styles/style.css">
    <title>Authentication App</title>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php 
        require_once('./components/navbar.php');
    ?>
    <section class="container row mx-auto card my-5 py-3" style="max-width:60%">
        <div class="row">
            <div class="col-md-6 ">
                <img src="./images/hero.png" alt="signup image" width="80%" class="mb-2">
                <div id="passwordPolicy" class="passwordPolicy">
                    <i class="bi bi-key-fill large-icons text-success"></i> Choose a Password : <br>
                    <ul>
                        <li class="text-danger" id="characterCountCheck">At least 8 characters long <i class="bi bi-shield-x"></i></li>
                        <li class="text-danger" id="lowerCaseCheck">At least one lower case letter <i class="bi bi-shield-x"></i></li>
                        <li class="text-danger" id="upperCaseCheck">At least one upper case letter <i class="bi bi-shield-x"></i></li>
                        <li class="text-danger" id="digitsCheck">At least one number <i class="bi bi-shield-x"></i></li>
                        <li class="text-danger" id="charCheck">At least one special character Ex:- @, #, $...<i class="bi bi-shield-x"></i></li>
                    </ul>
                </div>
                <p class="passwordPolicy">Note - Your password will be expired in 30 days. You must reset the password once expired!</p>
            </div>
            <div class="col-md-6">
                <div class="mx-auto" >
                    <div>
                        <h5 class="mb-4 topic-text poppins-medium">Sign Up Now!</h5>
                    </div>
                    <form id="signupForm">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="firstName" placeholder="First Name">
                            <span class="text-xs text-danger inputErr" id="firstNameErr"></span>
                        </div>
                        <div class="mb-3">
                            <span class="text-xs inputErr" id="lastNameErr">(Optional)</span>
                            <input type="text" class="form-control" id="lastName" placeholder="Last Name">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Email Address">
                            <span class="text-xs text-danger inputErr" id="emailErr"></span>
                        </div>
                        <div class="mb-3 position-relative">
                            <input type="password" class="form-control pe-5" id="password" placeholder="Password" oninput="validatePassword();">
                            <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer" id="passwordEye" onclick="passwordShowHide('password');"></i>
                            <span class="text-xs text-danger inputErr" id="passwordErr"></span>
                        </div>
                        <div class="mb-3 position-relative">
                            <input type="password" class="form-control pe-5" id="confirmPassword" placeholder="Confirm Password" oninput="crossCheckPassword(this);">
                            <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer" id="confirmPasswordEye" onclick="passwordShowHide('confirmPassword');"></i>
                            <span class="text-xs text-danger inputErr" id="confirmPasswordErr"></span>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" id="signupBtn">Sign Up<span class="spinner-border-sm ms-2" id="signup-spinner" aria-hidden="true"></span></button>
                        <span class="text-xs text-danger backendErr" id="backendErr"></span>
                        <p class="text-sm mt-2">Already have an account? <a href="#">Sign in</a></p>
                    </form>
                </div>  
            </div>
        </div>
    </section>
    <?php 
        require_once('./components/footer.php');
    ?>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="./js/helper.js"></script>
    <script src="./js/signup.js"></script>
</body>
</html>