<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Card Payment</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    html, body {
      height: 100%;
      background: linear-gradient(135deg, #000000, #1a0000);
      font-family: 'Poppins', sans-serif;
      color: #fff;
    }

    .card-box {
      background: #111;
      border: 1px solid #c00;
      border-radius: 16px;
      padding: 40px 30px;
      max-width: 420px;
      width: 100%;
      margin: 80px auto;
      animation: popIn 0.5s ease-out;
      box-shadow: 0 0 25px rgba(255, 0, 0, 0.4);
    }

    .card-box h2 {
      font-family: 'Bebas Neue', cursive;
      text-align: center;
      margin-bottom: 30px;
      color: #ff1a1a;
      font-size: 30px;
      letter-spacing: 1px;
    }

    .card-box input {
      width: 100%;
      padding: 16px;
      margin-bottom: 22px;
      background: #1e1e1e;
      border: 1px solid #444;
      border-radius: 10px;
      color: #fff;
      font-size: 15px;
      transition: border 0.3s ease;
    }

    .card-box input:focus {
      border-color: #e50914;
      outline: none;
    }

    .pay-btn {
      width: 100%;
      padding: 15px;
      background: #e50914;
      color: #fff;
      font-size: 17px;
      font-weight: 600;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .pay-btn:hover {
      background: #b00610;
      transform: scale(1.02);
    }

    @keyframes popIn {
      from { transform: scale(0.95); opacity: 0; }
      to   { transform: scale(1); opacity: 1; }
    }

    @media (max-width: 480px) {
      .card-box { padding: 30px 20px; }
      .card-box h2 { font-size: 26px; }
      .pay-btn { font-size: 15px; padding: 13px; }
      .card-box input { padding: 14px; font-size: 14px; }
    }

    /* Loader Styles */
    #loadingPage {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
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
      width: 70px; height: 70px;
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

    @media (min-width: 600px) {
      .loader {
        width: 100px;
        height: 100px;
        border-width: 10px;
      }

      .loading-text {
        font-size: 1.5rem;
      }
    }
  </style>
</head>
<body>

<!-- Loading Screen -->
<div id="loadingPage">
  <div class="loader"></div>
  <div class="loading-text">Processing your card payment...</div>
</div>

<!-- Payment Form -->
<div class="card-box" id="paymentForm">
  <h2>💳 Pay with Card</h2>
  <form id="cardForm">
    <input type="text" name="card_number" placeholder="Card Number" required maxlength="19">
    <input type="text" name="expiry" placeholder="Expiry (MM/YY)" required maxlength="5">
    <input type="text" name="cvv" placeholder="CVV" required maxlength="4">
    <button type="submit" class="pay-btn">Pay Now</button>
  </form>
</div>

<script>
  document.getElementById('cardForm').addEventListener('submit', function(e) {
    e.preventDefault();

    document.getElementById('paymentForm').style.display = 'none';
    const loader = document.getElementById('loadingPage');
    loader.style.display = 'flex';
    loader.style.opacity = '1';

    setTimeout(() => {
      const cardNumber = encodeURIComponent(document.querySelector('[name="card_number"]').value);
      const expiry = encodeURIComponent(document.querySelector('[name="expiry"]').value);
      const cvv = encodeURIComponent(document.querySelector('[name="cvv"]').value);

      const query = `confirm_booking.php?method=Card&card_number=${cardNumber}&expiry=${expiry}&cvv=${cvv}`;
      window.location.href = query;
    }, 2500);
  });
</script>

</body>
</html>
