// ============================================================
// DDU BTIC — Public Website JavaScript
// ============================================================

document.addEventListener('DOMContentLoaded', () => {
  const init = window.BticInit || {};
  [
    'initNavbarScroll',
    'initMobileMenu',
    'initActiveNavLinks',
    'initSmoothScroll',
    'initRevealAnimations',
    'initHeroParallax',
    'initCounterAnimation',
    'initAlertAutoDismiss',
    'initFilterAutoSubmit',
    'initCardHoverTilt',
    'initFilePreview',
    'initValidation',
    'initMultiStepForm',
    'initHeroCarousel',
  ].forEach((fnName) => {
    if (typeof init[fnName] === 'function') init[fnName]();
  });
});


