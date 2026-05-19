// ============================================================
// DDU BTIC — Admin CMS JavaScript
// ============================================================

document.addEventListener('DOMContentLoaded', () => {

  // ---- Mobile Sidebar Toggle ----
  const sidebarToggle = document.getElementById('sidebarToggle');
  const adminSidebar  = document.getElementById('adminSidebar');
  const sidebarOverlay = document.getElementById('sidebarOverlay');

  if (sidebarToggle && adminSidebar) {
    sidebarToggle.addEventListener('click', () => {
      const open = adminSidebar.classList.toggle('open');
      if (sidebarOverlay) sidebarOverlay.classList.toggle('show', open);
    });
  }
  if (sidebarOverlay) {
    sidebarOverlay.addEventListener('click', () => {
      adminSidebar.classList.remove('open');
      sidebarOverlay.classList.remove('show');
    });
  }

  // ---- Active Sidebar Link ----
  const currentPath = window.location.pathname;
  document.querySelectorAll('.sidebar-link').forEach(link => {
    const href = link.getAttribute('href');
    if (href && (currentPath === href || currentPath.startsWith(href + '/'))) {
      link.classList.add('active');
    }
  });

  // ---- Auto-dismiss Alerts ----
  document.querySelectorAll('.admin-alert[data-auto-dismiss]').forEach(alert => {
    const delay = parseInt(alert.dataset.autoDismiss) || 4000;
    setTimeout(() => {
      alert.style.transition = 'opacity 0.4s, max-height 0.4s, padding 0.4s, margin 0.4s';
      alert.style.opacity = '0';
      alert.style.maxHeight = '0';
      alert.style.padding = '0';
      alert.style.marginBottom = '0';
      setTimeout(() => alert.remove(), 400);
    }, delay);
  });

  // ---- Image Upload Preview ----
  document.querySelectorAll('.image-upload-area input[type=file]').forEach(input => {
    input.addEventListener('change', function() {
      const file = this.files[0];
      if (!file || !file.type.startsWith('image/')) return;
      const area    = this.closest('.image-upload-area');
      const preview = area.querySelector('.image-preview') || createPreviewImg(area);
      const reader  = new FileReader();
      reader.onload = (e) => {
        preview.src           = e.target.result;
        preview.style.display = 'block';
      };
      reader.readAsDataURL(file);
    });

    // Drag & drop
    const area = input.closest('.image-upload-area');
    if (area) {
      area.addEventListener('dragover', (e) => { e.preventDefault(); area.style.borderColor = 'var(--crimson)'; });
      area.addEventListener('dragleave', () => { area.style.borderColor = ''; });
      area.addEventListener('drop', (e) => {
        e.preventDefault();
        area.style.borderColor = '';
        input.files = e.dataTransfer.files;
        input.dispatchEvent(new Event('change'));
      });
    }
  });

  function createPreviewImg(container) {
    const img = document.createElement('img');
    img.className = 'image-preview';
    img.style.display = 'none';
    container.appendChild(img);
    return img;
  }

  // ---- Rich Text Editor (basic contenteditable) ----
  document.querySelectorAll('.editor-area').forEach(editor => {
    const toolbar  = editor.previousElementSibling;
    const hiddenEl = document.getElementById(editor.dataset.target);

    if (toolbar && toolbar.classList.contains('editor-toolbar')) {
      toolbar.querySelectorAll('[data-cmd]').forEach(btn => {
        btn.addEventListener('click', (e) => {
          e.preventDefault();
          const cmd   = btn.dataset.cmd;
          const value = btn.dataset.value || null;
          editor.focus();
          document.execCommand(cmd, false, value);
          syncEditor();
        });
      });
    }

    function syncEditor() {
      if (hiddenEl) hiddenEl.value = editor.innerHTML;
    }

    // Sync on input
    editor.addEventListener('input', syncEditor);

    // Init content
    if (hiddenEl && hiddenEl.value) {
      editor.innerHTML = hiddenEl.value;
    }
  });

  // ---- Confirm Delete Buttons ----
  document.querySelectorAll('[data-confirm]').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const msg = btn.dataset.confirm || 'Are you sure you want to delete this item? This action cannot be undone.';
      if (!confirm(msg)) e.preventDefault();
    });
  });

  // ---- Status Option Selection ----
  document.querySelectorAll('.status-option').forEach(option => {
    option.addEventListener('click', () => {
      document.querySelectorAll('.status-option').forEach(o => o.classList.remove('selected'));
      option.classList.add('selected');
      const radio = option.querySelector('input[type=radio]');
      if (radio) radio.checked = true;
    });
  });

  // ---- Toggle Password Visibility (Login) ----
  document.querySelectorAll('.login-toggle-pwd').forEach(btn => {
    btn.addEventListener('click', () => {
      const input = btn.closest('.login-input-wrapper').querySelector('input');
      const isText = input.type === 'text';
      input.type = isText ? 'password' : 'text';
      btn.innerHTML = isText ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
    });
  });

  // ---- Dashboard Charts (Chart.js) ----
  initDashboardCharts();

  // ---- Sort Order Drag (simple up/down) ----
  document.querySelectorAll('[data-sortable]').forEach(table => {
    // Basic sort by clicking up/down buttons handled by forms
  });

  // ---- Settings Tab Navigation ----
  document.querySelectorAll('.settings-nav-item[data-tab]').forEach(item => {
    item.addEventListener('click', () => {
      const tabId = item.dataset.tab;
      document.querySelectorAll('.settings-nav-item').forEach(i => i.classList.remove('active'));
      document.querySelectorAll('.settings-tab').forEach(t => t.style.display = 'none');
      item.classList.add('active');
      const tab = document.getElementById(tabId);
      if (tab) tab.style.display = 'block';
    });
  });

  // Show first tab
  const firstTab = document.querySelector('.settings-nav-item[data-tab]');
  if (firstTab) firstTab.click();

  // ---- Notification count badge update ----
  updateNotificationBadge();

  // ---- Tags input (comma separated to visual tags) ----
  document.querySelectorAll('input[data-tags]').forEach(input => {
    const container = document.createElement('div');
    container.className = 'tags-preview';
    container.style.cssText = 'display:flex;flex-wrap:wrap;gap:6px;margin-top:8px;';
    input.parentNode.insertBefore(container, input.nextSibling);

    const renderTags = () => {
      container.innerHTML = '';
      const tags = input.value.split(',').map(t => t.trim()).filter(Boolean);
      tags.forEach(tag => {
        const span = document.createElement('span');
        span.className = 'badge badge-primary';
        span.textContent = tag;
        container.appendChild(span);
      });
    };

    input.addEventListener('input', renderTags);
    renderTags();
  });

  // ---- Icon Picker (programs & services) ----
  document.querySelectorAll('[data-icon-picker]').forEach(initIconPicker);

});

