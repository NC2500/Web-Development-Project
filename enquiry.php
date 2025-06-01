<?php
if (session_status() === PHP_SESSION_NONE) session_start();
// Restore form data and error message if available
$enquiry_error = $_SESSION['enquiry_error'] ?? '';
$enquiry_form = $_SESSION['enquiry_form'] ?? [];
unset($_SESSION['enquiry_error'], $_SESSION['enquiry_form']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Bahrose Hassan Babar" />
    <title>Brew & Co. Coffee | Enquiry</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div id="top"></div>
    <header>
        <?php include 'navbar.php'; ?>
    </header>

    <section class="enquiry-hero">
        <div class="enquiry-overlay">
            <h2 class="enquiry-title">Enquiry</h2>
            <?php if ($enquiry_error): ?>
                <div class="response-error"><?= htmlspecialchars($enquiry_error) ?></div>
            <?php endif; ?>
            <form class="enquiry-form" action="process_enquiry.php" method="post">
            <fieldset>
                <label>First Name:
                <input type="text" name="first_name" maxlength="25" required
                value="<?= htmlspecialchars($enquiry_form['first_name'] ?? '') ?>">
                </label>

                <label>Last Name:
                <input type="text" name="last_name" maxlength="25" required
                value="<?= htmlspecialchars($enquiry_form['last_name'] ?? '') ?>">
                </label>

                <label>Email Address:
                <input type="email" name="email" required
                value="<?= htmlspecialchars($enquiry_form['email'] ?? '') ?>">
                </label>
                
                <fieldset class="enquiry-form-address">
                <legend><strong>Address</strong></legend>
                <label>Street Address:
                    <input type="text" name="street" maxlength="40" required
                    value="<?= htmlspecialchars($enquiry_form['street'] ?? '') ?>">
                </label>

                <label>City/Town:
                    <input type="text" name="city" maxlength="20" required
                    value="<?= htmlspecialchars($enquiry_form['city'] ?? '') ?>">
                </label>

                <label>State:
                    <select name="state" required>
                      <option value="">-- Select State --</option>
                      <?php
                        $states = ['Johor','Kedah','Kelantan','Malacca','Negeri Sembilan','Pahang','Penang','Perak','Perlis','Sabah','Sarawak','Selangor','Terengganu'];
                        foreach ($states as $state) {
                            $selected = (($enquiry_form['state'] ?? '') === $state) ? 'selected' : '';
                            echo "<option value=\"$state\" $selected>$state</option>";
                        }
                      ?>
                    </select>
                  </label>

                <label>Postcode:
                    <input type="text" name="postcode" maxlength="5" pattern="\d{5}" required
                    value="<?= htmlspecialchars($enquiry_form['postcode'] ?? '') ?>">
                </label>
                </fieldset>

                <label>Phone Number:
                    <input type="tel" name="phone" maxlength="10" placeholder="e.g. 0123456789" required
                    value="<?= htmlspecialchars($enquiry_form['phone'] ?? '') ?>">
                </label>
                
                <label>Type of Enquiry:
                <select name="enquiry_type" required>
                    <option value="">Select</option>
                    <?php
                        $types = ['Membership', 'Products', 'Pop-up Market'];
                        foreach ($types as $type) {
                            $selected = (($enquiry_form['enquiry_type'] ?? '') === $type) ? 'selected' : '';
                            echo "<option value=\"$type\" $selected>$type</option>";
                        }
                    ?>
                </select>
                </label>
                <label>Your Message:
                <textarea name="message" rows="5" required><?= htmlspecialchars($enquiry_form['message'] ?? '') ?></textarea>
                </label>
                
                <div class="button-group">
                    <button type="submit" class="btn-submit">Submit</button>
                    <button type="reset" class="btn-reset">Reset</button>
                </div>

            </fieldset>
            </form>
        </div>
    </section>
      
    <?php include 'footer.php'; ?>
    <?php include 'backtotop.php'; ?>
</body>
</html>
