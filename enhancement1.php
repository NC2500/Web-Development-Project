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
    <?php include 'navbar.php'; ?>
  </header>

  <section class="enhancement-container">
    <h1>Website Enhancements</h1>
  
    <!-- 1 -->
    <div class="enhancement-card">
      <h2>1. Responsive Layout Design (Media Queries)</h2>
      <p>This enhancement ensures all pages adjust beautifully across devices (desktop, tablet, mobile).</p>
      <p><strong>Used in:</strong> All pages (main.php, menu.php, activities.php, etc.)</p>
      <div class="enhancement-image">
        <img src="images/enhancement-responsive.png" alt="Responsive Layout Example" />
      </div>
    </div>
  
    <!-- 2 -->
    <div class="enhancement-card">
      <h2>2. Animated Scrolling Menu Carousel</h2>
      <p>An infinite horizontal scroll animation is added to the menu carousel using keyframes.</p>
      <p><strong>Used in:</strong> main.php (under Menu section)</p>
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
      <p><strong>Used in:</strong> main.php</p>
      <div class="enhancement-image">
        <img src="images/enhancement-cupfloat.png" alt="Floating Cup Visual" />
      </div>
    </div>
    
  <!-- 6 -->
  <div class="enhancement-card">
    <h2>6. Dropdown Navigation Menu</h2>
    <p>The main navigation bar uses a dropdown menu structure for better organization and UX. When hovering over “Menu” or “Activities,” a submenu appears using pure HTML and CSS. This allows users to quickly access subpages and improves navigation hierarchy without needing JavaScript.</p>
    <p><strong>Used in:</strong> All pages with navigation bar (e.g., main.php, menu.php, activities.php)</p>
    <div class="enhancement-image">
      <img src="images/enhancement-dropdown.png" alt="Dropdown Navigation Example" />
    </div>
  </div>

  
    <!-- 7 -->
    <div class="enhancement-card">
      <h2>7. Hover Elevation Effects</h2>
      <p>Cards (menu, activity, benefit, position, etc.) lift slightly on hover using `transform: translateY(-5px)`...</p>
      <p><strong>Used in:</strong> menu.php, activities.php, joinus.php</p>
      <div class="enhancement-image">
        <img src="images/enhancement-hovereffect.png" alt="Hover Card Effect" />
      </div>
    </div>
  
    <!-- 8 -->
    <div class="enhancement-card">
      <h2>8. Youtube Video Embedding</h2>
      <p>Music preferences are enhanced by embedding multiple YouTube iframes.</p>
      <p><strong>Used in:</strong> aboutus1~4.php</p>
      <div class="enhancement-image">
        <img src="images/enhancement-youtube.png" alt="YouTube Embed" />
      </div>
    </div>
  
    <!-- 9 -->
    <div class="enhancement-card">
      <h2>9. Embedded Google Map</h2>
      <p>This enhancement adds a real-time embedded Google Map to help users locate Brew & Go easily.</p>
      <p><strong>Used in:</strong> main.php</p>
      <div class="enhancement-image">
        <img src="images/enhancement-map.png" alt="Google Map Embed Example" />
      </div>
    </div>
  </section>
  

     <?php include 'footer.php'; ?>
   
    <?php include 'backtotop.php'; ?>
  
  </body>
  </html>
