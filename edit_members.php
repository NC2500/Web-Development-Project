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
$id = intval($_GET['id'] ?? 0);
if (!$id) {
    header("Location: admin_view_members.php");
    exit;
}
$result = mysqli_query($conn, "SELECT * FROM membership WHERE id = $id LIMIT 1");
$member = mysqli_fetch_assoc($result);

if (!$member) {
    header("Location: admin_view_members.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $member_id = trim($_POST['member_id'] ?? '');
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $wallet = floatval($_POST['wallet'] ?? 0);
    $points = intval($_POST['points'] ?? 0);
    $status = strtolower(trim($_POST['status'] ?? 'active'));
    $payment_slip = $member['payment_slip'];
    $address = trim($_POST['address'] ?? '');
    $sex = trim($_POST['sex'] ?? '');
    $nationality = trim($_POST['nationality'] ?? '');
    $profile_picture = $member['profile_picture'];

    // Handle payment slip upload (image/pdf)
    if (isset($_FILES['payment_slip']) && $_FILES['payment_slip']['error'] === UPLOAD_ERR_OK) {
        $target_dir = 'uploads/payment_slip/';
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $ext = strtolower(pathinfo($_FILES['payment_slip']['name'], PATHINFO_EXTENSION));
        $basename = uniqid('slip_', true) . '.' . $ext;
        $target_file = $target_dir . $basename;
        if (move_uploaded_file($_FILES['payment_slip']['tmp_name'], $target_file)) {
            // Optional: delete old file
            if (!empty($member['payment_slip']) && file_exists($member['payment_slip'])) {
                @unlink($member['payment_slip']);
            }
            $payment_slip = $target_file;
        } else {
            $error = "Payment slip upload failed.";
        }
    }

    if (!$member_id || !$first_name || !$last_name || !$email || !$phone) {
        $error = "Please fill in all required fields.";
    }

    if (!$error) {
        $stmt = mysqli_prepare($conn, "
            UPDATE membership
            SET member_id=?, first_name=?, last_name=?, email=?, phone=?, address=?, sex=?, nationality=?, wallet=?, points=?, status=?, profile_picture=?, payment_slip=?
            WHERE id=?
        ");
        mysqli_stmt_bind_param($stmt, "ssssssssddssss",
            $member_id, $first_name, $last_name, $email, $phone, $address, $sex, $nationality, $wallet, $points, $status, $profile_picture, $payment_slip, $id);
        if (mysqli_stmt_execute($stmt)) {
            $success = "Member updated successfully!";
            header("Location: admin_view_members.php");
            exit;
        } else {
            $error = "Failed to update member: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Edit Member | Brew & Go Admin</title>
    <link rel="stylesheet" href="styles/style.css" />
    <link rel="stylesheet" href="styles/admin_view_activities.css" />
</head>
<body class="admin-members-body">
<?php include 'navbar.php'; ?>
<div class="admin-wrapper">
    <?php include 'admin_sidebar.php'; ?>
    <div class="admin-activities-main">
        <header class="admin-activities-topbar">
            <div class="admin-activities-topbar-left">
                <span class="admin-activities-topbar-title">Edit Member</span>
            </div>
            <div class="admin-activities-topbar-right">
                <a href="admin_view_members.php" class="admin-activities-back-btn">← Back to Members</a>
            </div>
        </header>
        <form class="admin-add-form" action="edit_members.php?id=<?= $member['id'] ?>" method="post" enctype="multipart/form-data">
            <?php if ($error): ?><div class="error"><?= $error ?></div><?php endif; ?>

            <label for="member_id">Member ID*</label>
            <input type="text" name="member_id" id="member_id" required value="<?= htmlspecialchars($member['member_id']) ?>">

            <label for="first_name">First Name*</label>
            <input type="text" name="first_name" id="first_name" required value="<?= htmlspecialchars($member['first_name']) ?>">

            <label for="last_name">Last Name*</label>
            <input type="text" name="last_name" id="last_name" required value="<?= htmlspecialchars($member['last_name']) ?>">

            <label for="email">Email*</label>
            <input type="email" name="email" id="email" required value="<?= htmlspecialchars($member['email']) ?>">

            <label for="phone">Phone*</label>
            <input type="text" name="phone" id="phone" required value="<?= htmlspecialchars($member['phone']) ?>">

            <label for="address">Address</label>
            <input type="text" name="address" id="address" value="<?= htmlspecialchars($member['address']) ?>">

            <label for="sex">Sex</label>
            <select name="sex" id="sex">
                <option value="">--</option>
                <option value="Male" <?= $member['sex']=='Male'?'selected':'' ?>>Male</option>
                <option value="Female" <?= $member['sex']=='Female'?'selected':'' ?>>Female</option>
            </select>

            <label for="nationality">Nationality</label>
            <input type="text" name="nationality" id="nationality" value="<?= htmlspecialchars($member['nationality']) ?>">

            <label for="wallet">Wallet (RM)</label>
            <input type="number" step="0.01" name="wallet" id="wallet" value="<?= htmlspecialchars($member['wallet']) ?>">

            <label for="points">Points</label>
            <input type="number" name="points" id="points" value="<?= htmlspecialchars($member['points']) ?>">

            <label for="status">Status</label>
            <select name="status" id="status">
                <option value="active"<?= $member['status'] === 'active' ? ' selected' : '' ?>>Active</option>
                <option value="expired"<?= $member['status'] === 'expired' ? ' selected' : '' ?>>Expired</option>
            </select>

            <label for="profile_picture">Profile Picture (Image)</label>
            <?php if (!empty($member['profile_picture'])): ?>
                <div style="margin-bottom:10px;">
                    <a href="<?= htmlspecialchars($member['profile_picture']) ?>" target="_blank">View Current</a>
                </div>
            <?php endif; ?>
            <input type="file" name="profile_picture" id="profile_picture" accept="image/*">

            <label for="payment_slip">Payment Slip (Image/PDF)</label>
            <?php if (!empty($member['payment_slip'])): ?>
                <div style="margin-bottom:10px;">
                    <a href="<?= htmlspecialchars($member['payment_slip']) ?>" target="_blank">View Current</a>
                </div>
            <?php endif; ?>
            <input type="file" name="payment_slip" id="payment_slip" accept="image/*,.pdf">

            <div class="action-button-wrapper">
                <button type="submit" class="admin-add-button">Save Changes</button>
            </form>
                <form action="delete_member.php" method="post">
                    <input type="hidden" name="id" value="<?= $member['id'] ?>">
                    <button type="submit" class="btn-delete-member">Delete Member</button>
                </form>
            </div>
    </div>
</div>
</body>
</html>
