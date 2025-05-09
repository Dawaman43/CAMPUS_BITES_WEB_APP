<?php
session_start();
require_once 'dbConfig.php';

// Handle order submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'], $_POST['quantity'])) {
    $postId = $_POST['post_id'];
    $quantity = (int)$_POST['quantity'];

    // Validate inputs
    if ($quantity <= 0) {
        $_SESSION['status'] = ['type' => 'error', 'msg' => 'Quantity must be greater than 0.'];
        header('Location: ../pages/managers/order.php');
        exit;
    }

    // Verify post exists
    $sql = "SELECT id FROM food_posts WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $postId]);
    if (!$stmt->fetch()) {
        $_SESSION['status'] = ['type' => 'error', 'msg' => 'Invalid food post.'];
        header('Location: ../pages/managers/order.php');
        exit;
    }

    // Create order
    $sql = "INSERT INTO orders (post_id, quantity) VALUES (:post_id, :quantity)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'post_id' => $postId,
        'quantity' => $quantity
    ]);
    $_SESSION['status'] = ['type' => 'success', 'msg' => 'Order placed successfully.'];
    header('Location: ../pages/managers/order.php');
    exit;
}

// Fetch all orders with food post details
$sql = "SELECT o.id, o.post_id, o.quantity, o.created_at, f.title 
        FROM orders o 
        JOIN food_posts f ON o.post_id = f.id 
        ORDER BY o.created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$orders = $stmt->fetchAll();

// Fetch all food posts for the order form
$sql = "SELECT id, title FROM food_posts ORDER BY title";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$foodPosts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Bites - Place Orders</title>
    <link rel="stylesheet" href="../../css/order.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <h1 class="logo">Campus Bites</h1>
            <nav>
                <a href="../managers/home.html">Home</a>
                <a href="#order-form">Place Order</a>
                <a href="#orders">View Orders</a>
                <a href="food_post.php">Recipes</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <h2>Order Your Favorite Dishes</h2>
            <p>Select a recipe and place your order with ease.</p>
            <a href="#order-form" class="btn-primary">Get Started</a>
        </div>
    </section>

    <!-- Order Form -->
    <section class="container" id="order-form">
        <h2>Place an Order</h2>
        <?php if (!empty($_SESSION['status'])): ?>
            <div class="alert alert-<?php echo $_SESSION['status']['type']; ?>">
                <?php echo $_SESSION['status']['msg']; unset($_SESSION['status']); ?>
            </div>
        <?php endif; ?>
        <form id="order-form" action="order.php" method="POST">
            <div class="form-group">
                <label for="post_id">Select Recipe</label>
                <select id="post_id" name="post_id" required>
                    <option value="">Choose a recipe</option>
                    <?php foreach ($foodPosts as $post): ?>
                        <option value="<?php echo $post['id']; ?>">
                            <?php echo htmlspecialchars($post['title']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" min="1" value="1" required>
            </div>
            <button type="submit">Place Order</button>
        </form>
    </section>

    <!-- Orders List -->
    <section class="container" id="orders">
        <h2>Your Orders</h2>
        <?php if (empty($orders)): ?>
            <p class="no-orders">No orders yet. Place your first order!</p>
        <?php else: ?>
            <div class="orders-grid">
                <?php foreach ($orders as $order): ?>
                    <div class="order-card">
                        <div class="order-content">
                            <h3><?php echo htmlspecialchars($order['title']); ?></h3>
                            <p>Quantity: <?php echo $order['quantity']; ?></p>
                            <p class="order-date">Ordered on <?php echo date('M d, Y', strtotime($order['created_at'])); ?></p>
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
</body>
</html>