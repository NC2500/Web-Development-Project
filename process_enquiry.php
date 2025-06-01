<?php
session_start();
require_once 'connection.php';

function clean($data) {
    return htmlspecialchars(trim($data));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = clean($_POST['first_name'] ?? '');
    $last_name = clean($_POST['last_name'] ?? '');
    $email = clean($_POST['email'] ?? '');
    $street = clean($_POST['street'] ?? '');
    $city = clean($_POST['city'] ?? '');
    $state = clean($_POST['state'] ?? '');
    $postcode = clean($_POST['postcode'] ?? '');
    $phone = clean($_POST['phone'] ?? '');
    $enquiry_type = clean($_POST['enquiry_type'] ?? '');
    $message = clean($_POST['message'] ?? '');

    // Required fields validation
    if (!$first_name || !$last_name || !$email || !$street || !$city || !$state || !$postcode || !$phone || !$enquiry_type || !$message) {
        $_SESSION['enquiry_error'] = "All required fields must be filled in!";
        $_SESSION['enquiry_form'] = $_POST;
        header("Location: enquiry.php");
        exit;
    }

    $address = $street;

    // 1. Insert row without ticket_id
    $sql = "INSERT INTO enquiry 
        (first_name, last_name, email, phone, address, postcode, city, state, enquiry_type, message)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssssss",
        $first_name, $last_name, $email, $phone, $address, $postcode, $city, $state, $enquiry_type, $message);

    if (mysqli_stmt_execute($stmt)) {
        // 2. Get inserted id and generate ticket_id
        $enquiry_id = mysqli_insert_id($conn);
        $ticket_id = 'ENQ-' . str_pad($enquiry_id, 5, '0', STR_PAD_LEFT);

        // 3. Update ticket_id for this row
        $update_sql = "UPDATE enquiry SET ticket_id = ? WHERE id = ?";
        $update_stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "si", $ticket_id, $enquiry_id);
        mysqli_stmt_execute($update_stmt);

        // Success message
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Enquiry Submitted | Brew & Go</title>
            <link rel="stylesheet" href="styles/style.css">
            <meta http-equiv="refresh" content="3;url=main.php">
        </head>
        <body>
        <div class="response-container">
            <div class="response-success">Your enquiry was submitted successfully!<br>Ticket ID: <?= htmlspecialchars($ticket_id) ?></div>
            <a href="main.php"><button class="response-btn">Back to Home</button></a>
            <div class="login-confirm-redirect">You will be redirected in 3 seconds...</div>
        </div>
        </body>
        </html>
        <?php
        exit;
    } else {
        $_SESSION['enquiry_error'] = "Failed to submit enquiry: " . mysqli_error($conn);
        $_SESSION['enquiry_form'] = $_POST;
        header("Location: enquiry.php");
        exit;
    }
} else {
    header("Location: enquiry.php");
    exit;
}
