<?php
require_once 'connection.php';

// Get search and filter parameters from GET
$search_name = isset($_GET['search_name']) ? strtolower(trim($_GET['search_name'])) : '';
$search_sku = isset($_GET['search_sku']) ? strtolower(trim($_GET['search_sku'])) : '';
$search_category = isset($_GET['search_category']) ? strtolower(trim($_GET['search_category'])) : '';
$filter_availability = isset($_GET['filter_availability']) ? $_GET['filter_availability'] : '';

// Initialize messages
$success_message = '';
$error_message = '';

// Build the SQL query with search and filter conditions
$sql = "SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id";
$where_conditions = [];
if (!empty($search_name)) {
    $where_conditions[] = "LOWER(p.name) LIKE '%" . mysqli_real_escape_string($conn, $search_name) . "%'";
}
if (!empty($search_sku)) {
    $where_conditions[] = "LOWER(p.sku) LIKE '%" . mysqli_real_escape_string($conn, $search_sku) . "%'";
}
if (!empty($search_category)) {
    $where_conditions[] = "LOWER(c.name) LIKE '%" . mysqli_real_escape_string($conn, $search_category) . "%'";
}
if ($filter_availability === 'Available' || $filter_availability === 'Unavailable') {
    $where_conditions[] = "p.availability = '" . mysqli_real_escape_string($conn, $filter_availability) . "'";
}
if (!empty($where_conditions)) {
    $sql .= " WHERE " . implode(" AND ", $where_conditions);
}
$sql .= " ORDER BY p.id ASC";

// Handle availability toggle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_availability'])) {
    $product_id = (int)$_POST['product_id'];
    $sql_toggle = "SELECT availability FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql_toggle);
    mysqli_stmt_bind_param($stmt, "i", $product_id);
    mysqli_stmt_execute($stmt);
    $result_toggle = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result_toggle);

    if ($product) {
        $new_availability = $product['availability'] === 'Available' ? 'Unavailable' : 'Available';
        $update_sql = "UPDATE products SET availability = ? WHERE id = ?";
        $update_stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "si", $new_availability, $product_id);
        if (mysqli_stmt_execute($update_stmt)) {
            $success_message = "Availability updated successfully!";
        } else {
            $error_message = "Failed to update availability.";
        }
        mysqli_stmt_close($update_stmt);
    } else {
        $error_message = "Product not found.";
    }
    mysqli_stmt_close($stmt);
}

// Execute the main query
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching products: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="author" content="Admin" />
  <title>Admin - View Products - Brew & Go</title>
  <link rel="stylesheet" href="styles/style.css" />
</head>

<body class="admin-members-body">
  <div id="top"></div>
  <?php include 'navbar.php'; ?>
  <div class="admin-wrapper">
    <?php include 'admin_sidebar.php'; ?>
    <div class="admin-activities-main">
      <header class="admin-activities-topbar">
        <div class="admin-activities-topbar-left">
          <span class="admin-activities-topbar-title">All Products</span>
        </div>
        <div class="admin-activities-topbar-right">
          <a href="add_products.php" class="admin-activities-add-btn"> Add Products</a>
          <a href="admin_dashboard.php" class="admin-activities-back-btn">← Back to Dashboard</a>
        </div>
      </header>

      <!-- Search and Filter Bar -->
      <div class="admin-search-sort-bar">
        <form method="GET" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
          <div class="admin-search-sort-row">
            <div class="admin-search-sort-group">
              <label class="admin-search-sort-label" for="search_name">Product Name:</label>
              <input class="admin-search-sort-input" type="text" id="search_name" name="search_name" value="<?= htmlspecialchars($search_name) ?>" placeholder="Search by Product Name" style="padding: 5px;">
            </div>
            <div class="admin-search-sort-group">
              <label class="admin-search-sort-label" for="search_sku">SKU:</label>
              <input class="admin-search-sort-input" type="text" id="search_sku" name="search_sku" value="<?= htmlspecialchars($search_sku) ?>" placeholder="Search by SKU" style="padding: 5px;">
            </div>
            <div class="admin-search-sort-group">
              <label class="admin-search-sort-label" for="search_category">Category:</label>
              <input class="admin-search-sort-input" type="text" id="search_category" name="search_category" value="<?= htmlspecialchars($search_category) ?>" placeholder="Search by Category" style="padding: 5px;">
            </div>
            <div class="admin-search-sort-group">
              <label class="admin-search-sort-label" for="filter_availability">Filter by Availability:</label>
              <select id="filter_availability" name="filter_availability" onchange="this.form.submit()" style="padding: 5px;">
                <option value="" <?= $filter_availability === '' ? 'selected' : '' ?>>All Products</option>
                <option value="Available" <?= $filter_availability === 'Available' ? 'selected' : '' ?>>Available</option>
                <option value="Unavailable" <?= $filter_availability === 'Unavailable' ? 'selected' : '' ?>>Unavailable</option>
              </select>
            </div>
            <button class="admin-search-sort-btn" type="submit" style="padding: 5px 10px;">Search</button>
            <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="admin-clear-search-btn">Clear</a>
          </form>
        </div>
        </div>

      <section class="admin-products-content">
        <!-- Display Messages -->
        <?php if (!empty($success_message)): ?>
          <div class="admin-products-message admin-products-success">
            <?= htmlspecialchars($success_message) ?>
          </div>
        <?php elseif (!empty($error_message)): ?>
          <div class="admin-products-message admin-products-error">
            <?= htmlspecialchars($error_message) ?>
          </div>
        <?php endif; ?>

        <h2>Product List</h2>
        <table class="admin-products-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Description</th>
              <th>Price</th>
              <th>Large Price</th>
              <th>SKU</th>
              <th>Category</th>
              <th>Availability</th>
              <th>Created At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
              <?php while ($product = mysqli_fetch_assoc($result)): ?>
                <tr>
                  <td><?= htmlspecialchars($product['id']) ?></td>
                  <td><?= htmlspecialchars($product['name']) ?></td>
                  <td><?= htmlspecialchars($product['description']) ?></td>
                  <td><?= number_format($product['price'], 2) ?></td>
                  <td><?= number_format($product['large_price'], 2) ?></td>
                  <td><?= htmlspecialchars($product['sku']) ?></td>
                  <td><?= htmlspecialchars($product['category_name'] ?? 'N/A') ?></td>
                  <td>
                    <form method="POST" action="" class="admin-products-toggle-form">
                      <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                      <button type="submit" name="toggle_availability" class="admin-products-toggle-btn <?= htmlspecialchars($product['availability']) === 'Available' ? 'available' : 'unavailable' ?>">
                        <?= htmlspecialchars($product['availability']) ?>
                      </button>
                    </form>
                  </td>
                  <td><?= htmlspecialchars($product['created_at']) ?></td>
                  <td class="admin-products-actions">
                    <a href="edit_products.php?id=<?= $product['id'] ?>" class="admin-products-edit-btn">Edit</a>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="10" style="text-align: center; padding: 20px;">
                  No products found<?php if (!empty($search_name) || !empty($search_sku) || !empty($search_category) || $filter_availability !== '') echo " matching your search"; ?>.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </section>
    </div>
  </div>

  <?php include 'backtotop.php'; ?>
</body>
</html>