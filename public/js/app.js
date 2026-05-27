// ============================================================
// DDU BTIC — Public Website JavaScript
// ============================================================

document.addEventListener('DOMContentLoaded', () => {
  initNavbarScroll();
  initMobileMenu();
  initActiveNavLinks();
  initSmoothScroll();
  initRevealAnimations();
  initHeroParallax();
  initCounterAnimation();
  initAlertAutoDismiss();
  initFilterAutoSubmit();
  initCardHoverTilt();
  initFilePreview();
  initValidation();
  initMultiStepForm();
  initHeroCarousel();
});

function initNavbarScroll() {
  const navbar = document.querySelector('.navbar');
  if (!navbar) return;

  const onScroll = () => navbar.classList.toggle('scrolled', window.scrollY > 20);
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
}

function initMobileMenu() {
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
}

function initActiveNavLinks() {
  const currentPath = window.location.pathname.replace(/\/+$/, '') || '/';
  document.querySelectorAll('.nav-link, .mobile-nav-link').forEach((link) => {
    const href = (link.getAttribute('href') || '').replace(/\/+$/, '') || '/';
    if (href === currentPath) link.classList.add('active');
  });
}

function initSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener('click', (event) => {
      const target = document.querySelector(anchor.getAttribute('href'));
      if (!target) return;
      event.preventDefault();
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  });
}

function initRevealAnimations() {
  const animateElements = document.querySelectorAll(
    '.program-card, .startup-card, .news-card, .service-card, .team-card, .stat-item, .value-card'
  );
  if (!animateElements.length || !('IntersectionObserver' in window)) return;

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
        observer.unobserve(entry.target);
      });
    },
    { threshold: 0.1, rootMargin: '0px 0px -40px 0px' }
  );

  animateElements.forEach((element) => {
    element.style.opacity = '0';
    element.style.transform = 'translateY(30px)';
    element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(element);
  });
}

function initHeroParallax() {
  const heroCard = document.querySelector('.hero-3d-card');
  if (!heroCard || window.matchMedia('(max-width: 1024px)').matches) return;

  document.addEventListener('mousemove', (event) => {
    const xRot = (event.clientY / window.innerHeight - 0.5) * 10;
    const yRot = (event.clientX / window.innerWidth - 0.5) * -15;
    heroCard.style.transform = `rotateX(${xRot}deg) rotateY(${yRot}deg)`;
  });

  document.addEventListener('mouseleave', () => {
    heroCard.style.transform = 'rotateY(-8deg) rotateX(4deg)';
  });
}

function initCounterAnimation() {
  const counters = document.querySelectorAll('[data-count]');
  if (!counters.length || !('IntersectionObserver' in window)) return;

  const animateCounter = (element) => {
    const target = Number.parseFloat(element.dataset.count || '0');
    if (Number.isNaN(target)) return;

    const suffix = element.dataset.suffix || '';
    const prefix = element.dataset.prefix || '';
    const duration = 2000;
    const start = performance.now();

    const update = (time) => {
      const progress = Math.min((time - start) / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 4);
      const current = Math.floor(eased * target);
      element.textContent = `${prefix}${current.toLocaleString()}${suffix}`;
      if (progress < 1) requestAnimationFrame(update);
      else element.textContent = `${prefix}${target.toLocaleString()}${suffix}`;
    };

    requestAnimationFrame(update);
  };

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        animateCounter(entry.target);
        observer.unobserve(entry.target);
      });
    },
    { threshold: 0.5 }
  );

  counters.forEach((counter) => observer.observe(counter));
}

function initAlertAutoDismiss() {
  document.querySelectorAll('.alert[data-auto-dismiss]').forEach((alert) => {
    const delay = Number.parseInt(alert.dataset.autoDismiss || '5000', 10);
    window.setTimeout(() => {
      alert.style.transition = 'opacity 0.5s ease, max-height 0.5s ease';
      alert.style.opacity = '0';
      alert.style.maxHeight = '0';
      alert.style.overflow = 'hidden';
      window.setTimeout(() => alert.remove(), 500);
    }, Number.isNaN(delay) ? 5000 : delay);
  });
}

function initFilterAutoSubmit() {
  document.querySelectorAll('select[data-auto-submit]').forEach((select) => {
    select.addEventListener('change', () => {
      const form = select.closest('form');
      if (form) form.submit();
    });
  });
}

function initCardHoverTilt() {
  if (window.matchMedia('(max-width: 1024px)').matches) return;

  document.querySelectorAll('.startup-card, .program-card').forEach((card) => {
    card.addEventListener('mousemove', (event) => {
      const rect = card.getBoundingClientRect();
      const x = event.clientX - rect.left;
      const y = event.clientY - rect.top;
      const centerX = rect.width / 2;
      const centerY = rect.height / 2;
      const rotateX = ((y - centerY) / centerY) * -4;
      const rotateY = ((x - centerX) / centerX) * 4;
      card.style.transform = `perspective(800px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-6px)`;
    });

    card.addEventListener('mouseleave', () => {
      card.style.transform = '';
    });
  });
}

