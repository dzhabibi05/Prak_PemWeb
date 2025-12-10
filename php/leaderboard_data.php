<?php
include __DIR__ . "/db.php";


$query = "
SELECT users.username, leaderboard.score 
FROM leaderboard 
JOIN users ON leaderboard.user_id = users.id
ORDER BY leaderboard.score ASC
LIMIT 5
";

$data = mysqli_query($conn, $query);

echo "<table border='1' width='300' align='center'>";
echo "<tr><th>Rank</th><th>Nama</th><th>Time</th></tr>";

$rank = 1;
while ($row = mysqli_fetch_assoc($data)) {
  echo "<tr>";
  echo "<td>".$rank++."</td>";
  echo "<td>".$row['username']."</td>";
  echo "<td>".$row['score']."</td>";
  echo "</tr>";
}

echo "</table>";
?>
