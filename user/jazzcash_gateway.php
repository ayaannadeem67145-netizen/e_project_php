<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>JazzCash Payment</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter&family=Poppins:wght@600;700&display=swap" rel="stylesheet">

  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    html, body {
      height: 100%;
      background: linear-gradient(to bottom, #000000, #1a1a1a);
      font-family: 'Inter', sans-serif;
      color: #fff;
    }

    .payment-box {
      background: #111;
      border: 1px solid orange;
      padding: 40px 30px;
      max-width: 440px;
      width: 100%;
      border-radius: 16px;
      text-align: center;
      box-shadow: 0 0 10px rgba(255, 165, 0, 0.15);
      margin: 80px auto;
    }

    .payment-icon {
      font-size: 52px;
      margin-bottom: 20px;
    }

    .payment-box h2 {
      font-family: 'Poppins', sans-serif;
      font-size: 28px;
      margin-bottom: 20px;
      color: orange;
    }

    .payment-box p {
      font-size: 16px;
      margin: 12px 0;
      line-height: 1.7;
      color: #e0e0e0;
    }

    .jazzcash-number {
      font-size: 20px;
      font-weight: bold;
      color: #ff0000ff;
      margin: 18px 0;
      letter-spacing: 1px;
    }

    .confirm-btn {
      display: inline-block;
      margin-top: 28px;
      padding: 14px 26px;
      background: orange;
      color: #000;
      font-size: 16px;
      font-weight: bold;
      border: none;
      border-radius: 10px;
      text-decoration: none;
      transition: 0.3s ease;
      cursor: pointer;
    }

    .confirm-btn:hover {
      background: #ffaa00;
      transform: scale(1.05);
    }

    /* Loading Overlay Styles */
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


    .payment-box {
  background: #111;
  border: 1px solid #ff0000;
  box-shadow: 0 0 10px rgba(255, 0, 0, 0.15);
}

/* Heading */
.payment-box h2 {
  color: #ff0000;
}

/* JazzCash number */
.jazzcash-number {
  color: #ff0000ff;
}

/* Confirm button */
.confirm-btn {
  background: #ff0000;
  color: #000;
}

.confirm-btn:hover {
  background: #cc0000;
}

/* Loader glow */
.loader {
  box-shadow: 0 0 25px rgba(255, 0, 0, 0.2);
}

/* Loading text */
.loading-text {
  color: #ff0000;
  text-shadow: 0 0 5px #ff0000;
}

    @media (max-width: 480px) {
      .payment-box {
        padding: 30px 20px;
        margin: 60px 20px;
      }

      .payment-box h2 {
        font-size: 24px;
      }

      .payment-box p {
        font-size: 15px;
      }

      .jazzcash-number {
        font-size: 18px;
      }

      .confirm-btn {
        width: 100%;
        padding: 16px;
      }

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

<!-- Loading Overlay -->
<div id="loadingPage">
  <div class="loader"></div>
  <div class="loading-text">Processing your payment...</div>
</div>

<!-- Payment Box -->
<div class="payment-box" id="paymentContent">
  <div class="payment-icon">💰</div>
  <h2>JazzCash Payment</h2>
  <p>Please send payment to the following JazzCash number:</p>
  <div class="jazzcash-number">0321-XXXXXXX</div>
  <p>Once you've sent the payment, click below to confirm your booking:</p>
  <button class="confirm-btn" onclick="startPayment()">✅ Confirm Payment</button>
</div>

<script>
  function startPayment() {

    document.getElementById('paymentContent').style.display = 'none';
    const loader = document.getElementById('loadingPage');
    loader.style.display = 'flex';
    loader.style.opacity = '1';

    setTimeout(() => {
      window.location.href = 'confirm_booking.php?method=JazzCash';
    }, 2500); 
  }
</script>

</body>
</html>
