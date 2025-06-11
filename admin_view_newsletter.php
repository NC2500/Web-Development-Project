<?php
session_start();
require_once 'connection.php';
require_once 'auth.php';

$currentPage = basename($_SERVER['PHP_SELF']);

// Set timezone for correct date calculation!
date_default_timezone_set('Asia/Kuala_Lumpur');

// Check login and role
if (
    !isset($_SESSION['role_id']) || 
    (!isset($_SESSION['admin_id']) && !isset($_SESSION['user_id']))
) {
    header("Location: login.php");
    exit;
}

// Check page permission by role!
if (!checkPagePermission($conn, $currentPage, $_SESSION['role_id'])) {
    header("Location: no_access.php");
    exit;
}

// Handle search and sort parameters
$search_email = isset($_GET['search_email']) ? trim($_GET['search_email']) : '';
$search_subject = isset($_GET['search_subject']) ? trim($_GET['search_subject']) : '';
$sort_date = isset($_GET['sort_date']) ? $_GET['sort_date'] : 'desc';

// === PHPMailer include & settings ===
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;

// SMTP Settings
$mail_host = 'smtp.gmail.com';
$mail_username = 'zapydevtest@gmail.com';
$mail_password = 'zebw zcxr vesx fvsc';
$mail_from = 'zapydevtest@gmail.com';
$mail_from_name = 'Brew & Go Newsletter';

$feedback = '';
if (isset($_GET['status']) && $_GET['status'] === 'success') {
    $feedback = urldecode($_GET['message']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = trim($_POST['subject'] ?? '');
    $body = trim($_POST['body'] ?? '');
    $attachment_path = '';

    // Handle file upload (if any)
    if (!empty($_FILES['attachment']['name']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf'];
        $ext = strtolower(pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed_ext)) {
            $target_dir = 'Uploads/newsletter/';
            if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
            $basename = uniqid('newsletter_', true) . '.' . $ext;
            $attachment_path = $target_dir . $basename;
            move_uploaded_file($_FILES['attachment']['tmp_name'], $attachment_path);
        } else {
            $feedback = "<span style='color:#c0392b;'>Attachment type not allowed. Only image/PDF accepted.</span>";
        }
    }

    if ($subject && $body && !$feedback) {
        // Get all subscriber emails
        $emails = [];
        $sql = "SELECT email FROM newsletter_subscribers";
        if ($search_email !== '') {
            $sql .= " WHERE email LIKE ?";
        }
        $stmt = mysqli_prepare($conn, $sql);
        if ($search_email !== '') {
            $email_search = '%' . $search_email . '%';
            mysqli_stmt_bind_param($stmt, 's', $email_search);
        }
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($res)) {
            $emails[] = $row['email'];
        }
        mysqli_stmt_close($stmt);

        $email_count = 0;
        $send_errors = [];
        foreach ($emails as $to) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = $mail_host;
                $mail->SMTPAuth = true;
                $mail->Username = $mail_username;
                $mail->Password = $mail_password;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom($mail_from, $mail_from_name);
                $mail->addAddress($to);

                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = $body;

                // Add attachment if any
                if ($attachment_path && file_exists($attachment_path)) {
                    $mail->addAttachment($attachment_path);
                }

                $mail->send();
                $email_count++;
            } catch (Exception $e) {
                $send_errors[] = "Email to $to failed: " . $mail->ErrorInfo;
            }
        }

        if (empty($send_errors)) {
            $feedback = "<span style='color:#27ae60;'>Newsletter sent to $email_count subscribers.</span>";
        } else {
            $feedback = "<span style='color:#c0392b;'>Some emails failed:<br>" . implode('<br>', $send_errors) . "</span>";
        }

        // Save newsletter history
        $stmt = mysqli_prepare($conn, "INSERT INTO newsletter_history (subject, body, attachment_path) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'sss', $subject, $body, $attachment_path);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Redirect to prevent resubmission
        $query_params = http_build_query([
            'status' => 'success',
            'message' => $feedback,
            'search_email' => $search_email,
            'search_subject' => $search_subject,
            'sort_date' => $sort_date
        ]);
        header("Location: $currentPage?$query_params");
        exit;
    } else if (!$subject || !$body) {
        $feedback = "<span style='color:#c0392b;'>Please enter subject and message.</span>";
    }
}

// Fetch subscribers
$subscribers = [];
$sql = "SELECT email, subscribed_at FROM newsletter_subscribers";
if ($search_email !== '') {
    $sql .= " WHERE email LIKE ?";
}
$sql .= " ORDER BY subscribed_at " . ($sort_date === 'asc' ? 'ASC' : 'DESC');
$stmt = mysqli_prepare($conn, $sql);
if ($search_email !== '') {
    $email_search = '%' . $search_email . '%';
    mysqli_stmt_bind_param($stmt, 's', $email_search);
}
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
while ($row = mysqli_fetch_assoc($res)) {
    $subscribers[] = $row;
}
mysqli_stmt_close($stmt);

