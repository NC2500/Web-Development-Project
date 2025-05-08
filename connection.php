<?php
// ✅ First, define the variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment2_database";

// ✅ Then, use them to connect
$conn = mysqli_connect($servername, $username, $password);

// ✅ Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if (mysqli_query($conn, $sql)) {
    echo "Database created or already exists.<br>";
} else {
    die("Error creating database: " . mysqli_error($conn));
}

// Now connect to the new database
mysqli_select_db($conn, $dbname);

// Create the table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(30) NOT NULL
)";

if (mysqli_query($conn, $sql)) {
    echo "Table users created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

$sql = "SELECT COUNT(*) as count FROM users";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if ($row['count'] == 0) {
    // Table is empty → insert default admin user
    $sql = "INSERT INTO users (username, password) VALUES ('admin', 'admin')";
    if (mysqli_query($conn, $sql)) {
        echo "Default admin user created.<br>";
    } else {
        echo "Error inserting admin user: " . mysqli_error($conn);
    }
} else {
    echo "Admin user already exists or users table is not empty.<br>";
}

mysqli_close($conn);
?>