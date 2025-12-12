<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Home - Roblox Obby</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <div class="container">
    <div class="avatar-placeholder">🤠</div>
    
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>Siap untuk menaklukkan tantangan?</p>

    <a href="game.php" class="btn btn-play">▶ PLAY OBBY</a>
    <a href="php/leaderboard.php" class="btn btn-leaderboard">🏆 LEADERBOARD</a>
    <a href="php/balance.php" class="btn btn-balance">💰 ROBUX BALANCE</a>

    <!-- Trigger popup -->
    <button class="btn btn-logout" onclick="openLogoutPopup()">Logout</button>

    <div class="footer">Roblox Obby 2D v1.0</div>
  </div>

  <!-- POPUP LOGOUT -->
  <!-- POPUP LOGOUT -->
<div class="popup" id="logoutPopup" style="display:none;">
  <div class="popup-box">
    <h3>Logout?</h3>
    <p>Yakin ingin keluar?</p>

    <button onclick="closeLogoutPopup()">Cancel</button>
    <button onclick="confirmLogout()">Yes, Logout</button>
  </div>
</div>


  <script>
    function openLogoutPopup(){
      document.getElementById("logoutPopup").style.display = "flex";
    }

    function closeLogoutPopup(){
      document.getElementById("logoutPopup").style.display = "none";
    }

    function confirmLogout(){
      window.location.href = "php/logout.php";
    }
  </script>

</body>
</html>
