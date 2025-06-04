<?php

function log_status($success, $successMsg, $failMsg, $conn = null) {
    if ($success) {
        echo "✅ $successMsg<br>";
    } else {
        echo "❌ $failMsg";
        if ($conn) echo ": " . mysqli_error($conn);
        echo "<br>";
    }
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment_2";

// Connect to MySQL
$conn = mysqli_connect($servername, $username, $password);
if (!$conn) {
    die("❌ Connection failed: " . mysqli_connect_error());
}
echo "✅ Connected to MySQL server.<br>";

// Create database with utf8mb4 charset
$sql = "CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
log_status(mysqli_query($conn, $sql), "Database '$dbname' is ready.", "Error creating database", $conn);

// Select database
mysqli_select_db($conn, $dbname);
echo "✅ Selected database: $dbname<br>";

/* --- 1. Roles Table --- */
echo "<b>// 1. roles: User/Staff/Admin Roles</b><br>";
$sql = "CREATE TABLE IF NOT EXISTS roles (
  id TINYINT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) UNIQUE NOT NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
log_status(mysqli_query($conn, $sql), "Table 'roles' ready.", "Table 'roles' failed", $conn);

// Insert roles if not present
$roles = [1 => 'admin', 2 => 'operator', 3 => 'staff', 4 => 'user'];
foreach ($roles as $id => $name) {
    $check = mysqli_query($conn, "SELECT id FROM roles WHERE id = $id");
    if (mysqli_num_rows($check) === 0) {
        mysqli_query($conn, "INSERT INTO roles (id, name) VALUES ($id, '$name')");
    }
}

/* --- 2. Membership Table --- */
echo "<b>// 2. membership: Member Profile Info</b><br>";
$sql = "CREATE TABLE IF NOT EXISTS membership (
  id INT AUTO_INCREMENT PRIMARY KEY,
  member_id VARCHAR(10) UNIQUE,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  phone VARCHAR(20) UNIQUE,
  address TEXT DEFAULT NULL,
  sex VARCHAR(10) DEFAULT NULL,
  nationality VARCHAR(50) DEFAULT NULL,
  wallet DECIMAL(10,2) DEFAULT 0.00,
  points INT DEFAULT 0,
  profile_picture VARCHAR(255) DEFAULT NULL,
  payment_slip VARCHAR(255) DEFAULT NULL,
  status ENUM('active', 'inactive') DEFAULT 'inactive',
  registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
log_status(mysqli_query($conn, $sql), "Table 'membership' ready.", "Table 'membership' failed", $conn);

