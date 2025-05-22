<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Basic sanitization and validation
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);

    // Validate required fields
    if (
        empty($first_name) || empty($last_name) || empty($email) ||
        empty($login) || empty($password) || !filter_var($email, FILTER_VALIDATE_EMAIL)
    ) {
        die("❌ Invalid form data. Please go back and correct the input.");
    }

    // File Upload Handling
    if (isset($_FILES['payment_slip']) && $_FILES['payment_slip']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
        $file_type = $_FILES['payment_slip']['type'];
        $file_tmp = $_FILES['payment_slip']['tmp_name'];
        $file_name = basename($_FILES['payment_slip']['name']);
        $upload_dir = 'uploads/';

        // Create the uploads folder if it doesn't exist
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Check MIME type
        if (!in_array($file_type, $allowed_types)) {
            die("❌ Invalid file type. Only JPG, PNG, and PDF are allowed.");
        }

        $target_path = $upload_dir . uniqid() . "_" . $file_name;
        move_uploaded_file($file_tmp, $target_path);
    } else {
        die("❌ File upload failed.");
    }

    // Database Connection
    $conn = new mysqli("localhost", "username", "password", "database_name");
    if ($conn->connect_error) {
        die("❌ Connection failed: " . $conn->connect_error);
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO membership (full_name, email, address, membership_type, phone, start_date) VALUES (?, ?, '', 'Basic', '', CURDATE())");
    $full_name = $first_name . " " . $last_name;
    $stmt->bind_param("ss", $full_name, $email);

    if ($stmt->execute()) {
        echo "<h2>✅ Membership registration successful!</h2>";
        echo "<p>Thank you, $full_name, for joining Brew & Go.</p>";
        echo "<a href='membership.php'>Return to Membership Page</a>";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "❌ Invalid access.";
}
?>
