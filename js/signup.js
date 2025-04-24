let characterCountValidation = false
let lowerCaseValidation = false
let upperCaseValidation = false
let numberValidation = false
let specialCharacterValidation = false

document.addEventListener("DOMContentLoaded", function () {
    const signupBtn = document.getElementById("signupBtn");
    signupBtn.disabled = true;
  })

function passwordShowHide(type){
    if(type === 'password'){
        const input = document.getElementById('password')
        const eyeIcon = document.getElementById('passwordEye')

        if(input.type === 'password'){
            input.type = 'text'
            eyeIcon.classList.remove('bi-eye')
            eyeIcon.classList.add('bi-eye-slash')
        }else{
            input.type = 'password'
            eyeIcon.classList.remove('bi-eye-slash')
            eyeIcon.classList.add('bi-eye')
        }
    }else if(type === 'confirmPassword'){
        const input = document.getElementById('confirmPassword')
        const eyeIcon = document.getElementById('confirmPasswordEye')

        if(input.type === 'password'){
            input.type = 'text'
            eyeIcon.classList.remove('bi-eye')
            eyeIcon.classList.add('bi-eye-slash')
        }else{
            input.type = 'password'
            eyeIcon.classList.remove('bi-eye-slash')
            eyeIcon.classList.add('bi-eye')
        }
    }
}

//Validate oninput in password field
function validatePassword(){
    toggleSubmitBtn(true)
    const password = document.getElementById("password").value //Password field
    const passwordInput = document.getElementById("password")
    const confirmPassword = document.getElementById("confirmPassword").value //Confirm password field

    //Check for 8 characters or long
    let characterCount = password.length >= 8
    const characterCountLine = document.getElementById("characterCountCheck")
    //characterCount = true;
    
    characterCountValidation = checkForValidations(characterCount, characterCountLine);

    //Check for lower case letter and pick lower case line
    let hasLowerCase = /[a-z]/.test(password)
    const lowerCaseLine = document.getElementById("lowerCaseCheck")
    //hasLowerCase = true;

    lowerCaseValidation = checkForValidations(hasLowerCase, lowerCaseLine);

    //Check for upper case letter and pick upper case line
    let hasUpperCase = /[A-Z]/.test(password)
    const upperCaseLine = document.getElementById("upperCaseCheck")
    //hasUpperCase = true;

    upperCaseValidation = checkForValidations(hasUpperCase, upperCaseLine);

    //Check for any numbers and pick number line
    let hasDigit = /\d/.test(password)
    const digitsLine = document.getElementById("digitsCheck")
    //hasDigit = true;

    numberValidation = checkForValidations(hasDigit, digitsLine);

    //Check for any special characters and pick character line
    let hasSpecialChar = /[^A-Za-z0-9]/.test(password);
    const charLine = document.getElementById("charCheck")
    //hasSpecialChar = true;

    specialCharacterValidation = checkForValidations(hasSpecialChar, charLine);

    const element = document.getElementById("confirmPassword")
    if(password === confirmPassword && password !== ''){
        element.style.outline = "2px solid #5dc566"
        passwordInput.style.outline = "2px solid #5dc566"
        toggleSubmitBtn(false)
    }else{
        if(confirmPassword !== ''){
            element.style.outline = "2px solid #ff8a8a"
            passwordInput.style.outline = "none"
        }
    }

}

//Validates for case on each input chracter - Common for all the checks
function checkForValidations(validation, line){
    const icon = line.querySelector("i")
    if(validation){
        line.classList.remove('text-danger')
        line.classList.add('text-success')
        icon.classList.remove('bi-shield-x')
        icon.classList.add('bi-shield-check')
        return true
    }else{
        line.classList.remove('text-success')
        line.classList.add('text-danger')
        icon.classList.remove('bi-shield-check')
        icon.classList.add('bi-shield-x')
        return false
    }
}

//Cross check confirm password with the original password
function crossCheckPassword(element){
    toggleSubmitBtn(true)
    const password = document.getElementById("password").value //Password field
    const passwordInput = document.getElementById("password")
    const confirmPassword = document.getElementById("confirmPassword").value //Confirm password field

    if(password === confirmPassword && password !== ''){
        element.style.outline = "2px solid #5dc566"
        passwordInput.style.outline = "2px solid #5dc566"
        toggleSubmitBtn(false)
    }else{
        if(confirmPassword !== ''){
            element.style.outline = "2px solid #ff8a8a"
            passwordInput.style.outline = "none"
        }
    }
}

function toggleSubmitBtn(type){
    const signupBtn = document.getElementById("signupBtn")
    if(!type){
        if(characterCountValidation && lowerCaseValidation && upperCaseValidation && numberValidation && specialCharacterValidation){
        //if(upperCaseValidation && numberValidation && specialCharacterValidation){
            signupBtn.disabled = type;
        }
    }else{
        signupBtn.disabled = type;
    }
}

