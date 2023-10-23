<?php
include './config.php';
$get_pitch_reviews = mysqli_query($mysqli, "SELECT r.*, c.name, c.avatar_url, p.id FROM tbl_pitches p RIGHT JOIN tbl_pitch_reviews r ON r.pitch_id = p.id LEFT JOIN tbl_customers c ON c.id = r.publish_by ORDER BY r.rating DESC;");

$get_swimming_site_reviews = mysqli_query($mysqli, "SELECT r.*, c.name, c.avatar_url, s.id FROM tbl_swimming_sites s RIGHT JOIN tbl_swimming_site_reviews r ON r.swimming_site_id = s.id LEFT JOIN tbl_customers c ON c.id = r.publish_by ORDER BY r.rating DESC;");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GWSC | REVIEWS</title>
    <link rel="stylesheet" href="./assets/css/index.css">
    <script src="./assets/js/index.js" defer></script>
    <script src="https://kit.fontawesome.com/46933ee6ba.js" crossorigin="anonymous" defer></script>
</head>

<body>

    <?php include('./components/layouts/Navbar.php') ?>

    <section class="body-70">
        <div class="component_wrapper">
            <h1>Reviews and Ratings<span style="color: var(--color-danger);"> For Pitches</span></h1>
            <div class="reviews_container">
                <i id="left" class="fa-solid fa-angle-left"></i>
                <ul class="reviews_carousel">
                    <?php while ($pitch_reviews = mysqli_fetch_assoc($get_pitch_reviews)) { ?>
                        <li class="reviews_card">
                            <div class="img"><img src=<?php echo "./uploads/customers/" . $pitch_reviews['avatar_url'] ?> alt="img" draggable="false"></div>
                            <h2>
                                <?php echo $pitch_reviews['name'] ?>
                            </h2>
                            <span><?php echo explode(" ", $pitch_reviews['created_at'])[0] ?></span>
                            <p>
                                <?php echo $pitch_reviews['description'] ?>
                            </p>
                        </li>
                    <?php } ?>
                </ul>
                <i id="right" class="fa-solid fa-angle-right"></i>
            </div>
        </div>
        <div class="component_wrapper">
            <h1>Reviews and Ratings<span style="color: var(--color-danger);"> For Swimming Sites</span></h1>
            <div class="reviews_container">
                <i id="left" class="fa-solid fa-angle-left"></i>
                <ul class="reviews_carousel">
                    <?php while ($swimming_site_reviews = mysqli_fetch_assoc($get_swimming_site_reviews)) { ?>
                        <li class="reviews_card">
                            <div class="img"><img src=<?php echo "./uploads/customers/" . $swimming_site_reviews['avatar_url'] ?> alt="img" draggable="false"></div>
                            <h2>
                                <?php echo $swimming_site_reviews['name'] ?>
                            </h2>
                            <span><?php echo explode(" ", $swimming_site_reviews['created_at'])[0] ?></span>
                            <p>
                                <?php echo $swimming_site_reviews['description'] ?>
                            </p>
                        </li>
                    <?php } ?>
                </ul>
                <i id="right" class="fa-solid fa-angle-right"></i>
            </div>
        </div>
        <?php include('./components/home/PopularPitches.php') ?>
        <?php include('./components/home/PopularSwimmingSites.php') ?>
    </section>

    <?php include('./components/layouts/Footer.php') ?>
</body>

</html>