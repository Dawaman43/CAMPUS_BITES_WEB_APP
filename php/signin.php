<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection file
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate input
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Email and password are required.";
        header("Location: ../login.php");
        exit();
    }

    try {
        // Prepare and execute the query to find the user
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify user and password
        if ($user && password_verify($password, $user['password'])) {
            // Store user data in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role']; // Store role in session

            // Regenerate session ID for security
            session_regenerate_id(true);

            // Redirect based on user role
            switch ($user['role']) {
                case 'student':
                    header("Location: ../students/student_home.php");
                    break;
                case 'delivery':
                    header("Location: ../managers/home.html");
                    break;
                case 'manager':
                    header("Location: ../delivery/delivery_home.php");
                    break;
                default:
                    // Fallback for unrecognized roles
                    $_SESSION['error'] = "Invalid user role.";
                    header("Location: ../login.php");
                    break;
            }
            exit();
        } else {
            // Store error message in session for display
            $_SESSION['error'] = "Invalid email or password.";
            header("Location: ../login.php");
            exit();
        }
    } catch (PDOException $e) {
        // Handle database errors
        $_SESSION['error'] = "Error logging in: " . $e->getMessage();
        header("Location: ../login.php");
        exit();
    }
}
?>