document.addEventListener('DOMContentLoaded', function() {
    
    function showError(input, message) {
        const formGroup = input.parentElement;
        const errorMessage = formGroup.querySelector('.error-message') || createErrorMessageElement();
        
        input.classList.add('error');
        errorMessage.textContent = message;
        errorMessage.style.display = 'block';
        
        if (!formGroup.contains(errorMessage)) {
            formGroup.appendChild(errorMessage);
        }
    }
    
    function createErrorMessageElement() {
        const errorElement = document.createElement('div');
        errorElement.className = 'error-message';
        return errorElement;
    }
    
    function clearErrors() {
        const errors = document.querySelectorAll('.error-message');
        errors.forEach(error => {
            error.style.display = 'none';
        });
        
        const inputs = document.querySelectorAll('.text-input');
        inputs.forEach(input => {
            input.classList.remove('error');
        });
    }
    
    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    
    const signupForm = document.getElementById('signup-form');
    if (signupForm) {
        signupForm.addEventListener('submit', function(e) {
            e.preventDefault();
            clearErrors();
            
            if (validateSignupForm()) { 
                const username = document.getElementById('username').value;
                window.location.href = `login.html?username=${encodeURIComponent(username)}`;
            }
        });
        
        function validateSignupForm() {
            let isValid = true;
            
            const username = document.getElementById('username');
            if (username.value.trim() === '') {
                showError(username, 'Username is required');
                isValid = false;
            }
            
            const email = document.getElementById('email');
            if (email.value.trim() === '') {
                showError(email, 'Email is required');
                isValid = false;
            } else if (!isValidEmail(email.value.trim())) {
                showError(email, 'Please enter a valid email');
                isValid = false;
            }
            
            const password = document.getElementById('password');
            if (password.value.trim() === '') {
                showError(password, 'Password is required');
                isValid = false;
            } else if (password.value.length < 6) {
                showError(password, 'Password must be at least 6 characters');
                isValid = false;
            }
            
            const confirmPassword = document.getElementById('confirm-password');
            if (confirmPassword.value.trim() === '') {
                showError(confirmPassword, 'Please confirm your password');
                isValid = false;
            } else if (confirmPassword.value !== password.value) {
                showError(confirmPassword, 'Passwords do not match');
                isValid = false;
            }
            
            return isValid;
        }
    }

    
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        
        const urlParams = new URLSearchParams(window.location.search);
        const usernameParam = urlParams.get('username');
        if (usernameParam) {
            const usernameField = document.getElementById('username');
            if (usernameField) {
                usernameField.value = decodeURIComponent(usernameParam);
            }
        }
        
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            clearErrors();
            
            if (validateLoginForm()) {
                localStorage.setItem('isLoggedIn', 'true');
                window.location.href = './home/home.html';
            }
        });
        
        function validateLoginForm() {
            let isValid = true;
            
            const username = document.getElementById('username');
            if (username.value.trim() === '') {
                showError(username, 'Username is required');
                isValid = false;
            }
            
            const password = document.getElementById('password');
            if (password.value.trim() === '') {
                showError(password, 'Password is required');
                isValid = false;
            }
            
            return isValid;
        }
    }
});