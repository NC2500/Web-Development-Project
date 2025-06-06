<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Miaw Fong LIM" />
    <title>Brew & Co. Coffee</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

  <div id="top"></div>

  <header>
    <?php 
    session_start();
    include 'setup.php';
    include 'connection.php';
    include 'navbar.php'; 
    ?>
  </header>
 
    <section class="hero">
        
        <div class="content">
            <p class="small-text">Brew & Go, Coffee Estd. 2023</p>
            <h1>Freshly Brewed, <br> Ready to Go!</h1>
            <a href="#signature" class="btn">Discover Our Coffee</a>
        </div>
    </section>
    
    <div class="cup-float-container">
        <img src="images/Cup_3.png" alt="Floating Coffee Cup">
    </div>

    <section class="menu">
        
      
        <div class="menu-content">
        
          <h3 id="signature" class="menu-title">Our Signature</h3>
      
            <div class="card-wrapper">
              <div class="menu-slider">
                <figure class="menu-card" id="card1">
                  <img src="images/Coffee/Cappucino Cold Foam.jpeg" alt="Cappuccino Cold Foam">
                  <figcaption>
                    <h3>Cappuccino Cold Foam</h3>
                    <p>Classic cappuccino topped with a smooth, velvety cold foam. Bold yet airy.</p>
                  </figcaption>
                </figure>
    
                <figure class="menu-card" id="card2">
                  <img src="images/Coffee/Cheese Americano.jpeg" alt="Cheese Americano">
                  <figcaption>
                    <h3>Cheese Americano</h3>
                    <p>Strong black coffee mellowed by a creamy cheese foam. Savory meets bold.</p>
                  </figcaption>
                </figure>
    
                <figure class="menu-card" id="card3">
                  <img src="images/Coffee/Yuzu Americano.jpeg" alt="Yuzu Americano">
                  <figcaption>
                    <h3>Yuzu Americano</h3>
                    <p>A zesty citrus twist in a classic Americano. Bright, bold, and refreshing.</p>
                  </figcaption>
                </figure>
    
                <figure class="menu-card" id="card4">
                  <img src="images/Coffee/Orange mocha.jpeg" alt="Orange Mocha">
                  <figcaption>
                    <h3>Orange Mocha</h3>
                    <p>Rich chocolate with a splash of orange. Decadent, fruity, and indulgent.</p>
                  </figcaption>
                </figure>
    
                <figure class="menu-card" id="card5">
                  <img src="images/Coffee/mocha.jpeg" alt="Mocha">
                  <figcaption>
                    <h3>Mocha</h3>
                    <p>A rich fusion of chocolate and espresso. Smooth, deep, and indulgent.</p>
                  </figcaption>
                </figure>
    
                <figure class="menu-card" id="card6">
                  <img src="images/Coffee/Matcha Latte.jpeg" alt="Matcha Latte">
                  <figcaption>
                    <h3>Matcha Latte</h3>
                    <p>Earthy premium matcha blended with creamy milk. Smooth and energizing.</p>
                  </figcaption>
                </figure>
    
                <figure class="menu-card" id="card7">
                  <img src="images/Coffee/strawberry latte.jpeg" alt="Strawberry Latte">
                  <figcaption>
                    <h3>Strawberry Latte</h3>
                    <p>Fresh milk infused with sweet strawberry purée. Creamy, fruity, and refreshing.</p>
                  </figcaption>
                </figure>
    
                <figure class="menu-card" id="card8">
                  <img src="images/Coffee/Vienna latte.jpeg" alt="Vienna Latte">
                  <figcaption>
                    <h3>Vienna Latte</h3>
                    <p>Espresso topped with whipped cream. Smooth, sweet, and luxurious.</p>
                  </figcaption>
                </figure>
                
                <figure class="menu-card" id="card1">
                  <img src="images/Coffee/Cappucino Cold Foam.jpeg" alt="Cappuccino Cold Foam">
                  <figcaption>
                    <h3>Cappuccino Cold Foam</h3>
                    <p>Classic cappuccino topped with a smooth, velvety cold foam. Bold yet airy.</p>
                  </figcaption>
                </figure>
    
                <figure class="menu-card" id="card2">
                  <img src="images/Coffee/Cheese Americano.jpeg" alt="Cheese Americano">
                  <figcaption>
                    <h3>Cheese Americano</h3>
                    <p>Strong black coffee mellowed by a creamy cheese foam. Savory meets bold.</p>
                  </figcaption>
                </figure>
    
                <figure class="menu-card" id="card3">
                  <img src="images/Coffee/Yuzu Americano.jpeg" alt="Yuzu Americano">
                  <figcaption>
                    <h3>Yuzu Americano</h3>
                    <p>A zesty citrus twist in a classic Americano. Bright, bold, and refreshing.</p>
                  </figcaption>
                </figure>

              </div>
            </div>
      
          </div>
      
          <div class="menu-cta">
            <a href="menu.php" class="btn">Discover Our Signature</a>
          </div>
        </div>
      </section>

      <hr class="section-divider">
      <section class="story-section-flex">
        <div class="story-image"></div>
        <div class="story-text">
          <h2>Our Story</h2>
          <h4 class="subheading">Born in Kuching, brewed for all.</h4>
          <p>
            Brew & Go is a Kuching-based coffee brand, rooted in passion and quality. We’re known for our handcrafted brews that celebrate local and global inspirations — from classic espresso blends to unique artisan creations.
          </p>
          <p>
            Beyond coffee, we offer a delightful variety of matcha and chocolate beverages, crafted for every taste. Each cup tells a story — carefully brewed to bring warmth, comfort, and joy to your everyday moments.
          </p>
        </div>
      </section>
    
