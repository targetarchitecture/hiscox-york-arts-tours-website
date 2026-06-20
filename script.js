/* Hiscox York Arts Tours — site JS */

// ── mark JS available for CSS reveal hooks
document.documentElement.classList.add('js');

// ── sticky header
const header = document.getElementById('siteHeader');
if (header) {
  const onScroll = () => header.classList.toggle('scrolled', window.scrollY > 60);
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
}

// ── mobile nav toggle
const navToggle = document.getElementById('navToggle');
const siteNav   = document.getElementById('siteNav');
if (navToggle && siteNav) {
  navToggle.addEventListener('click', () => {
    const open = siteNav.classList.toggle('open');
    navToggle.setAttribute('aria-expanded', open);
  });
  // close on nav link click
  siteNav.querySelectorAll('a').forEach(a =>
    a.addEventListener('click', () => {
      siteNav.classList.remove('open');
      navToggle.setAttribute('aria-expanded', 'false');
    })
  );
}

// ── hero background subtle zoom-in on load
const heroBg = document.getElementById('heroBg');
if (heroBg) {
  window.addEventListener('load', () => heroBg.classList.add('loaded'), { once: true });
}

// ── scroll reveal (IntersectionObserver)
const revealEls = document.querySelectorAll('.reveal, .stagger');
if (revealEls.length && 'IntersectionObserver' in window) {
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('in');
        io.unobserve(e.target);
      }
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
  revealEls.forEach(el => io.observe(el));
}

// ── FAQ accordion
document.querySelectorAll('.faq-item').forEach(item => {
  const btn = item.querySelector('.faq-q');
  const ans = item.querySelector('.faq-a');
  if (!btn || !ans) return;
  btn.setAttribute('aria-expanded', 'false');
  btn.addEventListener('click', () => {
    const open = item.classList.toggle('open');
    btn.setAttribute('aria-expanded', open);
    ans.style.maxHeight = open ? ans.scrollHeight + 'px' : '0';
  });
});

// ── update copyright year
const yearEl = document.getElementById('year');
if (yearEl) yearEl.textContent = new Date().getFullYear();
