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

export const calculateProbability = function (state) {
  for (const ship in state.shipsLeft) {
    // Index calculation on horizontal axis
    for (let row = 0; row < 10; row++) {
      for (let col = 0; col < 10; col++) {
        const shipLength = +state.shipsLeft[ship].length;
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
            if (state.grid[`${row}-${col + len}`].isUsable) {
              state.grid[`${row}-${col + len}`].probabilityIndex +=
                +state.shipsLeft[ship].left;
            }
          }
        }
        if (canPlaceV) {
          for (let len = 0; len < shipLength; len++) {
            if (state.grid[`${row + len}-${col}`].isUsable) {
              state.grid[`${row + len}-${col}`].probabilityIndex +=
                +state.shipsLeft[ship].left;
            }
          }
        }
      }
    }
  }
};
