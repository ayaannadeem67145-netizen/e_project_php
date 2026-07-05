<?php
require_once '../includes/auth.php';
require_role(ROLE_USER);

include('dbconfig.php');
global $con;

$user_email = $_SESSION['user'];
$id = $_GET['id'];

// 🛑 STEP 1: Redirect logic ko sabse upar rakhna hai (Taaki white screen error na aaye)
if (isset($_POST['btnSave'])) {
    $_SESSION['booking'] = [
        'name'     => $_POST['name'],
        'quantity' => $_POST['quantity'],
        'event'    => $_POST['event'],
        'date'     => $_POST['date'],
        'time'     => $_POST['time'],
        'price'    => $_POST['price'],
        'total'    => $_POST['total'],
        'seats'    => $_POST['selected_seats'],
        'email'    => $user_email,
    ];

    header("Location: payment.php");
    exit();
}

// 🛑 STEP 2: Ab jab redirect check ho gaya, toh tasalli se header include karo
include('header.php');

// 1. Apni TMDB API Key yahan dalein
$api_key = "dfbd45f87596dc8b931f5a0625c2a168"; 

// 2. TMDB API se Movie Details fetch karna
$api_url = "https://api.themoviedb.org/3/movie/" . $id . "?api_key=" . $api_key . "&language=en-US";
$response = @file_get_contents($api_url);
$tmdb_movie = json_decode($response, true);

if ($tmdb_movie) {
    $rec = [
        'name' => $tmdb_movie['title'],
        'show_date' => isset($tmdb_movie['release_date']) ? $tmdb_movie['release_date'] : date('Y-m-d'),
        'show_time' => '19:00:00', 
        'ticket_price' => '3000'    
    ];
} else {
    $rec = [
        'name' => 'Unknown Movie',
        'show_date' => date('Y-m-d'),
        'show_time' => '19:00:00',
        'ticket_price' => '3000'
    ];
}

$event_name = $rec['name'] . " Movie";
$bookedSeatsQ = mysqli_query($con, "SELECT seat_id FROM tickets WHERE event = '$event_name' AND status='booked'");
$bookedSeats = [];
while ($r = mysqli_fetch_assoc($bookedSeatsQ)) {
    $bookedSeats[] = $r['seat_id'];
}

$max_seats = 200;
$remaining_seats = $max_seats - count($bookedSeats);
$is_sold_out = $remaining_seats <= 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Book Tickets</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
  body {
    background: #000;
    color: #fff;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    line-height: 1.7;
  }

  .container {
    max-width: 700px;
    margin: 50px auto;
    background: #111;
    padding: 40px 30px;
    border-radius: 14px;
    box-shadow: 0 0 30px rgba(255, 0, 0, 0.4);
  }

  form > div {
    margin-bottom: 24px;
  }

  label {
    font-family: 'Bebas Neue', cursive;
    font-size: 18px;
    letter-spacing: 0.5px;
    color: #ff1a1a;
    display: block;
    margin-bottom: 10px;
  }

  input, select {
    width: 100%;
    padding: 14px 15px;
    font-size: 16px;
    background: #1c1c1c;
    border: 1px solid #ff1a1a;
    color: #fff;
    border-radius: 8px;
  }

  input[readonly] {
    background-color: #222;
    color: #aaa;
  }

  button {
    background: #e50914;
    color: white;
    padding: 14px 20px;
    border: none;
    border-radius: 8px;
    font-size: 17px;
    font-weight: 500;
    cursor: pointer;
    width: 100%;
    transition: background 0.3s ease;
    margin-top: 10px;
  }

  button:hover {
    background: #b00610;
  }

  .sold-out {
    text-align: center;
    font-size: 24px;
    padding: 40px;
    color: #ff4c4c;
    font-weight: bold;
  }

  .status {
    margin-top: -10px;
    font-weight: 600;
    color: #00ff88;
    text-align: center;
    font-size: 16px;
    padding-top: 10px;
  }

  @media screen and (max-width: 768px) {
    .container {
      margin: 25px;
      padding: 25px;
    }

    label {
      font-size: 16px;
    }

    input, select, button {
      font-size: 15px;
    }
  }
</style>

</head>
<body>

<div class="container">
  <?php if ($is_sold_out): ?>
    <div class="sold-out">🚫 All Seats Booked</div>
  <?php else: ?>
    <form method="POST">
      <div>
        <label>Full Name</label>
        <input name="name" required />
      </div>

      <div>
        <label>Tickets to Book</label>
        <input type="number" name="quantity" id="qty" min="1" max="<?= $remaining_seats ?>" value="1" required>
      </div>

      <div>
        <label>Select Adjacent Seats</label>
        <select name="selected_seats" id="seatOptions" required></select>
      </div>

    

      <div>
        <label>Event</label>
        <input name="event" value="<?= $event_name ?>" readonly />
      </div>

      <div>
        <label>Date</label>
        <input type="date" name="date" value="<?= $rec['show_date'] ?>" readonly />
      </div>

      <div>
        <label>Time</label>
        <input type="time" name="time" value="<?= substr($rec['show_time'], 0, 5) ?>" readonly />
      </div>

      <div>
        <label>Price per Ticket</label>
        <input type="text" value="Rs. <?= $rec['ticket_price'] ?>" readonly />
        <input type="hidden" id="price" name="price" value="<?= $rec['ticket_price'] ?>">
      </div>

      <div>
        <label>Total Amount</label>
        <input type="text" id="totalDisplay" value="Rs. <?= $rec['ticket_price'] ?>" readonly />
        <input type="hidden" id="total" name="total" value="<?= $rec['ticket_price'] ?>">
      </div>

      <div class="status">✅ <?= $remaining_seats ?> seats left</div>
      <button type="submit" name="btnSave">Book Now & Proceed to Payment</button>
    </form>
  <?php endif; ?>
</div>

<script>
  const price = <?= $rec['ticket_price'] ?>;
  const bookedSeats = <?= json_encode($bookedSeats) ?>;
  const seatOptions = document.getElementById('seatOptions');
  const qtyInput = document.getElementById('qty');
  const totalInput = document.getElementById('total');
  const totalDisplay = document.getElementById('totalDisplay');

  function generateSeatGroups(quantity) {
    const available = [];
    for (let r = 1; r <= 10; r++) {
      for (let s = 1; s <= 21 - quantity; s++) {
        let group = [];
        for (let i = 0; i < quantity; i++) {
          const seat = `R${r}S${s + i}`;
          if (bookedSeats.includes(seat)) {
            group = [];
            break;
          } else {
            group.push(seat);
          }
        }
        if (group.length === quantity) available.push(group);
      }
    }
    return available;
  }

  function updateSeatOptions() {
    const qty = parseInt(qtyInput.value);
    const groups = generateSeatGroups(qty);
    seatOptions.innerHTML = '';

    if (groups.length === 0) {
      seatOptions.innerHTML = '<option disabled>No adjacent seats available</option>';
    } else {
      groups.forEach(group => {
        const val = group.join(',');
        seatOptions.innerHTML += `<option value="${val}">${val}</option>`;
      });
    }

    const total = qty * price;
    totalDisplay.value = "Rs. " + total;
    totalInput.value = total;
  }

  qtyInput.addEventListener('input', updateSeatOptions);
  window.onload = updateSeatOptions;
</script>
</body>
</html>
