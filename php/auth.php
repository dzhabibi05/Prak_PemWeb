<?php
// php/auth.php
session_start();

// Jika tidak login, redirect ke login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}
?>
