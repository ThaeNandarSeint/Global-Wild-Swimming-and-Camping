<?php
include '../config.php';
if (isset($_GET['id'])) {
    $pitch_type_id = $_GET['id'];
    $get_pitches = mysqli_query($mysqli, "SELECT  p.*, COUNT(r.pitch_id)  AS review_count FROM tbl_pitches p LEFT JOIN tbl_pitch_reviews r ON p.id = r.pitch_id GROUP BY p.id HAVING p.pitch_type_id = $pitch_type_id ORDER BY view_count DESC");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GWSC | PITCH DETAIL</title>
    <link rel="stylesheet" href="../assets/css/index.css">
    <script src="./assets/js/index.js" defer></script>
    <script src="https://kit.fontawesome.com/46933ee6ba.js" crossorigin="anonymous" defer></script>
</head>

<body>

    <?php include('../components/layouts/Navbar.php') ?>

    <section class="body-70 component_wrapper">
        <h1>Find Your Next<span style="color: var(--color-danger);"> Pitches</span></h1>
        <div class="card_container">
            <?php while ($pitch = mysqli_fetch_assoc($get_pitches)) { ?>
                <a href=<?php echo "./view.php?id=" . $pitch['id'] ?> class="card_wrapper">
                    <img src=<?php echo "../uploads/pitches/Pitch_" . $pitch['id'] . "_Img_1.jpg" ?> alt="">
                    <div class="card_body">
                        <h3>
                            <?php echo $pitch['title'] ?>
                        </h3>
                        <p>
                            Price per night -
                            $
                            <?php echo $pitch['price'] ?>
                        </p>
                        <div class="count_container">
                            <p><span class="fa-solid fa-eye"></span>
                                <?php echo $pitch['view_count'] ?> views
                            </p>
                            <p><span class="fa-solid fa-star-half-stroke"></span>
                                <?php echo $pitch['review_count'] ?> reviews
                            </p>
                        </div>
                    </div>
                    <i></i>
                </a>
            <?php } ?>
        </div>
    </section>

    <?php include('../components/layouts/Footer.php') ?>
</body>

</html>