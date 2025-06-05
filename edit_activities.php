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

// Get activity ID and fetch existing data
$id = intval($_GET['id'] ?? 0);
if (!$id) {
    header("Location: admin_view_activities.php");
    exit;
}
$result = mysqli_query($conn, "SELECT * FROM activities WHERE id = $id LIMIT 1");
$activity = mysqli_fetch_assoc($result);

if (!$activity) {
    header("Location: admin_view_activities.php");
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
    $image_path = $activity['image_path'];

    // Handle image upload (optional)
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = 'uploads/events/';
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $basename = uniqid('event_', true) . '.' . $ext;
        $target_file = $target_dir . $basename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $target_file;
            // Optional: Delete old image file if exists
            if (!empty($activity['image_path']) && file_exists($activity['image_path'])) {
                unlink($activity['image_path']);
            }
        } else {
            $error = "Image upload failed.";
        }
    }

    // Validate required fields
    if (empty($title) || empty($event_date) || empty($start_time) || empty($end_time)) {
        $error = "Please fill in all required fields (title, date, start & end time).";
    }

    // Update in DB
    if (empty($error)) {
        $stmt = mysqli_prepare($conn, "
            UPDATE activities
            SET title=?, description=?, image_path=?, event_date=?, start_time=?, end_time=?, location=?, external_link=?
            WHERE id=?
        ");
        mysqli_stmt_bind_param($stmt, 'ssssssssi', $title, $description, $image_path, $event_date, $start_time, $end_time, $location, $external_link, $id);
        if (mysqli_stmt_execute($stmt)) {
            $success = "Activity updated successfully!";
            header("Location: admin_view_activities.php");
            exit;
        } else {
            $error = "Failed to update activity: " . mysqli_error($conn);
        }
    }
}

// Only allow delete if admin or operator
$is_admin = ($_SESSION['role_id'] ?? 0) == 1;
$is_operator = ($_SESSION['role_id'] ?? 0) == 2;

// Handle Delete (POST for safety)
if (($is_admin || $is_operator) && isset($_POST['delete_activity']) && $_POST['delete_activity'] == '1') {
    $id = intval($_GET['id'] ?? 0);
    if ($id > 0) {
        // Optional: Delete image file as well
        if (!empty($activity['image_path']) && file_exists($activity['image_path'])) {
            unlink($activity['image_path']);
        }
        mysqli_query($conn, "DELETE FROM activities WHERE id = $id");
        header("Location: admin_view_activities.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Activity | Brew & Go Admin</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/admin_view_activities.css">
</head>
<body class="admin-edit-activity-body">
    <?php include 'navbar.php'; ?>
<div class="admin-wrapper">
    <?php include 'admin_sidebar.php';?>
    <div class="admin-activities-main">
        <header class="admin-activities-topbar">
            <div class="admin-activities-topbar-left">
                <span class="admin-activities-topbar-title">Edit Activities</span>
            </div>
            <div class="admin-topbar-right">
                <a href="admin_view_activities.php" class="admin-back-btn">← Back to Activities</a>
            </div>
        </header>
    <div class="admin-add-form">
        <form action="edit_activities.php?id=<?= $activity['id'] ?>" method="post" enctype="multipart/form-data">
            <?php if ($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
            <?php if ($success): ?><div class="success"><?= $success ?></div><?php endif; ?>

            <div class="form-group">
                <label for="title">Title<span style="color:red">*</span></label>
                <input type="text" name="title" id="title" maxlength="255" required value="<?= htmlspecialchars($activity['title']) ?>">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="3"><?= htmlspecialchars($activity['description']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="image">Event Image</label>
                <?php if (!empty($activity['image_path'])): ?>
                    <div style="margin-bottom:10px;">
                        <img src="<?= htmlspecialchars($activity['image_path']) ?>" alt="Current Image" style="height:48px;">
                    </div>
                <?php endif; ?>
                <input type="file" name="image" id="image" accept="image/*">
                <small>Leave empty to keep the current image.</small>
            </div>
            <div class="form-group">
                <label for="event_date">Date<span style="color:red">*</span></label>
                <input type="date" name="event_date" id="event_date" required value="<?= htmlspecialchars($activity['event_date']) ?>">
            </div>
            <div class="form-group">
                <label for="start_time">Start Time<span style="color:red">*</span></label>
                <input type="time" name="start_time" id="start_time" required value="<?= htmlspecialchars($activity['start_time']) ?>">
            </div>
            <div class="form-group">
                <label for="end_time">End Time<span style="color:red">*</span></label>
                <input type="time" name="end_time" id="end_time" required value="<?= htmlspecialchars($activity['end_time']) ?>">
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" id="location" maxlength="255" value="<?= htmlspecialchars($activity['location']) ?>">
            </div>
            <div class="form-group">
                <label for="external_link">External Link</label>
                <input type="url" name="external_link" id="external_link" maxlength="255" value="<?= htmlspecialchars($activity['external_link']) ?>">
            </div>
            <div class="admin-activities-action-btn-row">
                <button type="submit" class="admin-add-button">Save Changes</button>
        </form>
                <?php if ($is_admin || $is_operator): ?>
                    <!-- Delete uses a separate form for safety -->
                    <form method="post" onsubmit="return confirm('Are you sure you want to delete this activity?');" style="display:inline;">
                        <input type="hidden" name="delete_activity" value="1">
                        <button type="submit" class="btn-delete-member">Delete Activity</button>
                    </form>
                <?php endif; ?>
            </div>
    </div>
</div>
</body>
</html>
