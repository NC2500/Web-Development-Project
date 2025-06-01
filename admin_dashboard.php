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

// Total Members
$stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM membership");
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $member_count);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Total Enquiries
$stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM enquiry");
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $enquiry_count);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Today's Revenue
$today = date('Y-m-d');
$stmt = mysqli_prepare($conn, "SELECT SUM(amount) FROM topup_history WHERE DATE(created_at) = ?");
mysqli_stmt_bind_param($stmt, "s", $today);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $today_revenue);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
$today_revenue = $today_revenue ?? 0.00;

// Top 5 latest enquiries
$stmt = mysqli_prepare($conn, "SELECT ticket_id, first_name, last_name, email, enquiry_type, submitted_at FROM enquiry WHERE status IN ('Pending') ORDER BY submitted_at DESC LIMIT 5");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$latest_enquiries = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

// Pending job applications (sorted by latest)
$stmt = mysqli_prepare($conn, "SELECT id, first_name, last_name, email, preferred_shift, submitted_at FROM job_application WHERE status = 'Pending' ORDER BY submitted_at DESC");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$pending_jobs = mysqli_fetch_all($result, MYSQLI_ASSOC);
$pending_job_count = count($pending_jobs);
mysqli_stmt_close($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | Brew & Go</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="admin-wrapper">
        <?php include 'admin_sidebar.php'; ?>
        <div class="admin-activities-main">
            <header class="admin-activities-topbar">
                <div class="admin-activities-topbar-left">
                    <span class="admin-activities-topbar-title">Dashboard</span>
                </div>
            </header>
            <!-- Stat Cards -->
            <section class="admin-cards-row">
                <div class="admin-card">
                    <h4>Total Members</h4>
                    <div class="admin-card-stat"><?= htmlspecialchars($member_count) ?></div>
                </div>
                <div class="admin-card">
                    <h4>Today's Revenue</h4>
                    <div class="admin-card-stat">RM <?= number_format($today_revenue, 2) ?></div>
                </div>
                <div class="admin-card">
                    <h4>Total Enquiries</h4>
                    <div class="admin-card-stat"><?= htmlspecialchars($enquiry_count) ?></div>
                </div>
            </section>

            <!-- Pending Job Applications -->
            <section class="admin-table-section">
                <h3>Pending Job Applications <span style="font-size:1em; color:#777;">(<?= $pending_job_count ?>)</span></h3>
                <?php if ($pending_job_count == 0): ?>
                    <div style="color:#888;margin-bottom:1.5em;">No pending job applications.</div>
                <?php else: ?>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Preferred Shift</th>
                                <th>Submitted</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pending_jobs as $job): ?>
                                <tr 
                                    onclick="window.location='admin_view_jobs.php?show=<?= urlencode($job['id']) ?>#<?= htmlspecialchars($job['id']) ?>';" 
                                    style="cursor:pointer"
                                >
                                    <td><?= htmlspecialchars($job['id']) ?></td>
                                    <td><?= htmlspecialchars($job['first_name'] . ' ' . $job['last_name']) ?></td>
                                    <td><?= htmlspecialchars($job['email']) ?></td>
                                    <td><?= htmlspecialchars($job['preferred_shift']) ?></td>
                                    <td><?= htmlspecialchars($job['submitted_at']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </section>

            <!-- Latest Enquiries Table -->
            <section class="admin-table-section">
                <h3>Latest Enquiries</h3>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Submitted</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($latest_enquiries as $row): ?>
                            <tr onclick="window.location='admin_view_enquiries.php?highlight=<?= urlencode($row['ticket_id']) ?>#<?= htmlspecialchars($row['ticket_id']) ?>';" style="cursor:pointer">
                                <td><?= htmlspecialchars($row['ticket_id']) ?></td>
                                <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['enquiry_type']) ?></td>
                                <td><?= htmlspecialchars($row['submitted_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</body>
</html>
