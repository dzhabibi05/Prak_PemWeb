<?php
session_start();
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = (int)$_SESSION['user_id'];

$income_source = isset($_POST['income_source']) ? trim($_POST['income_source']) : '';
$amount = isset($_POST['amount']) ? (int)$_POST['amount'] : 0;
$received_from = isset($_POST['received_from']) ? trim($_POST['received_from']) : '';
$category = isset($_POST['category']) ? trim($_POST['category']) : '';
$date_sql = isset($_POST['date_sql']) ? trim($_POST['date_sql']) : '';

if ($income_source === '' || $amount <= 0 || $date_sql === '') {
    die("Missing or invalid fields.");
}

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_sql)) {
    die("Invalid date format.");
}

mysqli_begin_transaction($conn);

try {
    $ins = "INSERT INTO transactions 
      (user_id,type,income_source,received_from,category,amount,date) 
      VALUES (?,?,?,?,?,?,?)";
    $type = 'income';

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $ins)) throw new Exception("Prepare failed: " . mysqli_error($conn));
    // types: i s s s s i s  -> "isssiss"
    mysqli_stmt_bind_param($stmt, "isssiss", $user_id, $type, $income_source, $received_from, $category, $amount, $date_sql);
    if (!mysqli_stmt_execute($stmt)) throw new Exception("Execute failed: " . mysqli_stmt_error($stmt));
    mysqli_stmt_close($stmt);

    $upd = "UPDATE users SET robux_balance = robux_balance + ? WHERE id = ?";
    $ust = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($ust, $upd)) throw new Exception("Prepare update failed: " . mysqli_error($conn));
    mysqli_stmt_bind_param($ust, "ii", $amount, $user_id);
    if (!mysqli_stmt_execute($ust)) throw new Exception("Update failed: " . mysqli_stmt_error($ust));
    mysqli_stmt_close($ust);

    mysqli_commit($conn);
    header("Location: ../php/balance.php");
    exit;
} catch (Exception $e) {
    mysqli_rollback($conn);
    die("Error: " . $e->getMessage());
}
