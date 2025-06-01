<?php
session_start();
require_once 'connection.php';

// Check login and role
if (
    !isset($_SESSION['role_id']) ||
    (!isset($_SESSION['admin_id']) && !isset($_SESSION['user_id']))
) {
    header("Location: login.php");
    exit;
}

// Set variables for repopulation
$member_id = '';
$first_name = '';
$last_name = '';
$email = '';
$phone = '';
$wallet = '0.00';
$points = '0';
$address = '';
$sex = '';
$nationality = '';
$profile_picture = '';
$status = 'inactive';
$password = '';
$payment_slip = '';

$error = '';
$success = '';

// Only override variables if POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $member_id = trim($_POST['member_id'] ?? '');
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $wallet = trim($_POST['wallet'] ?? '0.00');
    $points = '0'; // Should always start at 0
    $status = 'inactive'; // Default
    $registered_at = date('Y-m-d H:i:s');
    $password = trim($_POST['password'] ?? '');
    $payment_slip = ''; // You never repopulate files for security reasons
    $address = trim($_POST['address'] ?? '');
    $sex = trim($_POST['sex'] ?? '');
    $nationality = trim($_POST['nationality'] ?? '');

    // Set status based on wallet
    $wallet_float = floatval($wallet);
    if ($wallet_float >= 30) {
        $status = 'active';
    }
    $points_int = intval($points);

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $target_dir = 'uploads/profile_pictures/';
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $ext = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png'];
        if (!in_array($ext, $allowed_ext)) {
            $error = "Invalid profile picture file type. Only JPG, JPEG, or PNG allowed.";
        } else {
            $basename = uniqid('profile_', true) . '.' . $ext;
            $target_file = $target_dir . $basename;
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
                $profile_picture = $target_file;
            } else {
                $error = "Profile picture upload failed.";
            }
        }
    }

    // Handle payment slip upload
    if (!$error && isset($_FILES['payment_slip']) && $_FILES['payment_slip']['error'] === UPLOAD_ERR_OK) {
        $target_dir = 'uploads/payment_slip/';
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $ext = strtolower(pathinfo($_FILES['payment_slip']['name'], PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'pdf'];
        if (!in_array($ext, $allowed_ext)) {
            $error = "Invalid payment slip file type. Only JPG, JPEG, PNG, or PDF allowed.";
        } else {
            $basename = uniqid('slip_', true) . '.' . $ext;
            $target_file = $target_dir . $basename;
            if (move_uploaded_file($_FILES['payment_slip']['tmp_name'], $target_file)) {
                $payment_slip = $target_file;
            } else {
                $error = "Payment slip upload failed.";
            }
        }
    }

    // Validate required fields
    if (!$member_id || !$first_name || !$last_name || !$email || !$phone || !$password) {
        $error = "Please fill in all required fields.";
    }

    if (!$error) {
        // Duplicate checks
        $stmt_check_member_id = mysqli_prepare($conn, "SELECT id FROM membership WHERE member_id = ?");
        mysqli_stmt_bind_param($stmt_check_member_id, "s", $member_id);
        mysqli_stmt_execute($stmt_check_member_id);
        mysqli_stmt_store_result($stmt_check_member_id);
        $member_id_exists = mysqli_stmt_num_rows($stmt_check_member_id) > 0;
        mysqli_stmt_close($stmt_check_member_id);

        $stmt_check_email = mysqli_prepare($conn, "SELECT id FROM membership WHERE email = ?");
        mysqli_stmt_bind_param($stmt_check_email, "s", $email);
        mysqli_stmt_execute($stmt_check_email);
        mysqli_stmt_store_result($stmt_check_email);
        $email_exists = mysqli_stmt_num_rows($stmt_check_email) > 0;
        mysqli_stmt_close($stmt_check_email);

        $stmt_check_username = mysqli_prepare($conn, "SELECT id FROM user WHERE username = ?");
        mysqli_stmt_bind_param($stmt_check_username, "s", $member_id);
        mysqli_stmt_execute($stmt_check_username);
        mysqli_stmt_store_result($stmt_check_username);
        $username_exists = mysqli_stmt_num_rows($stmt_check_username) > 0;
        mysqli_stmt_close($stmt_check_username);

        if ($member_id_exists || $email_exists || $username_exists) {
            $error = '';
            if ($member_id_exists) {
                $error .= "The Member ID '$member_id' is already taken. ";
            }
            if ($email_exists) {
                $error .= "The email '$email' is already registered. ";
            }
            if ($username_exists) {
                $error .= "The username '$member_id' is already in use. ";
            }
        }
        
        $reserved = ['admin', 'superadmin', 'root'];
        if (in_array(strtolower($member_id), $reserved)) {
            $error = "The Member ID you entered is not allowed.";
        }

    }

    if (!$error) {
        // Insert into membership
        $stmt = mysqli_prepare($conn, "
            INSERT INTO membership 
            (member_id, first_name, last_name, email, phone, address, sex, nationality, wallet, points, status, registered_at, profile_picture, payment_slip)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        mysqli_stmt_bind_param(
            $stmt,
            "ssssssssdissss",
            $member_id,
            $first_name,
            $last_name,
            $email,
            $phone,
            $address,
            $sex,
            $nationality,
            $wallet_float,
            $points_int,
            $status,
            $registered_at,
            $profile_picture,
            $payment_slip
        );
        if (mysqli_stmt_execute($stmt)) {
            $membership_id = mysqli_insert_id($conn);

            // Insert into user table with hashed password
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $role_id = 4; // Default role for members
            $stmt_user = mysqli_prepare($conn, "
                INSERT INTO user (username, password, membership_id, role_id)
                VALUES (?, ?, ?, ?)
            ");
            mysqli_stmt_bind_param($stmt_user, "ssii", $member_id, $hash, $membership_id, $role_id);
            if (mysqli_stmt_execute($stmt_user)) {
                $success = "Member added successfully!";
                header("Location: admin_view_members.php");
                exit;
            } else {
                $error = "Failed to create user account: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt_user);
        } else {
            $error = "Failed to add member: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Add Member | Brew & Go Admin</title>
    <link rel="stylesheet" href="styles/style.css" />
    <link rel="stylesheet" href="styles/admin_view_activities.css" />
    <style>
      .admin-add-form { max-width:600px; margin:30px auto; background:#f9f9f9; padding:22px 35px 30px 35px; border-radius:13px; box-shadow:0 4px 24px #0001;}
      .admin-add-form label { font-weight:600; margin-top:12px; display:block;}
      .admin-add-form input { width:100%; margin-top:4px; margin-bottom:12px; padding:7px 8px; border-radius:6px; border:1px solid #bbb;}
      .admin-add-form select { width:100%; margin-top:4px; margin-bottom:12px; padding:7px 8px; border-radius:6px; border:1px solid #bbb;}
      .admin-add-form button { background:#2196F3; color:#fff; padding:10px 20px; border:none; border-radius:8px; font-size:16px;}
      .admin-add-form .error { color:#e53e3e; margin-bottom:12px;}
      .admin-add-form .success { color:#38a169; margin-bottom:12px;}
    </style>
</head>
<body class="admin-members-body">
<?php include 'navbar.php'; ?>
<div class="admin-wrapper">
    <?php include 'admin_sidebar.php'; ?>
    <div class="admin-activities-main">
        <header class="admin-activities-topbar">
            <div class="admin-activities-topbar-left">
                <span class="admin-activities-topbar-title">Add Member</span>
            </div>
            <div class="admin-activities-topbar-right">
                <a href="admin_view_members.php" class="admin-activities-back-btn">← Back to Members</a>
            </div>
        </header>
        <form class="admin-add-form" action="add_members.php" method="post" enctype="multipart/form-data">
            <?php if ($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
            <?php if ($success): ?><div class="success"><?= $success ?></div><?php endif; ?>

            <label for="member_id">Member ID*</label>
            <input type="text" name="member_id" id="member_id" required value="<?= htmlspecialchars($member_id) ?>">

            <label for="first_name">First Name*</label>
            <input type="text" name="first_name" id="first_name" required value="<?= htmlspecialchars($first_name) ?>">

            <label for="last_name">Last Name*</label>
            <input type="text" name="last_name" id="last_name" required value="<?= htmlspecialchars($last_name) ?>">

            <label for="email">Email*</label>
            <input type="email" name="email" id="email" required value="<?= htmlspecialchars($email) ?>">

            <label for="phone">Phone*</label>
            <input type="text" name="phone" id="phone" required value="<?= htmlspecialchars($phone) ?>">

            <label for="address">Address</label>
            <input type="text" name="address" id="address" value="<?= htmlspecialchars($address ?? '') ?>">

            <label for="sex">Sex</label>
            <select name="sex" id="sex">
                <option value="">--</option>
                <option value="Male" <?= (isset($sex) && $sex=='Male') ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= (isset($sex) && $sex=='Female') ? 'selected' : '' ?>>Female</option>
            </select>

            <label for="nationality">Nationality</label>
            <input type="text" name="nationality" id="nationality" value="<?= htmlspecialchars($nationality ?? '') ?>">

            <label for="wallet">Wallet (RM)</label>
            <input type="number" step="0.01" name="wallet" id="wallet" value="<?= htmlspecialchars($wallet) ?>">

            <label for="points">Points</label>
            <input type="number" name="points" id="points" value="0" readonly>

            <label for="status">Status</label>
            <select name="status" id="status" disabled>
                <option value="inactive" <?= $status === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Active</option>
            </select>

            <label for="password">Password*</label>
            <input type="password" name="password" id="password" required value="">

            <label for="profile_picture">Profile Picture (Image)</label>
            <input type="file" name="profile_picture" id="profile_picture" accept="image/*">

            <label for="payment_slip">Payment Slip (Image/PDF)</label>
            <input type="file" name="payment_slip" id="payment_slip" accept="image/*,.pdf">

            <button type="submit">Add Member</button>
        </form>

    </div>
</div>
</body>
</html>
