window.BticInit = window.BticInit || {};

window.BticInit.initNavbarScroll = function initNavbarScroll() {
  const navbar = document.querySelector('.navbar');
  if (!navbar) return;

  const onScroll = () => navbar.classList.toggle('scrolled', window.scrollY > 20);
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
};

window.BticInit.initMobileMenu = function initMobileMenu() {
  const toggle = document.getElementById('navbarToggle') || document.querySelector('.navbar-toggle');
  const mobileMenu = document.getElementById('mobileMenu') || document.querySelector('.mobile-menu');
  if (!toggle || !mobileMenu) return;

  const setState = (isOpen) => {
    mobileMenu.classList.toggle('open', isOpen);
    toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    toggle.innerHTML = isOpen ? '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
    document.body.style.overflow = isOpen ? 'hidden' : '';
  };

  toggle.addEventListener('click', (event) => {
    event.preventDefault();
    event.stopPropagation();
    setState(!mobileMenu.classList.contains('open'));
  });

  mobileMenu.addEventListener('click', (event) => {
    event.stopPropagation();
  });

  document.addEventListener('click', (event) => {
    if (!toggle.contains(event.target) && !mobileMenu.contains(event.target)) {
      setState(false);
    }
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') setState(false);
  });

  mobileMenu.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => setState(false));
  });
};

window.BticInit.initActiveNavLinks = function initActiveNavLinks() {
  const normalizePath = (href) => {
    try {
      return new URL(href, window.location.origin).pathname.replace(/\/+$/, '') || '/';
    } catch {
      return (href || '').replace(/\/+$/, '') || '/';
    }
  };

  const currentPath = window.location.pathname.replace(/\/+$/, '') || '/';

  document.querySelectorAll('.nav-link, .mobile-nav-link').forEach((link) => {
    if (link.classList.contains('active')) return;

    const linkPath = normalizePath(link.getAttribute('href') || '');
    let isActive = false;

    if (linkPath === '/') {
      isActive = currentPath === '/';
    } else if (linkPath === '/apply/track') {
      isActive = currentPath === '/apply/track';
    } else {
      isActive = currentPath === linkPath || currentPath.startsWith(`${linkPath}/`);
    }

    if (isActive) link.classList.add('active');
  });
};

window.BticInit.initSmoothScroll = function initSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener('click', (event) => {
      const target = document.querySelector(anchor.getAttribute('href'));
      if (!target) return;
      event.preventDefault();
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  });
};
