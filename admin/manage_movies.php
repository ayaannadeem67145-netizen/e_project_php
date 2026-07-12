<?php
include('config.php');
include('sidebar.php');

// ADD MOVIE
if(isset($_POST['add_movie'])){
    $name = $_POST['name'];
    $genre = $_POST['genre'];
    $date = $_POST['show_date'];
    $time = $_POST['show_time'];
    $price = $_POST['ticket_price'];

    $filename = $_FILES['cover_image']['name'];
    $filename = str_replace(" ", "", $filename); // space remove

    $tempname = $_FILES['cover_image']['tmp_name'];

    $upload_folder = "uploads/" . $filename;

    move_uploaded_file($tempname, $upload_folder);

    $img_path = $filename;

    // ✅ FIX HERE
    $query = "INSERT INTO movie (name, genre, ticket_price, cover_image, show_date, show_time)
              VALUES ('$name', '$genre', '$price', '$img_path', '$date', '$time')";

    mysqli_query($con, $query);

    // optional success redirect
    header("Location: manage_movies.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<style>
body {background:#0f0f0f;color:#fff;font-family:Arial;}
.container {display:flex;gap:20px;margin-left:240px;padding:20px;}
.box {background:#181818;padding:20px;border-radius:10px;width:100%;}
input {width:100%;padding:10px;margin:5px 0;background:#222;color:#fff;border:none;}
button {background:red;color:#fff;padding:10px;width:100%;border:none;}
table {width:100%;margin-top:10px;}
th {color:red;text-align:left;}
td {padding:10px;border-bottom:1px solid #333;}
</style>
</head>

<body>

<div class="container">

<div class="box">
<h2>Add Movie</h2>
<form method="POST" enctype="multipart/form-data">
<input type="text" name="name" placeholder="Title" required>
<input type="text" name="genre" placeholder="Genre" required>
<input type="date" name="show_date" required>
<input type="time" name="show_time" required>
<input type="number" name="ticket_price" placeholder="Price" required>
<input type="file" name="cover_image" required>
<button name="add_movie">Save</button>
</form>
</div>

<div class="box">
<h2>Movies</h2>

<table>
<tr>
<th>Title</th>
<th>Genre</th>
<th>Image</th>
<th>Delete</th>
</tr>

<?php
$res = mysqli_query($con,"SELECT * FROM movie ORDER BY id DESC");
while($row = mysqli_fetch_assoc($res)){
?>

<tr>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['genre']; ?></td>
<td><img src="../user/uploads/<?php echo $row['cover_image']; ?>" width="60"></td>
<td><a href="?del=<?php echo $row['id']; ?>" style="color:red;">Delete</a></td>
</tr>

<?php } ?>

</table>
</div>

</div>
</body>
</html>