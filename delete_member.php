<?php
session_start();
require_once 'connection.php';

if (
    !isset($_SESSION['role_id']) ||
    (!isset($_SESSION['admin_id']) && !isset($_SESSION['user_id']))
) {
    header("Location: login.php");
    exit;
}

// Only POST is allowed
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $confirmed = isset($_POST['confirm']);

    // Fetch member info for confirmation display
    $result = mysqli_query($conn, "SELECT * FROM membership WHERE id = $id LIMIT 1");
    $member = mysqli_fetch_assoc($result);

    if (!$member) {
        header("Location: admin_view_members.php");
        exit;
    }

    if ($confirmed) {
        // Second submit, confirmed deletion
        $stmt = mysqli_prepare($conn, "DELETE FROM membership WHERE id=?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        // Delete any user accounts linked to this member
        $stmt_user = mysqli_prepare($conn, "DELETE FROM user WHERE membership_id=?");
        mysqli_stmt_bind_param($stmt_user, "i", $id);
        mysqli_stmt_execute($stmt_user);
        mysqli_stmt_close($stmt_user);

        header("Location: admin_view_members.php");
        exit;
    }
    // Else, show confirmation form below
} else {
    // If not POST or no id, just redirect
    header("Location: admin_view_members.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Confirm Delete | Brew & Go Admin</title>
    <link rel="stylesheet" href="styles/style.css" />
    <style>
        .confirm-box {
            max-width: 400px;
            margin: 100px auto;
            padding: 35px 30px;
            background: #fff3f3;
            border: 1.5px solid #e53935;
            border-radius: 14px;
            box-shadow: 0 2px 18px #d32f2f21;
            text-align: center;
        }
        .confirm-title { color: #d32f2f; font-size: 1.3em; font-weight: bold; margin-bottom: 1.2em;}
        .confirm-buttons { display: flex; justify-content: center; gap: 18px; margin-top: 2em;}
        .btn-cancel {
            background: #777;
            color: #fff;
            padding: 8px 26px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
        }
        .btn-delete-member {
            background: #e53935;
            color: #fff;
            padding: 8px 26px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
        }
        .btn-delete-member:hover { background: #b71c1c;}
        .btn-cancel:hover { background: #333;}
    </style>
</head>
<body>
    <div class="confirm-box">
        <div class="confirm-title">Are you sure you want to delete this member?</div>
        <div>
            <strong><?= htmlspecialchars($member['first_name'] . ' ' . $member['last_name']) ?></strong><br>
            Member ID: <?= htmlspecialchars($member['member_id']) ?>
        </div>
        <div class="confirm-buttons">
            <form action="delete_member.php" method="post" style="margin:0;">
                <input type="hidden" name="id" value="<?= $member['id'] ?>">
                <input type="hidden" name="confirm" value="1">
                <button type="submit" class="btn-delete-member">Yes, Delete</button>
            </form>
            <form action="admin_view_members.php" method="get" style="margin:0;">
                <button type="submit" class="btn-cancel">Cancel</button>
            </form>
        </div>
    </div>
</body>
</html>
