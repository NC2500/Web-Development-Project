<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="author" content="Miaw Fong LIM" />
  <title>Tammy Ru Xiu TAY - Profile</title>
  <link rel="stylesheet" href="styles/style.css" />
</head>
<body>

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


<!-- Profile Section -->
<section class="profile-container">
  <h1>Tammy Ru Xiu TAY</h1>
  <p class="student-number">Student Number: 104405861</p>
  <p class="course">Course: Bachelor of Computer Science</p>

  <div class="center-image">
    <img src="images/aboutus2.png" alt="Tammy's Image">
  </div>

  <table class="info-table">
    <tr><th>Category</th><th>Details</th></tr>
    <tr><td>Gender</td><td>Female</td></tr>
    <tr><td>Nationalities</td><td>Malaysia</td></tr>
    <tr><td>Hometown</td><td>Kuching, Sarawak</td></tr>
    <tr><td>Greatest Achievement</td>
      <td>
        Successfully completing my Diploma in International Business – balancing academic and personal responsibilities with resilience and dedication.
      </td>
    </tr>
    <tr>
      <td>Favorite Book</td>
      <td>
        The Temple of Earth and Me<br>
        <img src="images/The Temple of Earth and Me.png" alt="Book Cover">
      </td>
    </tr>
    <tr>
      <td>Favorite Music</td>
      <td class="videos">

        <strong>盧廣仲 Crowd Lu 【刻在我心底的名字 Your Name Engraved Herein】 Official Music Video （刻在你心底的名字電影主題曲</strong><br>
        <iframe src="https://www.youtube.com/embed/m78lJuzftcc" allowfullscreen></iframe>

        <br><strong>《My Only 麥恩莉》【方大同回到未來音樂會台北Legacy】20130127</strong><br>
        <iframe src="https://www.youtube.com/embed/0cu4KiSOvCU" allowfullscreen></iframe>

        <br><strong>Lauv - Paris in the Rain (Lyrics)</strong><br>
        <iframe src="https://www.youtube.com/embed/q7xXQUJrLq0" allowfullscreen></iframe>
      </td>
    </tr> 
    <tr>
      <td>Favorite Movie</td>
      <td>
        Howl's Moving Castle<br>
        <img src="images/Howl's Moving Castle.png" alt="Movie Poster">
      </td>
    </tr>
  </table>
</section>

<div class="profile-email">
  <a href="mailto:104405861@students.swinburne.edu.my">
    <img src="images/icons8-email-32.png" alt="Email Icon">
  </a>
</div>

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

</body>
</html>
