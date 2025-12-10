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
  <style>
    body {
      margin: 0;
      padding: 0;
      background: linear-gradient(#00A2FF, #A1DEFF); /* Roblox Sky Blue */
      font-family: 'Verdana', sans-serif;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container {
      background: rgba(255, 255, 255, 0.95);
      width: 400px;
      padding: 30px;
      border-radius: 20px;
      text-align: center;
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
      border: 5px solid #fff;
    }

    .avatar-placeholder {
      width: 80px;
      height: 80px;
      background: #eee;
      border-radius: 15px; /* Sedikit rounded box */
      margin: 0 auto 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 40px;
      border: 3px solid #ccc;
    }

    h1 {
      color: #333;
      font-family: 'Arial Black', sans-serif; /* Font tebal ala game */
      margin-bottom: 5px;
    }

    p {
      color: #666;
      margin-bottom: 30px;
    }

    .btn {
      display: block;
      width: 100%;
      padding: 15px;
      margin-bottom: 15px;
      border: none;
      border-radius: 10px;
      font-size: 18px;
      font-weight: bold;
      color: white;
      cursor: pointer;
      text-decoration: none;
      transition: transform 0.1s;
      box-sizing: border-box;
      position: relative;
    }

    .btn:active {
      transform: translateY(4px);
      border-bottom-width: 0px;
      margin-top: 4px; /* Supaya layout tidak geser */
      margin-bottom: 11px;
    }

    /* Tombol Play (Hijau Khas Roblox) */
    .btn-play {
      background-color: #00B06F;
      border-bottom: 6px solid #008C56; /* Efek 3D */
    }

    /* Tombol Leaderboard (Kuning/Oranye) */
    .btn-leaderboard {
      background-color: #F0B90B;
      border-bottom: 6px solid #C69500;
    }

    /* Tombol Logout (Merah/Abu) */
    .btn-logout {
      background-color: #FF5252;
      border-bottom: 6px solid #D32F2F;
      width: auto;
      display: inline-block;
      padding: 10px 20px;
      font-size: 14px;
      margin-top: 10px;
    }

    .footer {
      margin-top: 20px;
      font-size: 12px;
      color: #888;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="avatar-placeholder">🤠</div>
    
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>Siap untuk menaklukkan tantangan?</p>

    <a href="game.php" class="btn btn-play">
      ▶ PLAY OBBY
    </a>

    <a href="php/leaderboard.php" class="btn btn-leaderboard">
      🏆 LEADERBOARD
    </a>

    <a href="php/logout.php" class="btn btn-logout">Logout</a>

    <div class="footer">Roblox Obby 2D v1.0</div>
  </div>

</body>
</html>