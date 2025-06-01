<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Miaw Fong LIM" />
    <title>Miaw Fong Lim</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>

<div id="top"></div>

<header>
    <?php include 'navbar.php'; ?>
</header>


<section class="profile-container">

    <h1>Miaw Fong LIM</h1>
    <p class="student-number">Student Number: 104406013</p>
    <p class="course">Course: Bachelor of Computer Science</p>
    
    <div class="center-image">
        <img src="images/aboutus3.png" alt="Lim's Image">
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
            <td>Kuching, Sarawak</td>
        </tr>
        <tr>
            <td>Great Achievement</td>
            <td>One of my greatest achievements in life was successfully completing my Diploma in International Business and then pursuing a Degree in Computer Science. Transitioning from business to technology was challenging, as I had to learn new concepts and develop technical skills from scratch. However, through dedication, continuous learning, and perseverance, I adapted to the new field and excelled in my studies.</td>
        </tr>
        <tr>
            <td>Favorites Book</td>
            <td>
                Game of Throne<br><img src="images/ClashOfKings.png" alt="Book Cover">
            </td>
        </tr>

        <tr>
            <td>Favorites Music</td>
            <td class="videos">
                <strong>Hideyoshi - Majinahanashi</strong><br>
                <iframe src="https://www.youtube.com/embed/9a3sPzbG68I" allowfullscreen></iframe>

                <br><strong>Awich, 唾奇, OZworld, CHICO CARLITO - RASEN in OKINAWA (Prod. Diego Ave)</strong><br>
                <iframe src="https://www.youtube.com/embed/p6vM08MGoQ8" allowfullscreen></iframe>

                <br><strong>Creeds - Push Up </strong><br>
                <iframe src="https://www.youtube.com/embed/BGrBuUF4UqA" allowfullscreen></iframe>

            </td>
        </tr>

        <tr>
            <td>Favourite Movies</td>
            <td>The Green Mile<br><img src="images/TheGreenMile.png" alt="Movie Poster"></td>
        </tr>
    </table>
</section>


<div class="profile-email">
    <a href="mailto:104406013@students.swinburne.edu.my">
      <img src="images/icons8-email-32.png" alt="Email Icon">
    </a>
  </div>


  <!-- Footer -->
   <?php include 'footer.php'; ?>
   
    <?php include 'backtotop.php'; ?>
</body>
</html>