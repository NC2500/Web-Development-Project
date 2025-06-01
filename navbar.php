<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$role_id = $_SESSION['role_id'] ?? 0;
$is_admin = ($role_id == 1);       // Admin
$is_operator = ($role_id == 2);    // Operator
$is_staff = ($role_id == 3);       // Staff
$is_user = ($role_id == 4);        // User

$is_admin_or_operator = $is_admin || $is_operator;
$is_staff_logged_in = $is_staff && isset($_SESSION['user_id']);
$is_user_logged_in = $is_user && isset($_SESSION['user_id']);
$is_logged_in = isset($_SESSION['user_id']) || isset($_SESSION['admin_id']); // covers all

$member_full_name = '';
if (($is_staff_logged_in || $is_user_logged_in) && isset($_SESSION['membership_id'])) {
    require_once 'connection.php';
    $membership_id = $_SESSION['membership_id'];
    $sql = "SELECT first_name, last_name FROM membership WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $membership_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $first_name, $last_name);
    if (mysqli_stmt_fetch($stmt)) {
        $member_full_name = htmlspecialchars($first_name . ' ' . $last_name);
    }
    mysqli_stmt_close($stmt);
}

?>

<nav class="navbar">
    <input type="checkbox" id="menu-toggle" class="menu-toggle">
    <label for="menu-toggle" class="hamburger">&#9776;</label>
    <div class="mobile-dropdown-menu">
      <ul>
        <li><a href="menu.php">MENU</a></li>
        <li><a href="activities.php">ACTIVITIES</a></li>
        <li><a href="joinus.php">JOIN US</a></li>
        <li><a href="enquiry.php">ENQUIRY</a></li>
        <?php if ($is_admin_logged_in): ?>
            <li><a href="admin_dashboard.php">View</a></li>
            <li><a href="logout.php">LOGOUT</a></li>
        <?php elseif ($is_member_logged_in): ?>
            <li><a href="profile.php"><?= $member_full_name ?></a></li>
            <li><a href="logout.php">LOGOUT</a></li>
        <?php else: ?>
            <li><a href="membership.php">MEMBERSHIP</a></li>
            <li><a href="login.php">LOGIN</a></li>
        <?php endif; ?>
      </ul>
    </div>
    <div class="logo">
        <a href="main.php"><img src="images/Logo_1.png" alt="Logo"></a>
    </div>
    
    <ul class="nav-links">
        <li class="dropdown">
            <a href="menu.php" class="dropbtn">MENU ▼</a>
            <ul class="dropdown-menu">
                <li><a href="menu3.php">Basic Brew</a></li>
                <li><a href="menu1.php">Artisan Brew</a></li>
                <li><a href="menu2.php">Non-Coffee</a></li>
                <li><a href="menu4.php">Hot Beverages</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="activities.php" class="dropbtn">ACTIVITIES ▼</a>
            <ul class="dropdown-menu">
                <li><a href="coming_soon.php">Coming Soon</a></li>
                <li><a href="current.php">Current</a></li>
                <li><a href="past_activities.php">Past Activities</a></li>
            </ul>
        </li>
        <li><a href="joinus.php">JOIN US</a></li>
        <li><a href="enquiry.php">ENQUIRY</a></li>
        <?php if ($is_admin_or_operator): ?>
            <li><a href="admin_dashboard.php">ADMIN</a></li>
            <li><a href="logout.php">LOGOUT</a></li>
        <?php elseif ($is_staff_logged_in): ?>
            <li><a href="profile.php"><?= $member_full_name ?></a></li>
            <li><a href="admin_dashboard.php">VIEW</a></li>
            <li><a href="logout.php">LOGOUT</a></li>
        <?php elseif ($is_user_logged_in): ?>
            <li><a href="profile.php"><?= $member_full_name ?></a></li>
            <li><a href="logout.php">LOGOUT</a></li>
        <?php else: ?>
            <li><a href="membership.php">MEMBERSHIP</a></li>
            <li><a href="login.php">LOGIN</a></li>
        <?php endif; ?>
    </ul>
</nav>
