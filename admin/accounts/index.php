<?php
include '../../config.php';
session_start();
$admin_id = $_SESSION['admin_id'];

if (empty($admin_id)) {
    header('location:/project/login.php');
} else {
    $super_admin = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM tbl_admins WHERE id = $admin_id"));

    $select = mysqli_query($mysqli, "SELECT * FROM tbl_admins");

    if (isset($_GET['activate'])) {
        $id = $_GET['activate'];
        mysqli_query($mysqli, "UPDATE tbl_admins SET is_active=1 WHERE id = $id");
        $messages[] = 'Activated!';
        header('location:index.php');
    } else if (isset($_GET['deactivate'])) {
        $id = $_GET['deactivate'];
        mysqli_query($mysqli, "UPDATE tbl_admins SET is_active=0 WHERE id = $id");
        $messages[] = 'Deactivated!';
        header('location:index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWSC | ADMINS</title>
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
                <h1>Admins</h1>
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
                <?php if ($super_admin['is_superadmin'] == 1) { ?>
                    <div class="navigate_btn">
                        <a href="add.php">
                            <i class="fa-solid fa-plus"></i>
                            Add New Admin
                        </a>
                    </div>
                <?php } ?>
                <?php if ($super_admin['is_superadmin'] != 1) { ?>
                    <br>
                <?php } ?>
                <table class="content_table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <?php if ($super_admin['is_superadmin'] == 1) { ?>
                                <th>Actions</th>
                            <?php } ?>
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
                                <?php if ($super_admin['is_superadmin'] == 1) { ?>
                                    <td class="table_actions">
                                        <?php if ($row['is_active'] == 0) { ?>
                                            <a href="?activate=<?php echo $row['id']; ?>">
                                                activate
                                            </a>
                                        <?php } else { ?>
                                            <a href="edit.php?id=<?php echo $row['id']; ?>">
                                                edit
                                            </a>
                                            <a href="?deactivate=<?php echo $row['id']; ?>">
                                                deactivate
                                            </a>
                                        <?php } ?>
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