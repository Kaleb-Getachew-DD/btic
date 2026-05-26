// ============================================================
// DDU BTIC — Public Website JavaScript
// ============================================================

document.addEventListener('DOMContentLoaded', () => {

  // ---- Navbar Scroll Effect ----
  const navbar = document.querySelector('.navbar');
  if (navbar) {
    const onScroll = () => {
      navbar.classList.toggle('scrolled', window.scrollY > 20);
    };
    // ============================================================
// DDU BTIC — PREMIUM HERO CAROUSEL
// Paste this entire block INSIDE the DOMContentLoaded callback
// in public/js/app.js — right after the closing brace of
// the "Navbar Scroll Effect" block (around line 12)
// ============================================================

(function initHeroCarousel() {

  // ----- Slide data -----
  var SLIDES = [
      {
          tag:   'Pre-Incubation & Ideation',
          num:   '01',
          line1: 'Where Innovation',
          line2: 'Meets Opportunity',
          desc:  'DDU BTIC empowers bold entrepreneurs to validate ideas, build scalable products, and connect with investors — from first concept to market-ready launch.',
          label: 'Collaborative Innovation',
      },
      {
          tag:   'Core Incubation Program',
          num:   '02',
          line1: 'Empowering Tomorrow\'s',
          line2: 'Entrepreneurs',
          desc:  'Our 6-month core incubation program provides co-working space, expert mentorship, legal guidance, and direct funding pathways for high-potential startups.',
          label: 'World-Class Workspace',
      },
      {
          tag:   'Technology & R&D Access',
          num:   '03',
          line1: 'Technology-Driven',
          line2: 'Transformation',
          desc:  'Leverage Dire Dawa University\'s research infrastructure, cloud computing credits, software licenses, and academic expertise to build better products faster.',
          label: 'Technology at the Core',
      },
      {
          tag:   'Investment & Market Access',
          num:   '04',
          line1: 'Connecting Ideas',
          line2: 'to Capital',
          desc:  'Access our network of angel investors, venture capital firms, and Demo Day platforms. Our alumni have raised over $1M USD in cumulative funding.',
          label: 'Pitch to Investors',
      },
      {
          tag:   'Mentorship & Growth',
          num:   '05',
          line1: 'Building East Africa\'s',
          line2: 'Future Leaders',
          desc:  'Join 200+ mentors, 60+ successful alumni startups, and a thriving community of founders building solutions that serve Ethiopia and beyond.',
          label: 'Expert Mentorship',
      },
  ];

  var currentSlide = 0;
  var totalSlides  = SLIDES.length;
  var AUTO_INTERVAL = 7000;
  var autoTimer = null;
  var isAutoPaused = false;

  // ----- DOM refs -----
  var stage     = document.getElementById('heroStage');
  var heroEl    = document.getElementById('heroSection');
  var tagEl     = document.getElementById('heroTagText');
  var counterEl = document.getElementById('heroCounterCurrent');
  var line1El   = document.getElementById('heroLine1');
  var line2El   = document.getElementById('heroLine2');
  var descEl    = document.getElementById('heroDesc');
  var dotsEl    = document.getElementById('heroDots');
  var prevBtn   = document.getElementById('heroPrev');
  var nextBtn   = document.getElementById('heroNext');
  var labelEl   = document.getElementById('heroCarouselLabel');
  var particles   = document.getElementById('heroParticles');

  if (!stage) return; // Hero not on this page

  var cards = Array.from(stage.querySelectorAll('.btic-hero__card'));
  var dots  = dotsEl ? Array.from(dotsEl.querySelectorAll('.btic-hero__dot')) : [];

  // ----- Particle system -----
  function spawnParticle() {
      if (!particles) return;
      var p = document.createElement('div');
      p.className = 'btic-hero__particle';
      var size = Math.random() * 3 + 1;
      var left = Math.random() * 100;
      var delay = Math.random() * 0;
      var dur   = Math.random() * 12 + 10;
      p.style.cssText = [
          'width:' + size + 'px',
          'height:' + size + 'px',
          'left:' + left + '%',
          'bottom:-10px',
          'animation-duration:' + dur + 's',
          'animation-delay:' + delay + 's',
          'opacity:' + (Math.random() * 0.5 + 0.2),
      ].join(';');
      particles.appendChild(p);
      setTimeout(function () { if (p.parentNode) p.parentNode.removeChild(p); }, (dur + 2) * 1000);
  }
  var particleInterval = setInterval(spawnParticle, 800);
  for (var pi = 0; pi < 8; pi++) spawnParticle(); // initial burst

  // ----- Position helpers -----
  // Returns pos relative to activeIndex: 0=front, 1=right1, -1=left1, 2=right2, -2=left2
  function getPosForIndex(cardIndex, activeIndex) {
      var diff = cardIndex - activeIndex;
      // wrap around
      if (diff > totalSlides / 2)  diff -= totalSlides;
      if (diff < -totalSlides / 2) diff += totalSlides;
      // clamp to visible range
      if (diff > 2)  diff = 2;
      if (diff < -2) diff = -2;
      return diff;
  }

  function applyPositions(activeIndex) {
      cards.forEach(function (card, i) {
          var pos = getPosForIndex(i, activeIndex);
          card.setAttribute('data-pos', String(pos));
      });
  }

  // ----- Text update -----
  function updateText(slideIndex, direction) {
      var data = SLIDES[slideIndex];

      // Tag & counter — instant
      if (tagEl)     tagEl.textContent    = data.tag;
      if (counterEl) counterEl.textContent = data.num;
      if (labelEl)   labelEl.textContent   = data.label;

      // Headline animation
      if (line1El && line2El) {
          var exitClass  = 'is-exiting';
          var enterClass = 'is-entering';
          line1El.classList.add(exitClass);
          line2El.classList.add(exitClass);
          setTimeout(function () {
              line1El.textContent = data.line1;
              line2El.textContent = data.line2;
              line1El.classList.remove(exitClass);
              line2El.classList.remove(exitClass);
              line1El.classList.add(enterClass);
              line2El.classList.add(enterClass);
              // Trigger reflow
              void line1El.offsetHeight;
              line1El.classList.remove(enterClass);
              line2El.classList.remove(enterClass);
          }, 280);
      }

      // Description fade
      if (descEl) {
          descEl.classList.add('is-transitioning');
          setTimeout(function () {
              descEl.textContent = data.desc;
              descEl.classList.remove('is-transitioning');
          }, 250);
      }

      // Dots
      dots.forEach(function (dot, i) {
          dot.classList.toggle('btic-hero__dot--active', i === slideIndex);
      });
  }

  // ----- Go to slide -----
  function goToSlide(index, direction) {
      if (index === currentSlide) return;
      currentSlide = index;
      applyPositions(currentSlide);
      updateText(currentSlide, direction);
  }

  function nextSlide() {
      goToSlide((currentSlide + 1) % totalSlides, 1);
  }

  function prevSlide() {
      goToSlide((currentSlide - 1 + totalSlides) % totalSlides, -1);
  }

  // ----- Auto-play (every 7s, loops continuously) -----
  function startAutoPlay() {
      stopAutoPlay();
      if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
      autoTimer = setInterval(function () {
          if (document.hidden || isAutoPaused) return;
          nextSlide();
      }, AUTO_INTERVAL);
  }

  function stopAutoPlay() {
      if (autoTimer) {
          clearInterval(autoTimer);
          autoTimer = null;
      }
  }

  function resetAutoPlay() {
      stopAutoPlay();
      startAutoPlay();
  }

  // ----- Init -----
  applyPositions(0);
  updateText(0, 1);
  startAutoPlay();

  // ----- Controls -----
  if (prevBtn) {
      prevBtn.addEventListener('click', function () {
          prevSlide();
          resetAutoPlay();
      });
  }
  if (nextBtn) {
      nextBtn.addEventListener('click', function () {
          nextSlide();
          resetAutoPlay();
      });
  }

  // Dot clicks
  dots.forEach(function (dot, i) {
      dot.addEventListener('click', function () {
          goToSlide(i, i > currentSlide ? 1 : -1);
          resetAutoPlay();
      });
  });

  // Card clicks — select a slide manually
  cards.forEach(function (card, i) {
      card.addEventListener('click', function () {
          if (i !== currentSlide) {
              goToSlide(i, i > currentSlide ? 1 : -1);
              resetAutoPlay();
          }
      });
  });

  // ----- Keyboard -----
  document.addEventListener('keydown', function (e) {
      if (!stage) return;
      if (e.key === 'ArrowRight') { nextSlide(); resetAutoPlay(); }
      if (e.key === 'ArrowLeft')  { prevSlide(); resetAutoPlay(); }
  });

  // ----- Touch / swipe -----
  var touchStartX = 0;
  var touchStartY = 0;
  stage.addEventListener('touchstart', function (e) {
      touchStartX = e.touches[0].clientX;
      touchStartY = e.touches[0].clientY;
  }, { passive: true });
  stage.addEventListener('touchend', function (e) {
      var dx = e.changedTouches[0].clientX - touchStartX;
      var dy = e.changedTouches[0].clientY - touchStartY;
      if (Math.abs(dx) > Math.abs(dy) && Math.abs(dx) > 40) {
          if (dx < 0) nextSlide();
          else        prevSlide();
          resetAutoPlay();
      }
  }, { passive: true });

  // Pause auto-play while hovering (resume when mouse leaves)
  if (heroEl) {
      heroEl.addEventListener('mouseenter', function () {
          isAutoPaused = true;
      });
      heroEl.addEventListener('mouseleave', function () {
          isAutoPaused = false;
          resetAutoPlay();
      });
      heroEl.addEventListener('focusin', function () {
          isAutoPaused = true;
      });
      heroEl.addEventListener('focusout', function (e) {
          if (!heroEl.contains(e.relatedTarget)) {
              isAutoPaused = false;
              resetAutoPlay();
          }
      });
  }

  // ----- Cleanup on page hide -----
  document.addEventListener('visibilitychange', function () {
      if (document.hidden) {
          stopAutoPlay();
          clearInterval(particleInterval);
      } else {
          startAutoPlay();
          particleInterval = setInterval(spawnParticle, 800);
      }
  });

})(); // end initHeroCarousel IIFE
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  // ---- Mobile Menu ----
  const toggle   = document.querySelector('.navbar-toggle');
  const mobileMenu = document.querySelector('.mobile-menu');
  if (toggle && mobileMenu) {
    toggle.addEventListener('click', () => {
      const open = mobileMenu.classList.toggle('open');
      toggle.innerHTML = open
        ? '<i class="fas fa-times"></i>'
        : '<i class="fas fa-bars"></i>';
      document.body.style.overflow = open ? 'hidden' : '';
    });

    // Close on outside click
    document.addEventListener('click', (e) => {
      if (!toggle.contains(e.target) && !mobileMenu.contains(e.target)) {
        mobileMenu.classList.remove('open');
        toggle.innerHTML = '<i class="fas fa-bars"></i>';
        document.body.style.overflow = '';
      }
    });
  }

  // ---- Active Nav Link ----
  const currentPath = window.location.pathname;
  document.querySelectorAll('.nav-link, .mobile-nav-link').forEach(link => {
    if (link.getAttribute('href') === currentPath) {
      link.classList.add('active');
    }
  });

  // ---- Smooth Scroll ----
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', (e) => {
      const target = document.querySelector(anchor.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  // ---- Intersection Observer: Animate on scroll ----
  const animateEls = document.querySelectorAll(
    '.program-card, .startup-card, .news-card, .service-card, .team-card, .stat-item, .value-card'
  );

  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry, index) => {
          if (entry.isIntersecting) {
            setTimeout(() => {
              entry.target.style.opacity  = '1';
              entry.target.style.transform = 'translateY(0)';
            }, index * 80);
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.1, rootMargin: '0px 0px -40px 0px' }
    );

    animateEls.forEach((el) => {
      el.style.opacity   = '0';
      el.style.transform = 'translateY(30px)';
      el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
      observer.observe(el);
    });
  }

  // ---- 3D Hero Card Mouse Parallax ----
  const heroCard = document.querySelector('.hero-3d-card');
  if (heroCard) {
    document.addEventListener('mousemove', (e) => {
      const { clientX, clientY } = e;
      const { innerWidth, innerHeight } = window;
      const xRot = ((clientY / innerHeight) - 0.5) * 10;
      const yRot = ((clientX / innerWidth)  - 0.5) * -15;
      heroCard.style.transform = `rotateX(${xRot}deg) rotateY(${yRot}deg)`;
    });
    document.addEventListener('mouseleave', () => {
      heroCard.style.transform = 'rotateY(-8deg) rotateX(4deg)';
    });
  }

  // ---- Counter Animation (Stats) ----
  const counters = document.querySelectorAll('[data-count]');
  if (counters.length && 'IntersectionObserver' in window) {
    const counterObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            animateCounter(entry.target);
            counterObserver.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.5 }
    );
    counters.forEach(el => counterObserver.observe(el));
  }

  function animateCounter(el) {
    const target = parseFloat(el.dataset.count);
    const suffix = el.dataset.suffix || '';
    const prefix = el.dataset.prefix || '';
    const duration = 2000;
    const start = performance.now();

    const update = (time) => {
      const elapsed  = time - start;
      const progress = Math.min(elapsed / duration, 1);
      const ease     = 1 - Math.pow(1 - progress, 4);
      const current  = Math.floor(ease * target);
      el.textContent = prefix + current.toLocaleString() + suffix;
      if (progress < 1) requestAnimationFrame(update);
      else el.textContent = prefix + target.toLocaleString() + suffix;
    };
    requestAnimationFrame(update);
  }

  // ---- Alert auto-dismiss ----
  document.querySelectorAll('.alert[data-auto-dismiss]').forEach(alert => {
    const delay = parseInt(alert.dataset.autoDismiss) || 5000;
    setTimeout(() => {
      alert.style.transition = 'opacity 0.5s ease, max-height 0.5s ease';
      alert.style.opacity = '0';
      alert.style.maxHeight = '0';
      alert.style.overflow = 'hidden';
      setTimeout(() => alert.remove(), 500);
    }, delay);
  });

  // ---- Application Form Multi-Step ----
  initMultiStepForm();

  // ---- Filter Forms Auto-submit ----
  document.querySelectorAll('select[data-auto-submit]').forEach(select => {
    select.addEventListener('change', () => select.closest('form').submit());
  });

  // ---- Startup card 3D hover ----
  document.querySelectorAll('.startup-card, .program-card').forEach(card => {
    card.addEventListener('mousemove', (e) => {
      const rect   = card.getBoundingClientRect();
      const x      = e.clientX - rect.left;
      const y      = e.clientY - rect.top;
      const centerX = rect.width  / 2;
      const centerY = rect.height / 2;
      const rotateX = (y - centerY) / centerY * -4;
      const rotateY = (x - centerX) / centerX *  4;
      card.style.transform = `perspective(800px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-6px)`;
    });
    card.addEventListener('mouseleave', () => {
      card.style.transform = '';
    });
  });

  // ---- File input preview ----
  document.querySelectorAll('input[type=file][data-preview]').forEach(input => {
    input.addEventListener('change', () => {
      const file = input.files[0];
      if (!file) return;
      const previewId = input.dataset.preview;
      const preview   = document.getElementById(previewId);
      if (!preview) return;
      const reader = new FileReader();
      reader.onload = (e) => {
        preview.src = e.target.result;
        preview.style.display = 'block';
      };
      reader.readAsDataURL(file);
    });
  });

  // ---- Form validation feedback ----
  document.querySelectorAll('form.needs-validation').forEach(form => {
    form.addEventListener('submit', (e) => {
      if (!form.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
      }
      form.classList.add('was-validated');
    });
  });

});

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


