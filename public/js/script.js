var navbar_responsive = document.getElementById("top");

document.querySelectorAll('.progress-fill').forEach(bar => {
    const target = bar.style.width;
    bar.style.width = '0';
    requestAnimationFrame(() => {
      requestAnimationFrame(() => { bar.style.width = target; });
    });
});

function responsive_navbar(){
  if (navbar_responsive.className === "top"){
    navbar_responsive.className += " responsive";
  }else{
    navbar_responsive.className = "top";
  }
}

const profilePicture = document.getElementById("profile-picture");
const profileToggle = document.getElementById("profile-toggle");

if (profilePicture && profileToggle) {
  profileToggle.addEventListener("click", event => {
    event.stopPropagation();
    const isOpen = profilePicture.classList.toggle("open");
    profileToggle.setAttribute("aria-expanded", isOpen);
  });

  document.addEventListener("click", event => {
    if (!profilePicture.contains(event.target)) {
      profilePicture.classList.remove("open");
      profileToggle.setAttribute("aria-expanded", "false");
    }
  });
}