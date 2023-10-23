<?php
include '../../config.php';
session_start();
$admin_id = $_SESSION['admin_id'];

if (empty($admin_id)) {
    header('location:/project/login.php');
} else {

    $get_all = mysqli_query($mysqli, "SELECT * FROM tbl_pitch_types");

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $get_pitch = mysqli_query($mysqli, "SELECT * FROM tbl_swimming_sites WHERE id = $id");
        $pitch = mysqli_fetch_assoc($get_pitch);

        $get_pitch_images = mysqli_query($mysqli, "SELECT * FROM tbl_swimming_site_images WHERE swimming_site_id = $id");

        if (isset($_POST['submit'])) {

            if (empty($_POST['title'])) {
                $message[] = 'Title is required!';
            } else if (empty($_POST['location'])) {
                $message[] = 'Location is required!';
            } else if (empty($_POST['maximum_guest_count'])) {
                $message[] = 'Maximum guest count is required!';
            } else if (empty($_POST['price'])) {
                $message[] = 'Price is required!';
            } else if (empty($_POST['number_of_tents'])) {
                $message[] = 'Number of tents is required!';
            } else if (empty($_POST['width'])) {
                $message[] = 'Width is required!';
            } else if (empty($_POST['description'])) {
                $message[] = 'Description is required!';
            } else {
                $title = mysqli_real_escape_string($mysqli, $_POST['title']);
                $location = mysqli_real_escape_string($mysqli, $_POST['location']);
                $maximum_guest_count = mysqli_real_escape_string($mysqli, $_POST['maximum_guest_count']);
                $price = mysqli_real_escape_string($mysqli, $_POST['price']);
                $number_of_tents = mysqli_real_escape_string($mysqli, $_POST['number_of_tents']);
                $width = mysqli_real_escape_string($mysqli, $_POST['width']);
                $description = mysqli_real_escape_string($mysqli, $_POST['description']);

                if (isset($_POST['allow_campfires'])) {
                    $allow_campfires = 1;
                } else {
                    $allow_campfires = 0;
                }

                if (isset($_POST['allow_pets'])) {
                    $allow_pets = 1;
                } else {
                    $allow_pets = 0;
                }

                if (isset($_POST['available_wifi'])) {
                    $available_wifi = 1;
                } else {
                    $available_wifi = 0;
                }

                if (isset($_POST['available_electricity'])) {
                    $available_electricity = 1;
                } else {
                    $available_electricity = 0;
                }

                if (isset($_POST['has_cooking_equipments'])) {
                    $has_cooking_equipments = 1;
                } else {
                    $has_cooking_equipments = 0;
                }

                if (isset($_POST['can_bike'])) {
                    $can_bike = 1;
                } else {
                    $can_bike = 0;
                }

                if (isset($_POST['can_fish'])) {
                    $can_fish = 1;
                } else {
                    $can_fish = 0;
                }

                if (isset($_POST['can_sail'])) {
                    $can_sail = 1;
                } else {
                    $can_sail = 0;
                }

                if (isset($_POST['can_hike'])) {
                    $can_hike = 1;
                } else {
                    $can_hike = 0;
                }

                if (isset($_POST['can_ride_horse'])) {
                    $can_ride_horse = 1;
                } else {
                    $can_ride_horse = 0;
                }

                $update_swimming_site = mysqli_query($mysqli, "UPDATE tbl_swimming_sites SET 
                title='$title', 
                location='$location', 
                maximum_guest_count='$maximum_guest_count',
                price='$price',
                number_of_tents='$number_of_tents',
                width='$width',
                description='$description',
                allow_campfires='$allow_campfires',
                allow_pets='$allow_pets',
                available_wifi='$available_wifi',
                available_electricity='$available_electricity',
                has_cooking_equipments='$has_cooking_equipments',
                can_bike='$can_bike',
                can_fish='$can_fish',
                can_sail='$can_sail',
                can_hike='$can_hike',
                can_ride_horse='$can_ride_horse',
                publish_by=1 
            WHERE id = $id") or die('query failed');

                if ($update_swimming_site) {
                    $get_swimming_site_images = mysqli_query($mysqli, "SELECT url FROM tbl_swimming_site_images WHERE swimming_site_id = $id");

                    mysqli_query($mysqli, "DELETE FROM tbl_swimming_site_images WHERE swimming_site_id = $id") or die('query failed');

                    while ($pitch_images = mysqli_fetch_assoc($get_swimming_site_images)) {
                        unlink("../pitch_images/" . $pitch_images['url']);
                    }

                    for ($i = 0; $i < count($_FILES['images']['tmp_name']); $i++) {
                        $image_path = $_FILES['images']["tmp_name"][$i];

                        $image_name = $_FILES['images']['name'][$i];

                        $image_url = "Swimming_Site_" . $swimming_site_id . "_Img_" . ($i + 1) . ".jpg";

                        move_uploaded_file($image_path, "../../uploads/swimming_sites/" . $image_url);

                        mysqli_query($mysqli, "INSERT INTO `tbl_swimming_site_images`(url, name, swimming_site_id) VALUES('$image_url', '$image_name', $id)") or die('query failed');
                    }

                    $message[] = 'Successfully updated!';
                    header('location: index.php');
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
    <title>GWSC | EDIT SWIMMING SITE</title>
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
                <h1>Edit Swimming Site</h1>
            </div>
            <div class="form_container">
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
                    <div class="text_field_container">
                        <div class="text_field">
                            <input type="text" name="title" value="<?php echo $pitch['title']; ?>">
                            <span></span>
                            <label>Title</label>
                        </div>
                        <div class="text_field">
                            <input type="text" name="location" value="<?php echo $pitch['location']; ?>">
                            <span></span>
                            <label>Location (Google Map iFrame URL)</label>
                        </div>
                    </div>

                    <div class="text_field_container">
                        <div class="text_field">
                            <input type="number" name="maximum_guest_count" value="<?php echo $pitch['maximum_guest_count']; ?>">
                            <span></span>
                            <label>Maximum guest count</label>
                        </div>
                        <div class="text_field">
                            <input type="number" name="price" value="<?php echo $pitch['price']; ?>">
                            <span></span>
                            <label>Price per night ($)</label>
                        </div>
                    </div>

                    <div class="text_field_container">
                        <div class="text_field">
                            <input type="number" name="number_of_tents" value="<?php echo $pitch['number_of_tents']; ?>">
                            <span></span>
                            <label>Number of tents</label>
                        </div>
                        <div class="text_field">
                            <input type="number" name="width" value="<?php echo $pitch['width']; ?>">
                            <span></span>
                            <label>Width (acres)</label>
                        </div>
                    </div>

                    <div class="text_field">
                        <input type="text" name="description" value="<?php echo $pitch['description']; ?>">
                        <span></span>
                        <label>Description</label>
                    </div>
                    <!-- checkbox -->
                    <div class="text_field_container">
                        <fieldset class="checkbox_group">
                            <legend class="checkbox_group_title">Features</legend>
                            <div class="checkbox">
                                <label class="checkbox_wrapper">
                                    <input type="checkbox" class="checkbox_input" name="allow_campfires" <?php if ($pitch['allow_campfires'] == 1) {
                                                                                                                echo 'checked="checked"';
                                                                                                            } ?> />
                                    <span class="checkbox_title">
                                        <span class="checkbox_icon">
                                            <i class="fa-solid fa-fire"></i>
                                        </span>
                                        <span class="checkbox_label">Allow Campfires</span>
                                    </span>
                                </label>
                            </div>
                            <div class="checkbox">
                                <label class="checkbox_wrapper">
                                    <input type="checkbox" class="checkbox_input" name="allow_pets" <?php if ($pitch['allow_pets'] == 1) {
                                                                                                        echo 'checked="checked"';
                                                                                                    } ?> />
                                    <span class="checkbox_title">
                                        <span class="checkbox_icon">
                                            <i class="fa-solid fa-dog"></i>
                                        </span>
                                        <span class="checkbox_label">Allow Pets</span>
                                    </span>
                                </label>
                            </div>
                            <div class="checkbox">
                                <label class="checkbox_wrapper">
                                    <input type="checkbox" class="checkbox_input" name="available_wifi" <?php if ($pitch['available_wifi'] == 1) {
                                                                                                            echo 'checked="checked"';
                                                                                                        } ?> />
                                    <span class="checkbox_title">
                                        <span class="checkbox_icon">
                                            <i class="fa-solid fa-wifi"></i>
                                        </span>
                                        <span class="checkbox_label">Available Wifi</span>
                                    </span>
                                </label>
                            </div>
                            <div class="checkbox">
                                <label class="checkbox_wrapper">
                                    <input type="checkbox" class="checkbox_input" name="has_cooking_equipments" <?php if ($pitch['has_cooking_equipments'] == 1) {
                                                                                                                    echo 'checked="checked"';
                                                                                                                } ?> />
                                    <span class="checkbox_title">
                                        <span class="checkbox_icon">
                                            <i class="fa-solid fa-utensils"></i>
                                        </span>
                                        <span class="checkbox_label">Cooking Equipment Present</span>
                                    </span>
                                </label>
                            </div>
                            <div class="checkbox">
                                <label class="checkbox_wrapper">
                                    <input type="checkbox" class="checkbox_input" name="available_electricity" <?php if ($pitch['available_electricity'] == 1) {
                                                                                                                    echo 'checked="checked"';
                                                                                                                } ?> />
                                    <span class="checkbox_title">
                                        <span class="checkbox_icon">
                                            <i class="fa-solid fa-plug"></i>
                                        </span>
                                        <span class="checkbox_label">Available Electricity</span>
                                    </span>
                                </label>
                            </div>
                        </fieldset>
                        <fieldset class="checkbox_group">
                            <legend class="checkbox_group_title" style="opacity: 0;">Features</legend>
                            <div class="checkbox">
                                <label class="checkbox_wrapper">
                                    <input type="checkbox" class="checkbox_input" name="can_bike" <?php if ($pitch['can_bike'] == 1) {
                                                                                                        echo 'checked="checked"';
                                                                                                    } ?> />
                                    <span class="checkbox_title">
                                        <span class="checkbox_icon">
                                            <i class="fa-solid fa-bicycle"></i>
                                        </span>
                                        <span class="checkbox_label">Biking</span>
                                    </span>
                                </label>
                            </div>
                            <div class="checkbox">
                                <label class="checkbox_wrapper">
                                    <input type="checkbox" class="checkbox_input" name="can_fish" <?php if ($pitch['can_fish'] == 1) {
                                                                                                        echo 'checked="checked"';
                                                                                                    } ?> />
                                    <span class="checkbox_title">
                                        <span class="checkbox_icon">
                                            <i class="fa-solid fa-fish-fins"></i>
                                        </span>
                                        <span class="checkbox_label">Fishing</span>
                                    </span>
                                </label>
                            </div>
                            <div class="checkbox">
                                <label class="checkbox_wrapper">
                                    <input type="checkbox" class="checkbox_input" name="can_sail" <?php if ($pitch['can_sail'] == 1) {
                                                                                                        echo 'checked="checked"';
                                                                                                    } ?> />
                                    <span class="checkbox_title">
                                        <span class="checkbox_icon">
                                            <i class="fa-solid fa-sailboat"></i>
                                        </span>
                                        <span class="checkbox_label">Sailing</span>
                                    </span>
                                </label>
                            </div>
                            <div class="checkbox">
                                <label class="checkbox_wrapper">
                                    <input type="checkbox" class="checkbox_input" name="can_hike" <?php if ($pitch['can_hike'] == 1) {
                                                                                                        echo 'checked="checked"';
                                                                                                    } ?> />
                                    <span class="checkbox_title">
                                        <span class="checkbox_icon">
                                            <i class="fa-solid fa-person-hiking"></i>
                                        </span>
                                        <span class="checkbox_label">Hiking</span>
                                    </span>
                                </label>
                            </div>
                            <div class="checkbox">
                                <label class="checkbox_wrapper">
                                    <input type="checkbox" class="checkbox_input" name="can_ride_horse" <?php if ($pitch['can_ride_horse'] == 1) {
                                                                                                            echo 'checked="checked"';
                                                                                                        } ?> />
                                    <span class="checkbox_title">
                                        <span class="checkbox_icon">
                                            <i class="fa-solid fa-horse"></i>
                                        </span>
                                        <span class="checkbox_label">Riding Horse</span>
                                    </span>
                                </label>
                            </div>
                        </fieldset>
                    </div>

                    <!-- photo upload -->

                    <input type="file" name="images[]" id="image-input" hidden multiple onchange="preview(this)" />
                    <label class="image_upload_btn" for="image-input">
                        <i class="fa-solid fa-plus"></i>
                        Add Cover Photos
                    </label>

                    <div class="preview_images" id="preview-images"></div>

                    <div class="form_btns">
                        <a href="./index.php" class="cancel_btn">Cancel</a>
                        <input type="submit" value="Submit" name="submit" class="submit_btn">
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>