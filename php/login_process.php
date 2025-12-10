<?php
// php/login_process.php
session_start();
require_once "db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Redirect ke login.php (bukan html lagi)
    header("Location: ../login.php");
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Cek jika kosong
if ($username === '' || $password === '') {
    // Kirim error 'empty' kembali ke halaman login
    header("Location: ../login.php?error=empty");
    exit;
}

$sql = "SELECT id, username, password FROM users WHERE username = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if ($user && password_verify($password, $user['password'])) {
    // Login sukses
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    
    session_regenerate_id(true);
    
    // Redirect ke Home, bukan langsung ke Game
    header("Location: ../home.php");
    exit;
} else {
    // Kirim error 'invalid' (salah password/user)
    header("Location: ../login.php?error=invalid");
    exit;
}
?>