// Fetch newsletter history
$history = [];
$sql = "SELECT * FROM newsletter_history";
if ($search_subject !== '') {
    $sql .= " WHERE subject LIKE ?";
}
$sql .= " ORDER BY sent_at " . ($sort_date === 'asc' ? 'ASC' : 'DESC') . " LIMIT 20";
$stmt = mysqli_prepare($conn, $sql);
if ($search_subject !== '') {
    $subject_search = '%' . $search_subject . '%';
    mysqli_stmt_bind_param($stmt, 's', $subject_search);
}
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
if ($res === false) {
    $feedback .= "<span style='color:#c0392b;'>Error fetching newsletter history: " . mysqli_error($conn) . "</span>";
} else {
    while ($row = mysqli_fetch_assoc($res)) {
        $history[] = $row;
    }
}
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Newsletter Panel | Brew & Go Admin</title>
    <link rel="stylesheet" href="styles/style.css" />
</head>
<body class="admin-members-body">
<?php include 'navbar.php'; ?>
<div class="admin-wrapper">
    <?php include 'admin_sidebar.php'; ?>
    <div class="admin-activities-main">
        <header class="admin-activities-topbar">
            <div class="admin-activities-topbar-left">
                <span class="admin-activities-topbar-title">Newsletter Panel</span>
            </div>
            <div class="admin-activities-topbar-right">
                <a href="admin_dashboard.php" class="admin-activities-back-btn">← Back to Dashboard</a>
            </div>
        </header>
            <div class="admin-search-sort-bar">
                <form method="GET" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div style="display: flex; gap: 15px; align-items: center;">
                        <div>
                            <label for="search_email">Email:</label>
                            <input type="text" id="search_email" name="search_email" value="<?= htmlspecialchars($search_email) ?>" placeholder="Search by Email" style="padding: 5px;">
                        </div>
                        <div>
                            <label for="search_subject">Subject:</label>
                            <input type="text" id="search_subject" name="search_subject" value="<?= htmlspecialchars($search_subject) ?>" placeholder="Search by Subject" style="padding: 5px;">
                        </div>
                        <div>
                            <label for="sort_date">Sort by Date:</label>
                            <select id="sort_date" name="sort_date" style="padding: 5px;">
                                <option value="desc" <?= $sort_date === 'desc' ? 'selected' : ''; ?>>Newest First</option>
                                <option value="asc" <?= $sort_date === 'asc' ? 'selected' : ''; ?>>Oldest First</option>
                            </select>
                        </div>
                        <button type="submit" style="padding: 5px 10px;">Search</button>
                        <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="admin-clear-search-btn">Clear</a>
                    </div>
                    <input type="hidden" name="status" value="<?= htmlspecialchars($_GET['status'] ?? '') ?>">
                    <input type="hidden" name="message" value="<?= htmlspecialchars($_GET['message'] ?? '') ?>">
                </form>
            </div>
        <div class="newsletter-wrapper">
        <!-- Subscriber List -->
        <section class="admin-newsletter-subscribers">
            <h2>Subscribers (<?= count($subscribers) ?>)</h2>
            <?php if (empty($subscribers)): ?>
                <p>No subscribers found.</p>
            <?php else: ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Subscribed At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($subscribers as $sub): ?>
                            <tr>
                                <td><?= htmlspecialchars($sub['email']) ?></td>
                                <td><?= htmlspecialchars($sub['subscribed_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>     
        <form class="admin-newsletter-panel" action="<?= htmlspecialchars($_SERVER['PHP_SELF'] . '?' . http_build_query([
            'search_email' => $search_email,
            'search_subject' => $search_subject,
            'sort_date' => $sort_date
        ])) ?>" method="post" enctype="multipart/form-data">
            <?php if ($feedback): ?>
                <div class="feedback"><?= $feedback ?></div>
            <?php endif; ?>
            <h2>Newsletter
                <span style="font-size: 0.85em; font-weight: normal;">
                    (<?= date('l, d F Y') ?>)
                </span>
            </h2>
            <label for="subject">Subject*</label>
            <input type="text" name="subject" id="subject" required>

            <label for="body">Message</label>
            <textarea name="body" id="body" rows="8" required placeholder="Write your newsletter here. HTML allowed for formatting, links, etc."></textarea>

            <label for="attachment">Attachment (image or PDF, optional)</label>
            <input type="file" name="attachment" id="attachment" accept="image/*,.pdf">

            <button type="submit">Send Newsletter</button>
        </form>
        </div>
        <section class="admin-newsletter-history">
            <div class="admin-newsletter-history-title">
                <h2>Newsletter History</h2>
            </div>
            <?php if (empty($history)): ?>
                <p>No newsletter history available.</p>
            <?php else: ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Sent At</th>
                            <th>Attachment</th>
                            <th>Preview</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($history as $h): ?>
                            <tr>
                                <td><?= htmlspecialchars($h['subject']) ?></td>
                                <td><?= htmlspecialchars($h['sent_at']) ?></td>
                                <td>
                                    <?php if ($h['attachment_path']): ?>
                                        <div class="admin-newsletter-add-button">
                                            <a href="<?= htmlspecialchars($h['attachment_path']) ?>" target="_blank" style="text-decoration: none;">View</a>
                                        </div>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <details class="newsletter-details">
                                        <summary>Show</summary>
                                        <div style="max-width:350px;overflow-x:auto;"><?= htmlspecialchars($h['body']) ?></div>
                                    </details>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>