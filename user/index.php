<?php
require_once '../includes/auth.php'; 

include('dbconfig.php');
include('header.php');

$loggedIn = isset($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>MyMovie Booking</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="icon" type="image/x-icon" href="image/favicon-logo.ico">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    html, body {
      overflow-x: hidden;
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #000;
      color: #fff;
      line-height: 1.6;
      box-sizing: border-box;
    }

    h2.index-heading {
      text-align: center;
      margin-top: 40px;
      font-size: 40px;
      font-family: 'Bebas Neue', cursive;
      letter-spacing: 1px;
      padding-bottom: 10px;
      position: relative;
    }


    .movie-subheading {
      text-align: center;
      font-size: 16px;
      color: #ddd;
      margin-top: -20px;
    }

    .top-input {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
      gap: 15px;
      margin: 30px 20px;
    }

    .top-input p {
      margin: 0;
      font-size: 16px;
      font-weight: 500;
      white-space: nowrap;
      flex: 1;
      text-align: left;
    }

    .mic-search-container,
    .day-filter-container {
      flex: 0 0 auto;
      max-width: 250px;
      width: 100%;
    }

    .mic-search-container {
      position: relative;
      flex: 1 1 220px;
      max-width: 300px;
    }

    .mic-search-container input {
      width: 100%;
      padding: 12px 40px 12px 15px;
      height: 50px;
      border-radius: 8px;
      border: 1px solid #444;
      background-color: #111;
      color: white;
      font-size: 16px;
    }

    .mic-search-container button {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      font-size: 20px;
      color: white;
      cursor: pointer;
    }

    .day-filter-container {
      flex: 1 1 220px;
      display: flex;
      justify-content: center;
    }

    #daySearch {
      padding: 12px 20px;
      font-size: 16px;
      font-family: 'Poppins', sans-serif;
      color: #fff;
      background: linear-gradient(135deg, #000000ff, #000000ff);
      border: 1px solid #444;
      border-radius: 12px;
      appearance: none;
      background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D%2210%22%20height%3D%227%22%20viewBox%3D%220%200%2010%207%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Cpath%20d%3D%22M1%200l4%204%204-4%22%20stroke%3D%22white%22%20stroke-width%3D%222%22%20fill%3D%22none%22/%3E%3C/svg%3E');
      background-repeat: no-repeat;
      background-position: right 16px center;
      background-size: 12px;
      cursor: pointer;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
      transition: all 0.3s ease;
      min-width: 220px;
    }

    #daySearch option {
      color: red;
      background-color: black;
    }

    #daySearch:hover {
      background: linear-gradient(135deg, #ff0000ff, #ff0000ff);
    }

    #daySearch:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(255, 0, 0, 1);
    }

    .genre-scroll {
      display: flex;
      overflow-x: auto;
      gap: 12px;
      padding: 20px;
      margin: 0 10px;
      scrollbar-width: none;
      -ms-overflow-style: none;
    }

    .genre-scroll::-webkit-scrollbar {
      display: none;
    }

    .genre-box {
      flex: 0 0 auto;
      padding: 10px 20px;
      background-color: #1a1a1a;
      border: 1px solid #333;
      border-radius: 25px;
      font-size: 15px;
      cursor: pointer;
      white-space: nowrap;
      transition: 0.3s;
    }

    .genre-box:hover,
    .genre-box.active {
      background-color: #ff1a1a;
      color: #fff;
    }

   .cards-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 30px;
  padding: 30px 20px;
  max-width: 1200px;
  margin: 0 auto;
  justify-items: center; 
}


    .card {
      background-color: #111;
      border-radius: 15px;
      overflow: hidden;
      transition: transform 0.3s, box-shadow 0.3s;
      display: flex;
      flex-direction: column;
      text-align: center;
    }

    .card:hover {
      transform: scale(1.03);
      box-shadow: 0 0 25px rgba(255, 0, 0, 0.4);
    }

    .card img {
      width: 100%;
      height: 350px;
      object-fit: cover;
    }

    .card-info {
      padding: 15px 12px;
    }

    .card-info h5 {
      font-size: 18px;
      margin-bottom: 6px;
      font-family: 'Bebas Neue', cursive;
      letter-spacing: 1px;
    }

    .card-info p {
      font-size: 14px;
      color: #ccc;
    }

    .card a {
      color: inherit;
      text-decoration: none;
      display: block;
    }

    .card a:hover {
      color: inherit;
    }

    #noResult {
      color: #ff4d4d;
      font-size: 22px;
      text-align: center;
      margin-top: 50px;
    }


    .mic-listening {
      animation: pulse 1s infinite;
      color: red;
    }

    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.2); }
      100% { transform: scale(1); }
    }


    .card::after,
    .card-info::after,
    .card *::after {
      content: none !important;
      background: none !important;
      display: none !important;
    }

  
