<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="author" content="Miaw Fong LIM" />
  <title>Meet Our Team - Brew & Go</title>
  <link rel="stylesheet" href="styles/style.css" />
</head>

<body class="aboutus">

  <div id="top"></div>

 <!-- Navigation -->
 <header>
   
   <nav class="navbar">
    <input type="checkbox" id="menu-toggle" class="menu-toggle">
    <label for="menu-toggle" class="hamburger">&#9776;</label>
    <div class="mobile-dropdown-menu">
      <ul>
        <li><a href="menu.php">MENU</a></li>
        <li><a href="activities.php">ACTIVITIES</a></li>
        <li><a href="joinus.php">JOIN US</a></li>
        <li><a href="enquiry.php">ENQUIRY</a></li>
        <li><a href="membership.php">MEMBERSHIP</a></li>
        <li><a href="login.php">LOGIN</a></li>
      </ul>
    </div>
    <div class="logo">
        <a href="main.php"><img src="images/Logo_1.png" alt="Logo"></a>
    </div>
    
    <ul class="nav-links">
        <li class="dropdown">
            <a href="menu.php" class="dropbtn">MENU ▼</a>
            <ul class="dropdown-menu">
                <li><a href="menu3.php">Basic Brew</a></li>
                <li><a href="menu1.php">Artisan Brew</a></li>
                <li><a href="menu2.php">Non-Coffee</a></li>
                <li><a href="menu4.php">Hot Beverages</a></li>
    </ul>
    </li>
        
        <li class="dropdown">
            <a href="activities.php" class="dropbtn">ACTIVITIES ▼</a>
            <ul class="dropdown-menu">
                <li><a href="coming_soon.php">Coming Soon</a></li>
                <li><a href="current.php">Current</a></li>
                <li><a href="past_activities.php">Past Activities</a></li>
            </ul>
        </li>
        
        <li><a href="joinus.php">JOIN US</a></li>
        <li><a href="enquiry.php">ENQUIRY</a></li>
        <li><a href="membership.php">MEMBERSHIP</a></li>
        <li><a href="login.php">LOGIN</a></li>
    </ul>
  </nav>

</header>

  <section class="team-section">
  <h1>Meet Our Team</h1>
  <div class="team-grid">
    <a href="aboutus1.php" class="team-card">
      <div class="circle">
        <img src="images/aboutus1.png" alt="Norman">
      </div>
      <h3>Norman Zhi Wen<br>CHUNG</h3>
    </a>

    <a href="aboutus2.php" class="team-card">
      <div class="circle">
        <img src="images/aboutus2.png" alt="Tammy">
      </div>
      <h3>Tammy Ru Xiu<br>TAY</h3>
    </a>

    <a href="aboutus3.php" class="team-card">
      <div class="circle">
        <img src="images/aboutus3.png" alt="Miaw">
      </div>
      <h3>Miaw Fong<br>LIM</h3>
    </a>

    <a href="aboutus4.php" class="team-card">
      <div class="circle">
        <img src="images/aboutus4.png" alt="Bahrose">
      </div>
      <h3>Bahrose Hassan<br>BABAR</h3>
    </a>
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
