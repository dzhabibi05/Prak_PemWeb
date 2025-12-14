<?php
session_start();
require_once "db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../login.php");
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
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
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    
    session_regenerate_id(true);
    
    header("Location: ../home.php");
    exit;
} else {
    header("Location: ../login.php?error=invalid");
    exit;
}
?>