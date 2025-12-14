<?php
session_start();
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = (int)$_SESSION['user_id'];


$sql = "SELECT robux_balance FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $current_balance);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Transaction</title>
  <link rel="stylesheet" href="../assets/css/base.css">
  <link rel="stylesheet" href="../assets/css/transaction.css">
</head>
<body>

<div class="overlay"></div>

<header class="top-header">
  TRANSACTION
</header>

<div class="transaction-container">
  <div class="transaction-card">

    <a href="../home.php" class="back-btn">←</a>

    <h2 class="card-title">Transaction</h2>

    <div class="action-buttons">
      <a href="transaction_expense.php" class="action-box">
        Add Expenses
      </a>
      <a href="transaction_income.php" class="action-box">
        Add Income
      </a>
    </div>

    <?php if ((int)$current_balance === 0): ?>
  <form method="post" action="add_income.php" class="initial-robux">
    <input type="hidden" name="initial" value="1">

    <input
      type="number"
      name="amount"
      min="0"
      required
      placeholder="For your first time Robux Tracker, please input your current Robux"
    >
    <button type="submit" class="submit-btn">Submit</button>
  </form>
<?php endif; ?>


  </div>
</div>

</body>
</html>
