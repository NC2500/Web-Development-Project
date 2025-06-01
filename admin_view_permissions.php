<?php
session_start();
require_once 'connection.php';
require_once 'auth.php';

$currentPage = basename($_SERVER['PHP_SELF']);

// Set timezone for correct date calculation!
date_default_timezone_set('Asia/Kuala_Lumpur');

// Check login and role
if (
    !isset($_SESSION['role_id']) || 
    (!isset($_SESSION['admin_id']) && !isset($_SESSION['user_id']))
) {
    header("Location: login.php");
    exit;
}

// Check page permission by role!
if (!checkPagePermission($conn, $currentPage, $_SESSION['role_id'])) {
    header("Location: no_access.php");
    exit;
}

// Handle search parameter
$search_page = isset($_GET['search_page']) ? trim($_GET['search_page']) : '';

// List all pages for management
$page_perms = [
    'admin_dashboard.php',
    'admin_view_enquiries.php',
    'admin_view_jobs.php',
    'admin_view_members.php',
    'add_members.php',
    'edit_members.php',
    'add_role.php',
    'admin_view_activities.php',
    'add_activities.php',
    'edit_activities.php',
    'admin_view_newsletter.php',
    'admin_view_permissions.php',
    'admin_view_products.php',
    'add_products.php',
    'edit_products.php',
];

// Filter pages based on search
$filtered_pages = array_filter($page_perms, function($page) use ($search_page) {
    if ($search_page === '') {
        return true;
    }
    return stripos($page, $search_page) !== false;
});

// Fetch all roles
$roles = [];
$res = mysqli_query($conn, "SELECT id, name FROM roles ORDER BY id ASC");
while ($row = mysqli_fetch_assoc($res)) {
    $roles[$row['id']] = ucfirst($row['name']);
}

// Handle permission toggle (Allow/Deny)
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['page'], $_POST['role_id'])) {
    $page = $_POST['page'];
    $role_id = intval($_POST['role_id']);
    $can_view = isset($_POST['can_view']) && $_POST['can_view'] == '1' ? 1 : 0;

    // Validate page
    if (!in_array($page, $page_perms)) {
        $message = "<span style='color:#c0392b;'>Invalid page selected.</span>";
    } else {
        // Check if permission exists
        $stmt = mysqli_prepare($conn, "SELECT id FROM page_permissions WHERE page = ? AND role_id = ?");
        mysqli_stmt_bind_param($stmt, 'si', $page, $role_id);
        mysqli_stmt_execute($stmt);
        $check = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($check) > 0) {
            // Update
            $stmt = mysqli_prepare($conn, "UPDATE page_permissions SET can_view = ? WHERE page = ? AND role_id = ?");
            mysqli_stmt_bind_param($stmt, 'isi', $can_view, $page, $role_id);
            $success = mysqli_stmt_execute($stmt);
            $message = $success ? "<span style='color:#27ae60;'>Permission updated!</span>" : "<span style='color:#c0392b;'>Update failed: " . mysqli_error($conn) . "</span>";
        } else {
            // Insert
            $stmt = mysqli_prepare($conn, "INSERT INTO page_permissions (page, role_id, can_view) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, 'sii', $page, $role_id, $can_view);
            $success = mysqli_stmt_execute($stmt);
            $message = $success ? "<span style='color:#27ae60;'>Permission inserted!</span>" : "<span style='color:#c0392b;'>Insert failed: " . mysqli_error($conn) . "</span>";
        }
        mysqli_stmt_close($stmt);
    }
    // Redirect to preserve search state
    $query_params = http_build_query(['search_page' => $search_page]);
    header("Location: $currentPage" . ($query_params ? '?' . $query_params : ''));
    exit;
}

// Fetch all current permissions
$page_roles = [];
$stmt = mysqli_prepare($conn, "SELECT page, role_id, can_view FROM page_permissions");
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
while ($row = mysqli_fetch_assoc($res)) {
    $page_roles[$row['page']][$row['role_id']] = $row['can_view'];
}
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Page Permissions</title>
    <link rel="stylesheet" href="styles/style.css" />
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="admin-wrapper">
        <?php include 'admin_sidebar.php'; ?>
        <div class="admin-activities-main">
            <header class="admin-activities-topbar">
                <div class="admin-activities-topbar-left">
                    <span class="admin-activities-topbar-title">Page Authorization</span>
                </div>
                <div class="admin-activities-topbar-right">
                    <a href="admin_dashboard.php" class="admin-activities-back-btn">← Back to Dashboard</a>
                </div>
            </header>
            <div class="admin-search-sort-bar">
                <form method="GET" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div style="display: flex; gap: 15px; align-items: center;">
                        <div>
                            <label for="search_page">Page:</label>
                            <input type="text" id="search_page" name="search_page" value="<?= htmlspecialchars($search_page) ?>" placeholder="Search by Page Name" style="padding: 5px;">
                        </div>
                        <button type="submit" style="padding: 5px 10px;">Search</button>
                        <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="admin-clear-search-btn">Clear</a>
                    </div>
                </form>
            </div>
            <?php if ($message): ?>
                <div class="message"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>
            <?php if (empty($filtered_pages)): ?>
                <p>No pages found matching your search.</p>
            <?php else: ?>
                <table class="perm-table">
                    <thead>
                        <tr>
                            <th>Page</th>
                            <?php foreach ($roles as $id => $role): ?>
                                <th><?= htmlspecialchars($role) ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($filtered_pages as $page): ?>
                            <tr>
                                <td class="page-name"><?= htmlspecialchars($page) ?></td>
                                <?php foreach ($roles as $role_id => $role): 
                                    $state = $page_roles[$page][$role_id] ?? 0; ?>
                                    <td>
                                        <form method="POST" class="perm-form" action="">
                                            <input type="hidden" name="page" value="<?= htmlspecialchars($page) ?>">
                                            <input type="hidden" name="role_id" value="<?= $role_id ?>">
                                            <input type="hidden" name="can_view" value="<?= $state ? 0 : 1 ?>">
                                            <button type="submit" title="<?= $state ? 'Click to Deny' : 'Click to Allow' ?>">
                                                <span class="<?= $state ? 'allow' : 'deny' ?> icon">
                                                    <?= $state ? '✔ Allow' : '✖ Deny' ?>
                                                </span>
                                            </button>
                                        </form>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>