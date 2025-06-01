<?php
require_once 'connection.php';
date_default_timezone_set(timezoneId: 'Asia/Kuching');

// Current date and time for Asia/Kuching
$today = date('Y-m-d');
$now = date('H:i:s');

// Get search query from GET parameter
$search_query = isset($_GET['search']) ? strtolower(trim($_GET['search'])) : '';

// Build the SQL query with search filter
$sql = "
    SELECT * FROM activities
    WHERE (
        event_date < '$today'
        OR (event_date = '$today' AND end_time < '$now')
    )
";
if (!empty($search_query)) {
    $search_safe = mysqli_real_escape_string($conn, $search_query);
    $sql .= " AND LOWER(title) LIKE '%$search_safe%'";
}
$sql .= " ORDER BY event_date DESC, start_time DESC";


// Execute the query
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="author" content="Norman Zhi Wen Chung" />
  <title>Past Activities - Brew & Go</title>
  <link rel="stylesheet" href="styles/style.css" />
</head>

<body>
  <div id="top"></div>
  <?php include 'navbar.php'; ?>

  <section class="hero-header">
    <div class="banner-text">
      <div class="hero-text">
        <h1>Past Activities</h1>
        <a href="activities.php" class="back-button">Back</a>
      </div>
    </div>
  </section>

  <!-- Search Bar -->
  <div class="admin-search-sort-bar" style="margin: 20px auto; max-width: 600px; padding: 0 20px;">
      <form method="GET" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
          <div class="admin-search-sort-row" style="display: flex; gap: 15px; align-items: center;">
              <div class="admin-search-sort-group">
                  <label class="admin-search-sort-label" for="search">Search Event:</label>
                  <input class="admin-search-sort-input" type="text" id="search" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" placeholder="Enter event name" style="padding: 5px;">
              </div>
              <button class="admin-search-sort-btn" type="submit" style="padding: 5px 10px;">Search</button>
          </div>
      </form>
  </div>

  <section class="past-intro">
    <h2 class="past-banner-title">Previously at Brew & Go</h2>
    <p>Look back on the creative, caffeinated journey we've shared. Here are some of our favorite past moments!</p>
  </section>

  <?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($event = mysqli_fetch_assoc($result)): ?>
      <div class="past-event-card">
        <!-- Media Section -->
        <section class="past-media">
          <h2 class="media-section-title"><?= htmlspecialchars($event['title']) ?></h2>
          <div class="media-gallery">
            <?php if (!empty($event['image_path'])): ?>
              <figure>
                <img src="<?= htmlspecialchars($event['image_path']) ?>" alt="Event Image" />
                <figcaption><?= htmlspecialchars($event['title']) ?></figcaption>
              </figure>
            <?php endif; ?>
            <?php /* Add support for videos or additional media here if needed */ ?>
          </div>
        </section>
        <section class="past-info">
          <h2>Event Description</h2>
          <p><?= nl2br(htmlspecialchars($event['description'])) ?></p>
          <dl>
            <dt>Date</dt>
            <dd>
              <?= date('d M Y', strtotime($event['event_date'])) ?>
            </dd>
            <?php if (!empty($event['start_time']) && !empty($event['end_time'])): ?>
              <dt>Time</dt>
              <dd><?= date('g:i A', strtotime($event['start_time'])) ?> – <?= date('g:i A', strtotime($event['end_time'])) ?></dd>
            <?php endif; ?>
            <?php if (!empty($event['location'])): ?>
              <dt>Venue</dt>
              <dd><?= htmlspecialchars($event['location']) ?></dd>
            <?php endif; ?>
          </dl>
          <?php if (!empty($event['external_link'])): ?>
            <p>
              <a href="<?= htmlspecialchars($event['external_link']) ?>" target="_blank" class="event-link">More Info</a>
            </p>
          <?php endif; ?>
        </section>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <div class="past-event-card" style="text-align:center;margin:40px 0;font-size:1.2em;">
      No past activities yet<?php if (!empty($search_query)) echo " matching your search"; ?>. Stay tuned for updates!
    </div>
  <?php endif; ?>

  <aside class="past-aside">
    <h3>Did You Know?</h3>
    <p>
      From our humble coffee cart launch to major cultural events, Brew & Go has joined many memorable happenings across Kuching — each one brewing stronger community ties and unforgettable sips.
    </p>
  </aside>

  <?php include 'footer.php'; ?>
  <?php include 'backtotop.php'; ?>
</body>
</html>