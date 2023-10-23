<?php
include '../../config.php';
session_start();
$admin_id = $_SESSION['admin_id'];

if (empty($admin_id)) {
    header('location:/project/login.php');
} else {

    $get_all = mysqli_query($mysqli, "SELECT * FROM tbl_pitch_types");

    if (isset($_POST['submit'])) {

        if (empty($_POST['title'])) {
            $message[] = 'Title is required!';
        } else if (empty($_POST['location'])) {
            $message[] = 'Location is required!';
        } else if (empty($_POST['maximum_guest_count'])) {
            $message[] = 'Maximum guest count is required!';
        } else if (empty($_POST['price'])) {
            $message[] = 'Price is required!';
        } else if (empty($_POST['number_of_sites'])) {
            $message[] = 'Number of sites is required!';
        } else if (empty($_POST['number_of_tents'])) {
            $message[] = 'Number of tents is required!';
        } else if (empty($_POST['number_of_rvs'])) {
            $message[] = 'Number of RVs is required!';
        } else if (empty($_POST['width'])) {
            $message[] = 'Width is required!';
        } else if (empty($_POST['description'])) {
            $message[] = 'Description is required!';
        } else if (empty($_POST['pitch_type_id'])) {
            $message[] = 'Please select pitch type!';
        } else {
            $title = mysqli_real_escape_string($mysqli, $_POST['title']);
            $location = mysqli_real_escape_string($mysqli, $_POST['location']);
            $maximum_guest_count = mysqli_real_escape_string($mysqli, $_POST['maximum_guest_count']);
            $price = mysqli_real_escape_string($mysqli, $_POST['price']);
            $number_of_tents = mysqli_real_escape_string($mysqli, $_POST['number_of_tents']);
            $number_of_sites = mysqli_real_escape_string($mysqli, $_POST['number_of_sites']);
            $number_of_rvs = mysqli_real_escape_string($mysqli, $_POST['number_of_rvs']);
            $width = mysqli_real_escape_string($mysqli, $_POST['width']);
            $description = mysqli_real_escape_string($mysqli, $_POST['description']);
            $pitch_type_id = $_POST['pitch_type_id'];

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

            $insert_pitch = mysqli_query($mysqli, "INSERT INTO `tbl_pitches`(title, location, maximum_guest_count, price, number_of_tents, number_of_sites, number_of_rvs, width, description, allow_campfires, allow_pets, available_wifi, available_electricity, has_cooking_equipments, can_bike, can_fish, can_sail, can_hike, can_ride_horse, publish_by, pitch_type_id) 
            VALUES('$title', '$location', '$maximum_guest_count', '$price', '$number_of_tents', '$number_of_sites', '$number_of_rvs', '$width', '$description', '$allow_campfires', '$allow_pets',	'$available_wifi', '$available_electricity', '$has_cooking_equipments', '$can_bike', '$can_fish', '$can_sail', '$can_hike', '$can_ride_horse', 1, '$pitch_type_id')") or die('query failed');

            if ($insert_pitch) {
                $pitch_id = mysqli_insert_id($mysqli);

                for ($i = 0; $i < count($_FILES['images']['tmp_name']); $i++) {
                    $image_path = $_FILES['images']["tmp_name"][$i];

                    $image_name = $_FILES['images']['name'][$i];

                    $image_url = "Pitch_" . $pitch_id . "_Img_" . ($i + 1) . ".jpg";

                    move_uploaded_file($image_path, "../../uploads/pitches/" . $image_url);

                    $insert_pitch_type_images = mysqli_query($mysqli, "INSERT INTO `tbl_pitch_images`(url, name, pitch_id) VALUES('$image_url', '$image_name', '$pitch_id')") or die('query failed');
                }

                $message[] = 'Successfully created!';
                header('location: index.php');
            } else {
                $message[] = 'Failed!';
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
    <title>GWSC | ADD NEW PITCH</title>
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
                <h1>Add New Pitch</h1>
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
                            <input type="text" name="title">
                            <span></span>
                            <label>Title</label>
                        </div>
                        <div class="text_field">
                            <input type="text" name="location">
                            <span></span>
                            <label>Location (Google Map iFrame URL)</label>
                        </div>
                    </div>

                    <div class="text_field_container">
                        <div class="text_field">
                            <input type="number" name="maximum_guest_count">
                            <span></span>
                            <label>Maximum guest count</label>
                        </div>
                        <div class="text_field">
                            <input type="number" name="price">
                            <span></span>
                            <label>Price per night (Kyats)</label>
                        </div>
                    </div>

                    <div class="text_field_container">
                        <div class="text_field">
                            <input type="number" name="number_of_sites">
                            <span></span>
                            <label>Number of sites</label>
                        </div>
                        <div class="text_field">
                            <input type="number" name="number_of_tents">
                            <span></span>
                            <label>Number of tents</label>
                        </div>
                    </div>

                    <div class="text_field_container">
                        <div class="text_field">
                            <input type="number" name="number_of_rvs">
                            <span></span>
                            <label>Number of RVs</label>
                        </div>
                        <div class="text_field">
                            <input type="number" name="width">
                            <span></span>
                            <label>Width (acres)</label>
                        </div>
                    </div>

                    <div class="text_field">
                        <input type="text" name="description">
                        <span></span>
                        <label>Description</label>
                    </div>

                    <!-- select box -->
                    <div class="select_wrapper">
                        <div class="options_container">
                            <?php while ($row = mysqli_fetch_assoc($get_all)) { ?>
                                <div class="select_option">
                                    <input type="radio" class="radio" id="film" name="category" value="<?php echo $row['id']; ?>" />
                                    <label for="film">
                                        <?php echo $row['title']; ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="selected">
                            Select Pitch Type
                            <i class="fa-solid fa-angle-down"></i>
                        </div>
                        <input type="text" hidden name="pitch_type_id">

                        <div class="select_search_box">
                            <input type="text" placeholder="Search..." onkeyup="onSearch(this);" />
                        </div>
                    </div>

                    <!-- checkbox -->
                    <div class="text_field_container">
                        <fieldset class="checkbox_group">
                            <legend class="checkbox_group_title">Features</legend>
                            <div class="checkbox">
                                <label class="checkbox_wrapper">
                                    <input type="checkbox" class="checkbox_input" name="allow_campfires" />
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
                                    <input type="checkbox" class="checkbox_input" name="allow_pets" />
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
                                    <input type="checkbox" class="checkbox_input" name="available_wifi" />
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
                                    <input type="checkbox" class="checkbox_input" name="has_cooking_equipments" />
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
                                    <input type="checkbox" class="checkbox_input" name="available_electricity" />
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
                            <legend class="checkbox_group_title" style="opacity: 0;">Choose your favorites</legend>
                            <div class="checkbox">
                                <label class="checkbox_wrapper">
                                    <input type="checkbox" class="checkbox_input" name="can_bike" />
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
                                    <input type="checkbox" class="checkbox_input" name="can_fish" />
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
                                    <input type="checkbox" class="checkbox_input" name="can_sail" />
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
                                    <input type="checkbox" class="checkbox_input" name="can_hike" />
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
                                    <input type="checkbox" class="checkbox_input" name="can_ride_horse" />
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