<?php
include './config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GWSC | PITCH TYPES and AVAILABILITY</title>
    <link rel="stylesheet" href="./assets/css/index.css">
    <script src="./assets/js/index.js" defer></script>
    <script src="https://kit.fontawesome.com/46933ee6ba.js" crossorigin="anonymous" defer></script>
</head>

<body>

    <?php include('./components/layouts/Navbar.php') ?>

    <section class="body-70">
        <?php include('./components/home/Searchbar.php') ?>
        <?php include('./components/home/PitchTypes.php') ?>
        <?php include('./components/home/AvailablePitches.php') ?>
        <?php include('./components/home/AvailableSwimmingSites.php') ?>
    </section>

    <?php include('./components/layouts/Footer.php') ?>
</body>

</html>