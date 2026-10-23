// The 3D background: a road through the Mahakam area past three plant sites.
// THREE is passed in so the same code runs from the npm package (Vite build)
// or from a global <script> copy (single-file preview).
//
// Performance notes
// - Every non-moving part of a site is merged into ONE mesh with vertex colours
//   (bake), so the GPU draws a few dozen objects instead of ~1,500.
// - "lite" mode (phones / low-end devices): no shadows, fewer trees and props,
//   lower pixel ratio, no antialiasing.
// - The frame loop renders at full rate only while the camera is moving;
//   when idle it drops to ~30 fps (lite: ~20 fps), and pauses in hidden tabs.

export function initWorld(THREE, canvas, opts = {}) {
  const lite = !!opts.lite;
  const reduce = !!opts.reduceMotion;
  const V3 = THREE.Vector3, PI = Math.PI;

  /* ---------------- renderer, scene, lights ---------------- */
  const renderer = new THREE.WebGLRenderer({ canvas, antialias: !lite, powerPreference: 'high-performance' });
  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, lite ? 1.25 : 1.5));
  renderer.shadowMap.enabled = !lite;
  renderer.shadowMap.type = THREE.PCFSoftShadowMap;
  if ('outputEncoding' in renderer && THREE.sRGBEncoding !== undefined) renderer.outputEncoding = THREE.sRGBEncoding;

  const scene = new THREE.Scene();
  const BG = 0xf2f4f5;
  scene.background = new THREE.Color(BG);
  scene.fog = new THREE.Fog(BG, 55, 230);
  const camera = new THREE.PerspectiveCamera(38, 1, 0.1, 600);

  scene.add(new THREE.HemisphereLight(0xffffff, 0xbcb6a8, lite ? 0.95 : 0.8));
  const sun = new THREE.DirectionalLight(0xfff1de, 0.85);
  sun.castShadow = !lite;
  sun.shadow.mapSize.set(1024, 1024);
  Object.assign(sun.shadow.camera, { left: -40, right: 40, top: 40, bottom: -40, near: 1, far: 200 });
  sun.shadow.bias = -0.0006;
  scene.add(sun); scene.add(sun.target);

  /* ---------------- palette & builders ---------------- */
  const C = { pad: 0xd3d0c8, conc2: 0xc2beb5, wall: 0xdfddd8, blue: 0x1592d4, teal: 0x2f8a85, tealD: 0x22625f, silver: 0xc4c7ca,
    steel: 0x8c9096, yellow: 0xffd500, dark: 0x3e4146, road: 0x5a5c5f, ground: 0xe5e8e6, tree: 0x8fa56b, trafo: 0x7d8884 };
  const cache = {};
  const M = (c, o) => {
    const k = c + '|' + JSON.stringify(o || {});
    return cache[k] || (cache[k] = new THREE.MeshStandardMaterial(Object.assign({ color: c, roughness: 0.85, metalness: 0, flatShading: true }, o)));
  };
  const shadows = !lite;
  function add(g, geo, mat, x, y, z) { const m = new THREE.Mesh(geo, mat); m.position.set(x, y, z); g.add(m); return m; }
  const box = (g, w, h, d, mat, x, y, z) => add(g, new THREE.BoxGeometry(w, h, d), mat, x, y + h / 2, z);
  const cyl = (g, r, h, mat, x, y, z, seg, r2) => add(g, new THREE.CylinderGeometry(r, r2 === undefined ? r : r2, h, lite ? Math.min(seg || 20, 12) : seg || 20), mat, x, y + h / 2, z);
  function hcyl(g, r, len, mat, x, y, z, axis) { const m = add(g, new THREE.CylinderGeometry(r, r, len, lite ? 12 : 24), mat, x, y, z); if (axis === 'x') m.rotation.z = PI / 2; else m.rotation.x = PI / 2; return m; }
  function pipe(g, a, b, r, mat) {
    const d = new V3().subVectors(b, a);
    const m = add(g, new THREE.CylinderGeometry(r, r, d.length(), 8), mat, 0, 0, 0);
    m.position.copy(a).add(b).multiplyScalar(0.5);
    m.quaternion.setFromUnitVectors(new V3(0, 1, 0), d.normalize());
    return m;
  }
  function rail(g, x1, z1, x2, z2, y) {
    const ym = M(C.yellow);
    pipe(g, new V3(x1, y + 0.9, z1), new V3(x2, y + 0.9, z2), 0.035, ym);
    pipe(g, new V3(x1, y + 0.45, z1), new V3(x2, y + 0.45, z2), 0.025, ym);
    const n = Math.max(1, Math.round(Math.hypot(x2 - x1, z2 - z1) / (lite ? 2 : 1)));
    for (let i = 0; i <= n; i++) { const t = i / n; cyl(g, 0.03, 0.9, ym, x1 + (x2 - x1) * t, y, z1 + (z2 - z1) * t, 5); }
  }
  function ring(g, r, y, x, z, col) { const m = add(g, new THREE.TorusGeometry(r, 0.07, 5, lite ? 18 : 28), M(col || C.yellow), x, y, z); m.rotation.x = PI / 2; }
  function gantry(g, x, z, w, h) { const s = M(C.steel); box(g, 0.18, h, 0.18, s, x - w / 2, 0, z); box(g, 0.18, h, 0.18, s, x + w / 2, 0, z); box(g, w + 0.2, 0.18, 0.18, s, x, h, z); }
  function trafo(g, x, y, z, s) {
    s = s || 1;
    box(g, 1.5 * s, 1.5 * s, 1.1 * s, M(C.trafo), x, y, z);
    for (let i = 0; i < 3; i++) cyl(g, 0.07 * s, 0.7 * s, M(C.dark), x - 0.45 * s + i * 0.45 * s, y + 1.5 * s, z, 6);
    for (let i = 0; i < 4; i++) box(g, 0.06, 1.2 * s, 1.2 * s, M(C.steel), x - 0.6 * s + i * 0.4 * s, y + 0.1, z);
  }

  /* -------- bake: merge every static, plain-coloured mesh under root into one vertex-coloured mesh -------- */
  const bakedMat = new THREE.MeshStandardMaterial({ vertexColors: true, roughness: 0.85, metalness: 0, flatShading: true });
  const plain = (m) => m && m.isMeshStandardMaterial && !m.wireframe && m.side === THREE.FrontSide && !m.transparent && !m.map;
  function bake(root, { cast = true } = {}) {
    root.updateMatrixWorld(true);
    const inv = new THREE.Matrix4().copy(root.matrixWorld).invert();
    const parts = [];
    (function walk(o) {
      for (const c of o.children.slice()) {
        if (c.userData.dynamic) continue;            // moving parts keep their own mesh
        if (c.isMesh && plain(c.material)) parts.push(c);
        walk(c);
      }
    })(root);
    if (!parts.length) return null;
    let total = 0;
    const geos = parts.map((p) => {
      const g = p.geometry.index ? p.geometry.toNonIndexed() : p.geometry.clone();
      g.applyMatrix4(new THREE.Matrix4().multiplyMatrices(inv, p.matrixWorld));
      total += g.attributes.position.count;
      return g;
    });
    const pos = new Float32Array(total * 3), col = new Float32Array(total * 3);
    let off = 0;
    geos.forEach((g, i) => {
      const a = g.attributes.position.array, c = parts[i].material.color;
      pos.set(a, off * 3);
      for (let v = 0; v < g.attributes.position.count; v++) { const k = (off + v) * 3; col[k] = c.r; col[k + 1] = c.g; col[k + 2] = c.b; }
      off += g.attributes.position.count;
      g.dispose();
    });
    parts.forEach((p) => { p.parent.remove(p); p.geometry.dispose(); });
    const geo = new THREE.BufferGeometry();
    geo.setAttribute('position', new THREE.BufferAttribute(pos, 3));
    geo.setAttribute('color', new THREE.BufferAttribute(col, 3));
    geo.computeVertexNormals();
    geo.computeBoundingSphere();
    const mesh = new THREE.Mesh(geo, bakedMat);
    mesh.castShadow = shadows && cast;
    mesh.receiveShadow = shadows;
    root.add(mesh);
    return mesh;
  }

  /* ---------------- animated parts ---------------- */
  const fans = [];
  const shroudMat = M(C.steel, { side: THREE.DoubleSide });
  function fan(g, x, y, z, r) {
    const sh = new THREE.Mesh(new THREE.CylinderGeometry(r, r, 0.3, lite ? 14 : 22, 1, true), shroudMat);
    sh.position.set(x, y + 0.15, z); g.add(sh);
    const f = new THREE.Group(); f.position.set(x, y + 0.2, z); f.userData.dynamic = true;
    cyl(f, r * 0.15, 0.12, M(C.dark), 0, 0, 0, 8);
    for (let i = 0; i < 5; i++) {
      const b = new THREE.Mesh(new THREE.BoxGeometry(r * 0.85, 0.03, 0.2), M(C.dark));
      b.position.x = r * 0.45;
      const p = new THREE.Group(); p.rotation.y = i * PI * 2 / 5; p.add(b); f.add(p);
    }
    g.add(f);
    bake(f, { cast: false });                          // rotor = 1 mesh
    fans.push(f);
  }

  const smokeTex = (() => {
    const c = document.createElement('canvas'); c.width = c.height = 64;
    const x = c.getContext('2d');
    const gr = x.createRadialGradient(32, 32, 0, 32, 32, 32);
    gr.addColorStop(0, 'rgba(255,255,255,1)'); gr.addColorStop(0.5, 'rgba(255,255,255,.5)'); gr.addColorStop(1, 'rgba(255,255,255,0)');
    x.fillStyle = gr; x.fillRect(0, 0, 64, 64);
    return new THREE.CanvasTexture(c);
  })();
  const emitters = [];
  function smoke(g, x, y, z, o) {
    o = Object.assign({ n: 9, color: 0xb9b5ad, alpha: 0.45, rise: 5, size: 1, grow: 3, drift: 1.6, speed: 0.18 }, o);
    if (lite) o.n = Math.max(3, Math.round(o.n / 2));
    const mat = new THREE.SpriteMaterial({ map: smokeTex, color: o.color, transparent: true, depthWrite: false, opacity: 0 });
    const e = { o, b: new V3(x, y, z), s: [] };
    for (let i = 0; i < o.n; i++) {
      const sp = new THREE.Sprite(mat.clone()); sp.userData.off = i / o.n; g.add(sp); e.s.push(sp);
    }
    emitters.push(e);
  }

  /* ---------------- PLTD (front faces +z) ---------------- */
  function buildPLTD(g) {
    box(g, 21, 0.3, 15, M(C.pad), 0, 0, 0); const Y = 0.3;
    const wall = M(C.wall), blue = M(C.blue);
    box(g, 12, 4.2, 0.25, wall, 0, Y, -4); box(g, 0.25, 4.2, 5.2, wall, -6, Y, -1.5); box(g, 0.25, 4.2, 5.2, wall, 6, Y, -1.5);
    for (const x of [-2, 2]) box(g, 0.2, 4.2, 0.2, M(C.steel), x, Y, 1);
    box(g, 12, 0.25, 0.25, M(C.steel), 0, Y + 4, 1);
    const ridgeY = Y + 5.2, half = 2.9, th = 0.38;
    const r1 = add(g, new THREE.BoxGeometry(12.6, 0.16, half * 1.08), blue, 0, ridgeY - Math.sin(th) * half / 2, -1.5 - Math.cos(th) * half / 2); r1.rotation.x = -th;
    const r2 = add(g, new THREE.BoxGeometry(12.6, 0.16, half * 1.08), blue, 0, ridgeY - Math.sin(th) * half / 2, -1.5 + Math.cos(th) * half / 2); r2.rotation.x = th;
    [-3.8, 0, 3.8].forEach((x) => {
      box(g, 3.1, 0.3, 2.3, M(C.conc2), x, Y, -1.8);
      box(g, 2.2, 1.1, 1.1, M(C.teal), x - 0.35, Y + 0.3, -1.8);
      box(g, 2, 0.35, 0.75, M(C.tealD), x - 0.35, Y + 1.4, -1.8);
      hcyl(g, 0.62, 1.1, M(C.teal), x + 1.3, Y + 0.3 + 0.62, -1.8, 'x');
      pipe(g, new V3(x - 0.35, Y + 1.75, -1.8), new V3(x - 0.35, Y + 3.2, -3.2), 0.2, M(C.silver));
      cyl(g, 0.22, 3.6, M(C.silver), x - 0.35, Y + 3.1, -3.2, 12);
      cyl(g, 0.48, 1.9, M(C.silver), x - 0.35, Y + 6.3, -3.2, 16);
      cyl(g, 0.25, 0.6, M(C.silver), x - 0.35, Y + 8.2, -3.2, 12);
      smoke(g, x - 0.35, Y + 9.2, -3.2, { color: 0xa8a49c, alpha: 0.4, rise: 5.5, drift: 2 });
      rail(g, x - 1.6, -0.4, x + 1.6, -0.4, Y + 0.3);
    });
    for (const [dx, dz] of [[-1.4, -3.6], [1.4, -3.6], [-1.4, 0.6], [1.4, 0.6]]) cyl(g, 0.08, 2, M(C.steel), -9 + dx, Y, -1.5 + dz, 6);
    box(g, 3.4, 1.1, 5, M(C.silver), -9, Y + 2, -1.5);
    rail(g, -10.7, 1.1, -7.3, 1.1, Y + 3.1);
    for (const x of [-9.8, -8.2]) for (const z of [-3.2, -1.5, 0.2]) fan(g, x, Y + 3.1, z, 0.62);
    pipe(g, new V3(-7.3, Y + 2.4, -0.5), new V3(-6.1, Y + 1, -0.5), 0.12, M(C.teal));
    pipe(g, new V3(-7.3, Y + 2.4, -2.4), new V3(-6.1, Y + 1, -2.4), 0.12, M(C.teal));
    box(g, 6.4, 0.55, 4.6, M(C.conc2), 3.4, Y, 4.6);
    hcyl(g, 0.85, 4.6, M(C.silver), 3.4, Y + 0.55 + 0.85, 3.7, 'x'); hcyl(g, 0.85, 4.6, M(C.silver), 3.4, Y + 0.55 + 0.85, 5.6, 'x');
    for (const z of [3.7, 5.6]) cyl(g, 0.28, 0.25, M(C.silver), 3.4, Y + 2.25, z, 10);
    for (const [x, z] of [[-1.6, 3.9], [0.2, 3.9], [-1.6, 5.5], [0.2, 5.5]]) cyl(g, 0.05, 1.8, M(C.steel), x, Y, z, 6);
    box(g, 2.1, 0.1, 1.9, M(C.silver), -0.7, Y + 1.8, 4.7); box(g, 0.8, 0.6, 0.6, M(C.teal), -0.9, Y, 4.7);
    pipe(g, new V3(-0.5, Y + 0.4, 4.7), new V3(1.1, Y + 0.4, 4.7), 0.07, M(C.teal));
    box(g, 3.4, 2.6, 3.2, blue, 8.6, Y, -2.2); box(g, 3.6, 0.2, 3.4, M(C.silver), 8.6, Y + 2.6, -2.2);
    box(g, 0.7, 1.5, 0.05, M(C.wall), 8.2, Y, -0.58);
    trafo(g, 8.8, Y, 3.4, 1.1);
    for (const x of [7.4, 10.2]) cyl(g, 0.1, 0.9, M(C.yellow), x, Y, 4.8, 8);
  }

  /* ---------------- PLTG ---------------- */
  function buildPLTG(g) {
    box(g, 22, 0.3, 16, M(C.pad), 0, 0, 0); const Y = 0.3;
    [-3.4, 3.2].forEach((zc) => {
      for (const [dx, dz] of [[-1.1, -1.3], [1.1, -1.3], [-1.1, 1.3], [1.1, 1.3]]) cyl(g, 0.1, 1.5, M(C.steel), -8.4 + dx, Y, zc + dz, 6);
      box(g, 2.8, 3.2, 3.4, M(C.silver), -8.4, Y + 1.5, zc);
      for (let i = 0; i < 6; i++) box(g, 0.18, 0.14, 3.5, M(C.steel), -9.85, Y + 1.75 + i * 0.5, zc);
      rail(g, -9.8, zc + 1.75, -7, zc + 1.75, Y + 1.5);
      box(g, 1.8, 1.5, 1.8, M(C.silver), -6.2, Y + 1, zc);
      box(g, 5, 2.4, 2.5, M(C.blue), -3, Y, zc);
      box(g, 5.1, 0.12, 2.6, M(C.silver), -3, Y + 2.4, zc);
      box(g, 1, 0.5, 0.8, M(C.silver), -2.3, Y + 2.52, zc);
      rail(g, -5.4, zc + 1.3, -0.6, zc + 1.3, Y + 2.52);
      box(g, 2.4, 2.6, 2.6, M(C.silver), 0.9, Y, zc); box(g, 2.42, 1.3, 2.62, M(C.blue), 0.9, Y, zc);
      box(g, 1.6, 2, 2.2, M(C.silver), 2.9, Y + 0.5, zc);
      box(g, 2, 3, 2.4, M(C.silver), 4.6, Y, zc);
      cyl(g, 0.95, 9, M(C.silver), 4.6, Y + 3, zc, 24);
      ring(g, 1.2, Y + 8, 4.6, zc); ring(g, 1.2, Y + 11.2, 4.6, zc);
      smoke(g, 4.6, Y + 12.5, zc, { color: 0xd6d2c9, alpha: 0.25, rise: 5, size: 1.5, grow: 4, drift: 2.5, n: 7 });
      box(g, 1.2, 1, 1, M(C.wall), -1, Y, zc + 2.1);
    });
    pipe(g, new V3(-6, Y + 0.3, 6.4), new V3(5, Y + 0.3, 6.4), 0.1, M(C.teal));
    gantry(g, 8.6, -3, 3.6, 4.2); gantry(g, 8.6, 1, 3.6, 4.2); gantry(g, 8.6, 5, 3.6, 4.2);
    trafo(g, 8.6, Y, -1, 1); trafo(g, 8.6, Y, 3, 1);
    box(g, 3, 2.3, 2.2, M(C.wall), 5.6, Y, 6.4); box(g, 3.2, 0.15, 2.4, M(C.silver), 5.6, Y + 2.3, 6.4); box(g, 0.6, 1.4, 0.05, M(C.blue), 5.6, Y, 7.52);
  }

  /* ---------------- PLTGU ---------------- */
  function buildPLTGU(g) {
    box(g, 24, 0.3, 18, M(C.pad), 0, 0, 0); const Y = 0.3;
    [-5.4, -0.6].forEach((zc) => {
      box(g, 2.6, 2.6, 3, M(C.silver), -10, Y, zc);
      for (let i = 0; i < 5; i++) box(g, 0.16, 0.14, 3.1, M(C.steel), -11.35, Y + 0.4 + i * 0.45, zc);
      box(g, 3.2, 2.3, 2.5, M(C.blue), -7.1, Y, zc); box(g, 3.3, 0.12, 2.6, M(C.silver), -7.1, Y + 2.3, zc);
      hcyl(g, 0.95, 1.8, M(C.silver), -4.6, Y + 1.4, zc, 'x');
      box(g, 3.2, 6.6, 3.2, M(C.silver), -2.1, Y, zc);
      for (const [dx, dz] of [[-1.7, -1.7], [1.7, -1.7], [-1.7, 1.7], [1.7, 1.7]]) box(g, 0.18, 7.2, 0.18, M(C.blue), -2.1 + dx, Y, zc + dz);
      for (const y of [2.4, 4.8]) rail(g, -3.8, zc + 1.75, -0.4, zc + 1.75, Y + y);
      cyl(g, 0.75, 5.4, M(C.silver), -1.6, Y + 6.6, zc, 20);
      ring(g, 0.95, Y + 7.2, -1.6, zc, C.blue); ring(g, 0.95, Y + 11.4, -1.6, zc);
      smoke(g, -1.6, Y + 12.6, zc, { color: 0xd6d2c9, alpha: 0.22, rise: 5, size: 1.4, grow: 4, drift: 2.5, n: 7 });
      pipe(g, new V3(-0.5, Y + 5.6, zc), new V3(2, Y + 5.6, zc), 0.22, M(C.silver));
      pipe(g, new V3(2, Y + 5.6, zc), new V3(2.4, Y + 3.6, -3), 0.22, M(C.silver));
      pipe(g, new V3(-0.5, Y + 4.2, zc + 0.6), new V3(2.4, Y + 3, -2.4), 0.12, M(C.teal));
    });
    for (const z of [-5.4, -3, -0.6]) box(g, 0.18, 5.4, 0.18, M(C.blue), 2, Y, z);
    box(g, 6.6, 4.4, 5.2, M(C.wall), 5.8, Y, -3.2); box(g, 6.62, 1.2, 5.22, M(C.blue), 5.8, Y + 3.2, -3.2);
    box(g, 6.8, 0.15, 5.4, M(C.silver), 5.8, Y + 4.4, -3.2);
    for (const x of [4.2, 5.8, 7.4]) box(g, 0.8, 0.4, 0.8, M(C.silver), x, Y + 4.55, -3.2);
    box(g, 1.4, 1.4, 1.4, M(C.blue), 3.6, Y, -0.2);
    for (const x of [2.6, 5.6, 8.6]) for (const z of [3, 5.6]) box(g, 0.22, 3.2, 0.22, M(C.blue), x, Y, z);
    box(g, 7.4, 1.1, 3.6, M(C.dark), 5.6, Y + 2.2, 4.3);
    box(g, 7.6, 0.25, 3.8, M(C.silver), 5.6, Y + 3.3, 4.3);
    rail(g, 1.8, 6.25, 9.4, 6.25, Y + 3.55);
    for (let i = 0; i < 4; i++) for (const z of [3.4, 5.2]) fan(g, 2.8 + i * 1.9, Y + 3.55, z, 0.78);
    pipe(g, new V3(5.8, Y + 4.4, -0.6), new V3(5.8, Y + 3.3, 2.5), 0.3, M(C.teal));
    gantry(g, -7.5, 4, 4, 4.4); gantry(g, -3.5, 4, 4, 4.4);
    trafo(g, -8.2, Y, 6.4, 1); trafo(g, -5.5, Y, 6.4, 1); trafo(g, -2.8, Y, 6.4, 1);
    box(g, 10, 0.08, 4.4, M(0xb7b3aa), -5.5, Y, 5.6);
  }

  /* ---------------- road ---------------- */
  const curve = new THREE.CatmullRomCurve3([
    new V3(0, 0, 60), new V3(3, 0, 25), new V3(-8, 0, -10), new V3(6, 0, -50), new V3(-6, 0, -90), new V3(8, 0, -130), new V3(0, 0, -175)
  ], false, 'catmullrom', 0.5);
  const RW = 2.6;
  const flatMat = (c) => new THREE.MeshStandardMaterial({ color: c, roughness: 0.95, side: THREE.DoubleSide });
  function ribbon(off, w, y, mat) {
    const N = lite ? 320 : 600, pos = [], idx = [];
    for (let i = 0; i <= N; i++) {
      const u = i / N, p = curve.getPointAt(u), t = curve.getTangentAt(u), n = new V3(-t.z, 0, t.x).normalize();
      const a = p.clone().addScaledVector(n, off + w / 2), b = p.clone().addScaledVector(n, off - w / 2);
      pos.push(a.x, y, a.z, b.x, y, b.z);
      if (i < N) { const k = i * 2; idx.push(k, k + 1, k + 2, k + 1, k + 3, k + 2); }
    }
    const geo = new THREE.BufferGeometry();
    geo.setAttribute('position', new THREE.Float32BufferAttribute(pos, 3)); geo.setIndex(idx); geo.computeVertexNormals();
    const m = new THREE.Mesh(geo, mat); m.receiveShadow = shadows; scene.add(m);
  }
  ribbon(0, RW * 2 + 1.6, 0.02, flatMat(0xcdcabf));
  ribbon(0, RW * 2, 0.04, flatMat(C.road));
  ribbon(RW - 0.25, 0.12, 0.05, flatMat(0xf4f2ec));
  ribbon(-RW + 0.25, 0.12, 0.05, flatMat(0xf4f2ec));
  const roadSamples = []; for (let i = 0; i <= 200; i++) roadSamples.push(curve.getPointAt(i / 200));

  // centre dashes + street lights, merged into one mesh
  const decor = new THREE.Group(); scene.add(decor);
  {
    const dm = M(0xffd500);
    for (let i = 0; i <= 300; i += 2) {
      const u = i / 300, p = curve.getPointAt(u), t = curve.getTangentAt(u);
      const d = new THREE.Mesh(new THREE.BoxGeometry(0.14, 0.02, 1.6), dm);
      d.position.set(p.x, 0.06, p.z); d.rotation.y = Math.atan2(t.x, t.z); decor.add(d);
    }
    const pm = M(C.steel), lamp = M(0xfff1c2);
    const L = lite ? 30 : 60;
    for (let i = 0; i <= L; i++) {
      const u = i / L, p = curve.getPointAt(u), t = curve.getTangentAt(u), n = new V3(-t.z, 0, t.x).normalize();
      const side = i % 2 ? 1 : -1, q = p.clone().addScaledVector(n, side * (RW + 1.3));
      const g = new THREE.Group(); g.position.copy(q); g.rotation.y = Math.atan2(-n.x * side, -n.z * side); decor.add(g);
      cyl(g, 0.07, 4.2, pm, 0, 0, 0, 6); box(g, 0.08, 0.08, 1.2, pm, 0, 4.1, 0.55); box(g, 0.25, 0.1, 0.5, lamp, 0, 4.05, 1.1);
    }
  }
  bake(decor);

  /* ---------------- plant sites along the road ---------------- */
  const stopsDef = [{ u: 0.25, side: 1, build: buildPLTD }, { u: 0.52, side: -1, build: buildPLTG }, { u: 0.79, side: 1, build: buildPLTGU }];
  const sites = [];
  stopsDef.forEach((s) => {
    const p = curve.getPointAt(s.u), t = curve.getTangentAt(s.u), n = new V3(-t.z, 0, t.x).normalize();
    const center = p.clone().addScaledVector(n, s.side * (RW + 13));
    const toRoad = n.clone().multiplyScalar(-s.side);
    const g = new THREE.Group(); g.position.copy(center); g.rotation.y = Math.atan2(toRoad.x, toRoad.z); scene.add(g);
    s.build(g);
    bake(g);                                           // whole site = 1 mesh (+ fans, smoke)
    const dw = new THREE.Mesh(new THREE.BoxGeometry(3.2, 0.05, 6), flatMat(C.road));
    dw.position.copy(p.clone().addScaledVector(n, s.side * (RW + 2.6))); dw.position.y = 0.035; dw.rotation.y = g.rotation.y; dw.receiveShadow = shadows; scene.add(dw);
    sites.push({ center });
  });

  /* ---------------- ground, trees, towers ---------------- */
  const ground = new THREE.Mesh(new THREE.PlaneGeometry(800, 800), new THREE.MeshStandardMaterial({ color: C.ground, roughness: 1 }));
  ground.rotation.x = -PI / 2; ground.receiveShadow = shadows; scene.add(ground);
  {
    const N = lite ? 260 : 600;
    const geo = new THREE.IcosahedronGeometry(1.3, lite ? 0 : 1); geo.scale(1, 1.15, 1); geo.translate(0, 2.4, 0);
    const tg = new THREE.CylinderGeometry(0.14, 0.2, 1.4, 5); tg.translate(0, 0.7, 0);
    const im = new THREE.InstancedMesh(geo, M(C.tree), N); im.castShadow = shadows; im.receiveShadow = shadows;
    const it = new THREE.InstancedMesh(tg, M(0x8a7a64), N);
    const d = new THREE.Object3D(); let k = 0, tries = 0;
    while (k < N && tries < 20000) {
      tries++;
      const x = (Math.random() - 0.5) * 190, z = -200 + Math.random() * 290, q = new V3(x, 0, z);
      if (roadSamples.some((r) => r.distanceToSquared(q) < 64)) continue;
      if (sites.some((s) => s.center.distanceToSquared(q) < 420)) continue;
      const s = 0.7 + Math.random() * 0.9;
      d.position.set(x, 0, z); d.scale.set(s, s * (0.8 + Math.random() * 0.6), s); d.rotation.y = Math.random() * PI; d.updateMatrix();
      im.setMatrixAt(k, d.matrix); it.setMatrixAt(k, d.matrix); k++;
    }
    im.count = k; it.count = k; scene.add(im); scene.add(it);
  }
  {
    const towers = new THREE.Group(); scene.add(towers);
    const pts = [[30, 40], [34, 0], [28, -40], [33, -80], [27, -120], [31, -160]], tops = [];
    const lattice = M(C.steel, { wireframe: true });
    pts.forEach(([x, z]) => {
      const g = new THREE.Group(); g.position.set(x, 0, z); towers.add(g);
      add(g, new THREE.CylinderGeometry(0.15, 1.3, 11, 4, 1, true), lattice, 0, 5.5, 0);
      box(g, 4.4, 0.14, 0.14, M(C.steel), 0, 9.2, 0); box(g, 3.2, 0.14, 0.14, M(C.steel), 0, 10.4, 0);
      tops.push([new V3(x - 2.1, 9.1, z), new V3(x + 2.1, 9.1, z), new V3(x - 1.5, 10.3, z), new V3(x + 1.5, 10.3, z)]);
    });
    bake(towers);
    // all wires in a single line-segments object
    const segs = [];
    for (let i = 0; i < tops.length - 1; i++) for (let k = 0; k < 4; k++) {
      const a = tops[i][k], b = tops[i + 1][k], m = a.clone().add(b).multiplyScalar(0.5); m.y -= 1.6;
      const pts2 = new THREE.QuadraticBezierCurve3(a, m, b).getPoints(lite ? 12 : 20);
      for (let j = 0; j < pts2.length - 1; j++) segs.push(pts2[j], pts2[j + 1]);
    }
    scene.add(new THREE.LineSegments(new THREE.BufferGeometry().setFromPoints(segs), new THREE.LineBasicMaterial({ color: 0x8a867d })));
  }

  /* ---------------- traffic (each vehicle baked to 1 mesh) ---------------- */
  function car(col) {
    const g = new THREE.Group(); box(g, 0.95, 0.5, 2, M(col), 0, 0.18, 0); box(g, 0.85, 0.42, 1.05, M(C.dark), 0, 0.68, -0.15);
    for (const [x, z] of [[-0.48, 0.65], [0.48, 0.65], [-0.48, -0.65], [0.48, -0.65]]) hcyl(g, 0.2, 0.14, M(0x222222), x, 0.2, z, 'x');
    return g;
  }
  function tanker() { const g = new THREE.Group(); box(g, 1.1, 1, 1.1, M(0xe31e24), 0, 0.25, 1.4); box(g, 1, 0.2, 3.6, M(C.dark), 0, 0.25, -0.4); hcyl(g, 0.6, 3.2, M(C.silver), 0, 1.05, -0.6, 'z'); return g; }
  function truck() { const g = new THREE.Group(); box(g, 1.1, 1, 1.1, M(C.blue), 0, 0.25, 1.4); box(g, 1.2, 1.4, 3.2, M(C.wall), 0, 0.3, -0.5); return g; }
  const vehicles = [];
  [[tanker(), 0, 1], [car(0xf5f5f2), 0.12, 1], [car(0xc9332b), 0.41, 1], [truck(), 0.63, 1], [car(0x9aa3ab), 0.85, 1],
    [car(0xf5f5f2), 0.05, -1], [truck(), 0.3, -1], [car(0x2f8a85), 0.55, -1], [tanker(), 0.78, -1]].forEach(([m, u0, dir]) => {
    scene.add(m); bake(m); vehicles.push({ m, u0, dir, spd: 0.018 + Math.random() * 0.006 });
  });

  /* ---------------- camera: calm aerial glide driven by page scroll ---------------- */
  const outroShot = { p: new V3(95, 95, 10), l: new V3(0, 0, -60) };
  const ss = (a, b, x) => { x = Math.min(1, Math.max(0, (x - a) / (b - a))); return x * x * (3 - 2 * x); };
  const progress = () => {
    const total = document.documentElement.scrollHeight - innerHeight;
    return Math.min(1, Math.max(0, scrollY / Math.max(1, total)));
  };
  const OFF = new V3(24, 27, 34);                       // fixed viewing angle: the camera slides, never swings
  const tgtP = new V3(), tgtL = new V3(), _p = new V3();
  let uS = 0;
  function computeTarget(pr, snap) {
    const uT = 0.02 + 0.9 * pr;
    uS = snap ? uT : uS + (uT - uS) * 0.035;
    _p.copy(curve.getPointAt(Math.min(uS, 1)));
    tgtL.copy(_p); tgtL.y = 0;
    tgtP.copy(_p).add(OFF);
    const w = ss(0.88, 1, pr);
    tgtP.lerp(outroShot.p, w); tgtL.lerp(outroShot.l, w);
  }

  function resize() {
    renderer.setSize(innerWidth, innerHeight, false);
    camera.aspect = innerWidth / innerHeight; camera.updateProjectionMatrix();
    needsRender = true;
  }
  let needsRender = true;
  addEventListener('resize', resize, { passive: true });
  resize();

  let mx = 0, my = 0, tx = 0, ty = 0;
  if (!lite) addEventListener('pointermove', (e) => { mx = e.clientX / innerWidth - 0.5; my = e.clientY / innerHeight - 0.5; }, { passive: true });

  const camP = new V3(), camL = new V3();
  computeTarget(progress(), true); camP.copy(tgtP); camL.copy(tgtL);

  const clock = new THREE.Clock();
  let last = 0, raf = 0;
  const idleGap = lite ? 50 : 33;                       // ms between frames when nothing is moving fast
  // While a playing video is on screen the GPU is shared with the video decoder.
  // Keep the full frame rate (smooth motion) but make each frame cheaper:
  // lower resolution behind the video and shadows refreshed only every few frames.
  const fullRatio = Math.min(window.devicePixelRatio || 1, lite ? 1.25 : 1.5);
  let light = false, frameNo = 0;
  addEventListener('world:slow', () => {
    if (light) return;
    light = true;
    renderer.setPixelRatio(Math.min(1, fullRatio));
    renderer.setSize(innerWidth, innerHeight, false);
    if (shadows) renderer.shadowMap.autoUpdate = false;
  });
  addEventListener('world:normal', () => {
    if (!light) return;
    light = false;
    renderer.setPixelRatio(fullRatio);
    renderer.setSize(innerWidth, innerHeight, false);
    if (shadows) renderer.shadowMap.autoUpdate = true;
    needsRender = true;
  });

  function frame(now) {
    raf = requestAnimationFrame(frame);
    if (document.hidden) return;

    computeTarget(progress(), reduce);
    const k = reduce ? 1 : 0.05;
    const moving = camP.distanceToSquared(tgtP) > 0.0025 || Math.abs(mx - tx) > 0.002 || Math.abs(my - ty) > 0.002 || needsRender;
    if (!moving && now - last < idleGap) return;
    if (reduce && !moving) return;                      // fully static when the user prefers less motion
    last = now; needsRender = false;

    camP.lerp(tgtP, k); camL.lerp(tgtL, k);
    tx += (mx - tx) * 0.05; ty += (my - ty) * 0.05;
    camera.position.set(camP.x + tx * 0.8, camP.y - ty * 0.5, camP.z);
    camera.lookAt(camL);
    if (shadows) { sun.position.set(camL.x - 30, 60, camL.z + 35); sun.target.position.copy(camL); }

    const t = clock.getElapsedTime();
    if (!reduce) {
      for (let j = 0; j < fans.length; j++) fans[j].rotation.y = t * (4 + (j % 3));
      for (const e of emitters) {
        const o = e.o;
        for (const sp of e.s) {
          const life = (t * o.speed + sp.userData.off) % 1;
          sp.position.set(e.b.x + life * o.drift, e.b.y + life * o.rise, e.b.z - life * o.drift * 0.3);
          const s = o.size + life * o.grow; sp.scale.set(s, s, 1);
          sp.material.opacity = o.alpha * Math.min(1, life * 6) * (1 - life);
        }
      }
    }
    for (const v of vehicles) {
      let u = (v.u0 + (reduce ? 0 : t) * v.spd * v.dir) % 1; if (u < 0) u += 1;
      const p = curve.getPointAt(u), tg = curve.getTangentAt(u);
      v.m.position.set(p.x + tg.z * 1.25 * v.dir, 0.04, p.z - tg.x * 1.25 * v.dir);
      v.m.rotation.y = Math.atan2(tg.x, tg.z) + (v.dir < 0 ? PI : 0);
    }
    if (light && shadows && (frameNo++ % 4 === 0)) renderer.shadowMap.needsUpdate = true;
    renderer.render(scene, camera);
  }
  raf = requestAnimationFrame(frame);
  canvas.classList.add('ready');

  return {
    dispose() { cancelAnimationFrame(raf); renderer.dispose(); }
  };
}
