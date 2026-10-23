// Page behaviour that does not depend on the 3D world:
// word-by-word heading reveal, staggered fade-ins, the YouTube player, smooth anchor links.

function splitWords(el, counter) {
  [...el.childNodes].forEach((n) => {
    if (n.nodeType === 3) {
      const frag = document.createDocumentFragment();
      n.textContent.split(/(\s+)/).forEach((part) => {
        if (!part) return;
        if (/^\s+$/.test(part)) { frag.appendChild(document.createTextNode(' ')); return; }
        const w = document.createElement('span');
        w.className = 'w';
        const i = document.createElement('span');
        i.textContent = part;
        i.style.setProperty('--i', counter.n++);
        w.appendChild(i);
        frag.appendChild(w);
      });
      n.replaceWith(frag);
    } else if (n.nodeType === 1) {
      splitWords(n, counter);
    }
  });
}

function initTextMotion() {
  document.querySelectorAll('.split').forEach((h) => splitWords(h, { n: 0 }));
  document.querySelectorAll('.reveal').forEach((r) => {
    let d = 0;
    r.querySelectorAll('.fx').forEach((e) => e.style.setProperty('--d', d++));
  });
  // Play every time a block scrolls into view (up or down). A block is only reset once it is
  // completely off screen, so nothing ever disappears while the visitor can still see it.
  const show = new IntersectionObserver((entries) => {
    entries.forEach((e) => { if (e.isIntersecting) e.target.classList.add('in'); });
  }, { rootMargin: '0px 0px -10% 0px' });
  const reset = new IntersectionObserver((entries) => {
    entries.forEach((e) => { if (!e.isIntersecting) e.target.classList.remove('in'); });
  }, { rootMargin: '15% 0px 15% 0px' });
  document.querySelectorAll('.reveal').forEach((r) => { show.observe(r); reset.observe(r); });
}

function initVideo() {
  const v = document.getElementById('video');
  if (!v) return;
  const id = v.dataset.id;
  const watch = 'https://www.youtube.com/watch?v=' + id;
  // YouTube only allows embedded playback from a real website (http/https).
  const canEmbed = /^https?:$/.test(location.protocol) && location.origin !== 'null';
  v.addEventListener('click', (e) => {
    if (e.target.closest('.yt-out')) return;
    if (!canEmbed) { window.open(watch, '_blank', 'noopener'); return; }
    if (v.classList.contains('on')) return;
    v.classList.add('on');
    const f = document.createElement('iframe');
    f.src = 'https://www.youtube.com/embed/' + id + '?autoplay=1&rel=0&playsinline=1&origin=' + encodeURIComponent(location.origin);
    f.title = 'From Energy, Comes Meaning - UBP Mahakam';
    f.referrerPolicy = 'strict-origin-when-cross-origin';
    f.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
    f.allowFullscreen = true;
    v.appendChild(f);

    // Video decoding + full-speed 3D on the same GPU makes scrolling stutter:
    // while the playing video is visible, the background world drops to a low frame rate.
    const tell = (on) => window.dispatchEvent(new CustomEvent(on ? 'world:slow' : 'world:normal'));
    new IntersectionObserver((es) => tell(es[0].isIntersecting), { threshold: 0.15 }).observe(v);
  });
}

// lenis is optional: without it the browser's native smooth scroll is used.
function initAnchors(lenis) {
  document.querySelectorAll('a[href^="#"]').forEach((a) => {
    a.addEventListener('click', (e) => {
      const id = a.getAttribute('href');
      const target = id === '#top' || id === '#' ? 0 : document.querySelector(id);
      if (target === null) return;
      e.preventDefault();
      if (lenis) lenis.scrollTo(target, { offset: -80, duration: 1.6 });
      else if (target === 0) window.scrollTo({ top: 0, behavior: 'smooth' });
      else window.scrollTo({ top: target.getBoundingClientRect().top + scrollY - 80, behavior: 'smooth' });
    });
  });
}

export function initUI({ lenis } = {}) {
  initTextMotion();
  initVideo();
  initAnchors(lenis);
}

// Decide once whether to run the lighter 3D world (phones, low-end devices).
export function isLiteDevice() {
  const narrow = matchMedia('(max-width: 820px)').matches;
  const fewCores = (navigator.hardwareConcurrency || 8) <= 4;
  const lowMem = (navigator.deviceMemory || 8) <= 4;
  return narrow || fewCores || lowMem;
}

export const prefersReducedMotion = () => matchMedia('(prefers-reduced-motion: reduce)').matches;

// Load heavy work after the page content is on screen.
export function whenIdle(fn) {
  const go = () => ('requestIdleCallback' in window ? requestIdleCallback(fn, { timeout: 1500 }) : setTimeout(fn, 300));
  if (document.readyState === 'complete') go();
  else addEventListener('load', go, { once: true });
}
