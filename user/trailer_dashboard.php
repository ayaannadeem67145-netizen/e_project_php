<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

include('dashheader.php');
include('dbconfig.php');

if (isset($_POST['btnDel'])) {
    $id = intval($_POST['id']);
    mysqli_query($con, "DELETE FROM movie_teasers WHERE id = '$id' ");
    echo "<script>alert('Teaser deleted successfully.');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - Movie Teasers</title>
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
    iframe {
      border-radius: 5px;
    }
    .custom-table-shift {
      margin-left: 25%;
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
  </style>
</head>
<body>

<div class="container-fluid py-4">
  <div class="row">
    <main class="col-12">
      <div class="text-center mb-4">
        <h2 class="text-danger">📺 Movie Teasers</h2>
      </div>

      <div class="table-responsive custom-table-shift">
        <table class="table table-dark table-bordered table-hover align-middle" id="teaserTable">
          <thead>
            <tr class="text-center">
              <th>ID</th>
              <th>Title</th>
              <th>Description</th>
              <th>Trailer</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $fetch = mysqli_query($con, "SELECT * FROM movie_teasers ORDER BY id DESC");
            while ($row = mysqli_fetch_array($fetch)) {
            ?>
            <tr class="text-center">
              <td><?php echo $row['id']; ?></td>
              <td><?php echo htmlspecialchars($row['title']); ?></td>
              <td style="max-width: 250px;"><?php echo htmlspecialchars($row['description']); ?></td>
              <td>
                <iframe width="200" height="110" src="<?php echo htmlspecialchars($row['video_url']); ?>" frameborder="0" allowfullscreen></iframe>
              </td>
              <td>
                <form method="POST" style="display: flex; gap: 6px; justify-content: center; flex-wrap: wrap;">
                  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                  <a class="btn btn-sm btn-edit" href="edit_trailer.php?id=<?php echo $row['id']; ?>" title="Edit">
                    <i class="fas fa-pen-to-square"></i>
                  </a>
                  <button class="btn btn-sm btn-delete" name="btnDel" onclick="return confirm('Are you sure you want to delete this teaser?');" title="Delete">
                    <i class="fas fa-trash"></i>
                  </button>
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
  const table = document.getElementById('teaserTable').getElementsByTagName('tbody')[0];
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
