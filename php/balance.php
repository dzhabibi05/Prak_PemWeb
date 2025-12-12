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
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Robux Balance</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>

  <div class="container balance-container">

    <div class="avatar-placeholder">💰</div>

    <h1 class="balance-title">
      Hi, <?php echo htmlspecialchars($username); ?>
    </h1>

    <p class="balance-label">Your robux balance:</p>

    <div class="balance-value">
      <?php echo number_format((int)$balance); ?> R$
    </div>

    <div class="balance-subtext">
      Last updated: <?php echo date('Y-m-d H:i:s'); ?>
    </div>

    <div class="actions">
      <a href="transaction_expense.php" class="btn btn-expense">Add Expense</a>
      <a href="transaction_income.php" class="btn btn-income">Add Income</a>
      <a href="history.php" class="btn btn-history">History</a>
      <a href="../home.php" class="btn btn-back">Back to Home</a>
    </div>

  </div>

</body>
</html>
