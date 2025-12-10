<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Login — Roblox Project</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <main class="container">
    <h2>Login</h2>

    <?php if (isset($_GET['error'])): ?>
      <div style="color: red; margin-bottom: 15px; text-align: center; font-weight: bold;">
        <?php 
          if ($_GET['error'] == 'empty') {
            echo "⚠ Harap isi username dan password!";
          } elseif ($_GET['error'] == 'invalid') {
            echo "❌ Username atau password salah!";
          }
        ?>
      </div>
    <?php endif; ?>
    <form class="form" action="php/login_process.php" method="POST">
      <label>
        Username
        <input type="text" name="username" required />
      </label>

      <label>
        Password
        <input type="password" name="password" required />
      </label>

      <div class="actions">
        <button type="submit" class="btn">Login</button>
        <a class="btn btn-outline" href="register.html">Register</a>
      </div>
    </form>

    <p class="small"><a href="index.html">Kembali ke Home</a></p>
  </main>
</body>
</html>