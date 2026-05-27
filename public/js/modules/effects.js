window.BticInit = window.BticInit || {};

window.BticInit.initRevealAnimations = function initRevealAnimations() {
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
};

window.BticInit.initHeroParallax = function initHeroParallax() {
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
};

window.BticInit.initCounterAnimation = function initCounterAnimation() {
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
};

window.BticInit.initAlertAutoDismiss = function initAlertAutoDismiss() {
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
};

window.BticInit.initFilterAutoSubmit = function initFilterAutoSubmit() {
  document.querySelectorAll('select[data-auto-submit]').forEach((select) => {
    select.addEventListener('change', () => {
      const form = select.closest('form');
      if (form) form.submit();
    });
  });
};

window.BticInit.initCardHoverTilt = function initCardHoverTilt() {
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
};

window.BticInit.initFilePreview = function initFilePreview() {
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
};

window.BticInit.initValidation = function initValidation() {
  document.querySelectorAll('form.needs-validation').forEach((form) => {
    form.addEventListener('submit', (event) => {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    });
  });
};
