<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$membership_id = $_SESSION['membership_id'];

// Get current data
$sql = "SELECT member_id, first_name, last_name, email, phone, address, sex, nationality, wallet, points, profile_picture, status, registered_at 
        FROM membership WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $membership_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (!$row = mysqli_fetch_assoc($result)) {
    echo "<p>Profile not found.</p>";
    exit;
}
$is_edit = isset($_GET['edit']);
$profile_error = $_SESSION['profile_error'] ?? '';
unset($_SESSION['profile_error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>My Profile | Brew & Go</title>
    <link rel="stylesheet" href="styles/style.css" />
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="profile-page-container">
        <div class="profile-card">
            <?php if ($is_edit): ?>
                <h2>Edit Profile</h2>
                <?php if ($profile_error): ?>
                    <div class="response-error"><?= htmlspecialchars($profile_error) ?></div>
                <?php endif; ?>
                <form class="profile-edit-form" action="update_profile.php" method="post" enctype="multipart/form-data">
                    <div class="profile-picture-section">
                        <img src="<?= htmlspecialchars($row['profile_picture'] ?: 'images/default_profile.png') ?>" alt="Profile Picture" class="profile-picture">
                        <input type="file" name="profile_picture" accept="image/*">
                    </div>
                    <input type="hidden" name="member_id" value="<?= htmlspecialchars($row['member_id']) ?>">
                    <label>First Name:
                        <input type="text" name="first_name" maxlength="100" value="<?= htmlspecialchars($row['first_name']) ?>" required>
                    </label>
                    <label>Last Name:
                        <input type="text" name="last_name" maxlength="100" value="<?= htmlspecialchars($row['last_name']) ?>" required>
                    </label>
                    <label>Email:
                        <input type="email" name="email" maxlength="100" value="<?= htmlspecialchars($row['email']) ?>" required>
                    </label>
                    <label>Phone:
                        <input type="text" name="phone" maxlength="20" value="<?= htmlspecialchars($row['phone']) ?>">
                    </label>
                    <label>Address:
                        <input type="text" name="address" maxlength="255" value="<?= htmlspecialchars($row['address']) ?>">
                    </label>
                    <label>Sex:
                        <select name="sex">
                            <option value="">--</option>
                            <option value="Male" <?= $row['sex']=='Male'?'selected':'' ?>>Male</option>
                            <option value="Female" <?= $row['sex']=='Female'?'selected':'' ?>>Female</option>
                        </select>
                    </label>
                    <label>Nationality:
                        <input type="text" name="nationality" maxlength="50" value="<?= htmlspecialchars($row['nationality']) ?>">
                    </label>
                    <button type="submit" class="btn-membership-submit">Save</button>
                    <a href="profile.php" class="btn-membership-reset" style="margin-left:1em;">Cancel</a>
                </form>
            <?php else: ?>
                <div class="profile-header">
                    <img src="<?= htmlspecialchars($row['profile_picture'] ?: 'images/default_profile.png') ?>" alt="Profile Picture" class="profile-picture">
                    <h2><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></h2>
                    <span class="profile-status <?= $row['status'] === 'active' ? 'active' : 'expired' ?>">
                        <?= ucfirst($row['status']) ?>
                    </span>
                </div>
                    <div class="profile-details">
                    <div class="profile-row"><span class="profile-label">Member ID:</span> <span class="profile-value"><?= htmlspecialchars($row['member_id']) ?></span></div>
                    <div class="profile-row"><span class="profile-label">Email:</span> <span class="profile-value"><?= htmlspecialchars($row['email']) ?></span></div>
                    <div class="profile-row"><span class="profile-label">Phone:</span> <span class="profile-value"><?= htmlspecialchars($row['phone']) ?></span></div>
                    <div class="profile-row"><span class="profile-label">Address:</span> <span class="profile-value"><?= htmlspecialchars($row['address']) ?></span></div>
                    <div class="profile-row"><span class="profile-label">Sex:</span> <span class="profile-value"><?= htmlspecialchars($row['sex']) ?></span></div>
                    <div class="profile-row"><span class="profile-label">Nationality:</span> <span class="profile-value"><?= htmlspecialchars($row['nationality']) ?></span></div>
                    <div class="profile-row"><span class="profile-label">Wallet Balance:</span> <span class="profile-value">RM <?= htmlspecialchars($row['wallet']) ?></span></div>
                    <div class="profile-topup-section">
                    <form action="topup_wallet.php" method="post" class="topup-form">
                        <label for="topup_amount" class="profile-label">Top-Up Amount:</label>
                        <select name="topup_amount" id="topup_amount" required>
                            <option value="">Select Amount</option>
                            <option value="30">RM 30</option>
                            <option value="50">RM 50</option>
                            <option value="100">RM 100</option>
                            <option value="200">RM 200</option>
                        </select>
                        <button type="submit" class="btn-topup-submit">Top Up</button>
                    </form>
                    <?php if (!empty($_SESSION['topup_msg'])): ?>
                        <div class="topup-responce-success">
                            <?= htmlspecialchars($_SESSION['topup_msg']); unset($_SESSION['topup_msg']); ?>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($_SESSION['topup_error'])): ?>
                            <div class="topup-responce-error">
                                <?= htmlspecialchars($_SESSION['topup_error']); unset($_SESSION['topup_error']); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    <div class="profile-row"><span class="profile-label">Points:</span> <span class="profile-value"><?= htmlspecialchars($row['points']) ?></span></div>
                    <div class="profile-row"><span class="profile-label">Joined:</span> <span class="profile-value"><?= htmlspecialchars($row['registered_at']) ?></span></div>
                </div>
                <a href="profile.php?edit=1" class="btn-membership-submit" style="margin-top:1.1em;">Edit Profile</a>
                <?php endif; ?>
            </div>
        </div>

    <?php include 'footer.php'; ?>
    <?php include 'backtotop.php'; ?>
</body>
</html>
