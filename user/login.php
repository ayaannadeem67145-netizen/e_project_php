<?php
session_start();
include('dbconfig.php');

if (isset($_POST['btn'])) {
  global $con;
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

  if (empty($email) || empty($password)) {
        echo "<script>alert('Please fill in all the fields.');</script>";
    } else {
        // SQL Query ekdum sahi format mein
        $query = "SELECT * FROM login WHERE email = '$email'";

        $result = mysqli_query($con, $query);

        // Pehle check karein ki user mila ya nahi
        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            
            // Ab password verify karein
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $email;
                $_SESSION['user_id'] = $user['id'];      
                $_SESSION['role_id'] = $user['role_id'];  
                $_SESSION['show_review_popup'] = true;
                setcookie("user", $email, time() + (60 * 60 * 24 * 7), "/");

                // Role ke hisaab se redirect
                if ($user['role_id'] == 1) {
                    header("Location: ../admin/admin.php");
                } elseif ($user['role_id'] == 2) {
                    header("Location: dashboard.php");
                } else {
                    header("Location: index.php");
                }
                exit();
            } else {
                echo "<script>alert('Incorrect password');</script>";
            }
        } else {
            echo "<script>alert('Email not found');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Movie Booking Login</title>
  <link rel="icon" type="image/x-icon" href="image/favicon-logo.ico">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Poppins&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #0d0d0d, #1a1a1a);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      overflow: hidden;
      padding: 20px;
    }

    .login-container {
      background-color: #111;
      padding: 50px 40px;
      border-radius: 20px;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 0 30px rgba(255, 26, 26, 0.15);
      position: relative;
      animation: fadeInUp 0.8s ease forwards;
      transform: translateY(20px);
      opacity: 0;
    }

    @keyframes fadeInUp {
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .login-container h2 {
      text-align: center;
      font-family: 'Orbitron', sans-serif;
      font-size: 30px;
      margin-bottom: 36px;
      color: #ff1a1a;
      letter-spacing: 1px;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 30px;
    }

    .form-group {
      position: relative;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 16px 14px 16px 14px;
      border: 1px solid #333;
      background: #1c1c1c;
      color: #fff;
      font-size: 16px;
      border-radius: 8px;
      transition: border-color 0.3s, background 0.3s;
    }

    input:focus {
      outline: none;
      border-color: #ff1a1a;
      background: #252525;
    }

    label {
      position: absolute;
      top: 50%;
      left: 14px;
      transform: translateY(-50%);
      font-size: 15px;
      color: #aaa;
      transition: 0.2s ease all;
      pointer-events: none;
      background-color: #1c1c1c;
      padding: 0 6px;
    }

    input:focus + label,
    input:not(:placeholder-shown) + label {
      top: -10px;
      font-size: 12px;
      color: #ff1a1a;
      background-color: #1a1a1a;
      left: 10px;
       padding: 0 5px;
    }

    .login-btn {
      width: 100%;
      background: #ff1a1a;
      padding: 14px;
      font-size: 17px;
      font-weight: 600;
      color: #fff;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      box-shadow: 0 4px 15px rgba(255, 26, 26, 0.3);
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .login-btn:hover {
      background: #e60000;
      transform: scale(1.03);
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

    @media (max-width: 480px) {
      .login-container {
        padding: 36px 24px;
      }

      .login-container h2 {
        font-size: 26px;
      }

      .login-btn {
        font-size: 16px;
      }
    }
    @media (max-width: 768px) {
    body {
      padding: 16px;
    }

    .login-container {
      padding: 40px 24px;
    }

    .login-container h2 {
      font-size: 26px;
    }

    .login-btn {
      font-size: 16px;
      padding: 12px;
    }

    label {
      font-size: 14px;
    }

    input[type="email"],
    input[type="password"] {
      font-size: 15px;
      padding: 14px 12px;
    }

    .footer {
      gap: 15px;
    }

    .footer a {
      font-size: 14px;
      padding: 8px 14px;
    }
  }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>LOGIN TO MY MOVIE</h2>
    <form method="post">
      <div class="form-group">
        <input type="email" id="email" name="email" placeholder=" " required />
        <label for="email">Email Address</label>
      </div>

      <div class="form-group">
        <input type="password" id="password" name="password" placeholder=" " required />
        <label for="password">Password</label>
      </div>

      <button type="submit" class="login-btn" name="btn">Login</button>
    </form>

   <div class="footer">
  <a href="./forgot_password.php">
    <i class="fas fa-unlock-alt"></i> Forgot Password?
  </a>
  <a href="./signin.php">
    <i class="fas fa-user-plus"></i> Sign in
  </a>
</div>
  </div>
</body>
</html>
