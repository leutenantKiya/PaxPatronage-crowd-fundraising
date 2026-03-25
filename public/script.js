document.querySelectorAll('.progress-fill').forEach(bar => {
    const target = bar.style.width;
    bar.style.width = '0';
    requestAnimationFrame(() => {
      requestAnimationFrame(() => { bar.style.width = target; });
    });
});