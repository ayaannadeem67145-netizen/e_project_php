<?php
session_start();
if (isset($_SESSION['preloader_shown'])) {
    header("Location: index.php");
    exit();
}
$_SESSION['preloader_shown'] = true;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Loading...</title>
  <link rel="icon" type="image/x-icon" href="image/favicon-logo.ico">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&family=Montserrat:wght@500&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background-color: #000;
      color: #e50914;
      font-family: 'Orbitron', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      overflow: hidden;
      padding: 20px;
    }

    .preloader-container {
      display: inline-flex;
      align-items: center;
      font-size: clamp(24px, 6vw, 42px);
      letter-spacing: 2px;
      white-space: nowrap; 
    }

    .logo-m {
      font-size: clamp(40px, 9vw, 60px);
      color: #e50914;
      animation: bounce 1.2s ease-out;
      font-weight: bold;
      margin-right: 8px;
      font-family: 'Montserrat', sans-serif;
      text-shadow: 0 0 15px #e50914;
    }

    .logo-text {
      font-family: 'Orbitron', sans-serif;
      overflow: hidden;
      border-right: 2px solid #e50914;
      animation: typing 2s steps(20) forwards, blink 0.6s step-end infinite;
      opacity: 0;
    }

    @keyframes bounce {
      0%   { transform: scale(0.2) translateY(100px); opacity: 0; }
      50%  { transform: scale(1.2) translateY(-10px); opacity: 1; }
      70%  { transform: scale(0.95) translateY(5px); }
      100% { transform: scale(1) translateY(0); }
    }

    @keyframes typing {
      0% { width: 0; opacity: 1; }
      100% { width: 18ch; opacity: 1; }
    }

    @keyframes blink {
      0%, 100% { border-color: transparent; }
      50% { border-color: #e50914; }
    }

    @media screen and (max-width: 480px) {
      .preloader-container {
        font-size: 28px;
      }

      .logo-m {
        font-size: 44px;
      }

      .logo-text {
        font-size: 24px;
      }
    }
  </style>
</head>
<body>
  <div class="preloader-container" id="preloader">
    <span class="logo-m">M</span>
    <span class="logo-text" id="text">yMovie Booking</span>
  </div>

  <script>
    setTimeout(() => {
      window.location.href = "index.php";
    }, 4000);
  </script>
</body>
</html>