/* --- 3. User Table (Login credentials) --- */
echo "<b>// 3. user: Login Credentials (linked to membership, role)</b><br>";
$sql = "CREATE TABLE IF NOT EXISTS user (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  membership_id INT,
  role_id TINYINT DEFAULT 4,
  FOREIGN KEY (membership_id) REFERENCES membership(id) ON DELETE CASCADE,
  FOREIGN KEY (role_id) REFERENCES roles(id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
log_status(mysqli_query($conn, $sql), "Table 'user' ready.", "Table 'user' failed", $conn);

/* --- 4. Admin Table --- */
echo "<b>// 4. admin: Standalone admin login table</b><br>";
$sql = "CREATE TABLE IF NOT EXISTS admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
log_status(mysqli_query($conn, $sql), "Table 'admin' ready.", "Table 'admin' failed", $conn);

// Insert default admin (plain text 'admin')
$check_admin_sql = "SELECT id FROM admin WHERE LOWER(username) = 'admin'";
$check_admin_result = mysqli_query($conn, $check_admin_sql);
if (mysqli_num_rows($check_admin_result) === 0) {
    $insert_admin_sql = "INSERT INTO admin (username, password) VALUES ('admin', 'admin')";
    if (mysqli_query($conn, $insert_admin_sql)) {
        echo "✅ Default admin account created.<br>";
    } else {
        echo "❌ Failed to create default admin: " . mysqli_error($conn) . "<br>";
    }
} else {
    echo "ℹ️ Default admin already exists.<br>";
}

/* --- 5. job_application: Job/Join Us Table --- */
echo "<b>// 5. job_application: Staff/Job Applications</b><br>";
$sql = "CREATE TABLE IF NOT EXISTS job_application (
  id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  phone VARCHAR(20),
  preferred_shift VARCHAR(50),
  address TEXT,
  postcode VARCHAR(10),
  city VARCHAR(100),
  state VARCHAR(100),
  photo_path VARCHAR(255),
  cv_path VARCHAR(255),
  status ENUM('Pending','Accepted','Rejected') DEFAULT 'Pending',
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
log_status(mysqli_query($conn, $sql), "Table 'job_application' ready.", "Table 'job_application' failed", $conn);

/* --- 6. enquiry: Contact/Enquiry Submissions --- */
echo "<b>// 6. enquiry: User Contact/Enquiry Messages</b><br>";
$sql = "CREATE TABLE IF NOT EXISTS enquiry (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ticket_id VARCHAR(20) UNIQUE,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  phone VARCHAR(20),
  address TEXT,
  postcode VARCHAR(10),
  city VARCHAR(100),
  state VARCHAR(100),
  enquiry_type VARCHAR(100),
  message TEXT,
  status ENUM('Pending', 'In Progress', 'Resolved') DEFAULT 'Pending',
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
log_status(mysqli_query($conn, $sql), "Table 'enquiry' ready.", "Table 'enquiry' failed", $conn);

/* --- 7. activities: Events/Blog Posts --- */
echo "<b>// 7. activities: Events & Activities</b><br>";
$sql = "CREATE TABLE IF NOT EXISTS activities (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  image_path VARCHAR(255),
  event_date DATE,
  start_time TIME,
  end_time TIME,
  location VARCHAR(255),
  external_link VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
log_status(mysqli_query($conn, $sql), "Table 'activities' ready.", "Table 'activities' failed", $conn);

/* --- 8. topup_history: Track Each Wallet Top-Up Event --- */
echo "<b>// 10. topup_history: Member Wallet Top-Up Transactions</b><br>";
$sql = "CREATE TABLE IF NOT EXISTS topup_history (
  id INT AUTO_INCREMENT PRIMARY KEY,
  membership_id INT NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (membership_id) REFERENCES membership(id) ON DELETE CASCADE
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
log_status(mysqli_query($conn, $sql), "Table 'topup_history' ready.", "Table 'topup_history' failed", $conn);


/* --- 9. newsletter_subscribers: Newsletter Subscription --- */
$sql = "CREATE TABLE IF NOT EXISTS newsletter_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if (mysqli_query($conn, $sql)) {
    echo "<p style='color:green;'>✅ Table <b>newsletter_subscribers</b> created or already exists.</p>";
} else {
    echo "<p style='color:red;'>❌ Failed to create table: " . mysqli_error($conn) . "</p>";
}


/* --- 10. newsletter_history: Track Sent Newsletters --- */
$sql = "CREATE TABLE IF NOT EXISTS newsletter_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    attachment_path VARCHAR(255),
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
if (mysqli_query($conn, $sql)) {
    echo "<p style='color:green;'>✅ Table <b>newsletter_history</b> created or already exists.</p>";
} else {
    echo "<p style='color:red;'>❌ Failed to create table newsletter_history: " . mysqli_error($conn) . "</p>";
}

/* --- 11. page_permissions: RBAC for admin dashboard --- */
echo "<b>// 9. page_permissions: Role-Page Access</b><br>";
$sql = "CREATE TABLE IF NOT EXISTS page_permissions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  page VARCHAR(100) NOT NULL,
  role_id TINYINT NOT NULL,
  can_view TINYINT(1) NOT NULL DEFAULT 1,
  UNIQUE KEY unique_page_role (page, role_id),
  FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
