<?php
session_start();
include('header.php');
include('dbconfig.php');

if (!isset($_SESSION['user']) && isset($_COOKIE['user'])) {
    $_SESSION['user'] = $_COOKIE['user'];
}

if (isset($_POST['submitReview'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $rating = intval($_POST['rating']);

    if (!empty($name) && !empty($description) && $rating > 0) {
        $insert = "INSERT INTO reviews (name, description, rating) VALUES ('$name', '$description', '$rating')";
        mysqli_query($con, $insert);
    }
}

$result = mysqli_query($con, "SELECT * FROM reviews ORDER BY rating DESC, id DESC");

$reviews = [];
$totalRating = 0;
$count = mysqli_num_rows($result);

if ($count > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $reviews[] = $row;
        $totalRating += $row['rating'];
    }
    $averageRating = round($totalRating / $count, 1);
} else {
    $averageRating = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Review & Feedback</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
<style>
  body {
    font-family: 'Inter', sans-serif;
    background-color: #0d0d0d;
    color: #f2f2f2;
    margin: 0;
    padding: 0;
    line-height: 1.6;
  }

  h1 {
    font-family: 'Playfair Display', serif;
    text-align: center;
    color: #ff1a1a;
    font-size: 36px;
    margin-bottom: 25px;
  }

  .container {
    max-width: 1100px;
    margin: 60px auto;
    padding: 30px 20px;
  }

  .average-rating {
    text-align: center;
    margin: 30px 0 40px;
    font-size: 22px;
  }

  .stars {
    display: inline-flex;
    color: gold;
    font-size: 26px;
    margin-top: 8px;
  }

  .form-wrapper {
    display: flex;
    justify-content: center;
    margin-bottom: 60px;
  }

  form {
    background-color: #1a1a1a;
    padding: 30px 25px;
    border-radius: 14px;
    width: 100%;
    max-width: 600px;
    box-shadow: 0 0 15px rgba(255, 0, 0, 0.1);
  }

  form input,
  form textarea,
  form button {
    width: 100%;
    margin-bottom: 20px;
    padding: 14px 12px;
    border-radius: 6px;
    border: none;
    font-size: 16px;
    background-color: #262626;
    color: #fff;
  }

  form input::placeholder,
  form textarea::placeholder {
    color: #aaa;
  }

  form button {
    background-color: #ff1a1a;
    color: white;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: background 0.3s ease;
  }

  form button:hover {
    background-color: #cc0000;
  }

  .rating-stars {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin: 16px 0;
  }

  .rating-stars span {
    font-size: 30px;
    color: #666;
    cursor: pointer;
    transition: color 0.2s ease;
  }

  .rating-stars span.selected {
    color: gold;
  }

  .review-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 24px;
    justify-content: center;
  }

  .review-card {
    flex: 0 0 30%;
    background-color: #1a1a1a;
    padding: 20px 18px;
    border-radius: 12px;
    border: 1px solid #333;
    box-shadow: 0 0 12px rgba(255, 0, 0, 0.15);
    min-width: 280px;
    max-width: 100%;
  }

  .review-card h4 {
    margin-top: 0;
    margin-bottom: 10px;
    font-size: 20px;
    font-family: 'Playfair Display', serif;
    color: #ff4d4d;
  }

  .review-card .stars {
    font-size: 18px;
    margin-bottom: 8px;
  }

  .review-card p {
    margin: 0;
    white-space: pre-wrap;
    color: #ddd;
  }

  @media (max-width: 992px) {
    .review-card {
      flex: 0 0 45%;
    }
  }

  @media (max-width: 600px) {
    .review-card {
      flex: 0 0 100%;
    }

    h1 {
      font-size: 28px;
    }

    .average-rating {
      font-size: 18px;
    }

    .rating-stars span {
      font-size: 26px;
    }
  }
</style>

</head>
<body>

<div class="container">
  <h1>WEBSITE FEEDBACK</h1>

  <div class="average-rating">
    Average Rating: <?php echo $averageRating; ?> / 5
    <div class="stars">
      <?php
        for ($i = 1; $i <= 5; $i++) {
          echo $i <= round($averageRating) ? '★' : '☆';
        }
      ?>
    </div>
    <p><?php echo $count; ?> users rated this website</p>
  </div>

  <div class="form-wrapper">
    <form method="POST">
      <input type="text" name="name" placeholder="Your Name" required>
      <textarea name="description" rows="3" placeholder="Write your review..." required></textarea>

      <div class="rating-stars" id="starRating">
        <?php for ($i = 1; $i <= 5; $i++) : ?>
          <span data-star="<?php echo $i; ?>">★</span>
        <?php endfor; ?>
      </div>

      <input type="hidden" name="rating" id="ratingInput" value="0">
      <button type="submit" name="submitReview">Submit Review</button>
    </form>
  </div>

  <div class="review-grid">
    <?php foreach ($reviews as $rev): ?>
      <div class="review-card">
        <h4><?php echo htmlspecialchars($rev['name']); ?></h4>
        <div class="stars">
          <?php for ($i = 1; $i <= 5; $i++): ?>
            <?php echo $i <= $rev['rating'] ? '★' : '☆'; ?>
          <?php endfor; ?>
        </div>
        <p><?php echo nl2br(htmlspecialchars($rev['description'])); ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<script>
  const stars = document.querySelectorAll('#starRating span');
  const ratingInput = document.getElementById('ratingInput');

  stars.forEach((star, index) => {
    star.addEventListener('click', () => {
      ratingInput.value = index + 1;
      stars.forEach((s, i) => {
        s.classList.toggle('selected', i <= index);
      });
    });
  });
</script>
<script>
  const stars = document.querySelectorAll('#starRating span');
  const ratingInput = document.getElementById('ratingInput');

  stars.forEach((star, index) => {
    star.addEventListener('click', () => {
      ratingInput.value = index + 1;
      stars.forEach((s, i) => {
        s.classList.toggle('selected', i <= index);
      });
    });
  });

  const saved = parseInt(ratingInput.value);
  if (saved > 0) {
    stars.forEach((s, i) => {
      s.classList.toggle('selected', i < saved);
    });
  }
</script>


<?php include('footer.php'); ?>
</body>
</html>
