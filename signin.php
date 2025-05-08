<?php
session_start();
$errorMessage = !empty($_SESSION['error']) ? $_SESSION['error'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="signup.css">
    <!-- <style>
        /* Modal styles */
        #error-modal.modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            overflow: auto;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        #error-modal.modal.active {
            display: flex;
            opacity: 1;
        }
        .modal-content {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
        .modal-content p {
            margin: 0;
            padding: 10px 0;
            font-size: 16px;
            color: #333;
        }
        .modal-content button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        .modal-content button:hover {
            background-color: white;
            color: #4CAF50;
            border: 1px solid #4CAF50;
        }
        /* Dropdown styles */
        .form-group select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
    </style> -->
</head>
<body>
    <div class="signup-container">
        <?php if (!empty($errorMessage)) : ?>
            <div class="modal active" id="error-modal">
                <div class="modal-content">
                    <p><?= htmlspecialchars($errorMessage) ?></p>
                    <button onclick="closeModal()">Close</button>
                </div>
            </div>
        <?php 
            unset($_SESSION['error']); // Clear error to prevent re-display
        endif; ?>
        <img src="../images/icon.png" alt="App Icon" class="logo">
        <h1 class="signup-text">Sign Up</h1>
        <p class="subtitle">Please fill the form to join us</p>
        
        <form id="signup-form" class="signup-form" action="php/signup.php" method="post">
            <div class="form-group">
                <input type="text" id="username" name="username" class="text-input" placeholder="User name" required>
            </div>
            <div class="form-group">
                <input type="email" id="email" name="email" class="text-input" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" class="text-input" placeholder="Password" minlength="6" required>
            </div>
            <div class="form-group">
                <input type="password" id="confirm-password" name="confirm-password" class="text-input" placeholder="Confirm Password" required>
            </div>
            <div class="form-group">
                <select id="role" name="role" class="text-input" required>
                    <option value="student" selected>Student</option>
                    <option value="delivery">Delivery</option>
                    <option value="manager">Manager</option>
                </select>
            </div>
            <button type="submit" class="signup-button">Create Account</button>
        </form>
        
        <div class="login-redirect">
            <p class="login-text">You already have an account?</p>
            <a href="login.php" class="login-link">Sign in</a>
        </div>
    </div>

    <?php if (!empty($errorMessage)) : ?>
        <script>
            function closeModal() {
                const modal = document.getElementById('error-modal');
                if (modal) {
                    modal.classList.remove('active');
                    setTimeout(() => {
                        modal.style.display = 'none';
                    }, 300); // Match transition duration
                }
            }
        </script>
    <?php endif; ?>
</body>
</html>