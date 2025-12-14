<?php
session_start();
include __DIR__ . "/db.php";

if (!isset($_SESSION['user_id'])) {
  echo "Belum login";
  exit;
}

$user_id = $_SESSION['user_id'];
$score = (int) $_POST['score'];

$check = mysqli_query($conn, "SELECT score FROM leaderboard WHERE user_id = '$user_id'");
$data = mysqli_fetch_assoc($check);

if ($data) {
  if ($score < $data['score']) {
    mysqli_query($conn, "UPDATE leaderboard SET score='$score' WHERE user_id='$user_id'");
    echo "Score diperbarui (lebih baik)";
  } else {
    echo "Score lama lebih baik, tidak diupdate";
  }
} else {
  mysqli_query($conn, "INSERT INTO leaderboard (user_id, score) VALUES ('$user_id', '$score')");
  echo "Score pertama disimpan";
}
?>
