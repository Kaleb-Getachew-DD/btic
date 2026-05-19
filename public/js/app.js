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
