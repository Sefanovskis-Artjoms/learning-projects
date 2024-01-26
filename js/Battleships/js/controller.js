import * as model from "./model.js";
import View from "./view.js";

const controlUpdateCheckboxState = function (newCheckboxState) {
  model.setCurrentCheckbox(newCheckboxState);
};

const controlGridClick = function (row, col) {
  const checkbox = model.state.currentCheckbox;
  if (actions[checkbox]) {
    actions[checkbox](model.state, +row, +col);
  } else {
    return;
  }
  model.resetProbabilityIndex(model.state);
  model.calculateProbability(model.state);
  View.updateUI(model.state);
};

const actions = {
  shot: (state, row, col) => {
    model.shot(state, row, col);
  },
  hit: (state, row, col) => {
    model.hit(state, row, col);
  },
  sunk: (state, row, col) => {
    model.sunk(state, row, col);
  },
};

const init = function () {
  View.setMarkup();
  model.initializeGridState(model.state);
  model.calculateProbability(model.state);
  View.updateUI(model.state);
  View.addHandlerCheckboxes(model.state, controlUpdateCheckboxState);
  View.addHandlerGridClick(controlGridClick);
};

init();
