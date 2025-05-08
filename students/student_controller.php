<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../../php/db.php';

// Fetch all food posts
function getFoodPosts($pdo) {
    $sql = "SELECT * FROM food_posts ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Fetch student's recent orders
function getRecentOrders($pdo, $student_id) {
    $sql = "SELECT o.id, o.status, o.total, o.created_at, f.title AS food_title 
            FROM orders o 
            JOIN food_posts f ON o.food_post_id = f.id 
            WHERE o.student_id = :student_id 
            ORDER BY o.created_at DESC LIMIT 3";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['student_id' => $student_id]);
    return $stmt->fetchAll();
}

// Handle order submission
function placeOrder($pdo, $food_post_id, $student_id) {
    $total = 15.99; // Replace with dynamic pricing if available
    $sql = "INSERT INTO orders (student_id, food_post_id, total) VALUES (:student_id, :food_post_id, :total)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'student_id' => $student_id,
        'food_post_id' => $food_post_id,
        'total' => $total
    ]);
}

// Main logic
$posts = getFoodPosts($pdo);
$student_id = isset($_SESSION['student_id']) ? $_SESSION['student_id'] : 1; // Replace with actual session logic
$orders = getRecentOrders($pdo, $student_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order'])) {
    $food_post_id = $_POST['food_post_id'];
    placeOrder($pdo, $food_post_id, $student_id);
    $_SESSION['status'] = ['type' => 'success', 'msg' => 'Order placed successfully!'];
    header('Location: student_home.php');
    exit;
}
?>