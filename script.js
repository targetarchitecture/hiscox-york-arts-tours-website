/* Hiscox York Arts Tours — script.js */
(function () {
  'use strict';

  document.documentElement.classList.add('js');

  /* sticky header */
  const header = document.getElementById('siteHeader');
  if (header) {
    const tick = () => header.classList.toggle('scrolled', window.scrollY > 60);
    window.addEventListener('scroll', tick, { passive: true });
    tick();
  }

  /* mobile nav toggle */
  const toggle = document.getElementById('navToggle');
  const nav    = document.getElementById('siteNav');
  if (toggle && nav) {
    toggle.addEventListener('click', () => {
      const open = nav.classList.toggle('open');
      toggle.setAttribute('aria-expanded', String(open));
    });
    nav.querySelectorAll('a').forEach(a =>
      a.addEventListener('click', () => {
        nav.classList.remove('open');
        toggle.setAttribute('aria-expanded', 'false');
      })
    );
  }

  /* hero background zoom */
  const heroBg = document.getElementById('heroBg');
  if (heroBg) {
    const go = () => heroBg.classList.add('loaded');
    document.readyState === 'complete' ? go() : window.addEventListener('load', go, { once: true });
  }

  /* scroll reveal */
  const els = document.querySelectorAll('.reveal, .stagger');
  if (els.length && 'IntersectionObserver' in window) {
    const io = new IntersectionObserver(
      entries => entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } }),
      { threshold: 0.10, rootMargin: '0px 0px -40px 0px' }
    );
    els.forEach(el => io.observe(el));
  }

  /* FAQ accordion */
  document.querySelectorAll('.faq-item').forEach(item => {
    const btn = item.querySelector('.faq-q');
    const ans = item.querySelector('.faq-a');
    if (!btn || !ans) return;
    btn.setAttribute('aria-expanded', 'false');
    btn.addEventListener('click', () => {
      const open = item.classList.toggle('open');
      btn.setAttribute('aria-expanded', String(open));
      ans.style.maxHeight = open ? ans.scrollHeight + 'px' : '0';
    });
  });

  /* video facade */
  const facade = document.getElementById('videoFacade');
  if (facade) {
    const play = () => {
      facade.querySelector('iframe').src =
        'https://www.youtube.com/embed/fps2cGSoSgI?autoplay=1&start=16&rel=0';
      facade.classList.add('is-playing');
    };
    facade.addEventListener('click', play);
    facade.addEventListener('keydown', e => {
      if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); play(); }
    });
  }

})();
