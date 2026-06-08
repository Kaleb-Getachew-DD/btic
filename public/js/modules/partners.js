window.BticInit = window.BticInit || {};

window.BticInit.initPartners = function initPartners() {
  const modal = document.getElementById('partnersModal');
  const openBtn = document.getElementById('partnersLearnMoreBtn');
  const closeBtn = document.getElementById('partnersModalClose');
  const backdrop = document.getElementById('partnersModalBackdrop');
  const stage = document.getElementById('partnersModalStage');

  if (!modal) return;

  const openModal = () => {
    modal.classList.add('partners-modal--open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  };

  const closeModal = () => {
    modal.classList.remove('partners-modal--open');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  };

  openBtn?.addEventListener('click', openModal);
  closeBtn?.addEventListener('click', closeModal);
  backdrop?.addEventListener('click', closeModal);
  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && modal.classList.contains('partners-modal--open')) {
      closeModal();
    }
  });

  if (!stage || window.matchMedia('(max-width: 768px)').matches) return;

  stage.querySelectorAll('[data-tilt]').forEach((card) => {
    card.addEventListener('mousemove', (event) => {
      const rect = card.getBoundingClientRect();
      const x = (event.clientX - rect.left) / rect.width - 0.5;
      const y = (event.clientY - rect.top) / rect.height - 0.5;
      card.style.transform = `rotateY(${x * 18}deg) rotateX(${y * -18}deg) translateZ(12px)`;
    });
    card.addEventListener('mouseleave', () => {
      card.style.transform = 'rotateY(0deg) rotateX(0deg) translateZ(0)';
    });
  });
};
