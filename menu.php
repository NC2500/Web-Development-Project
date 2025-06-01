<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="author" content="Tammy Ru Xiu TAY" />
  <title>Our Menu - Brew & Go</title>
  <link rel="stylesheet" href="styles/style.css" />
</head>

<body>

  <div id="top"></div>

<!-- Navigation Bar -->
<header>
    <?php include 'navbar.php'; ?>
</header>

<!-- Product Category Selection -->
<section class="menu-page">
  <h1>Our Menu Categories</h1>
  <p>Select from our handcrafted drink collections:</p>

  <div class="menu-grid">
    <div class="menu-item">
      <a href="menu1.php">
        <img src="images/coffee/Cheese Americano.jpeg" alt="Artisan Brew" />
        <h3>Artisan Brew</h3>
        <p>Creative blends like Cheese Americano & Orange Mocha.</p>
      </a>
    </div>
    <div class="menu-item">
      <a href="menu2.php">
        <img src="images/coffee/Matcha Latte.jpeg" alt="Non-Coffee" />
        <h3>Non-Coffee</h3>
        <p>Matcha, chocolate, strawberry latte & more.</p>
      </a>
    </div>
    <div class="menu-item">
      <a href="menu3.php">
        <img src="images/coffee/Mocha.jpeg" alt="Basic Brew" />
        <h3>Basic Brew</h3>
        <p>Classic brews like Americano, Mocha, and Latte.</p>
      </a>
    </div>
    <div class="menu-item">
      <a href="menu4.php">
        <img src="images/coffee/Hot Yuri Matcha.jpeg" alt="Hot Beverages" />
        <h3>Hot Beverages</h3>
        <p>Warm and cozy: Hot Chocolate, Yuri Matcha, Houjicha and more.</p>
      </a>
    </div>
  </div>
</section>

<!-- Footer -->
   <?php include 'footer.php'; ?>
   
    <?php include 'backtotop.php'; ?>

</body>
</html>
