import * as model from "./model.js";
import View from "./view.js";

const controlUpdateCheckboxState = function (newCheckboxState) {
  model.setCurrentCheckbox(newCheckboxState);
};

const init = function () {
  View.setMarkup();
  model.initializeGridState(model.state);
  model.calculateProbability(model.state);
  View.updateUI(model.state);
  View.addHandlerCheckboxes(
    model.state.currentCheckbox,
    controlUpdateCheckboxState
  );
};

init();
