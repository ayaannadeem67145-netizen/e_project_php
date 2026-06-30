<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

include('dashheader.php');
include('dbconfig.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch existing teaser data
$result = mysqli_query($con, "SELECT * FROM movie_teasers WHERE id = '$id'");
if (mysqli_num_rows($result) == 0) {
    echo "<script>alert('Teaser not found.'); window.location.href='trailer_dashboard.php';</script>";
    exit();
}
$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($con, $_POST['movie_title']);
    $description = mysqli_real_escape_string($con, $_POST['movie_description']);
    $video_url = trim($_POST['movie_video_url']);

    // Extract video ID
    preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video_url, $matches);
    $video_id = $matches[1] ?? '';

    if ($video_id !== '') {
        $embed_url = "https://www.youtube.com/embed/" . $video_id;

        $stmt = $con->prepare("UPDATE movie_teasers SET title=?, description=?, video_url=? WHERE id=?");
        $stmt->bind_param("sssi", $title, $description, $embed_url, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Teaser updated successfully!'); window.location.href='trailer_dashboard.php';</script>";
            exit();
        } else {
            echo "<script>alert('Update failed: " . $stmt->error . "');</script>";
        }
    } else {
        echo "<script>alert('Invalid YouTube URL');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Movie Teaser</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

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

    .form-control::placeholder {
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

    iframe {
      border-radius: 5px;
      margin-top: 15px;
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
    <h2 class="text-center"><i class="fas fa-edit"></i> Edit Movie Teaser</h2>

    <form method="POST">
      <div class="mb-3">
        <label for="movieTitle" class="form-label">Movie Title</label>
        <input type="text" class="form-control" id="movieTitle" name="movie_title" value="<?php echo htmlspecialchars($row['title']); ?>" required>
      </div>

      <div class="mb-3">
        <label for="movieDescription" class="form-label">Movie Description</label>
        <textarea class="form-control" id="movieDescription" name="movie_description" rows="4" required><?php echo htmlspecialchars($row['description']); ?></textarea>
      </div>

      <div class="mb-3">
        <label for="movieVideoURL" class="form-label">YouTube Trailer URL</label>
        <input type="url" class="form-control" id="movieVideoURL" name="movie_video_url"
               value="https://www.youtube.com/watch?v=<?php echo substr($row['video_url'], -11); ?>"
               required>
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-dark w-100">Update Teaser</button>
      </div>

      <div class="mt-4 text-center">
        <p class="text-white">Preview:</p>
        <iframe width="100%" height="300" src="<?php echo $row['video_url']; ?>" allowfullscreen></iframe>
      </div>
    </form>
  </div>
</div>

</body>
</html>
