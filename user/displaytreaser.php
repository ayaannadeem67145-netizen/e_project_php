<?php
include('dashheader.php');
include('dbconfig.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($con, $_POST['movie_title']);
    $description = mysqli_real_escape_string($con, $_POST['movie_description']);
    $video_url = trim($_POST['movie_video_url']);

    preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video_url, $matches);
    $video_id = $matches[1] ?? '';

    if ($video_id !== '') {
        $embed_url = "https://www.youtube.com/embed/" . $video_id;

        $query = "INSERT INTO movie_teasers (title, description, video_url) VALUES (?, ?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param("sss", $title, $description, $embed_url);

        if ($stmt->execute()) {
            echo "<script>alert('Trailer uploaded successfully!'); window.location.href='displaytreaser.php';</script>";
        } else {
            echo "Database error: " . $stmt->error;
        }
    } else {
        echo "<script>alert('Invalid YouTube URL'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload Movie Teaser</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      background-color: #000;
      color: #fff;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container {
      max-width: 700px;
      margin: 40px auto;
      padding: 15px;
    }

    .card {
      background-color: #111;
      border: 1px solid #e50914;
      box-shadow: 0 0 12px rgba(229, 9, 20, 0.3);
    }

    .card h2 {
      color: #e50914;
      font-size: 26px;
      margin-bottom: 20px;
      border-bottom: 2px solid #e50914;
      padding-bottom: 10px;
    }

    .form-label {
      font-weight: 500;
      color: #fff;
    }

    .form-control {
      background-color: #222;
      border: 1px solid #333;
      color: white;
    }

    .form-control::placeholder,
    textarea::placeholder {
      color: white;
      opacity: 0.6;
    }

    .form-control:focus {
      border-color: #e50914;
      box-shadow: 0 0 6px #e50914;
    }

    .btn-dark {
      background-color: #e50914;
      border: none;
      padding: 10px 20px;
      font-weight: bold;
      font-size: 16px;
    }

    .btn-dark:hover {
      background-color: #ff0a16;
    }

    @media screen and (max-width: 576px) {
      .card h2 {
        font-size: 22px;
      }

      .btn-dark {
        font-size: 14px;
        padding: 10px;
      }

      .form-control {
        font-size: 14px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <div class="card p-4 rounded">
    <h2 class="text-center"><i class="fas fa-video"></i> Upload Movie Teaser</h2>

    <form action="displaytreaser.php" method="POST">

      <div class="mb-3">
        <label for="movieTitle" class="form-label">Movie Title</label>
        <input type="text" class="form-control" id="movieTitle" name="movie_title" placeholder="Enter movie title" required>
      </div>

      <div class="mb-3">
        <label for="movieDescription" class="form-label">Movie Description</label>
        <textarea class="form-control" id="movieDescription" name="movie_description" rows="4" placeholder="Enter movie description" required></textarea>
      </div>

     <div class="mb-3">
  <label for="movieVideoURL" class="form-label">YouTube Trailer URL</label>
  <input type="url" class="form-control" id="movieVideoURL" name="movie_video_url" placeholder="https://www.youtube.com/watch?v=..." required>
</div>


      <div class="text-center">
        <button type="submit" class="btn btn-dark w-100">Upload Teaser</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
