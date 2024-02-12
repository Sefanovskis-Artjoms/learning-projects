// Logic for misclick button
document
  .querySelector(".btn-toDecrement")
  .addEventListener("click", function () {
    const button = document.querySelector(".btn-switch");
    if (button.classList.contains("btn-toDecrement")) {
      button.textContent = "Back";
      button.classList.remove("btn-toDecrement");
      button.classList.add("btn-toIncrement");

      document.querySelectorAll(".btn-counter").forEach(function (element) {
        element.classList.remove("btn-increment");
        element.classList.add("btn-decrement");
        element.querySelector(".action").textContent = "-1";
      });
    } else {
      button.textContent = "Misclick?";
      button.classList.remove("btn-toIncrement");
      button.classList.add("btn-toDecrement");
      document.querySelectorAll(".btn-counter").forEach(function (element) {
        element.classList.remove("btn-decrement");
        element.classList.add("btn-increment");
        element.querySelector(".action").textContent = "+1";
      });
    }
  });

// Creating logic for increment button
document
  .querySelector(".counter-container")
  .addEventListener("click", function (e) {
    if (
      e.target.classList.contains("btn-increment") ||
      e.target.closest(".btn-increment")
    ) {
      const button = e.target.classList.contains("btn-increment")
        ? e.target
        : e.target.closest(".btn-increment");

      const zone = button.dataset.zone;
      const counter = button.dataset.counter;

      const request = new XMLHttpRequest();
      request.open("POST", "inc/increment.php", true);
      request.setRequestHeader(
        "Content-Type",
        "application/x-www-form-urlencoded"
      );

      request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
          const response = JSON.parse(request.responseText);
          if (response.success) {
            button.querySelector(".counter-number").textContent =
              response.counter;
          }
        }
      };
      // sending variables to the request
      const data = `zone=${encodeURIComponent(
        zone
      )}&counterName=${encodeURIComponent(counter)}`;
      request.send(data);
    }
  });

// Logic for decrement button
document
  .querySelector(".counter-container")
  .addEventListener("click", function (e) {
    if (
      e.target.classList.contains("btn-decrement") ||
      e.target.closest(".btn-decrement")
    ) {
      const button = e.target.classList.contains("btn-decrement")
        ? e.target
        : e.target.closest(".btn-decrement");

      const zone = button.dataset.zone;
      const counter = button.dataset.counter;

      const request = new XMLHttpRequest();
      request.open("POST", "inc/decrement.php", true);
      request.setRequestHeader(
        "Content-Type",
        "application/x-www-form-urlencoded"
      );

      request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
          const response = JSON.parse(request.responseText);
          if (response.success) {
            button.querySelector(".counter-number").textContent =
              response.counter;
          }
        }
      };
      // sending variables to the request
      const data = `zone=${encodeURIComponent(
        zone
      )}&counterName=${encodeURIComponent(counter)}`;
      request.send(data);
    }
  });
