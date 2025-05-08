<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Bahrose Hassan Babar" />
    <title>Brew & Co. Coffee</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

    <div id="top"></div>

    <header>
      <nav class="navbar">
        
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
      </nav>
    </header>
    


<!-- Membership Page -->
<section class="membership-hero">
    <div class="membership-overlay">
  
      <!-- Top Section: Membership Info + QR -->
      <section class="membership-container">
        <div class="membership-content">
          <div class="membership-details">
            <section class="membership-benefit-section">
              <h2 class="membership-section-title">Membership Perks</h2>
              <div class="membership-text-cards">
                <div class="membership-text-card">
                  <h4>Exclusive Prices</h4>
                  <p>Members can enjoy exclusive member prices.</p>
                </div>
                <div class="membership-text-card">
                  <h4>Lucky Draw</h4>
                  <p>A more attractive lucky draw prizes awaits.</p>
                </div>
                <div class="membership-text-card">
                  <h4>Free Drinks</h4>
                  <p>Psst: you may even get free drinks from us for <strong>FIVE DAYS STRAIGHT!!</strong></p>
                </div>
              </div>
                          
            </section>
  
            <section class="membership-requirements">
              <h3 class="membership-section-title">Requirements</h3>
              <p class="membership-requirements-desc">Here’s what it takes to unlock our member privileges:</p>
              <ul class="membership-requirement-list">
                <li><span>01</span> Top-up RM30, RM50, RM100 or RM200</li>
                <li><span>02</span> Credit is stored & non-refundable</li>
                <li><span>03</span> Lifetime membership (no expiry)</li>
                <li><span>04</span> Minimum RM30 required if balance is insufficient</li>
              </ul>
            </section>
          </div>
  
          <div class="membership-qr-card">
            <h4 class="membership-qr-title">DUIT NOW</h4>
            <img src="images/membership_qr.png" alt="DuitNow QR Code" class="membership-qr-img">
            <p class="membership-qr-caption">Brew And Go SDN BHD</p>
          </div>
          
        </div>
      </section>
  
      <!-- Bottom Section: Registration Form -->
      <section class="membership-form-section">
        <h2>Membership Registration</h2>
        <form class="membership-form" action="#" method="post">
          <fieldset>
            <label>First Name:
              <input type="text" name="first_name" maxlength="25" pattern="[A-Za-z\s]+" required>
            </label>
  
            <label>Last Name:
              <input type="text" name="last_name" maxlength="25" pattern="[A-Za-z\s]+" required>
            </label>
  
            <label>Email Address:
              <input type="email" name="email" required>
            </label>
  
            <label>Login ID:
              <input type="text" id="login" name="login" maxlength="10" pattern="[A-Za-z]+" required>
            </label>
  
            <label>Password:
              <input type="text" id="password" name="password" maxlength="25" pattern="[A-Za-z]+" required>
            </label>

            <label>Payment Slip Upload:
                <input type="file" name="payment_slip" accept=".jpg,.jpeg,.png,.pdf" required>
              </label>              
  
            <div class="membership-button-group">
              <button type="submit" class="btn-membership-submit">Submit</button>
              <button type="reset" class="btn-membership-reset">Reset</button>
            </div>
  
          </fieldset>
        </form>
      </section>
    </div>
  </section>
  
      
      
  <!-- Footer -->
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

    <a href="#top" class="back-to-top">
        <span>↑</span>
      </a>

</body>
</html>