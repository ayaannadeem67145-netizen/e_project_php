<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>EasyPaisa Payment</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://fonts.googleapis.com/css2?family=Inter&family=Poppins:wght@500;700&display=swap" rel="stylesheet">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      background: linear-gradient(to bottom, #000000, #611414ff);
      color: #fff;
      font-family: 'Inter', sans-serif;
    }

    .payment-box {
      background: #111;
      border: 1px solid #ff0000ff;
      padding: 40px 30px;
      max-width: 440px;
      width: 100%;
      border-radius: 18px;
      text-align: center;
      box-shadow: 0 0 20px rgba(255, 0, 0, 0.15);

      margin: 80px auto;
    }

    .icon-circle {
      background-color: #ff0000ff;
      color: #000;
      width: 65px;
      height: 65px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      font-size: 32px;
      margin: 0 auto 25px;
    }

    .payment-box h2 {
      font-family: 'Poppins', sans-serif;
      font-size: 28px;
      margin-bottom: 20px;
      color: #ff0000ff;
    }

    .payment-box p {
      font-size: 16px;
      margin: 15px 0;
      line-height: 1.7;
      color: #cccccc;
    }

    .easypaisa-number {
      font-size: 20px;
      font-weight: bold;
      color: #ff0000ff;
      margin: 18px 0;
      letter-spacing: 1px;
    }

    .confirm-btn {
      display: inline-block;
      margin-top: 30px;
      padding: 14px 26px;
      background: #ff0000ff;
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
      background: #ff0000ff;
      transform: scale(1.05);
    }

    @media (max-width: 480px) {
      .payment-box {
        padding: 30px 20px;
      }

      .payment-box h2 {
        font-size: 24px;
      }

      .confirm-btn {
        width: 100%;
        padding: 16px;
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
  <div class="loading-text">Processing your payment...</div>
</div>

<!-- Payment Section -->
<div class="payment-box" id="paymentContent">
  <div class="icon-circle">
    <i class="fas fa-money-bill-wave"></i>
  </div>

  <h2>EasyPaisa Payment</h2>

  <p>Please send your payment to the following EasyPaisa number:</p>
  <div class="easypaisa-number">0300-XXXXXXX</div>
  <p>Once payment is complete, click the button below to confirm:</p>

  <button class="confirm-btn" onclick="startPayment()">✅ Confirm Payment</button>
</div>

<script>
  function startPayment() {


    document.getElementById('paymentContent').style.display = 'none';
    const loader = document.getElementById('loadingPage');
    loader.style.display = 'flex';
    loader.style.opacity = '1';

    setTimeout(() => {
      window.location.href = 'confirm_booking.php?method=EasyPaisa';
    }, 2500);
  }
</script>

</body>
</html>
