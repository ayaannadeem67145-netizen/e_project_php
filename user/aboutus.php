<?php
session_start();
include('header.php');


if (!isset($_SESSION['user']) && isset($_COOKIE['user'])) {
    $_SESSION['user'] = $_COOKIE['user'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>About Us | Movie Booking</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #0d0d0d;
      color: #eee;
      line-height: 1.7;
    }

    .about-container {
      max-width: 1100px;
      margin: 60px auto;
      padding: 40px 25px;
      text-align: center;
    }

    .about-container h1 {
      font-family: 'Bebas Neue', cursive;
      color: #ff1a1a;
      font-size: 52px;
      margin-bottom: 35px;
      letter-spacing: 1px;
    }

    .about-container p {
      font-size: 18px;
      margin-bottom: 40px;
      color: #ddd;
    }

    .gallery {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 25px;
      margin-bottom: 60px;
    }

    .gallery img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 12px;
      box-shadow: 0 4px 18px rgba(255, 0, 0, 0.4);
    }

    .team {
      background-color: #1a1a1a;
      padding: 50px 30px;
      border-radius: 12px;
      margin-bottom: 60px;
      text-align: center;
    }

    .team h2 {
      font-family: 'Bebas Neue', cursive;
      font-size: 36px;
      color: #ff1a1a;
      margin-bottom: 25px;
      letter-spacing: 1px;
    }

    .team p {
      font-size: 17px;
      max-width: 900px;
      margin: 0 auto;
      color: #ccc;
    }

    @media (max-width: 768px) {
      .about-container {
        padding: 20px;
      }

      .about-container h1 {
        font-size: 40px;
      }

      .team h2 {
        font-size: 30px;
      }
    }
  </style>
</head>
<body>

<div class="about-container">
  <h1>ABOUT US</h1>
  <p>
    Welcome to <strong>MyMovie Booking</strong>! We're dedicated to bringing you the best cinema experience right from your screen.
    Whether you're booking tickets or discovering new movies, our mission is to make it seamless, fast, and fun.
  </p>

  <div class="gallery">
    <img src="image/modern.jpg" alt="Modern cinema lobby">
    <img src="image/empty.jpg" alt="Empty theater seats">
    <img src="image/cozy.jpg" alt="Cozy home theater interior">
    <img src="image/stadium.jpg" alt="Stadium-style cinema screen">
    <img src="image/vintage.jpg" alt="Vintage film projector room">
    <img src="image/popcorn.jpg" alt="Popcorn counter at cinema">
  </div>

  <div class="team">
    <h2>Our Journey</h2>
    <p>
      Founded by movie lovers, MyMovie Booking started with a simple goal: to make movie-going effortless for everyone.
      Our team combines expertise in software, design, and cinema to deliver a platform that's both beautiful and powerful.
    </p>
  </div>

  <div class="team">
    <h2>Meet the Team</h2>
    <p>
      We're a passionate crew of developers, designers, and cinema enthusiasts who believe that every ticket should be just a click away.
    </p>
  </div>
</div>

<?php include('footer.php'); ?>
</body>
</html>
