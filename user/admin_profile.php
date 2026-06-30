<?php
session_start();
include('dashheader.php');
include('dbconfig.php');

// Resize function only if not already defined
if (!function_exists('resizeImage')) {
    function resizeImage($source, $destination, $maxWidth, $maxHeight) {
        $imageInfo = getimagesize($source);
        $width = $imageInfo[0];
        $height = $imageInfo[1];
        $mime = $imageInfo['mime'];

        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($source);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source);
                break;
            default:
                return false;
        }

        $ratio = min($maxWidth / $width, $maxHeight / $height);
        $newWidth = (int)($width * $ratio);
        $newHeight = (int)($height * $ratio);

        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        if ($mime == 'image/jpeg') {
            imagejpeg($resizedImage, $destination, 85);
        } else {
            imagepng($resizedImage, $destination);
        }

        return true;
    }
}

if (!isset($_SESSION['admin_email'])) {
    header("Location: admin_login.php");
    exit();
}

$email = $_SESSION['admin_email'];
$query = mysqli_query($con, "SELECT * FROM admin WHERE email='$email'");
$admin = mysqli_fetch_assoc($query);

// Check for admin ID 2
$is_second_admin = ($admin['id'] == 2);

// Profile update logic
if (isset($_POST['update_profile'])) {
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $phone = trim($_POST['phone']);

    if (!empty($_FILES['profile_image']['name'])) {
        $imgName = time() . '_' . $_FILES['profile_image']['name'];
        $imgTmp = $_FILES['profile_image']['tmp_name'];
        $destination = "image/$imgName";

        // Image resize and upload
        if (resizeImage($imgTmp, $destination, 300, 300)) {
            mysqli_query($con, "UPDATE admin SET profile_image='$imgName' WHERE email='$email'");
            $_SESSION['admin_image'] = $imgName;
        } else {
            echo "<script>alert('Invalid image format. Only JPG and PNG allowed.');</script>";
        }
    }

    mysqli_query($con, "UPDATE admin SET first_name='$firstName', last_name='$lastName', phone='$phone' WHERE email='$email'");
    $_SESSION['admin_first_name'] = $firstName;

    echo "<script>alert('Profile updated successfully'); window.location.href='admin_profile.php';</script>";
}

