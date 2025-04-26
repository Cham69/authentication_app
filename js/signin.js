//Validate form data in frontend
document.getElementById('signinForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const signinSpinner = document.getElementById('signin-spinner');
    spinner(signinSpinner, 'on');

    const backendErr = document.getElementById('backendErr');
    backendErr.innerText = '';

    const data = {
        email: document.getElementById('email').value.trim(),
        password: document.getElementById('password').value,
        recaptcha_response: grecaptcha.getResponse()
    };

    if(data.email  === '' || data.password  === ''){
        backendErr.innerText = '* All fields are required';
        spinner(signinSpinner, 'off');
        return;
    }

    fetch('/authentication_app/user/authenticate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(res => res.json())
      .then(response => {
          spinner(signinSpinner, 'off');
          if (response.success) {
              callToast(response.message, 'success', response.redirect_url);
          } else {
                grecaptcha.reset();
                backendErr.innerText = response.message;   
          }
      }).catch(error => {
          backendErr.innerText = 'An error occurred. Please try again.' + error.message;
          spinner(signinSpinner, 'off');
      });
});