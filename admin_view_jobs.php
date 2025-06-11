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

// Handle search and filter parameters
$search_name = isset($_GET['search_name']) ? trim($_GET['search_name']) : '';
$search_email = isset($_GET['search_email']) ? trim($_GET['search_email']) : '';
$filter_status = isset($_GET['filter_status']) ? $_GET['filter_status'] : '';
$filter_shift = isset($_GET['filter_shift']) ? $_GET['filter_shift'] : '';

// Handle status update
if (isset($_POST['update_status'], $_POST['job_id'], $_POST['status'])) {
    $job_id = intval($_POST['job_id']);
    $allowed = ['Pending', 'Accepted', 'Rejected'];
    $status = in_array($_POST['status'], $allowed) ? $_POST['status'] : 'Pending';
    $stmt = mysqli_prepare($conn, "UPDATE job_application SET status = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "si", $status, $job_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    // Redirect to preserve search/filter state
    $query_params = http_build_query([
        'search_name' => $search_name,
        'search_email' => $search_email,
        'filter_status' => $filter_status,
        'filter_shift' => $filter_shift
    ]);
    header("Location: $currentPage" . ($query_params ? '?' . $query_params : ''));
    exit;
}

// Build the SQL query with search and filter
$sql = "SELECT * FROM job_application WHERE 1=1";
$params = [];
$types = '';

if ($search_name !== '') {
    $sql .= " AND CONCAT(first_name, ' ', last_name) LIKE ?";
    $params[] = '%' . $search_name . '%';
    $types .= 's';
}

if ($search_email !== '') {
    $sql .= " AND email LIKE ?";
    $params[] = '%' . $search_email . '%';
    $types .= 's';
}

if (in_array($filter_status, ['Pending', 'Accepted', 'Rejected'])) {
    $sql .= " AND status = ?";
    $params[] = $filter_status;
    $types .= 's';
}

if (in_array($filter_shift, ['Morning', 'Evening'])) {
    $sql .= " AND preferred_shift = ?";
    $params[] = $filter_shift;
    $types .= 's';
}

// Default sorting by submitted_at DESC
$sql .= " ORDER BY submitted_at DESC";

// Prepare and execute the query
$stmt = mysqli_prepare($conn, $sql);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$jobs = [];
while ($row = mysqli_fetch_assoc($result)) {
    $jobs[] = $row;
}
mysqli_stmt_close($stmt);

$edit_id = isset($_GET['edit']) ? intval($_GET['edit']) : 0;
$show_id = isset($_GET['show']) ? intval($_GET['show']) : 0;

function renderJobTable($jobs, $show_id, $edit_id, $search_name, $search_email, $filter_status, $filter_shift)
{
    if (empty($jobs)) {
        echo "<tr class='admin-table-row'><td colspan='8'>No applications found.</td></tr>";
        return;
    }
    foreach ($jobs as $row):
        $expanded = ($show_id === intval($row['id']));
        $editing = ($edit_id === intval($row['id']));
        ?>
        <tr class="admin-table-row row-status-<?= strtolower($row['status']) ?>">
            <td class="admin-td"><?= htmlspecialchars($row['id']) ?></td>
            <td class="admin-td"><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
            <td class="admin-td"><?= htmlspecialchars($row['email']) ?></td>
            <td class="admin-td"><?= htmlspecialchars($row['phone']) ?></td>
            <td class="admin-td"><?= htmlspecialchars($row['preferred_shift']) ?></td>
            <td class="admin-td"><?= htmlspecialchars($row['submitted_at']) ?></td>
            <td class="admin-td" style="text-align:center;">
                <form method="post" style="display:inline;">
                    <input type="hidden" name="job_id" value="<?= $row['id'] ?>">
                    <input type="hidden" name="search_name" value="<?= htmlspecialchars($search_name) ?>">
                    <input type="hidden" name="search_email" value="<?= htmlspecialchars($search_email) ?>">
                    <input type="hidden" name="filter_status" value="<?= htmlspecialchars($filter_status) ?>">
                    <input type="hidden" name="filter_shift" value="<?= htmlspecialchars($filter_shift) ?>">
                    <select name="status"
                        class="status-pill <?= strtolower($row['status']) ?>"
                        style="min-width:105px;">
                        <option value="Pending"   <?= $row['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="Accepted"  <?= $row['status'] == 'Accepted' ? 'selected' : '' ?>>Accepted</option>
                        <option value="Rejected"  <?= $row['status'] == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                    </select>
                    <input type="hidden" name="update_status" value="1">
                </form>
            </td>
            <td class="admin-td">
                <?php if ($expanded): ?>
                    <a href="<?= htmlspecialchars($_SERVER['PHP_SELF'] . '?' . http_build_query([
                        'search_name' => $search_name,
                        'search_email' => $search_email,
                        'filter_status' => $filter_status,
                        'filter_shift' => $filter_shift
                    ])) ?>" class="btn-preview-pdf">Hide</a>
                <?php else: ?>
                    <a href="<?= htmlspecialchars($_SERVER['PHP_SELF'] . '?' . http_build_query([
                        'show' => $row['id'],
                        'search_name' => $search_name,
                        'search_email' => $search_email,
                        'filter_status' => $filter_status,
                        'filter_shift' => $filter_shift
                    ])) ?>" class="btn-preview-pdf">View</a>
                <?php endif; ?>
            </td>
        </tr>
        
        <?php if ($expanded): ?>
        <tr class="admin-details-row">
            <td colspan="8" class="admin-details-td">
                <div class="admin-details-card" style="display:flex; gap:32px;">
                    <div class="admin-details-photo-col" style="min-width:170px;">
                        <img src="<?= $row['photo_path'] ? htmlspecialchars($row['photo_path']) : 'images/default-profile.png' ?>" 
                            alt="Applicant Photo" 
                            class="job-photo">
                            <table class="admin-details-table" style="margin-bottom:24px;">
                                <tr><td><b>Name</b></td><td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td></tr>
                                <tr><td><b>Email</b></td><td><?= htmlspecialchars($row['email']) ?></td></tr>
                                <tr><td><b>Phone</b></td><td><?= htmlspecialchars($row['phone']) ?></td></tr>
                                <tr><td><b>Shift</b></td><td><?= htmlspecialchars($row['preferred_shift']) ?></td></tr>
                                <tr><td><b>Address</b></td><td><?= htmlspecialchars($row['address']) ?></td></tr>
                                <tr><td><b>Postcode</b></td><td><?= htmlspecialchars($row['postcode']) ?></td></tr>
                                <tr><td><b>City</b></td><td><?= htmlspecialchars($row['city']) ?></td></tr>
                                <tr><td><b>State</b></td><td><?= htmlspecialchars($row['state']) ?></td></tr>
                                <tr><td><b>Submitted</b></td><td><?= htmlspecialchars($row['submitted_at']) ?></td></tr>
                            </table>
                    </div>
                    <div class="admin-details-info-col" style="flex:1;">
                        <div class="admin-cv-section">
                            <h4 style="margin:6px 0 12px;">CV / Resume</h4>
                            <?php if (!empty($row['cv_path']) && strtolower(pathinfo($row['cv_path'], PATHINFO_EXTENSION)) === 'pdf'): ?>
                                <embed src="<?= htmlspecialchars($row['cv_path']) ?>" type="application/pdf" class="job-pdf-preview" />
                                <div style="margin-top:8px;">
                                    <a href="<?= htmlspecialchars($row['cv_path']) ?>" target="_blank" class="btn btn-pdf">Open PDF in New Tab</a>
                                    <a href="<?= htmlspecialchars($row['cv_path']) ?>" download class="btn btn-pdf">Download</a>
                                </div>
                            <?php elseif (!empty($row['cv_path'])): ?>
                                <a href="<?= htmlspecialchars($row['cv_path']) ?>" download class="btn btn-pdf">Download CV</a>
                            <?php else: ?>
                                <span class="admin-no-cv">No CV uploaded.</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <?php endif; ?>
        <?php
        endforeach;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Job Applications | Brew & Go Admin</title>
    <link rel="stylesheet" href="styles/style.css" />
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="admin-wrapper">
        <?php include 'admin_sidebar.php'; ?>
        <div class="admin-activities-main">
            <header class="admin-activities-topbar">
                <div class="admin-activities-topbar-left">
                    <span class="admin-activities-topbar-title">All Job Applications</span>
                </div>
                <div class="admin-activities-topbar-right">
                    <a href="admin_dashboard.php" class="admin-activities-back-btn">← Back to Dashboard</a>
                </div>
            </header>
            <div class="aside-right">
                <aside class="status-legend">
                    <strong>Status Legend:</strong>
                    <span class="legend-box row-status-pending">Pending</span>
                    <span class="legend-box row-status-accepted">Accepted</span>
                    <span class="legend-box row-status-rejected">Rejected</span>
                </aside>
            </div>
                            <div class="admin-search-sort-bar">
                    <form method="GET" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div style="display: flex; gap: 15px; align-items: center;">
                            <div>
                                <label for="search_name">Name:</label>
                                <input type="text" id="search_name" name="search_name" value="<?= htmlspecialchars($search_name) ?>" placeholder="Search by Name" style="padding: 5px;">
                            </div>
                            <div>
                                <label for="search_email">Email:</label>
                                <input type="text" id="search_email" name="search_email" value="<?= htmlspecialchars($search_email) ?>" placeholder="Search by Email" style="padding: 5px;">
                            </div>
                            <div>
                                <label for="filter_status">Filter by Status:</label>
                                <select id="filter_status" name="filter_status" style="padding: 5px;">
                                    <option value="" <?= $filter_status === '' ? 'selected' : ''; ?>>All Statuses</option>
                                    <option value="Pending" <?= $filter_status === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="Accepted" <?= $filter_status === 'Accepted' ? 'selected' : ''; ?>>Accepted</option>
                                    <option value="Rejected" <?= $filter_status === 'Rejected' ? 'selected' : ''; ?>>Rejected</option>
                                </select>
                            </div>
                            <div>
                                <label for="filter_shift">Filter by Preferred Shift:</label>
                                <select id="filter_shift" name="filter_shift" style="padding: 5px;">
                                    <option value="" <?= $filter_shift === '' ? 'selected' : ''; ?>>All Shifts</option>
                                    <option value="Morning" <?= $filter_shift === 'Morning' ? 'selected' : ''; ?>>Morning</option>
                                    <option value="Evening" <?= $filter_shift === 'Evening' ? 'selected' : ''; ?>>Evening</option>
                                </select>
                            </div>
                            <button type="submit" style="padding: 5px 10px;">Search</button>
                            <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="admin-clear-search-btn">Clear</a>
                        </div>
                    </form>
                </div>
            <table class="admin-table">
                <thead>
                <tr>
                    <th class="admin-th">ID</th>
                    <th class="admin-th">Name</th>
                    <th class="admin-th">Email</th>
                    <th class="admin-th">Phone</th>
                    <th class="admin-th">Preferred Shift</th>
                    <th class="admin-th">Submitted</th>
                    <th class="admin-th">Status (Update)</th>
                    <th class="admin-th">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php renderJobTable($jobs, $show_id, $edit_id, $search_name, $search_email, $filter_status, $filter_shift); ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>