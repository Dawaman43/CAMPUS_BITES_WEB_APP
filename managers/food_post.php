<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Bites - Share Your Recipes</title>
    <link rel="stylesheet" href="css/post.css">
</head>
<body>
    <?php require_once '../../php/food_posts.php'; ?>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <h1 class="logo">Campus Bites</h1>
            <nav>
                <a href="#home">Home</a>
                
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <h2>Share Your Culinary Creations</h2>
            <p>Post your favorite recipes and explore dishes from our community.</p>
            <a href="#post-form" class="btn-primary">Get Started</a>
        </div>
    </section>

    <!-- Food Post Form -->
    <section class="container" id="post-form">
        <h2>Create a Food Post</h2>
        <?php if (!empty($_SESSION['status'])): ?>
            <div class="alert alert-<?php echo $_SESSION['status']['type']; ?>">
                <?php echo $_SESSION['status']['msg']; unset($_SESSION['status']); ?>
            </div>
        <?php endif; ?>
        <form id="create-post-form" action="../../php/food_posts.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit">Submit Post</button>
        </form>
    </section>

    <!-- Food Posts Grid -->
    <section class="container" id="posts">
        <h2>Explore Recipes</h2>
        <?php if (empty($posts)): ?>
            <p class="no-posts">No posts yet. Be the first to share a recipe!</p>
        <?php else: ?>
            <div class="posts-grid">
                <?php foreach ($posts as $post): ?>
                    <div class="post-card">
                        <img src="/CAMPUS_BITES_WEB_APP/<?php echo htmlspecialchars($post['image_path']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                        <div class="post-content">
                            <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                            <p><?php echo htmlspecialchars($post['description'] ? $post['description'] : 'No description provided.'); ?></p>
                            <p class="post-date">Posted on <?php echo date('M d, Y', strtotime($post['created_at'])); ?></p>
                            <div class="post-actions">
                                <a href="../../php/edit_post.php?id=<?php echo $post['id']; ?>" class="btn-warning">Edit</a>
                                <a href="../../php/food_posts.php?delete=<?php echo $post['id']; ?>" class="btn-danger" onclick="return confirmDelete()">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>© 2025 Campus Bites. All rights reserved.</p>
        </div>
    </footer>

    <script src="js/post.js"></script>
</body>
</html>