<?php
include './config.php';
if (isset($_GET['search_pitch'])) {
    $pitch_keyword = $_GET['search_pitch'];
    $search_pitches = mysqli_query($mysqli, "SELECT p.*, COUNT(r.pitch_id) AS review_count FROM tbl_pitches p LEFT JOIN tbl_pitch_reviews r ON p.id = r.pitch_id GROUP BY p.id HAVING title like '%$pitch_keyword%' ORDER BY p.number_of_sites DESC");
}
if (isset($_GET['search_swimming_site'])) {
    $swimming_site_keyword = $_GET['search_swimming_site'];
    $search_swimming_sites = mysqli_query($mysqli, "SELECT s.*, COUNT(r.swimming_site_id) AS review_count FROM tbl_swimming_sites s LEFT JOIN tbl_swimming_site_reviews r ON s.id = r.swimming_site_id GROUP BY s.id HAVING title like '%$swimming_site_keyword%' ORDER BY s.number_of_tents DESC");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GWSC | SEARCH RESULTS</title>
    <link rel="stylesheet" href="./assets/css/index.css">
    <script src="./assets/js/index.js" defer></script>
    <script src="https://kit.fontawesome.com/46933ee6ba.js" crossorigin="anonymous" defer></script>
</head>

<body>
    <!-- navbar -->
    <?php include('./components/layouts/Navbar.php') ?>
    <!-- body -->
    <section class="body-70">
        <?php if (isset($pitch_keyword)) { ?>
            <div class="component_wrapper">
                <h1>Search Result: <span style="color: var(--color-danger);"> Pitches</span></h1>
                <div class="card_container">
                    <?php if (mysqli_num_rows($search_pitches) != 0) { ?>
                        <?php while ($pitch = mysqli_fetch_assoc($search_pitches)) { ?>

                            <a href=<?php echo "./pitches/view.php?id=" . $pitch['id'] ?> class="card_wrapper">
                                <img src=<?php echo "./uploads/pitches/Pitch_" . $pitch['id'] . "_Img_1.jpg" ?> alt="">
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
                    <?php } else { ?>
                        <h1 class="no_search_result">No Result Found!</h1>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <?php if (isset($swimming_site_keyword)) { ?>
            <div class="component_wrapper">
                <h1>Search Result: <span style="color: var(--color-danger);"> Swimming Sites</span></h1>
                <div class="card_container">
                    <?php if (mysqli_num_rows($search_swimming_sites) != 0) { ?>
                        <?php while ($swimming_site = mysqli_fetch_assoc($search_swimming_sites)) { ?>
                            <a href=<?php echo "./swimming_sites/view.php?id=" . $swimming_site['id'] ?> class="card_wrapper">
                                <img src=<?php echo "./uploads/swimming_sites/Swimming_Site_" . $swimming_site['id'] . "_Img_1.jpg" ?> alt="">
                                <div class="card_body">
                                    <h3>
                                        <?php echo $swimming_site['title'] ?>
                                    </h3>
                                    <p>
                                        Price per night -
                                        $
                                        <?php echo $swimming_site['price'] ?>
                                    </p>
                                    <div class="count_container">
                                        <p><span class="fa-solid fa-eye"></span>
                                            <?php echo $swimming_site['view_count'] ?> views
                                        </p>
                                        <p><span class="fa-solid fa-star-half-stroke"></span>
                                            <?php echo $swimming_site['review_count'] ?> reviews
                                        </p>
                                    </div>
                                </div>
                                <i></i>
                            </a>
                        <?php } ?>
                    <?php } else { ?>
                        <h1 class="no_search_result">No Result Found!</h1>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </section>
    <!-- footer -->
    <?php include('./components/layouts/Footer.php') ?>
</body>

</html>