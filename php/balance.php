<?php
session_start();
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = (int)$_SESSION['user_id'];

$sql = "SELECT username, robux_balance FROM users WHERE id = ?";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    die("Prepare failed: " . mysqli_error($conn));
}
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $username, $balance);
if (!mysqli_stmt_fetch($stmt)) {
    mysqli_stmt_close($stmt);
    die("User not found.");
}
mysqli_stmt_close($stmt);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Balance Robux</title>
  <link rel="stylesheet" href="../assets/css/base.css">
</head>
<body>

<div class="overlay"></div>
<div class="header">BALANCE ROBUX</div>

<div class="container">
  <div class="card" style="text-align:center">
    <a href="../home.php" class="back-btn">←</a> 

    <h2>Your Balance Robux Now Is</h2>

    <h1 style="font-size:64px;margin-top:20px;">
      <?php echo number_format((int)$balance); ?> Robux
    </h1>
  </div>
</div>

</body>
</html>

