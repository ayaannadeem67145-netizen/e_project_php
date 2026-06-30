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
  <title>Help & Support | MyMovie Booking</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <link href="https://fonts.googleapis.com/css2?family=Inter&family=Poppins:wght@600;700&display=swap" rel="stylesheet">

  <style>
    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background-color: #0d0d0d;
      color: #fff;
       overflow-x: hidden;
      padding: 0;
      line-height: 1.6;
      box-sizing: border-box;
    }

    .container {
      max-width: 1200px;
      margin: 50px auto;
      padding: 0 24px;
     
    }

    h1 {
      font-family: 'Poppins', sans-serif;
      text-align: center;
      color: #ff1a1a;
      font-size: 34px;
      margin-bottom: 50px;
    }

    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 30px;
      margin-bottom: 60px;
    }

    .card {
      background-color: #1a1a1a;
      border-radius: 14px;
      padding: 24px 22px;
      border: 1px solid #ff0000ff;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      box-shadow: 0 0 12px rgba(255, 0, 0, 0.08);
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 0 20px rgba(255, 0, 0, 0.2);
    }

    .card h3 {
      font-family: 'Poppins', sans-serif;
      color: #ff0000ff;
      font-size: 21px;
      margin-bottom: 14px;
    }

    .card p {
      font-size: 15.5px;
      color: #cccccc;
      line-height: 1.6;
    }

    .map-section {
      margin-top: 60px;
    }

    .map-section h2 {
      font-family: 'Poppins', sans-serif;
      text-align: center;
      color: #ff1a1a;
      margin-bottom: 25px;
      font-size: 26px;
    }

    iframe {
      width: 100%;
      height: 420px;
      border: 0;
      border-radius: 10px;
    }

    

    @media (max-width: 768px) {
      h1 {
        font-size: 28px;
        margin-bottom: 35px;
      }

      .card h3 {
        font-size: 18px;
      }

      .card p {
        font-size: 14px;
      }

      .map-section h2 {
        font-size: 20px;
      }
    }

    @media (max-width: 480px) {
      .container {
        padding: 0 16px;
      }

      h1 {
        font-size: 24px;
      }

      .card {
        padding: 20px 16px;
      }

      .map-section h2 {
        font-size: 18px;
      }

      iframe {
        height: 350px;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Help & Support</h1>

    <div class="cards">
      <div class="card">
        <h3>Account Help</h3>
        <p>Need help creating an account or resetting your password? We're here to guide you step-by-step.</p>
      </div>
      <div class="card">
        <h3>Booking Assistance</h3>
        <p>Having trouble booking your ticket? Learn how to pick your seats, showtimes, and payment methods.</p>
      </div>
      <div class="card">
        <h3>Refund & Cancellation</h3>
        <p>Want to cancel or change your ticket? See our policy and how to proceed with refunds.</p>
      </div>
      <div class="card">
        <h3>Contact Support</h3>
        <p>Still need help? Contact our support team via email, live chat, or phone call.</p>
      </div>
    </div>

    <div class="map-section">
      <h2>Visit Us at Dolmen Mall, Tariq Road</h2>
      <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3620.111147126064!2d67.06616037530826!3d24.861639245839377!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb33f72ec7a4ae3%3A0x570fc2c8e6c1a42b!2sDolmen%20Mall%20Tariq%20Road!5e0!3m2!1sen!2s!4v1720429031679!5m2!1sen!2s"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
  </div>

<?php include('footer.php'); ?>
</body>
</html>
