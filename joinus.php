<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="author" content="Bahrose Hassan Babar" />
  <title>Our Menu - Brew & Go</title>
  <link rel="stylesheet" href="styles/style.css" />
</head>

<body>

  <div id="top"></div>

<!-- Navigation Bar -->
<header>

  
  <nav class="navbar">
    <input type="checkbox" id="menu-toggle" class="menu-toggle">
    <label for="menu-toggle" class="hamburger">&#9776;</label>
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
  </nav>

</header>

<!-- Join Us Section -->
<section class="joinus-hero">
    <div class="joinus-overlay">
      <div class="joinus-container">
  
        <!-- Open Positions -->
        <section class="joinus-section">
            <h2 class="section-title">Open Positions</h2>
            <div class="positions-wrapper">
              <a href="#joinus-form" class="position-card">
                <div class="position-content">
                  <h3>Barista</h3>
                  <p>One Jaya Mall & Plaza Merdeka Mall</p>
                </div>
              </a>
              
              <a href="#joinus-form" class="position-card">
                <div class="position-content">
                  <h3>Cashier</h3>
                  <p>One Jaya Mall & Plaza Merdeka Mall</p>
                </div>
              </a>
            </div>
          </section>
          
  
        <!-- Benefits -->
        <section class="joinus-section">
            <h2 class="section-title">Benefits</h2>
            <div class="benefit-cards">
              <div class="benefit-card">
                <img src="images/EPF & Socso_2.png" alt="EPF & Socso" class="epf-logo"/>
                <p>EPF & SOCSO</p>
              </div>
              <div class="benefit-card">
                <img src="images/Meal Allowance.png" alt="Meal Allowance" />
                <p>Meal Allowance</p>
              </div>
              <div class="benefit-card">
                <img src="images/Commision.png" alt="Commission" />
                <p>Sales Commission</p>
              </div>
            </div>
          </section>
          
  
        <!-- Requirements -->
        <section class="joinus-section">
            <h2>Requirements</h2>
            <p class="requirements-desc">We’re looking for passionate team members who meet the following:</p>            
          <ul class="requirement-list">
            <li><span>01</span> Age 18 years old & above</li>
            <li><span>02</span> Fluent in English, Mandarin & BM</li>
            <li><span>03</span> Full-time & Part-time available</li>
            <li><span>04</span> Possess own transportation</li>
          </ul>
        </section>
  
       <!-- Application Form -->
       <section class="joinus-form-section" id="joinus-form">
        <h2>Let's work together！</h2>
  <form class="joinus-form" action="joinus_process.php" method="post" enctype="multipart/form-data">
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

      <fieldset class="joinus-form-address">
        <legend><strong>Address</strong></legend>

        <label>Street Address:
          <input type="text" name="street" maxlength="40" required>
        </label>

        <label>City/Town:
          <input type="text" name="city" maxlength="20" required>
        </label>

        <label>State:
          <select name="state" required>
            <option value="">-- Select State --</option>
            <option value="Johor">Johor</option>
            <option value="Kedah">Kedah</option>
            <option value="Kelantan">Kelantan</option>
            <option value="Malacca">Malacca</option>
            <option value="Negeri Sembilan">Negeri Sembilan</option>
            <option value="Pahang">Pahang</option>
            <option value="Penang">Penang</option>
            <option value="Perak">Perak</option>
            <option value="Perlis">Perlis</option>
            <option value="Sabah">Sabah</option>
            <option value="Sarawak">Sarawak</option>
            <option value="Selangor">Selangor</option>
            <option value="Terengganu">Terengganu</option>
          </select>
        </label>

        <label>Postcode:
          <input type="text" name="postcode" pattern="\d{5}" maxlength="5" required>
        </label>
      </fieldset>

      <label>Phone Number:
        <input type="tel" name="phone" maxlength="10" placeholder="e.g. 0123456789" required>
      </label>

      <fieldset class="joinus-form-shift">
        <legend><strong>Preferred Shift</strong></legend>
        <label>
          <input type="radio" name="shift" value="morning" required> Morning
        </label>
        <label>
          <input type="radio" name="shift" value="evening"> Evening
        </label>
      </fieldset>

      <label>CV Upload:
        <input type="file" name="cv" accept=".doc,.docx,.pdf">
      </label>

      <label>Photo Upload:
        <input type="file" name="photo" accept="image/*">
        <small>(Max size: 200KB)</small>
      </label>


      <div class="button-group">
        <button type="submit" class="btn-submit">Submit</button>
        <button type="reset" class="btn-reset">Reset</button>
      </div>
      
    </fieldset>
  </form>
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
