<?php
include('header.php');
include('dbconfig.php');

if (!isset($_SESSION['user']) && isset($_COOKIE['user'])) {
    $_SESSION['user'] = $_COOKIE['user'];
}
$loggedIn = isset($_SESSION['user']);

$id = $_GET['id'];
$movie = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM movie WHERE id = '$id'"));
$details = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM movie_details WHERE movie_id = '$id'"));


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($movie['name']) ?> - Details</title>
  <link rel="icon" type="image/x-icon" href="image/favicon-logo.ico">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #000;
      color: #fff;
      margin: 0;
      font-family: 'Inter', sans-serif;
      line-height: 1.7;
      
    }

    .movie-cover {
      width: 100%;
      max-width: 320px;
      border-radius: 10px;
      box-shadow: 0 0 12px rgba(255, 0, 0, 0.4);
    }

    .movie-title {
       font-family: 'Montserrat', sans-serif;
      font-size: 2.2rem;
      margin-bottom: 24px;
      border-bottom: 2px solid red;
      padding-bottom: 12px;
      word-break: break-word;
      text-transform: capitalize;
      line-height: 1.4;
    }

    .movie-details p {
      font-size: 16px;
      margin-bottom: 14px;
      color: #ddd;
      font-family: 'Orbitron', sans-serif;
   text-transform: capitalize;
    }

    .btn-book {
      background-color: red;
      color: black;
      font-weight: bold;
      border: 2px solid black;
      padding: 12px 26px;
      font-size: 16px;
      transition: 0.3s ease;
      text-decoration: none;
      border-radius: 8px;
    }

    .btn-book:hover {
      background-color: darkred;
      color: white;
    }

    .blurred {
      filter: blur(6px);
      pointer-events: none;
      user-select: none;
    }

    #overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background-color: rgba(0, 0, 0, 0.9);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 999;
      padding: 20px;
    }

    .modal-box {
      background-color: #1a1a1a;
      padding: 40px 30px;
      border-radius: 10px;
      text-align: center;
      color: white;
      box-shadow: 0 0 20px red;
      width: 100%;
      max-width: 400px;
    }

    .modal-box h3 {
      font-family: 'Playfair Display', serif;
      margin-bottom: 25px;
    }

    .modal-box a {
      display: inline-block;
      margin: 10px 8px;
      text-decoration: none;
      background-color: red;
      color: black;
      padding: 10px 20px;
      border: 2px solid black;
      font-weight: bold;
      border-radius: 6px;
      transition: 0.3s;
    }

    .modal-box a:hover {
      background-color: darkred;
      color: white;
    }

    .container {
      padding-top: 60px;
      padding-bottom: 60px;
    }

    .movie-details {
      padding-left: 20px;
      padding-right: 20px;
    }

    @media screen and (max-width: 768px) {
      .movie-title {
        font-size: 1.7rem;
      }

      .movie-details p {
        font-size: 15px;
      }

      .btn-book {
        width: 100%;
        font-size: 15px;
        padding: 12px;
      }

      .modal-box {
        padding: 30px 20px;
      }

      .movie-cover {
        max-width: 90%;
        margin: 0 auto 20px auto;
      }
    }

    @media screen and (max-width: 480px) {
      .btn-book {
        font-size: 14px;
      }

      .movie-title {
        font-size: 1.4rem;
      }

      .movie-details {
        text-align: center;
      }

      .modal-box h3 {
        font-size: 18px;
      }
    }
    strong {
      color: red;
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>

<body>

<div id="mainContent">
  <div class="container py-5">
    <div class="row align-items-start">
      <div class="col-md-4 text-center mb-4 mb-md-0">
        <img src="<?= $movie['cover_image'] ?>" class="movie-cover" alt="Movie Cover">
      </div>
      <div class="col-md-8 movie-details">
        <h2 class="movie-title"><?= htmlspecialchars($movie['name']) ?></h2>
        <p><strong>Genre:</strong> <?= htmlspecialchars($movie['genre']) ?></p>
        <p><strong>Show Date:</strong> <?= $movie['show_date'] ?></p>
        <p><strong>Show Time:</strong> <?= $movie['show_time'] ?></p>
        <p><strong>Ticket Price:</strong> Rs. <?= $movie['ticket_price'] ?></p>

        <?php if ($details): ?>
          <p><strong>Duration:</strong> <?= $details['duration_hours'] ?>h <?= $details['duration_minutes'] ?>m</p>
          <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($details['description'])) ?></p>
        <?php endif; ?>

        <div class="mt-4 d-flex flex-wrap gap-3">
          <a href="#" class="btn btn-book" onclick="handleBooking(<?= $movie['id'] ?>)">Book Now</a>
          <a href="3d_cinema_demo.php" class="btn btn-book">Explore Cinema</a>
         


        </div>
      </div>
    </div>
  </div>
</div>

<div id="overlay">
  <div class="modal-box">
    <h3>Please sign up or log in to book tickets</h3>
    <a href="login.php">Login</a>
    <a href="signup.php">Sign Up</a>
  </div>
</div>

<?php include('footer.php'); ?>

<script>
  const isLoggedIn = <?= $loggedIn ? 'true' : 'false'; ?>;

  function handleBooking(movieId) {
    if (isLoggedIn) {
      window.location.href = `booktickets.php?id=${movieId}`;
    } else {
      document.getElementById('overlay').style.display = 'flex';
      document.getElementById('mainContent').classList.add('blurred');
    }
  }
</script>

</body>
</html>
