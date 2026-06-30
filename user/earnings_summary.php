<?php
include('dashheader.php');
include('dbconfig.php');


if (isset($_POST['reset_earnings'])) {

  mysqli_query($con, "
        INSERT INTO ticket_archive (name, email, event, date, time, quantity, price, total)
        SELECT name, email, event, date, time, quantity, price, total 
        FROM tickets 
        WHERE source = 'summary'
    ");


    mysqli_query($con, "DELETE FROM tickets WHERE source = 'summary'");

    echo "<script>alert('Earnings have been archived and reset.'); location.href='earnings_summary.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Earnings Summary</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
body {
  background-color: #000;
  color: white;
  font-family: Arial, sans-serif;
}

h2, h4 {
  color: #e50914;
}

.earnings-wrapper {
  margin-left: 25%;
  width: 70%;
}

.form-control::placeholder {
  color: white;
  opacity: 0.6;
}

.btn-danger {
  background-color: #e50914;
  border: none;
}

.btn-danger:hover {
  background-color: #ff0a16;
}

/* === Updated Table Styling Like dashboard.php === */

.table {
  background-color: transparent;
  color: white;
  border-collapse: separate;
  border-spacing: 0;
  box-shadow: 0 0 10px rgba(229, 9, 20, 0.3);
  border-radius: 8px;
  overflow: hidden;
}

.table thead th {
  background-color: #1a1a1a;
  color: #ff0000ff;
  border-bottom: 2px solid #ff000dff;
  border-top: none;
  border-left: none;
  border-right: none;
}

.table th, .table td {
  vertical-align: middle;
  background-color: #111;
  color: white;
  text-align: center;
  padding: 12px 15px;
  border: none;
}

.table tbody tr {
  border-bottom: 1px solid #333;
}

.table tbody tr:hover {
  background-color: #1a1a1a;
}



  </style>
</head>
<body>

  <div class="earnings-wrapper mt-5">
    <form method="POST">
      <button type="submit" name="reset_earnings" class="btn btn-danger mb-4">
        <i class="fas fa-rotate-right"></i> Refresh Earnings
      </button>
    </form>

    <h2>🎬 Movie-wise Earnings Summary (Summary Source Only)</h2>

    <table class="table table-bordered mt-4 text-center">
      <thead>
        <tr>
          <th>Movie Name</th>
          <th>Tickets Sold</th>
          <th>Total Earnings (Rs.)</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $result = mysqli_query($con, "
          SELECT event AS movie_name, 
                 SUM(quantity) AS total_tickets, 
                 SUM(total) AS total_earnings 
          FROM tickets 
          WHERE source = 'summary'
          GROUP BY event
        ");

        $grand_total_tickets = 0;
        $grand_total_earnings = 0;

        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>
                  <td>{$row['movie_name']}</td>
                  <td>{$row['total_tickets']}</td>
                  <td>Rs. " . number_format($row['total_earnings']) . "</td>
                </tr>";
          $grand_total_tickets += $row['total_tickets'];
          $grand_total_earnings += $row['total_earnings'];
        }
        ?>
      </tbody>
    </table>

    <h4 class="mt-4">🔢 Total Tickets Sold: <?php echo $grand_total_tickets; ?></h4>
    <h4>💰 Total Earnings from All Movies: Rs. <?php echo number_format($grand_total_earnings); ?></h4>
  </div>

</body>
</html>
