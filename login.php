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
  <title>Roblox Trackers - Login</title>
  <link rel="stylesheet" href="assets/css/login.css" />
</head>
<body>
  <div class="overlay"></div>

  <a href="register.php" class="top-button">Sign Up</a>

  <h1 class="logo">ROBLOX TRACKERS</h1>

  <div class="form-wrapper">
    <h2>Log In To Roblox Voters</h2>

    <?php if (isset($_GET['error'])): ?>
      <p style="color:red; text-align:center; font-weight:bold;">
        <?php
          if ($_GET['error'] === 'empty') echo "Harap isi semua field!";
          if ($_GET['error'] === 'invalid') echo "Username atau password salah!";
        ?>
      </p>
    <?php endif; ?>

    <form action="php/login_process.php" method="POST">
      <input
        type="text"
        name="username"
        class="input-box"
        placeholder="Username"
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

    <div class="bottom-links">
      Don't have an account?
      <a class="signup-link" href="register.php">Sign up</a>
    </div>
  </div>
</body>
</html>
