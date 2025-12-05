// game.js - movement dasar
const player = document.getElementById("player");
let x = 50;
let y = 300;
const speed = 6;

const bounds = document.getElementById("gameArea").getBoundingClientRect();

document.addEventListener("keydown", function(e) {
  const key = e.key.toLowerCase();
  if (key === "arrowright" || key === "d") x += speed;
  if (key === "arrowleft" || key === "a")  x -= speed;
  if (key === "arrowup" || key === "w")    y -= speed;
  if (key === "arrowdown" || key === "s")  y += speed;

  // clamp ke area
  if (x < 0) x = 0;
  if (y < 0) y = 0;
  if (x > bounds.width - player.offsetWidth) x = bounds.width - player.offsetWidth;
  if (y > bounds.height - player.offsetHeight) y = bounds.height - player.offsetHeight;

  player.style.left = x + "px";
  player.style.top = y + "px";
});
