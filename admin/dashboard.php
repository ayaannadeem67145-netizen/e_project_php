<?php
include('config.php');

$today = date('Y-m-d');

// Total Movies Count
$movies_query = mysqli_query($con, "SELECT COUNT(*) as total FROM movie");
$movies_data = mysqli_fetch_assoc($movies_query);

// Today's Scheduled Movies
$sched_query = mysqli_query($con, "SELECT COUNT(*) as total FROM movie WHERE show_date = '$today'");
$sched_data = mysqli_fetch_assoc($sched_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; background: #111; color: #fff; }
        .sidebar { width: 260px; height: 100vh; background: #1a1a1a; padding: 20px; position: fixed; border-right: 1px solid #333; }
        .sidebar h2 { color: #ff1a1a; margin-bottom: 30px; text-transform: uppercase; letter-spacing: 1px; }
        .sidebar a { display: block; color: #bbb; padding: 12px 15px; text-decoration: none; margin-bottom: 10px; border-radius: 5px; font-weight: 500; }
        .sidebar a:hover, .sidebar a.active { background: #ff1a1a; color: #fff; }
        .sidebar a i { margin-right: 10px; }
        .main-content { margin-left: 260px; flex: 1; padding: 40px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 1px solid #333; padding-bottom: 20px; }
        .stats-container { display: flex; gap: 20px; margin-bottom: 30px; }
        .card { flex: 1; background: #1a1a1a; padding: 25px; border-radius: 8px; border: 1px solid #333; position: relative; overflow: hidden; }
        .card h3 { color: #888; font-size: 14px; text-transform: uppercase; margin-bottom: 10px; }
        .card .number { font-size: 32px; font-weight: bold; color: #fff; }
        .card i { position: absolute; right: 20px; bottom: 20px; font-size: 40px; color: #333; }
        .card.prime { border-left: 4px solid #ff1a1a; }
    </style>
</head>
<body>

    <?php include('sidebar.php'); ?>

    <div class="main-content">
        <div class="header">
            <h1>Dashboard Summary</h1>
            <span style="color: #888;">System Date: <?php echo date('d M, Y'); ?></span>
        </div>

        <div class="stats-container">
            <div class="card prime">
                <h3>Total Movies</h3>
                <div class="number"><?php echo $movies_data['total']; ?></div>
                <i class="fa-solid fa-video"></i>
            </div>
            <div class="card prime">
                <h3>Scheduled Today</h3>
                <div class="number"><?php echo $sched_data['total']; ?></div>
                <i class="fa-solid fa-calendar-day"></i>
            </div>
            <div class="card prime">
                <h3>Total Bookings</h3>
                <div class="number">0</div>
                <i class="fa-solid fa-ticket"></i>
            </div>
        </div>
    </div>

</body>
</html>