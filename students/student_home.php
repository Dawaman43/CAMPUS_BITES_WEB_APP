<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'student_controller.php'; // Include controller

// Check if user is signed in before processing order
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order'])) {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error'] = "Please sign in to place an order.";
        header("Location: ../login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>CampusBite</title>
    <style>
        :root {
            --primary-green: #10B249;
            --dark-green: #0E9A3F;
            --black: #121212;
            --white: #ffffff;
            --light-gray: #f8f9fa;
            --text-gray: #555;
            --section-padding: 6rem 2rem;
            --container-width: 1200px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: 400;
            font-style: normal;
            background-color: white;
        }

        body > *:not(.section-0) {
            margin: 60px 100px;
        }

        html {
            scroll-behavior: smooth;
        }

        .section-0 {
            background-image: url('../../images/grab-W_UiSLqthaU-unsplash.jpg');
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            margin: 0;
        }

        /* nav css */
        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo1 {
            height: 40px;
            filter: brightness(0) invert(1);
        }

        .brand-name {
            color: var(--white);
            font-size: 1.5rem;
            font-weight: 700;
        }

        .brand-name span {
            color: var(--primary-green);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
        }

        .nav-elements ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        .nav-elements a {
            color: var(--white);
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .nav-elements a:hover {
            color: var(--primary-green);
        }

        .sign-log {
            width: 30px;
            filter: brightness(0) invert(1);
        }

        /* section-1 */
        .section-1 {
            position: absolute;
            bottom: 0;
            gap: 20px;
            margin: 50px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            right: 0;
        }

        .header-content h1 {
            font-size: 70px;
            width: 100%;
            right: 0;
            color: black;
            font-weight: bold;
        }

        .header-content p {
            font-size: 20px;
            color: black;
            width: 100%;
            font-weight: lighter;
            margin: 10px;
            text-align: center;
        }

        .header-buttons {
            justify-content: center;
            align-items: center;
            display: flex;
            gap: 10px;
        }

        .order-button2 {
            color: black;
            background-color: #14d658e2;
            padding: 5px 20px;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
        }

        .learn-more-button {
            color: black;
            background-color: white;
            padding: 5px 20px;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            border: 1px solid black;
            cursor: pointer;
        }

        /* slider */
        .slider-section {
            height: 100vh;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .slider {
            max-width: 80%;
            height: 500px;
            position: relative;
            overflow: hidden;
            border-radius: 16px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }

        .slides {
            display: flex;
            width: 100%;
            transition: transform 0.6s ease;
        }

        .slides input {
            display: none;
        }

        .slide {
            width: 100%;
        }

        .slide img {
            width: 100%;
            height: 500px;
            object-fit: cover;
        }

        .navigation-manual {
            position: absolute;
            bottom: 20px;
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 12px;
        }

        .manual-btn {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #bbb;
            cursor: pointer;
            transition: background 0.3s;
        }

        #img1:checked ~ .s1 {
            margin-left: 0%;
        }

        #img2:checked ~ .s1 {
            margin-left: -100%;
        }

        #img3:checked ~ .s1 {
            margin-left: -200%;
        }

        #img1:checked ~ .navigation-manual label:nth-child(1),
        #img2:checked ~ .navigation-manual label:nth-child(2),
        #img3:checked ~ .navigation-manual label:nth-child(3) {
            background: #fff;
        }

        /* section-2 */
        .section-2 {
            min-height: 100vh;
        }

        .features-title {
            font-size: 1rem;
            font-weight: bold;
            color: black;
            text-align: left;
            margin-bottom: 20px;
        }

        .features-heading {
            font-size: 5rem;
            font-weight: bold;
            color: black;
            text-align: left;
            margin-bottom: 10px;
        }

        .features-para {
            font-size: 15px;
            color: grey;
            text-align: left;
            margin-bottom: 20px;
        }

        .features {
            display: flex;
            flex-direction: row;
            justify-content: space-evenly;
            gap: 20px;
        }

        .feat-item {
            border-radius: 20px;
            border: 1px solid black;
            min-width: 250px;
            min-height: 300px;
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            align-items: center;
        }

        .feat-item div {
            width: 80%;
            height: 2px;
            border: 1px solid black;
            align-items: center;
            display: none;
        }

        .feat-item h1 {
            align-items: center;
            color: black;
            font-size: 25px;
            font-weight: bold;
        }

        .feat-item p {
            color: rgba(0, 0, 0, 0.529);
            font-size: 15px;
            font-weight: lighter;
            text-align: center;
            padding: 10px;
        }

        /* section-3 */
        .section-3 {
            min-height: 100vh;
        }

        .menu {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .discover-title {
            font-size: 1rem;
            font-weight: bold;
            color: black;
            text-align: left;
            margin-bottom: 20px;
        }

        .menu-title {
            font-size: 5rem;
            font-weight: bold;
            color: black;
            text-align: left;
            margin-bottom: 10px;
        }

        .menu-para {
            font-size: 15px;
            color: grey;
            text-align: left;
            margin-bottom: 20px;
        }

        .menu-items {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .menu-item {
            display: flex;
            flex-direction: column;
            min-height: 100%;
        }

        .menu-item img {
            width: 100%;
            height: 70vh;
            border-radius: 20px;
        }

        .menu-item h1 a {
            text-decoration: none;
            color: black;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }

        .pricing {
            text-align: center;
            min-height: 100vh;
        }

        .pricing-title {
            font-size: 1rem;
            text-align: left;
            font-weight: bold;
            color: black;
            margin-bottom: 20px;
        }

        .pricing-header {
            margin-bottom: 40px;
            text-align: left;
        }

        .pricing-header h1 {
            font-size: 5rem;
            color: black;
            margin-bottom: 20px;
        }

        .pricing-header p {
            font-size: 15px;
            color: grey;
            margin-bottom: 20px;
        }

        .pricing-plans {
            display: flex;
            flex: 1 2 1;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .plan {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 10px;
            width: 30%;
            text-align: center;
        }

        .plan.highlight {
            background: #14d658d6;
        }

        .plan h4 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: black;
        }

        .plan ul {
            list-style: none;
            padding: 0;
            margin: 20px 0;
            text-align: left;
        }

        .plan ul li {
            margin-bottom: 10px;
        }

        .plan button {
            background: white;
            color: black;
            border: 1px solid black;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .newsletter {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 40px 20px;
            margin: 60px 100px;
            border-radius: 20px;
            background-color: hsla(141, 83%, 46%, 0.836 rescuers);
            width: fit-content;
        }

        .newsletter form {
            display: flex;
            margin-top: 10px;
        }

        .newsletter input {
            padding: 10px;
            border: 1px solid;
            border-radius: 5px 0 0 5px;
        }

        .newsletter button {
            padding: 10px;
            border: none;
            background: black;
            color: white;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }

        .extras {
            padding: 40px 20px;
            text-align: center;
            margin: 60px 100px;
            min-height: 50vh;
        }

        .extras-items {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .extras-items img {
            width: 400px;
            border-radius: 20px;
        }

        .extras-items p {
            margin-top: 10px;
            font-size: 1.2rem;
            color: black;
        }

        .footer {
            background: linear-gradient(180deg, #14d658e2, #ffffff);
            padding: 60px 40px;
            border-radius: 24px;
            text-align: center;
            color: #1a1a1a;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .footer-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
            max-width: 1200px;
            margin: auto;
        }

        .footer-col {
            flex: 1 1 220px;
        }

        .footer-logo {
            font-size: 1.8em;
            margin-bottom: 10px;
            color: #ffcc00;
        }

        .footer-col h3 {
            font-size: 1.2em;
            margin-bottom: 30px;
            color: black;
            border: 1.5px solid black;
            padding: 20px;
            border-radius: 10px;
        }

        .footer-col ul {
            list-style: none;
            padding: 0;
        }

        .footer-col ul li {
            margin-bottom: 8px;
        }

        .footer-col ul li a {
            color: black;
            text-decoration: none;
        }

        .footer-col ul li a:hover {
            text-decoration: underline;
        }

        .footer-col p {
            margin-bottom: 8px;
        }

        .social-icons a {
            display: inline-block;
            margin-right: 5px;
        }

        .social-icons img {
            width: 24px;
            height: 24px;
            filter: brightness(0) invert(1);
        }

        .footer-bottom {
            text-align: center;
            margin-top: 30px;
            font-size: 0.9em;
            color: black;
        }

        /* Updated Food Posts Section (Menu Section) */
        .posts-section {
            padding: 60px 30px;
            background: #fdfdfd;
            text-align: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .posts-title {
            font-size: 2em;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .posts-heading {
            font-size: 1.8em;
            margin-bottom: 10px;
        }

        .posts-para {
            font-size: 1.2em;
            color: #666;
            margin-bottom: 20px;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .menu-item {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            text-align: center;
        }

        .menu-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.12);
        }

        .menu-item img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .menu-item h3 {
            margin: 15px 0 5px;
            color: #333;
        }

        .menu-item .desc {
            font-size: 0.9em;
            color: #777;
            padding: 0 15px;
        }

        .menu-item .price {
            font-size: 1.2em;
            color: #27ae60;
            font-weight: bold;
            margin: 15px 0;
        }

        .menu-item form {
            margin: 10px 0;
        }

        .btn-order {
            background-color: #27ae60;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s;
        }

        .btn-order:hover {
            background-color: #219150;
        }

        .alert {
            padding: 10px;
            margin: 10px auto;
            border-radius: 5px;
            max-width: 1200px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        /* Orders Section Styles */
        .orders-section {
            padding: 60px 30px;
            text-align: center;
        }

        .orders-title {
            font-size: 2em;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .orders-heading {
            font-size: 1.8em;
            margin-bottom: 10px;
        }

        .orders-para {
            font-size: 1.2em;
            color: #666;
            margin-bottom: 20px;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .orders-table th,
        .orders-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .orders-table th {
            background-color: #f8f9fa;
            color: #333;
        }

        .orders-table td {
            color: #666;
        }
    </style>
</head>
<body>
    <section class="section-0">
        <header>
            <nav>
                <div class="logo-container">
                    
                    <h1 class="brand-name">Campus<span>Bite</span></h1>
                </div>
                <div class="nav-elements">
                    <ul>
                        <li><a href="../home/home.html">Home</a></li>
                        <li><a href="order.php">Order</a></li>
                        <li><a href="../about/about.html">About Us</a></li>
                    </ul>
                </div>
                <div>
                    <img class="sign-log" src="./images/user (2).png" alt="">
                </div>
            </nav>
        </header>
        <section class="section-1">
            <div class="header-content">
                <h1>Order Fresh Hot <span class="logo">Meals <br> Delivered</span> To Your Door</h1>
                <p>Enjoy delicious, chef-prepared meals without <br>
                    lifting a finger. Hot, ready, and right on time.
                </p>
            </div>
            <div class="header-buttons">
                <button class="order-button2">Order Now</button>
                <button class="learn-more-button">See Menu</button>
            </div>
        </section>
    </section>
    <section>
        <section class="slider-section">
            <div class="slider">
                <div class="slides">
                    <input type="radio" name="radio-btn" id="img1" checked>
                    <input type="radio" name="radio-btn" id="img2">
                    <input type="radio" name="radio-btn" id="img3">
                    <div class="slide s1">
                        <img src="../../images/Recipes/ella-olsson-kKLRvcjQNqM-unsplash.jpg" alt="">
                    </div>
                    <div class="slide">
                        <img src="../../images/Recipes/gebiya-putri-IzdLRdXcNT8-unsplash.jpg" alt="">
                    </div>
                    <div class="slide">
                        <img src="../../images/Recipes/s-o-c-i-a-l-c-u-t-hwy3W3qFjgM-unsplash.jpg" alt="">
                    </div>
                    <div class="navigation-manual">
                        <label for="img1" class="manual-btn"></label>
                        <label for="img2" class="manual-btn"></label>
                        <label for="img3" class="manual-btn"></label>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <section class="section-2">
        <h1 class="features-title">Features</h1>
        <h1 class="features-heading">Why Choose <span class="logo">Campus Bite</span>?</h1>
        <p class="features-para">From customizable plans to expert lifestyle support,<br>
            discover the features that make healthy eating easy and enjoyable.</p>
        <div class="features">
            <div class="feat-item">
                <h1 class="feat-content">Fast & Fresh <span class="logo">Delivery</span></h1>
                <div class="hl"></div>
                <p>Skip the cafeteria lines. Get your favorite
                    campus meals delivered hot and fresh in minutes.</p>
            </div>
            <div class="feat-item">
                <h1 class="feat-content">Student-Friendly <span class="logo">Prices</span></h1>
                <div class="hl"></div>
                <p>Enjoy delicious meals without breaking your budget.
                    Exclusive student discounts every day!</p>
            </div>
            <div class="feat-item">
                <h1 class="feat-content">Variety of <span class="logo">Choices</span></h1>
                <div class="hl"></div>
                <p>From local favorites to international dishes—Campus Bite
                    brings a wide range of cuisines right to your dorm.</p>
            </div>
            <div class="feat-item">
                <h1 class="feat-content">Order <span class="logo">Tracking</span></h1>
                <div class="hl"></div>
                <p>Stay in the loop! Track your food in real-time,
                    from kitchen prep to doorstep delivery.</p>
            </div>
        </div>
    </section>
    <section class="posts-section">
        <h1 class="posts-title">CampusBite Menu</h1>
        <h1 class="posts-heading">Available <span class="logo">Meals</span></h1>
        <p class="posts-para">Browse and order from a variety of delicious meals posted by our vendors.</p>
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
        <?php if (empty($posts)): ?>
            <p>No meals available yet. Check back later!</p>
        <?php else: ?>
            <div class="menu-grid">
                <?php foreach ($posts as $post): ?>
                    <div class="menu-item">
                        <img src="/CAMPUS_BITES_WEB_APP/<?php echo htmlspecialchars($post['image_path']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                        <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                        <p class="desc"><?php echo htmlspecialchars($post['description'] ? $post['description'] : 'No description provided.'); ?></p>
                        <p class="price">$<?php echo number_format($post['price'] ?? 15.99, 2); ?></p>
                        <form method="POST">
                            <input type="hidden" name="food_post_id" value="<?php echo $post['id']; ?>">
                            <button type="submit" name="order" class="btn-order">Order Now</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <section class="pricing">
        <h1 class="pricing-title">Pricing</h1>
        <div class="pricing-header">
            <h1>Flexible Plan <br> <span class="logo">For Every Student</span></h1>
            <p>Choose the plan that fits your lifestyle—whether
                you're a light snacker or a daily foodie,
                <br>Campus Bite has flexible options made for your
                campus routine. Eat smart, save more, and snack
                on your terms.</p>
        </div>
        <div class="pricing-plans">
            <div class="plan">
                <h4>Basic<br>749 birr</h4>
                <ul>
                    <li>1 week package</li>
                    <li>3 meals per day</li>
                    <li>Choose preferred menu</li>
                    <li>1 day detox Juice cleanse</li>
                    <li>Lifestyle advice</li>
                </ul>
                <button>Get plan</button>
            </div>
            <div class="plan highlight">
                <h4>Starter<br>1540 birr</h4>
                <ul>
                    <li>2 week package</li>
                    <li>3 meals per day</li>
                    <li>Choose preferred menu</li>
                    <li>1 day detox Juice cleanse</li>
                    <li>Lifestyle advice</li>
                </ul>
                <button>Get plan</button>
            </div>
            <div class="plan">
                <h4>Pro<br>3000 birr</h4>
                <ul>
                    <li>1 week package</li>
                    <li>3 meals per day</li>
                    <li>Choose preferred menu</li>
                    <li>1 day detox Juice cleanse</li>
                    <li>Lifestyle advice</li>
                </ul>
                <button>Get plan</button>
            </div>
        </div>
    </section>
    <section class="newsletter">
        <div>
            <p>Subscribe to our newsletters and get 10% discount on your first week ration</p>
            <form>
                <input type="email" placeholder="Your email" />
                <button type="submit">Subscribe</button>
            </form>
        </div>
    </section>
    <section class="extras">
        <h3>What else we can offer you</h3>
        <div class="extras-items">
            <div><img src="../../images/Recipes/ella-olsson-kKLRvcjQNqM-unsplash.jpg"><p>Recipes</p></div>
            <div><img src="../../images/Recipes/gebiya-putri-IzdLRdXcNT8-unsplash.jpg"><p>Home workouts</p></div>
            <div><img src="../../images/Recipes/s-o-c-i-a-l-c-u-t-hwy3W3qFjgM-unsplash.jpg"><p>Accessories</p></div>
        </div>
    </section>
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-col">
                <h2 class="footer-logo">CampusBite</h2>
                <p>Your go-to meal partner on campus. Fast, affordable, and delicious Ethiopian food delivered to students.</p>
            </div>
            <div class="footer-col">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#menu">Menu</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#pricing">Pricing</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Contact Us</h3>
                <p>Email: campusbite@gmail.com</p>
                <p>Phone: +251 912 345 678</p>
                <p>Location: Adama, Ethiopia</p>
            </div>
            <div class="footer-col">
                <h3>Follow Us</h3>
                <div class="social-icons">
                    <a href="#"><img src="../../icons/socials/facebook (1).png" alt="Facebook"></a>
                    <a href="#"><img src="../../icons/socials/twitter.png" alt="Twitter"></a>
                    <a href="#"><img src="../../icons/socials/instagram.png" alt="Instagram"></a>
                </div>
            </div>
        </div>
        <p class="footer-bottom">© 2025 CampusBite. All rights reserved.</p>
    </footer>
</body>
</html>