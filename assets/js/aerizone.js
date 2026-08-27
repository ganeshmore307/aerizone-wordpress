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
})();
