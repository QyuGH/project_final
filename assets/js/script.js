// Functionality for sidebar burger menu icon
const burger = document.querySelector(".burger-menu");
const closeBtn = document.querySelector(".close-menu");
const navWrapper = document.querySelector(".nav-wrapper");
const overlay = document.querySelector(".overlay");

function openSidebar() {
  navWrapper.classList.add("nav-open");
  overlay.classList.add("active");
}

function closeSidebar() {
  navWrapper.classList.remove("nav-open");
  overlay.classList.remove("active");
}

burger.addEventListener("click", openSidebar);
closeBtn.addEventListener("click", closeSidebar);
overlay.addEventListener("click", closeSidebar);



