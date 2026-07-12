<?php
session_start();

if (isset($_GET['platform'])) {
    $platform = $_GET['platform'];
    $user = ucfirst($platform) . " User";

    $_SESSION['user'] = $user; 
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign In | Movie Booking</title>
  <link rel="icon" type="image/x-icon" href="image/favicon-logo.ico">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Poppins&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #0d0d0d, #1a1a1a);
      color: white;
    }

    main {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      padding: 30px 20px;
    }

    .signin-box {
      background-color: #111;
      padding: 50px 40px;
      border-radius: 20px;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 0 30px rgba(255, 26, 26, 0.15);
      text-align: center;
      animation: fadeInUp 0.8s ease forwards;
      transform: translateY(20px);
      opacity: 0;
    }

    @keyframes fadeInUp {
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .signin-box h2 {
      font-family: 'Orbitron', sans-serif;
      font-size: 30px;
      margin-bottom: 36px;
      color: #ff1a1a;
      letter-spacing: 1px;
    }

    .social-buttons {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .social-buttons a {
      text-decoration: none;
      padding: 14px 16px;
      border-radius: 10px;
      font-size: 17px;
      font-weight: 600;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
      letter-spacing: 0.3px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .social-buttons a:hover {
      transform: scale(1.03);
    }

    .social-buttons a i {
      margin-right: 12px;
      font-size: 20px;
    }

    .google {
      background-color: #db4437;
    }
    .google:hover {
      background-color: #c23321;
    }

    .facebook {
      background-color: #1877f2;
    }
    .facebook:hover {
      background-color: #0e5ddf;
    }

    .x {
      background-color: #000;
      border: 1px solid #ccc;
    }
    .x:hover {
      background-color: #1a1a1a;
    }

    .footer {
      margin-top: 35px;
      font-size: 15px;
      display: flex;
      justify-content: center;
      gap: 16px;
      flex-wrap: wrap;
    }

    .footer a {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(255, 26, 26, 0.05);
      color: #bbb;
      padding: 10px 16px;
      border-radius: 8px;
      text-decoration: none;
      transition: all 0.3s ease;
      font-weight: 500;
      border: 1px solid transparent;
    }

    .footer a:hover {
      color: #fff;
      background: rgba(255, 26, 26, 0.15);
      border-color: #ff1a1a;
      transform: scale(1.05);
    }

    @media (max-width: 480px) {
      .signin-box {
        padding: 40px 25px;
      }

      .signin-box h2 {
        font-size: 26px;
      }

      .social-buttons a {
        font-size: 15px;
        padding: 12px 14px;
      }
    }

     @media (max-width: 768px) {
      .signin-box {
        padding: 40px 25px;
      }

      .signin-box h2 {
        font-size: 24px;
      }

      .social-buttons a {
        font-size: 15px;
        padding: 12px;
      }

      .social-buttons a i {
        font-size: 16px;
        margin-right: 10px;
      }

      .footer a {
        font-size: 14px;
        padding: 8px 14px;
      }
    }

    @media (max-width: 400px) {
      .signin-box h2 {
        font-size: 22px;
      }

      .social-buttons a {
        font-size: 14px;
        padding: 10px;
      }

      .footer {
        gap: 10px;
      }
    }
  </style>
</head>

<body>
  <main>
    <div class="signin-box">
      <h2>SIGN IN TO MY MOVIE</h2>
      <form action="signup.php" method="POST">
    
    <input type="text" name="name" placeholder="Full Name" required 
    style="width:100%; padding:12px; margin-bottom:15px; border-radius:8px; border:none;">

    <input type="email" name="email" placeholder="Email Address" required 
    style="width:100%; padding:12px; margin-bottom:15px; border-radius:8px; border:none;">

    <input type="password" name="password" placeholder="Password" required 
    style="width:100%; padding:12px; margin-bottom:20px; border-radius:8px; border:none;">

    <button type="submit" name="signup" style="width:100%; padding:14px; background:#ff1a1a; border:none; border-radius:10px; color:white; font-weight:bold;">
    Sign Up
</button>

</form>
      <div class="footer">
        <a href="login.php"><i class="fas fa-arrow-left"></i> Back to Login</a>
      </div>
    </div>
  </main>

</body>
</html>
