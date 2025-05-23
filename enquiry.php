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
    


    <section class="enquiry-hero">
        <div class="enquiry-overlay">

            <h2 class="enquiry-title">Enquiry</h2>
            
            <form class="enquiry-form">
            
            <fieldset>
                
                <label>First Name:
                <input type="text" name="first-name" maxlength="25" required>
                </label>

                <label>Last Name:
                <input type="text" name="last-name" maxlength="25" required>
                </label>

                <label>Email Address:
                <input type="email" name="email" required>
                </label>
                
                <fieldset class="enquiry-form-address">
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
                    <input type="text" name="postcode" maxlength="5" pattern="\d{5}" required>
                </label>

                </fieldset>

                <label>Phone Number:
                    <input type="tel" name="phone" maxlength="10" placeholder="e.g. 0123456789" required>
                </label>
                
                <label>Type of Enquiry:
                <select name="enquiry-type" required>
                    <option value="">Select</option>
                    <option value="Membership">Membership</option>
                    <option value="Products">Products</option>
                    <option value="Pop-up Market">Pop-up Market</option>
                </select>
                </label>
                <label>Your Message:
                <textarea name="message" rows="5" required></textarea>
                </label>
                
                <div class="button-group">
                    <button type="submit" class="btn-submit">Submit</button>
                    <button type="reset" class="btn-reset">Reset</button>
                </div>

            </fieldset>
            </form>
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

    <a href="#top" class="back-to-top">
        <span>↑</span>
      </a>

</body>
</html>