function visible() {
  let pass = document.getElementById("password");
  let icon = document.getElementById("pass-icon");
  if (pass.type === "password") {
    pass.type = "text";
    icon.classList.add("pass-icon2");
  } else {
    pass.type = "password";
    icon.classList.remove("pass-icon2");
  }
}

function visible2() {
  let pass = document.getElementById("verify");
  let icon = document.getElementById("verify-icon");
  if (pass.type === "password") {
    pass.type = "text";
    icon.classList.add("pass-icon2");
  } else {
    pass.type = "password";
    icon.classList.remove("pass-icon2");
  }
}
