<?php
session_start();
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = (int)$_SESSION['user_id'];
$filter = isset($_GET['type']) ? $_GET['type'] : 'all';
$allowed = ['all','income','expense'];
if (!in_array($filter, $allowed)) $filter = 'all';

$sql = "SELECT id,type,item_name,category,bought_in,income_source,received_from,amount,date,created_at 
        FROM transactions WHERE user_id = ?";
$params = [$user_id];
$types = "i";

if ($filter === 'income') {
    $sql .= " AND type = 'income'";
} elseif ($filter === 'expense') {
    $sql .= " AND type = 'expense'";
}

$sql .= " ORDER BY date DESC, created_at DESC";

$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    die("Prepare failed: " . mysqli_error($conn));
}
mysqli_stmt_bind_param($stmt, $types, ...$params);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Transaction History</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>

  <div class="container history-container">

    <h2 class="history-title">Transaction History</h2>

    <div class="history-filters">
      <a class="btn filter-all" href="history.php?type=all">All</a>
      <a class="btn filter-income" href="history.php?type=income">Income</a>
      <a class="btn filter-expense" href="history.php?type=expense">Expense</a>
    </div>

    <table class="history-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Type</th>
          <th>Description</th>
          <th>Amount (R$)</th>
          <th>Date</th>
          <th>Created</th>
        </tr>
      </thead>
      <tbody>

<?php while ($row = mysqli_fetch_assoc($res)): ?>
        <tr>
          <td><?php echo (int)$row['id']; ?></td>

          <td class="type-<?php echo $row['type']; ?>">
            <?php echo ucfirst($row['type']); ?>
          </td>

          <td>
            <?php
              if ($row['type'] === 'expense') {
                $desc = trim(
                  ($row['item_name'] ?? '') .
                  ($row['category'] ? " — {$row['category']}" : '') .
                  ($row['bought_in'] ? " (in: {$row['bought_in']})" : '')
                );
              } else {
                $desc = trim(
                  ($row['income_source'] ?? '') .
                  ($row['received_from'] ? " — from: {$row['received_from']}" : '') .
                  ($row['category'] ? " — {$row['category']}" : '')
                );
              }
              echo htmlspecialchars($desc);
            ?>
          </td>

          <td><?php echo number_format((int)$row['amount']); ?></td>
          <td><?php echo htmlspecialchars($row['date']); ?></td>
          <td><?php echo htmlspecialchars($row['created_at']); ?></td>
        </tr>
<?php endwhile; ?>

      </tbody>
    </table>

    <div class="history-back">
      <a href="balance.php" class="btn btn-back">Back to Balance</a>
    </div>

  </div>

</body>
</html>
