<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="author" content="Tammy Ru Xiu TAY" />
  <title>Hot Beverages - Brew & Go</title>
  <link rel="stylesheet" href="styles/style.css" />
</head>

<body>

  <div id="top"></div>

<!-- Navigation Bar -->
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

<header class="product-banner">
  <div class="banner-overlay">
    <div class="banner-text">
      <h1>Hot Beverages</h1>
      <a href="menu.php" class="back-button">Back</a>
    </div>
  </div>
</header>

<section class="product-grid">
  <figure class="product-card">
    <img src="images/coffee/Hot Americano.jpeg" alt="Americano" />
    <figcaption>
      <h3>Americano</h3>
      <p>Straight and bold espresso, perfect for a chilly day.</p>
      <div class="price-tag">MP: RM8.90 | NP: RM10.90</div>
    </figcaption>    
  </figure>

  <figure class="product-card">
    <img src="images/coffee/Hot Latte.jpeg" alt="Latte" />
    <figcaption>
      <h3>Latte</h3>
      <p>Warm espresso blended with silky steamed milk.</p>
      <div class="price-tag">MP: RM10.90 | NP: RM12.90</div>
    </figcaption>    
  </figure>

  <figure class="product-card">
    <img src="images/coffee/Hot Yuri Matcha.jpeg" alt="Yuri Matcha" />
    <figcaption>
      <h3>Yuri Matcha</h3>
      <p>Hot ceremonial-grade matcha with floral undertones.</p>
      <div class="price-tag">MP: RM13.90 | NP: RM15.90</div>
    </figcaption>    
  </figure>

  <figure class="product-card">
    <img src="images/coffee/Hot Houjicha.jpeg" alt="Hojicha" />
    <figcaption>
      <h3>Hojicha</h3>
      <p>Roasted Japanese green tea with deep nutty flavor.</p>
      <div class="price-tag">MP: RM13.90 | NP: RM15.90</div>
    </figcaption>    
  </figure>
</section>

<section class="pricing-section">
  <h2>Menu</h2>
  <table>
    <thead><tr><th>Drink</th><th>MP (RM)</th><th>NP (RM)</th></tr></thead>
    <tbody>
        <tr><td>Americano</td><td>7.90</td><td>9.90</td></tr>
        <tr><td>Latte</td><td>9.90</td><td>11.90</td></tr>
        <tr><td>Butterscotch Latte</td><td>10.90</td><td>12.90</td></tr>
        <tr><td>Cappuccino</td><td>10.90</td><td>12.90</td></tr>
        <tr><td>Chocolate</td><td>12.90</td><td>14.90</td></tr>
        <tr><td>Yuri Matcha</td><td>13.90</td><td>14.90</td></tr>
        <tr><td>Houjicha</td><td>13.90</td><td>14.90</td></tr>
        </tbody>
  </table>
</section>

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