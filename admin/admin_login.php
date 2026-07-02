<?php
session_start();
include('dbconfig.php');

// If already logged in, redirect to dashboard
if (isset($_SESSION['admin_email'])) {
    header("Location: admin_dashboard_summary.php");
    exit();
}

$error = '';

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $con->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $row = $res->fetch_assoc();

        // In production, use password_verify(). For now, plain match:
        if ($password === $row['password']) {

            // ✅ Store all required session values
            $_SESSION['admin'] = true;
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_image'] = $row['profile_image'] ?? 'admin_profile.jpg';
            $_SESSION['admin_first_name'] = $row['first_name'] ?? 'Admin';

            // ✅ Optional: Remember admin for 30 days
            setcookie('admin_email', $row['email'], time() + (86400 * 30), "/");

            header("Location: admin_dashboard_summary.php");
            exit();
        } else {
            $error = "❌ Invalid password.";
        }
    } else {
        $error = "❌ Unauthorized email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <link rel="icon" type="image/x-icon" href="image/favicon-logo.ico">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Poppins&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; }

    body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #000 60%, #e50914 100%);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-container {
      background-color: #111;
      padding: 40px;
      border-radius: 12px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 0 15px rgba(229, 9, 20, 0.6);
    }

    .login-container h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #e50914;
      font-family: 'Orbitron', sans-serif;
      font-size: 28px;
      letter-spacing: 1px;
    }

    .login-container input[type="email"],
    .login-container input[type="password"] {
      width: 100%;
      padding: 14px 16px;
      margin: 12px 0 20px;
      border: none;
      border-radius: 8px;
      background-color: #222;
      color: white;
      font-size: 15px;
    }

    .login-container input:focus {
      outline: none;
      border: 1px solid #e50914;
      background-color: #1a1a1a;
    }

    .login-container button {
      width: 100%;
      padding: 14px;
      background-color: #e50914;
      color: white;
      font-weight: bold;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .login-container button:hover {
      background-color: #ff0a16;
    }

    .error {
      text-align: center;
      color: red;
      margin-top: 10px;
      font-size: 14px;
    }

    @media screen and (max-width: 480px) {
      .login-container { padding: 30px 20px; }
      .login-container h2 { font-size: 24px; }
    }
  </style>
</head>
<body>
  <form method="POST" class="login-container">
    <h2>Admin Login</h2>
    <input type="email" name="email" placeholder="Admin Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
    <?php if ($error) echo "<div class='error'>$error</div>"; ?>
    <div style="text-align: center; margin-top: 10px;">
  <a href="admin_forgot_password.php" style="color: #e50914; text-decoration: none;">Forgot Password?</a>
</div>

  </form>
</body>
</html>
