<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include controller for order processing
require_once 'student_controller.php';

// Check if user is signed in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Please sign in to place an order.";
    header("Location: ../login.php");
    exit();
}

// Sample food list (hardcoded as fallback if no posts are available)
$default_foods = [
    [
        'id' => 1,
        'title' => 'Egg Sliced',
        'description' => 'Classic Egg Siced with ingredients',
        'price' => 120,
        'image_path' => 'images/food/egg-firfir.jpg'
    ],
    [
        'id' => 2,
        'title' => 'Normal Firfir',
        'description' => 'Normal Firfir with Injera',
        'price' => 140,
        'image_path' => 'images/food/firfir.jpg'
    ],
    [
        'id' => 3,
        'title' => 'Keysir',
        'description' => 'Traditional Ethiopian Food',
        'price' => 180,
        'image_path' => 'images/food/keysir.jpg'
    ],
    [
        'id' => 4,
        'title' => 'Shiro Wot',
        'description' => 'Home Made Shiro Feses',
        'price' => 90,
        'image_path' => 'images/food/shiro.jpg'
    ],
    [
        'id' => 5,
        'title' => 'Meat Wot',
        'description' => 'Delicious Red Meat Wot',
        'price' => 100,
        'image_path' => 'images/food/meat.jpg'
    ],
    [
        'id' => 6,
        'title' => 'Beyaynetu',
        'description' => 'Mixed Ethipian Foods',
        'price' => 130,
        'image_path' => 'images/food/mixed.jpg'
    ],
    [
        'id' => 7,
        'title' => 'Tibs',
        'description' => 'Grilled Ethiopian Meat.',
        'price' => 200,
        'image_path' => 'images/food/shekla-tibs.jpg'
    ],
    [
        'id' => 8,
        'title' => 'Gomen Wot',
        'description' => 'Simple and filling Gomen Wot',
        'price' => 80,
        'image_path' => '../images/food/gomen.jpg'
    ],
    [
        'id' => 9,
        'title' => 'Chechebsa',
        'description' => 'Traditional Ethiopian food called Chechebsa',
        'price' => 100,
        'image_path' => '../images/food/chechebsa.jpg'
    ],
    [
        'id' => 10,
        'title' => 'Firfir',
        'description' => 'Firfir with yellowish erd flavour',
        'price' => 100,
        'image_path' => '../images/food/firfir2.jpg'
    ],
    [
        'id' => 11,
        'title' => 'Chocolate Cake',
        'description' => 'Decadent chocolate cake with creamy frosting.',
        'price' => 150, // Add price for Chocolate Cake
        'image_path' => 'images/food/chocolate-cake.jpg'
    ]
];

// Validate and sanitize $posts to ensure all required keys exist
$foods = [];
if (!empty($posts)) {
    foreach ($posts as $post) {
        // Ensure all required keys exist, use defaults if missing
        $foods[] = [
            'id' => isset($post['id']) ? $post['id'] : uniqid(), // Generate ID if missing
            'title' => isset($post['title']) ? $post['title'] : 'Unnamed Food',
            'description' => isset($post['description']) ? $post['description'] : 'No description available',
            'price' => isset($post['price']) ? (float)$post['price'] : 0.00, // Default to 0 if price missing
            'image_path' => isset($post['image_path']) ? $post['image_path'] : 'images/food/default.jpg' // Default image
        ];
    }
} else {
    $foods = $default_foods;
}

