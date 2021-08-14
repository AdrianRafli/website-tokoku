/*===== CHANGE COLOR HEADER =====*/
const navbar = document.querySelector(".navbar");
window.addEventListener("scroll", function () {
  if (window.scrollY < 400) {
    navbar.classList.remove("scroll-navbar");
    return;
  } else if (window.scrollY > 400) {
    navbar.classList.add("scroll-navbar");
  }
});