// ============================================================
// Dashboard Charts
// ============================================================
function initDashboardCharts() {
  // Applications by Status (Doughnut)
  const statusCanvas = document.getElementById('statusChart');
  if (statusCanvas && typeof Chart !== 'undefined') {
    const data = JSON.parse(statusCanvas.dataset.values || '{}');
    new Chart(statusCanvas, {
      type: 'doughnut',
      data: {
        labels: Object.keys(data).map(k => k.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())),
        datasets: [{
          data: Object.values(data),
          backgroundColor: ['#FEF3C7','#DBEAFE','#EDE9FE','#D1FAE5','#FEE2E2','#F3F4F6'],
          borderColor:     ['#F59E0B','#3B82F6','#8B5CF6','#10B981','#EF4444','#9CA3AF'],
          borderWidth: 2,
        }]
      },
      options: {
        responsive: true,
        cutout: '70%',
        plugins: {
          legend: { position: 'bottom', labels: { font: { size: 12 }, padding: 16 } }
        }
      }
    });
  }

  // Applications over time (Bar)
  const sectorCanvas = document.getElementById('sectorChart');
  if (sectorCanvas && typeof Chart !== 'undefined') {
    const data = JSON.parse(sectorCanvas.dataset.values || '{}');
    new Chart(sectorCanvas, {
      type: 'bar',
      data: {
        labels: Object.keys(data),
        datasets: [{
          label: 'Applications',
          data: Object.values(data),
          backgroundColor: 'rgba(140,29,53,0.15)',
          borderColor: '#8C1D35',
          borderWidth: 2,
          borderRadius: 6,
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
          y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#F1F5F9' } },
          x: { grid: { display: false } }
        }
      }
    });
  }
}

