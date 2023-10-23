<?php
include '../../config.php';
if (isset($_GET['logout'])) {
    unset($admin_id);
    session_destroy();
    header('location:/project/login.php');
}

$pitch_booking_select = mysqli_query($mysqli, "SELECT * FROM tbl_pitch_bookings b LEFT JOIN tbl_pitches p ON b.pitch_id = p.id where b.status = 'pending'");
$pitch_booking_count = mysqli_num_rows($pitch_booking_select);

$swimming_site_booking_select = mysqli_query($mysqli, "SELECT * FROM tbl_swimming_site_bookings b LEFT JOIN tbl_swimming_sites s ON b.swimming_site_id = s.id where b.status = 'pending'");
$swimming_site_booking_count = mysqli_num_rows($swimming_site_booking_select);

?>

<aside>
    <div class="logo_container">
        <div class="logo">
            <img src="../../assets/images/Logo.jpg" alt="">
            <h2>GW<span class="danger">SC</span></h2>
        </div>
        <div class="sidebar_close" id="close-btn">
            <span class="fa-solid fa-xmark"></span>
        </div>
    </div>
    <div class="sidebar">
        <a href="/project/admin/pitch_types/index.php" <?php if (str_contains($_SERVER['REQUEST_URI'], "pitch_types")) { ?> class="active" <?php } ?>>
            <span class="fa-solid fa-list"></span>
            <h3>Pitch Types</h3>
        </a>
        <a href="/project/admin/pitches/index.php" <?php if (str_contains($_SERVER['REQUEST_URI'], "pitches")) { ?> class="active" <?php } ?>>
            <span class="fa-solid fa-campground"></span>
            <h3>Pitches</h3>
        </a>
        <a href="/project/admin/swimming_sites/index.php" <?php if (str_contains($_SERVER['REQUEST_URI'], "swimming_sites")) { ?> class="active" <?php } ?>>
            <span class="fa-solid fa-person-swimming"></span>
            <h3>Swimming Sites</h3>
        </a>
        <a href="/project/admin/pitch_bookings/index.php" <?php if (str_contains($_SERVER['REQUEST_URI'], "pitch_bookings")) { ?> class="active" <?php } ?>>
            <span class="fa-solid fa-book-bookmark"></span>
            <h3>Pitch Bookings</h3>
            <?php if ($pitch_booking_count != 0) { ?>
                <span class="message-count">
                    <?php echo $pitch_booking_count ?>
                </span>
            <?php } ?>
        </a>
        <a href="/project/admin/swimming_site_bookings/index.php" <?php if (str_contains($_SERVER['REQUEST_URI'], "swimming_site_bookings")) { ?> class="active" <?php } ?>>
            <span class="fa-solid fa-receipt"></span>
            <h3>Swimming Bookings</h3>
            <?php if ($swimming_site_booking_count != 0) { ?>
                <span class="message-count">
                    <?php
                    echo $swimming_site_booking_count;
                    ?>
                </span>
            <?php } ?>
        </a>
        <a href="/project/admin/feedbacks/index.php" <?php if (str_contains($_SERVER['REQUEST_URI'], "feedbacks")) { ?> class="active" <?php } ?>>
            <span class="fa-solid fa-comment"></span>
            <h3>Feedbacks</h3>
        </a>
        <a href="/project/admin/customers/index.php" <?php if (str_contains($_SERVER['REQUEST_URI'], "customers")) { ?> class="active" <?php } ?>>
            <span class="fa-solid fa-user"></span>
            <h3>Customers</h3>
        </a>
        <a href="/project/admin/accounts/index.php" <?php if (str_contains($_SERVER['REQUEST_URI'], "accounts")) { ?> class="active" <?php } ?>>
            <span class="fa-solid fa-user-shield"></span>
            <h3>Admins</h3>
        </a>
        <a href="/project/index.php">
            <span class="fa-solid fa-person-walking-arrow-right"></span>
            <h3>Customer Website</h3>
        </a>
        <a href="?logout=true">
            <span class="fa-solid fa-arrow-right-from-bracket"></span>
            <h3>Logout</h3>
        </a>
    </div>
</aside>