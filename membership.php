<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Bahrose Hassan Babar" />
    <title>Brew & Co. Coffee</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

    <div id="top"></div>

    <header>
        <?php
        include 'navbar.php';

        // Make sure session is started only once
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Restore form and error if present
        $membership_error = $_SESSION['membership_error'] ?? '';
        $membership_form = $_SESSION['membership_form'] ?? [];
        unset($_SESSION['membership_error'], $_SESSION['membership_form']);
        ?>
    </header>

    <!-- Membership Page -->
    <section class="membership-hero">
        <div class="membership-overlay">

            <!-- Top Section: Membership Info + QR -->
            <section class="membership-container">
                <div class="membership-content">
                    <div class="membership-details">
                        <section class="membership-benefit-section">
                            <h2 class="membership-section-title">Membership Perks</h2>
                            <div class="membership-text-cards">
                                <div class="membership-text-card">
                                    <h4>Exclusive Prices</h4>
                                    <p>Members can enjoy exclusive member prices.</p>
                                </div>
                                <div class="membership-text-card">
                                    <h4>Lucky Draw</h4>
                                    <p>A more attractive lucky draw prizes awaits.</p>
                                </div>
                                <div class="membership-text-card">
                                    <h4>Free Drinks</h4>
                                    <p>Psst: you may even get free drinks from us for <strong>FIVE DAYS STRAIGHT!!</strong></p>
                                </div>
                            </div>
                        </section>
                        <section class="membership-requirements">
                            <h3 class="membership-section-title">Requirements</h3>
                            <p class="membership-requirements-desc">Here’s what it takes to unlock our member privileges:</p>
                            <ul class="membership-requirement-list">
                                <li><span>01</span> Top-up RM30, RM50, RM100 or RM200</li>
                                <li><span>02</span> Credit is stored & non-refundable</li>
                                <li><span>03</span> Lifetime membership (no expiry)</li>
                                <li><span>04</span> Minimum RM30 required if balance is insufficient</li>
                            </ul>
                        </section>
                    </div>
                    <div class="membership-qr-card">
                        <h4 class="membership-qr-title">DUIT NOW</h4>
                        <img src="images/membership_qr.png" alt="DuitNow QR Code" class="membership-qr-img">
                        <p class="membership-qr-caption">Brew And Go SDN BHD</p>
                    </div>
                </div>
            </section>

            <!-- Bottom Section: Registration Form -->
            <section class="membership-form-section">
                <h2>Membership Registration</h2>
                <?php if ($membership_error): ?>
                    <div class="response-error"><?= htmlspecialchars($membership_error) ?></div>
                <?php endif; ?>
                <form class="membership-form" action="process_membership.php" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <label>First Name:
                            <input type="text" name="first_name" maxlength="25" pattern="[A-Za-z\s]+" required
                                value="<?= htmlspecialchars($membership_form['first_name'] ?? '') ?>">
                        </label>

                        <label>Last Name:
                            <input type="text" name="last_name" maxlength="25" pattern="[A-Za-z\s]+" required
                                value="<?= htmlspecialchars($membership_form['last_name'] ?? '') ?>">
                        </label>

                        <label>Email Address:
                            <input type="email" name="email" required
                                value="<?= htmlspecialchars($membership_form['email'] ?? '') ?>">
                        </label>

                        <label>Login ID:
                            <input type="text" id="login" name="login" maxlength="10" pattern="[A-Za-z]+" required
                                value="<?= htmlspecialchars($membership_form['login'] ?? '') ?>">
                        </label>

                        <label>Password:
                            <input type="text" id="password" name="password" maxlength="25" pattern="[A-Za-z]+" required>
                        </label>

                        <label>Payment Slip Upload:
                            <input type="file" name="payment_slip" id="payment_slip" accept=".jpg,.jpeg,.png,.pdf" required>
                        </label>

                        <div class="membership-button-group">
                            <button type="submit" class="btn-membership-submit">Submit</button>
                            <button type="reset" class="btn-membership-reset">Reset</button>
                        </div>
                    </fieldset>
                </form>
            </section>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
    <?php include 'backtotop.php'; ?>

</body>
</html>
