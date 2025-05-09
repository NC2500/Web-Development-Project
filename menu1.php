<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="author" content="Tammy Ru Xiu TAY" />
  <title>Artisan Brew - Brew & Go</title>
  <link rel="stylesheet" href="styles/style.css" />
</head>
<body>

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

<!-- Header with background -->
<header class="product-banner">
  <div class="banner-overlay">
    <div class="banner-text">
      <h1>Artisan Brew</h1>
      <a href="menu.php" class="back-button">Back</a>
    </div>
  </div>
</header>


<!-- Product Grid -->
<!-- Product Card Section -->
<section class="product-grid">
  <figure class="product-card">
    <img src="images/coffee/Cheese Americano.jpeg" alt="Cheese Americano" />
    <figcaption>
      <h3>Cheese Americano</h3>
      <p>Smooth black coffee with a creamy cheese foam topping.</p>
      <div class="price-tag">MP: RM13.90 | NP: RM15.90</div>
    </figcaption>
  </figure>
  
  <figure class="product-card">
    <img src="images/coffee/Yuzu Americano.jpeg" alt="Yuzu Americano" />
    <figcaption>
      <h3>Yuzu Americano</h3>
      <p>Espresso with Japanese citrus syrup – fruity and uplifting.</p>
      <div class="price-tag">MP: RM13.90 | NP: RM15.90</div>
    </figcaption>
  </figure>
  
  <figure class="product-card">
    <img src="images/coffee/Orange Mocha.jpeg" alt="Orange Mocha" />
    <figcaption>
      <h3>Orange Mocha</h3>
      <p>Rich chocolate with orange zest. Fruity and indulgent.</p>
      <div class="price-tag">MP: RM12.90 | NP: RM14.90</div>
    </figcaption>
  </figure>
  
  <figure class="product-card">
    <img src="images/coffee/Pistachio Latte.jpeg" alt="Pistachio Latte" />
    <figcaption>
      <h3>Pistachio Latte</h3>
      <p>Nutty, creamy, and visually stunning. A unique fan favorite.</p>
      <div class="price-tag">MP: RM15.90 | NP: RM17.90</div>
    </figcaption>
  </figure>
  
</section>

<!-- Pricing Table -->
<section class="pricing-section">
  <h2>Menu</h2>
  <table>
    <thead>
      <tr>
        <th>Drink</th>
        <th>MP (RM)</th>
        <th>NP (RM)</th>
      </tr>
    </thead>
    <tbody>
      <tr><td>Butterscotch Latte</td><td>11.90</td><td>13.90</td></tr>
      <tr><td>Butterscotch Creme</td><td>14.90</td><td>16.90</td></tr>
      <tr><td>Mint Latte</td><td>12.90</td><td>14.90</td></tr>
      <tr><td>Vienna Latte</td><td>14.90</td><td>16.90</td></tr>
      <tr><td>Pistachio Latte</td><td>15.90</td><td>17.90</td></tr>
      <tr><td>Strawberry Latte</td><td>14.90</td><td>16.90</td></tr>
      <tr><td>Mocha</td><td>11.90</td><td>13.90</td></tr>
      <tr><td>Mint Mocha</td><td>12.90</td><td>14.90</td></tr>
      <tr><td>Orange Mocha</td><td>12.90</td><td>14.90</td></tr>
      <tr><td>Yuzu Americano</td><td>13.90</td><td>15.90</td></tr>
      <tr><td>Cheese Americano</td><td>13.90</td><td>15.90</td></tr>
      <tr><td>Orange Americano</td><td>13.90</td><td>15.90</td></tr>
      <tr>
        <td>Extra Espresso Shot</td>
        <td colspan="2" class="centered-cell">RM2</td>
      </tr>      
    </tbody>
  </table>
</section>

<!-- Price Note -->
<aside class="price-note-aside">
  <h2>Important Price Info</h2>
  <ol>
    <li><strong>MP</strong> = Member Price</li>
    <li><strong>NP</strong> = Normal Price</li>
    <li>Add RM2 for Oat Milk</li>
  </ol>
  <dl>
    <dt>MP</dt>
    <dd>Discounted rate for Brew & Go members.</dd>
    <dt>NP</dt>
    <dd>Standard price for all customers.</dd>
  </dl>
</aside>


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
