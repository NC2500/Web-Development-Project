<?php
session_start();
function format_duration($seconds) {
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $seconds = $seconds % 60;
    $parts = [];
    if ($hours)   $parts[] = $hours . 'h';
    if ($minutes) $parts[] = $minutes . 'm';
    $parts[] = $seconds . 's';
    return implode(' ', $parts);
}

$username = $_SESSION['username'] ?? '';
$login_time = $_SESSION['login_time'] ?? null;
$session_duration = 0;


if ($login_time) {
    $session_duration = time() - $login_time;
}
session_unset();
session_destroy();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Logged Out | Brew & Go</title>
    <link rel="stylesheet" href="styles/style.css" />
    <meta http-equiv="refresh" content="2;url=main.php">
</head>
<body>
    <div class="response-container" style="margin-top:100px;text-align:center;">
        <div class="response-success">You have been logged out.</div>
        <?php if ($username): ?>
            <p>
                <strong>Username:</strong> <?= htmlspecialchars($username) ?><br>
                <strong>Session Duration:</strong> <?= format_duration($session_duration) ?>
            </p>
        <?php endif; ?>
        <p>You will be redirected to the main page in 2 seconds.</p>
        <a href="main.php"><button class="response-btn">Go to Home Now</button></a>
    </div>
</body>
</html>
