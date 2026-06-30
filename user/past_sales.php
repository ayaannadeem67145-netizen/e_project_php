<?php
include('dashheader.php');
include('dbconfig.php');

$limit = 10; // Records per page
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Get total number of rows
$total_result = mysqli_query($con, "SELECT COUNT(*) as total FROM ticket_archive");
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Paginated data
$archived_result = mysqli_query($con, "SELECT * FROM ticket_archive ORDER BY date DESC LIMIT $limit OFFSET $offset");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Past Ticket Sales</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    body {
      background-color: #000;
      color: white;
      font-family: Arial, sans-serif;
    }

    h2 {
      color: #e50914;
      border-bottom: 2px solid #ff010eff;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }

    .form-control::placeholder {
      color: white;
      opacity: 0.6;
    }

    .search-bar {
      text-align: center;
      margin-bottom: 20px;
    }

    .search-bar input {
      width: 50%;
      padding: 10px;
      border-radius: 10px;
      border: none;
      background-color: #222;
      color: white;
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

    .table thead th {
      background-color: #1a1a1a;
      color: #ff0000ff;
      border: none;
      padding: 12px 15px;
    }

    .table th,
    .table td {
      background-color: #000;
      color: white;
      text-align: center;
      border: none;
      padding: 12px 15px;
      vertical-align: middle;
    }

    .table tbody tr:nth-child(even) {
      background-color: #111;
    }

    .table tbody tr:hover {
      background-color: #1a1a1a;
    }

    /* Pagination styling */
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
      .search-bar input {
        width: 90%;
      }
    }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row">
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-5">

      <div class="search-bar">
        <input type="text" id="searchMovie" placeholder="🔍 Search by Movie Name..." class="form-control">
      </div>

      <h2>📦 Archived Ticket Sales History</h2>

      <div class="table-responsive">
        <table class="table table-bordered text-center" id="ticketTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Movie</th>
              <th>Date</th>
              <th>Time</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($archived_result)) { ?>
              <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td class="movie-name"><?php echo htmlspecialchars($row['event']); ?></td>
                <td><?php echo htmlspecialchars($row['date']); ?></td>
                <td><?php echo htmlspecialchars($row['time']); ?></td>
                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                <td>Rs. <?php echo number_format($row['price']); ?></td>
                <td>Rs. <?php echo number_format($row['total']); ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>

      <!-- PAGINATION -->
      <?php if ($total_pages > 1): ?>
        <nav aria-label="Page navigation">
          <ul class="pagination justify-content-center mt-4">
            <?php if ($page > 1): ?>
              <li class="page-item">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>">&laquo; Prev</a>
              </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
              <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
              </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
              <li class="page-item">
                <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next &raquo;</a>
              </li>
            <?php endif; ?>
          </ul>
        </nav>
      <?php endif; ?>

    </main>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#searchMovie').on('keyup', function() {
      var value = $(this).val().toLowerCase();
      $('#ticketTable tbody tr').filter(function() {
        $(this).toggle($(this).find('.movie-name').text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
</script>

</body>
</html>
