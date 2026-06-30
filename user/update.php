<?php
include('dbconfig.php');

$id = isset($_GET['id']) ? $_GET['id'] : 0;

// Fetch movie and details
$fetch = mysqli_query($con, "SELECT * FROM `movie` WHERE id = '$id'");
$rec = mysqli_fetch_array($fetch);

$detailFetch = mysqli_query($con, "SELECT * FROM `movie_details` WHERE movie_id = '$id'");
$detail = mysqli_fetch_array($detailFetch);

if (isset($_POST['btnUpdate'])) {
    $uid = $_POST['id'];
    $name = $_POST['name'];
    $genre = $_POST['genre'];
    $show_date = $_POST['show_date'];
    $show_time = $_POST['show_time'];
    $duration_hours = $_POST['duration_hours'];
    $duration_minutes = $_POST['duration_minutes'];
    $description = mysqli_real_escape_string($con, $_POST['description']);

    // Image upload
    $newImage = $_FILES['cover_image']['name'];
    if ($newImage != '') {
        $uploadPath = 'uploads/' . basename($newImage);
        move_uploaded_file($_FILES['cover_image']['tmp_name'], $uploadPath);
    } else {
        $uploadPath = $rec['cover_image'];
    }

    // Update movie table
    $updateMovie = mysqli_query($con, "UPDATE `movie` SET 
        `name` = '$name', 
        `genre` = '$genre', 
        `cover_image` = '$uploadPath', 
        `show_date` = '$show_date', 
        `show_time` = '$show_time' 
        WHERE id = '$uid'");

    // Update movie_details table
    $updateDetails = mysqli_query($con, "UPDATE `movie_details` SET 
        `duration_hours` = '$duration_hours', 
        `duration_minutes` = '$duration_minutes', 
        `description` = '$description' 
        WHERE movie_id = '$uid'");

    if ($updateMovie && $updateDetails) {
        echo "<script>alert('Movie updated successfully.'); window.location.href='dashboard.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to update.');</script>";
    }
}
?>

<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Update Movie</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #000;
      color: #fff;
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      background-color: #111;
      color: #fff;
      border: 1px solid #dc3545;
    }
    .form-control {
      background-color: #222;
      color: #fff;
      border: 1px solid #dc3545;
    }
    .form-control:focus {
      background-color: #111;
      color: #fff; 
      border-color: #dc3545;
      box-shadow: none;
    }
    .form-control::placeholder {
      color: white;
      opacity: 0.6;
    }
    .btn-dark {
      background-color: #dc3545;
      border: none;
    }
    .btn-dark:hover {
      background-color: #c82333;
    }
    label {
      font-weight: 600;
    }
  </style>
</head>
<body>

<main class="container py-5">
  <h2 class="text-center mb-4 text-danger">Update Movie Record</h2>

  <div class="card shadow p-4 mx-auto" style="max-width: 600px;">
    <form method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $rec['id']; ?>">

      <div class="mb-3">
        <label class="form-label">Movie Name</label>
        <input type="text" class="form-control" name="name" value="<?php echo $rec['name']; ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Genre</label>
        <input type="text" class="form-control" name="genre" value="<?php echo $rec['genre']; ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Show Date</label>
        <input type="date" class="form-control" name="show_date" value="<?php echo $rec['show_date']; ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Show Time</label>
        <input type="time" class="form-control" name="show_time" value="<?php echo $rec['show_time']; ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Current Image</label><br>
        <img src="<?php echo $rec['cover_image']; ?>" height="100" class="mb-2 border rounded">
        <input type="file" name="cover_image" class="form-control mt-2">
        <small class="text-white">Leave empty to keep existing image.</small>
      </div>

      <hr class="my-4 text-danger">
      <h5 class="text-center text-white">Movie Details</h5>

      <div class="mb-3">
        <label class="form-label">Duration (Hours)</label>
        <input type="number" class="form-control" name="duration_hours" value="<?php echo $detail['duration_hours']; ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Duration (Minutes)</label>
        <input type="number" class="form-control" name="duration_minutes" value="<?php echo $detail['duration_minutes']; ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Movie Description</label>
        <textarea class="form-control" name="description" required><?php echo htmlspecialchars($detail['description']); ?></textarea>
      </div>

      <button type="submit" name="btnUpdate" class="btn btn-dark w-100">Update Movie</button>
    </form>
  </div>
</main>

</body>
</html>
