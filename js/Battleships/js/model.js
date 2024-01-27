export const state = {
  currentCheckbox: null,
  grid: {},
  shipsLeft: {
    battleship: { length: 4, left: 1 },
    cruiser: { length: 3, left: 2 },
    destroyer: { length: 2, left: 3 },
    submarine: { length: 1, left: 4 },
  },
};

export const setCurrentCheckbox = function (newCurrentCheckbox) {
  state.currentCheckbox = newCurrentCheckbox;
};

// Function to initialize the grid data
export const initializeGridState = function (state) {
  for (let row = 0; row < 10; row++) {
    for (let col = 0; col < 10; col++) {
      let cell = {
        probabilityIndex: 0,
        // Used to determine if this cell can be used to count probability
        isUsable: true,
        // Used to determine how to display this cell
        state: "grid-index",
        /*
        Possible states:
        grid-index
        grid-index-recomended
        grid-shot
        grid-killzone
        grid-target
        grid-hit
        grid-destroyed
        */
      };

      // Useing row and col as key to store the cell in the grid
      state.grid[`${row}-${col}`] = cell;
    }
  }
};

export const resetProbabilityIndex = function (state) {
  for (let key in state.grid) {
    state.grid[key].probabilityIndex = 0;
  }
};

export const resetGrid = function (state) {
  state.currentCheckbox = null;
  state.shipsLeft.battleship.left = 1;
  state.shipsLeft.cruiser.left = 2;
  state.shipsLeft.destroyer.left = 3;
  state.shipsLeft.submarine.left = 4;
  for (let key in state.grid) {
    state.grid[key].probabilityIndex = 0;
    state.grid[key].isUsable = true;
    state.grid[key].state = "grid-index";
  }
};

export const calculateProbability = function (state) {
  for (const ship in state.shipsLeft) {
    // Index calculation on horizontal axis
    for (let row = 0; row < 10; row++) {
      for (let col = 0; col < 10; col++) {
        const shipLength = +state.shipsLeft[ship].length;
        const shipsLeft = +state.shipsLeft[ship].left;
        let canPlaceH = true;
        let canPlaceV = true;
        // Checking if ship is in the borders of grid
        if (col + shipLength > 10) {
          canPlaceH = false;
        }
        if (row + shipLength > 10) {
          canPlaceV = false;
        }
        // Checking if ship is allowed to be placed
        for (let len = 0; len < shipLength; len++) {
          if (canPlaceH && !state.grid[`${row}-${col + len}`].isUsable) {
            canPlaceH = false;
          }
          if (canPlaceV && !state.grid[`${row + len}-${col}`].isUsable) {
            canPlaceV = false;
          }
        }
        if (canPlaceH) {
          for (let len = 0; len < shipLength; len++) {
            state.grid[`${row}-${col + len}`].probabilityIndex += shipsLeft;
          }
        }
        if (canPlaceV) {
          for (let len = 0; len < shipLength; len++) {
            state.grid[`${row + len}-${col}`].probabilityIndex += shipsLeft;
          }
        }
        if (canPlaceH && canPlaceV && shipLength == 1) {
          state.grid[`${row}-${col}`].probabilityIndex -= shipsLeft;
        }
      }
    }
  }
};

export const shot = function (state, row, col) {
  const cell = state.grid[`${row}-${col}`];
  if (cell.isUsable) {
    cell.isUsable = false;
    cell.state = "grid-shot";
    return;
  }
  if (!cell.isUsable && cell.state == "grid-shot") {
    cell.isUsable = true;
    cell.state = "grid-index";
  }
};
