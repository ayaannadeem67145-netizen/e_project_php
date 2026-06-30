<?php
session_start();
include('dbconfig.php');

$method = $_GET['method'] ?? 'Unknown';
$booking = $_SESSION['booking'] ?? null;

if (!$booking) {
    echo "Invalid booking session.";
    exit();
}

$seatsArray = explode(',', $booking['seats']);
$event = $booking['event'];

// Check for already booked seats
$bookedQ = mysqli_query($con, "SELECT seat_id FROM tickets WHERE event = '$event' AND status='booked'");
$bookedSeats = [];
while ($r = mysqli_fetch_assoc($bookedQ)) {
    $bookedSeats[] = $r['seat_id'];
}

foreach ($seatsArray as $seat_id) {
    if (in_array($seat_id, $bookedSeats)) {
        echo "<script>alert('Seat $seat_id already booked!'); window.location.href='index.php';</script>";
        exit();
    }
}

date_default_timezone_set('Asia/Karachi');
$date_time = date('Y-m-d H:i:s');
$allInserted = true;

foreach ($seatsArray as $seat_id) {
    $insert = mysqli_query($con, "
        INSERT INTO tickets (name, email, seat_id, event, date, time, quantity, price, total, date_time, source, status)
        VALUES ('{$booking['name']}', '{$booking['email']}', '$seat_id', '{$booking['event']}', '{$booking['date']}', '{$booking['time']}', 1, '{$booking['price']}', '{$booking['price']}', '$date_time', 'web', 'booked')
    ");
    if (!$insert) {
        $allInserted = false;
        break;
    }
}

if ($allInserted) {
    // Save details for ticket rendering
    $movie_name = $booking['event'];
    $seats = explode(',', $booking['seats']);
    $show_time = $booking['time'];
    $date = $booking['date'];
    $booking_id = strtoupper(substr(md5(uniqid()), 0, 8));
    
    unset($_SESSION['booking']);
    unset($_SESSION['selected_method']);
} else {
    echo "<script>alert('Booking error.'); window.location.href='index.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Booking Confirmed</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: radial-gradient(circle at top, #1a0000, #000000);
      color: #fff;
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 30px 20px;
    }

    .confirmation-box {
      background: #111;
      border: 1px solid #e50914;
      padding: 50px 35px;
      border-radius: 16px;
      max-width: 520px;
      width: 100%;
      text-align: center;
      animation: fadeIn 0.6s ease-in;
      box-shadow: 0 0 25px rgba(229, 9, 20, 0.3);
    }

    .confirmation-box h2 {
      font-family: 'Bebas Neue', cursive;
      font-size: 34px;
      color: #e50914;
      margin-bottom: 25px;
      animation: pulse 2s infinite;
      letter-spacing: 1px;
    }

    .confirmation-box p {
      font-size: 16px;
      margin: 14px 0;
      line-height: 1.8;
      color: #ddd;
    }

    .back-link {
      display: inline-block;
      margin-top: 30px;
      padding: 14px 28px;
      background: #e50914;
      color: #fff;
      font-weight: bold;
      font-size: 16px;
      border-radius: 8px;
      text-decoration: none;
      transition: background 0.3s ease, transform 0.3s ease;
    }

    .back-link:hover {
      background: #ff0022;
      transform: scale(1.05);
    }

    .movie-ticket {
  margin-top: 30px;
  background: linear-gradient(135deg, #1f1f1f, #2e2e2e);
  color: white;
  font-family: 'Poppins', sans-serif;
  padding: 25px 30px;
  border-radius: 14px;
  width: 100%;
  max-width: 400px;
  margin-left: auto;
  margin-right: auto;
  box-shadow: 0 8px 20px rgba(255, 0, 0, 0.15);
  animation: fadeIn 1s ease-in-out;
  border: 2px dashed #e50914;
}


    .movie-ticket {
      background: linear-gradient(135deg, #1f1f1f, #2e2e2e);
      color: white;
      font-family: 'Poppins', sans-serif;
      padding: 25px 30px;
      border-radius: 18px;
      width: 320px;
      box-shadow: 0 12px 25px rgba(255, 0, 0, 0.2);
      animation: fadeIn 1s ease-in-out;
      border: 2px dashed #e50914;
    }

    .ticket-header {
      font-size: 20px;
      font-weight: bold;
      text-align: center;
      margin-bottom: 15px;
      border-bottom: 1px dashed #aaa;
      padding-bottom: 8px;
    }

    .ticket-body p {
      margin: 8px 0;
      font-size: 15px;
      color: #ddd;
    }

    @keyframes pulse {
      0%, 100% {
        text-shadow: 0 0 6px #e50914;
      }
      50% {
        text-shadow: 0 0 14px #ff0033;
      }
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes slideUp {
      from {
        transform: translateY(80px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    @media (max-width: 600px) {
      .confirmation-box {
        padding: 35px 22px;
      }

      .confirmation-box h2 {
        font-size: 26px;
      }

      .confirmation-box p {
        font-size: 15px;
      }

      .back-link {
        font-size: 15px;
        padding: 12px 22px;
        width: 100%;
      }
    }
  </style>
</head>
<body>

  <!-- Updated Confirmation HTML (inside <body>) -->
<div class="confirmation-box">
  <h2>🎉 Booking Confirmed!</h2>
  <p>Your payment via <strong><?= htmlspecialchars($method) ?></strong> has been successfully processed.</p>
  <p>Enjoy the show —<br>Thank you for choosing <b>Final Boss Cinema</b>!</p>

  <div class="movie-ticket">
    <div class="ticket-header">🎟 Final Boss Cinema</div>
    <div class="ticket-body">
      <p><strong>Movie:</strong> <?= htmlspecialchars($movie_name) ?></p>
      <p><strong>Date:</strong> <?= htmlspecialchars($date) ?></p>
      <p><strong>Time:</strong> <?= htmlspecialchars($show_time) ?></p>
      <p><strong>Seats:</strong> <?= htmlspecialchars(implode(', ', $seats)) ?></p>
      <p><strong>Booking ID:</strong> #<?= $booking_id ?></p>
    </div>
  </div>

  <a href="index.php" class="back-link">← Back to Home</a>
</div>


  <!-- Ticket Slide Sound Effect -->
  <audio id="ticketSound" autoplay>
    <source src="https://assets.mixkit.co/sfx/download/mixkit-fast-cartoon-slide-1094.wav" type="audio/wav">
  </audio>

</body>
</html>