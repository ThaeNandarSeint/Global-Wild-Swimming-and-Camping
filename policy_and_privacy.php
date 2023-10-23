<?php
include './config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GWSC | POLICY AND PRIVACY</title>
    <link rel="stylesheet" href="./assets/css/index.css">
    <script src="./assets/js/index.js" defer></script>
</head>

<body>

    <?php include('./components/layouts/Navbar.php') ?>

    <section class="body-70">
        <div class="component_wrapper">
            <h1>Our Policy and <span style="color: var(--color-danger);"> Privacy</span></h1>
            <div class="privacy_wrapper">
                <p>
                    We value your privacy and are committed to protecting your personal information. This Privacy Policy outlines how we collect, use, disclose, and safeguard your information when you visit our website or use our services.
                </p>
                <div>
                    <h3>Information We Collect:</h3>
                    <p>When you make a reservation or sign up for an account, we may collect your name, email address, phone number, and payment details. We collect data about how you use our website, including pages visited, search queries, and device information. With your consent, we may collect and process precise location data to provide location-based services. We may keep a record of communications you have with us, such as emails and customer support inquiries.</p>
                </div>
                <div>
                    <h3>How We Use Your Information:</h3>
                    <p>We use your personal information to process and confirm your camping reservations. Analyzing usage patterns helps us enhance our website's functionality and user-friendliness. We may use your contact information to send booking confirmations, updates, and promotional materials. Your information helps us protect against unauthorized access, maintain data accuracy, and ensure the proper use of information.</p>
                </div>
                <div>
                    <h3>Sharing Your Information:</h3>
                    <p>We may share your information with trusted third-party service providers who assist us in providing and improving our services. We may disclose your information to comply with legal obligations, respond to legal requests, or protect our rights, privacy, safety, or property.</p>
                </div>
                <div>
                    <h3>Cookies and Tracking:</h3>
                    <p>We use cookies and similar technologies to track your activity on our website and improve your experience. You can manage your cookie preferences through your browser settings.</p>
                </div>
                <div>
                    <h3>Others:</h3>
                    <p>We take reasonable measures to protect your information from unauthorized access, disclosure, alteration, and destruction. However, no method of transmission over the internet or electronic storage is entirely secure. Our services are not directed to individuals under the age of 13. We do not knowingly collect personal information from children.</p>
                </div>
                <p class="privacy_linK">
                    We may update this Privacy Policy from time to time. Any changes will be posted on this page, and the revised policy will be effective immediately. If you have any questions or concerns regarding this Privacy Policy, please
                    <a href="contact.php">contact us</a>
                </p>
            </div>
        </div>
    </section>

    <?php include('./components/layouts/Footer.php') ?>
</body>

</html>