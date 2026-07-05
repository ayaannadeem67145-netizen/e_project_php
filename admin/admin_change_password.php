<?php
session_start();
include('../user/dbconfig.php');
global $con;
$step = 1;
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['check_email'])) {
        $email = trim($_POST['email']);
        $stmt = $con->prepare("SELECT * FROM login WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows === 1) {
            $_SESSION['change_email'] = $email;
            $step = 2;
        } else {
            $error = "❌ Email not found.";
        }
    } elseif (isset($_POST['change_password'])) {
        $email = $_SESSION['change_email'] ?? '';
        $current = $_POST['current_password'];
        $new = $_POST['new_password'];
        $confirm = $_POST['confirm_password'];

        $stmt = $con->prepare("SELECT password FROM login WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();

        if ($row && $current === $row['password']) {
            if ($new === $confirm) {
                $update = $con->prepare("UPDATE login SET password = ? WHERE email = ?");
                $update->bind_param("ss", $new, $email);
                $update->execute();
                $success = "✅ Password updated successfully!";
unset($_SESSION['change_email']);
header("Location: admin_login.php");
exit();

            } else {
                $error = "❌ New passwords do not match.";
                $step = 2;
            }
        } else {
            $error = "❌ Current password is incorrect.";
            $step = 2;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Change Admin Password</title>
  <link rel="icon" type="image/x-icon" href="image/favicon-logo.ico">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Poppins&display=swap" rel="stylesheet">

  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      background: linear-gradient(135deg, #000 60%, #e50914 100%);
      font-family: 'Poppins', sans-serif;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      padding: 20px;
    }

    .container {
      background-color: #111;
      padding: 40px;
      border-radius: 12px;
      width: 100%;
      max-width: 450px;
      box-shadow: 0 0 20px rgba(229, 9, 20, 0.3);
    }

    h2 {
      font-family: 'Orbitron', sans-serif;
      color: #e50914;
      text-align: center;
      margin-bottom: 30px;
      font-size: 28px;
      letter-spacing: 1px;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    input {
      background: #1c1c1c;
      border: 1px solid #333;
      border-radius: 8px;
      padding: 14px 16px;
      margin-bottom: 20px;
      color: #fff;
      font-size: 15px;
      transition: all 0.3s ease;
    }

    input:focus {
      outline: none;
      border-color: #e50914;
      background: #1a1a1a;
    }

    button {
      background-color: #e50914;
      border: none;
      padding: 14px;
      border-radius: 8px;
      color: #fff;
      font-weight: bold;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
      margin-top: 10px;
    }

    button:hover {
      background-color: #ff0a16;
    }

    .msg {
      text-align: center;
      font-size: 15px;
      margin-top: 15px;
    }

    .success {
      color: #00ff88;
    }

    .error {
      color: #ff4444;
    }

    @media screen and (max-width: 480px) {
      .container {
        padding: 30px 20px;
      }

      h2 {
        font-size: 22px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Change Password</h2>

    <?php if ($step === 1): ?>
      <form method="POST">
        <input type="email" name="email" placeholder="Enter Admin Email" required>
        <button type="submit" name="check_email">Verify Email</button>
      </form>
    <?php elseif ($step === 2): ?>
      <form method="POST">
        <input type="password" name="current_password" placeholder="Current Password" required>
        <input type="password" name="new_password" placeholder="New Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
        <button type="submit" name="change_password">Change Password</button>
      </form>
    <?php endif; ?>

    <?php if ($error): ?>
      <div class="msg error"><?= $error ?></div>
    <?php elseif ($success): ?>
      <div class="msg success"><?= $success ?></div>
    <?php endif; ?>
  </div>
</body>
</html>
