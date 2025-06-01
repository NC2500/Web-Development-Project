<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['membership_id'])) {
    header("Location: login.php");
    exit;
}
$membership_id = $_SESSION['membership_id'];
$amount = intval($_POST['topup_amount'] ?? 0);

// Only allow specific top-up values
$allowed = [30, 50, 100, 200];
if (!in_array($amount, $allowed)) {
    $_SESSION['topup_error'] = "Invalid top-up amount.";
    header("Location: profile.php");
    exit;
}

// Update wallet balance
$sql = "UPDATE membership SET wallet = wallet + ? WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $amount, $membership_id);
if (mysqli_stmt_execute($stmt)) {
    // Log to topup_history
    $sql2 = "INSERT INTO topup_history (membership_id, amount) VALUES (?, ?)";
    $stmt2 = mysqli_prepare($conn, $sql2);
    mysqli_stmt_bind_param($stmt2, "id", $membership_id, $amount);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_close($stmt2);

    // ------ AUTO ACTIVATE STATUS IF wallet >= 30 ------
    $sql3 = "SELECT wallet FROM membership WHERE id = ?";
    $stmt3 = mysqli_prepare($conn, $sql3);
    mysqli_stmt_bind_param($stmt3, "i", $membership_id);
    mysqli_stmt_execute($stmt3);
    mysqli_stmt_bind_result($stmt3, $new_wallet);
    mysqli_stmt_fetch($stmt3);
    mysqli_stmt_close($stmt3);

    if ($new_wallet >= 30) {
        mysqli_query($conn, "UPDATE membership SET status = 'active' WHERE id = $membership_id");
    }
    // --------------------------------------------------

    $_SESSION['topup_msg'] = "Wallet topped up successfully by RM $amount!";
} else {
    $_SESSION['topup_error'] = "Failed to top up wallet. " . mysqli_error($conn);
}
mysqli_stmt_close($stmt);
header("Location: profile.php");
exit;
?>
