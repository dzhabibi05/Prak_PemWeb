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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Robux Tracker - Home</title>
    <link rel="stylesheet" href="assets/css/base.css" />
    <link rel="stylesheet" href="assets/css/home.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
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
            <span>@<?= htmlspecialchars(strtolower($username)) ?></span>
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

          <div class="menu-item" id="logoutBtn">
            <span>Logout</span>
          </div>
        </nav>
      </aside>

      <!-- CONTENT -->
      <main class="home-content">
        <h1 class="greeting">Hi, <?= htmlspecialchars($username) ?>!</h1>

        <div class="mascot-area" data-aos="zoom-in" data-aos-duration="1000">
          <img src="assets/mascot/Maskot.png" alt="Mascot" />
        </div>
      </main>
    </div>

    <!-- LOGOUT MODAL -->
    <div class="logout-modal" id="logoutPopup">
      <div class="logout-box">
        <h3>Logout?</h3>
        <p>Yakin ingin keluar?</p>

        <div class="logout-actions">
          <button class="btn-cancel" type="button" id="cancelBtn">Cancel</button>
          <button class="btn-logout" type="button" id="confirmBtn">Yes, Logout</button>
        </div>
      </div>
    </div>

    <script>
      const logoutBtn = document.getElementById("logoutBtn");
      const logoutPopup = document.getElementById("logoutPopup");
      const cancelBtn = document.getElementById("cancelBtn");
      const confirmBtn = document.getElementById("confirmBtn");

      // Open logout popup
      logoutBtn.addEventListener("click", function() {
        logoutPopup.style.display = "flex";
      });

      // Close popup when clicking cancel
      cancelBtn.addEventListener("click", function() {
        logoutPopup.style.display = "none";
      });

      // Close popup when clicking outside the box
      logoutPopup.addEventListener("click", function(e) {
        if (e.target === logoutPopup) {
          logoutPopup.style.display = "none";
        }
      });

      // Confirm logout
      confirmBtn.addEventListener("click", function() {
        window.location.href = "php/logout.php";
      });
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>
    <script src="assets/js/animations.js"></script>
  </body>
</html>
