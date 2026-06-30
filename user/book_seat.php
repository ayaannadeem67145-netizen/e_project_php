<?php
require_once '../includes/auth.php';
require_role(ROLE_USER);

include('dbconfig.php');
global $con;

if (!isset($_POST['seat'])) {
    echo "No seat selected.";
    exit;
}
$seat = mysqli_real_escape_string($con, $_POST['seat']);
$user = $_SESSION['user'] ?? 'guest@example.com';

mysqli_query($con, "INSERT INTO tickets (email, event, date, time, quantity, total, status)
VALUES ('$user', '3D Test Event', CURDATE(), '6:00 PM', 1, 500, 'booked')");

echo "Seat $seat booked successfully!";
?>
