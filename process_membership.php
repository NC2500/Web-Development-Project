<?php
session_start();
require_once 'connection.php';

function clean($data) {
    return htmlspecialchars(trim($data));
}

$response_type = '';
$response_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name  = clean($_POST['first_name'] ?? '');
    $last_name   = clean($_POST['last_name'] ?? '');
    $email       = clean($_POST['email'] ?? '');
    $login_id    = clean($_POST['login'] ?? '');
    $password    = clean($_POST['password'] ?? '');

    // Validate required fields
    if (!$first_name || !$last_name || !$email || !$login_id || !$password) {
        $response_type = 'error';
        $response_msg = 'All required fields must be filled in!';
    } else {
        // --- Handle Payment Slip Upload ---
        $payment_slip_path = '';
        if (isset($_FILES['payment_slip']) && $_FILES['payment_slip']['error'] === 0) {
            $allowed_ext = ['jpg','jpeg','png','pdf'];
            $file_ext = strtolower(pathinfo($_FILES['payment_slip']['name'], PATHINFO_EXTENSION));
            if (!in_array($file_ext, $allowed_ext)) {
                $response_type = 'error';
                $response_msg = 'Invalid payment slip file type.';
            } else {
                // Ensure uploads/payment_slip directory exists
                $upload_dir = 'uploads/payment_slip';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $payment_slip_path = $upload_dir . "/slip_" . uniqid() . "." . $file_ext;
                move_uploaded_file($_FILES['payment_slip']['tmp_name'], $payment_slip_path);
            }
        } else {
            $response_type = 'error';
            $response_msg = 'Payment slip is required.';
        }

        // If everything is valid, proceed to DB
        if ($response_type !== 'error') {
            // Check for unique email
            $sql_email = "SELECT id FROM membership WHERE email = ?";
            $stmt_email = mysqli_prepare($conn, $sql_email);
            mysqli_stmt_bind_param($stmt_email, "s", $email);
            mysqli_stmt_execute($stmt_email);
            mysqli_stmt_store_result($stmt_email);

            $email_exists = (mysqli_stmt_num_rows($stmt_email) > 0);

            mysqli_stmt_close($stmt_email);

            // Check for unique login ID
            $sql_login = "SELECT id FROM membership WHERE member_id = ?";
            $stmt_login = mysqli_prepare($conn, $sql_login);
            mysqli_stmt_bind_param($stmt_login, "s", $login_id);
            mysqli_stmt_execute($stmt_login);
            mysqli_stmt_store_result($stmt_login);

            $login_exists = (mysqli_stmt_num_rows($stmt_login) > 0);

            mysqli_stmt_close($stmt_login);

            if ($email_exists || $login_exists) {
                if ($email_exists && $login_exists) {
                    $errMsg = "Both the email and login ID are already registered.";
                } elseif ($email_exists) {
                    $errMsg = "The email address is already registered.";
                } else {
                    $errMsg = "The login ID is already registered.";
                }
                $_SESSION['membership_error'] = $errMsg;
                $_SESSION['membership_form'] = [
                    'first_name' => $first_name,
                    'last_name'  => $last_name,
                    'email'      => $email,
                    'login'      => $login_id
                ];
                header("Location: membership.php");
                exit;
            }
            else {
                // Insert into membership table
                $sql = "INSERT INTO membership (member_id, first_name, last_name, email, payment_slip, status, registered_at) VALUES (?, ?, ?, ?, ?, 'active', NOW())";
                $stmt2 = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt2, "sssss", $login_id, $first_name, $last_name, $email, $payment_slip_path);

                if (mysqli_stmt_execute($stmt2)) {
                    $membership_id = mysqli_insert_id($conn);

                    // Insert into user table (with hashed password!)
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $status = 'inactive';
                    $sql_user = "INSERT INTO user (username, password, membership_id, role_id) VALUES (?, ?, ?, 4)";
                    $stmt3 = mysqli_prepare($conn, $sql_user);
                    mysqli_stmt_bind_param($stmt3, "ssi", $login_id, $hash, $membership_id);
                    $user_success = mysqli_stmt_execute($stmt3);
                    mysqli_stmt_close($stmt3);
                    $response_type = ($user_success) ? 'success' : 'error';
                    $response_msg = ($user_success)
                        ? 'Membership registration successful! <br> You may now log in as a member.'
                        : 'Membership registered, but failed to create user login. Contact admin.';
                } else {
                    $response_type = 'error';
                    $response_msg = 'Failed to register membership: ' . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt2);
            }
        }
    }
    mysqli_close($conn);
} else {
    $response_type = 'error';
    $response_msg = 'Invalid request.';
}

// Render only on non-redirect errors and on success:
if ($response_type !== 'error' || (empty($_SESSION['membership_error']))) :
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Membership Registration | Brew & Go</title>
    <link rel="stylesheet" href="styles/style.css" />
</head>
<body>
    <div class="response-container">
        <?php if ($response_type === 'success'): ?>
            <div class="response-success"><?= $response_msg ?></div>
        <?php else: ?>
            <div class="response-error"><?= $response_msg ?></div>
        <?php endif; ?>
        <a href="login.php"><button class="response-btn">Login Here</button></a>
        <?php if ($response_type === 'success'): ?>
            <p class="redirect-btn">You may now proceed to the login page.</p>
        <?php endif; ?>
    </div>
</body>
</html>
<?php endif; ?>
