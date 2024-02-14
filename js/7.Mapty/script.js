"use strict";
const modal = document.querySelector(".modal");
const modalHeader = document.querySelector(".modal-header");
const overlay = document.querySelector(".overlay");
const btnModalNo = document.querySelector(".btn-modal-no");
const btnModalYes = document.querySelector(".btn-modal-yes");
const deleteAllWorkoutsBtn = document.querySelector(".delete-all-workouts");
const form = document.querySelector(".form");
const containerWorkouts = document.querySelector(".workouts");
const inputType = document.querySelector(".form__input--type");
const inputDistance = document.querySelector(".form__input--distance");
const inputDuration = document.querySelector(".form__input--duration");
const inputCadence = document.querySelector(".form__input--cadence");
const inputElevation = document.querySelector(".form__input--elevation");
// const seeAllWorkouts = document.querySelector('.see-all-workouts');

class Workout {
  date = new Date();
  id = (Date.now() + "").slice(-10);

  constructor(coords, distance, duration) {
    this.coords = coords; //[lat,lng]
    this.distance = distance;
    this.duration = duration;
  }

  _setDescription() {
    // prettier-ignore
    const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    this.description = `${this.type[0].toUpperCase()}${this.type.slice(1)} on ${
      months[this.date.getMonth()]
    } ${this.date.getDate()}`;
  }
}

class Running extends Workout {
  type = "running";
  constructor(coords, distance, duration, cadence) {
    super(coords, distance, duration);
    this.cadence = cadence;
    this.calcPace();
    this._setDescription();
  }

  calcPace() {
    // min/km
    this.pace = this.duration / this.distance;
    return this.pace;
  }
}
class Cycling extends Workout {
  type = "cycling";
  constructor(coords, distance, duration, elevationGain) {
    super(coords, distance, duration);
    this.elevationGain = elevationGain;
    this.calcSpeed();
    this._setDescription();
  }

  calcSpeed() {
    // km/h
    this.speed = this.distance / this.duration / 60;
    return this.speed;
  }
}

// ////////////////////////////////////////////
// Application architecture
class App {
  #map;
  #mapZoomlevel = 13;
  #mapEvent;
  #workouts = [];

  constructor() {
    // Get users positon
    this._getPositon();

    // Get data from local stroage
    this._getLocalStorage();

    // Attach event handlers
    deleteAllWorkoutsBtn.addEventListener(
      "click",
      this._deleteAllWorkouts.bind(this)
    );
    form.addEventListener("submit", this._newWorkout.bind(this));
    inputType.addEventListener("change", this._toggleElevationField);
    containerWorkouts.addEventListener("click", this._deleteWorkout.bind(this));
    containerWorkouts.addEventListener("click", this._moveToPopup.bind(this));
  }

