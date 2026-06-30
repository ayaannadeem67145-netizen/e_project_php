<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



$currentPage = basename($_SERVER['PHP_SELF']);
$isDashboardChild = in_array($currentPage, [
  'admin_dashboard_summary.php',
  'dashboard_analytics.php',
  'ticket_list.php',
  'dashboard.php',
  'trailer_dashboard.php'
]);
?>

 <title>Admin Dashboard</title>
 <link rel="icon" type="image/x-icon" href="image/favicon-logo.ico">
<link href="dashboardassets/dashboard.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&display=swap" rel="stylesheet">

<style>
  body {
    background-color: #000;
    color: #fff;
  }

  .navbar-custom {
    background-color: #111 !important;
    border-bottom: 2px solid #e50914;
    padding: 8px 16px !important;
  }

  .navbar-brand {
    color: #e50914 !important;
    font-weight: 600;
    font-size: 1.3rem;
    padding: 0;
    margin-right: 20px;
  }

  .btn-logout {
    background-color: transparent;
    border: 1.5px solid #e50914;
    color: #e50914;
    padding: 5px 12px;
    font-size: 14px;
    border-radius: 4px;
  }

  .btn-logout:hover {
    background-color: #e50914;
    color: #fff;
  }

  .sidebar {
    background-color: #111;
    border-right: 2px solid #e50914;
    height: 100vh;
  }

  .sidebar .nav-link {
    color: #fff;
    font-weight: 500;
    padding: 10px 20px;
    background-color: transparent !important;
  }

  .sidebar .nav-link:hover,
  .sidebar .nav-link.active {
    background-color: #e50914 !important;
    color: #fff !important;
    border-radius: 6px;
  }

  .sidebar h4 {
    color: #e50914;
    font-size: 1.2rem;
    margin-left: 20px;
    margin-top: 30px;
  }

  .sidebar .btn-logout {
    display: inline-block;
    background-color: transparent;
    border: 1.5px solid #e50914;
    color: #e50914;
    padding: 5px 12px;
    font-size: 14px;
    border-radius: 4px;
    transition: all 0.3s ease;
  }

  .sidebar .btn-logout:hover {
    background-color: #e50914;
    color: #fff;
  }

  .logo-text {
    font-family: 'Orbitron', sans-serif;
    font-size: 26px;
    font-weight: 700;
    background: linear-gradient(90deg, #ff3c3c, #ffffff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.6);
    letter-spacing: 1px;
    text-transform: uppercase;
  }

  .nav-link:focus,
  .nav-link:active,
  .nav-link.show,
  .nav-link:focus-visible {
    outline: none !important;
    box-shadow: none !important;
    background-color: transparent !important;
  }

  .dropdown-arrow {
    transition: transform 0.25s ease-in-out;
  }

 .admin-profile {
  color: white !important;
  padding: 6px 10px;
}

.admin-img-container {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  overflow: hidden;
  border: 2px solid #e50914;
  flex-shrink: 0;
}

.admin-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 50%;
  image-rendering: auto;
}

.admin-name {
  color: white !important;
  font-weight: 600;
  font-size: 16px;
}


.admin-profile:hover {
  text-decoration: none;
  opacity: 0.85;
}

</style>

<header class="navbar navbar-dark navbar-custom sticky-top flex-md-nowrap shadow justify-content-between align-items-center">
  <div class="d-flex align-items-center">
    <a class="navbar-brand logo-text" href="admin_dashboard_summary.php">MyMovies Admin</a>
  </div>
