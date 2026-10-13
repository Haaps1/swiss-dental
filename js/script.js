// ===========================================================
// SWISS DENTAL — interactions
// ===========================================================

document.addEventListener('DOMContentLoaded', () => {

  /* ---------- preloader ---------- */
  const preloader = document.getElementById('preloader');
  window.addEventListener('load', () => {
    setTimeout(() => preloader && preloader.classList.add('hide'), 400);
  });
  // fallback in case load already fired
  setTimeout(() => preloader && preloader.classList.add('hide'), 2200);

  /* ---------- scroll progress bar ---------- */
  const progress = document.getElementById('scroll-progress');
  const backTop = document.getElementById('back-top');
  function onScroll(){
    const h = document.documentElement;
    const scrolled = (h.scrollTop) / (h.scrollHeight - h.clientHeight) * 100;
    if(progress) progress.style.width = scrolled + '%';

    const header = document.getElementById('site-header');
    if(header){ header.classList.toggle('scrolled', h.scrollTop > 40); }

    if(backTop) backTop.classList.toggle('show', h.scrollTop > 500);
  }
  document.addEventListener('scroll', onScroll, { passive:true });
  onScroll();

  backTop && backTop.addEventListener('click', () => window.scrollTo({ top:0, behavior:'smooth' }));

  /* ---------- cursor glow (desktop only) ---------- */
  const glow = document.getElementById('cursor-glow');
  if(glow && window.matchMedia('(hover:hover) and (pointer:fine)').matches){
    window.addEventListener('mousemove', e => {
      glow.style.left = e.clientX + 'px';
      glow.style.top = e.clientY + 'px';
    });
  } else if(glow){ glow.style.display = 'none'; }

  /* ---------- mobile menu ---------- */
  const burger = document.getElementById('hamburger');
  const mmenu = document.getElementById('mobile-menu');
  if(burger && mmenu){
    burger.addEventListener('click', () => {
      burger.classList.toggle('active');
      mmenu.classList.toggle('open');
      document.body.style.overflow = mmenu.classList.contains('open') ? 'hidden' : '';
    });
    mmenu.querySelectorAll('a').forEach(a => a.addEventListener('click', () => {
      burger.classList.remove('active'); mmenu.classList.remove('open'); document.body.style.overflow = '';
    }));
  }

  /* ---------- mobile services submenu ---------- */
  const mmServicesToggle = document.getElementById('mm-services-toggle');
  const mmServicesPanel = document.getElementById('mm-services-panel');
  if(mmServicesToggle && mmServicesPanel){
    mmServicesToggle.addEventListener('click', () => {
      mmServicesToggle.classList.toggle('open');
      mmServicesPanel.classList.toggle('open');
    });
  }

  /* ---------- active nav link ---------- */
  const path = location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('nav.main-nav a, #mobile-menu a').forEach(a => {
    const href = a.getAttribute('href');
    if(href === path || (path === '' && href === 'index.html')) a.classList.add('active');
  });

  /* ---------- scroll reveal (IntersectionObserver) ---------- */
  const revealEls = document.querySelectorAll('[data-aos]');
  const io = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if(entry.isIntersecting){
        const delay = entry.target.getAttribute('data-aos-delay') || 0;
        setTimeout(() => entry.target.classList.add('aos-in'), delay);
        io.unobserve(entry.target);
      }
    });
  }, { threshold:0.15 });
  revealEls.forEach(el => io.observe(el));

  /* ---------- animated counters ---------- */
  const counters = document.querySelectorAll('[data-count]');
  const cio = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if(!entry.isIntersecting) return;
      const el = entry.target;
      const target = parseInt(el.getAttribute('data-count'), 10);
      const suffix = el.getAttribute('data-suffix') || '';
      let cur = 0;
      const duration = 1600;
      const start = performance.now();
      function tick(now){
        const p = Math.min((now - start) / duration, 1);
        const eased = 1 - Math.pow(1 - p, 3);
        cur = Math.floor(eased * target);
        el.textContent = cur.toLocaleString() + suffix;
        if(p < 1) requestAnimationFrame(tick);
        else el.textContent = target.toLocaleString() + suffix;
      }
      requestAnimationFrame(tick);
      cio.unobserve(el);
    });
  }, { threshold:0.5 });
  counters.forEach(el => cio.observe(el));

  /* ---------- 3D tilt cards ---------- */
  const tiltEls = document.querySelectorAll('.service-card, .why-card, .quick-card, .value-card, .info-card');
  if(window.matchMedia('(hover:hover) and (pointer:fine)').matches){
    tiltEls.forEach(card => {
      card.style.willChange = 'transform';
      card.addEventListener('mousemove', e => {
        const r = card.getBoundingClientRect();
        const x = (e.clientX - r.left) / r.width - 0.5;
        const y = (e.clientY - r.top) / r.height - 0.5;
        card.style.transform = `perspective(800px) rotateY(${x * 10}deg) rotateX(${-y * 10}deg) translateY(-4px)`;
      });
      card.addEventListener('mouseleave', () => { card.style.transform = ''; });
    });
  }

  /* ---------- hero tooth parallax ---------- */
  const stage = document.getElementById('tooth-stage');
  if(stage && window.matchMedia('(hover:hover) and (pointer:fine)').matches){
    window.addEventListener('mousemove', e => {
      const x = (e.clientX / window.innerWidth - 0.5) * 18;
      const y = (e.clientY / window.innerHeight - 0.5) * 18;
      stage.style.transform = `rotateY(${x}deg) rotateX(${-y}deg)`;
    });
  }

  /* ---------- testimonial carousel ---------- */
  const testiCards = document.querySelectorAll('.testi-card');
  const testiDots = document.querySelectorAll('.testi-dots button');
  let ti = 0, testiTimer;
  function showTesti(i){
    testiCards.forEach(c => c.classList.remove('active'));
    testiDots.forEach(d => d.classList.remove('active'));
    testiCards[i] && testiCards[i].classList.add('active');
    testiDots[i] && testiDots[i].classList.add('active');
    ti = i;
  }
  function nextTesti(){ showTesti((ti + 1) % testiCards.length); }
  if(testiCards.length){
    showTesti(0);
    testiTimer = setInterval(nextTesti, 5000);
    testiDots.forEach((d, i) => d.addEventListener('click', () => { showTesti(i); clearInterval(testiTimer); testiTimer = setInterval(nextTesti, 5000); }));
  }

  /* ---------- lead form ---------- */
  const leadForm = document.getElementById('lead-form');
  if(leadForm){
    leadForm.addEventListener('submit', function(e){
      e.preventDefault();
      const btn = leadForm.querySelector('button[type="submit"]');
      const original = btn.innerHTML;
      btn.innerHTML = 'Sending...';
      btn.disabled = true;
      setTimeout(() => {
        leadForm.style.display = 'none';
        document.getElementById('form-success').classList.add('show');
        btn.innerHTML = original;
        btn.disabled = false;
      }, 900);
    });
  }

});
