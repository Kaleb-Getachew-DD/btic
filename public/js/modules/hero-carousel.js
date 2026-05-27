window.BticInit = window.BticInit || {};

window.BticInit.initHeroCarousel = function initHeroCarousel() {
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
};
