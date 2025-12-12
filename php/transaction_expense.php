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
  <meta charset="utf-8" />
  <title>Add Expense</title>
  <link rel="stylesheet" href="../style.css">

  <script>
    function toSqlDate(mmddyyyy){
      const parts = mmddyyyy.split('/');
      if(parts.length !== 3) return '';
      const mm = parts[0].padStart(2,'0');
      const dd = parts[1].padStart(2,'0');
      const yyyy = parts[2];
      return `${yyyy}-${mm}-${dd}`;
    }

    function submitExpense(e){
      e.preventDefault();
      const form = document.getElementById('expenseForm');
      const dateRaw = form.date.value.trim();

      if(!dateRaw){
        alert('Isi tanggal (mm/dd/yyyy)');
        return;
      }

      const sqlDate = toSqlDate(dateRaw);
      if(!/^\d{4}-\d{2}-\d{2}$/.test(sqlDate)){
        alert('Format tanggal harus mm/dd/yyyy');
        return;
      }

      let hidden = form.querySelector('input[name="date_sql"]');
      if(!hidden){
        hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'date_sql';
        form.appendChild(hidden);
      }

      hidden.value = sqlDate;
      form.submit();
    }
  </script>
</head>

<body>
  <div class="container transaction-container">

    <h2 class="title-page">Add Expense</h2>

    <form id="expenseForm" method="post" action="add_expense.php" class="transaction-form" onsubmit="submitExpense(event);">

      <label class="form-label">Item name
        <input type="text" name="item_name" required maxlength="100" class="input-text">
      </label>

      <label class="form-label">Amount (Robux)
        <input type="number" name="amount" required min="1" class="input-number">
      </label>

      <label class="form-label">Category
        <input type="text" name="category" maxlength="50" class="input-text">
      </label>

      <label class="form-label">Date (mm/dd/yyyy)
        <input type="text" name="date" placeholder="mm/dd/yyyy" required class="input-text">
      </label>

      <label class="form-label">Bought in (game/catalog)
        <input type="text" name="bought_in" maxlength="100" class="input-text">
      </label>

      <div class="actions">
        <button type="button" class="btn btn-back" onclick="window.history.back();">Back</button>
        <button type="submit" class="btn btn-primary">Add Expense</button>
      </div>

    </form>

  </div>
</body>
</html>
