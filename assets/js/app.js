document.addEventListener('DOMContentLoaded', () => {
  const T = window.REC.intervalo;
  const reduz = matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---------- Menu móvel ---------- */
  const btn = document.getElementById('menu-btn');
  const menu = document.getElementById('menu');
  const alternarMenu = (abrir) => {
    if (!btn || !menu) return;
    menu.classList.toggle('aberto', abrir);
    btn.setAttribute('aria-expanded', abrir);
    menu.setAttribute('aria-hidden', !abrir);
    document.body.classList.toggle('menu-aberto', abrir);
  };
  if (btn) btn.addEventListener('click', () => alternarMenu(!menu.classList.contains('aberto')));
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') alternarMenu(false); });

  /* ---------- Cabeçalho ao descer ---------- */
  const topo = document.getElementById('topo');
  const aoRolar = () => topo.classList.toggle('rolado', window.scrollY > 60);
  aoRolar();
  window.addEventListener('scroll', aoRolar, { passive: true });

  /* ---------- Sliders de ecrã inteiro (mensagens e poemas) ---------- */
  document.querySelectorAll('.swiper-tela').forEach((el) => {
    const total = el.querySelectorAll('.swiper-slide').length;
    const barra = el.querySelector('.barra i');
    const contador = el.dataset.contador ? document.querySelector(el.dataset.contador) : null;
    const varios = total > 1;

    const swiper = new Swiper(el, {
      effect: 'fade',
      fadeEffect: { crossFade: true },
      speed: 1400,
      rewind: varios,
      allowTouchMove: varios,
      keyboard: { enabled: true },
      autoplay: varios ? { delay: T, disableOnInteraction: false, pauseOnMouseEnter: true } : false,
      navigation: { nextEl: el.querySelector('.seta-next'), prevEl: el.querySelector('.seta-prev') },
      on: {
        autoplayTimeLeft(_s, tempo, progresso) {
          if (barra && !reduz) barra.style.transform = `scaleX(${1 - progresso})`;
        },
        slideChange(s) {
          if (contador) contador.textContent = `${s.realIndex + 1} / ${total}`;
          const ativo = s.slides[s.activeIndex];
          if (ativo) ativo.querySelectorAll('.rolagem').forEach((r) => (r.scrollTop = 0));
        },
      },
    });

    if (!varios) {
      if (barra) barra.parentElement.style.display = 'none';
      el.querySelectorAll('.seta').forEach((s) => (s.style.display = 'none'));
      if (contador) contador.style.display = 'none';
    }

    /* Índice de poemas */
    const ibtn = el.querySelector('#indice-btn');
    const indice = el.querySelector('#indice');
    if (ibtn && indice) {
      const abrir = (v) => {
        indice.classList.toggle('aberto', v);
        ibtn.setAttribute('aria-expanded', v);
        indice.setAttribute('aria-hidden', !v);
        if (varios && swiper.autoplay) v ? swiper.autoplay.stop() : swiper.autoplay.start();
      };
      ibtn.addEventListener('click', () => abrir(!indice.classList.contains('aberto')));
      indice.addEventListener('click', (e) => { if (e.target === indice) abrir(false); });
      indice.querySelectorAll('[data-ir]').forEach((b) =>
        b.addEventListener('click', () => { swiper.slideTo(+b.dataset.ir); abrir(false); })
      );
      document.addEventListener('keydown', (e) => { if (e.key === 'Escape') abrir(false); });
    }
  });

  /* ---------- Lightbox da galeria ---------- */
  if (document.querySelector('.glightbox') && window.GLightbox) {
    GLightbox({ selector: '.glightbox', touchNavigation: true, loop: false, zoomable: true, draggable: true });
  }

  /* ---------- Uma entrada orquestrada no menu inicial ---------- */
  if (!reduz && window.gsap && document.querySelector('.tile')) {
    gsap.from('.tile', { opacity: 0, y: 30, duration: 1.4, ease: 'power3.out', stagger: 0.18 });
    gsap.from('.tile-linha', { width: 0, duration: 1.2, ease: 'power2.out', stagger: 0.18, delay: 0.7 });
  }
});
