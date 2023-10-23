<?php
if (isset($_POST['search_pitch'])) {
    $pitch_keyword = mysqli_real_escape_string($mysqli, $_POST['pitch_keyword']);
    header('location:search_result.php' . '?search_pitch=' . $pitch_keyword);
}
if (isset($_POST['search_swimming_site'])) {
    $swimming_site_keyword = mysqli_real_escape_string($mysqli, $_POST['swimming_site_keyword']);
    header('location:search_result.php' . '?search_swimming_site=' . $swimming_site_keyword);
}
?>

<div class="search_bar_container">
    <div class="search_wrap">
        <form action="" method="POST">
            <div class="search_box">
                <input type="text" class="input" placeholder="Search Available Pitches..." name="pitch_keyword">
                <button type="submit" name="search_pitch" class="search_btn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
    <div class="search_wrap">
        <form action="" method="POST">
            <div class="search_box">
                <input type="text" class="input" placeholder="Search Available Swimming Sites..." name="swimming_site_keyword">
                <button type="submit" name="search_swimming_site" class="search_btn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
    <div class="navigate_btn">
        <a href="rss_feed.php">
            View RSS Feed
        </a>
    </div>
</div>