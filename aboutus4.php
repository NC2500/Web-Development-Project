<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Miaw Fong LIM" />
    <title>Bahrose Hassan Babar</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>

<div id="top"></div>
 
<header>
    <?php include 'navbar.php'; ?>
</header>

<section class="profile-container">

    <h1>Bahrose Hassan Babar</h1>
    <p class="student-number">Student Number:  102780935</p>
    <p class="course">Course: Bachelor of Electrical and Electronics Engineering</p>
    
    <div class="center-image">
        <img src="images/aboutus4.png" alt="Bahrose's Image">
    </div>
    
    <table class="info-table">
        <tr>
            <th>Category</th>
            <th>Details</th>
        </tr>
        <tr>
            <td>Gender</td>
            <td>Male</td>
        </tr>
        <tr>
            <td>Nationality</td>
            <td>Pakistan</td>
        </tr>
        <tr>
            <td>Hometown</td>
            <td>Multan</td>
        </tr>
        <tr>
            <td>Great Achievement</td>
            <td>My greatest achievement is being close to completing my degree in Bachelor of Electrical and Electronics Engineering. It's been a long and challenging journey, filled with learning and growth, and I’m proud of how far I’ve come.</td>
        </tr>

        <tr>
            <td>Favorites Music</td>
            <td class="videos">
                <strong>Ed Sheeran - Shivers</strong><br>
                <iframe src="https://www.youtube.com/embed/Il0S8BoucSA" allowfullscreen></iframe>

                <br><strong>Billie Eilish - Lovely (with Khalid)</strong><br>
                <iframe width="300" height="200" src="https://www.youtube.com/embed/V1Pl8CzNzCw" frameborder="0" allowfullscreen></iframe>

                <br><strong>The Weeknd - Blinding Lights</strong><br>
                <iframe src="https://www.youtube.com/embed/4NRXx6U8ABQ" allowfullscreen></iframe>

            </td>
        </tr>

        <tr>
            <td>Favourite Movies</td>
            <td>Inception<br><img src="images/Inception.png" alt=""><br><br>

            Interstellar<br><img src="images/Interstellar.png" alt="">
            </td>
        </tr>
    </table>
</section>

<div class="profile-email">
    <a href="mailto:102780935@students.swinburne.edu.my">
      <img src="images/icons8-email-32.png" alt="Email Icon">
    </a>
  </div>

     <!-- Footer -->
   <?php include 'footer.php'; ?>
   
    <?php include 'backtotop.php'; ?>
</body>
</html>