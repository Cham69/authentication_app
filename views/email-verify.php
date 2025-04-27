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
    <title>Verify Your Email</title>
</head>
<body>
    <?php 
        require_once('./controllers/UserController.php');
        $user = new UserController();
        $response = $user->sendEmailVerification('pageLoad');
        $response = json_decode($response, true);
    ?>
    <section class="container my-5 py-2" style="max-width:30%">
        <div class="card p-3">
            <img src="./images/email.png" alt="Email Image" width="60%" class="mx-auto d-block">
            <div class="text-center">
                <h5 class="mb-2 topic-text poppins-medium">Hey, <?php echo htmlspecialchars(SessionManager::get('first_name')); ?>!</h5>
                <p class="text-sm grey-text"><?php echo $response['message'] ?? ''; ?></p>
            </div>
            <form id="signinForm">
                <div class="mb-3 d-flex justify-content-between">
                    <input type="text" class="form-control otp-input text-center" maxlength="1" />
                    <input type="text" class="form-control otp-input text-center" maxlength="1" />
                    <input type="text" class="form-control otp-input text-center" maxlength="1" />
                    <input type="text" class="form-control otp-input text-center" maxlength="1" />
                    <input type="text" class="form-control otp-input text-center" maxlength="1" />
                    <input type="text" class="form-control otp-input text-center" maxlength="1" />
                </div>

                <span class="text text-xs otpMessage" id="otpMessage"></span>
                <button type="submit" class="btn btn-primary w-100 mb-2" id="verifyBtn">Verify me<span class="spinner-border-sm ms-2" id="verify-spinner" aria-hidden="true"></span></button>
                <button type="button" class="btn btn-outline-dark w-100 mb-2" id="resendBtn" onclick="resendOtp()">Resend code<span class="spinner-border-sm ms-2" id="resend-spinner" aria-hidden="true"></span></button>
            </form>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="./js/helper.js"></script>
</body>
</html>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.otp-input');

    inputs.forEach((input, index) => {
        input.addEventListener('input', () => {
            if (input.value.length === 1 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === "Backspace" && input.value === '' && index > 0) {
                inputs[index - 1].focus();
            }
        });
    });

    inputs[0].focus();
});

document.getElementById('signinForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const verifySpinner = document.getElementById('verify-spinner');
    spinner(verifySpinner, 'on');
    const message = document.getElementById('otpMessage');

    const inputs = document.querySelectorAll('.otp-input');
    let otp = '';
    inputs.forEach(input => {
        otp += input.value;
    });

    if (otp.length < 6) {
        message.innerText = 'Please enter a valid OTP.';
        spinner(verifySpinner, 'off');
        return;
    }
    message.innerText = '';

    fetch('/authentication_app/user/verify', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ otp: otp }),
    })
    .then(response => response.json())
    .then(data => {

        if (data.success) {
            spinner(verifySpinner, 'off');
            callToast(data.message, 'success', data.redirect_url);
        } else {
            message.innerText = data.message;
            spinner(verifySpinner, 'off');
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
});

function resendOtp(){
    const resendSpinner = document.getElementById('resend-spinner');
    spinner(resendSpinner, 'on');
    const message = document.getElementById('otpMessage');
    message.classList.remove('text-success')
    message.classList.remove('text-danger')
    message.innerText = '';
    
    fetch('/authentication_app/user/resend', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        spinner(resendSpinner, 'off');
        if (data.success) {
            message.classList.add('text-success')
            message.innerText = data.message;
        } else {
            message.classList.add('text-danger')
            message.innerText = data.message;
        }
    })
    .catch((error) => {
        message.innerText = 'An error occurred. Please try again.';        
        spinner(resendSpinner, 'off');
        console.error('Error:', error);
    });
}
</script>
