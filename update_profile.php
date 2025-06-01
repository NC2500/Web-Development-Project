<?php
session_start();
require_once 'connection.php';

function clean($d) { return htmlspecialchars(trim($d)); }
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); exit;
}

$membership_id = $_SESSION['membership_id'] ?? 0;

// Only allow if POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: profile.php"); exit;
}

// Fetch input
$first_name  = clean($_POST['first_name'] ?? '');
$last_name   = clean($_POST['last_name'] ?? '');
$email       = clean($_POST['email'] ?? '');
$phone       = clean($_POST['phone'] ?? '');
$address     = clean($_POST['address'] ?? '');
$sex         = clean($_POST['sex'] ?? '');
$nationality = clean($_POST['nationality'] ?? '');

// Validate required fields
if (!$first_name || !$last_name || !$email) {
    $_SESSION['profile_error'] = "First Name, Last Name and Email are required.";
    header("Location: profile.php?edit=1");
    exit;
}

// Profile picture upload logic
$profile_picture = null;
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
    if (in_array($ext, $allowed_types)) {
        $upload_dir = 'uploads/';
        if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);
        $profile_picture = $upload_dir . 'profile_' . uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profile_picture);
    } else {
        $_SESSION['profile_error'] = "Invalid profile picture file type.";
        header("Location: profile.php?edit=1");
        exit;
    }
}

// Build SQL update
$set_picture = $profile_picture ? ", profile_picture = ?" : "";
$sql = "UPDATE membership SET first_name=?, last_name=?, email=?, phone=?, address=?, sex=?, nationality=? $set_picture WHERE id=?";

if ($profile_picture) {
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssssi", $first_name, $last_name, $email, $phone, $address, $sex, $nationality, $profile_picture, $membership_id);
} else {
    $sql = "UPDATE membership SET first_name=?, last_name=?, email=?, phone=?, address=?, sex=?, nationality=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssssi", $first_name, $last_name, $email, $phone, $address, $sex, $nationality, $membership_id);
}

if (mysqli_stmt_execute($stmt)) {
    header("Location: profile.php");
    exit;
} else {
    $_SESSION['profile_error'] = "Failed to update profile. " . mysqli_error($conn);
    header("Location: profile.php?edit=1");
    exit;
}
?>
