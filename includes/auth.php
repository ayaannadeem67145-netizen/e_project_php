<?php
if (session_status() === PHP_SESSION_NONE) session_start();

define('ROLE_ADMIN', 1);
define('ROLE_STAFF', 2);
define('ROLE_USER',  3);

function require_role($roles) {
    if (!isset($_SESSION['user'])) {
        header("Location: /e_project_php/user/login.php"); exit();
    }
    if (!is_array($roles)) $roles = [$roles];
   if (!in_array($_SESSION['role_id'] ?? 3, $roles)) {
        // Agar role galat hai toh loop mein phansane ke bajaye direct login ya error show karein
        echo "<script>alert('Aapko yeh page dekhne ki ijazat nahi hai!'); window.location.href='/e_project_php/user/login.php';</script>";
        exit();
    }
}