// Handle order submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $selected_items = json_decode($_POST['selected_items'], true);
    $dorm_block = $_POST['dorm_block'];
    $room_number = $_POST['room_number'];
    $total = $_POST['total'];

    if (empty($selected_items)) {
        $_SESSION['error'] = "Please select at least one food item.";
    } elseif (empty($dorm_block) || empty($room_number)) {
        $_SESSION['error'] = "Please provide dorm block and room number.";
    } else {
        // Simulate order processing (replace with actual controller logic)
        $_SESSION['status'] = [
            'type' => 'success',
            'msg' => 'Order placed successfully! You will receive a confirmation soon.'
        ];
        header("Location: order.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Food</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
        }

        .first-section {
            background-image: url('../images/grab-W_UiSLqthaU-unsplash.jpg');
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
        }

        .order {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .order-container {
            background: #b64c1c;
            padding: 30px;
            border-radius: 15px;
            width: 70%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .order-title {
            font-size: 28px;
            font-weight: bold;
            color: black;
            margin-bottom: 20px;
        }

        .food-list {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            justify-content: center;
        }

        .food-item {
            background-color: #A9745B;
            padding: 10px 20px;
            border-radius: 10px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            min-width: 200px;
            text-align: center;
            transition: transform 0.2s;
            cursor: pointer;
        }

        .food-item:hover {
            transform: translateY(-5px);
        }

        .food-item img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .food-item h3 {
            font-size: 18px;
            color: white;
            margin-bottom: 5px;
        }

        .food-item p {
            font-size: 14px;
            color: white;
        }

        .food-item.selected {
            border: 2px solid #16a34a;
        }

        .selected-items {
            font-size: 14px;
            color: black;
            margin-bottom: 10px;
            min-height: 20px;
        }

        .order-summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .unselect-btn {
            background: #dc2626;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }

        .total-fee {
            font-weight: bold;
            font-size: 18px;
            color: black;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: black;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .place-order-btn {
            background: #16a34a;
            color: white;
            padding: 15px;
            width: 100%;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
            cursor: pointer;
        }

        .place-order-btn:hover {
            background: #15803d;
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
        }

        .logo {
            height: 40px;
            filter: brightness(0) invert(1);
        }

        .nav-elements {
            display: flex;
            gap: 20px;
        }

        .nav-elements h1 a {
            color: white;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .nav-elements h1 a:hover {
            color: #10B249;
        }

        .order-button {
            background: #10B249;
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <section class="first-section">
        <header>
            <nav>
                <div>
                    <img class="logo" src="../images/icon.png" alt="Campus Bite Logo">
                </div>
                <div class="nav-elements" id="nav-elements">
                    <h1><a href="../home/home.php">Home</a></h1>
                    <h1><a href="./order.php">Order</a></h1>
                    <h1><a href="../contact/contact.html">Contact</a></h1>
                </div>
                <div>
                    <a href="./order.php" class="order-button">Order Now</a>
                </div>
            </nav>
        </header>
        <section class="order">
            <div class="order-container">
                <?php if (!empty($_SESSION['status'])): ?>
                    <div class="alert alert-<?php echo $_SESSION['status']['type']; ?>">
                        <?php echo $_SESSION['status']['msg']; unset($_SESSION['status']); ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($_SESSION['error'])): ?>
                    <div class="alert alert-danger">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>
                <h1 class="order-title">Select Food</h1>
                <div class="food-list" id="food-list">
                    <?php foreach ($foods as $food): ?>
                        <div class="food-item" 
                             data-id="<?php echo htmlspecialchars($food['id']); ?>" 
                             data-title="<?php echo htmlspecialchars($food['title']); ?>" 
                             data-price="<?php echo htmlspecialchars($food['price']); ?>">
                            <img src="/CAMPUS_BITES_WEB_APP/<?php echo htmlspecialchars($food['image_path']); ?>" 
                                 alt="<?php echo htmlspecialchars($food['title']); ?>">
                            <h3><?php echo htmlspecialchars($food['title']); ?></h3>
                            <p class="desc"><?php echo htmlspecialchars($food['description']); ?></p>
                            <p class="price">ብር <?php echo number_format($food['price'], 2); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="selected-items" id="selected-items"></div>
                <div class="order-summary">
                    <button class="unselect-btn" id="unselect-btn">Unselect All</button>
                    <p class="total-fee" id="total-fee">Estimated Total: 0 ብር</p>
                </div>
                <form method="POST" id="order-form">
                    <input type="hidden" name="selected_items" id="selected-items-input">
                    <input type="hidden" name="total" id="total-input">
                    <div class="input-group">
                        <label for="dorm">Dorm Block</label>
                        <input type="text" id="dorm" name="dorm_block" placeholder="Enter dorm block" required />
                    </div>
                    <div class="input-group">
                        <label for="room">Room Number</label>
                        <input type="number" id="room" name="room_number" placeholder="Enter room number" required />
                    </div>
                    <button type="submit" name="place_order" class="place-order-btn" id="place-order-btn">Place Order</button>
                </form>
            </div>
        </section>
    </section>
    <script>
        const foodItems = document.querySelectorAll('.food-item');
        const selectedItemsDiv = document.getElementById('selected-items');
        const totalFee = document.getElementById('total-fee');
        const unselectBtn = document.getElementById('unselect-btn');
        const selectedItemsInput = document.getElementById('selected-items-input');
        const totalInput = document.getElementById('total-input');
        let selectedItems = [];

        foodItems.forEach(item => {
            item.addEventListener('click', () => {
                const id = item.getAttribute('data-id');
                const title = item.getAttribute('data-title');
                const price = parseFloat(item.getAttribute('data-price'));

                if (item.classList.contains('selected')) {
                    item.classList.remove('selected');
                    selectedItems = selectedItems.filter(selected => selected.id !== id);
                } else {
                    item.classList.add('selected');
                    selectedItems.push({ id, title, price });
                }

                updateSelectedItems();
            });
        });

        unselectBtn.addEventListener('click', () => {
            selectedItems = [];
            foodItems.forEach(item => item.ConcurrentModificationException.classList.remove('selected'));
            updateSelectedItems();
        });

        function updateSelectedItems() {
            if (selectedItems.length === 0) {
                selectedItemsDiv.textContent = 'No items selected';
            } else {
                selectedItemsDiv.textContent = selectedItems.map(item => item.title).join(', ');
            }

            const total = selectedItems.reduce((sum, item) => sum + item.price, 0);
            totalFee.textContent = `Estimated Total: ${total.toFixed(2)} ብር`;

            selectedItemsInput.value = JSON.stringify(selectedItems);
            totalInput.value = total.toFixed(2);
        }
    </script>
</body>
</html>