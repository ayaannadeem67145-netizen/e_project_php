<?php
require_once '../includes/auth.php';
require_role(ROLE_USER);
include('dbconfig.php'); // Yeh upar le aaye
include('dashheader.php'); // Yeh bhi upar le aaye

// Handle delete
if (isset($_POST['btnDel'])) {
    global $con; // Yeh line add ki
    $id = intval($_POST['id']);
    mysqli_query($con, "DELETE FROM tickets WHERE id = '$id' ");
    unset($_POST['btnDel']);
}

// --- Pagination Setup ---
$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$total_query = mysqli_query($con, "SELECT COUNT(*) AS total FROM `tickets`");
$total_row = mysqli_fetch_assoc($total_query);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Paginated Data
$fetch = mysqli_query($con, "SELECT * FROM `tickets` ORDER BY id DESC LIMIT $limit OFFSET $offset");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tickets Table</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      background-color: #000;
      color: #fff;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    h2 {
      color: #e50914;
      border-bottom: 2px solid #e50914;
      padding-bottom: 10px;
    }

    .table {
      background-color: transparent;
      color: white;
      border-collapse: separate;
      border-spacing: 0;
      box-shadow: 0 0 10px rgba(229, 9, 20, 0.3);
    }

    .table thead th {
      background-color: #1a1a1a;
      color: #ff0000ff;
      border: 1px solid #2c2c2c;
      padding: 12px 15px;
    }

    .table th, .table td {
      vertical-align: middle;
      background-color: #111;
      color: white;
      text-align: center;
      padding: 12px 15px;
      border: 1px solid #2c2c2c;
    }

    .table tbody tr:hover {
      background-color: #1a1a1a;
    }

    .btn-sm {
      padding: 6px 10px;
      font-size: 14px;
      border-radius: 4px;
    }

    .btn-edit {
      background-color: transparent;
      color: #0d6efd;
      border: 1px solid #0d6efd;
    }

    .btn-edit:hover {
      background-color: #0d6efd;
      color: #fff;
    }

    .btn-delete {
      background-color: transparent;
      color: #e50914;
      border: 1px solid #e50914;
    }

    .btn-delete:hover {
      background-color: #e50914;
      color: #fff;
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

    @media screen and (max-width: 768px) {
      .btn-sm {
        margin: 3px 0;
        display: block;
        width: 100%;
      }
    }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row">
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <h2 class="mt-4 mb-3">🎟️ Tickets Table</h2>

      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
          <thead>
            <tr>
              <th>ID</th><th>Name</th><th>Email</th><th>Event</th><th>Date</th>
              <th>Time</th><th>Quantity</th><th>Price</th><th>Total</th><th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (mysqli_num_rows($fetch) > 0):
              while ($record = mysqli_fetch_array($fetch)) {
            ?>
              <tr>
                <td><?= $record['id']; ?></td>
                <td><?= htmlspecialchars($record['name']); ?></td>
                <td><?= htmlspecialchars($record['email']); ?></td>
                <td><?= htmlspecialchars($record['event']); ?></td>
                <td><?= htmlspecialchars($record['date']); ?></td>
                <td><?= htmlspecialchars($record['time']); ?></td>
                <td><?= htmlspecialchars($record['quantity']); ?></td>
                <td>Rs. <?= number_format($record['price']); ?></td>
                <td>Rs. <?= number_format($record['total']); ?></td>
                <td>
                  <form method="POST" style="display: flex; gap: 6px; justify-content: center; flex-wrap: wrap;">
                    <input type="hidden" name="id" value="<?= $record['id']; ?>">
                    <a class="btn btn-sm btn-edit" href="update.php?id=<?= $record['id']; ?>" title="Edit">
                      <i class="fas fa-pen-to-square"></i>
                    </a>
                    <button class="btn btn-sm btn-delete" name="btnDel" onclick="return confirm('Are you sure?');" title="Delete">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
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

</body>
</html>
