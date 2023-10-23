<?php
include '../../config.php';
session_start();
$admin_id = $_SESSION['admin_id'];

if (empty($admin_id)) {
    header('location:/project/login.php');
} else {

    $select = mysqli_query($mysqli, "SELECT * FROM tbl_pitches");

    if (isset($_GET['publish'])) {
        $id = $_GET['publish'];
        mysqli_query($mysqli, "UPDATE tbl_pitches SET is_published=1 WHERE id = $id");
        $messages[] = 'Published!';
        header('location:index.php');
    } else if (isset($_GET['unpublish'])) {
        $id = $_GET['unpublish'];
        mysqli_query($mysqli, "UPDATE tbl_pitches SET is_published=0 WHERE id = $id");
        $messages[] = 'Unpublished!';
        header('location:index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWSC | PITCHES</title>
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
                <h1>Pitches</h1>
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
                <div class="navigate_btn">
                    <a href="add.php">
                        <i class="fa-solid fa-plus"></i>
                        Add New Pitch
                    </a>
                </div>
                <table class="content_table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Maximum Guest Count</th>
                            <th>Price</th>
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
                                    <?php echo $row['title']; ?>
                                </td>
                                <td>
                                    <?php echo $row['maximum_guest_count']; ?>
                                </td>
                                <td>
                                    <?php echo $row['price']; ?>
                                </td>
                                <td class="table_actions">
                                    <a href="view.php?id=<?php echo $row['id']; ?>">
                                        view
                                    </a>
                                    <a href="edit.php?id=<?php echo $row['id']; ?>">
                                        edit
                                    </a>
                                    <?php if ($row['is_published'] == 0) { ?>
                                        <a href="?publish=<?php echo $row['id']; ?>">
                                            publish
                                        </a>
                                    <?php } else { ?>
                                        <a href="?unpublish=<?php echo $row['id']; ?>">
                                            unpublish
                                        </a>
                                    <?php } ?>
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