.top-bar {
  margin-top: 30px;
  text-align: center;
  padding: 0 20px;
}

.top-input {
  display: flex;
  justify-content: flex-end;
  gap: 15px;
  flex-wrap: wrap;
  margin-bottom: 10px;
}

.top-input .mic-search-container,
.top-input .day-filter-container {
  flex: 0 0 auto;
  width: 220px;
}

.index-heading {
  font-size: 40px;
  font-family: 'Bebas Neue', cursive;
  margin: 10px 0 5px;
}

.movie-subheading {
  font-size: 16px;
  color: #ddd;
  margin-top: 0;
}



    @media (max-width: 768px) {
      h2.index-heading {
        font-size: 30px;
        margin-top: 30px;
      }

      .top-input {
        flex-direction: column;
        align-items: stretch;
        justify-content: center;
      }

      .top-input p {
        text-align: center;
        margin-bottom: 10px;
      }

      .mic-search-container,
      .day-filter-container {
        flex: 1 1 100%;
        max-width: 100%;
      }

      #daySearch,
      #liveSearch {
        width: 100%;
      }

      .genre-scroll {
        padding: 10px 15px;
        gap: 10px;
      }

      .genre-box {
        font-size: 13px;
        padding: 6px 14px;
      }

      .cards-container {
        grid-template-columns: 1fr;
        padding: 15px;
        gap: 20px;
        max-width: 100%;
        justify-items: center;
      }

      .card {
        width: 75%;
        max-width: 290px;
        margin: 0 auto;
      }

      .card img {
        height: 370px;
      }
    }

    @media (max-width: 400px) {
      h2.index-heading {
        font-size: 26px;
      }

      .card-info h5 {
        font-size: 16px;
      }

      .card-info p {
        font-size: 13px;
      }
    }
    @media (max-width: 768px) {
  .top-input {
    justify-content: center;
  }

  .top-input .mic-search-container,
  .top-input .day-filter-container {
    width: 100%;
    max-width: 100%;
  }

  .index-heading {
    font-size: 28px;
  }

  .movie-subheading {
    font-size: 14px;
  }
}

  </style>
