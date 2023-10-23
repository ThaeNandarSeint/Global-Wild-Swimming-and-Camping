<?php
include '../../config.php';
session_start();
$admin_id = $_SESSION['admin_id'];

if (empty($admin_id)) {
    header('location:/project/login.php');
} else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $get_pitch_type = mysqli_query($mysqli, "SELECT * FROM tbl_pitch_types WHERE id = $id");
        $pitch_type = mysqli_fetch_assoc($get_pitch_type);

        $get_pitch_type_images = mysqli_query($mysqli, "SELECT * FROM tbl_pitch_type_images WHERE pitch_type_id = $id");

        if (empty($_POST['title'])) {
            $message[] = 'Title is required!';
        } else if (empty($_POST['description'])) {
            $message[] = 'Description is required!';
        } else {

            $title = mysqli_real_escape_string($mysqli, $_POST['title']);
            $description = mysqli_real_escape_string($mysqli, $_POST['description']);

            $update_pitch_type = mysqli_query($mysqli, "UPDATE tbl_pitch_types SET title='$title', description='$description', publish_by=1 WHERE id = $id") or die('query failed');

            if ($update_pitch_type) {
                $get_pitch_type_url = mysqli_query($mysqli, "SELECT url FROM tbl_pitch_type_images WHERE pitch_type_id = $id");

                mysqli_query($mysqli, "DELETE FROM tbl_pitch_type_images WHERE pitch_type_id = $id") or die('query failed');

                while ($pitch_type_images = mysqli_fetch_assoc($get_pitch_type_url)) {
                    unlink("../pitch_types_images/" . $pitch_type_images['url']);
                }

                for ($i = 0; $i < count($_FILES['images']['tmp_name']); $i++) {
                    $image_path = $_FILES['images']["tmp_name"][$i];

                    $image_name = $_FILES['images']['name'][$i];

                    $image_url = "Pitch_Type_" . $id . "_Img_" . ($i + 1) . ".jpg";

                    move_uploaded_file($image_path, "../../uploads/pitch_types/" . $image_url);

                    mysqli_query($mysqli, "INSERT INTO `tbl_pitch_type_images`(url, name, pitch_type_id) VALUES('$image_url', '$image_name', $id)") or die('query failed');
                }

                $message[] = 'Successfully updated!';
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
    <title>GWSC | EDIT PITCH TYPE</title>
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
                <h1>Edit Pitch Type</h1>
            </div>
            <div class="form_container">
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="text_field">
                        <input type="text" name="title" value="<?php echo $pitch_type['title']; ?>">
                        <span></span>
                        <label>Title</label>
                    </div>
                    <div class="text_field">
                        <input type="text" name="description" value="<?php echo $pitch_type['description']; ?>">
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