<?php
include './config.php';
session_start();

if (isset($_POST['submit'])) {

    if (empty($_POST['name'])) {
        $message[] = 'Username is required!';
    } else if (empty($_POST['email'])) {
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
            $name = mysqli_real_escape_string($mysqli, $_POST['name']);
            $email = mysqli_real_escape_string($mysqli, $_POST['email']);
            $password = mysqli_real_escape_string($mysqli, $_POST['password']);
            $location = mysqli_real_escape_string($mysqli, $_POST['location']);

            $hashedPassword = md5($password);

            $image_path = $_FILES['avatar']["tmp_name"];
            $image_name = $_FILES['avatar']['name'];

            $existing_customer = mysqli_query($mysqli, "SELECT * FROM tbl_customers WHERE email = '$email'");

            if ($existing_customer->num_rows > 0) {
                $message[] = "Email already exists!";
            } else {
                if ($_FILES['avatar']['tmp_name'] == "") {
                    $image_url = "No_Profile.jpg";
                } else {
                    $image_url = "Customer_" . date('Ymd_His') . "-" . mt_rand(1000, 9999) . ".jpg";
                    move_uploaded_file($image_path, "./uploads/customers/" . $image_url);
                }
                $insert_user = mysqli_query($mysqli, "INSERT INTO tbl_customers(name, email, password, location, avatar_url, avatar_name) VALUES('$name', '$email', '$hashedPassword', '$location', '$image_url', '$image_url')") or die('query failed');

                if ($insert_user) {
                    $select_customer = mysqli_query($mysqli, "SELECT * FROM tbl_customers WHERE email = '$email' AND password = '$hashedPassword'") or die('query failed');

                    $row = mysqli_fetch_assoc($select_customer);
                    $_SESSION['customer_id'] = $row['id'];

                    $message[] = 'Successfully created!';
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
    <title>GWSC | REGISTER</title>
    <link rel="stylesheet" href="./assets/css/index.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://kit.fontawesome.com/46933ee6ba.js" crossorigin="anonymous" defer></script>
    <script src="./assets/js/index.js" defer></script>
</head>

<body>
    <div>
        <div class="auth_container">
            <h1>Register</h1>

            <form method="post" enctype="multipart/form-data">
                <?php
                if (isset($message)) {
                    foreach ($message as $message) {
                        echo "<div class='message_container' style='margin: 0 1rem;''>
                                <b>{$message}</b>
                                <i class='fa-solid fa-circle-xmark' id='message_container-close' onclick='closeErrorMsg()'></i>
                            </div>";
                    }
                }
                ?>
                <div class="avatar_container">
                    <input name="avatar" type="file" id="avatar" hidden onchange="previewAvatar(this);">
                    <label for="avatar" class="avatar_label">
                        <img src="./assets/images/No_Profile.jpg" id="avatar-preview" width=100 height=100 alt="">
                        <div class="avatar_camera_icon">
                            <i class="fa-solid fa-camera"></i>
                        </div>
                    </label>
                </div>
                <div class="text_field">
                    <input type="text" name="name">
                    <span></span>
                    <label>Username</label>
                </div>
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
                <div class="text_field">
                    <input type="text" name="location">
                    <span></span>
                    <label>Location (City)</label>
                </div>
                <div class="g-recaptcha" data-sitekey="6Lfd7KYoAAAAACI-pkBoIFIcUSyWl16CqhF3tXqY"></div>
                <input type="submit" value="Register" name="submit" class="submit_btn">
                <div class="auth_link">
                    Already have an account? <a href="login.php">Login now</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>