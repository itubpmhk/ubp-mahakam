// Public site entry: smooth scroll, text motion, video, portal filter, and the 3D background (home page only).
import Lenis from 'lenis';
import { initUI, isLiteDevice, prefersReducedMotion, whenIdle } from './ui.js';

const reduce = prefersReducedMotion();

let lenis = null;
if (!reduce) {
  lenis = new Lenis({ lerp: 0.09, smoothWheel: true, wheelMultiplier: 0.9 });
  const loop = (time) => { lenis.raf(time); requestAnimationFrame(loop); };
  requestAnimationFrame(loop);
}

initUI({ lenis });
initPortalFilter();

// 3D world: only on pages that render <canvas id="scene">, loaded after the content.
const canvas = document.getElementById('scene');
if (canvas) {
  whenIdle(async () => {
    try {
      const [THREE, { initWorld }] = await Promise.all([import('three'), import('./world.js')]);
      initWorld(THREE, canvas, { lite: isLiteDevice(), reduceMotion: reduce });
    } catch (err) {
      canvas.remove(); // no WebGL: the page works without the background
    }
  });
}

/* Portal page: instant search + category filter, re-numbering visible cards 01, 02, ... */
function initPortalFilter() {
  const grid = document.getElementById('portal-grid');
  if (!grid) return;
  const q = document.getElementById('portal-q');
  const empty = document.getElementById('portal-empty');
  const buttons = [...document.querySelectorAll('.filters .filter')];
  const cards = [...grid.querySelectorAll('.a-card')];
  let cat = '';

  const apply = () => {
    const term = (q?.value || '').trim().toLowerCase();
    let n = 0;
    cards.forEach((card) => {
      const ok = (!cat || card.dataset.cat === cat) && (!term || card.dataset.name.includes(term) || card.dataset.cat.toLowerCase().includes(term));
      card.hidden = !ok;
      if (ok) {
        n += 1;
        const no = card.querySelector('.a-no');
        if (no) no.textContent = String(n).padStart(2, '0');
      }
    });
    if (empty) empty.hidden = n > 0;
  };

  buttons.forEach((b) => b.addEventListener('click', () => {
    cat = b.dataset.cat;
    buttons.forEach((x) => x.classList.toggle('on', x === b));
    apply();
  }));
  q?.addEventListener('input', apply);
}
