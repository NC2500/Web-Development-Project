<?php
require_once 'connection.php';

// Get search query from GET parameter
$search_query = isset($_GET['search']) ? strtolower(trim($_GET['search'])) : '';

// Fetch all basic brew products from the database
$sql = "SELECT * FROM products WHERE category_id = 1";
if (!empty($search_query)) {
    $sql .= " AND LOWER(name) LIKE '%" . mysqli_real_escape_string($conn, $search_query) . "%'";
}
$sql .= " ORDER BY id ASC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching products: " . mysqli_error($conn));
}

$all_products = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Separate products into grid (first 4) and all drinks
$grid_drinks = array_slice($all_products, 0, 4); // Limit to first 4 for the grid
$all_drinks = $all_products; // All products for the pricing table

// Filter grid drinks based on search
$filtered_grid_drinks = array_filter($grid_drinks, fn($drink) => $search_query === '' || stripos(strtolower($drink['name']), $search_query) !== false);

// Filter all drinks based on search
$filtered_all_drinks = array_filter($all_drinks, fn($drink) => $search_query === '' || stripos(strtolower($drink['name']), $search_query) !== false);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="author" content="Tammy Ru Xiu TAY" />
  <title>Basic Brew - Brew & Go</title>
  <link rel="stylesheet" href="styles/style.css" />
</head>
<body>
  <div id="top"></div>

  <!-- Navigation Bar -->
  <header>
    <?php include 'navbar.php'; ?>
  </header>

  <header class="product-banner">
    <div class="banner-overlay">
      <div class="banner-text">
        <h1>Basic Brew</h1>
        <a href="menu.php" class="back-button">Back</a>
      </div>
    </div>
  </header>

  <!-- Search Bar -->
  <div class="admin-search-sort-bar" style="margin: 20px auto; max-width: 600px; padding: 0 20px;">
      <form method="GET" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
          <div class="admin-search-sort-row" style="display: flex; gap: 15px; align-items: center;">
              <div class="admin-search-sort-group">
                  <label class="admin-search-sort-label" for="search">Search Drink:</label>
                  <input class="admin-search-sort-input" type="text" id="search" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" placeholder="Enter drink name" style="padding: 5px;">
              </div>
              <button class="admin-search-sort-btn" type="submit" style="padding: 5px 10px;">Search</button>
          </div>
      </form>
  </div>

  <!-- Product Grid -->
  <section class="product-grid">
    <?php if (empty($filtered_grid_drinks)): ?>
      <p style="text-align: center;">
        <?php if (!empty($search_query)): ?>
          No drinks found matching your search in Basic Brew.
        <?php else: ?>
          No drinks available in Basic Brew at the moment.
        <?php endif; ?>
      </p>
    <?php else: ?>
      <?php foreach ($filtered_grid_drinks as $drink): ?>
        <figure class="product-card <?= $drink['availability'] === 'Unavailable' ? 'unavailable' : '' ?>">
          <img src="<?= htmlspecialchars($drink['image_path']) ?>" alt="<?= htmlspecialchars($drink['name']) ?>" />
          <figcaption>
            <h3><?= htmlspecialchars($drink['name']) ?></h3>
            <p><?= htmlspecialchars($drink['description']) ?></p>
            <div class="price-tag">MP: RM<?= number_format($drink['price'], 2) ?> | NP: RM<?= number_format($drink['large_price'], 2) ?></div>
            <?php if ($drink['availability'] === 'Unavailable'): ?>
              <span class="unavailable-label">Unavailable</span>
            <?php endif; ?>
          </figcaption>
        </figure>
      <?php endforeach; ?>
    <?php endif; ?>
  </section>

  <!-- Pricing Table -->
  <section class="pricing-section">
    <h2>Menu</h2>
    <?php if (empty($filtered_all_drinks)): ?>
      <p style="text-align: center;">
        <?php if (!empty($search_query)): ?>
          No drinks found matching your search in Menu.
        <?php else: ?>
          No drinks available in Menu at the moment.
        <?php endif; ?>
      </p>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>Drink</th>
            <th>MP (RM)</th>
            <th>NP (RM)</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($filtered_all_drinks as $drink): ?>
            <tr class="<?= $drink['availability'] === 'Unavailable' ? 'unavailable' : '' ?>">
              <td><?= htmlspecialchars($drink['name']) ?></td>
              <td><?= number_format($drink['price'], 2) ?></td>
              <td><?= number_format($drink['large_price'], 2) ?></td>
              <?php if ($drink['availability'] === 'Unavailable'): ?>
                <td colspan="3"><span class="unavailable-label">Unavailable</span></td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
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
  <?php include 'footer.php'; ?>
  <?php include 'backtotop.php'; ?>
</body>
</html>