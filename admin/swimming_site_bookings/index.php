<?php
include '../../config.php';
session_start();
$admin_id = $_SESSION['admin_id'];

if (empty($admin_id)) {
    header('location:/project/login.php');
} else {
    $select = mysqli_query($mysqli, "SELECT * FROM tbl_swimming_site_bookings b LEFT JOIN tbl_swimming_sites s ON b.swimming_site_id = s.id");

    if (isset($_GET['approve'])) {
        $id = $_GET['approve'];
        mysqli_query($mysqli, "UPDATE tbl_swimming_site_bookings SET status='approved' WHERE id = $id");
        $messages[] = 'Approved!';
        header('location:index.php');
    } else if (isset($_GET['cancel'])) {
        $id = $_GET['cancel'];
        mysqli_query($mysqli, "UPDATE tbl_swimming_site_bookings SET status='canceled' WHERE id = $id");
        $messages[] = 'Canceled!';
        header('location:index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWSC | SWIMMING SITE BOOKINGS</title>
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
                <h1>Swimming Site Bookings</h1>
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
                            <th>Site ID</th>
                            <th>Guest Count</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($select)) { ?>
                            <tr>
                                <td>
                                    <?php echo $row['id']; ?>
                                </td>
                                <td>
                                    <?php echo $row['swimming_site_id']; ?>
                                </td>
                                <td>
                                    <?php echo $row['guest_count']; ?>
                                </td>
                                <td>
                                    <?php echo $row['start_date']; ?>
                                </td>
                                <td>
                                    <?php echo $row['end_date']; ?>
                                </td>
                                <td style="text-transform: capitalize;">
                                    <?php echo $row['status']; ?>
                                </td>
                                <?php if ($row['status'] == 'pending') { ?>
                                    <td class="table_actions">
                                        <a href="?approve=<?php echo $row['id']; ?>">
                                            Approve
                                        </a>
                                        <a href="?cancel=<?php echo $row['id']; ?>">
                                            Cancel
                                        </a>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>