log_status(mysqli_query($conn, $sql), "Table 'page_permissions' ready.", "Table 'page_permissions' failed", $conn);

// Define all pages and allowed roles for each
$page_perms = [
    // Restricted Pages (specific roles)
    'admin_dashboard.php'   => [1, 2, 3],
    
    'admin_view_enquiries.php' => [1, 2, 3],
    'admin_view_jobs.php'        => [1, 2],
    
    'admin_view_members.php' => [1, 2],
    'add_members.php'       => [1, 2],
    'edit_members.php'      => [1, 2],
    'add_role.php'      => [1,2],
    
    'admin_view_products.php' => [1, 2, 3],
    'add_products.php'    => [1, 2],
    'edit_products.php'   => [1, 2],
    
    'admin_view_activities.php'  => [1, 2, 3],
    'add_activities.php'    => [1, 2],
    'edit_activities.php'   => [1, 2],
    
    'admin_view_newsletter.php'  => [1, 2],
    'admin_view_permissions.php'  => [1], //Super Admin Only
];

// Get all roles (from your roles table)
$role_ids = [];
$result = mysqli_query($conn, "SELECT id FROM roles");
while ($row = mysqli_fetch_assoc($result)) {
    $role_ids[] = $row['id'];
}

// Seed permissions
foreach ($page_perms as $page => $allowed_roles) {
    foreach ($role_ids as $role_id) {
        $can_view = in_array($role_id, $allowed_roles) ? 1 : 0;
        $page_escaped = mysqli_real_escape_string($conn, $page);
        $check = mysqli_query($conn, "SELECT id FROM page_permissions WHERE page='$page_escaped' AND role_id=$role_id");
        if (mysqli_num_rows($check) === 0) {
            $sql = "INSERT INTO page_permissions (page, role_id, can_view) VALUES ('$page_escaped', $role_id, $can_view)";
            mysqli_query($conn, $sql);
        } else {
            $sql = "UPDATE page_permissions SET can_view=$can_view WHERE page='$page_escaped' AND role_id=$role_id";
            mysqli_query($conn, $sql);
        }
    }
}
echo "✅ Page permissions seeded.<br>";

// --- 12. categories: Product Categories --- */
$sql = "CREATE TABLE IF NOT EXISTS categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) UNIQUE NOT NULL
)";
echo mysqli_query($conn, $sql) ? "✅ Table 'categories' ready.<br>" : "❌ " . mysqli_error($conn);

// --- 13. products: Products --- */
$sql = "CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL,
  large_price DECIMAL(10,2) DEFAULT NULL,
  sku VARCHAR(100) UNIQUE,
  category_id INT,
  image_path VARCHAR(255),
  availability ENUM('Available', 'Unavailable') DEFAULT 'Available',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB";
echo mysqli_query($conn, $sql) ? "✅ Table 'products' (with category_id) ready.<br>" : "❌ " . mysqli_error($conn);

// --- Category Populating --- */
$categoryList = ['Basic Brew', 'Artisan Brew', 'Non-Coffee', 'Hot Beverages'];
foreach ($categoryList as $cat) {
    $cat_escaped = mysqli_real_escape_string($conn, $cat);
    $check = mysqli_query($conn, "SELECT id FROM categories WHERE name = '$cat_escaped'");
    if (mysqli_num_rows($check) === 0) {
        mysqli_query($conn, "INSERT INTO categories (name) VALUES ('$cat_escaped')");
    }
}

