/*===== MENU SHOW (Grid)=====*/
const showMenu = () => {
  const toggle = document.getElementById("nav-toggle");
  const nav = document.getElementById("nav-menu");

  if (toggle && nav) {
    toggle.addEventListener("click", () => {
      nav.classList.toggle("show");
    });
  }
};

showMenu();

/*===== REMOVE MENU =====*/
const navLink = document.querySelectorAll(".nav_link");
const navMenu = document.getElementById("nav-menu");

function linkAction() {
  navMenu.classList.remove("show");
}
navLink.forEach((n) => n.addEventListener("click", linkAction));

/*===== SCROLL SECTIONS ACTIVE LINK =====*/

/*===== CHANGE COLOR HEADER =====*/
