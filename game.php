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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Play - Roblox Obby 2D</title>
  <link rel="stylesheet" href="assets/css/game.css">
</head>
<body>

<h1>Roblox Obby 2D</h1>

<div id="hud">
  <div>⏱ Time: <span id="time">0</span>s</div>
  <div>🏁 Level: <span id="level">1</span></div>
</div>

<canvas id="game" width="800" height="400"></canvas>
<br>
<div id="controls-info">
    Kontrol: 
    <span class="key-label">A</span> Kiri 
    | <span class="key-label">D</span> Kanan 
    | <span class="key-label key-space">Space</span> Lompat
</div>
<button class="nav-btn btn-home" onclick="goHome()">🏠 Home</button>
<button class="nav-btn btn-rank" onclick="goToLeaderboard()">🏆 Leaderboard</button>

<script>
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
  },
  
{
  platforms: [
    { x: 0, y: 370, w: 800, h: 30 },
    { x: 100, y: 320, w: 100, h: 20 },
    { 
      x: 250, y: 280, w: 150, h: 20, 
      moving: true, speed: 1, minX: 200, maxX: 450
    },
    { x: 500, y: 220, w: 50, h: 20 }, 
    { 
      x: 600, y: 180, w: 100, h: 20, 
      moving: true, speed: 3, minX: 550, maxX: 750
    }
  ],
  lava: { x: 0, y: 390, w: 800, h: 10 },
  finish: { x: 740, y: 140, w: 40, h: 40 }
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

    if (player.x < 0) {
        player.x = 0;
    }
    if (player.x + player.w > canvas.width) {
        player.x = canvas.width - player.w;
    }

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

    
    ctx.fillStyle = "#2ecc71"; // Platform
    level.platforms.forEach(p => ctx.fillRect(p.x, p.y, p.w, p.h));

    ctx.fillStyle = "red"; // Lava
    ctx.fillRect(level.lava.x, level.lava.y, level.lava.w, level.lava.h);

    ctx.fillStyle = "gold"; // Finish Block
    ctx.fillRect(level.finish.x, level.finish.y, level.finish.w, level.finish.h);

    
    const px = player.x;
    const py = player.y;
    const pw = player.w;
    const ph = player.h;
    
    const torsoH = ph * 0.5; 
    const legH = ph * 0.5;   
    const headSize = pw * 1.0; 
    
    
    const skinColor = "#E6C9A3";
    const headX = px; 
    const headY = py - headSize; 

    ctx.fillStyle = skinColor; 
    ctx.fillRect(headX, headY, headSize, headSize);

    ctx.fillStyle = "black";
    ctx.fillRect(headX + 8, headY + 10, 4, 4);
    ctx.fillRect(headX + headSize - 12, headY + 10, 4, 4);
    ctx.beginPath();
    ctx.arc(headX + pw / 2, headY + 20, 5, 0, Math.PI, false);
    ctx.lineWidth = 2;
    ctx.stroke();
    
    ctx.fillStyle = "black";
    ctx.fillRect(headX, headY - 5, headSize, 10);
    
    const torsoY = py;
    
    ctx.fillStyle = "black"; 
    ctx.fillRect(px, torsoY, pw, torsoH);

    ctx.fillStyle = "white";
    ctx.font = "bold 10px Inter, sans-serif";
    ctx.textAlign = "center";
    ctx.fillText("RT", px + pw / 2, torsoY + torsoH / 2 + 3);
    
    const armW = pw * 0.3;
    const armH = torsoH * 0.8;
    
    ctx.fillStyle = skinColor;
    ctx.fillRect(px - armW, torsoY, armW, armH);
    ctx.fillRect(px + pw, torsoY, armW, armH);
    
    const pantsColor = "#192A56"; 
    const legY = py + torsoH;
    
    ctx.fillStyle = pantsColor; 
    
    const leftLegX = px;
    const rightLegX = px + pw / 2;
    const legW_half = pw / 2;
    
    ctx.fillRect(leftLegX, legY, legW_half, legH); 
    ctx.fillRect(rightLegX, legY, legW_half, legH); 
    
    const shoeH = 5;
    ctx.fillStyle = "black";
    
    ctx.fillRect(leftLegX, legY + legH - shoeH, legW_half, shoeH);
    ctx.fillStyle = "white";
    ctx.fillRect(leftLegX + 1, legY + legH - shoeH + 1, legW_half - 2, 1);
    
    ctx.fillStyle = "black";
    ctx.fillRect(rightLegX, legY + legH - shoeH, legW_half, shoeH);
    ctx.fillStyle = "white";
    ctx.fillRect(rightLegX + 1, legY + legH - shoeH + 1, legW_half - 2, 1);
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