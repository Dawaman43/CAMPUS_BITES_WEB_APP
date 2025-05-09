<?php
session_start();
$errorMessage = !empty($_SESSION['error']) ? $_SESSION['error'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
    <div class="login-container">
        <?php if(!empty($errorMessage)) : ?>
            <div class="modal" id="error-modal">
                <div class="modal-content">
                    <p><?php echo $errorMessage; ?></p>
                    <button onclick="closeModal()">Close</button>
                </div>
            </div>
        <?php
            unset($_SESSION['error']);
        endif;
        ?>
        <img src="../images/icon.png" alt="App Icon" class="logo">
        <h1 class="login-text1">Login Page</h1>
        <p class="subtitle">Enter your credentials to access your account</p>
        
        <form id="login-form" class="login-form" action="../php/signin.php" method="post">
            <div class="form-group">
                <input type="email" id="email" name="email" class="text-input" placeholder="Email" >
            </div>
            
            <div class="form-group">
                <input type="password" id="password" name="password" class="text-input" placeholder="Password" >
            </div>
            
            <button type="submit" class="login-button">Login</button>
        </form>

        <div class="login-redirect">
            <p class="login-text">You don't have an account?</p>
            <a href="index.php" class="login-link">Sign in</a>
        </div>
    </div>

    <?php if(!empty($errorMessage)) : ?>
        <script>
            try {
                const modal = document.getElementById('error-modal');
                if (modal) {
                    modal.classList.add('active');
                    console.log('Modal should be visible. Current display:', modal.style.display);
                } else {
                    console.error('Error: Modal element not found in DOM');
                }

                function closeModal() {
                    if (modal) {
                        modal.classList.remove('active');
                        setTimeout(() => {
                            window.location.href = 'login.php';
                        }, 300); // Delay redirect to allow animation
                    }
                }
            } catch (error) {
                console.error('JavaScript error in modal script:', error);
            }
        </script>
    <?php endif; ?>

    <!-- <script src="signup.js"></script> -->
</body>
</html>