  _getPositon() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        this._loadMap.bind(this),
        function () {
          alert("Could not get your position");
        }
      );
    }
  }

  _loadMap(positon) {
    const { latitude } = positon.coords;
    const { longitude } = positon.coords;

    const coords = [latitude, longitude];

    this.#map = L.map("map").setView(coords, this.#mapZoomlevel);

    L.tileLayer(
      "https://tile.openstreetmap.org/{z}/{x}/{y}.png?style=osm-bright",
      {
        attribution:
          '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      }
    ).addTo(this.#map);

    // Handling click on map
    this.#map.on("click", this._showForm.bind(this));

    this.#workouts.forEach((work) => {
      this._renderWorkoutMarker(work);
    });
  }

  _showForm(mapE) {
    this.#mapEvent = mapE;
    form.classList.remove("hidden");
    inputDistance.focus();
  }

  _hideForm() {
    // Empying form fields
    // prettier-ignore
    inputDistance.value = inputDuration.value = inputCadence.value =inputElevation.value ='';
    // Hiding form
    form.style.display = "none";
    form.classList.add("hidden");
    setTimeout(() => {
      form.style.display = "grid";
    }, 1000);
  }

  _toggleElevationField() {
    inputElevation.closest(".form__row").classList.toggle("form__row--hidden");
    inputCadence.closest(".form__row").classList.toggle("form__row--hidden");
  }

  _newWorkout(e) {
    const validInputs = (...inputs) =>
      inputs.every((inp) => Number.isFinite(inp));

    const allPositive = (...inputs) => inputs.every((inp) => inp >= 0);
    e.preventDefault();
    // Get data form form
    const type = inputType.value;
    const distance = +inputDistance.value;
    const duration = +inputDuration.value;
    const { lat, lng } = this.#mapEvent.latlng;
    let workout;

    // If activity runing create running object
    if (type === "running") {
      const cadence = +inputCadence.value;
      if (
        !validInputs(distance, duration, cadence) ||
        !allPositive(distance, duration, cadence)
      ) {
        return alert("Inputs have to be positive numbers");
      }

      workout = new Running([lat, lng], distance, duration, cadence);
    }
    // If activity cycling create cycling object
    if (type === "cycling") {
      const elevation = +inputElevation.value;
      if (
        !validInputs(distance, duration, elevation) ||
        !allPositive(distance, duration)
      ) {
        return alert("Inputs have to be positive numbers");
      }
      workout = new Cycling([lat, lng], distance, duration, elevation);
    }
    // Add new object to workout array
    this.#workouts.push(workout);

    // Render workout on map as marker
    this._renderWorkoutMarker(workout);

    // Render workout on list
    this._renderWorkout(workout);

    // Hide form + Clear input fields
    this._hideForm();

    // Set local storage to all wokrouts
    this._setLocalStorage();
  }

  _renderWorkoutMarker(workout) {
    //Creating dynamical variable name using window object to make distinctive markers that can be accesed later using this name
    window[`marker_${workout.id}`] = new L.Marker(L.latLng(workout.coords));
    // Display marker
    this.#map.addLayer(window[`marker_${workout.id}`]);
    // Adding popup
    window[`marker_${workout.id}`]
      .bindPopup(
        L.popup({
          maxWidth: 250,
          minWidth: 100,
          autoClose: false,
          closeOnClick: false,
          className: `${workout.type}-popup`,
        })
      )
      .setPopupContent(
        `${workout.type === "running" ? "🏃‍♂️" : "🚴‍♀️"} ${workout.description}`
      )
      .openPopup();
  }

  _renderWorkout(workout) {
    let html = `
    <li class="workout workout--${workout.type}" data-id="${workout.id}">
      <div class="workout-header-box">
        <h2 class="workout__title">${workout.description}</h2>
        <span class="delete-workout">X</span>
      </div>
      <div class="workout__details">
        <span class="workout__icon">${
          workout.type === "running" ? "🏃‍♂️" : "🚴‍♀️"
        }</span>
        <span class="workout__value">${workout.distance}</span>
        <span class="workout__unit">km</span>
      </div>
      <div class="workout__details">
        <span class="workout__icon">⏱</span>
        <span class="workout__value">${workout.duration}</span>
        <span class="workout__unit">min</span>
      </div>`;

    if (workout.type === "running") {
      html += `
        <div class="workout__details">
          <span class="workout__icon">⚡️</span>
          <span class="workout__value">${workout.pace?.toFixed(1) || 0}</span>
          <span class="workout__unit">min/km</span>
        </div>
        <div class="workout__details">
          <span class="workout__icon">🦶🏼</span>
          <span class="workout__value">${workout.cadence}</span>
          <span class="workout__unit">spm</span>
        </div>
      </li>`;
    }

    if (workout.type === "cycling") {
      html += `
        <div class="workout__details">
          <span class="workout__icon">⚡️</span>
          <span class="workout__value">${workout?.speed?.toFixed(1) || 0}</span>
          <span class="workout__unit">km/h</span>
        </div>
        <div class="workout__details">
          <span class="workout__icon">⛰</span>
          <span class="workout__value">${workout.elevationGain}</span>
          <span class="workout__unit">m</span>
        </div>
      </li>`;
    }
    form.insertAdjacentHTML("afterend", html);
  }

  _moveToPopup(e) {
    const workoutEl = e.target.closest(".workout");
    if (!workoutEl) return;
    if (e.target.classList.contains("delete-workout")) return;

    const workout = this.#workouts.find(
      (work) => work.id === workoutEl.dataset.id
    );

    this.#map.setView(workout.coords, this.#mapZoomlevel, {
      animate: true,
      pan: { duration: 1 },
    });
    // using public interface
    // workout.click();
  }

  _setLocalStorage() {
    // JSON.stringify converts object to string
    // localstorage must be used only on small amounts of data
    // lacal storage is simple key value storage where value must also always be a string
    localStorage.setItem("workouts", JSON.stringify(this.#workouts));
  }

  _getLocalStorage() {
    const data = JSON.parse(localStorage.getItem("workouts"));

    if (!data) return;

    this.#workouts = data;
    this.#workouts.forEach((work) => {
      this._renderWorkout(work);
    });
  }

  reset() {
    localStorage.removeItem("workouts");
    location.reload();
  }

  _deleteWorkout(e) {
    // gets clicked workout markup
    let deleteEl = e.target.closest(".delete-workout");
    if (!deleteEl) return;
    // fetches workout object
    const workout = this.#workouts.find(
      (work) => work.id === deleteEl.closest(".workout").dataset.id
    );

    // removes workout card from list in the markup
    deleteEl.closest(".workout").remove();

    // removes workout marker from map
    this.#map.removeLayer(window[`marker_${workout.id}`]);

    // Cuts workout from the workout array
    this.#workouts.splice(this.#workouts.indexOf(workout), 1);
    this._setLocalStorage();
  }

  _deleteAllWorkouts(e) {
    return;
    this._confirmAction("Delete all workouts", 0);
    // this.reset();
  }

  _confirmAction(action, position) {
    modalHeader.textContent = `Do you realy want to ${action}`;
    this._openModal();
    return false;
  }

  _openModal() {
    modal.classList.remove("hidden");
    overlay.classList.remove("hidden");
  }

  _closeModal() {
    modal.classList.add("hidden");
    overlay.classList.add("hidden");
  }
}

const app = new App();
