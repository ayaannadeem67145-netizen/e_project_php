<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cash on Delivery</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      background: linear-gradient(to bottom, #000, #1a1a1a);
      font-family: 'Poppins', sans-serif;
      color: #fff;
    }

    .cod-box {
      background: #111;
      border: 1px solid #333;
      padding: 40px 30px;
      border-radius: 14px;
      max-width: 420px;
      width: 100%;
      text-align: center;
      margin: 80px auto;
      animation: fadeIn 0.6s ease-in-out;
      box-shadow: 0 0 25px rgba(255, 0, 0, 0.2);
    }

    .delivery-icon {
      font-size: 40px;
      margin-bottom: 20px;
      color: #ccc;
    }

    .cod-box h2 {
      font-family: 'Bebas Neue', cursive;
      font-size: 30px;
      margin-bottom: 20px;
      color: #ff1a1a;
      letter-spacing: 1px;
    }

    .cod-box p {
      font-size: 16px;
      line-height: 1.8;
      color: #ddd;
      margin-bottom: 16px;
    }

    .confirm-btn {
      display: inline-block;
      margin-top: 20px;
      padding: 14px 26px;
      background: #e50914;
      color: #fff;
      font-size: 15px;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      text-decoration: none;
      transition: background 0.3s ease, transform 0.3s ease;
      cursor: pointer;
    }

    .confirm-btn:hover {
      background: #b00610;
      transform: scale(1.05);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 480px) {
      .cod-box {
        padding: 30px 20px;
      }

      .cod-box h2 {
        font-size: 26px;
      }

      .cod-box p {
        font-size: 15px;
      }

      .confirm-btn {
        width: 100%;
        padding: 14px;
        font-size: 15px;
      }
    }

    /* LOADING SCREEN STYLES */
    #loadingPage {
      position: fixed;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle at center, #111 0%, #000 100%);
      display: none;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      transition: opacity 0.5s ease;
    }

    .loader {
      border: 8px solid #1a1a1a;
      border-top: 8px solid red;
      border-radius: 50%;
      width: 70px;
      height: 70px;
      animation: spin 1.2s linear infinite;
      box-shadow: 0 0 25px red;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .loading-text {
      color: red;
      font-size: 1.2rem;
      margin-top: 20px;
      text-align: center;
      text-shadow: 0 0 5px red;
      letter-spacing: 1px;
    }

    @media (max-width: 480px) {
      .loader {
        width: 60px;
        height: 60px;
        border-width: 6px;
      }

      .loading-text {
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>

<!-- Loading Screen -->
<div id="loadingPage">
  <div class="loader"></div>
  <div class="loading-text">Processing your booking...</div>
</div>

<!-- COD Content -->
<div class="cod-box" id="codContent">
  <div class="delivery-icon">🚚</div>
  <h2>Cash on Delivery</h2>
  <p>Your booking will be reserved.</p>
  <p>You will pay in cash upon arrival at the cinema.</p>
  <p>Click below to confirm your booking.</p>
  <button class="confirm-btn" onclick="startCOD()">✅ Confirm Booking</button>
</div>

<script>
  function startCOD() {

    document.getElementById('codContent').style.display = 'none';
    const loader = document.getElementById('loadingPage');
    loader.style.display = 'flex';
    loader.style.opacity = '1';


    setTimeout(() => {
      window.location.href = 'confirm_booking.php?method=Cash%20on%20Delivery';
    }, 2500);
  }
</script>

</body>
</html>
