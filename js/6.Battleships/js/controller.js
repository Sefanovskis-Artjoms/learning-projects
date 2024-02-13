import * as model from "./model.js";
import View from "./view.js";

const controlUpdateCheckboxState = function (newCheckboxState) {
  model.setCurrentCheckbox(newCheckboxState);
};

const controlGridClick = function (row, col) {
  const checkbox = model.state.currentCheckbox;
  if (["shot", "hit", "sunk"].includes(checkbox)) {
    model[checkbox](model.state, +row, +col);
  } else {
    return;
  }
  model.resetProbabilityIndex(model.state);
  model.calculateProbability(model.state);
  View.updateUI(model.state);
};

const controlReset = function () {
  model.resetGrid(model.state);
  model.calculateProbability(model.state);
  View.updateUI(model.state);
};

const init = function () {
  View.setMarkup();
  model.initializeGridState(model.state);
  model.calculateProbability(model.state);
  View.updateUI(model.state);
  View.addHandlerCheckboxes(model.state, controlUpdateCheckboxState);
  View.addHandlerGridClick(controlGridClick);
  View.addHandlerReset(controlReset);
};

init();
