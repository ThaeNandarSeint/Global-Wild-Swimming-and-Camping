<?php
$get_pitch_reviews = mysqli_query($mysqli, "SELECT * FROM tbl_pitch_reviews pr JOIN tbl_customers c ON pr.publish_by = c.id");
?>

<div class="component_wrapper">
    <h1>Reviews and <span style="color: var(--color-danger);"> Ratings</span></h1>
    <div class="reviews_container">
        <i id="left" class="fa-solid fa-angle-left"></i>
        <ul class="reviews_carousel">
            <?php while ($pitch_reviews = mysqli_fetch_assoc($get_pitch_reviews)) { ?>
                <li class="reviews_card">
                    <div class="img"><img src=<?php echo "./uploads/customers/" . $pitch_reviews['avatar_url'] ?> alt="img" draggable="false"></div>
                    <h2><?php echo $pitch_reviews['name'] ?></h2>
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