/*===== CHANGE COLOR HEADER =====*/
function changeBg() {
  const navbar = document.getElementById("navbar");
  let scrollValue = window.scrollY;
  if (scrollValue < 410) {
    navbar.classList.remove("scroll-navbar");
  } else {
    navbar.classList.add("scroll-navbar");
  }
}

window.addEventListener("scroll", changeBg);
