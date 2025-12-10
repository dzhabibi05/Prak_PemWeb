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
  <title>Play - Roblox Obby 2D</title>
  <style>
    body {
      margin: 0;
      background: linear-gradient(#87ceeb, #e0f7ff);
      font-family: Arial, sans-serif;
      text-align: center;
    }

    h1 { margin: 10px 0; }

    #hud {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-bottom: 10px;
      font-weight: bold;
      color: #333;
    }

    canvas {
      background: #dff9fb;
      border: 4px solid #222;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    /* Styling tombol navigasi baru */
    .nav-btn {
      margin-top: 15px;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      font-weight: bold;
      margin-left: 5px;
      margin-right: 5px;
      transition: transform 0.1s;
    }
    
    .btn-home { background: #e67e22; color: white; border-bottom: 4px solid #d35400; }
    .btn-rank { background: #f1c40f; color: #333; border-bottom: 4px solid #f39c12; }

    .nav-btn:active {
      transform: translateY(2px);
      border-bottom-width: 2px;
    }

    .popup {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.6);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 999;
    }

    .popup-box {
      background: white;
      padding: 25px;
      border-radius: 12px;
      width: 300px;
      text-align: center;
      animation: zoom 0.3s ease;
      border: 4px solid #333;
    }

    .popup-box button {
      margin: 8px;
      padding: 10px 18px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      background: #3498db;
      color: white;
      font-weight: bold;
    }

    .popup-box button:hover { opacity: 0.8; }

    @keyframes zoom {
      from { transform: scale(0.6); opacity: 0; }
      to { transform: scale(1); opacity: 1; }
    }
  </style>
</head>
<body>

<h1>Roblox Obby 2D</h1>

<div id="hud">
  <div>⏱ Time: <span id="time">0</span>s</div>
  <div>🏁 Level: <span id="level">1</span></div>
</div>

<canvas id="game" width="800" height="400"></canvas>
<br>

<button class="nav-btn btn-home" onclick="goHome()">🏠 Home</button>
<button class="nav-btn btn-rank" onclick="goToLeaderboard()">🏆 Leaderboard</button>

<script>
// Variabel untuk menyimpan ID animasi
let animationId = null;

const canvas = document.getElementById("game");
const ctx = canvas.getContext("2d");

const gravity = 0.6;
const keys = {};
let time = 0;
let timerInterval;

const player = {
  x: 50, y: 300, w: 30, h: 30,
  vx: 0, vy: 0, speed: 2, jump: 8, onGround: false
};

const levels = [
  {
    platforms: [
      { x: 0, y: 370, w: 800, h: 30 },
      { x: 200, y: 320, w: 120, h: 20 },
      { x: 380, y: 280, w: 120, h: 20 },
      { x: 560, y: 240, w: 120, h: 20 }
    ],
    lava: { x: 0, y: 390, w: 800, h: 10 },
    finish: { x: 720, y: 200, w: 40, h: 40 }
  },
  {
    platforms: [
      { x: 0, y: 370, w: 800, h: 30 },
      { x: 150, y: 300, w: 100, h: 20 },
      { x: 300, y: 240, w: 100, h: 20 },
      { x: 450, y: 180, w: 100, h: 20 },
      { x: 600, y: 120, w: 100, h: 20 }
    ],
    lava: { x: 0, y: 390, w: 800, h: 10 },
    finish: { x: 720, y: 80, w: 40, h: 40 }
  },
  {
    platforms: [
      { x: 0, y: 370, w: 800, h: 30 },
      { x: 200, y: 320, w: 120, h: 20 },
      { 
        x: 380, y: 280, w: 120, h: 20,
        moving: true, speed: 2, minX: 300, maxX: 600
      },
      { x: 560, y: 240, w: 120, h: 20 }
    ],
    lava: { x: 0, y: 390, w: 800, h: 10 },
    finish: { x: 720, y: 200, w: 40, h: 40 }
  }
];

let currentLevel = 0;

function resetPlayer() {
  player.x = 50; player.y = 300; player.vx = 0; player.vy = 0;
}

function resetGame() {
  if (animationId) cancelAnimationFrame(animationId);
  currentLevel = 0;
  resetPlayer();
  time = 0;
  startTimer();
  update();
}

function startTimer() {
  clearInterval(timerInterval);
  timerInterval = setInterval(() => {
    time++;
    document.getElementById("time").textContent = time;
  }, 1000);
}

function rectCollision(a, b) {
  return (a.x < b.x + b.w && a.x + a.w > b.x && a.y < b.y + b.h && a.y + a.h > b.y);
}

function update() {
  player.vx = 0;
  if (keys["a"]) player.vx = -player.speed;
  if (keys["d"]) player.vx = player.speed;

  player.x += player.vx;
  player.vy += gravity;
  player.y += player.vy;
  player.onGround = false;

  const level = levels[currentLevel];

  level.platforms.forEach(p => {
    if (p.moving) {
      p.x += p.speed;
      if (p.x <= p.minX || p.x + p.w >= p.maxX) p.speed *= -1;
    }
  });

  level.platforms.forEach(p => {
    if (rectCollision(player, p)) {
      if (player.vy > 0) {
        player.y = p.y - player.h;
        player.vy = 0;
        player.onGround = true;
        if (p.moving) player.x += p.speed;
      }
    }
  });

  if (rectCollision(player, level.lava)) resetPlayer();

  if (rectCollision(player, level.finish)) {
    currentLevel++;
    if (currentLevel >= levels.length) {
      showWinPopup();
      clearInterval(timerInterval);
      return; 
    } else {
      resetPlayer();
    }
  }

  draw();
  document.getElementById("level").textContent = currentLevel + 1;
  animationId = requestAnimationFrame(update);
}

function draw() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  if (!levels[currentLevel]) return;
  const level = levels[currentLevel];

  ctx.fillStyle = "#2ecc71";
  level.platforms.forEach(p => ctx.fillRect(p.x, p.y, p.w, p.h));

  ctx.fillStyle = "red";
  ctx.fillRect(level.lava.x, level.lava.y, level.lava.w, level.lava.h);

  ctx.fillStyle = "gold";
  ctx.fillRect(level.finish.x, level.finish.y, level.finish.w, level.finish.h);

  ctx.fillStyle = "#3498db";
  ctx.fillRect(player.x, player.y, player.w, player.h);
}

function saveScore(score) {
  fetch("php/save_score.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "score=" + score
  });
}

window.addEventListener("keydown", e => {
  keys[e.key.toLowerCase()] = true;
  if (e.key === " " && player.onGround) player.vy = -player.jump;
});

window.addEventListener("keyup", e => {
  keys[e.key.toLowerCase()] = false;
});

startTimer();
update();

// FUNGSI LOAD LEADERBOARD DIHAPUS DARI SINI

function showWinPopup() {
  document.getElementById("finalTime").textContent = time;
  document.getElementById("winPopup").style.display = "flex";
  saveScore(time);
}

function restartFromPopup() {
  document.getElementById("winPopup").style.display = "none";
  resetGame();
}

function goHome() { window.location.href = "home.php"; }
function goToLeaderboard() { window.location.href = "php/leaderboard.php"; }
</script>

<div id="winPopup" class="popup">
  <div class="popup-box">
    <h2>🏆 YOU WIN!</h2>
    <p>Waktu terbaik kamu: <span id="finalTime"></span> detik</p>
    <button onclick="restartFromPopup()">🔄 Ulangi</button>
    <button onclick="goToLeaderboard()">🏆 Leaderboard</button>
    <button onclick="goHome()">🏠 Home</button>
  </div>
</div>