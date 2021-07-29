/*===== CHANGE COLOR HEADER =====*/
window.onscroll = () => {
  const nav = document.getElementById("navbar");
  if (this.scrollY >= 450) {
    nav.classList.add("scroll-navbar");
  } else {
    nav.classList.remove("scroll-navbar");
  }
};
