import * as model from "./model.js";
import View from "./view.js";

const init = function () {
  View.setMarkup();
  model.initializeGridState(model.state);
  model.calculateProbability(model.state);
  View.updateUI(model.state);
};

init();
