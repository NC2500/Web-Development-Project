<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Miaw Fong LIM" />
    <title>Miaw Fong Lim</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>

<div id="top"></div>

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


<section class="profile-container">

    <h1>Miaw Fong LIM</h1>
    <p class="student-number">Student Number: 104406013</p>
    <p class="course">Course: Bachelor of Computer Science</p>
    
    <div class="center-image">
        <img src="images/aboutus3.png" alt="Lim's Image">
    </div>
    
    <table class="info-table">
        <tr>
            <th>Category</th>
            <th>Details</th>
        </tr>
        <tr>
            <td>Gender</td>
            <td>Female</td>
        </tr>
        <tr>
            <td>Nationality</td>
            <td>Malaysian</td>
        </tr>
        <tr>
            <td>Hometown</td>
            <td>Kuching, Sarawak</td>
        </tr>
        <tr>
            <td>Great Achievement</td>
            <td>One of my greatest achievements in life was successfully completing my Diploma in International Business and then pursuing a Degree in Computer Science. Transitioning from business to technology was challenging, as I had to learn new concepts and develop technical skills from scratch. However, through dedication, continuous learning, and perseverance, I adapted to the new field and excelled in my studies.</td>
        </tr>
        <tr>
            <td>Favorites Book</td>
            <td>
                Game of Throne<br><img src="images/ClashOfKings.png" alt="Book Cover">
            </td>
        </tr>

        <tr>
            <td>Favorites Music</td>
            <td class="videos">
                <strong>Hideyoshi - Majinahanashi</strong><br>
                <iframe src="https://www.youtube.com/embed/9a3sPzbG68I" allowfullscreen></iframe>

                <br><strong>Awich, 唾奇, OZworld, CHICO CARLITO - RASEN in OKINAWA (Prod. Diego Ave)</strong><br>
                <iframe src="https://www.youtube.com/embed/p6vM08MGoQ8" allowfullscreen></iframe>

                <br><strong>Creeds - Push Up </strong><br>
                <iframe src="https://www.youtube.com/embed/BGrBuUF4UqA" allowfullscreen></iframe>

            </td>
        </tr>

        <tr>
            <td>Favourite Movies</td>
            <td>The Green Mile<br><img src="images/TheGreenMile.png" alt="Movie Poster"></td>
        </tr>
    </table>
</section>


<div class="profile-email">
    <a href="mailto:104406013@students.swinburne.edu.my">
      <img src="images/icons8-email-32.png" alt="Email Icon">
    </a>
  </div>


    <footer>
        <div class="footer-container">
            <div class="footer-links">
                <span><a href="aboutus.php">About Us</a></span>
                <p><a href="aboutus1.php">Norman Zhi Wen Chung </a></p>
                <p><a href="aboutus2.php">Tammy Ru Xiu Tay</a></p>
                <p><a href="aboutus3.php">Miaw Fong Lim</a></p>
                <p><a href="aboutus4.php">Bahrose Hassan Babar</a></p>

            </div>
        
            <div class="footer-links">
                <p><a href="acknowledgement.php">Acknowledgement</a></p>
                <p><a href="https://youtu.be/_me0CROE8AU/">Presentation Video</a></p>
                <p><a href="enhancement1.php">Enhancement</a></p>
            </div>

            <div class="social-media">
                <span>Follow Us</span>
                <div class="social-icons">
                    <a href="https://www.instagram.com/brewngo.coffee/"><img src="images/icons8-instagram-32.png" alt="Instagram"></a>
                    <a href="https://web.facebook.com/people/Brew-Go-Coffee/61554234958482/"><img src="images/icons8-facebook-32.png" alt="Facebook"></a>
                    <a href="mailto:brewngo.coffee@gmail.com"><img src="images/icons8-email-32.png" alt="Email"></a>
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