</header>

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
  <div class="position-sticky pt-3">
    <ul class="nav flex-column">

      <li class="nav-item">
        <a class="nav-link d-flex justify-content-between align-items-center"
           data-bs-toggle="collapse"
           href="#dashboardDropdown"
           role="button"
           aria-expanded="<?= $isDashboardChild ? 'true' : 'false'; ?>"
           aria-controls="dashboardDropdown">
          <span><i class="fas fa-chart-bar me-2"></i> Dashboard</span>
          <i class="fas fa-chevron-down dropdown-arrow" style="<?= $isDashboardChild ? 'transform: rotate(180deg);' : ''; ?>"></i>
        </a>
        <div class="collapse <?= $isDashboardChild ? 'show' : ''; ?>" id="dashboardDropdown">
          <ul class="nav flex-column ms-3">
            <li class="nav-item">
              <a class="nav-link <?= $currentPage == 'admin_dashboard_summary.php' ? 'active' : ''; ?>" href="admin_dashboard_summary.php">📈 Summary</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= $currentPage == 'dashboard_analytics.php' ? 'active' : ''; ?>" href="dashboard_analytics.php">📊 Analytics</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= $currentPage == 'ticket_list.php' ? 'active' : ''; ?>" href="ticket_list.php">📋 Ticket List</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= $currentPage == 'dashboard.php' ? 'active' : ''; ?>" href="dashboard.php">🎥 Uploaded Movies</a>
            </li>
            <li class="nav-item">
  <a class="nav-link <?= $currentPage == 'trailer_dashboard.php' ? 'active' : ''; ?>" href="trailer_dashboard.php">🎞️ Teaser Dashboard</a>
</li>
          </ul>
        </div>
      </li>

      <!-- 🎬 Other Items -->
      <li class="nav-item">
        <a class="nav-link <?= $currentPage == 'displaymovies.php' ? 'active' : ''; ?>" href="displaymovies.php">
          <i class="fas fa-film me-2"></i> Display Movies
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?= $currentPage == 'displaytreaser.php' ? 'active' : ''; ?>" href="displaytreaser.php">
          <i class="fas fa-play-circle me-2"></i> Display Treaser
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?= $currentPage == 'booking.php' ? 'active' : ''; ?>" href="booking.php">
          <i class="fas fa-ticket-alt me-2"></i> Bookings
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?= $currentPage == 'earnings_summary.php' ? 'active' : ''; ?>" href="earnings_summary.php">
          <i class="fas fa-coins me-2"></i> Earnings Summary
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?= $currentPage == 'past_sales.php' ? 'active' : ''; ?>" href="past_sales.php">
          <i class="fas fa-history me-2"></i> Past Sales
        </a>
      </li>
    </ul>

    <h4>Website Pages</h4>

    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link <?= $currentPage == 'index.php' ? 'active' : ''; ?>" href="index.php">
          <i class="fas fa-home me-2"></i> Index
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?= $currentPage == 'movies.php' ? 'active' : ''; ?>" href="movies.php">
          <i class="fas fa-clapperboard me-2"></i> Movies Treaser
        </a>
      </li>

      <!-- <li class="nav-item">
        <a class="nav-link <?= $currentPage == 'admin_change_password.php' ? 'active' : ''; ?>" href="admin_change_password.php">
          <i class="fas fa-key me-2"></i> Change Password
        </a>
      </li> -->

<li class="nav-item">
  <a href="admin_profile.php" class="admin-profile d-flex align-items-center text-decoration-none">
    <div class="admin-img-container me-2">
      <img src="image/<?= $_SESSION['admin_image'] ?? 'admin_profile_60x60.jpg'; ?>" 
     alt="Admin" 
     class="admin-img">

    </div>
    <span class="admin-name"><?= $_SESSION['admin_first_name'] ?? 'Admin'; ?></span>
  </a>
</li>


      <li class="nav-item px-3 mt-2">
        <a href="admin_logout.php" class="btn btn-logout w-100">Logout</a>

      </li>
    </ul>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

<script>
  feather.replace();

  const toggler = document.querySelector('[data-bs-toggle="collapse"][href="#dashboardDropdown"]');
  const arrowIcon = toggler?.querySelector('.dropdown-arrow');
  const dashboardMenu = document.getElementById('dashboardDropdown');

  if (dashboardMenu && arrowIcon) {
    dashboardMenu.addEventListener('show.bs.collapse', () => {
      arrowIcon.style.transform = 'rotate(180deg)';
    });

    dashboardMenu.addEventListener('hide.bs.collapse', () => {
      arrowIcon.style.transform = 'rotate(0deg)';
    });
  }

  const allNavLinks = document.querySelectorAll('.nav-link');
  allNavLinks.forEach(link => {
    link.addEventListener('click', () => {
      allNavLinks.forEach(l => l.classList.remove('active'));
      link.classList.add('active');
    });
  });
</script>