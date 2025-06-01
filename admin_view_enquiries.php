<?php
session_start();
require_once 'connection.php';
require_once 'auth.php';

$currentPage = basename($_SERVER['PHP_SELF']);
date_default_timezone_set('Asia/Kuala_Lumpur');

// Check login and role
if (
    !isset($_SESSION['role_id']) ||
    (!isset($_SESSION['admin_id']) && !isset($_SESSION['user_id']))
) {
    header("Location: login.php");
    exit;
}
if (!checkPagePermission($conn, $currentPage, $_SESSION['role_id'])) {
    header("Location: no_access.php");
    exit;
}

// Handle status update
if (isset($_POST['update_status'], $_POST['enquiry_id'], $_POST['status'])) {
    $enquiry_id = intval($_POST['enquiry_id']);
    $allowed = ['Pending', 'In Progress', 'Resolved'];
    $status = in_array($_POST['status'], $allowed) ? $_POST['status'] : 'Pending';
    $stmt = mysqli_prepare($conn, "UPDATE enquiry SET status = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "si", $status, $enquiry_id);
    mysqli_stmt_execute($stmt);
}

// Fetch by status
// Handle search and sort parameters
$search_name = isset($_GET['search_name']) ? trim($_GET['search_name']) : '';
$search_email = isset($_GET['search_email']) ? trim($_GET['search_email']) : '';
$sort_submitted = isset($_GET['sort_submitted']) ? $_GET['sort_submitted'] : 'desc';

// Helper for filtering an array by search criteria
function filter_enquiries($enquiries, $search_name, $search_email) {
    return array_filter($enquiries, function($row) use ($search_name, $search_email) {
        $name_match = ($search_name === '') ||
            (stripos($row['first_name'] . ' ' . $row['last_name'], $search_name) !== false);
        $email_match = ($search_email === '') ||
            (stripos($row['email'], $search_email) !== false);
        return $name_match && $email_match;
    });
}

function fetchEnquiriesByStatus($conn, $status, $sort = 'desc') {
    $order = $sort === 'asc' ? 'ASC' : 'DESC';
    $stmt = mysqli_prepare($conn, "SELECT * FROM enquiry WHERE status = ? ORDER BY submitted_at $order");
    mysqli_stmt_bind_param($stmt, "s", $status);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $enquiries = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $enquiries[] = $row;
    }
    mysqli_stmt_close($stmt);
    return $enquiries;
}

// Fetch and filter
$pending = filter_enquiries(fetchEnquiriesByStatus($conn, "Pending", $sort_submitted), $search_name, $search_email);
$inprogress = filter_enquiries(fetchEnquiriesByStatus($conn, "In Progress", $sort_submitted), $search_name, $search_email);
$resolved = filter_enquiries(fetchEnquiriesByStatus($conn, "Resolved", $sort_submitted), $search_name, $search_email);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enquiries Admin | Brew & Go</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
<body class="admin-members-body">
    <?php include 'navbar.php' ?>
<div class="admin-wrapper">
    <?php include 'admin_sidebar.php'; ?>
        <div class="admin-activities-main">
        <header class="admin-activities-topbar">
            <div class="admin-activities-topbar-left">
                <span class="admin-activities-topbar-title">All Enquiries</span>
            </div>
            <div class="admin-activities-topbar-right">
                <a href="admin_dashboard.php" class="admin-activities-back-btn">← Back to Dashboard</a>
            </div>
        </header>
    <div class="enquiryadmin-mainwrapper">
        <main class="enquiryadmin-content">
        <div class="admin-search-sort-bar">
            <form class="admin-search-sort-form" method="GET" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="admin-search-sort-row">
                    <div class="admin-search-sort-group">
                        <label class="admin-search-sort-label" for="search_name">Name:</label>
                        <input class="admin-search-sort-input" type="text" id="search_name" name="search_name"
                            value="<?= htmlspecialchars($search_name) ?>" placeholder="Search Name">
                    </div>
                    <div class="admin-search-sort-group">
                        <label class="admin-search-sort-label" for="search_email">Email:</label>
                        <input class="admin-search-sort-input" type="text" id="search_email" name="search_email"
                            value="<?= htmlspecialchars($search_email) ?>" placeholder="Search Email">
                    </div>
                    <div class="admin-search-sort-group">
                        <label class="admin-search-sort-label" for="sort_submitted">Sort by Date:</label>
                        <select class="admin-search-sort-select" id="sort_submitted" name="sort_submitted" onchange="this.form.submit()">
                            <option value="desc" <?= $sort_submitted === 'desc' ? 'selected' : '' ?>>Newest First</option>
                            <option value="asc" <?= $sort_submitted === 'asc' ? 'selected' : '' ?>>Oldest First</option>
                        </select>
                    </div>
                    <button class="admin-search-sort-btn" type="submit">Search</button>
                    <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="admin-clear-search-btn">Clear</a>
                </div>
            </form>
        </div>

            <div class="enquiryadmin-status-wrapper">
                <section class="enquiryadmin-status-col enquiryadmin-pending">
                    <h2>Pending</h2>
                    <?php if (empty($pending)): ?>
                        <div class="enquiryadmin-empty">No pending enquiries.</div>
                    <?php else: ?>
                        <?php foreach ($pending as $row): ?>
                            <?php include 'enquiryadmin_card.php'; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </section>
                <section class="enquiryadmin-status-col enquiryadmin-inprogress">
                    <h2>In Progress</h2>
                    <?php if (empty($inprogress)): ?>
                        <div class="enquiryadmin-empty">No enquiries in progress.</div>
                    <?php else: ?>
                        <?php foreach ($inprogress as $row): ?>
                            <?php include 'enquiryadmin_card.php'; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </section>
                <section class="enquiryadmin-status-col enquiryadmin-resolved">
                    <h2>Resolved</h2>
                    <?php if (empty($resolved)): ?>
                        <div class="enquiryadmin-empty">No resolved enquiries.</div>
                    <?php else: ?>
                        <?php foreach ($resolved as $row): ?>
                            <?php include 'enquiryadmin_card.php'; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </section>
            </div>
        </main>
    </div>
</body>
</html>
