<?php
require_once 'connection.php';

// Fetch categories
$category_sql = "SELECT id, name FROM categories ORDER BY name";
$category_result = mysqli_query($conn, $category_sql);
$categories = [];
while ($row = mysqli_fetch_assoc($category_result)) {
    $categories[] = $row;
}

// Initialize messages
$success_message = '';
$error_message = '';

// Handle form submission for adding a new product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $large_price = floatval($_POST['large_price']);
    $category_id = (int)$_POST['category_id'];
    $availability = 'Available'; // Hardcode to Available since field is read-only
    $image_path = ''; // Default empty image path

    // Fetch category name for SKU generation
    $category_name_sql = "SELECT name FROM categories WHERE id = ?";
    $category_stmt = mysqli_prepare($conn, $category_name_sql);
    mysqli_stmt_bind_param($category_stmt, "i", $category_id);
    mysqli_stmt_execute($category_stmt);
    $category_result = mysqli_stmt_get_result($category_stmt);
    $category = mysqli_fetch_assoc($category_result);
    mysqli_stmt_close($category_stmt);

    if (!$category) {
        $error_message = "Invalid category selected.";
    } else {
        // Generate SKU: Category name + Product name, replace spaces with underscores, all uppercase
        $category_name = str_replace(' ', '_', trim($category['name']));
        $product_name = str_replace(' ', '_', trim($name));
        $sku = strtoupper($category_name . '_' . $product_name);

        // Handle image upload if provided
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = "uploads/products/"; // Ensure this directory exists and is writable
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            $image_name = basename($_FILES['image']['name']);
            $target_file = $upload_dir . $image_name;

            // Check if file is an image
            $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($image_file_type, $allowed_types)) {
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    $image_path = $target_file; // Set image path to the uploaded file
                } else {
                    $error_message = "Failed to upload image.";
                }
            } else {
                $error_message = "Only JPG, JPEG, PNG, and GIF files are allowed.";
            }
        }

        if (empty($error_message)) {
            $insert_sql = "INSERT INTO products (name, description, price, large_price, sku, category_id, image_path, availability, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            $insert_stmt = mysqli_prepare($conn, $insert_sql);
            mysqli_stmt_bind_param($insert_stmt, "ssdssiss", $name, $description, $price, $large_price, $sku, $category_id, $image_path, $availability);

            if (mysqli_stmt_execute($insert_stmt)) {
                $success_message = "Product added successfully! View here <a href='admin_view_products.php'>product list</a>.";
            } else {
                $error_message = "Failed to add product.";
            }
            mysqli_stmt_close($insert_stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="author" content="Admin" />
  <title>Admin - Add Product - Brew & Go</title>
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
          <span class="admin-activities-topbar-title">Add Product</span>
        </div>
        <div class="admin-activities-topbar-right">
          <a href="admin_view_products.php" class="admin-activities-back-btn">← Back to Products</a>
        </div>
      </header>

      <section class="admin-products-edit-form">
        <?php if (!empty($error_message)): ?>
          <div class="admin-products-edit-message admin-products-edit-error">
            <?= htmlspecialchars($error_message) ?>
          </div>
        <?php elseif (!empty($success_message)): ?>
          <div class="admin-products-edit-message admin-products-edit-success">
            <?= $success_message ?>
          </div>
        <?php endif; ?>

        <?php if (empty($success_message)): ?>
          <div class="admin-products-image-preview">
            <label for="image">
              <p>Click to upload an image.</p>
            </label>
          </div>

          <form method="POST" action="" enctype="multipart/form-data">
            <input type="file" id="image" name="image" style="display: none;" accept="image/jpeg,image/png,image/gif">

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="" required>

            <label for="description">Description:</label>
            <input type="text" id="description" name="description" value="">

            <label for="price">Price:</label>
            <input type="number" step="0.01" id="price" name="price" value="" required>

            <label for="large_price">Large Price:</label>
            <input type="number" step="0.01" id="large_price" name="large_price" value="" required>

            <label for="category_id">Category:</label>
            <select id="category_id" name="category_id" required>
              <option value="" disabled selected>Select a category</option>
              <?php foreach ($categories as $category): ?>
                <option value="<?= htmlspecialchars($category['id']) ?>">
                  <?= htmlspecialchars($category['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>

            <label for="availability">Availability:</label>
            <input type="text" id="availability" name="availability" value="Available" readonly class="availability-readonly">

            <button type="submit" name="save" class="admin-add-button">Add Product</button>
            <a href="admin_view_products.php" class="admin-products-delete-btn">Cancel</a>
          </form>
        <?php endif; ?>
      </section>
    </div>
  </div>

  <?php include 'backtotop.php'; ?>
</body>
</html>