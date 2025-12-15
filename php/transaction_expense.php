<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Expenses</title>
    <link rel="stylesheet" href="../assets/css/base.css" />
    <link rel="stylesheet" href="../assets/css/expenses.css" />
  </head>
  <body>
    <div class="overlay"></div>
    <div class="header">EXPENSES</div>

    <div class="container">
      <div class="card form-card">
        <a href="transaction.php" class="back-btn">←</a>
        <h2>Add Expenses</h2>

        <form method="post" action="add_expense.php">

          <label>Item Name</label>
          <input type="text" name="item_name" required maxlength="100" />

          <label>Amount (Robux)</label>
          <input type="number" name="amount" min="1" required />

          <label>Category</label>
          <select name="category" required>
            <option value="">Select Category</option>
            <option value="avatar">Avatar</option>
            <option value="gamepass">Game Pass</option>
            <option value="accessories">Accessories</option>
            <option value="other">Other</option>
          </select>

          <label>Date</label>
          <input type="date" name="date_sql" required value="<?= date('Y-m-d') ?>" />

          <label>Bought In (Game/Catalog)</label>
          <select name="bought_in" required>
            <option value="">Select Option</option>
            <option value="game">Game</option>
            <option value="catalog">Catalog</option>
          </select>

          <button type="submit">Submit</button>

        </form>

        <a href="history.php" class="history-link">View Transaction History</a>
      </div>
    </div>
    <script src="../assets/js/animations.js"></script>
  </body>
</html>
