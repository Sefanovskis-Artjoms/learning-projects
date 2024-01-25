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

  addHandlerCheckboxes(activeCheckbox, handler) {
    this._optionsContainer.addEventListener("click", (e) => {
      const checkbox = e.target.closest(".options-checkbox");
      if (!checkbox) return;
      this._unsetCheckboxes();
      if (activeCheckbox == checkbox.dataset.type) {
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

  updateUI(state) {
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
      }
    }
  }
}

export default new View();
