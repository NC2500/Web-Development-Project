<?php
function can_view_page($conn, $page, $role_id) {
    $stmt = mysqli_prepare($conn, "SELECT can_view FROM page_permissions WHERE page = ? AND role_id = ?");
    mysqli_stmt_bind_param($stmt, "si", $page, $role_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $can_view);
    $result = mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    return ($result && $can_view == 1);
}

$role_id = $_SESSION['role_id'] ?? 0;
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<aside class="admin-sidebar">
    <div class="admin-brand">
        <a href="admin_dashboard.php" class="admin-brand-link">Welcome, Admin</a>
    </div>
    <nav>
        <ul>
            <?php if (can_view_page($conn, 'admin_dashboard.php', $role_id)): ?>
            <li>
                <a href="admin_dashboard.php"<?= $currentPage == 'admin_dashboard.php' ? ' class="active"' : '' ?>>Dashboard</a>
            </li>
            <?php endif; ?>

            <?php if (can_view_page($conn, 'admin_view_members.php', $role_id)): ?>
            <li>
                <a href="admin_view_members.php"<?= $currentPage == 'admin_view_members.php' ? ' class="active"' : '' ?>>Members</a>
            </li>
            <?php endif; ?>

            <?php if (can_view_page($conn, 'admin_view_enquiries.php', $role_id)): ?>
            <li>
                <a href="admin_view_enquiries.php"<?= $currentPage == 'admin_view_enquiries.php' ? ' class="active"' : '' ?>>Enquiries</a>
            </li>
            <?php endif; ?>

            <?php if (can_view_page($conn, 'admin_view_jobs.php', $role_id)): ?>
            <li>
                <a href="admin_view_jobs.php"<?= $currentPage == 'admin_view_jobs.php' ? ' class="active"' : '' ?>>Job Applications</a>
            </li>
            <?php endif; ?>

            <?php if (can_view_page($conn, 'admin_view_products.php', $role_id)): ?>
            <li>
                <a href="admin_view_products.php"<?= $currentPage == 'admin_view_products.php' ? ' class="active"' : '' ?>>Products</a>
            </li>
            <?php endif; ?>
            
            <?php if (can_view_page($conn, 'admin_view_activities.php', $role_id)): ?>
            <li>
                <a href="admin_view_activities.php"<?= $currentPage == 'admin_view_activities.php' ? ' class="active"' : '' ?>>Activities</a>
            </li>
            <?php endif; ?>

            <?php if (can_view_page($conn, 'admin_view_newsletter.php', $role_id)): ?>
            <li>
                <a href="admin_view_newsletter.php"<?= $currentPage == 'admin_view_newsletter.php' ? ' class="active"' : '' ?>>Newsletter</a>
            </li>
            <?php endif; ?>

            <?php if (can_view_page($conn, 'admin_view_permissions.php', $role_id)): ?>
            <li>
                <a href="admin_view_permissions.php"<?= $currentPage == 'admin_view_permissions.php' ? ' class="active"' : '' ?>>Page Authorization</a>
            </li>
            <?php endif; ?>
            
            <li>
                <a href="logout.php" class="admin-logout-btn">Logout</a>
            </li>
        </ul>
    </nav>
</aside>
