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
  <style>
    body {
      margin: 0;
      /* Background biru langit khas Roblox Obby */
      background: linear-gradient(#00A2FF, #A1DEFF);
      font-family: 'Verdana', sans-serif;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
    }

    .container {
      background: rgba(255, 255, 255, 0.95);
      width: 500px;
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
      border: 5px solid #fff;
    }

    h1 {
      margin-top: 0;
      color: #333;
      font-family: 'Arial Black', sans-serif;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    /* Styling Table agar terlihat modern */
    table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
      background: white;
      border-radius: 10px;
      overflow: hidden; /* Supaya border-radius table kelihatan */
    }

    th {
      background-color: #3498db;
      color: white;
      padding: 12px;
      text-transform: uppercase;
      font-size: 14px;
    }

    td {
      padding: 12px;
      border-bottom: 1px solid #eee;
      color: #333;
      font-weight: bold;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    tr:hover {
      background-color: #e0f7ff;
    }

    /* Badge untuk Ranking 1, 2, 3 */
    .rank-1 { color: #f1c40f; font-size: 1.2em; } /* Emas */
    .rank-2 { color: #95a5a6; font-size: 1.1em; } /* Perak */
    .rank-3 { color: #cd7f32; font-size: 1.1em; } /* Perunggu */

    /* Tombol Navigasi */
    .btn-group {
      display: flex;
      gap: 10px;
      margin-top: 20px;
    }

    .btn {
      flex: 1;
      padding: 15px;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: bold;
      color: white;
      cursor: pointer;
      text-decoration: none;
      transition: transform 0.1s;
    }

    .btn:active {
      transform: translateY(3px);
    }

    .btn-home {
      background-color: #e67e22;
      border-bottom: 5px solid #d35400;
    }
    
    .btn-play {
      background-color: #2ecc71;
      border-bottom: 5px solid #27ae60;
    }
  </style>
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