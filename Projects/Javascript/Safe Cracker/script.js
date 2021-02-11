const gameArea = document.querySelector(".game");
const button = document.querySelector("button");
const message = document.querySelector(".message");
let attempts = 0;
let gameContainer = document.querySelector(".container");

let gamePlay = false;
gameContainer.style.background =
  "url('img/vault_closed.jpg') no-repeat center center/ cover";

button.addEventListener("click", function () {
  if (!gamePlay) {
    gameContainer.style.background =
      "url('img/vault_closed.jpg') no-repeat center center/ cover";
    attempts = 0;
    gamePlay = true;
    gameArea.innerHTML = "";
    maker();
    button.innerHTML = "Check Combo";
    message.innerHTML = "Guess the combination";
  } else {
    let winCondition = 0;
    attempts++;
    message.innerHTML = `Number of guesses ${attempts}`;
    const numbers = document.querySelectorAll(".combination");

    numbers.forEach((number) => {
      number.style.color = "white";
      if (number.value == number.correct) {
        winCondition++;

        number.style.backgroundColor = "green";
      } else {
        number.style.backgroundColor =
          number.value < number.correct ? "blue" : "red";
      }
    });
    if (winCondition == numbers.length) {
      endGame();
    }
  }
});

function maker() {
  for (let x = 0; x < 4; x++) {
    const el = document.createElement("input");
    el.setAttribute("type", "number");
    el.max = 9;
    el.min = 0;
    el.order = x;
    el.size = 1;
    el.correct = Math.floor(Math.random() * 10);
    el.value = 0;
    el.style.width = "54px";
    el.classList.add("combination");
    gameArea.appendChild(el);
  }
}

function endGame() {
  message.innerHTML = `You solved the combination in  ${attempts} attempts`;
  gamePlay = false;
  gameContainer.style.background =
    "url('img/vault_opened.jpg') no-repeat center center/ cover";
  button.innerHTML = "Restart Game";
}
