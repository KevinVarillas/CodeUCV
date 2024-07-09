const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");
const sign_in_btn2 = document.querySelector("#sign-in-btn2");
const sign_up_btn2 = document.querySelector("#sign-up-btn2");

sign_up_btn.addEventListener("click", () => {
    container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
    container.classList.remove("sign-up-mode");
});

sign_up_btn2.addEventListener("click", () => {
    container.classList.add("sign-up-mode2");
});

sign_in_btn2.addEventListener("click", () => {
    container.classList.remove("sign-up-mode2");
});

document.addEventListener('DOMContentLoaded', function() {
    const signinForm = document.querySelector('.sign-in-form');
    const signupForm = document.querySelector('.sign-up-form');
    const emailSignin = document.getElementById('email_signin');
    const emailSignup = document.getElementById('email_signup');
    const errorMessageSignin = document.getElementById('error-message-signin');
    const errorMessageSignup = document.getElementById('error-message-signup');
    
    function validateEmail(email) {
        const domain = '@ucvvirtual.edu.pe';
        return email.endsWith(domain);
    }

    function handleFormSubmit(event, emailField, errorMessage) {
        const email = emailField.value;
        if (!validateEmail(email)) {
            event.preventDefault();
            errorMessage.textContent = 'Ingresa con tu correo institucional';
        } else {
            errorMessage.textContent = '';
        }
    }

    if (signinForm) {
        signinForm.addEventListener('submit', function(event) {
            handleFormSubmit(event, emailSignin, errorMessageSignin);
        });
    }

    if (signupForm) {
        signupForm.addEventListener('submit', function(event) {
            handleFormSubmit(event, emailSignup, errorMessageSignup);
        });
    }
});
