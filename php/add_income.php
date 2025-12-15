<?php
session_start();
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = (int)$_SESSION['user_id'];

// cek apakah ini initial balance
$isInitial = isset($_POST['initial']) && $_POST['initial'] == '1';

// ambil amount
$amount = isset($_POST['amount']) ? (int)$_POST['amount'] : 0;
if ($amount < 0) {
    die("Invalid amount.");
}

// default values
$type = 'income';
$income_source = '';
$received_from = '';
$category = '';
$date_sql = '';


if ($isInitial) {
    $income_source = 'Initial Balance';
    $received_from = 'System';
    $category = 'initial';
    $date_sql = date('Y-m-d');
}

else {
    $income_source = trim($_POST['income_source'] ?? '');
    $received_from = trim($_POST['received_from'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $date_sql = trim($_POST['date_sql'] ?? '');

    if ($income_source === '' || $amount <= 0 || $date_sql === '') {
        die("Missing or invalid fields.");
    }

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_sql)) {
        die("Invalid date format.");
    }
}


mysqli_begin_transaction($conn);

try {
    // insert transaction
    $sql = "INSERT INTO transactions
        (user_id, type, income_source, received_from, category, amount, date)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "isssiss",
        $user_id,
        $type,
        $income_source,
        $received_from,
        $category,
        $amount,
        $date_sql
    );
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // update balance
    $upd = "UPDATE users SET robux_balance = robux_balance + ? WHERE id = ?";
    $ust = mysqli_prepare($conn, $upd);
    mysqli_stmt_bind_param($ust, "ii", $amount, $user_id);
    mysqli_stmt_execute($ust);
    mysqli_stmt_close($ust);

    mysqli_commit($conn);

    header("Location: ../php/balance.php");
    exit;

} catch (Exception $e) {
    mysqli_rollback($conn);
    die("Error: " . $e->getMessage());
}
