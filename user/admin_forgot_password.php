<?php
session_start();
include('dbconfig.php');

$step = $_SESSION['reset_step'] ?? 1;
$error = '';

// Step 1: Verify Admin Email
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_email'])) {
    $email = trim($_POST['email']);

    $res = mysqli_query($con, "SELECT * FROM admin WHERE email='$email'");
    if (mysqli_num_rows($res) === 1) {
        $row = mysqli_fetch_assoc($res);

        $_SESSION['reset_email'] = $email;
        $_SESSION['security_question'] = $row['security_question'];
        $_SESSION['security_answer'] = $row['security_answer']; // hashed or plain for now
        $_SESSION['reset_step'] = 2;
        $step = 2;
    } else {
        $error = "❌ Email not found.";
    }
}

// Step 2: Validate Security Answer
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_answer'])) {
    $given = trim(strtolower($_POST['answer']));
    $correct = strtolower($_SESSION['security_answer'] ?? '');

    if ($given === $correct) {
        $_SESSION['reset_step'] = 3;
        $step = 3;
    } else {
        $error = "❌ Incorrect answer.";
    }
}

// Step 3: Set New Password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $new = trim($_POST['new_password']);
    $confirm = trim($_POST['confirm_password']);
    $email = $_SESSION['reset_email'] ?? '';

    if ($new === $confirm) {
        mysqli_query($con, "UPDATE admin SET password='$new' WHERE email='$email'");
        session_unset();
        session_destroy();
        echo "<script>alert('✅ Password changed successfully.'); window.location='admin_login.php';</script>";
        exit();
    } else {
        $error = "❌ Passwords do not match.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Forgot Password</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #000 60%, #e50914 100%);
      color: white;
      font-family: 'Poppins', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .box {
      background: #111;
      padding: 30px;
      border-radius: 12px;
      max-width: 400px;
      width: 100%;
      box-shadow: 0 0 10px rgba(229, 9, 20, 0.5);
    }
    h2 {
      color: #e50914;
      text-align: center;
      margin-bottom: 20px;
    }
    input[type="email"], input[type="password"], input[type="text"] {
      width: 94%;
      padding: 12px;
      margin: 10px 0;
      border: none;
      border-radius: 6px;
      background: #222;
      color: white;
      font-size: 15px;
    }
    input:focus {
      outline: none;
      background-color: #1a1a1a;
      border: 1px solid #e50914;
    }
    button {
      width: 100%;
      background: #e50914;
      padding: 12px;
      border: none;
      border-radius: 6px;
      color: white;
      font-weight: bold;
      margin-top: 10px;
      cursor: pointer;
    }
    .error {
      text-align: center;
      color: red;
      font-size: 14px;
      margin-top: 10px;
    }
  </style>
</head>
<body>
<div class="box">
  <h2>Forgot Password</h2>

  <?php if ($step === 1): ?>
    <form method="POST">
      <input type="email" name="email" placeholder="Enter admin email" required>
      <button type="submit" name="verify_email">Verify Email</button>
    </form>

  <?php elseif ($step === 2): ?>
    <form method="POST">
      <label style="color:#ccc;">Security Question:</label>
      <input type="text" value="<?= $_SESSION['security_question']; ?>" disabled>
      <input type="text" name="answer" placeholder="Your Answer" required>
      <button type="submit" name="verify_answer">Submit Answer</button>
    </form>

  <?php elseif ($step === 3): ?>
    <form method="POST">
      <input type="password" name="new_password" placeholder="New Password" required>
      <input type="password" name="confirm_password" placeholder="Confirm Password" required>
      <button type="submit" name="reset_password">Reset Password</button>
    </form>
  <?php endif; ?>

  <?php if ($error) echo "<div class='error'>$error</div>"; ?>
</div>
</body>
</html>
