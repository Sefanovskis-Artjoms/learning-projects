/* /////////////////////////////// */
/* Kods atbildīgs par mobīlās navigācijas darbību
/* /////////////////////////////// */
const btnNavOpen = document.querySelector(".btn-mobile-nav-open");
const btnNavClose = document.querySelector(".btn-mobile-nav-close");
const navigation = document.querySelector(".main-nav-container");

btnNavOpen.addEventListener("click", function () {
  navigation.classList.toggle("nav-open");
});

btnNavClose.addEventListener("click", function () {
  navigation.classList.remove("nav-open");
});

/* /////////////////////////////// */
/* Kods atbildīgs par pašreizējā gada izvadi mājaslapas kājenē 
/* /////////////////////////////// */
const year = document.querySelector(".year");
const currentYear = new Date().getFullYear();
year.textContent = currentYear;

/* /////////////////////////////// */
/* Kods atbildīgs par šodienas, kā minimālā datuma, iestatīšanu pasūtījumu pieteikšanas kalendārā 
/* /////////////////////////////// */
const today = new Date().toISOString().split("T")[0];
document.getElementsByName("order_date")[0].setAttribute("min", today);
