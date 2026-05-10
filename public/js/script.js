document.querySelectorAll('.progress-fill, .detail-progress-fill').forEach(bar => {
    const target = bar.style.width;
    bar.style.width = '0';
    requestAnimationFrame(() => {
      requestAnimationFrame(() => { bar.style.width = target; });
    });
});

// mobile view nav
function getNav() {
  return document.getElementById("top") || document.getElementById("main-nav");
}

// responsive nav
function responsive_navbar() {
  // Capture event dari window.event biar bisa stopPropagation walau dipanggil
  // tanpa arg dari inline onclick.
  var e = window.event;
  if (e) e.stopPropagation();
  var nav = getNav();
  if (nav) nav.classList.toggle("is-open");
}

var hamburgerBtn = document.querySelector(".hamburger-btn");

// Tutup menu otomatis kalau user klik di luar nav (UX standar mobile menu).
document.addEventListener("click", function (e) {
  var nav = getNav();
  if (!nav || !nav.classList.contains("is-open")) return;
  // Klik di dalam nav atau hamburger button -> jangan tutup
  if (nav.contains(e.target)) return;
  if (hamburgerBtn && hamburgerBtn.contains(e.target)) return;
  nav.classList.remove("is-open");
});

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
    

// document.querySelector(".amount-input").addEventListener("click", function(e){
//     console.log()
// })






