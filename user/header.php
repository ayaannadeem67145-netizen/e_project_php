<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-ZWPPkLtxyOYkQHyPqLq+a8+gZc0X8MdDYAjfQO2RaKXq9Xw2qKDzL9mTJah+nBDRZKqFqx4HyYIpNB4T0YN0vQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&family=Montserrat:wght@500&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="icon" type="image/x-icon" href="image/favicon-logo.ico">

<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }



  .navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 9999;

    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #111;
    padding: 15px 25px;
    box-shadow: 0 2px 6px rgba(255, 0, 0, 0.1);
    flex-wrap: wrap;
  }

  .navbar-logo {
    font-family: 'Montserrat', sans-serif;
    font-size: 26px;
    font-weight: 700;
    background: linear-gradient(45deg, #ff3c3c, #fff);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
    text-transform: uppercase;
    letter-spacing: 1px;
  }

  .nav-logo {
    text-decoration: none;
  }

  .navbar-links {
    margin-top: 10px;
    list-style: none;
    display: flex;
    gap: 25px;
  }

  .navbar-links li a {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    text-decoration: none;
    color: white;
    font-weight: 500;
    padding: 5px 10px;
    transition: 0.3s ease;
    border-radius: 4px;
  }

  .navbar-links li a:hover {
    background-color: #e50914;
    color: #fff;
  }

  .navbar-links li a.active {
    background-color: #e50914;
    color: #fff;
    font-weight: bold;
  }

  .navbar-toggle {
    display: none;
    flex-direction: column;
    cursor: pointer;
  }

  .navbar-toggle span {
    height: 3px;
    width: 25px;
    background-color: #e50914;
    margin: 4px 0;
    transition: 0.4s;
  }

  @media screen and (max-width: 768px) {
    .navbar-links {
      flex-direction: column;
      width: 100%;
      display: none;
      background-color: #111;
      margin-top: 15px;
      border-top: 1px solid #333;
    }

    .navbar-links.show {
      display: flex;
    }

    .navbar-links li {
      text-align: center;
      padding: 10px 0;
    }

    .navbar-toggle {
      display: flex;
    }
  }
</style>

<!-- NAVBAR -->
<nav class="navbar">
  <!-- Purane waale ko hata kar yeh likhein -->
<a class="nav-logo" href="../user/index.php">
    <div class="navbar-logo">MyMovie</div>
  </a>

  <div class="navbar-toggle" id="navbar-toggle">
    <span></span>
    <span></span>
    <span></span>
  </div>

  <ul class="navbar-links" id="navbar-links">
    <!-- Purane waale ko hata kar yeh likhein -->
    <li><a href="../user/index.php" class="<?php echo $currentPage === 'index.php' ? 'active' : ''; ?>">Home</a></li>
    <li><a href="movies.php" class="<?= $currentPage === 'movies.php' ? 'active' : '' ?>">Trailers</a></li>
    <li><a href="aboutus.php" class="<?= $currentPage === 'aboutus.php' ? 'active' : '' ?>">About us</a></li>
    <li><a href="help.php" class="<?= $currentPage === 'help.php' ? 'active' : '' ?>">Help</a></li>

    <?php if (isset($_SESSION['user'])): ?>
      <li><a href="review.php" class="<?= $currentPage === 'review.php' ? 'active' : '' ?>">Review us</a></li>
      <!-- My Bookings ko pehle kar diya -->
      <li><a href="my_bookings.php" class="<?= $currentPage === 'my_bookings.php' ? 'active' : '' ?>">My Bookings</a></li>
      <!-- Logout ko aakhir (right) mein kar diya -->
      <li><a href="logout.php" class="<?= $currentPage === 'logout.php' ? 'active' : '' ?>">Logout</a></li>
    <?php else: ?>
      <li><a href="login.php" class="<?= $currentPage === 'login.php' ? 'active' : '' ?>">Login</a></li>
    <?php endif; ?>

  </ul>
</nav>
</nav>

<!-- JS: Toggle menu for mobile -->
<script>
  const toggle = document.getElementById('navbar-toggle');
  const links = document.getElementById('navbar-links');

  toggle.addEventListener('click', () => {
    links.classList.toggle('show');
  });
</script>

<!-- JS Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
