<?php
session_start();
require_once 'db.php';

// Fetch post to edit
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['status'] = ['type' => 'error', 'msg' => 'Invalid post ID.'];
    header('Location: ../pages/managers/food_post.php');
    exit;
}

$postId = $_GET['id'];
$sql = "SELECT * FROM food_posts WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $postId]);
$post = $stmt->fetch();

if (!$post) {
    $_SESSION['status'] = ['type' => 'error', 'msg' => 'Post not found.'];
    header('Location: ../pages/managers/food_post.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Food Post - Campus Bites</title>
    <link rel="stylesheet" href="../../css/post.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <h1 class="logo">Campus Bites</h1>
            <nav>
                <a href="../../pages/managers/food_post.php">Home</a>
                <a href="../../pages/managers/food_post.php#post-form">Post a Recipe</a>
                <a href="../../pages/managers/food_post.php#posts">Recipes</a>
            </nav>
        </div>
    </header>

    <section class="container">
        <h2>Edit Food Post</h2>
        <?php if (!empty($_SESSION['status'])): ?>
            <div class="alert alert-<?php echo $_SESSION['status']['type']; ?>">
                <?php echo $_SESSION['status']['msg']; unset($_SESSION['status']); ?>
            </div>
        <?php endif; ?>
        <form id="edit-post-form" action="food_posts.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($post['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image (leave blank to keep current)</label>
                <input type="file" id="image" name="image" accept="image/*">
                <div class="current-image">
                    <p>Current image:</p>
                    <img src="<?php echo htmlspecialchars($post['image_path']); ?>" alt="Current Image" width="100">
                </div>
            </div>
            <div class="form-buttons">
                <button type="submit">Update Post</button>
                <a href="../../pages/managers/food_post.php" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </section>

    <footer class="footer">
        <div class="container">
            <p>© 2025 Campus Bites. All rights reserved.</p>
        </div>
    </footer>

    <script src="../../js/post.js"></script>
</body>
</html>