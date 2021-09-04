// Slider Image Product
let thumbnails = document.getElementsByClassName("thumbnail");
let activeImages = document.getElementsByClassName("thumb-active");
let magnifyingArea = document.getElementById("magnifying_area");
let image = document.getElementById("featured");

// Hover Switch Image
for (let i = 0; i < thumbnails.length; i++) {
  thumbnails[i].addEventListener("mouseover", function () {
    if (activeImages.length > 0) {
      activeImages[0].classList.remove("thumb-active");
    }
    this.classList.add("thumb-active");
    image.src = this.src;
  });
  thumbnails[i].addEventListener("click", function () {
    if (activeImages.length > 0) {
      activeImages[0].classList.remove("thumb-active");
    }
    this.classList.add("thumb-active");
    image.src = this.src;
  });
}