</head>
<body>
<?php if ($loggedIn && !isset($_SESSION['review_prompt_shown'])): ?>

  <div id="reviewPrompt" style="
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: linear-gradient(145deg, #0d0d0d, #1a1a1a);
      border: 1px solid #ff1a1a;
      padding: 25px 30px;
      border-radius: 16px;
      box-shadow: 0 0 40px rgba(255, 0, 0, 0.4);
      z-index: 9999;
      width: 90%;
      max-width: 400px;
      font-family: 'Poppins', sans-serif;
      color: #fff;
      transition: all 0.3s ease;
      text-align: center;
    ">
    <p style="margin: 0 0 20px; font-size: 16px; line-height: 1.6;">
      🎬 Would you like to rate your experience?
    </p>
    <div style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap;">
      <button onclick="dismissPrompt()" style="
        background: #111;
        color: #fff;
        border: 1px solid #ff1a1a;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        transition: 0.3s ease;
      " onmouseover="this.style.background='#ff1a1a'" onmouseout="this.style.background='#111'">
        Not Now
      </button>

      <a href="review.php" style="
        background: #ff1a1a;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        text-decoration: none;
        font-weight: 500;
        border: 1px solid #ff1a1a;
        transition: 0.3s ease;
      " onmouseover="this.style.background='#111'; this.style.color='white'" onmouseout="this.style.background='#ff1a1a'; this.style.color='white'">
        Rate Now
      </a>
    </div>
  </div>
  <?php endif; ?>

<div class="top-bar">
  <div class="top-input">
    <div class="mic-search-container">
      <input type="text" id="liveSearch" placeholder="Search by movie name...">
    <button id="micBtn" title="Click to speak"><i class="fas fa-microphone"></i></button>

    </div>
    
  </div>

  <h2 class="index-heading">Scheduled Movies</h2>
  <p class="movie-subheading">Book the ticket of your favorite movie</p>
</div>




<div class="cards-container" id="movieList">
<?php
// 1. Apni database connection file ko include karo
include('dbconfig.php'); 

/** @var mysqli $con */
// 2. Aaj ki date nikalne ke liye variable (taaki JavaScript filter kharab na ho)
$day_name = strtolower(date('l')); 

// 3. 'new_store' database se aaj ki 3 movies uthane ki query
// Hamein WHERE show_date = CURDATE() hata dena hai
$sql = "SELECT * FROM scheduled_movies ORDER BY FIELD(show_slot, 'Morning', 'Evening', 'Night') LIMIT 3";
$result = mysqli_query($con, $sql); // Tumhaara '$con' variable yahan use ho gaya

if ($result && mysqli_num_rows($result) > 0) {
    while ($record = mysqli_fetch_assoc($result)) {
        // Database se data fetch karna
        $movie_id = $record['id'];
        $title = htmlspecialchars($record['movie_title']);
        $poster = $record['poster_image']; // Poster ka image path/URL
        $genre = "action"; // Default filter tag
        ?>

       <div class="card" 
             data-name="<?= strtolower($title); ?>" 
             data-day="<?= $day_name; ?>" 
             data-genre="<?= $genre; ?>"
             style="width: 230px; min-height: 350px; margin: 10px; display: inline-block; vertical-align: top;">
            
            <a href="viewmovie.php?id=<?php echo $movie_id; ?>">
                <!-- Image ki size fix kar di taaki broken hone par bhi layout na bigde -->
                <img src="<?= $poster; ?>" alt="<?= $title; ?>" style="width: 100%; height: 300px; object-fit: cover; background-color: #222;">
                
                <div class="card-info" style="text-align: center; padding: 10px 5px;">
                    <h5 style="color: #ffffff; font-size: 15px; font-weight: bold; text-shadow: 1px 1px 3px rgba(0,0,0,0.8); margin: 0;"><?= $title; ?></h5>
                </div>
            </a>
        </div>

        <?php
    }
} else {
    // Agar aaj koi movie scheduled nahi hai toh yeh dikhega
    echo "<div id='noResult' style='color:white; padding:20px;'>Aaj ke liye koi movie scheduled nahi hai. Please database check karein!</div>";
}
?>

 
</div>

<script>

function filterCards() {
  const searchText = $('#liveSearch').val().toLowerCase();
  const selectedDay = $('#daySearch').val();
  const selectedGenre = $('.genre-box.active').data('genre');
  let found = false;

  $('#movieList .card').each(function () {
    const name = $(this).data('name');
    const day = $(this).data('day');
    const genre = $(this).data('genre');

    const matchName = name.includes(searchText);
    const matchDay = !selectedDay || day === selectedDay;
    const matchGenre = !selectedGenre || genre === selectedGenre;

    if (matchName && matchDay && matchGenre) {
      $(this).css('display', 'block'); 
      found = true;
    } else {
      $(this).css('display', 'none'); 
    }
  });

  if (!found) {
    if (!$('#noResult').length) {
      $('#movieList').append('<div id="noResult">No movies found.</div>');
    }
  } else {
    $('#noResult').remove();
  }
}

$('#liveSearch').on('keyup', filterCards);
$('#daySearch').on('change', filterCards);
$('.genre-box').on('click', function () {
  $('.genre-box').removeClass('active');
  $(this).addClass('active');
  filterCards();
});


const micBtn = document.getElementById("micBtn");
const searchInput = document.getElementById("liveSearch");
const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

if (SpeechRecognition) {
  const recognition = new SpeechRecognition();
  recognition.lang = "en-US";
  recognition.interimResults = false;

  micBtn.addEventListener("click", () => {
    recognition.start();
    micBtn.classList.add('mic-listening');
    micBtn.innerHTML = '<i class="fas fa-microphone-lines"></i>';

  });

  recognition.onresult = function (event) {
    let transcript = event.results[0][0].transcript.trim();
    transcript = transcript.replace(/[.,!?]+$/, '');
    searchInput.value = transcript;
    $('#liveSearch').trigger('keyup');
    micBtn.innerHTML = '<i class="fas fa-microphone"></i>';

    micBtn.classList.remove('mic-listening');
  };

  recognition.onerror = recognition.onend = function () {
    micBtn.innerHTML = '<i class="fas fa-microphone"></i>';

    micBtn.classList.remove('mic-listening');
  };
} else {
  micBtn.style.display = "none";
  console.warn("Speech Recognition not supported.");
}
</script>
<script>
    function dismissPrompt() {
      document.getElementById("reviewPrompt").style.display = "none";
      fetch('set_review_prompt_session.php');
    }
  </script>


<?php include('footer.php'); ?>
</body>
</html>
