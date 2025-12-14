<?php
session_start();

require_once "db.php"; 

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

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