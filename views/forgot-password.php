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
    <section class="container my-5 py-2" style="max-width:30%">
        <div class="card p-3">
            <img src="./images/email.png" alt="Email Image" width="60%" class="mx-auto d-block">
            <div class="main-content">
                <div class="text-center">
                    <h5 class="mb-2 topic-text poppins-medium topic">Enter your email address</h5>
                    <p class="text-sm grey-text subText">Don't worry. We will send a password reset link if this email is registered with us. Please check your inbox.</p>
                </div>
                <form id="forgotPasswordForm">
                    <div class="mb-3 d-flex justify-content-between">
                        <input type="email" class="form-control email_address text-center" placeholder="Email Address" />
                    </div>

                    <span class="text text-xs forgotPasswordMsg" id="forgotPasswordMsg"></span>
                    <button type="submit" class="btn btn-primary w-100 mb-2" id="forgotPasswordBtn">Continue<span class="spinner-border-sm ms-2" id="forgotPassword-spinner" aria-hidden="true"></span></button>
                </form>
                <p class="text-center mt-3"><a href="http://localhost/authentication_app/signin" class="text-primary">Back to sign in</a></p>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="./js/helper.js"></script>
    <script>
        document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const email = document.querySelector('.email_address').value;
            const ForgotPwdspinner = document.getElementById('forgotPassword-spinner');
            const forgotPasswordMsg = document.getElementById('forgotPasswordMsg');
            const topic = document.querySelector('.topic');
            const subText = document.querySelector('.subText');
            const form = document.getElementById('forgotPasswordForm');

            forgotPasswordMsg.innerText = '';
            forgotPasswordMsg.classList.remove('text-danger', 'text-success');

            spinner(ForgotPwdspinner, 'on');
            if(email === '') {
                forgotPasswordMsg.innerText = "Please enter your email address";
                forgotPasswordMsg.classList.add('text-danger');
                spinner(ForgotPwdspinner, 'off');
                return;
            }

            const formData = new FormData();
            formData.append('email', email);

            fetch('/authentication_app/reset-password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ email: email }),
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    topic.innerText = "Success!";
                    subText.innerText = data.message;
                    topic.classList.add('text-success');
                    form.classList.add('d-none');
                } else {
                    forgotPasswordMsg.innerText = data.message;
                    forgotPasswordMsg.classList.add('text-danger');
                }
                spinner(ForgotPwdspinner, 'off');
            })
            .catch(error => {
                forgotPasswordMsg.innerText = "An error occurred. Please try again.";
                forgotPasswordMsg.classList.add('text-danger');
                spinner(ForgotPwdspinner, 'off');
            });
        });
    </script>
</body>
</html>
