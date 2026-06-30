<?php 
require_once '../includes/auth.php';
require_role(ROLE_ADMIN);
include('dbconfig.php');
include('header.php'); 
?>

<?php

if(isset($_POST['btnSave'])){
  global $con;
  $name = $_POST['name'];
  $genre = $_POST['genre'];
  $filename = $_FILES['cover_image']['name'];
  $filesize = $_FILES['cover_image']['size'];
  $Tmpname = $_FILES['cover_image']['tmp_name'];
  $filepath = "./uploads/" . $filename;
  move_uploaded_file($Tmpname , $filepath);
  mysqli_query($con , "INSERT INTO `movie`(`name`, `genre`, `cover_image`) VALUES ('$name','$genre','$filepath')");
  unset($_POST['btnSave']);
}

if (isset($_POST['btnDel'])) {
  global $con;
  $id = $_POST['id'];
  mysqli_query($con, "DELETE FROM `movie` WHERE id = '$id' ");

  unset($_POST['btnDel']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Panel</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    body {
      margin: 0;
      background-color: #111;
      color: #fff;
    }

    .admin-container {
      display: flex;
      flex-wrap: wrap;
      gap: 40px;
      padding: 40px 20px;
      justify-content: center;
      background: linear-gradient(to right, #1a1a1a, #0d0d0d);
      min-height: 100vh;
    }

    .admin-form,
    .admin-panel {
      flex: 1 1 500px;
      max-width: 700px;
      height: 450px;
    }

    .admin-form {
      background-color: #222;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 15px rgba(229, 9, 20, 0.3);
    }

    .admin-form h1 {
      text-align: center;
      color: #e50914;
      margin-bottom: 25px;
    }

    .admin-form label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
    }

    .admin-form input[type="file"],
    .admin-form input[type="text"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      background-color: #111;
      border: 1px solid #444;
      color: white;
      border-radius: 4px;
    }

    .admin-form input::placeholder {
      color: #aaa;
    }

    .form-actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .form-actions button {
      width: 550px;
      margin: auto;
    }

    .admin-form button,
    .admin-form .view-records {
      background-color: #e50914;
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .admin-form button:hover,
    .admin-form .view-records:hover {
      background-color: #ff1e2d;
    }

    .admin-panel h1 {
      color: #e50914;
      margin-bottom: 20px;
    }

    .admin-table {
      width: 100%;
      border-collapse: collapse;
      background-color: #222;
      color: #fff;
    }

    .admin-table thead {
      background-color: #e50914;
    }

    .admin-table th,
    .admin-table td {
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid #333;
    }

    .admin-table tbody tr:hover {
      background-color: #333;
    }



    .admin-table a {
      text-decoration: none;
      background-color: #e50914;
      color: white;
      border: none;
      padding: 5px 10px;
      margin-right: 5px;
      border-radius: 4px;
      cursor: pointer;
      transition: background 0.3s;
    }
    .admin-table button {
      height: 31px;
      text-decoration: none;
      background-color: #e50914;
      color: white;
      border: none;
      padding: 5px 10px;
      margin-right: 5px;
      border-radius: 4px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .admin-table button:hover {
      background-color: #ff1e2d;
    }
  </style>
</head>

<body>

  <div class="admin-container">

    <form method="POST" enctype="multipart/form-data" class="admin-form">
      <h1>Admin Panel</h1>

      <label for="cover_image">Cover Image:</label>
      <input type="file" name="cover_image" id="cover_image" required />

      <label for="name">Movie Name:</label>
      <input type="text" name="name" id="name" placeholder="Enter Movie Name" required />

      <label for="genre">Genre:</label>
      <input type="text" name="genre" id="genre" placeholder="Enter Movie Category" required />

      <div class="form-actions">
        <button type="submit" name="btnSave">Upload</button>
      </div>
    </form>




    <div class="admin-panel">
      <h1>Uploaded Records</h1>
      <table class="admin-table" id="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Genre</th>
            <th>Image</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>

          <?php


          $fetch = mysqli_query($con, "SELECT * FROM `movie`");
          while ($record = mysqli_fetch_array($fetch)) {

          ?>
            <tr>

              <td><?php echo  $record['id'] ?></td>
              <td><?php echo  $record['name'] ?></td>
              <td><?php echo  $record['genre'] ?></td>
              <td> <img src="<?php echo  $record['cover_image']; ?>" style="width:70px;" class=""  alt=""></td>
              <td>
                <form method="POST">
                  <a href="update.php?id=<?php echo $record['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>

                  <input type="hidden" name="id" value="<?php echo $record['id'] ?>">
                  <button name="btnDel"><i class="fa-solid fa-trash"></i></button>

                  <a><i class="fa-solid fa-cart-shopping"></i></a>
                </form>
              </td>

            </tr>
          <?php  } ?>
        </tbody>
      </table>
    </div>

  </div>
<?php
include('footer.php');

?>
</body>

</html>