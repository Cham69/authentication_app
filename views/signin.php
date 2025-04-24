<?php 
    require_once('./components/navbar.php');
?>
    <section class="container my-5 py-3" style="max-width:60%">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="./images/sign_in.png" alt="signup image" width="80%" class="mb-2">
            </div>
            <div class="col-md-6 card py-3">
                <div>
                    <h5 class="mb-4 topic-text poppins-medium">Sign In</h5>
                </div>
                <form id="signupForm">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Email Address">
                        <span class="text-xs text-danger inputErr" id="emailErr"></span>
                    </div>
                    <div class="mb-3 position-relative">
                        <input type="password" class="form-control pe-5" id="password" placeholder="Password" oninput="validatePassword();">
                        <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer" id="passwordEye" onclick="passwordShowHide('password');"></i>
                        <span class="text-xs text-danger inputErr" id="passwordErr"></span>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" id="signupBtn">Sign Up<span class="spinner-border-sm ms-2" id="signup-spinner" aria-hidden="true"></span></button>
                    <span class="text-xs text-danger backendErr" id="backendErr"></span>
                    <p class="text-sm mt-2">Don't have an account? <a href="/authentication_app/signup">Sign up</a></p>
                </form>
            </div>
        </div>
    </section>
    <?php 
        require_once('./components/footer.php');
    ?>
    