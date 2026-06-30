<?php
require_once '../includes/auth.php';
require_role(ROLE_USER);

include('dbconfig.php');
include('header.php');

$user_email = $_SESSION['user'];
global $con;

if (isset($_GET['cancel_id'])) {
    $cancel_id = $_GET['cancel_id'];
    $check = mysqli_query($con, "SELECT * FROM tickets WHERE id='$cancel_id' AND email='$user_email' AND LOWER(status)='booked'");
    if (mysqli_num_rows($check) > 0) {
        mysqli_query($con, "UPDATE tickets SET status='cancelled' WHERE id='$cancel_id'");
        echo "<script>alert('Ticket cancelled successfully.'); window.location.href='my_bookings.php';</script>";
        exit();
    } else {
        echo "<script>alert('Invalid ticket or already cancelled.');</script>";
    }
}

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$total_query = mysqli_query($con, "SELECT COUNT(*) AS total FROM tickets WHERE email='$user_email'");
$total_row = mysqli_fetch_assoc($total_query);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Bookings query
$bookings = mysqli_query($con, "SELECT * FROM tickets WHERE email='$user_email' ORDER BY date_time DESC LIMIT $limit OFFSET $offset");

// Reward system
$reward_query = mysqli_query($con, "
    SELECT SUM(quantity) as total 
    FROM tickets 
    WHERE email='$user_email' 
    AND (LOWER(status)='booked' OR LOWER(status)='completed')
");
$reward_result = mysqli_fetch_assoc($reward_query);
$totalTickets = $reward_result['total'] ?? 0;

$reward = "";
if ($totalTickets >= 50) {
    $reward = "🏆 VIP Badge Unlocked! You're a true movie lover!";
} elseif ($totalTickets >= 30) {
    $reward = "💸 15% Discount Code: <strong>MOVIE30</strong>";
} elseif ($totalTickets >= 25) {
    $reward = "🎟️ Free Movie Ticket Unlocked!";
} elseif ($totalTickets >= 20) {
    $reward = "🥤 Free Soft Drink Unlocked!";
} elseif ($totalTickets >= 10) {
    $reward = "🍿 Free Popcorn Unlocked!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>My Bookings</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&family=Open+Sans&display=swap" rel="stylesheet">
  <style>
    body {
      overflow-x: hidden;
      background-color: #0d0d0d;
      color: #f0f0f0;
      font-family: 'Open Sans', sans-serif;
      margin: 0;
      padding: 0;
      line-height: 1.6;
      box-sizing: border-box;
    }

    .page-content {
      padding: 30px 20px;
    }

    h2 {
      font-family: 'Montserrat', sans-serif;
      text-align: center;
      margin-bottom: 40px;
      color: #ff1a1a;
      font-size: 32px;
      margin-top: 40px;
    }

    .container {
      max-width: 1250px;
      margin: auto;
    }

    .reward-box {
      background-color: #1f1f1f;
      border-left: 6px solid #ff0202ff;
      padding: 20px 25px;
      border-radius: 12px;
      margin-bottom: 30px;
    }

    .reward-box strong {
      font-family: 'Montserrat', sans-serif;
      font-size: 20px;
      display: block;
      margin-bottom: 6px;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
      border: none;
    }

    .table th {
      background-color: #1c1c1c;
      color: #ff0000ff;
      font-weight: 600;
      font-family: 'Montserrat', sans-serif;
      padding: 14px;
      border: none;
    }

    .table td {
      background-color: #1a1a1a;
      color: #ddd;
      padding: 14px 12px;
      border: none;
    }

    .table tr:not(:last-child) td {
      border-bottom: 1px solid #2c2c2c;
    }

    .table tr:hover td {
      background-color: #2a2a2a;
    }

    .cancel-btn {
      background-color: #ff0000ff;
      color: white;
      border: none;
      padding: 7px 14px;
      border-radius: 6px;
      font-size: 14px;
      transition: 0.3s ease;
      font-weight: 500;
      text-decoration: none;
      display: inline-block;
      cursor: pointer;
    }

    .cancel-btn:hover {
      background-color: #ff0000ff;
      color: white;
      box-shadow: 0 0 8px rgba(255, 0, 0, 0.6);
      transform: scale(1.05);
    }

    .debug-text {
      font-size: 0.9rem;
      color: #bbbbbb;
      margin-bottom: 25px;
    }

    .pagination .page-link {
      background-color: #1a1a1a;
      color: #fff;
      border: 1px solid #333;
    }

    .pagination .page-item.active .page-link {
      background-color: #ff0000ff;
      border-color: #ff0000ff;
      color: #fff;
    }

    .pagination .page-link:hover {
      background-color: #ff0000ff;
      color: #fff;
      border-color: #ff0000ff;
    }

    @media (max-width: 768px) {
      .reward-box {
        font-size: 0.95rem;
      }

      .table th,
      .table td {
        font-size: 0.85rem;
        padding: 10px;
      }

      h2 {
        font-size: 24px;
        margin-bottom: 30px;
      }
    }

    @media (max-width: 480px) {
      .reward-box {
        padding: 16px;
      }

      .cancel-btn {
        padding: 6px 12px;
      }

      .debug-text {
        font-size: 0.8rem;
      }
    }
  </style>
</head>

<body>
<div class="page-content">
  <h2>🎟️ My Bookings</h2>

  <div class="container">

    <?php if ($reward): ?>
      <div class="reward-box">
        <strong>🎁 Congratulations!</strong> <?= $reward ?>
        <span style="font-size: 0.85rem; color: #aaa;">(Total tickets purchased: <?= $totalTickets ?>)</span>
      </div>
    <?php endif; ?>

    <div class="debug-text">[Debug] Tickets counted: <?= $totalTickets ?></div>

    <div class="table-responsive">
      <table class="table text-center">
        <thead>
          <tr>
            <th>#</th>
            <th>Event</th>
            <th>Date</th>
            <th>Time</th>
            <th>Qty</th>
            <th>Total</th>
            <th>Status</th>
            <th>Cancel</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = $offset + 1;
          while ($row = mysqli_fetch_assoc($bookings)) {
            echo "<tr>
                    <td>{$i}</td>
                    <td>{$row['event']}</td>
                    <td>{$row['date']}</td>
                    <td>{$row['time']}</td>
                    <td>{$row['quantity']}</td>
                    <td>Rs. {$row['total']}</td>
                    <td>" . ucfirst($row['status']) . "</td>
                    <td>";
            if (strtolower($row['status']) === 'booked') {
                echo "<a class='cancel-btn' href='my_bookings.php?cancel_id={$row['id']}' onclick=\"return confirm('Are you sure you want to cancel this ticket?');\">Cancel</a>";
            } else {
                echo "-";
            }
            echo "</td></tr>";
            $i++;
          }

          if ($i == $offset + 1) {
            echo "<tr><td colspan='8'>No bookings found.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>

    <?php if ($total_pages > 1): ?>
      <nav aria-label="Page navigation" style="margin-top: 25px;">
        <ul class="pagination justify-content-center">
          <?php if ($page > 1): ?>
            <li class="page-item">
              <a class="page-link" href="?page=<?= $page - 1 ?>">&laquo; Prev</a>
            </li>
          <?php endif; ?>

          <?php for ($p = 1; $p <= $total_pages; $p++): ?>
            <li class="page-item <?= $p == $page ? 'active' : '' ?>">
              <a class="page-link" href="?page=<?= $p ?>"><?= $p ?></a>
            </li>
          <?php endfor; ?>

          <?php if ($page < $total_pages): ?>
            <li class="page-item">
              <a class="page-link" href="?page=<?= $page + 1 ?>">Next &raquo;</a>
            </li>
          <?php endif; ?>
        </ul>
      </nav>
    <?php endif; ?>

  </div>
</div>
</body>
</html>