// Password change logic
if (isset($_POST['change_password'])) {
    $emailInput = trim($_POST['email']);
    $current = trim($_POST['current_password']);
    $new = trim($_POST['new_password']);
    $confirm = trim($_POST['confirm_password']);

    if ($emailInput === $email) {
        $check = mysqli_query($con, "SELECT * FROM admin WHERE email='$emailInput' AND password='$current'");
        if (mysqli_num_rows($check)) {
            if ($new === $confirm) {
                mysqli_query($con, "UPDATE admin SET password='$new' WHERE email='$emailInput'");
                echo "<script>alert('Password changed successfully.');</script>";
            } else {
                echo "<script>alert('New passwords do not match.');</script>";
            }
        } else {
            echo "<script>alert('Current password incorrect.');</script>";
        }
    } else {
        echo "<script>alert('Invalid admin email.');</script>";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>Admin Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  body {
    background: #000;
    color: #fff;
    font-family: 'Poppins', sans-serif;
  }

  .profile-section {
    max-width: 900px;
    background: linear-gradient(145deg, #121212, #0a0a0a);
    border: 1px solid #e50914;
    padding: 30px;
    border-radius: 10px;
    margin-left: 260px;
    margin-top: 50px;
    box-shadow: 0 0 20px rgba(229, 9, 20, 0.2);
    transition: 0.3s ease;
  }

  .profile-section:hover {
    box-shadow: 0 0 35px rgba(229, 9, 20, 0.5);
  }

  .form-label {
    color: #e50914;
    font-weight: 500;
    letter-spacing: 0.5px;
  }

  .form-control {
    background-color: #000000ff;
    color: #fff;
    border: 1px solid #444;
    padding: 10px 14px;
    border-radius: 6px;
    transition: border 0.3s, box-shadow 0.3s;
  }

  .form-control:focus {
    outline: none;
    border-color: #e50914;
    box-shadow: 0 0 8px rgba(229, 9, 20, 0.6);
    background-color: #111;
  }
  .form-control:hover {
    background-color: #111;
  }

  .btn-primary {
    background-color: #e50914;
    border: none;
    padding: 10px 25px;
    border-radius: 6px;
    transition: all 0.3s ease-in-out;
    font-weight: 500;
    box-shadow: 0 0 12px rgba(229, 9, 20, 0.3);
  }

  .btn-primary:hover {
    background-color: #ff1b1b;
    box-shadow: 0 0 20px rgba(229, 9, 20, 0.5);
    transform: scale(1.03);
  }

  .admin-img-box {
    width: 300px;
    height: 300px;
    overflow: hidden;
    margin: 0 auto;
    border-radius: 6px;
    border: 2px solid #e50914;
    box-shadow: 0 0 15px rgba(229, 9, 20, 0.4);
    transition: transform 0.3s ease;
  }

  .admin-img-box:hover {
    transform: scale(1.02);
  }

  .profile-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 6px;
    image-rendering: auto;
  }

  @media screen and (max-width: 768px) {
    .profile-section {
      margin-left: 0;
      margin-right: 0;
    }
    .admin-img-box {
      width: 180px;
      height: 180px;
    }
  }

  .col-md-8 {
    padding-left: 30px;
  }

  h2, h4 {
    text-shadow: 0 0 5px #e50914;
    font-weight: 600;
  }

  input[type="file"] {
    background-color: #1a1a1a;
    border: 1px solid #333;
    color: #fff;
    padding: 8px;
    border-radius: 6px;
    transition: all 0.3s ease;
  }

  input[type="file"]:hover {
    border-color: #e50914;
    box-shadow: 0 0 10px rgba(229, 9, 20, 0.3);
  }

  /* General Input Style */
input[type="text"],
input[type="email"],
input[type="password"],
textarea,
select {
  background-color: #111;      /* Dark background */
  color: #fff;                 /* White text */
  border: 1px solid red;       /* Matching border */
  padding: 10px;
  border-radius: 4px;
  width: 100%;
}

/* Placeholder Style */
input::placeholder,
textarea::placeholder {
  color: #aaa;
  opacity: 1;
 
}

/* On Focus */
/* Force text to stay white in all states */
input,
input:focus,
input:-webkit-autofill,
textarea,
textarea:focus,
textarea:-webkit-autofill {
  color: #fff !important;
  -webkit-text-fill-color: #fff !important; /* For Chrome autofill */
  transition: background-color 5000s ease-in-out 0s;
  background-color: #111 !important;
}

/* Optional: Remove autofill yellow background in Chrome */
input:-webkit-autofill {
  box-shadow: 0 0 0 1000px #111 inset !important;
  border: 1px solid crimson !important;
}


/* Fixing White Admin Role Box */
input[type="text"].admin-role {
  background-color: #111;
  color: #fff;
  width: 100%;
}

/* Button Style */
button, input[type="submit"] {
  background-color: crimson;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 4px;
  cursor: pointer;
}

/* Custom file input styling (input area) */
.custom-file-input {
  display: block;
  width: 100%;
  padding: 8px 10px;
  background-color: #111;
  color: #fff;
  border: 1px solid #444;
  border-radius: 6px;
  font-size: 14px;
  transition: border-color 0.2s ease, background-color 0.2s ease;
}

/* Fix "Choose File" button in Chrome/Safari */
.custom-file-input::-webkit-file-upload-button {
  background-color: crimson;
  color: #fff;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

/* On hover */
.custom-file-input::-webkit-file-upload-button:hover {
  background-color: #ff0000ff;
}

/* On focus (important fix) */
.custom-file-input:focus,
.custom-file-input::-webkit-file-upload-button:focus {
  outline: none;
  background-color: #111;
  color: #fff;
}


</style>

</head>
<body>
<div class="profile-section">
  <h2 class="text-center mb-4">ADMIN PROFILE</h2>

  <?php if (!$is_second_admin): ?>
  <!-- ORIGINAL ADMIN PROFILE UI (ID != 2) -->
  <form method="POST" enctype="multipart/form-data" class="mb-4">
    <div class="row align-items-center mb-3">
      <div class="col-md-4 text-center">
        <div class="admin-img-box mb-2">
          <img src="image/<?= htmlspecialchars($admin['profile_image'] ?? 'admin_profile_60x60.jpg'); ?>" class="profile-img" alt="Admin Image">
        </div>
        <input type="file" name="profile_image" class="custom-file-input mt-2">
      </div>
      <div class="col-md-8 mt-3 mt-md-0">
        <label class="form-label">First Name</label>
        <input type="text" name="first_name" class="form-control mb-2" value="<?= htmlspecialchars($admin['first_name']); ?>" required>

        <label class="form-label">Last Name</label>
        <input type="text" name="last_name" class="form-control mb-2" value="<?= htmlspecialchars($admin['last_name']); ?>" required>

        <label class="form-label">Contact Number</label>
        <input type="text" name="phone" class="form-control mb-2" value="<?= htmlspecialchars($admin['phone'] ?? ''); ?>">

        <label class="form-label">Admin Role</label>
        <input type="text" name="admin_role" class="admin-role" value="<?= htmlspecialchars($admin['role'] ?? 'Admin'); ?>" readonly>

        <button type="submit" name="update_profile" class="btn btn-primary mt-2">Update Profile</button>
      </div>
    </div>
  </form>
 <?php else: ?>
<!-- ADMIN 2 CUSTOMIZED FORM MATCHING ADMIN 1 LAYOUT -->
<form method="POST" enctype="multipart/form-data" class="mb-4">
  <div class="row align-items-center mb-3">
    <div class="col-md-4 text-center">
      <div class="admin-img-box mb-2">
        <img src="image/<?= htmlspecialchars($admin['profile_image'] ?? 'admin_profile_60x60.jpg'); ?>" class="profile-img" alt="Admin Image">
      </div>
      <input type="file" name="profile_image" class="custom-file-input mt-2">
    </div>
    <div class="col-md-8 mt-3 mt-md-0">
      <label class="form-label">First Name</label>
      <input type="text" name="first_name" class="form-control mb-2" value="<?= htmlspecialchars($admin['first_name']); ?>" required>

      <label class="form-label">Last Name</label>
      <input type="text" name="last_name" class="form-control mb-2" value="<?= htmlspecialchars($admin['last_name']); ?>" required>

      <label class="form-label">Phone Number</label>
      <input type="text" name="phone" class="form-control mb-2" value="<?= htmlspecialchars($admin['phone'] ?? ''); ?>">

      <label class="form-label">Admin Role</label>
      <input type="text" name="admin_role" class="admin-role" value="<?= htmlspecialchars($admin['role'] ?? 'Admin'); ?>" readonly>

      <button type="submit" name="update_profile" class="btn btn-primary mt-2">Save Admin 2 Profile</button>
    </div>
  </div>
</form>
<?php endif; ?>


  <hr style="border-color: #e50914;">

  <form method="POST">
    <h4 class="mb-3">Change Password</h4>

    <label class="form-label">Admin Email</label>
    <input type="email" name="email" class="form-control mb-2" required>

    <label class="form-label">Current Password</label>
    <input type="password" name="current_password" class="form-control mb-2" required>

    <label class="form-label">New Password</label>
    <input type="password" name="new_password" class="form-control mb-2" required>

    <label class="form-label">Confirm Password</label>
    <input type="password" name="confirm_password" class="form-control mb-3" required>

    <button type="submit" name="change_password" class="btn btn-primary">Update Password</button>
  </form>
</div>
</body>
</html>
