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
            <li><a href="menu.html">MENU</a></li>
            <li><a href="activities.html">ACTIVITIES</a></li>
            <li><a href="joinus.html">JOIN US</a></li>
            <li><a href="enquiry.html">ENQUIRY</a></li>
            <li><a href="membership.html">MEMBERSHIP</a></li>
            <li><a href="login.html">LOGIN</a></li>
          </ul>
        </div>
          <div class="logo">
              <a href="main.html"><img src="images/Logo_1.png" alt="Logo"></a>
          </div>
          
          <ul class="nav-links">
              <li class="dropdown">
                  <a href="menu.html" class="dropbtn">MENU ▼</a>
                  <ul class="dropdown-menu">
                      <li><a href="menu3.html">Basic Brew</a></li>
                      <li><a href="menu1.html">Artisan Brew</a></li>
                      <li><a href="menu2.html">Non-Coffee</a></li>
                      <li><a href="menu4.html">Hot Beverages</a></li>
          </ul>
          </li>
              
              <li class="dropdown">
                  <a href="activities.html" class="dropbtn">ACTIVITIES ▼</a>
                  <ul class="dropdown-menu">
                      <li><a href="coming_soon.html">Coming Soon</a></li>
                      <li><a href="current.html">Current</a></li>
                      <li><a href="past_activities.html">Past Activities</a></li>
                  </ul>
              </li>
              
              <li><a href="joinus.html">JOIN US</a></li>
              <li><a href="enquiry.html">ENQUIRY</a></li>
              <li><a href="membership.html">MEMBERSHIP</a></li>
              <li><a href="login.html">LOGIN</a></li>
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
                    Not a member yet? <a href="membership.html">Sign up for membership</a>
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
                <span><a href="aboutus.html">About Us</a></span>
                <p><a href="aboutus1.html">Norman Zhi Wen Chung </a></p>
                <p><a href="aboutus2.html">Tammy Ru Xiu Tay</a></p>
                <p><a href="aboutus3.html">Miaw Fong Lim</a></p>
                <p><a href="aboutus4.html">Bahrose Hassan Babar</a></p>

            </div>
        
            <div class="footer-links-2">
              <span>&nbsp;</span>
                <p><a href="acknowledgement.html">Acknowledgement</a></p>
                <p><a href="https://youtu.be/_me0CROE8AU/">Presentation Video</a></p>
                <p><a href="enhancement1.html">Enhancement</a></p>
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