//Validate form data in frontend
document.getElementById('signupForm').addEventListener('submit', function (e) {
    e.preventDefault();
    
    const signupSpinner = document.getElementById('signup-spinner');
    spinner(signupSpinner, 'on');

    const firstNameErr = document.getElementById('firstNameErr');
    const emailErr = document.getElementById('emailErr');
    const passwordErr = document.getElementById('passwordErr');
    const confirmPasswordErr = document.getElementById('confirmPasswordErr');

    firstNameErr.innerText = '';
    emailErr.innerText = '';
    passwordErr.innerText = '';
    confirmPasswordErr.innerText = '';

    const data = {
        firstName: document.getElementById('firstName').value.trim(),
        lastName: document.getElementById('lastName').value.trim(),
        email: document.getElementById('email').value.trim(),
        password: document.getElementById('password').value,
        confirmPassword: document.getElementById('confirmPassword').value
    };

    if(data.firstName  === '' || data.email  === '' || data.password  === '' || data.confirmPassword  === ''){
        if(data.firstName === ''){
            firstNameErr.innerText = '* First name field is required';
        }
        
        if(data.email === ''){
            emailErr.innerText = '* Email field is required';
        }

        if(data.password === ''){
            passwordErr.innerText = '* Password field is required';
        }

        if(data.confirmPassword === ''){
            confirmPasswordErr.innerText = '* Confirm password field is required';
        }

        spinner(signupSpinner, 'off');
        return;
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(data.email)) {
        document.getElementById('emailErr').innerText = "Please enter a valid email address";
        return;
    }

    fetch('/authentication_app/user/store', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(res => res.json())
      .then(response => {
          if (response.success) {
              callToast(response.message, 'success', response.redirect_url);
              spinner(signupSpinner, 'off');
          } else {
              if(response.type === 'empty_fields'){
                firstNameErr.innerText = response.message.firstNameErr;
                emailErr.innerText = response.message.emailErr;
                passwordErr.innerText = response.message.passwordErr;
                confirmPasswordErr.innerText = response.message.confirmPasswordErr;
              }else if(response.type === 'password_missmatch'){
                document.getElementById('backendErr').innerText = response.message;
              }else if(response.type === 'password_invalid'){
                if(!response.message.lowerCase){
                    const lowerCaseLine = document.getElementById("lowerCaseCheck")
                    const icon = lowerCaseLine.querySelector("i")
                    lowerCaseLine.classList.add('text-danger')
                    lowerCaseLine.classList.remove('text-success')
                    icon.classList.add('bi-shield-x')
                    icon.classList.remove('bi-shield-check')
                }

                if(!response.message.upperCase){
                    const upperCaseLine = document.getElementById("upperCaseCheck")
                    const icon = upperCaseLine.querySelector("i")
                    upperCaseLine.classList.add('text-danger')
                    upperCaseLine.classList.remove('text-success')
                    icon.classList.add('bi-shield-x')
                    icon.classList.remove('bi-shield-check')
                }

                if(!response.message.hasDigit){
                    const digitsLine = document.getElementById("digitsCheck")
                    const icon = digitsLine.querySelector("i")
                    digitsLine.classList.add('text-danger')
                    digitsLine.classList.remove('text-success')
                    icon.classList.add('bi-shield-x')
                    icon.classList.remove('bi-shield-check')
                }

                if(!response.message.passwordLength){
                    const characterCountLine = document.getElementById("characterCountCheck")
                    const icon = characterCountLine.querySelector("i")
                    characterCountLine.classList.add('text-danger')
                    characterCountLine.classList.remove('text-success')
                    icon.classList.add('bi-shield-x')
                    icon.classList.remove('bi-shield-check')
                }

                if(!response.message.specialChars){
                    const charLine = document.getElementById("charCheck")
                    const icon = charLine.querySelector("i")
                    charLine.classList.add('text-danger')
                    charLine.classList.remove('text-success')
                    icon.classList.add('bi-shield-x')
                    icon.classList.remove('bi-shield-check')
                }

                document.getElementById('backendErr').innerText = response.message.errorMsg;
              }else if(response.type === 'registration_failed'){
                    callToast(response.message, 'failed');
              }else if(response.type === 'email_taken'){
                    callToast(response.message, 'failed');
              }

              spinner(signupSpinner, 'off');
          }
      });
});

//Input field color variation
// function activateInputColors(element){
//     const password = document.getElementById("password").value //Password field
//     const confirmPassword = document.getElementById("confirmPassword").value //Confirm password field

//     if(password === confirmPassword && password !== ''){
//         element.style.outline = "2px solid #5dc566"
//     }else{
//         element.style.outline = "2px solid #ff8a8a"
//     }
    
// }

//Input field color variation
// function removeInputOutline(element){
//     const password = document.getElementById("password").value //Password field
//     const confirmPassword = document.getElementById("confirmPassword").value //Confirm password field

//     //element.style.outline = "none"
// }