// ============================================================
// Notification Badge
// ============================================================
function updateNotificationBadge() {
  const badge = document.querySelector('.topbar-notif-dot');
  // badge visibility is server-rendered; this just handles fetch-polling if needed
}

// ============================================================
// Form auto-save to localStorage
// ============================================================
function initFormAutoSave(formId) {
  const form = document.getElementById(formId);
  if (!form) return;
  const key = 'btic_form_' + formId;

  // Restore
  try {
    const saved = JSON.parse(localStorage.getItem(key) || '{}');
    Object.entries(saved).forEach(([name, value]) => {
      const el = form.querySelector(`[name="${name}"]`);
      if (el && el.type !== 'file') el.value = value;
    });
  } catch {}

  // Save on input
  form.addEventListener('input', () => {
    const data = {};
    new FormData(form).forEach((v, k) => { data[k] = v; });
    localStorage.setItem(key, JSON.stringify(data));
  });

  // Clear on submit
  form.addEventListener('submit', () => localStorage.removeItem(key));
}

function initIconPicker(root) {
  const input   = root.querySelector('[data-icon-input]');
  const preview = root.querySelector('[data-icon-preview] i');
  const panel   = root.querySelector('[data-icon-picker-panel]');
  const toggle  = root.querySelector('[data-icon-picker-toggle]');
  const search  = root.querySelector('[data-icon-search]');
  const options = root.querySelectorAll('.icon-picker-option');

  if (!input || !preview) return;

  const normalizeIcon = (value) => {
    let icon = (value || '').trim().toLowerCase();
    icon = icon.replace(/^(fas|far|fab)\s+/, '');
    if (!icon) return 'fa-rocket';
    if (!icon.startsWith('fa-')) icon = 'fa-' + icon.replace(/^fa-?/, '');
    return icon;
  };

  const updatePreview = (icon) => {
    const normalized = normalizeIcon(icon);
    input.value = normalized;
    preview.className = 'fas ' + normalized;
    options.forEach((btn) => {
      btn.classList.toggle('is-selected', btn.dataset.icon === normalized);
    });
  };

  input.addEventListener('input', () => updatePreview(input.value));
  input.addEventListener('blur', () => updatePreview(input.value));

  if (toggle && panel) {
    toggle.addEventListener('click', () => {
      const open = panel.hasAttribute('hidden');
      if (open) {
        panel.removeAttribute('hidden');
        toggle.innerHTML = '<i class="fas fa-times"></i> Close';
        search?.focus();
      } else {
        panel.setAttribute('hidden', '');
        toggle.innerHTML = '<i class="fas fa-icons"></i> Browse icons';
      }
    });
  }

  options.forEach((btn) => {
    btn.addEventListener('click', () => {
      updatePreview(btn.dataset.icon);
      if (panel && toggle) {
        panel.setAttribute('hidden', '');
        toggle.innerHTML = '<i class="fas fa-icons"></i> Browse icons';
      }
    });
  });

  if (search) {
    search.addEventListener('input', () => {
      const q = search.value.trim().toLowerCase();
      options.forEach((btn) => {
        const label = btn.dataset.label || '';
        const icon  = btn.dataset.icon || '';
        const match = !q || label.includes(q) || icon.includes(q);
        btn.hidden = !match;
      });
    });
  }

  updatePreview(input.value);
}
