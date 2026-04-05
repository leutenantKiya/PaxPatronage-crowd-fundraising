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
    navbar_responsive.className += "top";
  }
}