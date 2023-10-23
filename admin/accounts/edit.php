<?php
include '../../config.php';
session_start();
$admin_id = $_SESSION['superadmin_id'];

if (empty($admin_id)) {
    header('location:/project/login.php');
} else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $get_admin = mysqli_query($mysqli, "SELECT * FROM tbl_admins WHERE id = $id");
        $admin = mysqli_fetch_assoc($get_admin);

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

            $update_admin = mysqli_query($mysqli, "UPDATE tbl_admins SET name='$name', email='$email', password='$hashedPassword' WHERE id = $id") or die('query failed');

            if ($update_admin) {
                $message[] = 'Success!';
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
    <title>GWSC | EDIT ADMIN</title>
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
                <h1>Edit Admin</h1>
            </div>
            <div class="form_container">
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="text_field">
                        <input type="text" name="name" value="<?php echo $admin['name']; ?>">
                        <span></span>
                        <label>Username</label>
                    </div>
                    <div class="text_field">
                        <input type="email" name="email" value="<?php echo $admin['email']; ?>">
                        <span></span>
                        <label>Email</label>
                    </div>
                    <div class="text_field password_hidden_container">
                        <div class="fa-solid fa-eye-slash" id="password_hidden_icon" onclick="togglePasswordHiddenIcon()"></div>
                        <input type="password" name="password">
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