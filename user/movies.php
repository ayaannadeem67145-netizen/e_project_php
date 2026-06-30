<?php
session_start();
include('header.php');
include('dbconfig.php');
if (!isset($_SESSION['user']) && isset($_COOKIE['user'])) {
    $_SESSION['user'] = $_COOKIE['user'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Movie Trailers</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter&family=Poppins:wght@600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      background-color: #000;
      color: #fff;
      font-family: 'Inter', sans-serif;
        padding: 0; /* ✅ No padding on body */
  line-height: 1.6;
      box-sizing: border-box;
       overflow-x: hidden;
    }

    h1.moviesTrailer {
      font-family: 'Poppins', sans-serif;
      text-align: center;
      margin: 40px 20px 20px;
      font-size: 34px;
      color: #e50914;
      letter-spacing: 0.5px;
    }

    .search-bar {
      text-align: center;
      margin: 20px 0 40px;
    }

    #searchInput {
  width: 90%;
  max-width: 400px;
  padding: 14px 18px;
  font-size: 16px;
  border-radius: 10px;
 border: 1px solid rgba(255, 255, 255, 0.2); /* light translucent white border */

  outline: none;
  background-color: #000; /* black background */
  color: #fff; /* white text */
}

/* Placeholder text color for all modern browsers */
#searchInput::placeholder {
  color: #fff;
  opacity: 1; /* Ensures full white opacity */
}

/* For Firefox */
#searchInput:-moz-placeholder {
  color: #fff;
  opacity: 1;
}

/* For Internet Explorer */
#searchInput:-ms-input-placeholder {
  color: #fff;
}


    .video-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 28px;
      padding: 0 20px 60px;
    }

    .video-card {
      background-color: #1a1a1a;
      color: #fff;
      width: 100%;
      max-width: 360px;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(255, 255, 255, 0.05);
      transition: transform 0.3s ease;
    }

    .video-card:hover {
      transform: translateY(-5px);
    }

    .video-card iframe {
      width: 100%;
      height: 210px;
      border: none;
    }

    .info {
      padding: 18px 16px 10px;
    }

    .info h4 {
      margin: 0 0 8px;
      font-size: 18px;
      font-family: 'Poppins', sans-serif;
      color: #f1f1f1;
    }

    .info p {
      font-size: 14px;
      color: #ccc;
      line-height: 1.5;
    }

    .reviews {
      padding: 0 16px 16px;
      font-size: 15px;
    }

    .reviews i {
      color: orange;
      margin-right: 3px;
    }

    @media (max-width: 480px) {
      .video-container {
        padding: 0 12px 40px;
      }

      .video-card iframe {
        height: 180px;
      }

      h1.moviesTrailer {
        font-size: 26px;
        margin-top: 24px;
      }

      .info h4 {
        font-size: 16px;
      }

      .info p {
        font-size: 13px;
      }

      #searchInput {
        padding: 12px 14px;
      }
    }
  </style>
</head>
<body>

<h1 class="moviesTrailer">Movie Trailers</h1>

<div class="search-bar">
  <input type="text" id="searchInput" placeholder="Search by trailer...">
</div>

<div class="video-container" id="videoList">
  <?php
  // Show admin-uploaded trailers first
  $result = mysqli_query($con, "SELECT * FROM movie_teasers ORDER BY uploaded_at DESC");
  while ($row = mysqli_fetch_assoc($result)) {
      $title = htmlspecialchars($row['title']);
      $description = htmlspecialchars($row['description']);
      $video_url = htmlspecialchars($row['video_url']);
      echo '
      <div class="video-card" data-title="' . strtolower($title) . '">
          <iframe src="' . $video_url . '" allowfullscreen></iframe>
          <div class="info">
              <h4>' . $title . '</h4>
              <p>' . $description . '</p>
          </div>
          <div class="reviews">
              <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
          </div>
      </div>';
  }
  ?>

  <div class="video-card" data-title="superman">
    <iframe src="https://www.youtube.com/embed/brI3gt9girI" allowfullscreen></iframe>
    <div class="info">
      <h4>Superman</h4>
      <p>A mind-bending thriller by Superman.</p>
    </div>
    <div class="reviews">
      <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
    </div>
  </div>

 <div class="video-card" data-title="Inception">
      <iframe src="https://www.youtube.com/embed/YoHD9XEInc0" allowfullscreen></iframe>
      <div class="info">
        <h4>Inception</h4>
        <p>A mind-bending thriller by Inception.</p>
      </div>
      <div class="reviews">
        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
      </div>
    </div>

    <div class="video-card" data-title="The Dark Knight">
  <iframe src="https://www.youtube.com/embed/EXeTwQWrcwY" allowfullscreen></iframe>
  <div class="info">
    <h4>The Dark Knight</h4>
    <p>A mind-bending thriller by The Dark Knight.</p>
  </div>
  <div class="reviews">
    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
  </div>
</div>

<div class="video-card" data-title="Avengers: Endgame">
  <iframe src="https://www.youtube.com/embed/TcMBFSGVi1c" allowfullscreen></iframe>
  <div class="info">
    <h4>Avengers: Endgame</h4>
    <p>A mind-bending thriller by Avengers.</p>
  </div>
  <div class="reviews">
    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
  </div>
</div>

<div class="video-card" data-title="Interstellar">
  <iframe src="https://www.youtube.com/embed/zSWdZVtXT7E" allowfullscreen></iframe>
  <div class="info">
    <h4>Interstellar</h4>
    <p>A mind-bending thriller by Interstellar.</p>
  </div>
  <div class="reviews">
    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
  </div>
</div>

<div class="video-card" data-title="Joker">
  <iframe src="https://www.youtube.com/embed/zAGVQLHvwOY" allowfullscreen></iframe>
  <div class="info">
    <h4>Joker</h4>
    <p>A mind-bending thriller by Joker.</p>
  </div>
  <div class="reviews">
    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
  </div>
</div>

<div class="video-card" data-title="Spider-Man: No Way Home">
  <iframe src="https://www.youtube.com/embed/JfVOs4VSpmA" allowfullscreen></iframe>
  <div class="info">
    <h4>Spider-Man: No Way Home</h4>
    <p>A mind-bending thriller by Spider-Man.</p>
  </div>
  <div class="reviews">
    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
  </div>
</div>

<div class="video-card" data-title="The Batman">
  <iframe src="https://www.youtube.com/embed/mqqft2x_Aa4" allowfullscreen></iframe>
  <div class="info">
    <h4>The Batman (2022)</h4>
    <p>A mind-bending thriller by Batman.</p>
  </div>
  <div class="reviews">
    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
  </div>
</div>
</div>

<?php include('footer.php'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
    $('#searchInput').on('keyup', function () {
      const value = $(this).val().toLowerCase();
      $('.video-card').filter(function () {
        $(this).toggle($(this).attr('data-title').toLowerCase().indexOf(value) > -1);
      });
    });
  });
</script>
</body>
</html>
