<?php
include './config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GWSC | HOME</title>
    <link rel="stylesheet" href="./assets/css/index.css">
    <script src="./assets/js/index.js" defer></script>
    <script src="https://kit.fontawesome.com/46933ee6ba.js" crossorigin="anonymous" defer></script>
</head>

<body>

    <?php include('./components/layouts/Navbar.php') ?>

    <section class="body-70">
        <?php include('./components/home/Searchbar.php') ?>

        <div class="body-wrapper home_carousel">
            <figure>
                <img src="./assets/images/Carousel_2.jpg" alt="">
                <img src="./assets/images/Carousel_3.jpg" alt="">
                <img src="./assets/images/Carousel_4.jpg" alt="">
                <img src="./assets/images/Carousel_1.jpg" alt="">
                <img src="./assets/images/Carousel_2.jpg" alt="">
            </figure>
        </div>

        <?php include('./components/home/PitchTypes.php') ?>

        <?php include('./components/home/Banner1.php') ?>

        <?php include('./components/home/PopularPitches.php') ?>

        <?php include('./components/home/Banner2.php') ?>

        <?php include('./components/home/PopularSwimmingSites.php') ?>

        <?php include('./components/home/Reviews.php') ?>

        <?php include('./components/home/OutdoorGuide.php') ?>

        <?php include('./components/home/MemorySlider.php') ?>
    </section>

    <?php include('./components/layouts/Footer.php') ?>
</body>

</html>