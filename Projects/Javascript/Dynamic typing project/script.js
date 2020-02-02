const button = document.querySelector("button");
let typing = document.getElementById("typing");
let counter = 0;
let sentence;
let start;

const sentences = [
  "He didn't heed the warning and it had turned out surprisingly well.",
  "When I was little I had a car door slammed shut on my hand and I still remember it quite vividly.",
  "Flesh-colored yoga pants were far worse than even he feared.",
  "Don't step on the broken glass.",
  "He ran out of money, so he had to stop playing poker.",
  "Random words in front of other random words create a random sentence.",
  "All she wanted was the answer, but she had no idea how much she would hate it. It must be five o'clock somewhere.",
  "Joe made the sugar cookies; Susan decorated them."
];

button.addEventListener("click", function() {
  if (this.innerText === "Start") {
    typing.disabled = false;
    this.innerText = "Done";
    //pick random sentence
    sentence = pickSentence(sentences);
    // display sentence on the page
    displaySentence(sentence);
    // start time
    start = Date.now();
  } else if (this.innerText === "Done") {
    if (typing.value == "") {
      alert("You typed 0 words");
    } else {
      // finish the game
      let end = Date.now();
      gameEnd(sentence, start, end);
      // end time

      typing.disabled = true;
      typing.value = "";
      button.innerText = "Start";
    }
  }
});

function pickSentence(sentences) {
  let sentence = Math.floor(Math.random() * sentences.length);
  return sentences[sentence];
}

function displaySentence(phrase) {
  if (document.body.children.length > 3) {
    document.body.children[0].remove();
  }
  let el = document.createElement("p");
  let textNode = document.createTextNode(phrase);
  el.appendChild(textNode);
  document.body.insertBefore(el, document.body.children[0]);
  el.setAttribute(
    "style",
    "width: 100%; margin: auto; line-height: 1.4; font-size: 1.3rem;  text-align: center; border: 1px solid black; padding: 1.25rem; background-color: #65b8d6; color: #f3f3f3;"
  );
}

let calculateTime = function(words, start, end) {
  return Math.round((words * 60) / Math.floor((end - start) / 1000));
};

function gameEnd(sentence, start, end) {
  let wrong = 0;
  let words = sentence.split(" ").length;
  let splitInput = typing.value.split(" ");
  let splitSentence = sentence.split(" ");
  for (let i = 0; i < splitSentence.length; i++) {
    if (splitSentence[i] !== splitInput[i]) {
      wrong++;
    }
  }
  let correct = words - wrong;
  let el = (document.querySelector(
    "p"
  ).innerHTML = `Your typing speed is <span style="color: orange; font-size: 1.7rem">${calculateTime(
    correct,
    start,
    end
  )}</span> words per minute. <br>
  <span style="color: red; font-size: 1.6rem">${correct}</span> correct out of <span style="color: red; font-size: 1.6rem">${words}</span> words`);
}
