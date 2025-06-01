<?php
require_once 'connection.php';

// Get search query from GET parameter
$search_query = isset($_GET['search']) ? strtolower(trim($_GET['search'])) : '';

// Build the SQL query with search filter
$sql = "
    SELECT * FROM activities
    WHERE event_date > CURDATE()
";
if (!empty($search_query)) {
    $sql .= " AND LOWER(title) LIKE '%" . mysqli_real_escape_string($conn, $search_query) . "%'";
}
$sql .= " ORDER BY event_date ASC";

// Execute the query
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="author" content="Norman Zhi Wen Chung" />
  <title>Coming Soon - Brew & Go</title>
  <link rel="stylesheet" href="styles/style.css" />
</head>

<body>
  <div id="top"></div>

  <?php include 'navbar.php'; ?>

  <section class="hero-header">
    <div class="banner-text">
      <div class="hero-text">
        <h1>Coming Soon</h1>
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

  <section class="coming-intro">
    <h2 class="coming-banner-title">Upcoming Special Events</h2>
    <p>Mark your calendar — something exciting is brewing at Brew & Go. Here are our upcoming events!</p>
  </section>

  <?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($event = mysqli_fetch_assoc($result)): ?>
      <div class="coming-event-card">
        <!-- Media Section -->
        <section class="coming-media">
          <h2 class="media-section-title"><?= htmlspecialchars($event['title']) ?></h2>
          <div class="media-gallery">
            <?php if (!empty($event['image_path'])): ?>
              <figure>
                <img src="<?= htmlspecialchars($event['image_path']) ?>" alt="Event Image" />
                <figcaption><?= htmlspecialchars($event['title']) ?></figcaption>
              </figure>
            <?php endif; ?>
            <?php /* You can add logic here to support event videos if needed */ ?>
          </div>
        </section>

        <!-- About Section -->
        <section class="coming-info">
          <h2>Event Description</h2>
          <p><?= nl2br(htmlspecialchars($event['description'])) ?></p>
          <dl>
            <dt>Booth Operating Hours</dt>
            <dd>
              <?= date('g:i A', strtotime($event['start_time'])) ?> – 
              <?= date('g:i A', strtotime($event['end_time'])) ?>,
              <?= date('d M Y', strtotime($event['event_date'])) ?>
              <?= $event['location'] ? " ({$event['location']})" : "" ?>
            </dd>
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
    <div class="coming-event-card" style="text-align:center;margin:40px 0;font-size:1.2em;">
      No upcoming events at the moment<?php if (!empty($search_query)) echo " matching your search"; ?>.
    </div>
  <?php endif; ?>

  <aside class="coming-aside">
    <h3>Did You Know?</h3>
    <p>
      This is Brew & Go’s fourth appearance at a cultural community event — and it keeps getting better each time.
    </p>
  </aside>

  <?php include 'footer.php'; ?>
  <?php include 'backtotop.php'; ?>
</body>
</html>