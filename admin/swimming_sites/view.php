<?php
include '../../config.php';
session_start();
$admin_id = $_SESSION['admin_id'];

if (empty($admin_id)) {
    header('location:/project/login.php');
} else {
    if (isset($_GET['id'])) {
        $swimming_site_id = $_GET['id'];

        $get_swimming_site = mysqli_query($mysqli, "SELECT * FROM tbl_swimming_sites WHERE id = $swimming_site_id");
        $swimming_site = mysqli_fetch_assoc($get_swimming_site);

        // reviews
        $get_reviews = mysqli_query($mysqli, "SELECT c.name, c.avatar_url, r.description FROM tbl_swimming_site_reviews r, tbl_customers c WHERE r.publish_by = c.id AND r.swimming_site_id = $swimming_site_id");

        // get avg rating
        $get_avg_rating = mysqli_query($mysqli, "SELECT AVG(rating) AS avg_rating, swimming_site_id FROM tbl_swimming_site_reviews GROUP BY swimming_site_id HAVING swimming_site_id=$swimming_site_id");
        $avg_rating = mysqli_fetch_assoc($get_avg_rating);

        $get_swimming_site_images = mysqli_query($mysqli, "SELECT * FROM tbl_swimming_site_images WHERE swimming_site_id = $swimming_site_id");

        $get_swimming_site_first_image = mysqli_query($mysqli, "SELECT * FROM tbl_swimming_site_images WHERE swimming_site_id = $swimming_site_id LIMIT 1");
        $swimming_site_first_image = mysqli_fetch_assoc($get_swimming_site_first_image);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <metat="width=device-width, initial-scale="1.0">
        <title>GWSC | SWIMMING SITE DETAIL</title>
        <link rel="stylesheet" href="../assets/css/index.css">
        <script src="https://kit.fontawesome.com/46933ee6ba.js" crossorigin="anonymous" defer></script>
        <script src="../assets/js/index.js" defer></script>
</head>

<body>
    <div class="admin_container">
        <?php
        include('../components/layouts/Sidebar.php');
        ?>
        <div>
            <div class="topbar">
                <h1>Swimming Site Detail</h1>
            </div>
            <div class="detail_card_wrapper">
                <!-- card left -->
                <div class="detail_left">
                    <div class="detail_main_image">
                        <img src=<?php echo "../../uploads/swimming_sites/" . $swimming_site_first_image['url'] ?> alt="">
                    </div>
                    <div class="detail_thumb_wrapper">
                        <?php while ($row = mysqli_fetch_assoc($get_swimming_site_images)) { ?>
                            <a href=<?php echo "../../uploads/swimming_sites/" . $row['url'] ?> target="detail_main_image" onclick="event.preventDefault();changeImage(this);">
                                <img src=<?php echo "../../uploads/swimming_sites/" . $row['url'] ?> alt="" class="detail_thumb_img">
                            </a>
                        <?php } ?>
                    </div>
                </div>
                <!-- card right -->
                <div class="detail_content">
                    <div class="detail_content">
                        <h2 class="detail_title">
                            <?php echo $swimming_site['title']; ?>
                        </h2>
                        <div class="detail_rating">
                            <?php if ($avg_rating) { ?>
                                <?php for ($i = 1; $i <= floor($avg_rating['avg_rating']); $i++) { ?>
                                    <i class="fas fa-star"></i>
                                <?php } ?>

                                <?php if ((number_format((float)$avg_rating['avg_rating'], 1, '.', '') - floor($avg_rating['avg_rating'])) != 0) { ?>
                                    <i class="fas fa-star-half-alt"></i>
                                    <?php for ($i = 1; $i <= (4 - floor($avg_rating['avg_rating'])); $i++) { ?>
                                        <i class="fa-regular fa-star"></i>
                                    <?php } ?>
                                <?php } else { ?>
                                    <?php for ($i = 1; $i <= (5 - floor($avg_rating['avg_rating'])); $i++) { ?>
                                        <i class="fa-regular fa-star"></i>
                                    <?php } ?>
                                <?php } ?>
                            <?php } else { ?>
                                <i class="fa-regular fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                            <?php } ?>
                            <span>
                                <?php if ($avg_rating) {
                                    echo number_format((float) $avg_rating['avg_rating'], 1, '.', '') ?>
                                    <?php echo "(" . mysqli_num_rows($get_reviews) . ")";
                                } else { ?>( 0 )
                                <?php } ?>
                            </span>
                        </div>

                        <div class="item_container">
                            <p class="item_detail">Price per night: <span>$
                                    <?php echo $swimming_site['price'] ?>
                                </span></p>
                        </div>

                        <div class="detail_text">
                            <h2>About this item: </h2>
                            <p>
                                <?php echo $swimming_site['description']; ?>
                            </p>
                            <div class="item_container">
                                <div class="item_detail">Maximum guest count: <span>
                                        <?php echo $swimming_site['maximum_guest_count']; ?>
                                    </span></div>
                            </div>
                            <div class="item_container">
                                <div class="item_detail">Number of tents: <span>
                                        <?php echo $swimming_site['number_of_tents']; ?>
                                    </span></div>
                            </div>
                            <div class="item_container">
                                <div class="item_detail">Width (acres): <span>
                                        <?php echo $swimming_site['width']; ?>
                                    </span></div>
                            </div>
                        </div>

                        <div class="social_links">
                            <p>Share At: </p>
                            <a href="#">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                            <a href="#">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                            <a href="#">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="detail_features_wrapper">
                <h2>Available Features</h2>
                <div class="detail_features_box">
                    <div class="detail_features">
                        <?php if ($swimming_site['allow_campfires'] == 1) { ?>
                            <label class="checkbox_wrapper">
                                <input type="checkbox" class="checkbox_input" checked disabled />
                                <span class="checkbox_title">
                                    <span class="checkbox_icon">
                                        <i class="fa-solid fa-fire"></i>
                                    </span>
                                    <span class="checkbox_label">Allow Campfires</span>
                                </span>
                            </label>
                        <?php } ?>
                        <?php if ($swimming_site['allow_pets'] == 1) { ?>
                            <label class="checkbox_wrapper">
                                <input type="checkbox" class="checkbox_input" checked disabled />
                                <span class="checkbox_title">
                                    <span class="checkbox_icon">
                                        <i class="fa-solid fa-dog"></i>
                                    </span>
                                    <span class="checkbox_label">Allow Pets</span>
                                </span>
                            </label>
                        <?php } ?>
                        <?php if ($swimming_site['available_wifi'] == 1) { ?>
                            <label class="checkbox_wrapper">
                                <input type="checkbox" class="checkbox_input" checked disabled />
                                <span class="checkbox_title">
                                    <span class="checkbox_icon">
                                        <i class="fa-solid fa-wifi"></i>
                                    </span>
                                    <span class="checkbox_label">Available Wifi</span>
                                </span>
                            </label>
                        <?php } ?>
                        <?php if ($swimming_site['has_cooking_equipments'] == 1) { ?>
                            <label class="checkbox_wrapper">
                                <input type="checkbox" class="checkbox_input" checked disabled />
                                <span class="checkbox_title">
                                    <span class="checkbox_icon">
                                        <i class="fa-solid fa-utensils"></i>
                                    </span>
                                    <span class="checkbox_label">Cooking Equipment Present</span>
                                </span>
                            </label>
                        <?php } ?>
                        <?php if ($swimming_site['available_electricity'] == 1) { ?>
                            <label class="checkbox_wrapper">
                                <input type="checkbox" class="checkbox_input" checked disabled />
                                <span class="checkbox_title">
                                    <span class="checkbox_icon">
                                        <i class="fa-solid fa-plug"></i>
                                    </span>
                                    <span class="checkbox_label">Available Electricity</span>
                                </span>
                            </label>
                        <?php } ?>
                    </div>
                    <div class="detail_features">
                        <?php if ($swimming_site['can_bike'] == 1) { ?>
                            <label class="checkbox_wrapper">
                                <input type="checkbox" class="checkbox_input" checked disabled />
                                <span class="checkbox_title">
                                    <span class="checkbox_icon">
                                        <i class="fa-solid fa-bicycle"></i>
                                    </span>
                                    <span class="checkbox_label">Biking</span>
                                </span>
                            </label>
                        <?php } ?>
                        <?php if ($swimming_site['can_fish'] == 1) { ?>
                            <label class="checkbox_wrapper">
                                <input type="checkbox" class="checkbox_input" checked disabled />
                                <span class="checkbox_title">
                                    <span class="checkbox_icon">
                                        <i class="fa-solid fa-fish-fins"></i>
                                    </span>
                                    <span class="checkbox_label">Fishing</span>
                                </span>
                            </label>
                        <?php } ?>
                        <?php if ($swimming_site['can_sail'] == 1) { ?>
                            <label class="checkbox_wrapper">
                                <input type="checkbox" class="checkbox_input" checked disabled />
                                <span class="checkbox_title">
                                    <span class="checkbox_icon">
                                        <i class="fa-solid fa-sailboat"></i>
                                    </span>
                                    <span class="checkbox_label">Sailing</span>
                                </span>
                            </label>
                        <?php } ?>
                        <?php if ($swimming_site['can_hike'] == 1) { ?>
                            <label class="checkbox_wrapper">
                                <input type="checkbox" class="checkbox_input" checked disabled />
                                <span class="checkbox_title">
                                    <span class="checkbox_icon">
                                        <i class="fa-solid fa-person-hiking"></i>
                                    </span>
                                    <span class="checkbox_label">Hiking</span>
                                </span>
                            </label>
                        <?php } ?>
                        <?php if ($swimming_site['can_ride_horse'] == 1) { ?>
                            <label class="checkbox_wrapper">
                                <input type="checkbox" class="checkbox_input" checked disabled />
                                <span class="checkbox_title">
                                    <span class="checkbox_icon">
                                        <i class="fa-solid fa-horse"></i>
                                    </span>
                                    <span class="checkbox_label">Riding Horse</span>
                                </span>
                            </label>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="detail_map">
                <iframe src=<?php echo $swimming_site['location'] ?> width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

    </div>

</body>

</html>