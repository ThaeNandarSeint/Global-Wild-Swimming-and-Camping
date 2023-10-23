<?php
include '../../config.php';
session_start();
$admin_id = $_SESSION['superadmin_id'];

if (empty($admin_id)) {
    header('location:/project/login.php');
} else {
    if (isset($_POST['submit'])) {

        if (empty($_POST['name'])) {
            $message[] = 'Username is required!';
        } else if (empty($_POST['email'])) {
            $message[] = 'Email is required!';
        } else if (empty($_POST['password'])) {
            $message[] = 'Password is required!';
        } else {

            $name = mysqli_real_escape_string($mysqli, $_POST['name']);
            $email = mysqli_real_escape_string($mysqli, $_POST['email']);
            $password = mysqli_real_escape_string($mysqli, $_POST['password']);

            $hashedPassword = md5($password);

            $image_url = date('Ymd_His') . "-" . mt_rand(1000, 9999) . "-no_profile.jpg";

            $insert_admin = mysqli_query($mysqli, "INSERT INTO tbl_admins(name, email, password, avatar) VALUES('$name', '$email', '$hashedPassword', '$image_url')") or die('query failed');

            if ($insert_admin) {
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
    <title>GWSC | ADD NEW ADMIN</title>
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
                <h1>Add New Admin</h1>
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
                        <input type="text" name="name">
                        <span></span>
                        <label>Username</label>
                    </div>
                    <div class="text_field">
                        <input type="text" name="email">
                        <span></span>
                        <label>Email</label>
                    </div>
                    <div class="text_field password_hidden_container">
                        <div class="fa-solid fa-eye-slash" id="password_hidden_icon" onclick="togglePasswordHiddenIcon()"></div>
                        <input type="password" name="password" id="password_field">
                        <span></span>
                        <label>Password</label>
                    </div>

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