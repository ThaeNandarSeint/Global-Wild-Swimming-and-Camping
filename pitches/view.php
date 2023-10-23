<?php
session_start();
include '../config.php';

if (!isset($_SESSION['customer_id']) && !isset($_SESSION['admin_id']) && !isset($_SESSION['superadmin_id'])) {
    header('location:/project/login.php');
} else {
    if (isset($_SESSION['customer_id'])) {
        $customer_id = $_SESSION['customer_id'];
    }

    if (isset($_GET['id'])) {

        $pitch_id = $_GET['id'];

        // pitch
        $get_pitch = mysqli_query($mysqli, "SELECT * FROM tbl_pitches WHERE id = $pitch_id");
        $pitch = mysqli_fetch_assoc($get_pitch);
        $get_pitch_images = mysqli_query($mysqli, "SELECT * FROM tbl_pitch_images WHERE pitch_id = $pitch_id");

        // increase view count
        $view_count = $pitch['view_count'] + 1;
        mysqli_query($mysqli, "UPDATE tbl_pitches SET view_count = $view_count WHERE id = $pitch_id");

        // first pitch image
        $get_pitch_first_image = mysqli_query($mysqli, "SELECT * FROM tbl_pitch_images WHERE pitch_id = $pitch_id LIMIT 1");
        $pitch_first_image = mysqli_fetch_assoc($get_pitch_first_image);

        // pitch type
        $pitch_type_id = $pitch['pitch_type_id'];
        $get_pitch_type = mysqli_query($mysqli, "SELECT * FROM tbl_pitch_types WHERE id = $pitch_type_id");
        $pitch_type = mysqli_fetch_assoc($get_pitch_type);

        // reviews
        $get_reviews = mysqli_query($mysqli, "SELECT c.name, c.avatar_url, r.description FROM tbl_pitch_reviews r, tbl_customers c WHERE r.publish_by = c.id AND r.pitch_id = $pitch_id");

        // get avg rating
        $get_avg_rating = mysqli_query($mysqli, "SELECT AVG(rating) AS avg_rating, pitch_id FROM tbl_pitch_reviews GROUP BY pitch_id HAVING pitch_id=$pitch_id");
        $avg_rating = mysqli_fetch_assoc($get_avg_rating);

        // insert review
        if (isset($_POST['submit'])) {
            if (!isset($customer_id)) {
                $message[] = 'Cannot create review with admin account!';
            } else {
                $description = mysqli_real_escape_string($mysqli, $_POST['description']);
                $rating = mysqli_real_escape_string($mysqli, $_POST['rate']);

                $insert_review = mysqli_query($mysqli, "INSERT INTO `tbl_pitch_reviews`(description, rating, publish_by, pitch_id) VALUES('$description', '$rating', $customer_id, $pitch_id)") or die('query failed');

                if ($insert_review) {
                    $message[] = 'Sended!';
                } else {
                    $message[] = 'Failed!';
                }
            }
        }

        // booking
        if (isset($_POST['booking_submit'])) {
            if (!isset($customer_id)) {
                $message[] = "Cannot create booking with admin account!";
            } else {
                $guest_count = mysqli_real_escape_string($mysqli, $_POST['guest_count']);
                $start_date = mysqli_real_escape_string($mysqli, $_POST['start_date']);
                $end_date = mysqli_real_escape_string($mysqli, $_POST['end_date']);

                $insert_pitch_booking = mysqli_query($mysqli, "INSERT INTO `tbl_pitch_bookings`(pitch_id, customer_id, guest_count, start_date, end_date) VALUES('$pitch_id', '$customer_id', '$guest_count', '$start_date', '$end_date')") or die('query failed');

                if ($insert_pitch_booking) {
                    $message[] = 'Booking success!';
                } else {
                    $message[] = 'Failed!';
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GWSC | PITCHES</title>
    <!-- css -->
    <link rel="stylesheet" href="../assets/css/index.css">
    <script src="../assets/js/index.js" defer></script>
    <script src="https://kit.fontawesome.com/46933ee6ba.js" crossorigin="anonymous" defer></script>
</head>

<body>
    <!-- navbar -->
    <?php include('../components/layouts/Navbar.php') ?>
    <!-- body -->
    <section class="body-70">
        <div class="component_wrapper">
            <h1>Pitch<span style="color: var(--color-danger);"> Detail</span></h1>
            <?php
            if (isset($message)) {
                foreach ($message as $message) {
                    echo "<div class='message_container'>
                            <b>{$message}</b>
                            <i class='fa-solid fa-circle-xmark' id='message_container-close' onclick='closeErrorMsg()'></i>
                        </div>";
                }
            }
            ?>
            <div class="detail_card_box">
                <div class="detail_card_wrapper">
                    <!-- card left -->
                    <div class="detail_left">
                        <div class="detail_main_image">
                            <img src=<?php echo "../uploads/pitches/" . $pitch_first_image['url'] ?> alt="">
                        </div>
                        <div class="detail_thumb_wrapper">
                            <?php while ($row = mysqli_fetch_assoc($get_pitch_images)) { ?>
                                <a href=<?php echo "../uploads/pitches/" . $row['url'] ?> target="detail_main_image" onclick="event.preventDefault();changeImage(this);">
                                    <img src=<?php echo "../uploads/pitches/" . $row['url'] ?> alt="" class="detail_thumb_img">
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- card right -->
                    <div class="detail_content">
                        <h2 class="detail_title">
                            <?php echo $pitch['title']; ?>
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
                            <p class="item_detail">Price per night: <span>
                                    <?php echo $pitch['price'] ?> Kyats
                                </span></p>
                        </div>

                        <div class="detail_text">
                            <h2>About this item: </h2>
                            <p>
                                <?php echo $pitch['description']; ?>
                            </p>
                            <div class="item_container">
                                <div class="item_detail">Pitch Type: <span>
                                        <?php echo $pitch_type['title']; ?>
                                    </span></div>
                            </div>
                            <div class="item_container">
                                <div class="item_detail">Maximum guest count: <span>
                                        <?php echo $pitch['maximum_guest_count']; ?>
                                    </span></div>
                            </div>
                            <div class="item_container">
                                <div class="item_detail">Number of sites: <span>
                                        <?php echo $pitch['number_of_sites']; ?>
                                    </span></div>
                            </div>
                            <div class="item_container">
                                <div class="item_detail">Number of tents: <span>
                                        <?php echo $pitch['number_of_tents']; ?>
                                    </span></div>
                            </div>
                            <div class="item_container">
                                <div class="item_detail">Number of RVs: <span>
                                        <?php echo $pitch['number_of_rvs']; ?>
                                    </span></div>
                            </div>
                            <div class="item_container">
                                <div class="item_detail">Width (acres): <span>
                                        <?php echo $pitch['width']; ?>
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
                <div class="detail_features_wrapper">
                    <h2>Available Features</h2>
                    <div class="detail_features_box">
                        <div class="detail_features">
                            <?php if ($pitch['allow_campfires'] == 1) { ?>
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
                            <?php if ($pitch['allow_pets'] == 1) { ?>
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
                            <?php if ($pitch['available_wifi'] == 1) { ?>
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
                            <?php if ($pitch['has_cooking_equipments'] == 1) { ?>
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
                            <?php if ($pitch['available_electricity'] == 1) { ?>
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
                            <?php if ($pitch['can_bike'] == 1) { ?>
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
                            <?php if ($pitch['can_fish'] == 1) { ?>
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
                            <?php if ($pitch['can_sail'] == 1) { ?>
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
                            <?php if ($pitch['can_hike'] == 1) { ?>
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
                            <?php if ($pitch['can_ride_horse'] == 1) { ?>
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
                <form method="post">
                    <div class="detail_btn">
                        <div class="date_picker">
                            <label>Start Date</label>
                            <input type="date" name="start_date">
                        </div>
                        <div class="date_picker">
                            <label>End Date</label>
                            <input type="date" name="end_date">
                        </div>
                        <div class="text_field">
                            <input type="number" name="guest_count" placeholder="Enter guest count">
                        </div>
                        <button class="booking_btn" name="booking_submit" type="submit">Book Now</button>
                    </div>
                </form>
                <div class="detail_map">
                    <iframe src=<?php echo $pitch['location'] ?> width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
        <div class="component_wrapper">
            <h1>Reviews and <span style="color: var(--color-danger);"> Ratings</span></h1>
            <div class="reviews_container">
                <i id="left" class="fa-solid fa-angle-left"></i>
                <ul class="reviews_carousel">
                    <?php while ($row = mysqli_fetch_assoc($get_reviews)) { ?>
                        <li class="reviews_card">
                            <div class="img"><img src=<?php echo "../uploads/customers/" . $row['avatar_url'] ?> alt="img" draggable="false"></div>
                            <h2>
                                <?php echo $row['name'] ?>
                            </h2>
                            <span>29 July 2023</span>
                            <p>
                                <?php echo $row['description'] ?>
                            </p>
                        </li>
                    <?php } ?>
                </ul>
                <i id="right" class="fa-solid fa-angle-right"></i>
            </div>
        </div>
        <div class="component_wrapper">
            <h1>Support Us By<span style="color: var(--color-danger);"> Writing Reviews</span></h1>
            <div class="form_container review_form_container">
                <?php
                if (isset($message)) {
                    foreach ($message as $message) {
                        echo "<div class='message_container'>
                                <b>{$message}</b>
                                <i class='fa-solid fa-circle-xmark' id='message_container-close' onclick='closeErrorMsg()'></i>
                            </div>";
                    }
                }
                ?>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="review_wrapper">
                        <div class="review_box">
                            <div class="review_stars">
                                <input type="radio" id="five" name="rate" value="5" onclick="displayReviewContent(this)">
                                <label for="five"></label>
                                <input type="radio" id="four" name="rate" value="4" onclick="displayReviewContent(this)">
                                <label for="four"></label>
                                <input type="radio" id="three" name="rate" value="3" onclick="displayReviewContent(this)">
                                <label for="three"></label>
                                <input type="radio" id="two" name="rate" value="2" onclick="displayReviewContent(this)">
                                <label for="two"></label>
                                <input type="radio" id="one" name="rate" value="1" onclick="displayReviewContent(this)">
                                <label for="one"></label>
                            </div>
                        </div>
                    </div>
                    <h2 class="review_result" id="review_result"></h2>
                    <div class="text_field">
                        <input type="text" name="description">
                        <span></span>
                        <label>Describe Your Experience</label>
                    </div>
                    <div class="form_btns">
                        <input type="submit" value="Submit" name="submit" class="submit_btn">
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- footer -->
    <?php include('../components/layouts/Footer.php') ?>
</body>

</html>