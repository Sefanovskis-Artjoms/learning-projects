class View {
  _gridContainer = document.querySelector(".main-grid");

  _optionsContainer = document.querySelector(".options-container");
  _allChecks = document.querySelectorAll(".options-checkbox");

  _battleships = document.querySelector(".battleship-count");
  _cruisers = document.querySelector(".cruiser-count");
  _destroyers = document.querySelector(".destroyer-count");
  _submarines = document.querySelector(".submarine-count");

  _resetBtn = document.querySelector(".btn-reset");

  _shotVariations = {
    "grid-shot": `<i class="fas fa-times"></i>`,
    "grid-killzone": `<i class="fas fa-times"></i>`,
    "grid-target": `<i class="fas fa-crosshairs"></i>`,
    "grid-hit": `<i class="fas fa-times"></i>`,
    "grid-destroyed": `<i class="fas fa-times"></i>`,
  };

  _unsetCheckboxes() {
    this._allChecks.forEach((el) => {
      el.innerHTML = "";
    });
  }

  addHandlerCheckboxes(state, handler) {
    this._optionsContainer.addEventListener("click", (e) => {
      const checkbox = e.target.closest(".options-checkbox");
      if (!checkbox) return;
      this._unsetCheckboxes();
      if (state.currentCheckbox == checkbox.dataset.type) {
        handler(null);
        return;
      }
      checkbox.innerHTML = `<i class="fas fa-times"></i>`;
      handler(checkbox.dataset.type);
    });
  }

  setMarkup() {
    // Filling in empty grid squares
    let markup = "";
    for (let row = 0; row < 10; row++) {
      for (let col = 0; col < 10; col++) {
        markup += `
          <div
            data-row="${row}"
            data-col="${col}"
            data-state="grid-index"
            class="grid-square game-square"
          >
          </div>`;
      }
    }
    this._gridContainer.innerHTML = markup;

    // Unchecking checkboxes
    this._unsetCheckboxes();

    // Reseting ship counters
    this._battleships.innerHTML = 1;
    this._cruisers.innerHTML = 2;
    this._destroyers.innerHTML = 3;
    this._submarines.innerHTML = 4;
  }

  _getHeatmapColor(maxVal, minVal, val) {
    const maxColor = [184, 46, 56];
    const minColor = [240, 136, 144];
    // Creating a deep copy of one of the colors
    const result = [...maxColor];

    const factor = (val - maxVal) / (minVal - maxVal);
    for (let i = 0; i < 3; i++) {
      result[i] = Math.round(result[i] + factor * (minColor[i] - maxColor[i]));
    }
    return `rgb(${result[0]},${result[1]},${result[2]})`;
  }

  updateUI(state) {
    let maxVal = state.grid[`0-0`].probabilityIndex;
    let minVal = state.grid[`0-0`].probabilityIndex;
    for (const key in state.grid) {
      const cell = state.grid[key];
      if (cell.probabilityIndex > maxVal) maxVal = cell.probabilityIndex;
      if (cell.probabilityIndex < minVal) minVal = cell.probabilityIndex;
    }
    for (let row = 0; row < 10; row++) {
      for (let col = 0; col < 10; col++) {
        const stateEl = state.grid[`${row}-${col}`];
        const uiEl = document.querySelector(
          `[data-row='${row}'][data-col='${col}']`
        );
        uiEl.dataset.state = stateEl.state;
        stateEl.isUsable
          ? (uiEl.innerHTML = stateEl.probabilityIndex)
          : (uiEl.innerHTML = this._shotVariations[stateEl.state]);
        uiEl.style.color = this._getHeatmapColor(
          maxVal,
          minVal,
          stateEl.probabilityIndex
        );
      }
    }
    this._battleships.innerHTML = state.shipsLeft["battleship"].shipsLeft;
    this._cruisers.innerHTML = state.shipsLeft["cruiser"].shipsLeft;
    this._destroyers.innerHTML = state.shipsLeft["destroyer"].shipsLeft;
    this._submarines.innerHTML = state.shipsLeft["submarine"].shipsLeft;
  }

  addHandlerGridClick(handler) {
    this._gridContainer.addEventListener("click", (e) => {
      const cell = e.target.closest(".game-square");
      if (!cell) return;
      handler(cell.dataset.row, cell.dataset.col);
    });
  }

  addHandlerReset(handler) {
    this._resetBtn.addEventListener("click", () => {
      this._unsetCheckboxes();
      handler();
    });
  }
}

export default new View();