function initFilePreview() {
  document.querySelectorAll('input[type=file][data-preview]').forEach((input) => {
    input.addEventListener('change', () => {
      const file = input.files && input.files[0];
      if (!file) return;
      const preview = document.getElementById(input.dataset.preview || '');
      if (!preview) return;

      const reader = new FileReader();
      reader.onload = (event) => {
        preview.src = event.target.result;
        preview.style.display = 'block';
      };
      reader.readAsDataURL(file);
    });
  });
}

function initValidation() {
  document.querySelectorAll('form.needs-validation').forEach((form) => {
    form.addEventListener('submit', (event) => {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    });
  });
}

function initHeroCarousel() {
  const stage = document.getElementById('heroStage');
  if (!stage) return;

  const slides = [
    {
      tag: 'Pre-Incubation & Ideation',
      num: '01',
      line1: 'Where Innovation',
      line2: 'Meets Opportunity',
      desc: 'DDU BTIC empowers bold entrepreneurs to validate ideas, build scalable products, and connect with investors — from first concept to market-ready launch.',
      label: 'Collaborative Innovation',
    },
    {
      tag: 'Core Incubation Program',
      num: '02',
      line1: "Empowering Tomorrow's",
      line2: 'Entrepreneurs',
      desc: 'Our 6-month core incubation program provides co-working space, expert mentorship, legal guidance, and direct funding pathways for high-potential startups.',
      label: 'World-Class Workspace',
    },
    {
      tag: 'Technology & R&D Access',
      num: '03',
      line1: 'Technology-Driven',
      line2: 'Transformation',
      desc: "Leverage Dire Dawa University's research infrastructure, cloud computing credits, software licenses, and academic expertise to build better products faster.",
      label: 'Technology at the Core',
    },
    {
      tag: 'Investment & Market Access',
      num: '04',
      line1: 'Connecting Ideas',
      line2: 'to Capital',
      desc: 'Access our network of angel investors, venture capital firms, and Demo Day platforms. Our alumni have raised over $1M USD in cumulative funding.',
      label: 'Pitch to Investors',
    },
    {
      tag: 'Mentorship & Growth',
      num: '05',
      line1: "Building East Africa's",
      line2: 'Future Leaders',
      desc: 'Join 200+ mentors, 60+ successful alumni startups, and a thriving community of founders building solutions that serve Ethiopia and beyond.',
      label: 'Expert Mentorship',
    },
  ];

  const hero = document.getElementById('heroSection');
  const tagEl = document.getElementById('heroTagText');
  const counterEl = document.getElementById('heroCounterCurrent');
  const line1El = document.getElementById('heroLine1');
  const line2El = document.getElementById('heroLine2');
  const descEl = document.getElementById('heroDesc');
  const dotsWrap = document.getElementById('heroDots');
  const prevBtn = document.getElementById('heroPrev');
  const nextBtn = document.getElementById('heroNext');
  const labelEl = document.getElementById('heroCarouselLabel');
  const particles = document.getElementById('heroParticles');

  const cards = Array.from(stage.querySelectorAll('.btic-hero__card'));
  const dots = dotsWrap ? Array.from(dotsWrap.querySelectorAll('.btic-hero__dot')) : [];
  const totalSlides = slides.length;
  let currentSlide = 0;
  let autoTimer = null;
  let particleTimer = null;
  let paused = false;
  const autoInterval = 7000;

  const spawnParticle = () => {
    if (!particles) return;
    const particle = document.createElement('div');
    const size = Math.random() * 3 + 1;
    const duration = Math.random() * 12 + 10;
    particle.className = 'btic-hero__particle';
    particle.style.cssText = `width:${size}px;height:${size}px;left:${Math.random() * 100}%;bottom:-10px;animation-duration:${duration}s;opacity:${Math.random() * 0.5 + 0.2}`;
    particles.appendChild(particle);
    window.setTimeout(() => particle.remove(), (duration + 2) * 1000);
  };

  const getPosition = (cardIndex, activeIndex) => {
    let diff = cardIndex - activeIndex;
    if (diff > totalSlides / 2) diff -= totalSlides;
    if (diff < -totalSlides / 2) diff += totalSlides;
    return Math.max(-2, Math.min(2, diff));
  };

  const applyPositions = () => {
    cards.forEach((card, index) => {
      card.setAttribute('data-pos', String(getPosition(index, currentSlide)));
    });
  };

  const updateText = () => {
    const data = slides[currentSlide];
    if (tagEl) tagEl.textContent = data.tag;
    if (counterEl) counterEl.textContent = data.num;
    if (labelEl) labelEl.textContent = data.label;

    if (line1El && line2El) {
      line1El.classList.add('is-exiting');
      line2El.classList.add('is-exiting');
      window.setTimeout(() => {
        line1El.textContent = data.line1;
        line2El.textContent = data.line2;
        line1El.classList.remove('is-exiting');
        line2El.classList.remove('is-exiting');
        line1El.classList.add('is-entering');
        line2El.classList.add('is-entering');
        void line1El.offsetHeight;
        line1El.classList.remove('is-entering');
        line2El.classList.remove('is-entering');
      }, 280);
    }

    if (descEl) {
      descEl.classList.add('is-transitioning');
      window.setTimeout(() => {
        descEl.textContent = data.desc;
        descEl.classList.remove('is-transitioning');
      }, 250);
    }

    dots.forEach((dot, index) => {
      dot.classList.toggle('btic-hero__dot--active', index === currentSlide);
    });
  };

  const goToSlide = (nextIndex) => {
    if (nextIndex === currentSlide) return;
    currentSlide = nextIndex;
    applyPositions();
    updateText();
  };

  const nextSlide = () => goToSlide((currentSlide + 1) % totalSlides);
  const prevSlide = () => goToSlide((currentSlide - 1 + totalSlides) % totalSlides);

  const stopAutoPlay = () => {
    if (autoTimer) {
      window.clearInterval(autoTimer);
      autoTimer = null;
    }
  };

  const startAutoPlay = () => {
    stopAutoPlay();
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    autoTimer = window.setInterval(() => {
      if (document.hidden || paused) return;
      nextSlide();
    }, autoInterval);
  };

  const restartAutoPlay = () => {
    stopAutoPlay();
    startAutoPlay();
  };

  const startParticles = () => {
    if (!particles) return;
    for (let index = 0; index < 8; index += 1) spawnParticle();
    particleTimer = window.setInterval(spawnParticle, 800);
  };

  const stopParticles = () => {
    if (!particleTimer) return;
    window.clearInterval(particleTimer);
    particleTimer = null;
  };

  applyPositions();
  updateText();
  startAutoPlay();
  startParticles();

  if (prevBtn) {
    prevBtn.addEventListener('click', () => {
      prevSlide();
      restartAutoPlay();
    });
  }

  if (nextBtn) {
    nextBtn.addEventListener('click', () => {
      nextSlide();
      restartAutoPlay();
    });
  }

  dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
      goToSlide(index);
      restartAutoPlay();
    });
  });

  cards.forEach((card, index) => {
    card.addEventListener('click', () => {
      goToSlide(index);
      restartAutoPlay();
    });
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'ArrowRight') {
      nextSlide();
      restartAutoPlay();
    } else if (event.key === 'ArrowLeft') {
      prevSlide();
      restartAutoPlay();
    }
  });

  let touchStartX = 0;
  let touchStartY = 0;
  stage.addEventListener(
    'touchstart',
    (event) => {
      touchStartX = event.touches[0].clientX;
      touchStartY = event.touches[0].clientY;
    },
    { passive: true }
  );

  stage.addEventListener(
    'touchend',
    (event) => {
      const deltaX = event.changedTouches[0].clientX - touchStartX;
      const deltaY = event.changedTouches[0].clientY - touchStartY;
      if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > 40) {
        if (deltaX < 0) nextSlide();
        else prevSlide();
        restartAutoPlay();
      }
    },
    { passive: true }
  );

  if (hero) {
    hero.addEventListener('mouseenter', () => {
      paused = true;
    });
    hero.addEventListener('mouseleave', () => {
      paused = false;
      restartAutoPlay();
    });
    hero.addEventListener('focusin', () => {
      paused = true;
    });
    hero.addEventListener('focusout', (event) => {
      if (!hero.contains(event.relatedTarget)) {
        paused = false;
        restartAutoPlay();
      }
    });
  }

  document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
      stopAutoPlay();
      stopParticles();
    } else {
      startAutoPlay();
      startParticles();
    }
  });
}

