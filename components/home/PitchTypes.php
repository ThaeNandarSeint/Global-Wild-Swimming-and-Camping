<?php
$get_pitch_types = mysqli_query($mysqli, "SELECT pt.*, COUNT(p.pitch_type_id) AS pitch_count FROM tbl_pitch_types pt LEFT JOIN tbl_pitches p ON pt.id = p.pitch_type_id GROUP BY pt.id HAVING pt.is_published = 1;");
?>

<div class="component_wrapper">
    <h1>Find Your Next<span style="color: var(--color-danger);"> Pitch Types</span></h1>
    <div class="card_container">
        <?php while ($pitch_type = mysqli_fetch_assoc($get_pitch_types)) { ?>
            <a href=<?php echo "./pitches/index.php?id=" . $pitch_type['id'] ?> class="card_wrapper pitch_type_card">
                <img src=<?php echo "./uploads/pitch_types/Pitch_Type_" . $pitch_type['id'] . "_Img_1.jpg" ?> alt="">
                <div class="card_body">
                    <h3>
                        <?php echo $pitch_type['title'] ?>
                    </h3>
                    <p><span class="fa-solid fa-campground"></span>
                        <?php echo $pitch_type['pitch_count'] ?> pitches
                    </p>
                </div>
                <i></i>
            </a>
        <?php } ?>
    </div>
</div>