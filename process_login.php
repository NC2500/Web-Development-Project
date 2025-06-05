<?php
session_start();
require_once 'connection.php';

function clean($data) {
    return htmlspecialchars(trim($data));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login_id = clean($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$login_id || !$password) {
        $_SESSION['login_error'] = "Both Login ID and Password are required.";
        header("Location: login.php");
        exit;
    }

    // Admin login
    if (strtolower($login_id) === 'admin') {
        $admin_sql = "SELECT id, password FROM admin WHERE LOWER(username) = ?";
        $admin_stmt = mysqli_prepare($conn, $admin_sql);
        $lower_admin = strtolower($login_id);
        mysqli_stmt_bind_param($admin_stmt, "s", $lower_admin);
        mysqli_stmt_execute($admin_stmt);
        $admin_result = mysqli_stmt_get_result($admin_stmt);

        if ($admin_row = mysqli_fetch_assoc($admin_result)) {
            // WARNING: use password_hash for admin passwords in production!
            if (strtolower($password) === strtolower($admin_row['password'])) {
                $_SESSION['admin_id'] = $admin_row['id'];
                $_SESSION['role'] = 'admin';
                $_SESSION['role_id'] = 1; // hardcoded for admin
                $_SESSION['username'] = 'admin';
                $_SESSION['login_time'] = time();

                $display_name = 'Admin';
                $role_label = 'Administrator';
                $welcome_icon = '';
                $redirect_url = 'admin_dashboard.php';
                $custom_message = 'You are now logged in as an administrator.';
                goto login_success;
            }
        }
        $_SESSION['login_error'] = "Invalid admin credentials.";
        header("Location: login.php");
        exit;
    }

    // Normal user login (grab role_id from DB!)
    $sql = "SELECT id, username, password, membership_id, role_id FROM user WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $login_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) === 1) {
        mysqli_stmt_bind_result($stmt, $user_id, $username, $hash, $membership_id, $role_id);
        mysqli_stmt_fetch($stmt);

        if (password_verify($password, $hash)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['membership_id'] = $membership_id;
            $_SESSION['role_id'] = $role_id; // SET role_id in session!
            $_SESSION['role'] = 'user';
            $_SESSION['login_time'] = time();

            $display_name = $username;
            // You can make this dynamic: map role_id to string if you want
            $role_label = ($role_id == 2) ? "Operator" : (($role_id == 3) ? "Staff" : "Member");
            $welcome_icon = '✅';
            $redirect_url = ($role_id == 1 || $role_id == 2 || $role_id == 3) ? 'admin_dashboard.php' : 'main.php';
            $custom_message = 'You are now logged in.';

            goto login_success;
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    $_SESSION['login_error'] = "Invalid Login ID or Password.";
    header("Location: login.php");
    exit;

} else {
    header("Location: login.php");
    exit;
}

// ------- HTML OUTPUT FOR LOGIN SUCCESS (ADMIN OR MEMBER) -------
login_success:

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="refresh" content="2;url=<?= htmlspecialchars($redirect_url) ?>">
  <title>Welcome | Brew & Go</title>
  <link rel="stylesheet" href="styles/style.css">
</head>
<body>
  <div class="login-confirm-container">
    <div class="login-confirm-box">
      <div class="welcome-emoji"><?= $welcome_icon ?></div>
      <h2>Welcome, <?= htmlspecialchars($display_name) ?>!</h2>
      <div class="confirm-role"><?= htmlspecialchars($role_label) ?></div>
      <p><?= htmlspecialchars($custom_message) ?></p>
      <a href="<?= htmlspecialchars($redirect_url) ?>">
        <button class="login-confirm-btn">Go Now</button>
      </a>
      <div class="login-confirm-redirect">You will be redirected in 2 seconds...</div>
    </div>
  </div>
</body>
</html>
<?php
exit;
?>