// ============================================================
// Multi-Step Application Form
// ============================================================
function initMultiStepForm() {
  const form  = document.getElementById('applicationForm');
  if (!form) return;

  const steps = Array.from(form.querySelectorAll('.form-step'));
  const progressSteps = Array.from(document.querySelectorAll('.progress-step'));
  let current = 0;

  function showStep(index) {
    steps.forEach((step, i) => {
      step.style.display = i === index ? 'block' : 'none';
    });
    progressSteps.forEach((ps, i) => {
      ps.classList.toggle('active', i <= index);
    });
    window.scrollTo({ top: form.offsetTop - 100, behavior: 'smooth' });
  }

  function validateStep(index) {
    const step    = steps[index];
    const inputs  = step.querySelectorAll('[required]');
    let valid = true;
    inputs.forEach(input => {
      if (!input.value.trim()) {
        input.classList.add('is-invalid');
        valid = false;
      } else {
        input.classList.remove('is-invalid');
      }
    });
    return valid;
  }

  form.querySelectorAll('[data-next]').forEach(btn => {
    btn.addEventListener('click', () => {
      if (validateStep(current)) {
        current++;
        showStep(current);
      }
    });
  });

  form.querySelectorAll('[data-prev]').forEach(btn => {
    btn.addEventListener('click', () => {
      current--;
      showStep(current);
    });
  });

  // Remove invalid on input
  form.querySelectorAll('input, select, textarea').forEach(input => {
    input.addEventListener('input', () => input.classList.remove('is-invalid'));
  });

  showStep(0);
}


