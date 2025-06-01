<?php
session_start();
require_once 'connection.php';
require_once 'auth.php';

$currentPage = basename($_SERVER['PHP_SELF']);

// Set timezone for correct revenue date calculation!
date_default_timezone_set('Asia/Kuala_Lumpur');

// Check login and role
if (
    !isset($_SESSION['role_id']) || 
    (!isset($_SESSION['admin_id']) && !isset($_SESSION['user_id']))
) {
    header("Location: login.php");
    exit;
}

// **Check page permission by role!**
if (!checkPagePermission($conn, $currentPage, $_SESSION['role_id'])) {
    header("Location: no_access.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect fields
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $event_date = $_POST['event_date'] ?? '';
    $start_time = $_POST['start_time'] ?? '';
    $end_time = $_POST['end_time'] ?? '';
    $location = trim($_POST['location'] ?? '');
    $external_link = trim($_POST['external_link'] ?? '');
    $image_path = '';

    // Image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $target_dir = 'uploads/events/';
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $basename = uniqid('event_', true) . '.' . $ext;
        $target_file = $target_dir . $basename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $target_file;
        } else {
            $error = "Image upload failed.";
        }
    }

    // Validate required fields
    if (empty($title) || empty($event_date) || empty($start_time) || empty($end_time)) {
        $error = "Please fill in all required fields (title, date, start & end time).";
    }

    // Insert into DB
    if (empty($error)) {
        $stmt = mysqli_prepare($conn, "
            INSERT INTO activities 
            (title, description, image_path, event_date, start_time, end_time, location, external_link)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        mysqli_stmt_bind_param($stmt, 'ssssssss', $title, $description, $image_path, $event_date, $start_time, $end_time, $location, $external_link);
        if (mysqli_stmt_execute($stmt)) {
            $success = "Activity added successfully!";
            header("Location: admin_view_activities.php");
            exit;
        } else {
            $error = "Failed to add activity: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Activity | Brew & Go Admin</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body class="admin-add-activity-body">
    <?php include 'navbar.php'; ?>
<div class="admin-wrapper">
    <?php include 'admin_sidebar.php';?>
    <div class="admin-main">
        <header class="admin-topbar">
            <div class="admin-topbar-left">
                <span class="admin-topbar-title">Add New Activity</span>
            </div>
            <div class="admin-topbar-right">
                <a href="admin_view_activities.php" class="admin-back-btn">← Back to Activities</a>
            </div>
        </header>

        <form class="admin-add-form" action="add_activities.php" method="post" enctype="multipart/form-data">
            <?php if ($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
            <?php if ($success): ?><div class="success"><?= $success ?></div><?php endif; ?>

            <div class="form-group">
                <label for="title">Title<span style="color:red">*</span></label>
                <input type="text" name="title" id="title" maxlength="255" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="image">Event Image</label>
                <input type="file" name="image" id="image" accept="image/*">
            </div>
            <div class="form-group">
                <label for="event_date">Date<span style="color:red">*</span></label>
                <input type="date" name="event_date" id="event_date" required>
            </div>
            <div class="form-group">
                <label for="start_time">Start Time<span style="color:red">*</span></label>
                <input type="time" name="start_time" id="start_time" required>
            </div>
            <div class="form-group">
                <label for="end_time">End Time<span style="color:red">*</span></label>
                <input type="time" name="end_time" id="end_time" required>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" id="location" maxlength="255">
            </div>
            <div class="form-group">
                <label for="external_link">External Link</label>
                <input type="url" name="external_link" id="external_link" maxlength="255">
            </div>
            <button type="submit">Add Activity</button>
        </form>
    </div>
</div>
</body>
</html>
