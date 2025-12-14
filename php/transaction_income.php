<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Income</title>

  <link rel="stylesheet" href="../assets/css/base.css">
  <link rel="stylesheet" href="../assets/css/income.css">
</head>
<body>

<div class="overlay"></div>
<div class="header">INCOME</div>

<div class="container">
  <div class="card form-card">

    <a href="transaction.php" class="back-btn">←</a>

    <h2>Add Income</h2>

    <form method="post" action="add_income.php">

      <label>Income Source</label>
      <input
        type="text"
        name="income_source"
        required
        maxlength="100"
      >

      <label>Amount (Robux Received)</label>
      <input
        type="number"
        name="amount"
        min="1"
        required
      >

      <label>Date Received</label>
      <input type="date" name="date_sql" required>


      <label>Received From</label>
      <input
        type="text"
        name="received_from"
        maxlength="100"
      >

      <label>Category</label>
      <input
        type="text"
        name="category"
        maxlength="50"
      >

      <button type="submit">Submit</button>

    </form>
  </div>
</div>

</body>
</html>
