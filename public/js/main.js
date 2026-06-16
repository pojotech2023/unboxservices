/* ══ DESKTOP DROPDOWNS ══ */
document.querySelectorAll('.menu-item').forEach(item => {
  const btn = item.querySelector('.menu-btn');
  if (!btn) return;
  btn.addEventListener('click', e => {
    e.stopPropagation();
    const wasOpen = item.classList.contains('open');
    // Close all
    document.querySelectorAll('.menu-item.open').forEach(i => i.classList.remove('open'));
    if (!wasOpen) item.classList.add('open');
  });
});
document.addEventListener('click', () => {
  document.querySelectorAll('.menu-item.open').forEach(i => i.classList.remove('open'));
});

/* ══ MEGA DROPDOWN LEFT PANEL HOVER ══ */
/* ══ MEGA DROPDOWN LEFT PANEL HOVER ══ */
document.querySelectorAll('.dropdown.mega').forEach(mega => {

  const leftItems = mega.querySelectorAll('.dd-left-item[data-panel]');
  const rightPanels = mega.querySelectorAll('.dd-right');

  // When mega opens → hide all right panels
  const parentMenu = mega.closest('.menu-item');
  const btn = parentMenu.querySelector('.menu-btn');

  btn.addEventListener('click', () => {
    rightPanels.forEach(p => p.classList.remove('show'));
    leftItems.forEach(i => i.classList.remove('active'));
  });

  // Hover effect
  leftItems.forEach(item => {
    item.addEventListener('mouseenter', () => {

      // Remove active + hide panels
      leftItems.forEach(i => i.classList.remove('active'));
      rightPanels.forEach(p => p.classList.remove('show'));

      // Activate current
      item.classList.add('active');
      const panel = mega.querySelector('#' + item.dataset.panel);
      if (panel) panel.classList.add('show');

    });
  });

});
/* ══ SLIDER ══ */
const track = document.getElementById('track');
const allSlides = document.querySelectorAll('.slide');
const allDots = document.querySelectorAll('.dot');
const prevBtn = document.getElementById('prev');
const nextBtn = document.getElementById('next');
let cur = 0, timer;

function goTo(n) {
  if (!track || !allSlides.length || !allDots.length) return;
  if (allDots[cur]) allDots[cur].classList.remove('active');
  cur = (n + allSlides.length) % allSlides.length;
  track.style.transform = `translateX(-${cur * 100}%)`;
  if (allDots[cur]) allDots[cur].classList.add('active');
}

function startAuto() {
  if (!allSlides.length) return;
  timer = setInterval(() => goTo(cur + 1), 4000);
}
function reset() {
  if (timer) clearInterval(timer);
  startAuto();
}

// Only init slider if slider DOM exists on this page
if (track && allSlides.length && allDots.length && prevBtn && nextBtn) {
  prevBtn.onclick = () => { goTo(cur - 1); reset(); };
  nextBtn.onclick = () => { goTo(cur + 1); reset(); };
  allDots.forEach(d => d.addEventListener('click', () => { goTo(+d.dataset.i); reset(); }));
  startAuto();
}

/* ══ HAMBURGER ══ */
const hamburger = document.getElementById('hamburger');
const drawer = document.getElementById('mobileDrawer');
const drawerOverlay = document.getElementById('drawerOverlay');
const drawerClose = document.getElementById('drawerClose');

function openDrawer() {
  drawer.classList.add('open');
  hamburger.classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeDrawer() {
  drawer.classList.remove('open');
  hamburger.classList.remove('open');
  document.body.style.overflow = '';
}
if (hamburger && drawer && drawerOverlay && drawerClose) {
  hamburger.addEventListener('click', () => drawer.classList.contains('open') ? closeDrawer() : openDrawer());
  drawerOverlay.addEventListener('click', closeDrawer);
  drawerClose.addEventListener('click', closeDrawer);
}

/* ══ DRAWER SUBMENUS ══ */
document.querySelectorAll('.drawer-item.has-sub').forEach(item => {
  item.addEventListener('click', () => {
    const sub = document.getElementById(item.dataset.sub);
    if (!sub) return;
    const isOpen = sub.classList.contains('open');
    document.querySelectorAll('.drawer-sub.open').forEach(s => s.classList.remove('open'));
    document.querySelectorAll('.drawer-item.open-sub').forEach(i => i.classList.remove('open-sub'));
    if (!isOpen) {
      sub.classList.add('open');
      item.classList.add('open-sub');
      setTimeout(() => item.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 50);
    }
  });
});

/* ══ LOCATION MODAL ══ */
const locModal = document.getElementById('locModal');
const locClose = document.getElementById('locClose');
const citySearch = document.getElementById('citySearch');
const locationBtn = document.getElementById('locationBtn');
const drawerLocBtn = document.getElementById('drawerLocBtn');

function openLoc() {
  locModal.classList.add('open');
  document.body.style.overflow = 'hidden';
  setTimeout(() => citySearch.focus(), 200);
}
function closeLoc() {
  locModal.classList.remove('open');
  document.body.style.overflow = '';
}
if (locationBtn && locModal && locClose && citySearch) {
  locationBtn.addEventListener('click', openLoc);
  locClose.addEventListener('click', closeLoc);
  locModal.addEventListener('click', e => { if (e.target === locModal) closeLoc(); });
}

// Drawer location button
if (drawerLocBtn) {
  drawerLocBtn.addEventListener('click', () => {
    closeDrawer();
    setTimeout(openLoc, 220);
  });
}

/* ══ CITY SELECTION ══ */
function setCity(name) {
  // Update desktop button
  const btn = document.getElementById('locationBtn');
  btn.innerHTML = `
    <svg width="13" height="13" fill="none" stroke="#00c853" stroke-width="2.5" viewBox="0 0 24 24">
      <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
    </svg>
    <span id="desktopCityName">${name}</span>
    <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
  `;
  btn.onclick = openLoc;
  // Update drawer
  const dc = document.getElementById('drawerCityName');
  if (dc) dc.textContent = name;
}

document.querySelectorAll('.loc-city').forEach(city => {
  city.addEventListener('click', () => {
    document.querySelectorAll('.loc-city').forEach(c => c.classList.remove('selected'));
    city.classList.add('selected');
    setCity(city.dataset.city);
    setTimeout(closeLoc, 280);
  });
});

/* City search filter */
if (citySearch) {
  citySearch.addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.loc-city').forEach(c => {
      c.style.display = c.dataset.city.toLowerCase().includes(q) ? '' : 'none';
    });
  });
}


