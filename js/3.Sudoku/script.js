"use strict";

const levelContainer = document.querySelector(".sudoku-grid");
const arrowRight = document.querySelector(".arrow-right");
const arrowLeft = document.querySelector(".arrow-left");
const levelIndicator = document.querySelector(".level-indicator");
const levelNumber = document.querySelector(".level-number");
const levelDots = document.querySelector(".level-count");

class Level {
  levelNumber;
  cellInfo = Array(81);
  Completed = false;

  constructor(levelNumber, preFilled) {
    this.levelNumber = levelNumber;
    this._initiateCells(preFilled);
  }

  _initiateCells(preFilled) {
    for (let row = 1, index = 0; row <= 9; row++) {
      for (let column = 1; column <= 9; column++) {
        this.cellInfo[index] = {
          value: "",
          preFilled: false,
          row: row,
          column: column,
          quadrant: +(Math.ceil(row / 3) + "" + Math.ceil(column / 3)),
        };
        index++;
      }
    }
    preFilled.forEach((element) => {
      this.cellInfo[element[0]].value = element[1];
      this.cellInfo[element[0]].preFilled = true;
    });
  }
}

class App {
  levels = [];
  levelCount;
  currentLevel = 0;

  constructor(levels) {
    levels.forEach((element, index) => {
      const level = new Level(index, element);
      this.levels.push(level);
    });
    this.levelCount = levels.length - 1;
    this.populateFields();
    this.populateDots();
    document.querySelector(
      ".levelDot-0"
    ).innerHTML = `<i class="far fa-circle"></i>`;
    this.displayLevel(this.levels[this.currentLevel]);
    arrowRight.addEventListener("click", this.nextLevel.bind(this));
    arrowLeft.addEventListener("click", this.previousLevel.bind(this));
    levelContainer.addEventListener("input", this.manageInput.bind(this));
  }

  populateFields() {
    let html = "";
    for (let i = 0; i < 81; i++) {
      html += `<input
      type="number"
      class="inputfield"
      id="${i}" 
      />`;
    }
    levelContainer.insertAdjacentHTML("beforeend", html);
  }

  populateDots() {
    let html = "";
    for (let i = 0; i <= this.levelCount; i++) {
      html += `<div class="level-dot levelDot-${i}"><i class="fas fa-circle"></i></i></div>`;
    }
    levelDots.insertAdjacentHTML("beforeend", html);
  }

  displayLevel(level) {
    // Fills cells with current level data
    level.cellInfo.forEach((element, index) => {
      const inputfield = document.getElementById(`${index}`);
      inputfield.value = element.value;
      if (element.preFilled) {
        inputfield.classList.add("preFilled");
        inputfield.setAttribute("readonly", "");
      }
    });
    // Adds text "- Completed" to level header if level is completed
    if (this.levels[this.currentLevel].Completed) {
      levelIndicator.insertAdjacentHTML(
        "beforeend",
        "<span class='completed-indicator'> - Completed</span>"
      );
    }
  }
  clearLevel() {
    // Clears inputfields
    const elements = document.querySelectorAll(".inputfield");
    elements.forEach((el) => {
      el.value = "";
      if (el.classList.contains("preFilled")) {
        el.classList.remove("preFilled");
        el.removeAttribute("readonly");
      }
    });
    // Removes text "- Completed" from header
    const completed = document.querySelector(".completed-indicator");
    if (completed) {
      levelIndicator.removeChild(completed);
    }
  }

  // What happens when right arrow is pressed
  nextLevel() {
    this.clearLevel();
    if (this.currentLevel + 1 > this.levelCount) return;
    document.querySelector(
      `.levelDot-${this.currentLevel}`
    ).innerHTML = `<i class="fas fa-circle"></i></i>`;
    this.currentLevel++;
    document.querySelector(
      `.levelDot-${this.currentLevel}`
    ).innerHTML = `<i class="far fa-circle"></i>`;
    levelNumber.textContent = this.currentLevel + 1;
    this.displayLevel(this.levels[this.currentLevel]);
    // Displays or hides navigation arrows
    this.checkArrows();
  }

  // What happens when left arrow is pressed
  previousLevel() {
    this.clearLevel();
    if (this.currentLevel - 1 < 0) return;
    document.querySelector(
      `.levelDot-${this.currentLevel}`
    ).innerHTML = `<i class="fas fa-circle"></i></i>`;
    this.currentLevel--;
    document.querySelector(
      `.levelDot-${this.currentLevel}`
    ).innerHTML = `<i class="far fa-circle"></i>`;
    levelNumber.textContent = this.currentLevel + 1;
    this.displayLevel(this.levels[this.currentLevel]);
    // Displays or hides navigation arrows
    this.checkArrows();
  }

