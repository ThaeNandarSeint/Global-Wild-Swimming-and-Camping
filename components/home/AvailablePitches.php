<?php
$get_pitches = mysqli_query($mysqli, "SELECT p.*, COUNT(r.pitch_id) AS review_count FROM tbl_pitches p LEFT JOIN tbl_pitch_reviews r ON p.id = r.pitch_id GROUP BY p.id ORDER BY p.number_of_sites DESC");
?>

<div class="component_wrapper">
    <h1><span style="color: var(--color-danger);">Available</span> Pitches</h1>
    <div class="card_container">
        <?php while ($pitch = mysqli_fetch_assoc($get_pitches)) { ?>
            <a href=<?php echo "./pitches/view.php?id=" . $pitch['id'] ?> class="card_wrapper">
                <img src=<?php echo "./uploads/pitches/Pitch_" . $pitch['id'] . "_Img_1.jpg" ?> alt="">
                <div class="card_body">
                    <h3>
                        <?php echo $pitch['title'] ?>
                    </h3>
                    <p>Price - $
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
</div>