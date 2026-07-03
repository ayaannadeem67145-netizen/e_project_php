<?php
session_start();
include('dbconfig.php');

if (isset($_POST['signup'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "<script>alert('Please fill in all the fields.');</script>";
    } else {
        $query = "SELECT * FROM login WHERE email=?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            echo "<script>alert('Email already exists. Please use a different email or log in.');</script>";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertQuery = mysqli_prepare($con, "INSERT INTO login (email, password) VALUES (?, ?)");
            mysqli_stmt_bind_param($insertQuery, "ss", $email, $hashedPassword);

            if (mysqli_stmt_execute($insertQuery)) {
                $_SESSION['user'] = $email;
                setcookie("user", $email, time() + (60 * 60 * 24 * 7), "/");
                $_SESSION['show_review_popup'] = true;
                header("Location: index.php");
                exit();
            } else {
                echo "<script>alert('Something went wrong. Please try again.');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Signup</title>
  <link rel="icon" type="image/x-icon" href="image/favicon-logo.ico">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Poppins&display=swap" rel="stylesheet">

  <style>
    * { box-sizing: border-box; }

    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background: radial-gradient(ellipse at top, #121212, #000);
      color: #fff;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 30px 20px;
    }

    .signup-container {
      background-color: #1a1a1a;
      padding: 50px 40px;
      border-radius: 16px;
      box-shadow: 0 0 30px rgba(255, 0, 0, 0.3);
      width: 100%;
      max-width: 420px;
      position: relative;
      overflow: hidden;
    }

    .signup-container h2 {
      font-family: 'Orbitron', serif;
      color: #ff1a1a;
      margin-bottom: 40px;
      font-size: 28px;
      font-weight: bold;
      text-align: center;
    }

    .input-group {
      position: relative;
      margin-bottom: 30px;
    }

    .input-group input {
      width: 100%;
      padding: 16px 12px;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      background-color: #262626;
      color: #fff;
      outline: none;
    }

    .input-group label {
      position: absolute;
      top: 50%;
      left: 12px;
      transform: translateY(-50%);
      font-size: 16px;
      color: #aaa;
      transition: 0.2s;
      pointer-events: none;
    }

    .input-group input:focus + label,
    .input-group input:not(:placeholder-shown) + label {
      top: -10px;
      left: 10px;
      font-size: 12px;
      background-color: #1a1a1a;
      padding: 0 5px;
      color: #ff1a1a;
    }

    .signup-btn {
      width: 100%;
      background-color: #ff1a1a;
      border: none;
      padding: 14px;
      border-radius: 8px;
      font-size: 18px;
      font-weight: 600;
      color: white;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 0 10px #ff1a1a;
    }

    .signup-btn:hover {
      background-color: #cc0000;
      box-shadow: 0 0 18px #ff1a1a, 0 0 5px #ff1a1a;
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
      .signup-container {
        padding: 40px 25px;
      }

      .signup-container h2 {
        font-size: 24px;
      }

      .signup-btn {
        font-size: 16px;
        padding: 12px;
      }
    }

    @media (max-width: 768px) {
  .signup-container {
    padding: 40px 30px;
  }

  .signup-container h2 {
    font-size: 26px;
  }

  .signup-btn {
    font-size: 16px;
    padding: 12px;
  }
}

/* Responsive for mobile */
@media (max-width: 480px) {
  .signup-container {
    padding: 30px 20px;
  }

  .signup-container h2 {
    font-size: 22px;
  }

  .input-group input {
    padding: 14px 10px;
    font-size: 15px;
  }

  .signup-btn {
    font-size: 15px;
    padding: 12px;
  }
}
  </style>
</head>
<body>
  <div class="signup-container">
    <h2>SIGN UP FIRST PLEASE</h2>
    <form method="post" autocomplete="off">
      <div class="input-group">
        <input type="email" id="email" name="email" required placeholder=" " />
        <label for="email">Email Address</label>
      </div>

      <div class="input-group">
        <input type="password" id="password" name="password" required placeholder=" " />
        <label for="password">Password</label>
      </div>

      <button type="submit" class="signup-btn" name="signup">Sign Up</button>
    </form>

    <div class="footer">
  <p>Already have an account? <a href="login.php">Login here</a></p>
  
</div>

  </div>
</body>
</html>  
