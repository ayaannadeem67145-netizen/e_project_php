<?php
session_start();
include('dbconfig.php');

$step = 1;

// STEP 1 — Check Email
if (isset($_POST['check_email'])) {
    $email = trim($_POST['email']);
    $query = "SELECT * FROM login WHERE email='$email'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $_SESSION['reset_email'] = $email;
        $_SESSION['reset_code'] = rand(100000, 999999);
        $step = 2;
        // In real app, send this via email
        echo "<script>alert('Your verification code is: {$_SESSION['reset_code']}');</script>";
    } else {
        echo "<script>alert('Email not found.');</script>";
    }
}

// STEP 2 — Verify Code
if (isset($_POST['verify_code'])) {
    $code = trim($_POST['code']);
    if (isset($_SESSION['reset_code']) && $code == $_SESSION['reset_code']) {
        $step = 3;
    } else {
        echo "<script>alert('Invalid code. Try again.');</script>";
        $step = 2;
    }
}

// STEP 3 — Reset Password
if (isset($_POST['reset_password'])) {
    $newPassword = trim($_POST['new_password']);
    $email = $_SESSION['reset_email'] ?? '';

    if (!empty($email) && !empty($newPassword)) {
        $hashed_password = password_hash($newPassword, PASSWORD_BCRYPT);
        $update = "UPDATE login SET password='$hashed_password' WHERE email='$email'";

        if (mysqli_query($con, $update)) {
            session_destroy(); // clear session
            echo "<script>alert('Password reset successfully! Please login.'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Error updating password.');</script>";
        }
    } else {
        echo "<script>alert('Please enter a new password.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Forgot Password</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Poppins&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      background: linear-gradient(145deg, #0d0d0d, #1a1a1a);
      font-family: 'Inter', sans-serif;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      flex-direction: column;
    }

    .login-container {
      background-color: #121212;
      padding: 50px 40px;
      border-radius: 16px;
      box-shadow: 0 0 25px rgba(255, 0, 0, 0.5);
      width: 100%;
      max-width: 420px;
    }

    h2 {
      font-family: 'Orbitron', sans-serif;
      font-size: 32px;
      color: #ff1a1a;
      text-align: center;
      margin-bottom: 30px;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    .floating-label {
      position: relative;
      margin-bottom: 30px;
    }

    .floating-label input {
      width: 100%;
      padding: 16px 14px;
      background-color: #1f1f1f;
      border: 1px solid #333;
      border-radius: 10px;
      color: #fff;
      font-size: 16px;
      outline: none;
    }

    .floating-label label {
      position: absolute;
      top: 16px;
      left: 14px;
      font-size: 16px;
      color: #aaa;
      pointer-events: none;
      transition: 0.2s ease all;
    }

    .floating-label input:focus + label,
    .floating-label input:not(:placeholder-shown) + label {
      top: -10px;
      left: 10px;
      font-size: 13px;
      color: #ff1a1a;
      background: #121212;
      padding: 0 4px;
    }

    .login-btn {
      padding: 15px;
      border: none;
      border-radius: 10px;
      background: linear-gradient(90deg, #ff1a1a, #cc0000);
      color: white;
      font-size: 17px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 0 12px rgba(255, 26, 26, 0.6);
    }

    .login-btn:hover {
      background: linear-gradient(90deg, #cc0000, #990000);
      transform: translateY(-2px);
      box-shadow: 0 0 18px rgba(255, 26, 26, 0.8);
    }

    .footer {
  margin-top: 30px;
  font-size: 15px;
  display: flex;
  justify-content: center;
  gap: 30px;
  flex-wrap: wrap;
}

.footer a {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: rgba(255, 26, 26, 0.05);
  color: #bbb;
  padding: 10px 16px;
  border-radius: 8px;
  text-decoration: none;
  transition: all 0.3s ease;
  font-weight: 500;
  border: 1px solid transparent;
}

.footer a:hover {
  color: #fff;
  background: rgba(255, 26, 26, 0.15);
  border-color: #ff1a1a;
  transform: scale(1.05);
}

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 500px) {
      .login-container {
        padding: 35px 25px;
      }

      h2 {
        font-size: 26px;
      }
    }

    
  </style>
</head>
<body>
<div class="login-container">
  <h2>FORGOT PASSWORD</h2>

  <?php if ($step === 1): ?>
    <!-- Step 1: Enter Email -->
    <form method="post">
      <div class="floating-label">
        <input type="email" name="email" placeholder=" " required>
        <label for="email">Enter your registered email</label>
      </div>
      <button type="submit" name="check_email" class="login-btn">Next</button>
    </form>

  <?php elseif ($step === 2): ?>
    <!-- Step 2: Enter Code -->
    <form method="post">
      <div class="floating-label">
        <input type="text" name="code" placeholder=" " required>
        <label for="code">Enter verification code</label>
      </div>
      <button type="submit" name="verify_code" class="login-btn">Verify Code</button>
    </form>

  <?php elseif ($step === 3): ?>
    <!-- Step 3: Reset Password -->
    <form method="post">
      <div class="floating-label">
        <input type="password" name="new_password" placeholder=" " required>
        <label for="new_password">New Password</label>
      </div>
      <button type="submit" name="reset_password" class="login-btn">Reset Password</button>
    </form>
  <?php endif; ?>

 <div class="footer">
  <a href="login.php">
    <i class="fas fa-sign-in-alt"></i> Back to Login
  </a>
  <a href="signin.php">
    <i class="fas fa-user-plus"></i> Sign up
  </a>
</div>

  </div>
</body>
</html>
