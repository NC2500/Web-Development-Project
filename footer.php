<?php
$newsletter_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['newsletter_email'])) {
    require_once 'connection.php';
    $email = trim($_POST['newsletter_email']);

    // Basic email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $newsletter_message = '<span style="color:#c0392b">Please enter a valid email address.</span>';
    } else {
        // Check if already subscribed
        $stmt = mysqli_prepare($conn, "SELECT id FROM newsletter_subscribers WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $newsletter_message = '<span style="color:#f39c12">You have already subscribed!</span>';
        } else {
            // Insert new subscriber
            $stmt = mysqli_prepare($conn, "INSERT INTO newsletter_subscribers (email) VALUES (?)");
            mysqli_stmt_bind_param($stmt, "s", $email);
            if (mysqli_stmt_execute($stmt)) {
                $newsletter_message = '<span style="color:#27ae60">Thank you for subscribing!</span>';
            } else {
                $newsletter_message = '<span style="color:#c0392b">Subscription failed. Please try again.</span>';
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}
?>


<footer>
    <div class="footer-container">

      <div class="footer-content">
        <div class="footer-links">
            <span><a href="aboutus.php">About Us</a></span>
            <p><a href="aboutus1.php">Norman Zhi Wen Chung </a></p>
            <p><a href="aboutus2.php">Tammy Ru Xiu Tay</a></p>
            <p><a href="aboutus3.php">Miaw Fong Lim</a></p>
            <p><a href="aboutus4.php">Bahrose Hassan Babar</a></p>

        </div>
    
        <div class="footer-links-2">
          <span>&nbsp;</span>
            <p><a href="acknowledgement.php">Acknowledgement</a></p>
            <p><a href="https://youtu.be/_me0CROE8AU/">Presentation Video</a></p>
            <p><a href="enhancement2.php">Enhancement</a></p>
            <p>&nbsp;</p>
        </div>         

        <div class="social-media">
            <span>Follow Us</span>
            <div class="social-icons">
                <a href="https://www.instagram.com/brewngo.coffee/"><img src="images/icons8-instagram-32.png" alt="Instagram"></a>
                <a href="https://web.facebook.com/people/Brew-Go-Coffee/61554234958482/"><img src="images/icons8-facebook-32.png" alt="Facebook"></a>
                <a href="mailto:brewngo.coffee@gmail.com"><img src="images/icons8-email-32.png" alt="Email"></a>
              </div>
        </div>

      </div>   
      
      <div class="footer-subscribe">
        <h3>Subscribe to Our Newsletter</h3>
        <p>Stay updated on new brews, seasonal activities, and exclusive promotions!</p>
        <form action="#footer" method="post" autocomplete="off">
          <input type="email" name="newsletter_email" placeholder="Enter your email" required>
          <button type="submit">Subscribe</button>
          <?php if (!empty($newsletter_message)) echo "<div class='newsletter-message'>{$newsletter_message}</div>"; ?>
        </form>
      </div>


    </div>

    <div class="copyright">
        © 2025 Brew & Go. Coffee. All rights reserved.
    </div>
</footer>