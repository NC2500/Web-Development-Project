<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="author" content="Norman Chung" />
  <title>Application Confirmation - Brew & Go</title>
  <link rel="stylesheet" href="styles/style.css" />
</head>

<body>

  <div id="top"></div>

<!-- Navigation Bar -->
<header>
  <nav class="navbar">
    <div class="logo">
        <a href="main.php"><img src="images/Logo_1.png" alt="Logo"></a>
    </div>
    <ul class="nav-links">
        <li><a href="menu.php">MENU</a></li>
        <li><a href="activities.php">ACTIVITIES</a></li>
        <li><a href="joinus.php">JOIN US</a></li>
        <li><a href="enquiry.php">ENQUIRY</a></li>
        <li><a href="membership.php">MEMBERSHIP</a></li>
        <li><a href="login.php">LOGIN</a></li>
    </ul>
  </nav>
</header>

<!-- Confirmation Section -->
<section class="joinus-hero">
    <div class="joinus-overlay">
      <div class="joinus-container">
        <section class="joinus-section">
          <h2 class="section-title">Application Confirmation</h2>
          <p>Thank you for applying! Below are the details you submitted:</p>
          <div class="confirmation-details">
            <ul class="requirement-list">
              <li><span>First Name:</span> <?php echo htmlspecialchars($_POST['first_name']); ?></li>
              <li><span>Last Name:</span> <?php echo htmlspecialchars($_POST['last_name']); ?></li>
              <li><span>Email:</span> <?php echo htmlspecialchars($_POST['email']); ?></li>
              <li><span>Phone:</span> <?php echo htmlspecialchars($_POST['phone']); ?></li>
              <li><span>Street Address:</span> <?php echo htmlspecialchars($_POST['street']); ?></li>
              <li><span>City/Town:</span> <?php echo htmlspecialchars($_POST['city']); ?></li>
              <li><span>State:</span> <?php echo htmlspecialchars($_POST['state']); ?></li>
              <li><span>Postcode:</span> <?php echo htmlspecialchars($_POST['postcode']); ?></li>
              <li><span>Preferred Shift:</span> <?php echo htmlspecialchars($_POST['shift']); ?></li>
            </ul>
          </div>
          <p>If any of the details are incorrect, please <a href="joinus.php">go back</a> and resubmit the form.</p>
        </section>
      </div>
    </div>
</section>

<!-- Footer -->
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
          <p><a href="enhancement1.php">Enhancement</a></p>
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
      <form action="#" method="post">
        <input type="email" placeholder="Enter your email" required>
        <button type="submit">Subscribe</button>
      </form>
    </div>
  </div>
  <div class="copyright">
      © 2025 Brew & Go. Coffee. All rights reserved.
  </div>
</footer>

<a href="#top" class="back-to-top">
  <span>↑</span>
</a>

</body>
</html>