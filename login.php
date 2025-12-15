<?php
session_start();
if (isset($_SESSION['user_id'])) {
  header("Location: home.php");
  exit;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Roblox Trackers - Login</title>
    <link rel="stylesheet" href="assets/css/login.css" />
  </head>
  <body>
    <div class="overlay"></div>

    <a href="register.php" class="top-button">Sign Up</a>

    <h1 class="logo">ROBLOX TRACKERS</h1>

    <div class="form-wrapper">
      <h2>Log In To Roblox Voters</h2>

      <?php if (isset($_GET['register']) && $_GET['register'] === 'success'): ?>
        <p style="color: #4ade80; text-align: center; font-weight: bold; margin-bottom: 15px;">
          Registrasi berhasil! Silakan login.
        </p>
      <?php endif; ?>

      <?php if (isset($_GET['error'])): ?>
        <p style="color: #ff6b6b; text-align: center; font-weight: bold; margin-bottom: 15px;">
          <?php
            if ($_GET['error'] === 'empty') echo "Harap isi semua field!";
            elseif ($_GET['error'] === 'invalid') echo "Username atau password salah!";
            else echo "Terjadi kesalahan!";
          ?>
        </p>
      <?php endif; ?>

      <form action="php/login_process.php" method="POST">
        <input
          type="text"
          name="username"
          class="input-box"
          placeholder="Username/Email/Mobile Number"
          required
        />
        <input 
          type="password" 
          name="password"
          class="input-box" 
          placeholder="Password" 
          required
        />

        <button type="submit" class="button">Log In</button>
      </form>

      <a class="small-link" href="#">Forgot Password or Username?</a>

      <button class="button secondary-button">Send Me a One Time Code</button>
      <button class="button secondary-button">Use Another Device</button>

      <div class="bottom-links">
        Don't have an account?
        <a class="signup-link" href="register.php">Sign up</a>
      </div>
    </div>
    <script src="assets/js/animations.js"></script>
  </body>
</html>
