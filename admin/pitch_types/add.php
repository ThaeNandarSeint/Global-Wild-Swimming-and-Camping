<?php
include '../../config.php';
session_start();
$admin_id = $_SESSION['admin_id'];

if (empty($admin_id)) {
    header('location:/project/login.php');
} else {
    if (isset($_POST['submit'])) {

        if (empty($_POST['title'])) {
            $message[] = 'Title is required!';
        } else if (empty($_POST['description'])) {
            $message[] = 'Description is required!';
        } else {

            $title = mysqli_real_escape_string($mysqli, $_POST['title']);
            $description = mysqli_real_escape_string($mysqli, $_POST['description']);

            $insert_pitch_type = mysqli_query($mysqli, "INSERT INTO `tbl_pitch_types`(title, description, publish_by) VALUES('$title', '$description', $admin_id)") or die('query failed');

            if ($insert_pitch_type) {
                $pitch_type_id = mysqli_insert_id($mysqli);

                for ($i = 0; $i < count($_FILES['images']['tmp_name']); $i++) {
                    $image_path = $_FILES['images']["tmp_name"][$i];

                    $image_name = $_FILES['images']['name'][$i];

                    $image_url = "Pitch_Type_" . $pitch_type_id . "_Img_" . ($i + 1) . ".jpg";

                    move_uploaded_file($image_path, "../../uploads/pitch_types/" . $image_url);

                    $insert_pitch_type_images = mysqli_query($mysqli, "INSERT INTO `tbl_pitch_type_images`(url, name, pitch_type_id) VALUES('$image_url', '$image_name', '$pitch_type_id')") or die('query failed');
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
    <title>GWSC | ADD NEW PITCH TYPE</title>
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
                <h1>Add New Pitch Type</h1>
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
                    <div class="text_field">
                        <input type="text" name="title">
                        <span></span>
                        <label>Title</label>
                    </div>
                    <div class="text_field">
                        <input type="text" name="description">
                        <span></span>
                        <label>Description</label>
                    </div>

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