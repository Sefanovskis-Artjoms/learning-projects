export default class Ship {
  shiplength;
  cells = [];
  /* cells = [
    {
      row,
      col,
      adjacentCells:{
        exist:bool
        row,
        col,
        cell:{
          isUsable:bool,
          containsShot:bool,
          state:string,
        }
      }
    }
  ]
  */
  sunk = false;

  constructor(state, cells) {
    this.cells.push({ ...cells });
    this.shiplength = this.cells.length;
    this._addAdjacentCells(state);
  }

  // Function sets into state the adjacent cell info of the ship
  createAdjacent(state) {
    this._placeKillzone(state);
    this._placeTargets(state);
  }

  _placeKillzone(state) {
    // Iterates through known cells of the ship
    for (let i = 0; i < this.cells.length; i++) {
      // Iterates through every adjacent cell of each ships cell
      for (const key in this.cells[i].adjacentCells) {
        const element = this.cells[i].adjacentCells[key];
        // Filtering out only existing adjacent cells on diagonal axis
        if (element.exists && state.diagonalAxis.includes(key)) {
          // Updating information for the adjacent cell in the state
          state.grid[`${element.row}-${element.col}`].isUsable = false;
          state.grid[`${element.row}-${element.col}`].state = "grid-killzone";
        }
      }
    }
  }
  _placeTargets(state) {
    // If current ship is the longest ship that is left then function not placing targets
    let longestShip = this._isLongestShipLeft(state);
    if (longestShip) return;

    // Iterates through known cells of the ship
    for (let i = 0; i < this.cells.length; i++) {
      // Iterates through every adjacent cell of each ships cell
      for (const key in this.cells[i].adjacentCells) {
        const element = this.cells[i].adjacentCells[key];
        // Filtering out only existing adjacent cells on straight axis
        if (!element.exists || !state.straightAxis.includes(key)) {
          continue;
        }
        // Adding target only to pure cell
        if (element.cell.state == "grid-index") {
          state.grid[`${element.row}-${element.col}`].isUsable = false;
          state.grid[`${element.row}-${element.col}`].state = "grid-target";
          continue;
        }
        // If cell already has target, then checking if it is eligable to be merged with ship next to it, if not then cell is converted to killzone
        if (element.cell.state == "grid-target") {
          // Killzone if other ships length and current ships length in sum are more than 3
          if (!this._isAdjacentShipEligable(element, state)) {
            state.grid[`${element.row}-${element.col}`].isUsable = false;
            state.grid[`${element.row}-${element.col}`].state = "grid-killzone";
          }
        }
      }
    }
  }

  // function adds information about adjacent cells to every cell of the ship
  _addAdjacentCells(state) {
    for (let i = 0; i < this.cells.length; i++) {
      const element = this.cells[i];
      element.adjacentCells = Ship.getAdjacentCells(
        state,
        element.row,
        element.col
      );
    }
  }

  _isLongestShipLeft(state) {
    // Get the length of the current ship
    const currentShipLength = this.cells.length;

    // Check if there's any ship left with a greater length
    for (const ship in state.shipsLeft) {
      if (
        state.shipsLeft[ship].shipLength > currentShipLength &&
        state.shipsLeft[ship].left > 0
      ) {
        return false;
      }
    }

    // If no ship left has a greater length, return true
    return true;
  }

  // Helper function for _placeTargets function to determine if current and adjacent ships are compatible to combine
  _isAdjacentShipEligable(element, state) {
    let totalLength = 0;
    // Iterate over all ships in the shipRecord
    for (let i = 0; i < state.shipRecord.ships.length; i++) {
      const ship = state.shipRecord.ships[i];
      // Iterates through known cells of the ship
      for (let j = 0; j < ship.cells.length; j++) {
        // Iterates over all adjacent cells
        for (const key in ship.cells[j].adjacentCells) {
          const cell = ship.cells[j].adjacentCells[key];
          if (cell?.row == element.row && cell?.col == element.col) {
            totalLength += ship.shiplength;
          }
        }
      }
    }
    if (totalLength > 3) {
      return false;
    }
    return true;
  }

  // Static helper function to get all adjacent cells for a given one
  static getAdjacentCells(state, row, col) {
    const directions = {
      "up-left": [-1, -1],
      up: [-1, 0],
      "up-right": [-1, 1],
      left: [0, -1],
      right: [0, 1],
      "down-left": [1, -1],
      down: [1, 0],
      "down-right": [1, 1],
    };
    let adjacentCells = {};
    for (const dir in directions) {
      const newRow = row + directions[dir][0];
      const newCol = col + directions[dir][1];
      if (newRow >= 0 && newRow < 10 && newCol >= 0 && newCol < 10) {
        adjacentCells[dir] = {
          exists: true,
          row: newRow,
          col: newCol,
          cell: state.grid[`${newRow}-${newCol}`],
        };
      } else {
        adjacentCells[dir] = { exists: false };
      }
    }
    return adjacentCells;
  }
  // Static helper function that takes object of adjacent cells and returns only those cells that state is grid-hit
  static getAdjacentHits(adjacentCells) {
    let hits = [];
    for (const key in adjacentCells) {
      if (
        adjacentCells[key].exists &&
        adjacentCells[key].cell.state == "grid-hit"
      ) {
        hits.push(adjacentCells[key]);
      }
    }
    return hits;
  }
}
