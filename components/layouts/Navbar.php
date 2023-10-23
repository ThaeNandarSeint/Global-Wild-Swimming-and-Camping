<?php
$not_authenticated = (!isset($_SESSION['customer_id']) && !isset($_SESSION['admin_id']) && !isset($_SESSION['superadmin_id']));
$is_admin = (isset($_SESSION['admin_id']) || isset($_SESSION['superadmin_id']));
if (isset($_GET['logout'])) {
    unset($customer_id);
    unset($admin_id);
    unset($superadmin_id);
    session_destroy();
    header('location:/project/login.php');
}
?>

<header class="navbar_container">
    <nav>
        <input class="navbar_checkbox" type="checkbox" id="show-search">
        <input class="navbar_checkbox" type="checkbox" id="show-menu">
        <label for="show-menu" class="navbar_menu_icon"><i class="fa-solid fa-bars"></i></label>
        <div class="navbar_content">
            <div class="navbar_logo">
                <a href="index.php">
                    <img src="/project/assets/images/Logo.jpg" alt="">
                </a>
            </div>
            <ul class="navbar_links">
                <li><a href="/project/index.php" <?php if (str_contains($_SERVER['REQUEST_URI'], "/project/index.php")) { ?> class="navbar_active" <?php } ?>>Home</a></li>

                <li><a href="/project/information.php" <?php if (str_contains($_SERVER['REQUEST_URI'], "information")) { ?> class="navbar_active" <?php } ?>>Information</a></li>

                <li><a href="/project/pitch_types_and_availability.php" <?php if (str_contains($_SERVER['REQUEST_URI'], "pitch_types_and_availability")) { ?> class="navbar_active" <?php } ?>>Pitch Types and Availability</a></li>

                <li><a href="/project/reviews.php" <?php if (str_contains($_SERVER['REQUEST_URI'], "reviews")) { ?> class="navbar_active" <?php } ?>>Reviews</a></li>

                <li><a href="/project/features.php" <?php if (str_contains($_SERVER['REQUEST_URI'], "features")) { ?> class="navbar_active" <?php } ?>>Features</a></li>

                <li><a href="/project/contact.php" <?php if (str_contains($_SERVER['REQUEST_URI'], "contact")) { ?> class="navbar_active" <?php } ?>>Contact</a></li>

                <li><a href="/project/local_attractions.php" <?php if (str_contains($_SERVER['REQUEST_URI'], "local_attractions")) { ?> class="navbar_active" <?php } ?>>Local Attractions</a></li>

                <?php if ($not_authenticated) { ?>
                    <li>
                        <a href="/project/login.php" class="auth_btn">
                            Login
                        </a>
                    </li>
                <?php } else if ($is_admin == true) { ?>
                    <li>
                        <a href="/project/admin/pitch_types/index.php" class="auth_btn">
                            Panel
                        </a>
                    </li>
                <?php } else { ?>
                    <li>
                        <a href="?logout=true" class="auth_btn">
                            Logout
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
</header>