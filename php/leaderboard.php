<?php
session_start();

// Sesuaikan path db.php kamu. 
// Jika db.php ada di folder 'php', gunakan "php/db.php"
// Jika ada di folder yang sama, gunakan "db.php"
require_once "db.php"; 

// Cek login user
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

// Query dari file lama kamu (Logic tetap sama)
$query = "
SELECT users.username, leaderboard.score 
FROM leaderboard 
JOIN users ON leaderboard.user_id = users.id
ORDER BY leaderboard.score ASC
LIMIT 10
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Leaderboard - Roblox Obby</title>
  <link rel="stylesheet" href="leaderboard.css">
</head>
<body>

<div class="container">
  <h1>🏆 Top 10 Players</h1>
  
  <table>
    <thead>
      <tr>
        <th>Rank</th>
        <th>Username</th>
        <th>Time (s)</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if (mysqli_num_rows($result) > 0) {
          $rank = 1;
          while ($row = mysqli_fetch_assoc($result)) {
              // Menambahkan class khusus untuk juara 1-3
              $rankClass = "";
              if ($rank == 1) $rankClass = "rank-1";
              if ($rank == 2) $rankClass = "rank-2";
              if ($rank == 3) $rankClass = "rank-3";

              echo "<tr>";
              echo "<td class='$rankClass'>#" . $rank++ . "</td>";
              echo "<td>" . htmlspecialchars($row['username']) . "</td>";
              echo "<td>" . $row['score'] . "s</td>";
              echo "</tr>";
          }
      } else {
          echo "<tr><td colspan='3'>Belum ada data permainan.</td></tr>";
      }
      ?>
    </tbody>
  </table>

  <div class="btn-group">
    <a href="../home.php" class="btn btn-home">🏠 Home</a>
    <a href="../game.php" class="btn btn-play">▶ Main Lagi</a>
  </div>
</div>

</body>
</html>