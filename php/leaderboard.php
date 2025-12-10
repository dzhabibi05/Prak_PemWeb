<?php
include __DIR__ . "/db.php";


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
<html>
<head>
  <title>Leaderboard</title>
  <style>
    body {
      font-family: Arial;
      background: #111;
      color: white;
      text-align: center;
    }
    table {
      margin: auto;
      border-collapse: collapse;
      width: 400px;
    }
    th, td {
      border: 1px solid white;
      padding: 10px;
    }
  </style>
</head>
<body>

<h1>🏆 LEADERBOARD</h1>

<table>
<tr>
  <th>Rank</th>
  <th>Username</th>
  <th>Score</th>
</tr>

<?php
$rank = 1;
while ($row = mysqli_fetch_assoc($result)) {
  echo "<tr>";
  echo "<td>".$rank++."</td>";
  echo "<td>".$row['username']."</td>";
  echo "<td>".$row['score']."</td>";
  echo "</tr>";
}
?>

</table>

</body>
</html>
