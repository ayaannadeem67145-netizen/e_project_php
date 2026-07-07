<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['booking'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Select Payment Method</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&family=Open+Sans&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      background: linear-gradient(to right, #000000, #1a1a1a);
      color: #fff;
      font-family: 'Open Sans', sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 30px 20px;
    }

    .container {
      background: #111;
      padding: 45px 35px;
      border-radius: 18px;
      width: 100%;
      max-width: 470px;
      box-shadow: 0 0 25px rgba(255, 0, 0, 0.15);
      text-align: center;
    }

    h2 {
      font-family: 'Montserrat', sans-serif;
      margin-bottom: 35px;
      font-size: 28px;
      color: #ff1a1a;
      text-shadow: 0 0 4px #ff1a1a;
    }

    .payment-option {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 100%;
      padding: 16px 20px;
      margin-bottom: 18px;
      background: #1f1f1f;
      border: 1px solid #333;
      border-radius: 12px;
      color: #fff;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .payment-option:hover {
      background: #ff1a1a;
      color: #000;
      border-color: #ff1a1a;
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(255, 26, 26, 0.4);
    }

    .payment-option i {
      margin-right: 12px;
      font-size: 18px;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 14px;
    }

    @media (max-width: 480px) {
      .container {
        padding: 30px 20px;
      }

      h2 {
        font-size: 24px;
        margin-bottom: 28px;
      }

      .payment-option {
        font-size: 15px;
        padding: 14px;
      }

      .payment-option i {
        font-size: 16px;
        margin-right: 8px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Select Payment Method</h2>
    <form action="process_payment.php" method="POST">
      <button class="payment-option" name="method" value="easypaisa">
        <i class="fas fa-mobile-alt"></i> Pay with EasyPaisa
      </button>
      <button class="payment-option" name="method" value="jazzcash">
        <i class="fas fa-money-bill-wave"></i> Pay with JazzCash
      </button>
      <button class="payment-option" name="method" value="card">
        <i class="fas fa-credit-card"></i> Pay with Debit/Credit Card
      </button>
     
    </form>
  </div>
</body>
</html>
