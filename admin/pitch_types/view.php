<?php
include '../../config.php';
session_start();
$admin_id = $_SESSION['admin_id'];

if (empty($admin_id)) {
    header('location:/project/login.php');
} else {
    if (isset($_GET['id'])) {
        $pitch_type_id = $_GET['id'];

        $get_pitch_type = mysqli_query($mysqli, "SELECT * FROM tbl_pitch_types WHERE id = $pitch_type_id");
        $pitch_type = mysqli_fetch_assoc($get_pitch_type);

        $get_pitch_type_images = mysqli_query($mysqli, "SELECT * FROM tbl_pitch_type_images WHERE pitch_type_id = $pitch_type_id");

        $get_pitch_type_first_image = mysqli_query($mysqli, "SELECT * FROM tbl_pitch_type_images WHERE pitch_type_id = $pitch_type_id LIMIT 1");

        $pitch_type_first_image = mysqli_fetch_assoc($get_pitch_type_first_image);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWSC | PITCH TYPE DETAIL</title>
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
                <h1>Pitch Type Detail</h1>
            </div>
            <div class="detail_card_wrapper">
                <!-- card left -->
                <div class="detail_left">
                    <div class="detail_main_image">
                        <img src=<?php echo "../../uploads/pitch_types/" . $pitch_type_first_image['url'] ?> alt="">
                    </div>
                    <div class="detail_thumb_wrapper">
                        <?php while ($row = mysqli_fetch_assoc($get_pitch_type_images)) { ?>
                            <a href=<?php echo "../../uploads/pitch_types/" . $row['url'] ?> target="detail_main_image" onclick="event.preventDefault();changeImage(this);">
                                <img src=<?php echo "../../uploads/pitch_types/" . $row['url'] ?> alt="" class="detail_thumb_img">
                            </a>
                        <?php } ?>
                    </div>
                </div>
                <!-- card right -->
                <div class="detail_content">
                    <h2 class="detail_title">
                        <?php echo $pitch_type['title']; ?>
                    </h2>

                    <div class="detail_text">
                        <h2>About: </h2>
                        <p>
                            <?php echo $pitch_type['description']; ?>
                        </p>
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

    </div>

</body>

</html>