let log = console.log;
const score = document.querySelector(".score");
const startScreen = document.querySelector(".startScreen");
const gameArea = document.querySelector(".gameArea");
let road = gameArea.getBoundingClientRect();
log(road.top);

let player = {
  speed: 5,
  score: 0,
  start: false,
};
let keys = {
  ArrowUp: false,
  ArrowDown: false,
  ArrowRight: false,
  ArrowLeft: false,
};
document.addEventListener("keydown", start);
document.addEventListener("keydown", pressOn);
document.addEventListener("keyup", pressOff);

function moveLines() {
  let lines = document.querySelectorAll(".line");
  lines.forEach((line) => {
    if (line.y >= 1500) {
      line.y -= 1500;
    }
    line.y += player.speed;
    line.style.top = line.y + "px";
  });
}

function moveEnemy(car) {
  let enemies = document.querySelectorAll(".enemy");
  enemies.forEach((enemy) => {
    if (collisionDetection(car, enemy)) {
      log("HIT");
      endGame();
    }
    if (enemy.y > 1500) {
      enemy.y = -730;
      enemy.style.left = Math.floor(Math.random() * 220) + "px";
      enemy.style.backgroundColor = randomColor();
    }
    enemy.y += player.speed;
    enemy.style.top = enemy.y + "px";
  });
}

function collisionDetection(a, b) {
  let aRect = a.getBoundingClientRect();
  let bRect = b.getBoundingClientRect();

  return !(
    aRect.top > bRect.bottom ||
    aRect.right < bRect.left ||
    aRect.bottom < bRect.top ||
    aRect.left > bRect.right
  );
}

function playGame() {
  let car = document.querySelector(".car");
  moveLines();
  moveEnemy(car);
  if (player.start) {
    if (keys.ArrowUp && player.y > road.top) {
      player.y -= player.speed;
    }
    if (keys.ArrowDown && player.y < road.bottom - 180) {
      player.y += player.speed;
    }
    if (keys.ArrowLeft && player.x > 0) {
      player.x -= player.speed;
    }
    if (keys.ArrowRight && player.x < road.width - 50) {
      player.x += player.speed;
    }
    car.style.left = player.x + "px";
    car.style.top = player.y + "px";
    car.style.backgroundColor = "white";
    window.requestAnimationFrame(playGame);
    player.score++;
    score.innerText = "Score: " + player.score;
  }
}

function endGame() {
  player.start = false;
  score.innerHTML = "Game Over <br> Score was: " + player.score;
  startScreen.classList.remove("hide");
}

function pressOn(e) {
  e.preventDefault();
  keys[e.key] = true;
}

function pressOff(e) {
  e.preventDefault();
  keys[e.key] = false;
}

function start(event) {
  if (event.keyCode === 32 && player.start === false) {
    window.requestAnimationFrame(playGame);

    startScreen.classList.add("hide");
    gameArea.innerHTML = "";
    player.start = true;
    player.score = 0;

    for (let i = 0; i < 10; i++) {
      let line = document.createElement("div");
      line.classList.add("line");
      line.y = i * 150;
      line.style.top = i * 150 + "px";
      gameArea.appendChild(line);
    }

    let car = document.createElement("div");
    car.setAttribute("class", "car");
    gameArea.appendChild(car);
    player.x = car.offsetLeft;
    player.y = car.offsetTop;

    for (let i = 0; i < 3; i++) {
      let enemy = document.createElement("div");
      enemy.classList.add("enemy");
      enemy.innerHTML = "<br>" + (i + 1);
      enemy.y = (i + 1) * 530 + -1;
      enemy.style.top = enemy.y + "px";

      enemy.style.left = Math.floor(Math.random() * 270);
      enemy.style.backgroundColor = randomColor();
      gameArea.appendChild(enemy);
    }
  }
}

function randomColor() {
  function c() {
    let hex = Math.floor(Math.random() * 256).toString(16);
    return ("0" + String(hex)).substr(-2);
  }

  return "#" + c() + c() + c();
}
