<?php
session_start();

// Jika user sudah login, redirect ke home
if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Roblox Trackers - Welcome</title>
    <link rel="stylesheet" href="assets/css/login.css" />
    <style>
      .welcome-wrapper {
        position: relative;
        width: 318px;
        padding: 35px 28px;
        background: rgba(20, 20, 20, 0.55);
        border-radius: 18px;
        backdrop-filter: blur(1px);
        color: white;
        text-align: center;
        z-index: 5;
      }
      .welcome-wrapper h2 {
        font-size: 18px;
        margin-bottom: 16px;
        font-weight: 600;
      }
      .welcome-wrapper p {
        font-size: 14px;
        color: #b8b8b8;
        margin-bottom: 24px;
      }
      .links {
        display: flex;
        flex-direction: column;
        gap: 12px;
      }
      .links .button {
        display: block;
        text-decoration: none;
        text-align: center;
      }
    </style>
  </head>
  <body>
    <div class="overlay"></div>

    <h1 class="logo">ROBLOX TRACKERS</h1>

    <div class="welcome-wrapper">
      <h2>Welcome to Roblox Trackers!</h2>
      <p>Silakan login atau daftar untuk mulai tracking Robux Anda.</p>

      <div class="links">
        <a href="login.php" class="button">Log In</a>
        <a href="register.php" class="button secondary-button">Sign Up</a>
      </div>
    </div>
    <script src="assets/js/animations.js"></script>
  </body>
</html>
