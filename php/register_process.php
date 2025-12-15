<?php
require_once "db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../register.php");
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

/* =====================
   VALIDASI INPUT KOSONG
   ===================== */
if ($username === '' && $password === '') {
    header("Location: ../register.php?error=empty");
    exit;
}

if ($username === '') {
    header("Location: ../register.php?error=username_empty");
    exit;
}

if ($password === '') {
    header("Location: ../register.php?error=password_empty");
    exit;
}

/* =====================
   VALIDASI PANJANG PASSWORD
   ===================== */
if (strlen($password) < 8) {
    header("Location: ../register.php?error=password_length");
    exit;
}

/* =====================
   CEK USERNAME SUDAH ADA
   ===================== */
$sql = "SELECT id FROM users WHERE username = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    mysqli_stmt_close($stmt);
    header("Location: ../register.php?error=username_taken");
    exit;
}
mysqli_stmt_close($stmt);

/* =====================
   INSERT USER BARU
   ===================== */
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $username, $hashedPassword);
$success = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if ($success) {
    header("Location: ../login.php?register=success");
    exit;
}

echo "Database error: " . mysqli_error($conn);