/*new changes  */

/* ══════════════════════════════════════════
   ADD THIS TO YOUR EXISTING js/main.js
   (Paste at the bottom)
══════════════════════════════════════════ */

document.addEventListener('DOMContentLoaded', function () {

  /* ── MEGA MENU: Left item hover → show right panel ── */
  function activateSellMega(item) {
    const panelId = item.dataset.panel;
    const mega = item.closest('.ts-mega');
    if (!mega) return;

    // Remove active from all left items in this dropdown
    mega.querySelectorAll('.ts-dd-left-item').forEach(i => i.classList.remove('active'));
    item.classList.add('active');

    // Hide all right panels in this mega dropdown
    mega.querySelectorAll('.ts-dd-right').forEach(p => {
      p.classList.remove('active');
      p.style.display = 'none';
    });

    // Show target panel
    const panel = document.getElementById(panelId);
    if (panel) {
      panel.classList.add('active');
      panel.style.display = 'flex';
    }
  }

  document.querySelectorAll('.ts-dd-left-item[data-panel]').forEach(item => {
    // Hover
    item.addEventListener('mouseenter', function () {
      activateSellMega(this);
    });

    // Click (fix: user click should also switch right panel)
    item.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      activateSellMega(this);
    });
  });

  // Show first right panel by default when dropdown opens
  document.querySelectorAll('.ts-mega').forEach(mega => {
    const firstItem = mega.querySelector('.ts-dd-left-item[data-panel]');
    const firstPanel = firstItem ? document.getElementById(firstItem.dataset.panel) : null;
    if (firstPanel) {
      firstPanel.style.display = 'flex';
      firstItem.classList.add('active');
    }
    // Hide rest
    mega.querySelectorAll('.ts-dd-right').forEach((p, i) => {
      if (i > 0) p.style.display = 'none';
    });
  });

  // TS Navbar init (mobile drawer + submenu)
  initTsNavbar();

});

function initTsNavbar() {
  const tsHamburger = document.getElementById('tsHamburger');
  const tsDrawer    = document.getElementById('tsMobileDrawer');
  const tsOverlay   = document.getElementById('tsDrawerOverlay');
  const tsCloseBtn  = document.getElementById('tsDrawerClose');

  if (!tsHamburger || !tsDrawer) return;

  function openTsDrawer()  { tsDrawer.classList.add('open'); document.body.style.overflow = 'hidden'; }
  function closeTsDrawer() { tsDrawer.classList.remove('open'); document.body.style.overflow = ''; }
  function toggleTsDrawer(e) {
    if (e) { e.preventDefault(); e.stopPropagation(); }
    tsDrawer.classList.contains('open') ? closeTsDrawer() : openTsDrawer();
  }

  // Avoid multiple bindings if main.js loaded twice
  if (!tsHamburger.dataset.bound) {
    tsHamburger.addEventListener('click', toggleTsDrawer);
    tsHamburger.dataset.bound = '1';
  }
  tsOverlay  && tsOverlay.addEventListener('click', closeTsDrawer);
  tsCloseBtn && tsCloseBtn.addEventListener('click', closeTsDrawer);

  document.querySelectorAll('.ts-has-sub').forEach(item => {
    if (item.dataset.bound) return;
    item.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      const subId = this.dataset.sub;
      const sub   = document.getElementById(subId);
      if (!sub) return;
      const isOpen = sub.classList.contains('open');
      document.querySelectorAll('.ts-drawer-sub').forEach(s => s.classList.remove('open'));
      if (!isOpen) sub.classList.add('open');
    });
    item.dataset.bound = '1';
  });
}

// Also run immediately (sell pages load script at end)
initTsNavbar();