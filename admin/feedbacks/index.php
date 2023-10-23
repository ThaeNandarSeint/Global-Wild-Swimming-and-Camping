<?php
include '../../config.php';
session_start();
$admin_id = $_SESSION['admin_id'];

if (empty($admin_id)) {
    header('location:/project/login.php');
} else {
    $select = mysqli_query($mysqli, "SELECT * FROM tbl_feedbacks f JOIN tbl_customers c ON f.customer_id = c.id");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWSC | CUSTOMER FEEDBACKS</title>
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
                <h1>Customer Feedbacks</h1>
            </div>
            <?php
            if (isset($message)) {
                foreach ($messages as $message) {
                    echo "<div class='message_container'>
                    <b>{$message}</b>
                    <i class='fa-solid fa-circle-xmark' id='message_container-close' onclick='closeErrorMsg()'></i>
                </div>";
                }
            }
            ?>
            <div class="main_content">
                <table class="content_table" style="margin-top: 1rem;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($select)) { ?>
                            <tr>
                                <td>
                                    <?php echo $row['id']; ?>
                                </td>
                                <td>
                                    <?php echo $row['name']; ?>
                                </td>
                                <td>
                                    <?php echo $row['email']; ?>
                                </td>
                                <td>
                                    <?php echo $row['message']; ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>