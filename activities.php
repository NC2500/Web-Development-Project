<?php
require_once 'connection.php';
date_default_timezone_set('Asia/Kuching');

// Get today's date and time
$today = date('Y-m-d');
$now = date('H:i:s');

// Coming Soon: Next upcoming event
$coming = mysqli_query($conn, "
    SELECT * FROM activities
    WHERE event_date > '$today'
    ORDER BY event_date ASC, start_time ASC
    LIMIT 1
");
$coming_event = mysqli_fetch_assoc($coming);

// Current: Happening now
$current = mysqli_query($conn, "
    SELECT * FROM activities
    WHERE event_date = '$today'
      AND start_time <= '$now' AND end_time >= '$now'
    ORDER BY start_time ASC
    LIMIT 1
");
$current_event = mysqli_fetch_assoc($current);

// Past: Most recent past event
$past = mysqli_query($conn, "
    SELECT * FROM activities
    WHERE event_date < '$today'
       OR (event_date = '$today' AND end_time < '$now')
    ORDER BY event_date DESC, start_time DESC
    LIMIT 1
");
$past_event = mysqli_fetch_assoc($past);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="author" content="Tammy Ru Xiu TAY" />
  <title>Our Activities - Brew & Go</title>
  <link rel="stylesheet" href="styles/style.css" />
</head>

<body>
  <div id="top"></div>
  <div class="main-wrapper">
    <?php include 'navbar.php'; ?>

    <section class="activities-entry-page">
      <h1>Our Activities</h1>
      <p>Explore what's happening at Brew & Go:</p>
      <div class="activities-grid">

        <!-- Coming Soon -->
        <div class="activities-card">
          <a href="coming_soon.php">
            <?php if ($coming_event && !empty($coming_event['image_path'])): ?>
              <img src="<?= htmlspecialchars($coming_event['image_path']) ?>" alt="Coming Soon Activities" />
            <?php else: ?>
              <img src="images/CS/Seni Kita Weekend 4.0.jpg" alt="Coming Soon Activities" />
            <?php endif; ?>
            <h3>Coming Soon</h3>
            <?php if ($coming_event): ?>
              <p><strong><?= htmlspecialchars($coming_event['title']) ?></strong><br>
                <?= date('d M Y', strtotime($coming_event['event_date'])) ?>
              </p>
            <?php else: ?>
              <p>Exciting activities coming your way – stay tuned!</p>
            <?php endif; ?>
          </a>
        </div>

        <!-- Current -->
        <div class="activities-card">
          <a href="current.php">
            <?php if ($current_event && !empty($current_event['image_path'])): ?>
              <img src="<?= htmlspecialchars($current_event['image_path']) ?>" alt="Current Activities" />
            <?php else: ?>
              <img src="images/Current/Grand Opening 2.0.jpg" alt="Current Activities" />
            <?php endif; ?>
            <h3>Current Activities</h3>
            <?php if ($current_event): ?>
              <p><strong><?= htmlspecialchars($current_event['title']) ?></strong><br>
                Happening now!
              </p>
            <?php else: ?>
              <p>Check out what's happening now at Brew & Go.</p>
            <?php endif; ?>
          </a>
        </div>

        <!-- Past Activities -->
        <div class="activities-card">
          <a href="past_activities.php">
            <?php if ($past_event && !empty($past_event['image_path'])): ?>
              <img src="<?= htmlspecialchars($past_event['image_path']) ?>" alt="Past Activities" />
            <?php else: ?>
              <img src="images/Past/Seni Kita Weekend 1.0 v1.jpg" alt="Past Activities" />
            <?php endif; ?>
            <h3>Past Activities</h3>
            <?php if ($past_event): ?>
              <p><strong><?= htmlspecialchars($past_event['title']) ?></strong><br>
                <?= date('d M Y', strtotime($past_event['event_date'])) ?>
              </p>
            <?php else: ?>
              <p>Throwback to some of our amazing past events.</p>
            <?php endif; ?>
          </a>
        </div>

      </div>
    </section>
  </div>

  <?php include 'footer.php'; ?>
  <?php include 'backtotop.php'; ?>
</body>
</html>
