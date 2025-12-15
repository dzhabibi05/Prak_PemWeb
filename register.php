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
    <title>Roblox Trackers - Sign Up</title>
    <link rel="stylesheet" href="assets/css/signup.css" />
  </head>
  <body>
    <div class="overlay"></div>

    <a href="login.php" class="top-button">Log In</a>

    <h1 class="logo">ROBLOX TRACKERS</h1>

    <div class="form-wrapper">
      <h2>SIGN UP AND BUILD YOUR OWN CHARACTER!</h2>

      <?php if (isset($_GET['error'])): ?>
        <p style="color: #ff6b6b; text-align: center; font-weight: bold; margin-bottom: 15px;">
          <?php
            $err = $_GET['error'];
            if ($err === 'empty') echo "Harap isi semua field!";
            elseif ($err === 'username_empty') echo "Username tidak boleh kosong!";
            elseif ($err === 'password_empty') echo "Password tidak boleh kosong!";
            elseif ($err === 'password_length') echo "Password minimal 8 karakter!";
            elseif ($err === 'username_taken') echo "Username sudah digunakan!";
            else echo "Terjadi kesalahan!";
          ?>
        </p>
      <?php endif; ?>

      <form action="php/register_process.php" method="POST">
        <label class="field-label">Birthday</label>
        <div class="select-row">
          <select class="input-box" name="month">
            <option value="">Month</option>
            <option value="1">January</option>
            <option value="2">February</option>
            <option value="3">March</option>
            <option value="4">April</option>
            <option value="5">May</option>
            <option value="6">June</option>
            <option value="7">July</option>
            <option value="8">August</option>
            <option value="9">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
          </select>
          <select class="input-box" name="day">
            <option value="">Day</option>
            <?php for ($i = 1; $i <= 31; $i++): ?>
              <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor; ?>
          </select>
          <select class="input-box" name="year">
            <option value="">Year</option>
            <?php for ($y = 2025; $y >= 1990; $y--): ?>
              <option value="<?= $y ?>"><?= $y ?></option>
            <?php endfor; ?>
          </select>
        </div>

        <label class="field-label">Username</label>
        <input
          type="text"
          name="username"
          class="input-box"
          placeholder="Don't use your real name"
          required
        />

        <label class="field-label">Password</label>
        <input
          type="password"
          name="password"
          class="input-box"
          placeholder="At least 8 characters"
          minlength="8"
          required
        />

        <label class="field-label">Gender (optional)</label>
        <div class="gender-row">
          <button type="button" class="gender-button male" onclick="selectGender('male', this)">
            <svg
              class="gender-icon"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <circle
                cx="10"
                cy="14"
                r="5"
                stroke="currentColor"
                stroke-width="2"
              />
              <path
                d="M14 10L20 4M20 4H16M20 4V8"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>
          </button>
          <button type="button" class="gender-button female" onclick="selectGender('female', this)">
            <svg
              class="gender-icon"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <circle
                cx="12"
                cy="9"
                r="5"
                stroke="currentColor"
                stroke-width="2"
              />
              <path
                d="M12 14V22M9 19H15"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
              />
            </svg>
          </button>
          <input type="hidden" name="gender" id="genderInput" value="">
        </div>

        <small class="terms-text">
          By clicking Sign Up, you are agreeing to the
          <a href="#">Terms of Use</a> including the arbitration clause and you
          are acknowledging the <a href="#">Privacy Policy</a>
        </small>

        <button type="submit" class="button">Sign Up</button>
      </form>
    </div>

    <script>
      function selectGender(gender, btn) {
        document.getElementById('genderInput').value = gender;
        document.querySelectorAll('.gender-button').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
      }
    </script>
    <script src="assets/js/animations.js"></script>
  </body>
</html>