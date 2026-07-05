<?php
session_start(); 
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}




include('../user/dashheader.php');
include('../user/dbconfig.php');
global $con;
?>

<?php







date_default_timezone_set('Asia/Karachi');

$filter = $_GET['filter'] ?? 'today';
$today = date('Y-m-d');

switch ($filter) {
    case 'today':
        $start_date = $today . " 00:00:00";
        $end_date = $today . " 23:59:59";
        break;
    case 'week':
        $start_date = date('Y-m-d', strtotime('monday this week')) . " 00:00:00";
        $end_date = date('Y-m-d', strtotime('sunday this week')) . " 23:59:59";
        break;
    case 'month':
        $start_date = date('Y-m-01') . " 00:00:00";
        $end_date = date('Y-m-t') . " 23:59:59";
        break;
    default:
        $start_date = $today . " 00:00:00";
        $end_date = $today . " 23:59:59";
        break;
}

$where_clause = "WHERE archived = 0 AND date_time >= '$start_date' AND date_time <= '$end_date'";

$total_users = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as total FROM tickets $where_clause"))['total'];
$tickets_today = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(quantity) as sold FROM tickets $where_clause"))['sold'] ?? 0;
$total_earning = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(total) as earning FROM tickets $where_clause"))['earning'] ?? 0;
$top_movie = mysqli_fetch_assoc(mysqli_query($con, "SELECT event, COUNT(*) as cnt FROM tickets $where_clause GROUP BY event ORDER BY cnt DESC LIMIT 1"));

$chart_data = mysqli_query($con, "
    SELECT DATE(date) as date, SUM(total) AS earnings, SUM(quantity) AS tickets 
    FROM tickets 
    $where_clause
    GROUP BY DATE(date) 
    ORDER BY DATE(date) ASC
");

$dates = [];
$earnings = [];
$tickets = [];
while ($row = mysqli_fetch_assoc($chart_data)) {
    $dates[] = $row['date'];
    $earnings[] = $row['earnings'];
    $tickets[] = $row['tickets'];
}
?>


  <style>
    body {
      background-color: #000;
      color: white;
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      background-color: #111;
      border: none;
      border-radius: 15px;
      color: white;
      box-shadow: 0 0 15px rgba(255, 0, 0, 0.1);
      height: 100%;
    }
    .card-title {
      font-size: 1.2rem;
      color: #e50914;
    }
    .card-value {
      font-size: 2rem;
      font-weight: bold;
    }
    .dashboard-container {
    position: absolute;
    top: 70px;         /* Yeh top waale "MYMOVIES ADMIN" bar ke thik neeche set karega */
    left: 25%;         /* Yeh sidebar ke thik right side se shuru karega */
    width: 75%;        /* Baki bachi hui poori screen content ko de dega */
    padding: 30px;
    box-sizing: border-box; /* Padding se width kharab nahi hogi */
}
    canvas {
      background-color: #111;
      border-radius: 10px;
      padding: 20px;
    }
    .filter-btns a {
      margin-right: 10px;
      color: white;
      text-decoration: none;
      padding: 6px 12px;
      border: 1px solid #e50914;
      border-radius: 6px;
    }
    .filter-btns a.active, .filter-btns a:hover {
      background-color: #e50914;
    }
   .custom-heading {
  color: #ff0019ff;     /* red like Bootstrap's text-danger */
  margin-bottom: 1rem; /* same as mb-3 */
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  font-size: 1.5rem;
}

  </style>


  <div class="dashboard-container">

    <div class="mb-4" style="color: yellow;">
        Showing results from <strong><?php echo explode(" ", $start_date)[0]; ?></strong> to <strong><?php echo explode(" ", $end_date)[0]; ?></strong>
    </div>

    <div class="filter-btns mb-4">
        <a href="?filter=today" class="<?php echo $filter == 'today' ? 'active' : ''; ?>">Today</a>
        <a href="?filter=week" class="<?php echo $filter == 'week' ? 'active' : ''; ?>">Week</a>
        <a href="?filter=month" class="<?php echo $filter == 'month' ? 'active' : ''; ?>">Month</a>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <div class="card-title">Total Users Bought Tickets</div>
                <div class="card-value"><?php echo $total_users; ?></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <div class="card-title">Tickets Sold</div>
                <div class="card-value"><?php echo $tickets_today; ?></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <div class="card-title">Total Earnings</div>
                <div class="card-value">Rs. <?php echo number_format($total_earning); ?></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <div class="card-title">Most Active Movie</div>
                <div class="card-value">
                    <?php echo $top_movie ? $top_movie['event'] : 'N/A'; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h4 class="custom-heading">📈 Total Earnings Over Time</h4>
            <canvas id="earningsChart" height="250"></canvas>
        </div>
        <div class="col-md-6">
            <h4 class="custom-heading">🎟️ Total Tickets Sold Over Time</h4>
            <canvas id="ticketsChart" height="250"></canvas>
        </div>
    </div>
</div>

<script>
    const labels = <?php echo json_encode($dates); ?>;
    const earnings = <?php echo json_encode($earnings); ?>;
    const tickets = <?php echo json_encode($tickets); ?>;

    new Chart(document.getElementById('earningsChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Earnings (Rs)',
                data: earnings,
                backgroundColor: 'rgba(229, 9, 20, 0.4)',
                borderColor: '#e50914',
                borderWidth: 2,
                fill: true
            }]
        }
    });

    new Chart(document.getElementById('ticketsChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Tickets Sold',
                data: tickets,
                backgroundColor: 'rgba(40, 167, 69, 0.4)',
                borderColor: '#28a745',
                borderWidth: 2,
                fill: true
            }]
        }
    });
   
</script>