  checkArrows() {
    if (this.currentLevel == this.levelCount) {
      arrowRight.classList.add("hide");
    } else if (this.currentLevel == 0) {
      arrowLeft.classList.add("hide");
    } else {
      arrowRight.classList.remove("hide");
      arrowLeft.classList.remove("hide");
    }
  }

  manageInput(e) {
    const inputfield = e.target;
    if (
      !inputfield ||
      inputfield.classList.contains("preFilled") ||
      !inputfield.classList.contains("inputfield")
    ) {
      return;
    }
    // inputfield.value = +String(inputfield.value).replace(/0/g, undefined);
    if (inputfield.value < 1) {
      inputfield.value = "";
    }
    if (inputfield.value.length > 1) {
      inputfield.value =
        inputfield.value.slice(-1) != 0 ? inputfield.value.slice(-1) : "";
    }
    this.levels[this.currentLevel].cellInfo[inputfield.id].value =
      +inputfield.value;
    // TO DO
    // Update display when level is completed
    if (
      this.checkIfSolved() &&
      !this.levels[this.currentLevel].Completed == true
    ) {
      this.levels[this.currentLevel].Completed = true;
      this.clearLevel();
      this.displayLevel(this.levels[this.currentLevel]);
    }
  }

  checkIfSolved() {
    // Check rows
    if (!this._checkArrays("row")) {
      return;
    }
    console.log("yes");
    // // Check columns
    if (!this._checkArrays("column")) {
      return;
    }
    // Check quadrants
    for (let i = 1; i <= 3; i++) {
      for (let y = 1; y <= 3; y++) {
        const arrayToCheck = this.levels[this.currentLevel].cellInfo
          .filter((arr) => arr.quadrant == +(i + "" + y) && arr.value)
          .map((arr) => arr.value);

        if (
          arrayToCheck.length != 9 ||
          arrayToCheck.length !== new Set(arrayToCheck).size
        ) {
          return false;
        }
      }
    }
    // Return true if level completed
    return true;
  }
  _checkArrays(groupName) {
    for (let i = 1; i <= 9; i++) {
      const arrayToCheck = this.levels[this.currentLevel].cellInfo
        .filter((arr) => arr[groupName] == i && arr.value)
        .map((arr) => arr.value);
      console.log(arrayToCheck);
      if (
        arrayToCheck.length != 9 ||
        arrayToCheck.length !== new Set(arrayToCheck).size
      ) {
        return false;
      }
    }
    return true;
  }
}

const levels = [
  [
    [0, 1],
    [1, 6],
    [2, 8],
    [3, 4],
    [4, 5],
    [5, 7],
    [6, 9],
    [7, 3],
    [8, 2],
    [9, 5],
    [10, 7],
    [11, 2],
    [12, 3],
    [13, 9],
    [14, 1],
    [15, 4],
    [16, 6],
    [17, 8],
    [18, 9],
    [19, 3],
    [20, 4],
    [21, 6],
    [22, 2],
    [23, 8],
    [24, 5],
    [25, 1],
    [26, 7],
    [27, 8],
    [28, 2],
    [29, 9],
    [30, 7],
    [31, 4],
    [32, 3],
    [33, 1],
    [34, 5],
    [35, 6],
    [36, 6],
    [37, 5],
    [38, 1],
    [39, 2],
    [40, 8],
    [41, 9],
    [42, 3],
    [43, 7],
    [44, 4],
    [45, 7],
    [46, 4],
    [47, 3],
    [48, 5],
    [49, 1],
    [50, 6],
    [51, 2],
    [52, 8],
    [53, 9],
    [54, 3],
    [55, 9],
    [56, 5],
    [57, 8],
    [58, 7],
    [59, 2],
    [60, 6],
    [61, 4],
    [62, 1],
    [63, 4],
    [64, 1],
    [65, 7],
    [66, 9],
    [67, 6],
    [68, 5],
    [69, 8],
    [70, 2],
    [71, 3],
    [72, 2],
    [73, 8],
    [74, 6],
    [75, 1],
    [76, 3],
    [77, 4],
    [78, 7],
    [79, 9],
  ],
  [
    [80, 9],
    [0, 1],
    [9, 2],
  ],
  [
    [2, 2],
    [3, 3],
    [4, 4],
  ],
  [
    [2, 2],
    [50, 5],
  ],
];
const app = new App(levels);
