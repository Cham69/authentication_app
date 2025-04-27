<?php 
    require_once('./components/navbar.php');
    require 'config/recaptcha.php';
?>
    <section class="container row mx-auto card my-5 py-3" style="max-width:60%">
        <div class="row">
            <div class="col-md-6 ">
                <div class="text-center">
                    <img src="./images/sign_in.png" alt="signup image" width="60%" class="text-center">
                </div>
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

                        <!-- Google reCAPTCHA widget -->
                        <div class="g-recaptcha mb-2" data-sitekey="<?php echo htmlspecialchars($site_key); ?>"></div>
                        <span class="text-xs text-danger recaptchaErr" id="recaptchaErr"></span>

                        <button type="submit" class="btn btn-primary w-100" id="signupBtn">Sign Up<span class="spinner-border-sm ms-2" id="signup-spinner" aria-hidden="true"></span></button>
                        <span class="text-xs text-danger backendErr" id="backendErr"></span>
                        <p class="text-sm mt-2">Already have an account? <a href="/authentication_app/signin">Sign in</a></p>
                    </form>
                </div>  
            </div>
        </div>
    </section>
    <?php 
        require_once('./components/footer.php');
    ?>
    