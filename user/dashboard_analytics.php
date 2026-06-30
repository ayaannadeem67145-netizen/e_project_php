<?php
include('dashheader.php');
include('dbconfig.php');

$booked = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM tickets WHERE status='booked'"))['total'];
$cancelled = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM tickets WHERE status='cancelled'"))['total'];
$max_seats = 200;
$booked_qty = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(quantity) AS total FROM tickets WHERE status='booked'"))['total'] ?? 0;
$occupancy = round(($booked_qty / $max_seats) * 100);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Analytics</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      background: #000;
      color: #fff;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .content {
      margin-left: 350px; 
      padding: 30px 20px;
    }

    h2, h3 {
      margin-bottom: 20px;
    }

    .bar-container {
      background: #333;
      border-radius: 10px;
      overflow: hidden;
      margin-top: 40px;
      max-width: 600px;
    }

    .bar-fill {
      background: #00e676;
      padding: 12px;
      text-align: center;
      color: black;
      font-weight: bold;
      font-size: 16px;
      transition: width 0.3s ease-in-out;
    }

    canvas {
      max-width: 500px;
      background: #111;
      border-radius: 8px;
      padding: 10px;
    }

    @media screen and (max-width: 768px) {
      .content {
        margin-left: 0;
        padding: 20px;
      }

      canvas {
        width: 100% !important;
        height: auto !important;
      }
    }
  </style>
</head>
<body>
  <div class="content">
    <h2>📊 Cancelled vs Booked Tickets</h2>
    <canvas id="ticketChart" width="400" height="200"></canvas>
    <script>
      const ctx = document.getElementById('ticketChart').getContext('2d');
      const ticketChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: ['Booked', 'Cancelled'],
          datasets: [{
            data: [<?= $booked ?>, <?= $cancelled ?>],
            backgroundColor: ['#00c853', '#d50000']
          }]
        },
        options: {
          plugins: {
            legend: {
              labels: {
                color: '#fff',
                font: { size: 14 }
              }
            }
          }
        }
      });
    </script>

    <h3 class="mt-5">🎟️ Seat Occupancy</h3>
    <div class="bar-container">
      <div class="bar-fill" style="width: <?= $occupancy ?>%;">
        <?= $occupancy ?>% Occupied (<?= $booked_qty ?> / <?= $max_seats ?>)
      </div>
    </div>
  </div>
</body>
</html>
