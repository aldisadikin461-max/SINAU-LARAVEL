/**
 * Sinau — Floating Particle Animation
 * Inspired by Antigravity / modern SaaS landing pages
 * Colorful drifting dots that float across the entire screen
 */
(function () {
  'use strict';

  /* ── Config ─────────────────────────────────────────── */
  const CFG = {
    count:      55,     // number of particles
    minR:       2,      // min radius px
    maxR:       5.5,    // max radius px
    minSpeed:   0.25,   // min drift speed
    maxSpeed:   0.65,   // max drift speed
    minOpacity: 0.35,
    maxOpacity: 0.75,
    colors: [
      '#3B82F6', // blue-500
      '#60A5FA', // blue-400
      '#818CF8', // indigo-400
      '#A78BFA', // violet-400
      '#F97316', // orange-500
      '#FB923C', // orange-400
      '#F43F5E', // rose-500
      '#34D399', // emerald-400
      '#2563EB', // blue-600
      '#C084FC', // purple-400
    ],
    fps: 60,
  };

  /* ── Canvas Setup ───────────────────────────────────── */
  const canvas = document.createElement('canvas');
  canvas.id = 'sinau-particles';
  document.body.appendChild(canvas);
  const ctx = canvas.getContext('2d');

  function resize() {
    canvas.width  = window.innerWidth;
    canvas.height = window.innerHeight;
  }
  resize();
  window.addEventListener('resize', resize);

  /* ── Particle Factory ───────────────────────────────── */
  function rand(min, max) { return min + Math.random() * (max - min); }

  function createParticle(forced) {
    const r      = rand(CFG.minR, CFG.maxR);
    const speed  = rand(CFG.minSpeed, CFG.maxSpeed);
    const angle  = rand(0, Math.PI * 2);   // random direction
    const color  = CFG.colors[Math.floor(Math.random() * CFG.colors.length)];
    const opacity = rand(CFG.minOpacity, CFG.maxOpacity);
    const shape  = Math.random() > 0.35 ? 'circle' : 'pill'; // mix of round dots + tiny pills like screenshot

    return {
      x:       forced ? rand(0, canvas.width) : rand(-50, canvas.width + 50),
      y:       forced ? rand(0, canvas.height): rand(-50, canvas.height + 50),
      r,
      vx:      Math.cos(angle) * speed,
      vy:      Math.sin(angle) * speed,
      color,
      opacity,
      shape,
      // Gentle wander: slowly shift direction over time
      waveX:   rand(0, Math.PI * 2),
      waveY:   rand(0, Math.PI * 2),
      waveSpd: rand(0.003, 0.009),
      waveAmp: rand(0.08, 0.22),
    };
  }

  const particles = Array.from({ length: CFG.count }, () => createParticle(true));

  /* ── Draw ───────────────────────────────────────────── */
  function drawParticle(p) {
    ctx.save();
    ctx.globalAlpha = p.opacity;
    ctx.fillStyle   = p.color;

    if (p.shape === 'pill') {
      // Small pill / capsule (like the Antigravity screenshot)
      const w = p.r * 2.8;
      const h = p.r * 1.1;
      ctx.beginPath();
      ctx.roundRect(p.x - w / 2, p.y - h / 2, w, h, h / 2);
      ctx.fill();
    } else {
      ctx.beginPath();
      ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
      ctx.fill();
    }

    ctx.restore();
  }

  /* ── Animate ────────────────────────────────────────── */
  let last = 0;
  const interval = 1000 / CFG.fps;

  function animate(ts) {
    if (ts - last < interval) { requestAnimationFrame(animate); return; }
    last = ts;

    ctx.clearRect(0, 0, canvas.width, canvas.height);

    particles.forEach(p => {
      // Gentle sinusoidal wander
      p.waveX += p.waveSpd;
      p.waveY += p.waveSpd * 1.3;
      p.x += p.vx + Math.sin(p.waveX) * p.waveAmp;
      p.y += p.vy + Math.cos(p.waveY) * p.waveAmp;

      // Wrap around edges (seamless loop)
      const pad = 30;
      if (p.x < -pad)              p.x = canvas.width + pad;
      if (p.x > canvas.width + pad) p.x = -pad;
      if (p.y < -pad)              p.y = canvas.height + pad;
      if (p.y > canvas.height + pad) p.y = -pad;

      drawParticle(p);
    });

    requestAnimationFrame(animate);
  }

  /* ── Start ──────────────────────────────────────────── */
  // Wait for polyfill if roundRect is not supported
  if (typeof ctx.roundRect !== 'function') {
    ctx.roundRect = function (x, y, w, h, r) {
      this.beginPath();
      this.moveTo(x + r, y);
      this.arcTo(x + w, y, x + w, y + h, r);
      this.arcTo(x + w, y + h, x, y + h, r);
      this.arcTo(x, y + h, x, y, r);
      this.arcTo(x, y, x + w, y, r);
      this.closePath();
    };
  }

  requestAnimationFrame(animate);
})();