<hr>

      <!-- Latest Promotions/News Section -->
      <section class="latest-container">
        <div class="left-section">
            <div class="promo-box">
                <h3>LATEST PROMOTIONS</h3>
                <p>Get 1 FREE DRINK and 1 RM10 voucher, with a top-up of RM50 to your membership!</p>
                <p><strong>*Only available at Plaza Merdeka outlet</strong></p>
            </div>
    
            <div class="news-box">
                <h3>LATEST NEWS</h3>
                <img src="images/News1.png" alt="Latest News">
                <a href="activities.php" class="btn-view-more">View More Activities</a>
            </div>
        </div>
        <div class="right-section">
            <img src="images/MarchPromo.png" alt="March Promotion">
        </div>
    </section>


<hr>

<section class="map-card">
  <div class="map-card-inner">
    <div class="map-container">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.418390662413!2d110.36333687404955!3d1.5178430984679347!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31fba7003da964cb%3A0xf8d14c19ed1634a4!2sBrew%20and%20Go!5e0!3m2!1sen!2smy!4v1743490468428!5m2!1sen!2smy" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <div class="text-section">
      <h3>One Jaya Mall</h3>
      <p class="label">Address</p>
      <p>Ground Floor, G63, Lot, Onejaya Shopping Complex, 11430, Jalan Song, Tabuan Heights</p>

      <p class="label">Hours</p>
      <p>9:00am – 6:00pm daily</p>

      <p class="label">Contact Number</p>
      <p>+60 11-1653 1886</p>
    </div>
  </div>
</section>

<section class="map-card">
  <div class="map-card-inner">
    <div class="map-container">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.34225343413!2d110.34144207404962!3d1.5585741984268702!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31fba7ee0ea57329%3A0x104e8cca7140a048!2sPlaza%20Merdeka!5e0!3m2!1sen!2smy!4v1743498967331!5m2!1sen!2smy" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <div class="text-section">
      <h3>Plaza Merdeka</h3>
      <p class="label">Address</p>
      <p>Level 1, Plaza Merdeka, 88, Pearl Street</p>

      <p class="label">Hours</p>
      <p>10:00am – 10:00pm daily</p>

      <p class="label">Contact Number</p>
      <p>+60 11-1653 1886</p>
    </div>
  </div>
</section>

    
       <?php include 'footer.php'; ?>
   
    <?php include 'backtotop.php'; ?>

</body>
</html>