// --- Product Populating --- */
$products = [
    // [category name, product name, price, large price, image file]
    ['Basic Brew', 'Americano', 8.90, 10.90, 'Iced Americano.jpeg'],
    ['Basic Brew', 'Latte', 10.90, 12.90, 'Hot Latte.jpeg'],
    ['Basic Brew', 'Cappuccino', 11.90, 13.90, 'Iced Cappuccino.jpeg'],
    ['Basic Brew', 'Aerocano', 10.90, 12.90, 'Aerocano.jpeg'],
    ['Basic Brew', 'Aero-latte', 12.90, 14.90, 'Aero Latte.jpeg'],

    ['Artisan Brew', 'Butterscotch Creme', 14.90, 16.90, 'Butterscotch Latte.jpeg'],
    ['Artisan Brew', 'Butterscotch Latte', 11.90, 13.90, 'Butterscotch Latte.jpeg'],
    ['Artisan Brew', 'Mint Latte', 12.90, 14.90, 'Mint Chocolate.jpeg'],
    ['Artisan Brew', 'Vienna Latte', 14.90, 16.90, 'Vienna Latte.jpeg'],
    ['Artisan Brew', 'Pistachio Latte', 15.90, 17.90, 'Pistachio Latte.jpeg'],
    ['Artisan Brew', 'Strawberry Latte', 14.90, 16.90, 'Strawberry Latte.jpeg'],
    ['Artisan Brew', 'Mocha', 11.90, 13.90, 'Mocha.jpeg'],
    ['Artisan Brew', 'Mint Mocha', 12.90, 14.90, 'Mint Chocolate.jpeg'],
    ['Artisan Brew', 'Orange Mocha', 12.90, 14.90, 'Orange Mocha.jpeg'],
    ['Artisan Brew', 'Yuzu Americano', 13.90, 15.90, 'Yuzu Americano.jpeg'],
    ['Artisan Brew', 'Cheese Americano', 13.90, 15.90, 'Cheese Americano.jpeg'],
    ['Artisan Brew', 'Orange Americano', 13.90, 15.90, 'Orange Americano.jpeg'],

    ['Non-Coffee', 'Chocolate', 13.90, 15.90, 'Chocolate Latte.jpeg'],
    ['Non-Coffee', 'Mint Chocolate', 13.90, 15.90, 'Mint Chocolate.jpeg'],
    ['Non-Coffee', 'Orange Chocolate', 13.90, 15.90, 'Orange Chocolate.jpeg'],
    ['Non-Coffee', 'Strawberry Soda', 13.90, 15.90, 'Strawberry Latte.jpeg'],
    ['Non-Coffee', 'Yuzu Cheese', 13.90, 15.90, 'Cheese Americano.jpeg'],
    ['Non-Coffee', 'Yuri Matcha', 13.90, 15.90, 'Yuri Matcha Latte.jpeg'],
    ['Non-Coffee', 'Strawberry Matcha', 14.90, 16.90, 'Strawberry Matcha.jpeg'],
    ['Non-Coffee', 'Houjicha', 13.90, 15.90, 'Iced Houjicha.jpeg'],

    ['Hot Beverages', 'Americano', 7.90, 9.90, 'Hot Americano.jpeg'],
    ['Hot Beverages', 'Latte', 9.90, 11.90, 'Hot Latte.jpeg'],
    ['Hot Beverages', 'Butterscotch Latte', 10.90, 12.90, 'Hot Butterscotch Latte.jpeg'],
    ['Hot Beverages', 'Cappuccino', 10.90, 12.90, 'Iced Cappuccino.jpeg'],
    ['Hot Beverages', 'Chocolate', 12.90, 14.90, 'Chocolate Latte.jpeg'],
    ['Hot Beverages', 'Yuri Matcha', 13.90, 15.90, 'Hot Yuri Matcha.jpeg'],
    ['Hot Beverages', 'Houjicha', 13.90, 14.90, 'Hot Houjicha.jpeg'],
];


