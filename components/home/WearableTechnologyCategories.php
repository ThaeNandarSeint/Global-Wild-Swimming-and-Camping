<?php
session_start();
include './config.php';

if (!isset($_SESSION['customer_id']) && !isset($_SESSION['admin_id']) && !isset($_SESSION['superadmin_id'])) {
    header('location:/project/login.php');
} else {
    if (isset($_SESSION['customer_id'])) {
        $customer_id = $_SESSION['customer_id'];
    }
    if (isset($_POST['submit'])) {
        if (!isset($customer_id)) {
            $message[] = 'Cannot order with admin account!';
        } else {
            $message[] = 'Successfully Ordered!';
        }
    }
}

?>

<div class="component_wrapper">
    <h1>Wearable Technology <span style="color: var(--color-danger);">Categories</span></h1>
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
                    <img src="./assets/images/GPS_Watch.webp" alt="">
                </div>
                <div class="detail_thumb_wrapper">
                    <a href="./assets/images/GPS_Watch.webp" target="detail_main_image" onclick="event.preventDefault();changeImage(this);changeWearableText('GPS Watch')">
                        <img src="./assets/images/GPS_Watch.webp" alt="" class="detail_thumb_img">
                    </a>

                    <a href="./assets/images/Head_Lamps.jpg" target="detail_main_image" onclick="event.preventDefault();changeImage(this);changeWearableText('Head Lamp')">
                        <img src="./assets/images/Head_Lamps.jpg" alt="" class="detail_thumb_img">
                    </a>

                    <a href="./assets/images/Mosquito_Repellent_Bracelet.jpg" target="detail_main_image" onclick="event.preventDefault();changeImage(this);changeWearableText('Mosquito Repellent Bracelet')">
                        <img src="./assets/images/Mosquito_Repellent_Bracelet.jpg" alt="" class="detail_thumb_img">
                    </a>

                    <a href="./assets/images/Solar_Powered_Chargers.jpg" target="detail_main_image" onclick="event.preventDefault();changeImage(this);changeWearableText('Solor Powered Charger')">
                        <img src="./assets/images/Solar_Powered_Chargers.jpg" alt="" class="detail_thumb_img">
                    </a>

                    <a href="./assets/images/Water_Quality_Sensors.jpg" target="detail_main_image" onclick="event.preventDefault();changeImage(this);changeWearableText('Water Quality Sensor')">
                        <img src="./assets/images/Water_Quality_Sensors.jpg" alt="" class="detail_thumb_img">
                    </a>

                    <a href="./assets/images/Fitness_Tracker_Watch.jpg" target="detail_main_image" onclick="event.preventDefault();changeImage(this);changeWearableText('Fitness Tracker Watch')">
                        <img src="./assets/images/Fitness_Tracker_Watch.jpg" alt="" class="detail_thumb_img">
                    </a>
                </div>
            </div>
            <!-- card right -->
            <div class="detail_content">
                <h2 class="detail_title" id="wearable_title">
                    GPS Watch
                </h2>
                <div class="item_container">
                    <p class="item_detail">
                        Price: <span id="wearable_price">
                            10500 Kyats
                        </span>
                    </p>
                </div>
                <div class="detail_text">
                    <h2>About this item: </h2>
                    <p id="wearable_description">
                        A GPS watch, also known as a Global Positioning System watch, is a wearable device that combines a regular wristwatch with GPS technology. It allows the wearer to receive signals from multiple satellites in orbit around the Earth, which can accurately determine their geographical location.
                    </p>
                    <div class="item_container">
                        <div class="item_detail">
                            Category: <span id="wearable_category">
                                Navigation and GPS Devices
                            </span>
                        </div>
                    </div>

                    <div class="item_container">
                        <div class="item_detail">
                            Stocks: <span id="wearable_stock">
                                25
                            </span>
                        </div>
                    </div>
                    <form method="post">
                        <div class="item_container">
                            <div class="navigate_btn" style="justify-content: left;">
                                <input type="submit" value="Order" name="submit" class="submit_btn" style="background: var(--color-danger);">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>