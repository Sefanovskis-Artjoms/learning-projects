/* /////////////////////////////// */
/* Kods atbildīgs par pašreizējā gada izvadi mājaslapas kājenē 
/* /////////////////////////////// */
const year = document.querySelector(".year");
const currentYear = new Date().getFullYear();
year.textContent = currentYear;
