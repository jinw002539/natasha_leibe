/* Site estático: lê dados/conteudo.js e dados/fotos.js e monta cada página. */
(() => {
  'use strict';

  const C = window.CONTEUDO || {};
  const F = Object.assign({ mini: false, arquivos: [], galeria: {}, avulsas: [] }, window.FOTOS || {});
  const T = C.intervalo || 5000;
  const reduz = matchMedia('(prefers-reduced-motion: reduce)').matches;

  const $ = (s, r = document) => r.querySelector(s);
  const $$ = (s, r = document) => [...r.querySelectorAll(s)];
  const esc = (s) => String(s).replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
  const nat = (a, b) => a.localeCompare(b, 'pt', { numeric: true, sensitivity: 'base' });

  /* ---------- Fotografias ---------- */
  const enc = (rel) => rel.split('/').map(encodeURIComponent).join('/');
  const seguro = (rel) => rel.replace(/[^A-Za-z0-9._/-]/gu, '_'); // igual ao gerar-fotos.py
  const img = (rel, w = 800) => (F.mini ? `imagens/miniaturas/${w}/${enc(seguro(rel))}.jpg` : `imagens/${enc(rel)}`);
  const existentes = new Set(F.arquivos);

  const tituloPasta = (n) => {
    const t = n.replace(/[_-]+/g, ' ').trim();
    return t.charAt(0).toUpperCase() + t.slice(1);
  };

  const albuns = () =>
    Object.keys(F.galeria).sort(nat).filter((k) => F.galeria[k].length).map((slug) => {
      const cfg = (C.albuns || {})[slug] || {};
      const fotos = [...F.galeria[slug]].sort(nat);
      return { slug, titulo: cfg.titulo || tituloPasta(slug), descricao: cfg.descricao || '', capa: cfg.capa || fotos[0], fotos, total: fotos.length };
    });

  const todasFotos = () => [...new Set([...(F.avulsas || []), ...Object.values(F.galeria).flat()])].sort(nat);

  /** Foto indicada, ou (se activo) uma da galeria. */
  const fundo = (i, rel, passo = 5) => {
    if (rel && existentes.has(rel)) return rel;
    if (rel && existentes.size) console.warn('Foto não encontrada em /imagens:', rel, '— corre python gerar-fotos.py');
    if (C.fundo_automatico) {
      const t = todasFotos();
      if (t.length) return t[(i * passo) % t.length];
    }
    return null;
  };

  const imgTag = (rel, w, cls, i = 0) =>
    rel
      ? `<img class="${cls}" src="${img(rel, w)}" alt="" ${i ? 'loading="lazy"' : ''} decoding="async">`
      : '<div class="absolute inset-0 hero-vazio"></div>';

  /* ---------- Partes comuns ---------- */
  function comum() {
    $$('[data-titulo]').forEach((el) => (el.textContent = C.titulo || ''));
    $$('[data-assinatura]').forEach((el) => (el.textContent = C.assinatura || ''));
    const pag = document.body.dataset.pagina;
    const sec = (C.secoes || {})[pag];
    document.title = sec ? `${sec.titulo} — ${C.titulo}` : C.titulo || document.title;

    const btn = $('#menu-btn');
    const menu = $('#menu');
    const alternar = (abrir) => {
      if (!btn || !menu) return;
      menu.classList.toggle('aberto', abrir);
      btn.setAttribute('aria-expanded', abrir);
      menu.setAttribute('aria-hidden', !abrir);
    };
    if (btn) btn.addEventListener('click', () => alternar(!menu.classList.contains('aberto')));
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') alternar(false); });

    const topo = $('#topo');
    if (topo) {
      const aoRolar = () => topo.classList.toggle('rolado', window.scrollY > 60);
      aoRolar();
      window.addEventListener('scroll', aoRolar, { passive: true });
    }
  }

  /* ---------- Sliders de ecrã inteiro (mensagens e poemas) ---------- */
  function sliders() {
    $$('.swiper-tela').forEach((el) => {
      const total = $$('.swiper-slide', el).length;
      const barra = $('.barra i', el);
      const contador = el.dataset.contador ? $(el.dataset.contador) : null;
      const varios = total > 1;

      const swiper = new Swiper(el, {
        effect: 'fade',
        fadeEffect: { crossFade: true },
        speed: 1400,
        rewind: varios,
        allowTouchMove: varios,
        keyboard: { enabled: true },
        autoplay: varios ? { delay: T, disableOnInteraction: false, pauseOnMouseEnter: true } : false,
        navigation: { nextEl: $('.seta-next', el), prevEl: $('.seta-prev', el) },
        on: {
          autoplayTimeLeft(_s, _t, progresso) {
            if (barra && !reduz) barra.style.transform = `scaleX(${1 - progresso})`;
          },
          slideChange(s) {
            if (contador) contador.textContent = `${s.realIndex + 1} / ${total}`;
            const ativo = s.slides[s.activeIndex];
            if (ativo) $$('.rolagem', ativo).forEach((r) => (r.scrollTop = 0));
          },
        },
      });

      if (!varios) {
        if (barra) barra.parentElement.style.display = 'none';
        $$('.seta', el).forEach((s) => (s.style.display = 'none'));
        if (contador) contador.style.display = 'none';
      }

      const ibtn = $('#indice-btn', el);
      const indice = $('#indice', el);
      if (ibtn && indice) {
        const abrir = (v) => {
          indice.classList.toggle('aberto', v);
          ibtn.setAttribute('aria-expanded', v);
          indice.setAttribute('aria-hidden', !v);
          if (varios && swiper.autoplay) (v ? swiper.autoplay.stop() : swiper.autoplay.start());
        };
        ibtn.addEventListener('click', () => abrir(!indice.classList.contains('aberto')));
        indice.addEventListener('click', (e) => { if (e.target === indice) abrir(false); });
        $$('[data-ir]', indice).forEach((b) => b.addEventListener('click', () => { swiper.slideTo(+b.dataset.ir); abrir(false); }));
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') abrir(false); });
      }
    });
  }

  /* ---------- Página de entrada ---------- */
  function entrada() {
    const bg = fundo(0, (C.capas || {}).entrada, 3);
    $('#entrada-fundo').innerHTML = imgTag(bg, 1800, 'entrada-img absolute inset-0 h-full w-full object-cover');
    $$('[data-botao]').forEach((el) => (el.textContent = C.botao || 'Entrar'));
    $$('[data-entrada-texto]').forEach((el) => (el.textContent = C.entrada || ''));

    const link = $('#entrar');
    link.addEventListener('click', (e) => {
      if (reduz || e.metaKey || e.ctrlKey || e.shiftKey) return;
      e.preventDefault();
      document.body.classList.add('saindo');
      setTimeout(() => (location.href = link.href), 520);
    });

    if (!reduz && window.gsap) {
      gsap.from('[data-anima]', { y: 40, opacity: 0, duration: 1.5, ease: 'power3.out', stagger: 0.25, delay: 0.2 });
    }
  }

  /* ---------- Menu inicial ---------- */
  function inicio() {
    const ks = ['mensagens', 'poemas', 'galeria'];
    $('#tiles').innerHTML = ks.map((k, i) => {
      const capa = fundo(i, (C.capas || {})[k], 7);
      const s = (C.secoes || {})[k] || { titulo: k, descricao: '' };
      return `
      <a href="${k}.html" class="tile group relative block overflow-hidden border-b border-linho/10 md:border-b-0 md:border-r">
        ${capa
          ? `<img class="absolute inset-0 h-full w-full object-cover transition-transform duration-[1600ms] ease-out group-hover:scale-105" src="${img(capa, 1200)}" alt="" ${i ? 'loading="lazy"' : ''} decoding="async">`
          : '<div class="absolute inset-0 hero-vazio"></div>'}
        <div class="absolute inset-0 bg-noite/35 transition-colors duration-700 group-hover:bg-noite/15"></div>
        <div class="veil veil-hero"></div>
        <div class="absolute inset-x-0 bottom-0 z-20 px-6 md:px-10 pb-6 md:pb-14">
          <h2 class="font-serif font-light leading-none text-[clamp(2.4rem,6vw,4.6rem)]">${esc(s.titulo)}</h2>
          <p class="mt-3 max-w-xs text-sm md:text-base opacity-85">${esc(s.descricao)}</p>
          <span class="tile-linha mt-5 block h-px w-10 bg-ouro transition-all duration-700 group-hover:w-24"></span>
        </div>
      </a>`;
    }).join('');

    if (!reduz && window.gsap) {
      gsap.from('.tile', { opacity: 0, y: 30, duration: 1.4, ease: 'power3.out', stagger: 0.18 });
      gsap.from('.tile-linha', { width: 0, duration: 1.2, ease: 'power2.out', stagger: 0.18, delay: 0.7 });
    }
  }

  /* ---------- Mensagens ---------- */
  function mensagens() {
    const lista = (C.mensagens || []).map((m) => (typeof m === 'string' ? { texto: m } : m));
    $('#slides').innerHTML = lista.map((m, i) => `
      <div class="swiper-slide relative">
        ${imgTag(fundo(i, m.imagem, 3), 1800, 'kenburns absolute inset-0 h-full w-full object-cover', i)}
        <div class="absolute inset-0 scrim-texto"></div>
        <div class="relative z-10 flex h-full items-center justify-center px-8 md:px-28 pt-24 pb-24">
          <p class="max-w-3xl text-center font-serif font-light leading-[1.15] text-[clamp(2.1rem,6vw,4.6rem)]">${esc(m.texto)}</p>
        </div>
      </div>`).join('');
    $('#contador').textContent = `1 / ${lista.length}`;
    sliders();
  }

  /* ---------- Poemas ---------- */
  function poemas() {
    const lista = C.poemas || [];
    const texto = (p) => `
      <article class="m-auto w-full max-w-2xl py-4 text-center">
        <h3 class="mb-6 font-serif text-4xl md:text-5xl font-light">${esc(p.titulo)}</h3>
        ${(p.linhas || []).map((l) => (l === '' ? '<div class="h-5"></div>' : `<p class="font-serif font-light text-xl md:text-2xl leading-relaxed">${esc(l)}</p>`)).join('')}
      </article>`;

    $('#slides').innerHTML = lista.map((p, i) => {
      const bg = fundo(i, p.imagem, 4);
      const dur = p.duracao ? ` data-swiper-autoplay="${+p.duracao}"` : '';
      const corpo = p.layout === 'topo'
        ? `<div class="flex h-full flex-col bg-noite">
             <div class="relative h-[40svh] md:h-[46svh] shrink-0 overflow-hidden">
               ${imgTag(bg, 1800, 'kenburns absolute inset-0 h-full w-full object-cover', i)}
               <div class="veil veil-hero"></div>
             </div>
             <div class="rolagem flex flex-1 overflow-y-auto px-6 md:px-24 pb-28">${texto(p)}</div>
           </div>`
        : `<div class="relative h-full w-full">
             ${imgTag(bg, 1800, 'kenburns absolute inset-0 h-full w-full object-cover', i)}
             <div class="absolute inset-0 scrim-poema"></div>
             <div class="rolagem relative z-10 flex h-full overflow-y-auto px-6 md:px-24 pt-24 pb-28">${texto(p)}</div>
           </div>`;
      return `<div class="swiper-slide"${dur}>${corpo}</div>`;
    }).join('');

    $('#lista-indice').innerHTML = lista.map((p, i) => `<li><button type="button" data-ir="${i}">${esc(p.titulo)}</button></li>`).join('');
    $('#contador').textContent = `1 / ${lista.length}`;
    sliders();
  }

  /* ---------- Galeria ---------- */
  function paginacao(total, por, atual, q) {
    const paginas = Math.ceil(total / por);
    if (paginas < 2) return '';
    const link = (n) => `galeria.html?${new URLSearchParams({ ...q, pg: n })}`;
    const nums = [...new Set([1, atual - 1, atual, atual + 1, paginas].filter((n) => n >= 1 && n <= paginas))].sort((a, b) => a - b);
    let h = '<nav class="paginacao" aria-label="Páginas">';
    h += atual > 1 ? `<a href="${link(atual - 1)}">Anterior</a>` : '<span class="off">Anterior</span>';
    let ant = 0;
    nums.forEach((n) => {
      if (n - ant > 1) h += '<span class="off">…</span>';
      h += n === atual ? `<span class="atual" aria-current="page">${n}</span>` : `<a href="${link(n)}">${n}</a>`;
      ant = n;
    });
    h += atual < paginas ? `<a href="${link(atual + 1)}">Seguinte</a>` : '<span class="off">Seguinte</span>';
    return h + '</nav>';
  }

  function galeria() {
    const raiz = $('#galeria');
    const todas = todasFotos();
    const lista = albuns();
    const params = new URLSearchParams(location.search);
    const slug = params.get('album');
    const verTodas = slug === 'todas';
    const album = !verTodas && slug ? lista.find((a) => a.slug === slug) : null;
    const legenda = (rel) => (C.legendas || {})[rel] || '';
    const sec = (C.secoes || {}).galeria || { titulo: 'Galeria', descricao: '' };

    if (slug && !verTodas && !album) {
      raiz.innerHTML = `
        <h1 class="font-serif font-light leading-none text-[clamp(2.6rem,7vw,5rem)]">Álbum não encontrado</h1>
        <p class="mt-6"><a class="text-ouro border-b border-ouro" href="galeria.html">Voltar à galeria</a></p>`;
      return;
    }

    if (album || verTodas) {
      const fotos = verTodas ? todas : album.fotos;
      const titulo = verTodas ? 'Todas as fotografias' : album.titulo;
      const desc = verTodas ? '' : album.descricao;
      const por = Math.max(6, +C.paginacao || 30);
      const paginasTotal = Math.max(1, Math.ceil(fotos.length / por));
      const pg = Math.min(Math.max(1, parseInt(params.get('pg'), 10) || 1), paginasTotal);
      const pagina = fotos.slice((pg - 1) * por, pg * por);
      const q = { album: verTodas ? 'todas' : album.slug };

      raiz.innerHTML = `
        <p class="mb-3 text-sm text-bruma"><a class="hover:text-linho transition-colors" href="galeria.html">Galeria</a></p>
        <h1 class="font-serif font-light leading-none text-[clamp(2.6rem,7vw,5rem)]">${esc(titulo)}</h1>
        ${desc ? `<p class="mt-4 max-w-xl opacity-85">${esc(desc)}</p>` : ''}
        <p class="mt-3 text-sm text-bruma">${fotos.length} fotografias${fotos.length > por ? ' · página ' + pg : ''}</p>
        <div class="chips" role="navigation" aria-label="Álbuns">
          <a class="chip ${verTodas ? 'ativo' : ''}" href="galeria.html?album=todas">Todas</a>
          ${lista.map((a) => `<a class="chip ${!verTodas && album.slug === a.slug ? 'ativo' : ''}" href="galeria.html?album=${encodeURIComponent(a.slug)}">${esc(a.titulo)}</a>`).join('')}
        </div>
        <div class="mt-8 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-6 gap-2 md:gap-3">
          ${pagina.map((rel) => {
            const leg = legenda(rel);
            return `
            <a href="${img(rel, 1800)}" class="glightbox foto group relative block aspect-[4/5] overflow-hidden bg-ameixa" data-gallery="pagina" data-description="${esc(leg)}">
              <img class="h-full w-full object-cover transition-transform duration-[1200ms] ease-out group-hover:scale-105"
                   src="${img(rel, 480)}" ${F.mini ? `srcset="${img(rel, 480)} 480w, ${img(rel, 800)} 800w"` : ''}
                   sizes="(min-width:1536px) 16vw, (min-width:1024px) 24vw, (min-width:640px) 32vw, 48vw"
                   alt="${esc(leg)}" loading="lazy" decoding="async">
              ${leg ? `<span class="veil veil-foto"></span><span class="absolute z-10 inset-x-3 bottom-2 font-serif italic text-base md:text-lg">${esc(leg)}</span>` : ''}
            </a>`;
          }).join('')}
        </div>
        ${paginacao(fotos.length, por, pg, q)}`;

      if (window.GLightbox) GLightbox({ selector: '.glightbox', touchNavigation: true, loop: false, zoomable: true, draggable: true });
      return;
    }

    const card = (href, capa, titulo, total) => `
      <a href="${href}" class="card group relative block aspect-[4/5] overflow-hidden bg-ameixa">
        ${capa
          ? `<img class="absolute inset-0 h-full w-full object-cover transition-transform duration-[1400ms] ease-out group-hover:scale-105" src="${img(capa, 800)}" alt="" loading="lazy" decoding="async">`
          : '<div class="absolute inset-0 hero-vazio"></div>'}
        <div class="veil veil-foto"></div>
        <div class="absolute inset-x-4 bottom-4 z-10">
          <h2 class="font-serif text-2xl md:text-3xl leading-tight">${esc(titulo)}</h2>
          <p class="text-xs md:text-sm text-linho/70">${total} fotografias</p>
        </div>
      </a>`;

    raiz.innerHTML = `
      <h1 class="font-serif font-light leading-none text-[clamp(2.6rem,7vw,5rem)]">${esc(sec.titulo)}</h1>
      <p class="mt-4 max-w-xl opacity-85">${esc(sec.descricao)}</p>
      <p class="mt-3 text-sm text-bruma">${todas.length} fotografias em ${lista.length} ${lista.length === 1 ? 'álbum' : 'álbuns'}</p>
      ${todas.length
        ? `<div class="mt-10 grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 md:gap-5">
             ${card('galeria.html?album=todas', null, 'Todas', todas.length)}
             ${lista.map((a) => card(`galeria.html?album=${encodeURIComponent(a.slug)}`, a.capa, a.titulo, a.total)).join('')}
           </div>`
        : `<p class="mt-16 max-w-lg font-serif text-2xl text-bruma">Cria pastas dentro de <em>imagens/galeria</em> (uma por álbum), coloca lá as fotografias e corre <em>python gerar-fotos.py</em>.</p>`}`;
  }

  document.addEventListener('DOMContentLoaded', () => {
    comum();
    const pag = document.body.dataset.pagina;
    const rotas = { entrada, inicio, mensagens, poemas, galeria };
    if (rotas[pag]) rotas[pag]();
  });
})();
