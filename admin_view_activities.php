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

// Handle search parameters
$search_title = isset($_GET['search_title']) ? trim($_GET['search_title']) : '';
$search_date = isset($_GET['search_date']) ? trim($_GET['search_date']) : '';

// Build the SQL query with search conditions
$sql = "SELECT * FROM activities WHERE 1=1";
$params = [];
$types = '';

if ($search_title !== '') {
    $sql .= " AND title LIKE ?";
    $params[] = '%' . $search_title . '%';
    $types .= 's';
}

if ($search_date !== '') {
    $sql .= " AND event_date = ?";
    $params[] = $search_date;
    $types .= 's';
}

$sql .= " ORDER BY event_date DESC, start_time DESC";

// Prepare and execute the query
$stmt = mysqli_prepare($conn, $sql);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$today = date('Y-m-d');
$now = date('H:i:s');
$current = [];
$coming = [];
$past = [];

while ($row = mysqli_fetch_assoc($result)) {
    if ($row['event_date'] > $today) {
        $coming[] = $row; // Future events
    } elseif ($row['event_date'] == $today) {
        // Decide if "Current" (ongoing now) or "Past" (ended already)
        if (($row['start_time'] <= $now) && ($now <= $row['end_time'])) {
            $current[] = $row; // Ongoing now
        } elseif ($row['end_time'] < $now) {
            $past[] = $row; // Ended today
        } else {
            $coming[] = $row; // Today but not started yet
        }
    } else {
        $past[] = $row; // Past events
    }
}
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Activities | Brew & Go Admin</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body class="admin-activities-body">
    <?php include 'navbar.php'; ?>
<div class="admin-activities-wrapper">
    <?php include 'admin_sidebar.php';?>
    <div class="admin-activities-main">

        <header class="admin-activities-topbar">
            <div class="admin-activities-topbar-left">
                <span class="admin-activities-topbar-title">Manage Activities</span>
            </div>
            <div class="admin-activities-topbar-right">
                <a href="add_activities.php" class="admin-activities-add-btn" style="margin-left:15px;"> Add New Activity</a>
                <a href="admin_dashboard.php" class="admin-activities-back-btn">← Back to Dashboard</a>
            </div>
        </header>
        
        <section class="admin-activities-panel">
            <div class="admin-search-sort-bar">
                <form method="GET" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div style="display: flex; gap: 15px; align-items: center;">
                        <div>
                            <label for="search_title">Title:</label>
                            <input type="text" id="search_title" name="search_title" value="<?= htmlspecialchars($search_title) ?>" placeholder="Search by Title" style="padding: 5px;">
                        </div>
                        <div>
                            <label for="search_date">Event Date:</label>
                            <input type="date" id="search_date" name="search_date" value="<?= htmlspecialchars($search_date) ?>" style="padding: 5px;">
                        </div>
                        <button type="submit" style="padding: 5px 10px;">Search</button>
                        <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="admin-clear-search-btn">Clear</a>
                    </div>
                </form>
            </div>
            <!-- Current Activities Section -->
            <section class="enquiryadmin-status-col enquiryadmin-pending">
                <h2>Current Activities</h2>
            </section>    
            <?php if (empty($current)): ?>
                <p class="admin-activities-empty"><em>No current activities.</em></p>
            <?php else: ?>
                <table class="admin-activities-table">
                    <thead>
                        <tr>
                            <th>ID</th><th>Title</th><th>Date</th><th>Time</th><th>Location</th>
                            <th>External Link</th><th>Image</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($current as $row): ?>
                            <tr class="admin-activities-row-status-current">
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['title']) ?></td>
                                <td><?= htmlspecialchars($row['event_date']) ?></td>
                                <td><?= htmlspecialchars($row['start_time']) ?> - <?= htmlspecialchars($row['end_time']) ?></td>
                                <td><?= htmlspecialchars($row['location']) ?></td>
                                <td>
                                    <?php if (!empty($row['external_link'])): ?>
                                        <a href="<?= htmlspecialchars($row['external_link']) ?>" target="_blank">Link</a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($row['image_path'])): ?>
                                        <img src="<?= htmlspecialchars($row['image_path']) ?>" alt="Event Image" style="height:42px;">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit_activities.php?id=<?= $row['id'] . '&' . http_build_query([
                                        'search_title' => $search_title,
                                        'search_date' => $search_date
                                    ]) ?>" class="admin-activities-btn-edit">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            <?php endif;?>
        </section>

        <!-- Coming Soon Activities Section -->
        <section class="admin-activities-panel">
            <section class="enquiryadmin-status-col enquiryadmin-pending">
                <h2>Coming Soon</h2>
            </section>             
            <?php if (empty($coming)): ?>
                <p class="admin-activities-empty"><em>No upcoming activities.</em></p>
            <?php else: ?>
                <table class="admin-activities-table">
                    <thead>
                        <tr>
                            <th>ID</th><th>Title</th><th>Date</th><th>Time</th><th>Location</th>
                            <th>External Link</th><th>Image</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($coming as $row): ?>
                            <tr class="admin-activities-row-status-upcoming">
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['title']) ?></td>
                                <td><?= htmlspecialchars($row['event_date']) ?></td>
                                <td><?= htmlspecialchars($row['start_time']) ?> - <?= htmlspecialchars($row['end_time']) ?></td>
                                <td><?= htmlspecialchars($row['location']) ?></td>
                                <td>
                                    <?php if (!empty($row['external_link'])): ?>
                                        <a href="<?= htmlspecialchars($row['external_link']) ?>" target="_blank">Link</a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($row['image_path'])): ?>
                                        <img src="<?= htmlspecialchars($row['image_path']) ?>" alt="Event Image" style="height:42px;">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit_activities.php?id=<?= $row['id'] . '&' . http_build_query([
                                        'search_title' => $search_title,
                                        'search_date' => $search_date
                                    ]) ?>" class="admin-activities-btn-edit">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            <?php endif;?>
        </section>

        <!-- Past Activities Section -->
        <section class="admin-activities-panel">
            <section class="enquiryadmin-status-col enquiryadmin-pending">
                <h2>Past Activities</h2>
            </section> 
            <?php if (empty($past)): ?>
                <p class="admin-activities-empty"><em>No past activities.</em></p>
            <?php else: ?>
                <table class="admin-activities-table">
                    <thead>
                        <tr>
                            <th>ID</th><th>Title</th><th>Date</th><th>Time</th><th>Location</th>
                            <th>External Link</th><th>Image</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($past as $row): ?>
                            <tr class="admin-activities-row-status-past">
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['title']) ?></td>
                                <td><?= htmlspecialchars($row['event_date']) ?></td>
                                <td><?= htmlspecialchars($row['start_time']) ?> - <?= htmlspecialchars($row['end_time']) ?></td>
                                <td><?= htmlspecialchars($row['location']) ?></td>
                                <td>
                                    <?php if (!empty($row['external_link'])): ?>
                                        <a href="<?= htmlspecialchars($row['external_link']) ?>" target="_blank">Link</a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($row['image_path'])): ?>
                                        <img src="<?= htmlspecialchars($row['image_path']) ?>" alt="Event Image" style="height:42px;">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit_activities.php?id=<?= $row['id'] . '&' . http_build_query([
                                        'search_title' => $search_title,
                                        'search_date' => $search_date
                                    ]) ?>" class="admin-activities-btn-edit">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            <?php endif;?>
        </section>
    </div>
</div>
</body>
</html>