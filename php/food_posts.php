<?php
session_start();
require_once 'db.php';

// Handle form submission for creating or updating posts
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $image = $_FILES['image'];

    // Validate inputs
    if (empty($title) || empty($image['name'])) {
        $_SESSION['status'] = ['type' => 'error', 'msg' => 'Title and image are required.'];
        header('Location: ../pages/managers/food_post.php');
        exit;
    }

    // Handle image upload
    $uploadDir = '../Uploads/';
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            $_SESSION['status'] = ['type' => 'error', 'msg' => 'Failed to create Uploads directory.'];
            header('Location: ../pages/managers/food_post.php');
            exit;
        }
    }
    $imagePath = 'Uploads/' . basename($image['name']); // Store path relative to project root
    $fullPath = $uploadDir . basename($image['name']); // Full path for file system
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

    if (!in_array($image['type'], $allowedTypes)) {
        $_SESSION['status'] = ['type' => 'error', 'msg' => 'Invalid image format. Only JPEG, PNG, or GIF allowed.'];
        header('Location: ../pages/managers/food_post.php');
        exit;
    }

    if (!move_uploaded_file($image['tmp_name'], $fullPath)) {
        $_SESSION['status'] = ['type' => 'error', 'msg' => 'Failed to upload image. Check directory permissions.'];
        header('Location: ../pages/managers/food_post.php');
        exit;
    }

    // Log the image path for debugging
    error_log("Saving image path: " . $imagePath);

    // Check if updating or creating
    if (isset($_POST['post_id']) && !empty($_POST['post_id'])) {
        // Update existing post
        $postId = $_POST['post_id'];
        $sql = "UPDATE food_posts SET title = :title, description = :description, image_path = :image_path WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'title' => $title,
            'description' => $description,
            'image_path' => $imagePath,
            'id' => $postId
        ]);
        $_SESSION['status'] = ['type' => 'success', 'msg' => 'Post updated successfully.'];
    } else {
        // Create new post
        $sql = "INSERT INTO food_posts (title, description, image_path) VALUES (:title, :description, :image_path)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'title' => $title,
            'description' => $description,
            'image_path' => $imagePath
        ]);
        $_SESSION['status'] = ['type' => 'success', 'msg' => 'Post created successfully.'];
    }
    header('Location: ../pages/managers/food_post.php');
    exit;
}

// Handle delete request
if (isset($_GET['delete'])) {
    $postId = $_GET['delete'];
    // Fetch image path to delete the file
    $sql = "SELECT image_path FROM food_posts WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $postId]);
    $post = $stmt->fetch();

    if ($post && file_exists('../' . str_replace('Uploads/', 'Uploads/', $post['image_path']))) {
        unlink('../' . str_replace('Uploads/', 'Uploads/', $post['image_path']));
    }

    // Delete post from database
    $sql = "DELETE FROM food_posts WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $postId]);
    $_SESSION['status'] = ['type' => 'success', 'msg' => 'Post deleted successfully.'];
    header('Location: ../pages/managers/food_post.php');
    exit;
}

// Fetch all posts for display
$sql = "SELECT * FROM food_posts ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll();
?>