<rss version="2.0">
    <channel>
        <title>Global Wild Swimming Camping</title>
        <description>
            Dive into the world of wild swimming and camping adventures! Immerse yourself in the beauty of natural water bodies and pristine camping spots. Discover the best places to take a refreshing plunge while surrounded by nature's serenity. Stay updated with expert tips on gear, safety, and ideal locations for your aquatic escapades. Subscribe now for a regular dose of inspiration and embark on a journey of unforgettable wild swimming experiences combined with the thrill of camping in the great outdoors!
        </description>
        <?php
        include('./config.php');
        header('Content-Type: text/xml');
        $get_rss_feeds = mysqli_query($mysqli, 'SELECT * FROM tbl_rss_feeds ORDER BY id DESC');
        $count = mysqli_num_rows($get_rss_feeds);
        for ($i = 0; $i < $count; $i++) {
            $row = mysqli_fetch_array($get_rss_feeds);
            echo "<item>";
            echo "<title>" . $row["title"] . "</title>";
            echo "<description>" . $row["description"] . "</description>";
            echo "<url>" . $row["url"] . "</url>";
            echo "</item>";
        }
        ?>
    </channel>
</rss>