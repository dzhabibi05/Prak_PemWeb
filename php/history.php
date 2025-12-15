<?php
session_start();
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = (int)$_SESSION['user_id'];

$filter = $_GET['type'] ?? 'all';
$allowed = ['all','income','expense'];
if (!in_array($filter, $allowed)) $filter = 'all';

$sql = "SELECT * FROM transactions WHERE user_id = ?";
if ($filter !== 'all') {
    $sql .= " AND type = '$filter'";
}
$sql .= " ORDER BY date DESC, created_at DESC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

function prettyDate($date) {
    return date('d M Y', strtotime($date));
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>History</title>
  <link rel="stylesheet" href="../assets/css/base.css">
  <link rel="stylesheet" href="../assets/css/history.css">
</head>
<body>

<div class="overlay"></div>
<div class="header">HISTORY</div>

<div class="container">

  <!-- FILTER -->
  <div class="history-filter">
    <a href="history.php?type=all">All</a>
    <a href="history.php?type=income">Income</a>
    <a href="history.php?type=expense">Expense</a>
  </div>

  <h2>Transaction History</h2>

<?php if (mysqli_num_rows($res) === 0): ?>
  <p style="text-align:center;">No transaction yet.</p>
<?php endif; ?>

<?php while ($row = mysqli_fetch_assoc($res)): ?>

  <?php
    $isIncome = $row['type'] === 'income';
    $badgeClass = $isIncome ? 'income' : 'expense';
    $amountClass = $isIncome ? 'positive' : 'negative';
    $sign = $isIncome ? '+' : '-';

    if ($isIncome) {
        $title = $row['income_source'];
        $extra = $row['received_from'];
    } else {
        $title = $row['item_name'];
        $extra = $row['category'];
    }
  ?>

  <div class="history-card card">

    <div class="history-top">
      <span class="badge <?= $badgeClass ?>">
        <?= strtoupper($row['type']) ?>
      </span>
      <span class="date">
        <?= prettyDate($row['date']) ?>
      </span>
    </div>

    <p><strong><?= htmlspecialchars($title) ?></strong></p>

    <?php if ($extra): ?>
      <p class="muted"><?= htmlspecialchars($extra) ?></p>
    <?php endif; ?>

    <p class="<?= $amountClass ?>">
      <?= $sign . number_format((int)$row['amount']) ?> Robux
    </p>

  </div>

<?php endwhile; ?>

  <a href="../home.php" class="back-btn">← Back</a>

</div>

<script src="../assets/js/animations.js"></script>
</body>
</html>
