<?php
require_once 'connection.php';

// Check if product ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}

$product_id = (int)$_GET['id'];

// Fetch product details
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Product not found.");
}

$product = mysqli_fetch_assoc($result);

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

// Handle form submission for editing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $large_price = floatval($_POST['large_price']);
    $sku = mysqli_real_escape_string($conn, $_POST['sku']);
    $category_id = (int)$_POST['category_id'];
    $availability = mysqli_real_escape_string($conn, $_POST['availability']);

    // Handle image upload if a new file is provided
    $image_path = $product['image_path']; // Default to current image path
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
                $image_path = $target_file; // Update image path to the new file
            } else {
                $error_message = "Failed to upload image.";
            }
        } else {
            $error_message = "Only JPG, JPEG, PNG, and GIF files are allowed.";
        }
    }

    if (empty($error_message)) {
        $update_sql = "UPDATE products SET 
            name = ?, 
            description = ?, 
            price = ?, 
            large_price = ?, 
            sku = ?, 
            category_id = ?, 
            image_path = ?, 
            availability = ?
            WHERE id = ?";
        $update_stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "ssdssisss", $name, $description, $price, $large_price, $sku, $category_id, $image_path, $availability, $product_id);

        if (mysqli_stmt_execute($update_stmt)) {
            $success_message = "Product updated successfully!";
            // Refresh product data to reflect changes
            mysqli_stmt_close($stmt);
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $product_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $product = mysqli_fetch_assoc($result);
        } else {
            $error_message = "Failed to update product.";
        }
        mysqli_stmt_close($update_stmt);
    }
}

// Handle delete action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    if (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] === 'yes') {
        $delete_sql = "DELETE FROM products WHERE id = ?";
        $delete_stmt = mysqli_prepare($conn, $delete_sql);
        mysqli_stmt_bind_param($delete_stmt, "i", $product_id);

        if (mysqli_stmt_execute($delete_stmt)) {
            $success_message = "Product deleted successfully! Return to the <a href='admin_view_products.php'>product list</a>.";
        } else {
            $error_message = "Failed to delete product.";
        }
        mysqli_stmt_close($delete_stmt);
    }
}

mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="author" content="Admin" />
  <title>Admin - Edit Product - Brew & Go</title>
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
          <span class="admin-activities-topbar-title">Edit Product</span>
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

        <!-- Image Preview -->
        <?php if (empty($success_message) || strpos($success_message, 'deleted') === false): ?>
          <div class="admin-products-image-preview">
            <?php if (!empty($product['image_path'])): ?>
              <label for="image">
                <img src="<?= htmlspecialchars($product['image_path']) ?>" alt="<?= htmlspecialchars($product['name']) ?> Image">
              </label>
            <?php else: ?>
              <label for="image">
                <p>No image available. Click to upload one.</p>
              </label>
            <?php endif; ?>
          </div>

          <form method="POST" action="" enctype="multipart/form-data">
            <input type="file" id="image" name="image" style="display: none;" accept="image/jpeg,image/png,image/gif">

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

            <label for="description">Description:</label>
            <input type="text" id="description" name="description" value="<?= htmlspecialchars($product['description']) ?>">

            <label for="price">Price:</label>
            <input type="number" step="0.01" id="price" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>

            <label for="large_price">Large Price:</label>
            <input type="number" step="0.01" id="large_price" name="large_price" value="<?= htmlspecialchars($product['large_price']) ?>" required>

            <label for="sku">SKU:</label>
            <input type="text" id="sku" name="sku" value="<?= htmlspecialchars($product['sku']) ?>" required>

            <label for="category_id">Category:</label>
            <select id="category_id" name="category_id" required>
              <?php foreach ($categories as $category): ?>
                <option value="<?= htmlspecialchars($category['id']) ?>" 
                        <?= $category['id'] == $product['category_id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($category['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>

            <label for="availability">Availability:</label>
            <input type="text" id="availability" name="availability" value="<?= htmlspecialchars($product['availability']) ?>" required>

            <button type="submit" name="save" class="admin-add-button">Save Changes</button>
            <button type="submit" name="delete" formnovalidate class="btn-delete-member">Delete Product</button>
            <a href="admin_view_products.php" class="admin-products-delete-btn">Cancel</a>
          </form>

          <!-- Delete Confirmation Form -->
          <?php if (isset($_POST['delete']) && !isset($_POST['confirm_delete'])): ?>
            <form method="POST" action="" style="margin-top: 20px;">
              <p>Are you sure you want to delete <?= htmlspecialchars($product['name']) ?>?</p>
              <input type="hidden" name="confirm_delete" value="yes">
              <button type="submit" name="delete" class="btn-delete-member">Yes, Delete</button>
              <a href="edit_products.php?id=<?= $product_id ?>" class="admin-products-delete-btn">No, Cancel</a>
            </form>
          <?php endif; ?>
        <?php endif; ?>
      </section>
    </div>
  </div>

  <?php include 'backtotop.php'; ?>
</body>
</html>