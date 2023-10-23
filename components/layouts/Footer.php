<footer>
    <div class="footer_row">
        <div class="footer_col">
            <img src="/project/assets/images/Logo.jpg" class="footer_logo" alt="">
            <p class="footer-info">
                Escape the ordinary and embrace the extraordinary as you journey into the heart of nature. Our carefully curated camping experiences are designed to ignite your spirit of exploration and leave you with cherished memories that will last a lifetime.
            </p>
        </div>
        <div class="footer_col">
            <div class="footer_header">
                Office
                <div class="footer_underline">
                    <span></span>
                </div>
            </div>
            <p>No 81, Anawmar 2nd Street,</p>
            <p>Tharkayta, Yangon</p>
            <p class="email">gwsc@gmail.com</p>
            <h4>+959 758 764 462</h4>
        </div>
        <div class="footer_col footer_nav">
            <div class="footer_header">
                Links
                <div class="footer_underline">
                    <span></span>
                </div>
            </div>
            <ul>
                <li <?php if (str_contains($_SERVER['REQUEST_URI'], "/project/index.php")) { ?> class="footer_active" <?php } ?>><a href="index.php">Home</a></li>

                <li <?php if (str_contains($_SERVER['REQUEST_URI'], "/project/information.php")) { ?> class="footer_active" <?php } ?>><a href="information.php">Information</a></li>

                <li <?php if (str_contains($_SERVER['REQUEST_URI'], "/project/pitch_types_and_availability.php")) { ?> class="footer_active" <?php } ?>><a href="pitch_types_&_availability.php">Pitch Types & Availablitiy</a></li>

                <li <?php if (str_contains($_SERVER['REQUEST_URI'], "/project/reviews.php")) { ?> class="footer_active" <?php } ?>><a href="reviews.php">Reviews</a></li>

                <li <?php if (str_contains($_SERVER['REQUEST_URI'], "/project/features.php")) { ?> class="footer_active" <?php } ?>><a href="features.php">Features</a></li>

                <li <?php if (str_contains($_SERVER['REQUEST_URI'], "/project/contact.php")) { ?> class="footer_active" <?php } ?>><a href="contact.php">Contact</a></li>

                <li <?php if (str_contains($_SERVER['REQUEST_URI'], "/project/local_attractions.php")) { ?> class="footer_active" <?php } ?>><a href="local_attractions.php">Local Attractions</a></li>
            </ul>
        </div>
        <div class="footer_col footer_form">
            <div class="footer_header">
                Newsletter
                <div class="footer_underline">
                    <span></span>
                </div>
            </div>
            <form action="#">
                <i class="fa-regular fa-envelope footer_subscribe_icon"></i>
                <input type="email" placeholder="Enter your email..." required>
                <button type="submit">
                    <i class="fa-solid fa-arrow-right footer_subscribe_icon"></i>
                </button>
            </form>
            <div class="footer_social_icons">
                <i class="fa-brands fa-facebook-f"></i>
                <i class="fa-brands fa-twitter"></i>
                <i class="fa-brands fa-whatsapp"></i>
                <i class="fa-brands fa-pinterest"></i>
                <i class="fa-brands fa-youtube"></i>
            </div>
        </div>
    </div>
    <hr>
    <p class="footer_copyright">GWSC 2023 - All Right Reserved</p>
</footer>