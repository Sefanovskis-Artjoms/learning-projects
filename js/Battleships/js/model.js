import Ship from "./ship.js";

export const state = {
  currentCheckbox: null,
  grid: {},
  shipsLeft: {
    battleship: { shipLength: 4, left: 1 },
    cruiser: { shipLength: 3, left: 2 },
    destroyer: { shipLength: 2, left: 3 },
    submarine: { shipLength: 1, left: 4 },
  },
  shipRecord: {
    possibleHitsLeft: 20,
    ships: [],
    knownShipInstances: [],
  },
  straightAxis: ["up", "down", "right", "left"],
  diagonalAxis: ["up-right", "up-left", "down-right", "down-left"],
};

const _setKnownShipInstances = function (state) {
  state.shipRecord.knownShipInstances = [
    { shipLength: 1, instances: 0, maxAllowed: 10 },
    { shipLength: 2, instances: 0, maxAllowed: 6 },
    { shipLength: 3, instances: 0, maxAllowed: 3 },
    { shipLength: 4, instances: 0, maxAllowed: 1 },
  ];
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
        // Stores if this cell contains a shot as some states will have to temporarely override grid-shot
        containsShot: false,
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

      // Using row and col as key to store the cell in the grid
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
  state.shipRecord.possibleHitsLeft = 20;
  state.shipRecord.ships = [];
  for (let key in state.grid) {
    state.grid[key].probabilityIndex = 0;
    state.grid[key].isUsable = true;
    state.grid[key].containsShot = false;
    state.grid[key].state = "grid-index";
  }
};

export const calculateProbability = function (state) {
  for (const ship in state.shipsLeft) {
    // Index calculation on horizontal axis
    for (let row = 0; row < 10; row++) {
      for (let col = 0; col < 10; col++) {
        const shipLength = +state.shipsLeft[ship].shipLength;
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
  // Adding hit
  if (cell.isUsable || cell.state == "grid-target") {
    cell.isUsable = false;
    cell.containsShot = true;
    cell.state = "grid-shot";
    return;
  }
  // Removing hit
  if (!cell.isUsable && cell.state == "grid-shot") {
    cell.isUsable = true;
    cell.containsShot = false;
    cell.state = "grid-index";
  }
};

export const hit = function (state, row, col) {
  const cell = state.grid[`${row}-${col}`];
  // Checking if cell is appropriate to place shot
  if (
    !["grid-index", "grid-shot", "grid-hit", "grid-target"].includes(cell.state)
  ) {
    return;
  }

  // object containing information about cells around given cell
  const adjacentCells = Ship.getAdjacentCells(state, row, col);
  // Object contains information about hit type cells around given, if there are none then empty
  const adjacentHits = Ship.getAdjacentHits(adjacentCells);

  // Removing hit logic
  if (cell.state == "grid-hit") {
    // Removing stand alone hit
    // Removing hit with one adjacent hit
    // Removing hit between thow adjacent hits
    return;
  }

  // Checking if there are hits left to use
  if (state.shipRecord.possibleHitsLeft <= 0) {
    return;
  }

  // If its a stand alone hit then checking if there are any new unrevealed ships
  if (!adjacentHits.length && state.shipRecord.ships.length >= 10) {
    return;
  }

  // Processing stand alone hit
  if (!adjacentHits.length) {
    _placeStandAloneHit(state, row, col, cell);
    return;
  }

  // Adding another hit to the ship
  if (adjacentHits.length == 1) {
    _placeAddedHit(state, row, col, cell);
    return;
  }
};

export const sunk = function (state, row, col) {
  console.log(state.shipRecord);
};

const _placeStandAloneHit = function (state, row, col, cell) {
  // Updating availabe hit count in shipRecord
  state.shipRecord.possibleHitsLeft--;
  // Adding single cell ship to the record
  state.shipRecord.ships.push(new Ship(state, { row, col }));
  // Placing hit into the grid
  cell.state = "grid-hit";
  cell.isUsable = false;
  // Update ship adjacent cell info
  _updateAdjacent(state);
};

// Logic for adding hit for a ship
const _placeAddedHit = function (state, row, col, cell) {
  const shipIndex = _getShipsByTarget(state, row, col);
  const ship = state.shipRecord.ships[shipIndex[0]];
  // Return if ship cannot be longer
  if (!ship.canExpand(state)) return;
  state.shipRecord.possibleHitsLeft--;
  // Assigning given cell as a part of the ship
  ship.addCell(state, row, col);
  // Setting state in the gird for given cell
  cell.state = "grid-hit";
  cell.isUsable = false;
  // Updating adjacent cell info for all ships
  _updateAdjacent(state);
};

// Helper function that updates adjacent cell data for each ship
const _updateAdjacent = function (state) {
  // Updates known ship count for every length
  // Needed for correct display of targets and to control if hit can be placed
  _updateKnownShipInstances(state);
  // Clearing old adjacent cell info
  _clearAdjacent(state);
  // Creating new adjacent cell infor for each ship
  state.shipRecord.ships.forEach((ship) => {
    ship.createAdjacent(state);
  });
};

// Helper function to clear grid from cells that can be only around the ship e.g. "grid-killzone", "grid-target"
const _clearAdjacent = function (state) {
  for (const key in state.grid) {
    const cell = state.grid[key];
    if (cell.state == "grid-killzone" || cell.state == "grid-target") {
      if (cell.containsShot) {
        cell.state = "grid-shot";
        continue;
      }
      cell.state = "grid-index";
      cell.isUsable = true;
    }
  }
};

// Function returns array with indexes that correspond to the ships in shipRecord that have given cell(row+col) as adjacent cell
const _getShipsByTarget = function (state, row, col) {
  const shipIndexes = [];
  // Iterate over ships in the shipRecord
  for (let i = 0; i < state.shipRecord.ships.length; i++) {
    const ship = state.shipRecord.ships[i];
    // Iterates through known cells of the ship
    for (let j = 0; j < ship.cells.length; j++) {
      // Iterates over all adjacent cells
      for (const key in ship.cells[j].adjacentCells) {
        const cell = ship.cells[j].adjacentCells[key];
        if (cell?.row == row && cell?.col == col) {
          shipIndexes.push(i);
        }
      }
    }
  }
  return shipIndexes;
};

const _updateKnownShipInstances = function (state) {
  // Resets known ship record for the ease of updating it
  _setKnownShipInstances(state);
  // Counting instance count for every ship length
  for (let i = 0; i < state.shipRecord.ships.length; i++) {
    const shipLength = state.shipRecord.ships[i].shiplength;
    state.shipRecord.knownShipInstances[shipLength - 1].instances++;

    if (shipLength == 1) continue;
    // Decreases maximum possible ship count in every length that is smaller than current ship
    for (let i = shipLength - 2; i >= 0; i--) {
      state.shipRecord.knownShipInstances[i].maxAllowed--;
    }
  }
};
