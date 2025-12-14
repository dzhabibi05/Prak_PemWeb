<html>
<head>
  <title>Roblox Trackers - Sign Up</title>
  <link rel="stylesheet" href="assets/css/signup.css" />
</head>
<body>
  <div class="overlay"></div>

  <a href="login.php" class="top-button">Log In</a>

  <h1 class="logo">ROBLOX TRACKERS</h1>

  <div class="form-wrapper">
    <h2>SIGN UP AND BUILD YOUR OWN CHARACTER!</h2>

    <form action="php/register_process.php" method="POST">

      <label class="field-label">Username</label>
      <input
        type="text"
        name="username"
        class="input-box"
        placeholder="Don't use your real name"
        required
      />

      <!-- NOTE ERROR PASSWORD -->
      <?php if (isset($_GET['error']) && $_GET['error'] === 'password'): ?>
        <div class="error-note">
          Password harus minimal 8 karakter
        </div>
      <?php endif; ?>

      <label class="field-label">Password</label>
      <input
        type="password"
        name="password"
        class="input-box"
        placeholder="At least 8 characters"
        minlength="8"
        required
      />

      <button type="submit" class="button">Sign Up</button>
    </form>

    <div class="bottom-links">
      Already have an account?
      <a class="signup-link" href="login.php">Log in</a>
    </div>
  </div>
</body>
</html>