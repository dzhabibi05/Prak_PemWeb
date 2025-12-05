<?php
// game.php
require_once "php/auth.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Game — Roblox Mini</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <header class="topbar">
    <div class="container">
      <div>
        <strong>Roblox Mini</strong>
      </div>
      <div class="user-area">
        Halo, <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?> |
        <a href="php/logout.php">Logout</a>
      </div>
    </div>
  </header>

  <main class="container">
    <h2>Game Prototype</h2>

    

    <div id="gameArea">
      <div id="player"></div>
      <div class="platform" id="plat1"></div>
      <div class="platform" id="plat2"></div>
    </div>

  </main>

  <script src="game.js"></script>
</body>
</html>
