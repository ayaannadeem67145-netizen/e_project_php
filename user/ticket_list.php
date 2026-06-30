<?php
include('dashheader.php');
include('dbconfig.php');

// --- Pagination Setup ---
$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$total_query = mysqli_query($con, "SELECT COUNT(*) AS total FROM tickets");
$total_row = mysqli_fetch_assoc($total_query);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Paginated Data
$result = mysqli_query($con, "SELECT * FROM tickets ORDER BY id DESC LIMIT $limit OFFSET $offset");
?>

<!DOCTYPE html>
<html>
<head>
  <title>All Tickets</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #000;
      color: #fff;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    h2.index-heading {
      font-size: 32px;
      font-weight: bold;
      color: #e50914;
      margin-bottom: 25px;
      text-align: center;
      position: relative;
      font-family: 'Bebas Neue', cursive;
      letter-spacing: 1px;
      padding-bottom: 10px;
    }

    .index-heading::after {
      content: "";
      width: 80px;
      height: 3px;
      background-color: #e50914;
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
    }

    .table {
      background-color: transparent;
      color: white;
      border-collapse: separate;
      border-spacing: 0;
      box-shadow: 0 0 10px rgba(229, 9, 20, 0.3);
      border-radius: 8px;
      overflow: hidden;
    }

    .table th,
    .table td {
      vertical-align: middle;
      padding: 12px 15px;
      border: none !important;
      text-align: center;
    }

    .table-dark thead th {
      background-color: #1a1a1a;
      color: #ff0000ff;
    }

    .table-dark tbody tr {
      background-color: transparent;
      border-top: 1px solid #222;
    }

    .table-dark tbody tr:hover {
      background-color: #1a1a1a;
    }

    .btn-sm {
      padding: 4px 10px;
      font-size: 14px;
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
      .table th, .table td {
        font-size: 14px;
        padding: 10px;
      }

      h2.index-heading {
        font-size: 24px;
      }
    }

    .cancel-btn {
  display: inline-block;
  padding: 4px 10px;
  font-size: 0.875rem; 
  color: #fff;
  background-color: #ff0019ff; 
  border: none;
  border-radius: 4px;
  text-decoration: none;
  transition: background-color 0.3s ease;
  cursor: pointer;
}

.cancel-btn:hover {
  background-color: #c82333; 
   text-decoration: none;  
  color: #fff;  
}

  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row">
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
      <h2 class="index-heading">All Booked Tickets</h2>

      <div class="table-responsive">
        <table class="table table-dark table-bordered table-hover align-middle">
          <thead>
            <tr>
              <th>ID</th><th>Name</th><th>Email</th><th>Event</th><th>Date</th>
              <th>Time</th><th>Qty</th><th>Total</th><th>Status</th><th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (mysqli_num_rows($result) > 0):
              while($row = mysqli_fetch_assoc($result)) {
            ?>
              <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['event']) ?></td>
                <td><?= htmlspecialchars($row['date']) ?></td>
                <td><?= htmlspecialchars($row['time']) ?></td>
                <td><?= htmlspecialchars($row['quantity']) ?></td>
                <td>Rs. <?= number_format($row['total']) ?></td>
                <td>
                  <?= $row['status'] === 'cancelled'
                      ? "<span class='text-warning'>Cancelled</span>"
                      : "<span class='text-success'>Booked</span>" ?>
                </td>
                <td>
                  <?php if ($row['status'] !== 'cancelled') { ?>
                   <a href="?cancel_id=<?= $row['id'] ?>" class="cancel-btn">Cancel</a>

                  <?php } ?>
                </td>
              </tr>
            <?php
              }
            else:
              echo "<tr><td colspan='10'>No tickets found.</td></tr>";
            endif;
            ?>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
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

    </main>
  </div>
</div>

<?php
// Cancel Ticket Handler
if (isset($_GET['cancel_id'])) {
  $id = $_GET['cancel_id'];
  mysqli_query($con, "UPDATE tickets SET status='cancelled' WHERE id='$id'");

  $ticket = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM tickets WHERE id='$id'"));
  $userEmail = $ticket['email'];
  $userName = $ticket['name'];
  $event = $ticket['event'];
  $date = $ticket['date'];
  $time = $ticket['time'];

  $subject = "Your Ticket Has Been Cancelled";
  $message = "Dear $userName,\n\nYour booking for '$event' on $date at $time has been cancelled by admin.\n\nRegards,\nMyMovie Booking";
  $headers = "From: admin@mymovie.com";

  mail($userEmail, $subject, $message, $headers);

  header("Location: ticket_list.php?page=$page");
  exit();
}
?>
</body>
</html>
