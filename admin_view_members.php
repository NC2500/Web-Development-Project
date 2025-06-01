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

// Handle search and sort parameters
$search_member_id = isset($_GET['search_member_id']) ? trim($_GET['search_member_id']) : '';
$search_name = isset($_GET['search_name']) ? trim($_GET['search_name']) : '';
$filter_status = isset($_GET['filter_status']) ? $_GET['filter_status'] : '';
$sort_joined = isset($_GET['sort_joined']) ? $_GET['sort_joined'] : 'desc';

// Build the SQL query with search and filter
$sql = "SELECT m.id, m.member_id, m.first_name, m.last_name, m.email, m.phone, m.wallet, m.points, m.status, m.registered_at, m.payment_slip,
               u.role_id, r.name AS role_name, u.id AS user_id
        FROM membership m
        LEFT JOIN user u ON m.id = u.membership_id
        LEFT JOIN roles r ON u.role_id = r.id
        WHERE 1=1";

$params = [];
$types = '';

if ($search_member_id !== '') {
    $sql .= " AND m.member_id LIKE ?";
    $params[] = '%' . $search_member_id . '%';
    $types .= 's';
}

if ($search_name !== '') {
    $sql .= " AND CONCAT(m.first_name, ' ', m.last_name) LIKE ?";
    $params[] = '%' . $search_name . '%';
    $types .= 's';
}

if ($filter_status === 'active' || $filter_status === 'inactive') {
    $sql .= " AND m.status = ?";
    $params[] = $filter_status;
    $types .= 's';
}

// Sorting by joined date
$sql .= " ORDER BY m.registered_at " . ($sort_joined === 'asc' ? 'ASC' : 'DESC');

// Prepare and execute the query
$stmt = mysqli_prepare($conn, $sql);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['new_role_id'])) {
    $user_id = intval($_POST['user_id']);
    $new_role_id = intval($_POST['new_role_id']);
    if ($user_id > 0 && $new_role_id > 0) {
        $update_stmt = mysqli_prepare($conn, "UPDATE user SET role_id = ? WHERE id = ?");
        mysqli_stmt_bind_param($update_stmt, "ii", $new_role_id, $user_id);
        mysqli_stmt_execute($update_stmt);
        mysqli_stmt_close($update_stmt);
        // Redirect to preserve search/sort state
        $query_params = http_build_query([
            'search_member_id' => $search_member_id,
            'search_name' => $search_name,
            'filter_status' => $filter_status,
            'sort_joined' => $sort_joined
        ]);
        header("Location: " . $_SERVER['PHP_SELF'] . ($query_params ? '?' . $query_params : ''));
        exit;
    }
}

