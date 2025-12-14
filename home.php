<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Robux Tracker - Home</title>

  <link rel="stylesheet" href="assets/css/base.css" />
  <link rel="stylesheet" href="assets/css/home.css" />
</head>

<body>
  <div class="overlay"></div>

  <!-- HEADER -->
  <header class="top-header">ROBUX TRACKER</header>

  <!-- MAIN -->
  <div class="home-container">
    <!-- SIDEBAR -->
    <aside class="sidebar">

      <!-- PROFILE -->
      <div class="profile-strip">
        <div class="profile-avatar"></div>
        <div class="profile-info">
          <h3><?= htmlspecialchars($username) ?></h3>
          <span>@<?= htmlspecialchars($username) ?></span>
        </div>
      </div>

      <!-- MENU -->
      <nav class="menu-list">
        <a class="menu-item" href="php/balance.php">
          <img src="assets/icons/robux.png" />
          <span>Balanced Robux</span>
        </a>

        <a class="menu-item" href="php/transaction.php">
          <img src="assets/icons/transaction.png" />
          <span>Transaction</span>
        </a>

        <a class="menu-item" href="php/history.php">
          <img src="assets/icons/transaction history.png" />
          <span>Transaction History</span>
        </a>

        <a class="menu-item" href="game.php">
          <img src="assets/icons/mini game.png" />
          <span>Mini Game</span>
        </a>

        <a class="menu-item" href="#" onclick="openLogoutPopup(); return false;">
    <span>Logout</span>
  </a>


      </nav>
    </aside>

    <main class="home-content">
      <h1 class="greeting">Hi, <?= htmlspecialchars($username) ?>!</h1>

      <div class="mascot-area">
        <img src="assets/mascot/Maskot.png" alt="Mascot" />
      </div>
    </main>
  </div>

  <div class="logout-modal" id="logoutPopup" style="display:none;">
  <div class="logout-box">
    <h3>Logout?</h3>
    <p>Yakin ingin keluar?</p>

    <div class="logout-actions">
      <button class="btn-cancel" type="button" onclick="closeLogoutPopup()">Cancel</button>
      <button class="btn-logout" type="button" onclick="confirmLogout()">Yes, Logout</button>
    </div>
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
