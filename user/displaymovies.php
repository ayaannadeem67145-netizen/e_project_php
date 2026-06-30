<?php
include('dashheader.php');
include('dbconfig.php');

if (isset($_POST['btnUpload'])) {

  $name = $_POST['name'];
    $genre = $_POST['genre'];
    $show_date = $_POST['show_date'];
    $show_time = $_POST['show_time'];
    $ticket_price = $_POST['ticket_price'];


    $filename = $_FILES['cover_image']['name'];
    $Tmpname = $_FILES['cover_image']['tmp_name'];
    $filepath = "./uploads/" . $filename;
    move_uploaded_file($Tmpname, $filepath);


mysqli_query($con, "INSERT INTO movie(name, genre, cover_image, show_date, show_time, ticket_price) 
                        VALUES ('$name', '$genre', '$filepath', '$show_date', '$show_time', '$ticket_price')");
    $movie_id = mysqli_insert_id($con);


    $duration_hours = $_POST['duration_hours'];
    $duration_minutes = $_POST['duration_minutes'];
    $description = mysqli_real_escape_string($con, $_POST['description']);


mysqli_query($con, "INSERT INTO movie_details (movie_id, duration_hours, duration_minutes, description) 
                        VALUES ('$movie_id', '$duration_hours', '$duration_minutes', '$description')");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload Movie</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
  body { background-color: #000; color: #fff; font-family: 'Segoe UI'; }
  .container { max-width: 700px; margin: 40px auto; padding: 15px; }
  .card { background-color: #111; border: 1px solid #e50914; box-shadow: 0 0 10px rgba(229, 9, 20, 0.3); }
  .card h1 { color: #e50914; font-size: 28px; margin-bottom: 20px; border-bottom: 2px solid #e50914; padding-bottom: 10px; }
  .form-control { background-color: #222; border: 1px solid #333; color: white; }
  .form-control::placeholder { color: white; opacity: 0.6; }
  .form-control:focus { border-color: #e50914; box-shadow: 0 0 5px #e50914; }
  .btn-dark { background-color: #e50914; border: none; padding: 10px 20px; font-weight: bold; font-size: 16px; }
  .btn-dark:hover { background-color: #ff0a16; }
  .form-label { color: white !important; }
  .section-title { color: white; text-align: center; margin-bottom: 1rem; }
</style>
</head>
<body>

<div class="container">
  <div class="card p-4 rounded">
    <h1 class="text-center"><i class="fas fa-upload"></i> Upload Movie & Details</h1>
    <form method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label">Movie Name</label>
        <input type="text" class="form-control" name="name" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Movie Genre</label>
        <input type="text" class="form-control" name="genre" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Show Date</label>
        <input type="date" class="form-control" name="show_date" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Show Time</label>
        <input type="time" class="form-control" name="show_time" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Ticket Price</label>
        <input type="number" class="form-control" name="ticket_price" required>
      </div>
     
      <div class="mb-3">
        <label class="form-label">Movie Image</label>
        <input type="file" class="form-control" name="cover_image" required>
      </div>

      <hr class="my-4">
      <h5 class="text-center mb-3 text-white">Movie Details</h5>

      <div class="mb-3">
        <label class="form-label">Duration (Hours)</label>
        <input type="number" class="form-control" name="duration_hours" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Duration (Minutes)</label>
        <input type="number" class="form-control" name="duration_minutes" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Movie Description</label>
        <textarea class="form-control" name="description" required></textarea>
      </div>

      <div class="text-center">
        <button type="submit" name="btnUpload" class="btn btn-dark w-100">Upload Movie</button>
      </div>
    </form>
  </div>
</div>

</body>
</html>
