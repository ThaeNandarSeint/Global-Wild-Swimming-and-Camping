<?php
include './config.php';
session_start();

if (!isset($_SESSION['customer_id']) && !isset($_SESSION['admin_id']) && !isset($_SESSION['superadmin_id'])) {
    header('location:/project/login.php');
} else if (isset($_POST['submit'])) {
    if (isset($_SESSION['customer_id'])) {
        $customer_id = $_SESSION['customer_id'];
    }
    if (!isset($customer_id)) {
        $message[] = 'Cannot send feedback with admin account!';
    } else {
        $description = mysqli_real_escape_string($mysqli, $_POST['message']);

        $insert_message = mysqli_query($mysqli, "INSERT INTO `tbl_feedbacks`(message, customer_id) VALUES('$description', '$customer_id')") or die('query failed');

        if ($insert_message) {
            $message[] = 'Successfully sended!';
        } else {
            $message[] = 'Failed!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWSC | CONTACT</title>
    <link rel="stylesheet" href="./assets/css/index.css">
    <script src="./assets/js/index.js" defer></script>
    <script src="https://kit.fontawesome.com/46933ee6ba.js" crossorigin="anonymous" defer></script>
</head>

<body>

    <?php include('./components/layouts/Navbar.php') ?>

    <section class="contact-section body-70">
        <div class="contact_banner">
            <h3>Get in Touch with Us</h3>
            <h2>contact us</h2>
            <p>Stepping out of your comfort zone and into nature's embrace can lead to profound self-discovery.</p>
        </div>
        <?php
        if (isset($messages)) {
            foreach ($messages as $message) {
                echo "<div class='message_container'>
                    <b>{$message}</b>
                    <i class='fa-solid fa-circle-xmark' id='message_container-close' onclick='closeErrorMsg()'></i>
                </div>";
            }
        }
        ?>
        <div class="contact_container">
            <div class="contact_info">
                <div>
                    <i class="fa-solid fa-phone danger contact_icon"></i>
                    <span>Phone No.</span>
                    <span class="contact_info_text">+959 758 764 462</span>
                </div>
                <div>
                    <i class="fa-solid fa-envelope-open-text contact_icon primary"></i>
                    <span>E-mail</span>
                    <span class="contact_info_text danger">gwsc@gmail.com</span>
                </div>
                <div>
                    <span>
                        <i class="fa-solid fa-map-location-dot contact_icon primary"></i>
                    </span>
                    <span>Address</span>
                    <span class="contact_info_text danger">No 81, Anawmar 2nd Street, Tharkayta, Yangon</span>
                </div>
                <div>
                    <span>
                        <i class="fa-solid fa-clock contact_icon danger"></i>
                    </span>
                    <span>Opening Hours</span>
                    <span class="contact_info_text">Monday - Friday (9:00 AM to 5:00 PM)</span>
                </div>
            </div>
            <div class="component_wrapper">
                <h1>Support Us By<span style="color: var(--color-danger);"> Sending Feedbacks</span></h1>
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
                    <form method="post" action="">
                        <div class="text_field">
                            <input type="text" name="message">
                            <span></span>
                            <label>Message</label>
                        </div>
                        <div class="contact_privacy_link">
                            <a href="policy_and_privacy.php" style="text-decoration: underline;">Our policy and privacy</a>
                        </div>
                        <div class="form_btns">
                            <input type="submit" value="Submit" name="submit" class="submit_btn">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include('./components/layouts/Footer.php') ?>
</body>

</html>