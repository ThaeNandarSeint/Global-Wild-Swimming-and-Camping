<?php
$get_swimming_sites = mysqli_query($mysqli, "SELECT s.*, COUNT(r.swimming_site_id) AS review_count FROM tbl_swimming_sites s LEFT JOIN tbl_swimming_site_reviews r ON s.id = r.swimming_site_id GROUP BY s.id ORDER BY view_count DESC");
?>

<div class="component_wrapper">
    <h1><span style="color: var(--color-danger);">Popular</span> Swimming Sites</h1>
    <div class="card_container">
        <?php while ($swimming_site = mysqli_fetch_assoc($get_swimming_sites)) { ?>
            <a href=<?php echo "./swimming_sites/view.php?id=" . $swimming_site['id'] ?> class="card_wrapper popular_card">
                <img src=<?php echo "./uploads/swimming_sites/Swimming_Site_" . $swimming_site['id'] . "_Img_1.jpg" ?> alt="">
                <div class="card_body">
                    <h3>
                        <?php echo $swimming_site['title'] ?>
                    </h3>
                    <p>Price - $
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
    </div>
</div>