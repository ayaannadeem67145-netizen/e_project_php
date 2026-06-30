<?php
require_once '../includes/auth.php';
require_role([ROLE_ADMIN, ROLE_STAFF]);

include('dashheader.php');
include('dbconfig.php');

if (isset($_POST['btnDel'])) {
    global $con; // Yeh line add ki hai jo $con ko active karegi
    $id = intval($_POST['id']);
    mysqli_query($con, "DELETE FROM movie WHERE id = '$id' ");
    unset($_POST['btnDel']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - Movies List</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #000;
      color: #fff;
    }
    .table th, .table td {
      vertical-align: middle;
    }
    .btn {
      margin-right: 5px;
    }
    img {
      object-fit: cover;
      border-radius: 5px;
    }
    .custom-table-shift {
      margin-left: 25%;
    }  
    .form-control::placeholder {
      color: white;
      opacity: 0.6;
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

    .btn-cart {
      background-color: transparent;
      color: #28a745;
      border: 1px solid #28a745;
    }

    .btn-cart:hover {
      background-color: #28a745;
      color: #fff;
    }

    .pagination-wrapper {
      text-align: center;
      margin-top: 20px;
    }

    .pagination-wrapper button {
      background-color: #222;
      color: white;
      border: 1px solid #444;
      margin: 0 4px;
      padding: 6px 12px;
      border-radius: 4px;
    }

    .pagination-wrapper button.active,
    .pagination-wrapper button:hover {
      background-color: #e50914;
      color: white;
      border-color: #e50914;
    }
    h2 {
      /* font-size: 50px; */
      position: relative;
      text-align: center;
      display: block;
  width: fit-content;
  margin: 0 auto;
    }
  </style>
</head>
<body>

<div class="container-fluid py-4">
  <div class="row">
    <main class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-danger">🎬 Movies List</h2>
      </div>

      <div class="table-responsive custom-table-shift">
        <table class="table table-dark table-bordered table-hover align-middle" id="movieTable">
          <thead>
            <tr class="text-center">
              <th>ID</th>
              <th>Name</th>
              <th>Genre</th>
              <th>Price (Rs)</th>
              <th>Image</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $fetch = mysqli_query($con, "SELECT * FROM movie ORDER BY id DESC");
            while ($record = mysqli_fetch_array($fetch)) {
            ?>
            <tr class="text-center">
              <td><?php echo $record['id']; ?></td>
              <td><?php echo htmlspecialchars($record['name']); ?></td>
              <td><?php echo htmlspecialchars($record['genre']); ?></td>
              <td><?php echo number_format($record['ticket_price']); ?> Rs</td>
              <td>
                <img src="<?php echo htmlspecialchars($record['cover_image']); ?>" width="130" height="110" alt="cover">
              </td>
              <td>
                <form method="POST" style="display: flex; gap: 6px; justify-content: center; flex-wrap: wrap;">
                  <input type="hidden" name="id" value="<?php echo $record['id']; ?>">
                  <a class="btn btn-sm btn-edit" href="update.php?id=<?php echo $record['id']; ?>" title="Edit">
                    <i class="fas fa-pen-to-square"></i>
                  </a>
                  <button class="btn btn-sm btn-delete" name="btnDel" onclick="return confirm('Are you sure you want to delete this movie?');" title="Delete">
                    <i class="fas fa-trash"></i>
                  </button>
                  <a class="btn btn-sm btn-cart" href="booktickets.php?id=<?php echo $record['id']; ?>" title="Book Tickets">
                    <i class="fas fa-cart-shopping"></i>
                  </a>
                </form>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>

      <div class="pagination-wrapper" id="pagination"></div>

    </main>
  </div>
</div>

<script>
  const rowsPerPage = 10;
  const table = document.getElementById('movieTable').getElementsByTagName('tbody')[0];
  const rows = table.getElementsByTagName('tr');
  const totalPages = Math.ceil(rows.length / rowsPerPage);
  const pagination = document.getElementById('pagination');

  function showPage(page) {
    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    for (let i = 0; i < rows.length; i++) {
      rows[i].style.display = (i >= start && i < end) ? '' : 'none';
    }

    const buttons = pagination.getElementsByTagName('button');
    for (let btn of buttons) btn.classList.remove('active');
    if (buttons[page - 1]) buttons[page - 1].classList.add('active');
  }

  function setupPagination() {
    for (let i = 1; i <= totalPages; i++) {
      const btn = document.createElement('button');
      btn.innerText = i;
      btn.addEventListener('click', () => showPage(i));
      pagination.appendChild(btn);
    }
    showPage(1);
  }

  if (rows.length > 0) setupPagination();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
