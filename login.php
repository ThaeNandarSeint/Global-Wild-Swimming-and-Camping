<?php
include './config.php';
session_start();
function get_ip_address()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip_address = $_SERVER['REMOTE_ADDR'];
    }
    return $ip_address;
}

if (isset($_POST['submit'])) {

    if (empty($_POST['email'])) {
        $message[] = 'Email is required!';
    } else if (empty($_POST['password'])) {
        $message[] = 'Password is required!';
    }

    // reCAPTCHA validation
    else if (!isset($_POST['g-recaptcha-response']) && empty($_POST['g-recaptcha-response'])) {
        $response = array(
            "status" => "alert-danger",
            "message" => "Plese check on the reCAPTCHA box."
        );
    } else {
        // Google secret API
        $secretAPIkey = '6Lfd7KYoAAAAACnGa_1lQp-GjNh6vus9EjD8yM3G';
        // reCAPTCHA response verification
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretAPIkey . '&response=' . $_POST['g-recaptcha-response']);
        // Decode JSON data
        $response = json_decode($verifyResponse);
        if (!$response->success) {
            $message[] = 'Robot verification failed, please try again!';
        } else {
            $email = mysqli_real_escape_string($mysqli, $_POST['email']);
            $password = mysqli_real_escape_string($mysqli, $_POST['password']);

            $hashedPassword = md5($password);

            $select_customer = mysqli_query($mysqli, "SELECT * FROM tbl_customers WHERE email = '$email' AND password = '$hashedPassword'") or die('query failed');

            $select_admin = mysqli_query($mysqli, "SELECT * FROM tbl_admins WHERE email = '$email' AND password = '$hashedPassword' AND is_active = 1") or die('query failed');

            $ip_address = get_ip_address();

            $login_time = time() - 30; //after given attempts user can't login for 10 minutes
            $get_login_logs = mysqli_query($mysqli, "SELECT count(*) AS total_count FROM tbl_login_logs WHERE ip_address='$ip_address' AND login_time>'$login_time'");

            $login_logs = mysqli_fetch_assoc($get_login_logs);
            $login_attempts = $login_logs['total_count'];

            if ($login_attempts == 3) {
                $message[] = "Your account has been blocked. Please try after 10 minutes.";
            } else {
                if (mysqli_num_rows($select_admin) > 0) {
                    $delete_query = mysqli_query($mysqli, "DELETE FROM tbl_login_logs where ip_address='$ip_address'");

                    $row = mysqli_fetch_assoc($select_admin);
                    if ($row['is_superadmin'] == 1) {
                        $_SESSION['superadmin_id'] = $row['id'];
                    }
                    $_SESSION['admin_id'] = $row['id'];
                    header('location:admin/pitch_types/index.php');
                } else if (mysqli_num_rows($select_customer) > 0) {
                    $delete_query = mysqli_query($mysqli, "DELETE FROM tbl_login_logs where ip_address='$ip_address'");
                    $row = mysqli_fetch_assoc($select_customer);
                    $_SESSION['customer_id'] = $row['id'];
                    header('location:index.php');
                } else {
                    $login_attempts++;
                    $remaining_attempts = 3 - $login_attempts;
                    if ($remaining_attempts == 0) {
                        $message[] = "Your account has been blocked. Please try after 10 minutes.";
                    } else {
                        $message[] = "$remaining_attempts login attempts remaining.";
                    }
                    $ip_address = get_ip_address();
                    $login_time = time();
                    $insert_query = mysqli_query($mysqli, "INSERT INTO tbl_login_logs set ip_address='$ip_address', login_time='$login_time'");

                    $message[] = 'Incorrect email or password!';
                    $message[] = 'Or this user may be inactive!';
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
    <title>GWSC | LOGIN</title>
    <link rel="stylesheet" href="./assets/css/index.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://kit.fontawesome.com/46933ee6ba.js" crossorigin="anonymous" defer></script>
    <script src="./assets/js/index.js" defer></script>
</head>

<body>
    <div class="auth_container">
        <h1>Login</h1>
        <form method="post" enctype="multipart/form-data">
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
            <div class="text_field">
                <input type="email" name="email">
                <span></span>
                <label>Email</label>
            </div>
            <div class="text_field password_hidden_container">
                <div class="fa-solid fa-eye-slash" id="password_hidden_icon" onclick="togglePasswordHiddenIcon()"></div>
                <input type="password" name="password" id="password_field">
                <span></span>
                <label>Password</label>
            </div>
            <div class="g-recaptcha" data-sitekey="6Lfd7KYoAAAAACI-pkBoIFIcUSyWl16CqhF3tXqY"></div>
            <input type="submit" value="Login" name="submit" class="submit_btn">
            <div class="auth_link">
                Didn't have an account? <a href="register.php">Register now</a>
            </div>
        </form>
    </div>
</body>

</html>