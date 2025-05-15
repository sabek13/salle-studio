const burger = document.getElementById('burger');
const nav = document.getElementById('main-nav');

burger.addEventListener('click', () => {
  nav.classList.toggle('active');
});

document.addEventListener('DOMContentLoaded', function() {
  // Add a class to the body that indicates hover capability
  // This helps differentiate between touch-only and touch+hover devices
  const hasHoverSupport = window.matchMedia('(hover: hover)').matches;
  if (hasHoverSupport) {
    document.body.classList.add('has-hover');
  }
});