window.BticInit = window.BticInit || {};

window.BticInit.initMultiStepForm = function initMultiStepForm() {
  const form = document.getElementById('applicationForm');
  if (!form) return;

  const steps = Array.from(form.querySelectorAll('.form-step'));
  const progressSteps = Array.from(document.querySelectorAll('.progress-step'));
  let current = 0;

  const showStep = (index) => {
    steps.forEach((step, i) => {
      step.style.display = i === index ? 'block' : 'none';
    });
    progressSteps.forEach((progressStep, i) => {
      progressStep.classList.toggle('active', i <= index);
    });
    window.scrollTo({ top: form.offsetTop - 100, behavior: 'smooth' });
  };

  const validateStep = (index) => {
    const step = steps[index];
    const inputs = step.querySelectorAll('[required]');
    let valid = true;

    inputs.forEach((input) => {
      if (!input.value.trim()) {
        input.classList.add('is-invalid');
        valid = false;
      } else {
        input.classList.remove('is-invalid');
      }
    });

    return valid;
  };

  form.querySelectorAll('[data-next]').forEach((button) => {
    button.addEventListener('click', () => {
      if (!validateStep(current)) return;
      current += 1;
      showStep(current);
    });
  });

  form.querySelectorAll('[data-prev]').forEach((button) => {
    button.addEventListener('click', () => {
      current -= 1;
      showStep(current);
    });
  });

  form.querySelectorAll('input, select, textarea').forEach((input) => {
    input.addEventListener('input', () => input.classList.remove('is-invalid'));
  });

  showStep(0);
};
