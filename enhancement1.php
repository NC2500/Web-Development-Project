<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enhancement 1 - Brew & Go</title>
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

  <section class="enhancement-container">
    <h1>Website Enhancements</h1>
  
    <!-- 1 -->
    <div class="enhancement-card">
      <h2>1. Responsive Layout Design (Media Queries)</h2>
      <p>This enhancement ensures all pages adjust beautifully across devices (desktop, tablet, mobile).</p>
      <p><strong>Used in:</strong> All pages (main.html, menu.html, activities.html, etc.)</p>
      <div class="enhancement-image">
        <img src="images/enhancement-responsive.png" alt="Responsive Layout Example" />
      </div>
    </div>
  
    <!-- 2 -->
    <div class="enhancement-card">
      <h2>2. Animated Scrolling Menu Carousel</h2>
      <p>An infinite horizontal scroll animation is added to the menu carousel using keyframes.</p>
      <p><strong>Used in:</strong> main.html (under Menu section)</p>
      <div class="enhancement-image">
        <img src="images/enhancement-carousel.png" alt="Carousel Animation" />
      </div>
    </div>
  
    <!-- 3 -->
    <div class="enhancement-card">
      <h2>3. Back to Top Button with Glow Animation</h2>
      <p>This floating button appears in the bottom-right corner and brings the user to the top.</p>
      <p><strong>Used in:</strong> All pages</p>
      <div class="enhancement-image">
        <img src="images/enhancement-backtotop.png" alt="Back to Top Button" />
      </div>
    </div>
  
    <!-- 4 -->
    <div class="enhancement-card">
      <h2>4. Navigation Hamburger Menu with Toggle</h2>
      <p>On smaller devices, the navigation transforms into a hamburger icon.</p>
      <p><strong>Used in:</strong> All pages</p>
      <div class="enhancement-image">
        <img src="images/enhancement-hamburger.png" alt="Mobile Hamburger Menu" />
      </div>
    </div>
    
    <!-- 5 -->
    <div class="enhancement-card">
      <h2>5. Floating Coffee Cup Overlay</h2>
      <p>On the main page, a floating coffee cup image overlays the top of the menu carousel.</p>
      <p><strong>Used in:</strong> main.html</p>
      <div class="enhancement-image">
        <img src="images/enhancement-cupfloat.png" alt="Floating Cup Visual" />
      </div>
    </div>
    
  <!-- 6 -->
  <div class="enhancement-card">
    <h2>6. Dropdown Navigation Menu</h2>
    <p>The main navigation bar uses a dropdown menu structure for better organization and UX. When hovering over “Menu” or “Activities,” a submenu appears using pure HTML and CSS. This allows users to quickly access subpages and improves navigation hierarchy without needing JavaScript.</p>
    <p><strong>Used in:</strong> All pages with navigation bar (e.g., main.html, menu.html, activities.html)</p>
    <div class="enhancement-image">
      <img src="images/enhancement-dropdown.png" alt="Dropdown Navigation Example" />
    </div>
  </div>

  
    <!-- 7 -->
    <div class="enhancement-card">
      <h2>7. Hover Elevation Effects</h2>
      <p>Cards (menu, activity, benefit, position, etc.) lift slightly on hover using `transform: translateY(-5px)`...</p>
      <p><strong>Used in:</strong> menu.html, activities.html, joinus.html</p>
      <div class="enhancement-image">
        <img src="images/enhancement-hovereffect.png" alt="Hover Card Effect" />
      </div>
    </div>
  
    <!-- 8 -->
    <div class="enhancement-card">
      <h2>8. Youtube Video Embedding</h2>
      <p>Music preferences are enhanced by embedding multiple YouTube iframes.</p>
      <p><strong>Used in:</strong> aboutus1~4.html</p>
      <div class="enhancement-image">
        <img src="images/enhancement-youtube.png" alt="YouTube Embed" />
      </div>
    </div>
  
    <!-- 9 -->
    <div class="enhancement-card">
      <h2>9. Embedded Google Map</h2>
      <p>This enhancement adds a real-time embedded Google Map to help users locate Brew & Go easily.</p>
      <p><strong>Used in:</strong> main.html</p>
      <div class="enhancement-image">
        <img src="images/enhancement-map.png" alt="Google Map Embed Example" />
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

<a href="#top" class="back-to-top">
  <span>↑</span>
</a>
  
  </body>
  </html>