// ✅ Prepared insert with category_id lookup
foreach ($products as [$category, $name, $price, $large, $filename]) {
    $sku = strtoupper(str_replace(' ', '_', $category . '_' . $name));
    $escaped_name = mysqli_real_escape_string($conn, $name);
    $escaped_category = mysqli_real_escape_string($conn, $category);
    $image_path = mysqli_real_escape_string($conn, "images/coffee/" . $filename);

    // Fetch category_id
    $cat_result = mysqli_query($conn, "SELECT id FROM categories WHERE name = '$escaped_category'");
    $cat_row = mysqli_fetch_assoc($cat_result);
    $category_id = $cat_row['id'] ?? 'NULL';

    $check = mysqli_query($conn, "SELECT id FROM products WHERE name = '$escaped_name' AND category_id = $category_id");
    if (mysqli_num_rows($check) === 0) {
        $insert = "
        INSERT INTO products (name, price, large_price, sku, category_id, image_path)
        VALUES ('$escaped_name', $price, $large, '$sku', $category_id, '$image_path')";
        mysqli_query($conn, $insert);
    }
}
echo "✅ Product migration complete: menu items inserted.<br>";

// --- Activities Populating ---
$activities = [
    ['Seni Kita Weekend 4.0', 'Celebrate arts and community with Seni Kita Weekend 4.0. Enjoy live music, art workshops, and more.', 'images/CS/Seni Kita Weekend 4.0 v1.jpg', '2025-06-20', '10:00:00', '18:00:00', 'Cultural Hall', 'https://instagram.com/seni_kita_4'],
    ['Grand Opening 2.0', 'Our grand opening 2.0 celebration with exclusive drinks and giveaways.', 'images/Current/Grand Opening 2.0 v1.jpg', '2025-06-04', '09:00:00', '21:00:00', 'Main Branch', 'https://brewngo.coffee/grand-opening-2'],
    ['Seni Kita Weekend 1.0', 'Highlights of Seni Kita Weekend 1.0 where creativity and coffee met.', 'images/Past/Seni Kita Weekend 1.0 v1.jpg', '2024-03-12', '11:00:00', '17:00:00', 'Community Park', 'https://instagram.com/seni_kita_1'],
    ['Seni Kita Weekend 2.0', 'Bigger and better: Seni Kita Weekend 2.0 brought together more artists and coffee lovers.', 'images/Past/Seni Kita Weekend 2.0 v1.jpg', '2024-06-18', '10:00:00', '18:00:00', 'Art District', 'https://instagram.com/seni_kita_2'],
    ['Seni Kita Weekend 3.0', 'A celebration of local talents, coffee artistry, and live performances.', 'images/Past/Seni Kita Weekend 3.0 v1.jpg', '2024-10-05', '12:00:00', '20:00:00', 'Downtown Stage', 'https://instagram.com/seni_kita_3'],
    ['Kuching Christmas Bazaar', 'Christmas-themed drinks, gifts, and live music at the annual bazaar.', 'images/Past/Kuching Christmas Bazaar.jpg', '2024-12-15', '10:00:00', '22:00:00', 'Waterfront Plaza', 'https://instagram.com/christmas_bazaar'],
    ['Neurosurgical Health Conference', 'Partnered health event featuring our signature wellness drinks.', 'images/Past/Neurosurgical Association Malaysia Health Conference.mp4', '2024-09-10', '09:00:00', '17:00:00', 'Medical Hall', 'https://instagram.com/health_conf'],
    ['Grand Opening 1.0', 'Throwback to our very first grand opening and ribbon-cutting.', 'images/Past/Grand Opening.jpg', '2023-05-01', '09:00:00', '18:00:00', 'Main Branch', ''],
    ['Christmas Dreamville', 'A magical Christmas event with themed drinks and live caroling.', 'images/Past/Christmas Dreamville.mp4', '2023-12-20', '15:00:00', '22:00:00', 'Dreamville Cafe', 'https://instagram.com/dreamville_xmas'],
];

foreach ($activities as $activity) {
    $stmt = $conn->prepare("INSERT INTO activities (title, description, image_path, event_date, start_time, end_time, location, external_link) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $activity[0], $activity[1], $activity[2], $activity[3], $activity[4], $activity[5], $activity[6], $activity[7]);
    $stmt->execute();
}
echo "✅ Activity migration complete: events inserted.<br>";
mysqli_close($conn);
?>
