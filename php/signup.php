<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection file
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $role = isset($_POST['role']) ? trim($_POST['role']) : '';

    // Log received role for debugging
    error_log("Received role: " . $role);

    // Validation checks
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password) || empty($role)) {
        $_SESSION['error'] = "All fields are required.";
        error_log("Validation failed: Missing fields");
        header("Location: ../signup.php");
        exit();
    }

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match.";
        error_log("Validation failed: Passwords do not match");
        header("Location: ../signup.php");
        exit();
    }
    
    if (strlen($password) < 6) {
        $_SESSION['error'] = "Password must be at least 6 characters long.";
        error_log("Validation failed: Password too short");
        header("Location: ../signup.php");
        exit();
    }

    // Validate role
    $valid_roles = ['student', 'delivery', 'manager'];
    if (!in_array($role, $valid_roles)) {
        $_SESSION['error'] = "Invalid role selected: " . htmlspecialchars($role);
        error_log("Validation failed: Invalid role - " . $role);
        header("Location: ../signup.php");
        exit();
    }

    try {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $_SESSION['error'] = "Email already exists.";
            error_log("Validation failed: Email already exists - " . $email);
            header("Location: ../signup.php");
            exit();
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into the database
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $hashed_password,
            'role' => $role
        ]);

        // Verify the inserted role
        $stmt = $pdo->prepare("SELECT role FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $saved_role = $stmt->fetchColumn();
        error_log("Saved role: " . $saved_role);

        if ($saved_role !== $role) {
            $_SESSION['error'] = "Error: Role was not saved correctly. Expected $role, got $saved_role.";
            error_log("Role mismatch: Expected $role, got $saved_role");
            header("Location: ../signup.php");
            exit();
        }

        $_SESSION['success'] = "Signup successful! You can now log in.";
        header("Location: ../login.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error registering user: " . $e->getMessage();
        error_log("Database error: " . $e->getMessage());
        header("Location: ../signup.php");
        exit();
    }
}
?>