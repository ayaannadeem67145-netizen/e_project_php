<?php
// Top section ko aisa kar lijiye:
session_start(); 

// ✅ FIX: Path wapas wahi kiya kyunki file sach mein user folder ke andar hi hai
include('../user/dbconfig.php'); 
/** @var mysqli $con */ // 👈 Is bar is comment ko include ke theek neeche bina kisi double slash (//) ke likhein

include('sidebar.php');
// ==========================================
// 🛠️ DELETE MOVIE LOGIC
// ==========================================
if (isset($_GET['del'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['del']);
    
    $delete_query = "DELETE FROM movie WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        echo "<script>alert('Movie successfully deleted!'); window.location.href='manage_movies.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error: Movie delete nahi ho payi.');</script>";
    }
}

// ==========================================
// ➕ ADD MOVIE LOGIC
// ==========================================
if(isset($_POST['add_movie'])){
    // Inputs escape kiye security ke liye
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $genre = mysqli_real_escape_string($con, $_POST['genre']);
    $date = mysqli_real_escape_string($con, $_POST['show_date']);
    $time = mysqli_real_escape_string($con, $_POST['show_time']);
    $price = mysqli_real_escape_string($con, $_POST['ticket_price']);

    $filename = $_FILES['cover_image']['name'];
    $filename = str_replace(" ", "", $filename); // Spaces remove kiye

    $tempname = $_FILES['cover_image']['tmp_name'];
    $upload_folder = "../user/uploads/" . $filename;

    if(move_uploaded_file($tempname, $upload_folder)){
        $img_path = $filename;

        $query = "INSERT INTO movie (name, genre, ticket_price, cover_image, show_date, show_time)
                  VALUES ('$name', '$genre', '$price', '$img_path', '$date', '$time')";
        
        if(mysqli_query($con, $query)){
            echo "<script>alert('Movie successfully added!'); window.location.href='manage_movies.php';</script>";
            exit();
        } else {
            echo "<script>alert('Database Error: Movie add nahi ho payi.');</script>";
        }
    } else {
        echo "<script>alert('Error: Image upload nahi ho pa rahi hai.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cinema Admin</title>
    <style>
        /* Pure page ka background aur font styling */
        body {
            background-color: #0f0f0f;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 30px;
        }

        /* Cinema Admin Heading */
        h1 {
            font-size: 28px;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        /* 🔴 Top Navigation Links ko Bada aur Red karne ke liye */
        /* 🔴 Sidebar aur Top Header ke a tags ko bada aur red karne ke liye */
a {
    color: #e50914 !important; /* Netflix Bright Red */
    font-size: 20px !important; /* Font size bada kiya */
    font-weight: bold !important;
    text-decoration: none !important;
    margin-right: 20px;
    transition: color 0.2s ease;
}

a:hover {
    color: #fff !important; /* Hover karne par white */
}

        /* 🛠️ Pure Content ko left/center me ache se shift karne ke liye wrapper */
        .main-wrapper {
            display: flex;
            gap: 30px;
            max-width: 1300px;
            margin-left: 20px; /* Left side shifted space ke sath */
        }

        /* Left Side: Add Movie Box */
        .box {
            flex: 0 0 320px; /* Fixed width form ke liye */
            background-color: #181818;
            padding: 25px;
            border-radius: 10px;
            height: fit-content;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }

        .box h2 {
            margin-top: 0;
            font-size: 22px;
            margin-bottom: 20px;
        }

        /* Form Inputs */
        input, select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            background-color: #222;
            color: #fff;
            border: 1px solid #333;
            border-radius: 6px;
            box-sizing: border-box;
        }

        button {
            background-color: #e50914;
            color: #fff;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.2s;
        }

        button:hover {
            background-color: #b80710;
        }

        /* Right Side: Movies List Box */
        .table-container {
            flex: 1; /* Bacha hua poora space table ko milega */
            background-color: #181818;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }

        .table-container h2 {
            margin-top: 0;
            font-size: 22px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Table Headings Red */
        th {
            color: #e50914;
            text-align: left;
            padding: 12px;
            border-bottom: 2px solid #333;
            font-size: 16px;
            text-transform: uppercase;
        }

        td {
            padding: 15px 12px;
            border-bottom: 1px solid #222;
            vertical-align: middle;
        }

        /* Movie Poster Image Style */
        .movie-img {
            width: 140px;
            height: 85px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #333;
        }

        /* 🔴 Delete Button Styled Cleanly */
        .btn-delete {
            color: #e50914;
            text-decoration: none;
            font-weight: bold;
            border: 1px solid #e50914;
            padding: 6px 14px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .btn-delete:hover {
            background-color: #e50914;
            color: #fff;
        }
    </style>
</head>
<body>

    <div class="main-wrapper" style="margin-top: 20px;">
        
        <div class="box">
            <h2>Add Movie</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Title" required>
                <input type="text" name="genre" placeholder="Genre" required>
                <input type="date" name="show_date" required>
                <input type="time" name="show_time" required>
                <input type="number" name="ticket_price" placeholder="Price" required>
                <input type="file" name="cover_image" required style="background:none; border:none; padding:5px 0;">
                <button type="submit" name="add_movie">Save</button>
            </form>
        </div>

        <div class="table-container">
            <h2>Movies</h2>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Genre</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Database se movies display karne ka loop
                    $res = mysqli_query($con, "SELECT * FROM movie ORDER BY id DESC");
                    while($row = mysqli_fetch_assoc($res)){
                    ?>
                    <tr>
                        <td style="font-weight: bold; font-size: 15px;"><?php echo htmlspecialchars($row['name']); ?></td>
                        <td style="color: #aaa;"><?php echo htmlspecialchars($row['genre']); ?></td>
                        <td>
                            <img src="../user/uploads/<?php echo $row['cover_image']; ?>" class="movie-img" alt="poster">
                        </td>
                        <td>
                            <a href="?del=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Kya aap sach mein is movie ko delete karna chahte hain?');">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>