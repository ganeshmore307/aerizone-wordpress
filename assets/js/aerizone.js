(() => {
  'use strict';
  const app = document.querySelector('#aerizone-app');
  if (!app) return;
  const header = app.querySelector('.az-header');
  const menu = app.querySelector('.az-menu');
  menu?.addEventListener('click', () => {
    const open = app.classList.toggle('az-menu-open');
    menu.setAttribute('aria-expanded', String(open));
  });
  window.addEventListener('scroll', () => header?.classList.toggle('is-scrolled', window.scrollY > 18), {passive:true});
  const items = app.querySelectorAll('.aerizone-reveal');
  if (!('IntersectionObserver' in window)) items.forEach(el => el.classList.add('is-visible'));
  else {
    const observer = new IntersectionObserver(entries => entries.forEach(entry => {
      if (entry.isIntersecting) { entry.target.classList.add('is-visible'); observer.unobserve(entry.target); }
    }), {threshold:.12});
    items.forEach(el => observer.observe(el));
  }
  app.querySelectorAll('.az-controls button').forEach(button => button.addEventListener('click', () => button.classList.toggle('is-on')));
  app.querySelector('#az-enquiry')?.addEventListener('submit', event => {
    event.preventDefault();
    const data = new FormData(event.currentTarget);
    const text = `Hello Aerizone, I would like to discuss a project.\n\nName: ${data.get('name')}\nPhone: ${data.get('phone')}\nInterest: ${data.get('interest')}\nSpace/Requirement: ${data.get('message') || 'Not specified'}`;
    window.open(`https://wa.me/919011512832?text=${encodeURIComponent(text)}`, '_blank', 'noopener');
  });
  const hero = app.querySelector('[data-az-hero]');
  if (hero) {
    const slides = [...hero.querySelectorAll('.az-hero-slide')];
    const copies = [...hero.querySelectorAll('[data-hero-copy]')];
    const dots = [...hero.querySelectorAll('[data-hero-dot]')];
    const count = hero.querySelector('.az-hero-count b');
    const previous = hero.querySelector('.az-hero-prev');
    const next = hero.querySelector('.az-hero-next');
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let active = 0;
    let timer = null;
    let touchStart = 0;

    const showHeroSlide = (index, userInitiated = false) => {
      active = (index + slides.length) % slides.length;
      slides.forEach((slide, i) => slide.classList.toggle('is-active', i === active));
      copies.forEach((copy, i) => {
        const selected = i === active;
        copy.hidden = !selected;
        copy.classList.toggle('is-active', selected);
      });
      dots.forEach((dot, i) => {
        const selected = i === active;
        dot.classList.toggle('is-active', selected);
        dot.setAttribute('aria-selected', String(selected));
      });
      if (count) count.textContent = String(active + 1).padStart(2, '0');
      if (userInitiated) restartHero();
    };
    const stopHero = () => { if (timer) window.clearInterval(timer); timer = null; };
    const startHero = () => {
      if (reduceMotion || slides.length < 2) return;
      stopHero();
      timer = window.setInterval(() => showHeroSlide(active + 1), 6500);
    };
    const restartHero = () => { stopHero(); startHero(); };

    previous?.addEventListener('click', () => showHeroSlide(active - 1, true));
    next?.addEventListener('click', () => showHeroSlide(active + 1, true));
    dots.forEach((dot, i) => dot.addEventListener('click', () => showHeroSlide(i, true)));
    hero.addEventListener('mouseenter', stopHero);
    hero.addEventListener('mouseleave', startHero);
    hero.addEventListener('focusin', stopHero);
    hero.addEventListener('focusout', startHero);
    hero.addEventListener('touchstart', event => { touchStart = event.changedTouches[0].clientX; }, {passive:true});
    hero.addEventListener('touchend', event => {
      const distance = event.changedTouches[0].clientX - touchStart;
      if (Math.abs(distance) > 45) showHeroSlide(active + (distance < 0 ? 1 : -1), true);
    }, {passive:true});
    hero.addEventListener('keydown', event => {
      if (event.key === 'ArrowLeft') showHeroSlide(active - 1, true);
      if (event.key === 'ArrowRight') showHeroSlide(active + 1, true);
    });
    document.addEventListener('visibilitychange', () => document.hidden ? stopHero() : startHero());
    startHero();
  }

  const sceneStage = app.querySelector('.az-scene-stage');
  const sceneButtons = app.querySelectorAll('.az-scene-tabs [data-scene]');
  const scenePanes = app.querySelectorAll('.az-scene-pane[data-pane]');
  sceneButtons.forEach(button => button.addEventListener('click', () => {
    const scene = button.dataset.scene;
    sceneButtons.forEach(item => item.classList.toggle('is-active', item === button));
    scenePanes.forEach(pane => pane.classList.toggle('is-active', pane.dataset.pane === scene));
    if (sceneStage) sceneStage.className = 'az-scene-stage is-' + scene;
  }));

})();
