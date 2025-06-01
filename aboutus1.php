<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Miaw Fong LIM" />
    <title>Norman Zhi Wen Chung</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>

<div id="top"></div>

<header>
    <?php include 'navbar.php'; ?>
</header>

<section class="profile-container">
    <h1>Norman Zhi Wen Chung</h1>
    <p class="student-number">Student Number: 104387930</p>
    <p class="course">Course: Bachelor of Computer Science</p>
    
    <div class="center-image">
        <img src="images/aboutus1.png" alt="Norman's Image">
    </div>
    
    <table class="info-table">
        <tr>
            <th>Category</th>
            <th>Details</th>
        </tr>
        <tr>
            <td>Gender</td>
            <td>Female</td>
        </tr>
        <tr>
            <td>Nationality</td>
            <td>Malaysian</td>
        </tr>
        <tr>
            <td>Hometown</td>
            <td>Miri, Sarawak</td>
        </tr>
        <tr>
            <td>Great Achievement</td>
            <td>Getting pass on all subjects in my foundation studies.</td>
        </tr>
     
        <tr>
            <td>Favorites Music</td>
            <td class="videos">
                <strong>Beyond - 不再猶豫</strong><br>
                <iframe src="https://www.youtube.com/embed/2c_lHmkOq0E" allowfullscreen></iframe>

                <br><strong>Where Our Blue Is - Tatsuya Kitani</strong><br>
                <iframe src="https://www.youtube.com/embed/gcgKUcJKxIs" allowfullscreen></iframe>

                <br><strong>IDSMILE - Nightcord at 25</strong><br>
                <iframe src="https://www.youtube.com/embed/JTOM6fuXptg" allowfullscreen></iframe>

            </td>
        </tr>

        <tr>
            <td>Favourite Movies</td>
            <td>Puella Magi Madoka Magica<br><img src="images/madoka.png"></td>
        </tr>
    </table>
</section>

<div class="profile-email">
    <a href="mailto:104387930@students.swinburne.edu.my">
      <img src="images/icons8-email-32.png" alt="Email Icon">
    </a>
  </div>
  

  <!-- Footer -->
   <?php include 'footer.php'; ?>
   
    <?php include 'backtotop.php'; ?>
</body>
</html>