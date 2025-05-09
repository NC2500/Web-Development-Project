<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="author" content="Miaw Fong LIM" />
  <title>Login - Brew & Go</title>
  <link rel="stylesheet" href="styles/style.css" />
</head>

<body class="login-page">
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

      
      <section class="login-wrapper">
        <div class="login-outer">
          <div class="login-inner">
            <h1>Member Login</h1>
            <form class="login-form" action="#" method="post">
              <fieldset>
      
                <label for="login">Login ID:</label>
                <input type="text" id="login" name="login" maxlength="10" pattern="[A-Za-z]+" required>
      
                <label for="password">Password:</label>
                <input type="text" id="password" name="password" maxlength="25" pattern="[A-Za-z]+" required>
      
                <button type="submit">Login</button>
                <button type="reset">Reset</button>

                <p class="forgot-password">
                    <a href="#">Forgot your password?</a>
                </p>
                  
                <p class="register-link">
                    Not a member yet? <a href="membership.php">Sign up for membership</a>
                </p>
                  
              </fieldset>
            </form>
          </div>
        </div>
      </section>
      

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