// Fetch all possible roles for dropdown
$role_options = [];
$res = mysqli_query($conn, "SELECT id, name FROM roles ORDER BY id ASC");
while ($r = mysqli_fetch_assoc($res)) $role_options[$r['id']] = $r['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>All Members | Brew & Go Admin</title>
    <link rel="stylesheet" href="styles/style.css" />
</head>
<body class="admin-members-body">
    <?php include 'navbar.php' ?>
<div class="admin-wrapper">
    <?php include 'admin_sidebar.php'; ?>
        <div class="admin-activities-main">
        <header class="admin-activities-topbar">
            <div class="admin-activities-topbar-left">
                <span class="admin-activities-topbar-title">All Members</span>
            </div>
            <div class="admin-activities-topbar-right">
                <a href="add_members.php" class="admin-activities-add-btn" > Add New Member</a>
                <a href="admin_dashboard.php" class="admin-activities-back-btn">← Back to Dashboard</a>
            </div>
        </header>
        <section class="admin-table-section">
            <div class="admin-search-sort-bar">
                <form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="admin-search-sort-row">
                        <div>
                            <label for="search_member_id">Member ID:</label>
                            <input type="text" id="search_member_id" name="search_member_id" value="<?php echo htmlspecialchars($search_member_id); ?>" placeholder="Search by Member ID" style="padding: 5px;">
                        </div>
                        <div>
                            <label for="search_name">Name:</label>
                            <input type="text" id="search_name" name="search_name" value="<?php echo htmlspecialchars($search_name); ?>" placeholder="Search by Name" style="padding: 5px;">
                        </div>
                        <div>
                            <label for="filter_status">Filter by Status:</label>
                            <select id="filter_status" name="filter_status" onchange="this.form.submit()" style="padding: 5px;">
                                <option value="" <?php echo $filter_status === '' ? 'selected' : ''; ?>>All Status</option>
                                <option value="active" <?php echo $filter_status === 'active' ? 'selected' : ''; ?>>Active</option>
                                <option value="inactive" <?php echo $filter_status === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                        <div>
                            <label for="sort_joined">Sort by Joined:</label>
                            <select id="sort_joined" name="sort_joined" onchange="this.form.submit()" style="padding: 5px;">
                                <option value="desc" <?php echo $sort_joined === 'desc' ? 'selected' : ''; ?>>Newest First</option>
                                <option value="asc" <?php echo $sort_joined === 'asc' ? 'selected' : ''; ?>>Oldest First</option>
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
                        <th>ID</th>
                        <th>Member ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Wallet</th>
                        <th>Points</th>
                        <th>Status</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th>Payment Slip</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['member_id']) ?></td>
                        <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td>RM <?= htmlspecialchars(number_format($row['wallet'], 2)) ?></td>
                        <td><?= htmlspecialchars($row['points']) ?></td>
                        <td>
                            <span class="status-badge <?= $row['status'] === 'active' ? 'active' : 'inactive' ?>">
                                <?= ucfirst($row['status']) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($row['user_id']): ?>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
                                    <input type="hidden" name="search_member_id" value="<?= htmlspecialchars($search_member_id) ?>">
                                    <input type="hidden" name="search_name" value="<?= htmlspecialchars($search_name) ?>">
                                    <input type="hidden" name="filter_status" value="<?= htmlspecialchars($filter_status) ?>">
                                    <input type="hidden" name="sort_joined" value="<?= htmlspecialchars($sort_joined) ?>">
                                    <select name="new_role_id"
                                        class="status-pill role-pill <?= strtolower($role_options[$row['role_id']]) ?>"
                                        onchange="this.form.submit()"
                                        style="min-width:90px;">
                                        <?php foreach ($role_options as $rid => $rname): ?>
                                            <option value="<?= $rid ?>" <?= $row['role_id'] == $rid ? 'selected' : '' ?>>
                                                <?= htmlspecialchars(ucfirst($rname)) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </form>
                            <?php else: ?>
                                <span style="color:#aaa;">No user</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['registered_at']) ?></td>
                        <td>
                            <?php if ($row['payment_slip']): ?>
                                <?php
                                $ext = strtolower(pathinfo($row['payment_slip'], PATHINFO_EXTENSION));
                                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])): ?>
                                    <a href="<?= htmlspecialchars($row['payment_slip']) ?>" target="_blank">
                                        <img src="<?= htmlspecialchars($row['payment_slip']) ?>" alt="Payment Slip" class="admin-view-payment_slip">
                                    </a>
                                <?php elseif ($ext === 'pdf'): ?>
                                    <a href="<?= htmlspecialchars($row['payment_slip']) ?>" target="_blank">
                                        <button type="button" class="btn-view-pdf">View</button>
                                    </a>
                                <?php else: ?>
                                    <a href="<?= htmlspecialchars($row['payment_slip']) ?>" target="_blank" class="admin-view-payment_slip-pdf">View</a>
                                <?php endif; ?>
                            <?php else: ?>
                                <span>N/A</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit_members.php?id=<?= $row['id'] ?>" class="admin-activities-btn-edit">Edit</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </div>
</div>
</body>
</html>