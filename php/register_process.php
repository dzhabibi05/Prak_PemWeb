<?php
// php/register_process.php
require_once "db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../register.html");
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// validasi sederhana
if ($username === '' || $password === '') {
    echo "<script>alert('Username dan password wajib diisi'); window.location='../register.html';</script>";
    exit;
}

// cek apakah username sudah ada
$sql = "SELECT id FROM users WHERE username = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
if (mysqli_stmt_num_rows($stmt) > 0) {
    echo "<script>alert('Username sudah digunakan, pilih username lain'); window.location='../register.html';</script>";
    mysqli_stmt_close($stmt);
    exit;
}
mysqli_stmt_close($stmt);

// hash password
$hashed = password_hash($password, PASSWORD_DEFAULT);

// insert user baru
$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $username, $hashed);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if ($ok) {
    echo "<script>alert('Registrasi sukses! Silakan login.'); window.location='../login.html';</script>";
} else {
    // debug message
    echo "Error: " . mysqli_error($conn);
}
?>
