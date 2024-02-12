document.querySelector(".zones").addEventListener("click", function (e) {
  if (!e.target.classList.contains("zone-img")) {
    return;
  }
  const targetDiv = document.querySelector(
    `.counter-zone-${e.target.dataset.zone}`
  );
  targetDiv.classList.add("shadow");
  targetDiv.scrollIntoView({ behavior: "smooth" });

  setTimeout(function () {
    targetDiv.classList.remove("shadow");
  }, 1000);
});
