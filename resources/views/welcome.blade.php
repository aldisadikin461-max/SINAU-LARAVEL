<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sinau — Platform Belajar Mandiri SMKN 1 Purwokerto</title>
  <meta name="description" content="Platform belajar mandiri terlengkap untuk Smeconers. Latihan soal, e-book, leaderboard, study plan, dan streak harian.">
  @vite(['resources/css/app.css','resources/js/app.js'])
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/sinau.css') }}">
  <style>
    /* ═══════════════════════════════════════════════════
       SINAU LANDING PAGE — Spatial Premium Design
       ═══════════════════════════════════════════════════ */
    :root {
      --blue:    #2563EB;
      --blue-d:  #1D4ED8;
      --blue-l:  #3B82F6;
      --blue-xl: #60A5FA;
      --sky:     #0EA5E9;
      --orange:  #F97316;
      --violet:  #8B5CF6;
      --green:   #10B981;
      --bg:      #F0F5FF;
      --text:    #0F172A;
      --muted:   #64748B;
      --surface: #FFFFFF;
    }

    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
    html{font-family:'Plus Jakarta Sans','Inter',sans-serif;color:var(--text);-webkit-font-smoothing:antialiased;}

    body {
      background: var(--bg);
      background-image:
        radial-gradient(ellipse 80% 50% at 20% 0%, rgba(37,99,235,0.10) 0%, transparent 60%),
        radial-gradient(ellipse 60% 40% at 100% 20%, rgba(14,165,233,0.08) 0%, transparent 55%),
        radial-gradient(ellipse 50% 50% at 80% 100%, rgba(249,115,22,0.06) 0%, transparent 50%);
      overflow-x:hidden;
    }

    /* ── NAVBAR ──────────────────────────────────────── */
    .lp-nav {
      position: fixed; top: 0; width: 100%; z-index: 100;
      padding: 0 2rem;
      background: rgba(240,245,255,0.80);
      backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px);
      border-bottom: 1px solid rgba(255,255,255,0.9);
      box-shadow: 0 2px 20px rgba(37,99,235,0.06);
    }
    .lp-nav-inner {
      max-width: 1200px; margin: 0 auto;
      display: flex; align-items: center; justify-content: space-between;
      height: 68px;
    }
    .lp-brand {
      display: flex; align-items: center; gap: 0.6rem;
      font-size: 1.5rem; font-weight: 900; color: var(--blue);
      text-decoration: none; letter-spacing: -0.03em;
    }
    .lp-brand-cat { font-size: 1.7rem; animation: lp-wiggle 4s ease-in-out infinite; display:inline-block; }
    @keyframes lp-wiggle{0%,100%{transform:rotate(0);}20%{transform:rotate(-12deg);}40%{transform:rotate(10deg);}60%{transform:rotate(-7deg);}80%{transform:rotate(5deg);}}
    .lp-nav-links { display:flex; align-items:center; gap:0.75rem; }
    .lp-btn-ghost {
      padding: 0.5rem 1.3rem; border-radius: 999px;
      color: var(--blue); font-weight: 700; font-size: 0.9rem;
      text-decoration: none;
      border: 1.5px solid rgba(37,99,235,0.2);
      background: rgba(37,99,235,0.04);
      transition: all 0.2s;
    }
    .lp-btn-ghost:hover { background: rgba(37,99,235,0.1); border-color: var(--blue); }
    .lp-btn-solid {
      padding: 0.55rem 1.5rem; border-radius: 999px;
      background: linear-gradient(135deg, var(--blue), var(--blue-l));
      color: #fff; font-weight: 800; font-size: 0.9rem;
      text-decoration: none;
      box-shadow: 0 4px 14px rgba(37,99,235,0.35), inset 0 1px 0 rgba(255,255,255,0.2);
      transition: all 0.25s;
    }
    .lp-btn-solid:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(37,99,235,0.45); }

    /* ── HERO SECTION ────────────────────────────────── */
    .lp-hero {
      min-height: 100vh;
      display: flex; align-items: center;
      padding: 6rem 2rem 4rem;
      max-width: 1200px; margin: 0 auto;
    }
    .lp-hero-inner {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 5rem; align-items: center; width: 100%;
    }
    @media(max-width:900px){
      .lp-hero-inner { grid-template-columns:1fr; gap:3rem; text-align:center; }
      .lp-hero-right { order:-1; }
      .lp-hero-cta,.lp-hero-badges { justify-content:center; }
    }

    /* Hero Text */
    .lp-overtitle {
      display: inline-flex; align-items: center; gap: 0.4rem;
      background: rgba(37,99,235,0.07);
      border: 1.5px solid rgba(37,99,235,0.15);
      color: var(--blue); border-radius: 999px;
      padding: 0.35rem 1.1rem; font-size: 0.82rem; font-weight: 800;
      margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 0.06em;
    }
    .lp-headline {
      font-size: clamp(2.8rem, 5.5vw, 5rem);
      font-weight: 900; line-height: 1.05;
      letter-spacing: -0.04em; color: var(--text);
      margin-bottom: 1.5rem;
    }
    .lp-headline .h-blue   { color: var(--blue); }
    .lp-headline .h-orange { color: var(--orange); }
    .lp-headline .h-grad {
      background: linear-gradient(135deg, var(--blue) 0%, var(--sky) 50%, var(--violet) 100%);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
    }
    .lp-desc {
      font-size: 1.1rem; color: var(--muted); line-height: 1.8;
      font-weight: 500; margin-bottom: 2.5rem; max-width: 480px;
    }
    .lp-desc .hl { color: var(--orange); font-weight: 800; }
    .lp-hero-cta { display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 2rem; }
    .lp-cta-main {
      padding: 1rem 2.4rem; border-radius: 999px;
      background: linear-gradient(135deg, var(--blue) 0%, var(--blue-l) 100%);
      color: #fff; font-size: 1rem; font-weight: 800;
      text-decoration: none; letter-spacing: 0.01em;
      box-shadow: 0 8px 28px rgba(37,99,235,0.4), inset 0 1px 0 rgba(255,255,255,0.2);
      transition: all 0.3s cubic-bezier(0.34,1.56,0.64,1);
      display: inline-flex; align-items: center; gap: 0.5rem;
    }
    .lp-cta-main:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(37,99,235,0.5), inset 0 1px 0 rgba(255,255,255,0.2); }
    .lp-cta-ghost {
      padding: 1rem 2.4rem; border-radius: 999px;
      background: rgba(255,255,255,0.9); border: 1.5px solid rgba(37,99,235,0.15);
      color: var(--text); font-size: 1rem; font-weight: 700;
      text-decoration: none; transition: all 0.2s;
      display: inline-flex; align-items: center; gap: 0.5rem;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .lp-cta-ghost:hover { border-color: var(--blue); color: var(--blue); transform: translateY(-2px); }
    .lp-hero-badges { display:flex; gap:0.6rem; flex-wrap:wrap; }
    .lp-badge {
      background: rgba(255,255,255,0.9); border: 1px solid rgba(0,0,0,0.06);
      border-radius: 999px; padding: 0.4rem 0.9rem;
      font-size: 0.8rem; font-weight: 700; color: #475569;
      display: inline-flex; align-items: center; gap: 0.3rem;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    /* Hero Right — Kinners */
    .lp-hero-right { display:flex; justify-content:center; align-items:center; }
    .lp-kinners-stage {
      position: relative; width: 420px; height: 420px;
      display: flex; align-items: center; justify-content: center;
    }
    @media(max-width:600px){ .lp-kinners-stage{ width:300px;height:300px; } }
    .lp-kinners-blob {
      position: absolute; inset: 0;
      background: radial-gradient(ellipse at center, rgba(37,99,235,0.12) 0%, transparent 70%);
      animation: lp-pulse 4s ease-in-out infinite;
      border-radius: 50%;
    }
    @keyframes lp-pulse{0%,100%{transform:scale(1);}50%{transform:scale(1.08);}}
    .lp-kinners-float { animation: lp-float 4s ease-in-out infinite; position:relative; z-index:2; }
    @keyframes lp-float{0%,100%{transform:translateY(0);}50%{transform:translateY(-18px);}}
    .lp-kinners-float svg { filter: drop-shadow(0 24px 48px rgba(37,99,235,0.2)); }
    .lp-speech {
      position: absolute; top: 12%; right: -10px;
      background: #fff; border: 1.5px solid rgba(37,99,235,0.15);
      border-radius: 1.2rem 1.2rem 1.2rem 0;
      padding: 0.75rem 1.1rem; font-size: 0.88rem; font-weight: 700;
      color: var(--blue); font-style: italic; line-height: 1.5;
      box-shadow: 0 8px 24px rgba(37,99,235,0.12);
      white-space: nowrap; z-index: 3;
      animation: lp-float 4s ease-in-out infinite;
      animation-delay: 0.5s;
    }
    /* Floating mini cards around mascot */
    .lp-float-card {
      position: absolute; background: #fff;
      border: 1px solid rgba(37,99,235,0.1);
      border-radius: 1rem; padding: 0.6rem 1rem;
      box-shadow: 0 8px 24px rgba(37,99,235,0.1);
      font-size: 0.8rem; font-weight: 800;
      display: flex; align-items: center; gap: 0.4rem; z-index: 3;
      white-space: nowrap;
    }
    .lp-fc-1 { top: 8%; left: 0; animation: lp-float 5s ease-in-out infinite; color: var(--orange); }
    .lp-fc-2 { bottom: 20%; right: -15px; animation: lp-float 4.5s ease-in-out infinite; animation-delay:1s; color: var(--green); }
    .lp-fc-3 { bottom: 5%; left: 5%; animation: lp-float 5.5s ease-in-out infinite; animation-delay:0.8s; color: var(--violet); }

    /* ── STATS STRIP ─────────────────────────────────── */
    .lp-stats {
      background: rgba(255,255,255,0.7);
      backdrop-filter: blur(20px); border-top: 1px solid rgba(255,255,255,0.9);
      border-bottom: 1px solid rgba(255,255,255,0.9);
      padding: 2rem;
    }
    .lp-stats-inner {
      max-width:1200px; margin: 0 auto;
      display: grid; grid-template-columns: repeat(5,1fr); gap: 1rem;
    }
    @media(max-width:800px){ .lp-stats-inner { grid-template-columns:repeat(3,1fr); } }
    @media(max-width:500px){ .lp-stats-inner { grid-template-columns:repeat(2,1fr); } }
    .lp-stat { text-align:center; padding: 1rem; }
    .lp-stat-num {
      font-size: 2.4rem; font-weight: 900; letter-spacing:-0.04em;
      background: linear-gradient(135deg, var(--blue), var(--sky));
      -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
    }
    .lp-stat-label { font-size:0.8rem; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:0.06em; margin-top:0.2rem; }

    /* ── FEATURES BENTO ──────────────────────────────── */
    .lp-section { max-width:1200px; margin:0 auto; padding:5rem 2rem; }
    .lp-section-head { text-align:center; margin-bottom:3.5rem; }
    .lp-section-head .overtag {
      display:inline-flex; align-items:center; gap:0.4rem;
      background:rgba(37,99,235,0.07); border:1.5px solid rgba(37,99,235,0.15);
      color:var(--blue); border-radius:999px; padding:0.3rem 1rem;
      font-size:0.78rem; font-weight:800; text-transform:uppercase; letter-spacing:0.07em;
      margin-bottom:1rem;
    }
    .lp-section-head h2 {
      font-size: clamp(2rem,4vw,3rem); font-weight:900; letter-spacing:-0.035em;
      color:var(--text); margin-bottom:0.75rem;
    }
    .lp-section-head p { font-size:1.05rem; color:var(--muted); font-weight:500; line-height:1.7; max-width:560px; margin:0 auto; }

    /* Bento Feature Grid */
    .lp-feat-bento {
      display: grid;
      grid-template-columns: repeat(3,1fr);
      grid-template-rows: auto auto;
      gap: 1.25rem;
    }
    @media(max-width:900px){ .lp-feat-bento { grid-template-columns:repeat(2,1fr); } }
    @media(max-width:600px){ .lp-feat-bento { grid-template-columns:1fr; } }
    .lp-feat-bento .big { grid-column: span 2; }
    @media(max-width:900px){ .lp-feat-bento .big { grid-column: span 2; } }
    @media(max-width:600px){ .lp-feat-bento .big { grid-column: span 1; } }

    .lp-feat-card {
      background: var(--surface); border-radius: 1.75rem;
      border: 1px solid rgba(255,255,255,0.95);
      padding: 2rem; box-shadow: 0 4px 14px rgba(37,99,235,0.06);
      transition: all 0.35s cubic-bezier(0.34,1.56,0.64,1);
      position: relative; overflow: hidden;
    }
    .lp-feat-card::before {
      content:''; position:absolute; top:0; left:0; right:0; height:3px;
      background: var(--fc, linear-gradient(90deg,var(--blue),var(--sky)));
      transform:scaleX(0); transform-origin:left; transition:transform 0.35s ease;
    }
    .lp-feat-card:hover { transform:translateY(-6px); box-shadow:0 20px 48px rgba(37,99,235,0.12); }
    .lp-feat-card:hover::before { transform:scaleX(1); }
    .lp-feat-ico {
      width:3.5rem; height:3.5rem; border-radius:1rem;
      display:flex; align-items:center; justify-content:center;
      font-size:1.6rem; margin-bottom:1.25rem;
      background: var(--fi, rgba(37,99,235,0.07));
    }
    .lp-feat-card h3 { font-size:1.15rem; font-weight:800; color:var(--text); margin-bottom:0.5rem; }
    .lp-feat-card p  { font-size:0.9rem; color:var(--muted); line-height:1.7; font-weight:500; }

    /* Big feature — Streak Bento */
    .lp-streak-bento {
      background: linear-gradient(135deg, #FFF7ED 0%, #FFEDD5 100%);
      border: 1px solid rgba(249,115,22,0.15);
      display: flex; align-items: center; gap: 2rem; flex-wrap: wrap;
    }
    .lp-streak-bento .lp-feat-ico { background:rgba(249,115,22,0.1); }
    .lp-streak-num {
      font-size: 5rem; font-weight: 900; color: #EA580C;
      line-height:1; letter-spacing:-0.04em;
    }
    .lp-streak-label { font-size:1rem; font-weight:700; color:#92400E; margin-top:0.25rem; }

    /* ── HOW IT WORKS ─────────────────────────────────── */
    .lp-steps { display:grid; grid-template-columns:repeat(3,1fr); gap:2rem; }
    @media(max-width:768px){ .lp-steps { grid-template-columns:1fr; } }
    .lp-step { text-align:center; }
    .lp-step-num {
      width:3.5rem; height:3.5rem; border-radius:50%;
      background: linear-gradient(135deg, var(--blue), var(--blue-l));
      color:#fff; font-size:1.2rem; font-weight:900;
      display:flex; align-items:center; justify-content:center;
      margin:0 auto 1.25rem;
      box-shadow: 0 4px 14px rgba(37,99,235,0.35);
    }
    .lp-step h3 { font-size:1.1rem; font-weight:800; margin-bottom:0.5rem; }
    .lp-step p  { font-size:0.9rem; color:var(--muted); line-height:1.7; font-weight:500; }

    /* ── CTA SECTION ─────────────────────────────────── */
    .lp-cta-section { padding:0 2rem 6rem; }
    .lp-cta-box {
      max-width:900px; margin:0 auto;
      background: linear-gradient(135deg, var(--blue) 0%, #1E40AF 50%, #1E3A8A 100%);
      border-radius: 2.5rem; padding:5rem 4rem;
      text-align:center; position:relative; overflow:hidden;
      box-shadow: 0 24px 64px rgba(37,99,235,0.45);
    }
    .lp-cta-box::before {
      content:''; position:absolute;
      top:-80px; right:-80px; width:350px; height:350px;
      background:radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
      border-radius:50%;
    }
    .lp-cta-box::after {
      content:''; position:absolute;
      bottom:-60px; left:-60px; width:250px; height:250px;
      background:radial-gradient(circle, rgba(249,115,22,0.15) 0%, transparent 70%);
      border-radius:50%;
    }
    .lp-cta-mascot { font-size:4rem; display:block; margin-bottom:1rem; position:relative; z-index:1; animation:lp-float 3s ease-in-out infinite; }
    .lp-cta-box h2 { font-size:clamp(1.8rem,4vw,2.8rem); font-weight:900; color:#fff; margin-bottom:1rem; letter-spacing:-0.035em; position:relative; z-index:1; }
    .lp-cta-box p  { font-size:1.05rem; color:rgba(255,255,255,0.80); font-weight:500; margin-bottom:2.5rem; position:relative; z-index:1; line-height:1.7; }
    .lp-cta-btns  { display:flex; gap:1rem; justify-content:center; flex-wrap:wrap; position:relative; z-index:1; }
    .lp-btn-white {
      padding:1rem 2.5rem; border-radius:999px;
      background:#fff; color:var(--blue); font-weight:800; font-size:1rem;
      text-decoration:none; transition:all 0.3s;
      box-shadow:0 4px 20px rgba(0,0,0,0.15);
      display:inline-flex; align-items:center; gap:0.5rem;
    }
    .lp-btn-white:hover { transform:translateY(-3px); box-shadow:0 10px 32px rgba(0,0,0,0.2); }
    .lp-btn-outline-white {
      padding:1rem 2.5rem; border-radius:999px;
      background:rgba(255,255,255,0.12); color:#fff; font-weight:700; font-size:1rem;
      text-decoration:none; border:1.5px solid rgba(255,255,255,0.3);
      transition:all 0.2s; display:inline-flex; align-items:center; gap:0.5rem;
    }
    .lp-btn-outline-white:hover { background:rgba(255,255,255,0.2); }

    /* ── FOOTER ──────────────────────────────────────── */
    .lp-footer {
      text-align:center; padding:2rem; color:#94A3B8;
      font-size:0.85rem; font-weight:600;
      border-top:1px solid rgba(37,99,235,0.06);
    }
    .lp-footer a { color:var(--blue); text-decoration:none; font-weight:700; }

    /* ── Mobile nav hide ─────────────────────────────── */
    @media(max-width:500px){
      .lp-nav-links .lp-btn-ghost { display:none; }
      .lp-cta-box { padding: 3rem 1.75rem; }
      .lp-speech { display:none; }
      .lp-fc-2,.lp-fc-3 { display:none; }
    }
  </style>
  <script src="{{ asset('js/particles.js') }}" defer></script>
</head>
<body>

{{-- ════════════════════════════ NAVBAR ════════════════════════════ --}}
<nav class="lp-nav">
  <div class="lp-nav-inner">
    <a href="/" class="lp-brand">
      <span class="lp-brand-cat">🐱</span> Sinau
    </a>
    <div class="lp-nav-links">
      <a href="#fitur" class="lp-btn-ghost">Fitur</a>
      @auth
        <a href="{{ route('dashboard') }}" class="lp-btn-solid">Dashboard →</a>
      @else
        <a href="{{ route('login') }}"    class="lp-btn-ghost">Masuk</a>
        <a href="{{ route('register') }}" class="lp-btn-solid">Daftar Gratis 🎉</a>
      @endauth
    </div>
  </div>
</nav>

{{-- ════════════════════════════ HERO ════════════════════════════ --}}
<section class="lp-hero">
  <div class="lp-hero-inner">

    {{-- Hero Text --}}
    <div class="lp-hero-left">
      <div class="lp-overtitle">🏫 Project Smecone-hub PPLG · SMKN 1 Purwokerto</div>
      <h1 class="lp-headline">
        Belajar Lebih<br>
        <span class="h-grad">Cerdas,</span><br>
        <span class="h-orange">Seru</span> & Terarah
      </h1>
      <p class="lp-desc">
        Platform belajar mandiri untuk Smeconers. Kerjakan soal harian,
        jaga <span class="hl">🔥 streak</span>-mu, baca e-book, dan bersaing
        di leaderboard sekolah — semuanya dalam satu hub premium.
      </p>
      <div class="lp-hero-cta">
        <a href="{{ route('register') }}" class="lp-cta-main">Mulai Belajar Gratis <span>🚀</span></a>
        <a href="#fitur" class="lp-cta-ghost">Lihat Fitur <span>↓</span></a>
      </div>
      <div class="lp-hero-badges">
        <span class="lp-badge">🔥 Streak Harian</span>
        <span class="lp-badge">🏅 Badge & Poin</span>
        <span class="lp-badge">📚 E-Book Gratis</span>
        <span class="lp-badge">🎓 Info Beasiswa</span>
      </div>
    </div>

    {{-- Hero Kinners --}}
    <div class="lp-hero-right">
      <div class="lp-kinners-stage">
        <div class="lp-kinners-blob"></div>

        {{-- Floating mini cards --}}
        <div class="lp-float-card lp-fc-1">🔥 Streak 12 Hari!</div>
        <div class="lp-float-card lp-fc-2">✅ Soal Diselesaikan: 342</div>
        <div class="lp-float-card lp-fc-3">🏆 Rank #3 Sekolah</div>

        {{-- Speech bubble --}}
        <div class="lp-speech">"Halo Smeconers! 👋<br>Ayo belajar bareng Kinners!"</div>

        {{-- Kinners Mascot (bigger version) --}}
        <div class="lp-kinners-float">
          <svg width="320" height="320" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="100" cy="112" r="72" fill="white" stroke="#BFDBFE" stroke-width="2"/>
            <path d="M42 72 L26 26 L68 56 Z" fill="white" stroke="#BFDBFE" stroke-width="2" stroke-linejoin="round"/>
            <path d="M46 68 L34 36 L64 58 Z" fill="#EFF6FF"/>
            <path d="M158 72 L174 26 L132 56 Z" fill="white" stroke="#BFDBFE" stroke-width="2" stroke-linejoin="round"/>
            <path d="M154 68 L166 36 L136 58 Z" fill="#EFF6FF"/>
            <circle cx="100" cy="114" r="66" fill="#EFF6FF" opacity="0.5"/>
            <ellipse cx="76" cy="104" rx="15" ry="17" fill="white" stroke="#BFDBFE" stroke-width="1.5"/>
            <ellipse cx="124" cy="104" rx="15" ry="17" fill="white" stroke="#BFDBFE" stroke-width="1.5"/>
            <circle cx="78" cy="106" r="10" fill="#1E293B"/>
            <circle cx="126" cy="106" r="10" fill="#1E293B"/>
            <circle cx="83" cy="101" r="4" fill="white"/>
            <circle cx="131" cy="101" r="4" fill="white"/>
            <circle cx="75" cy="110" r="2" fill="white"/>
            <circle cx="123" cy="110" r="2" fill="white"/>
            <ellipse cx="58" cy="122" rx="13" ry="8" fill="#FDA4AF" opacity="0.5"/>
            <ellipse cx="142" cy="122" rx="13" ry="8" fill="#FDA4AF" opacity="0.5"/>
            <ellipse cx="100" cy="128" rx="5" ry="3.5" fill="#93C5FD"/>
            <path d="M88 136 Q100 148 112 136" stroke="#93C5FD" stroke-width="2.5" fill="none" stroke-linecap="round"/>
            <line x1="24"  y1="122" x2="72"  y2="126" stroke="#BFDBFE" stroke-width="1.8" stroke-linecap="round"/>
            <line x1="24"  y1="130" x2="72"  y2="130" stroke="#BFDBFE" stroke-width="1.8" stroke-linecap="round"/>
            <line x1="128" y1="126" x2="176" y2="122" stroke="#BFDBFE" stroke-width="1.8" stroke-linecap="round"/>
            <line x1="128" y1="130" x2="176" y2="130" stroke="#BFDBFE" stroke-width="1.8" stroke-linecap="round"/>
            <ellipse cx="100" cy="178" rx="26" ry="14" fill="white" stroke="#BFDBFE" stroke-width="1.5"/>
            <ellipse cx="84"  cy="174" rx="8"  ry="6"  fill="#DBEAFE"/>
            <ellipse cx="100" cy="170" rx="8"  ry="6"  fill="#DBEAFE"/>
            <ellipse cx="116" cy="174" rx="8"  ry="6"  fill="#DBEAFE"/>
          </svg>
        </div>
      </div>
    </div>

  </div>
</section>

{{-- ════════════════ STATS STRIP ════════════════ --}}
<div class="lp-stats">
  <div class="lp-stats-inner">
    @php
      $stats = [['20+','Siswa Aktif'],['200+','Soal Latihan'],['10+','E-Book'],['5','Info Beasiswa'],['100%','Gratis 🎉']];
    @endphp
    @foreach($stats as [$n,$l])
      <div class="lp-stat">
        <div class="lp-stat-num">{{ $n }}</div>
        <div class="lp-stat-label">{{ $l }}</div>
      </div>
    @endforeach
  </div>
</div>

{{-- ════════════════ FEATURES BENTO ════════════════ --}}
<section class="lp-section" id="fitur">
  <div class="lp-section-head">
    <div class="overtag">✨ Platform Unggulan</div>
    <h2>Semua yang Kamu Butuhkan</h2>
    <p>Didisain khusus untuk Smeconers — dari latihan soal sampai info beasiswa, semuanya lengkap di satu tempat.</p>
  </div>

  <div class="lp-feat-bento">

    {{-- Big Streak Card --}}
    <div class="lp-feat-card big lp-streak-bento" style="--fc:linear-gradient(90deg,#F97316,#EF4444);">
      <div>
        <div class="lp-feat-ico" style="--fi:rgba(249,115,22,0.1);">🔥</div>
        <h3>Streak & Gamifikasi Harian</h3>
        <p style="max-width:380px;">Jawab 1 soal setiap hari untuk menjaga api semangatmu! Raih badge, kumpulkan poin, dan bersaing di leaderboard — sekolah, jurusan, atau kelas.</p>
      </div>
      <div style="text-align:center;">
        <div class="lp-streak-num">🔥</div>
        <div class="lp-streak-label">Jaga streak setiap hari!</div>
      </div>
    </div>

    {{-- E-Book --}}
    <div class="lp-feat-card" style="--fc:linear-gradient(90deg,#2563EB,#3B82F6);--fi:rgba(37,99,235,0.07);">
      <div class="lp-feat-ico">📚</div>
      <h3>E-Book Lengkap</h3>
      <p>Akses materi mapel umum & kejuruan kapan saja. Baca langsung di browser, tanpa perlu download!</p>
    </div>

    {{-- Latihan Soal --}}
    <div class="lp-feat-card" style="--fc:linear-gradient(90deg,#10B981,#34D399);--fi:rgba(16,185,129,0.07);">
      <div class="lp-feat-ico">📝</div>
      <h3>Bank Soal Terstruktur</h3>
      <p>Ratusan soal berbagai tingkat kesulitan. Cocok untuk persiapan ujian nasional maupun uji kompetensi.</p>
    </div>

    {{-- Pomodoro --}}
    <div class="lp-feat-card" style="--fc:linear-gradient(90deg,#8B5CF6,#A78BFA);--fi:rgba(139,92,246,0.07);">
      <div class="lp-feat-ico">⏱️</div>
      <h3>Pomodoro Timer</h3>
      <p>Metode belajar 25 menit fokus + 5 menit istirahat. Kinners menemanimu selama sesi belajar!</p>
    </div>

    {{-- Study Plan --}}
    <div class="lp-feat-card" style="--fc:linear-gradient(90deg,#F59E0B,#FCD34D);--fi:rgba(245,158,11,0.07);">
      <div class="lp-feat-ico">📅</div>
      <h3>Study Plan</h3>
      <p>Buat jadwal belajar dengan deadline dan pantau progres harianmu. Belajar lebih terarah!</p>
    </div>

    {{-- Beasiswa --}}
    <div class="lp-feat-card" style="--fc:linear-gradient(90deg,#0EA5E9,#38BDF8);--fi:rgba(14,165,233,0.07);">
      <div class="lp-feat-ico">🎓</div>
      <h3>Info Beasiswa Terkurasi</h3>
      <p>Informasi beasiswa SMA/SMK/S1 yang selalu diperbarui. Jangan sampai ketinggalan kesempatan!</p>
    </div>

    {{-- Leaderboard --}}
    <div class="lp-feat-card" style="--fc:linear-gradient(90deg,#F97316,#FB923C);--fi:rgba(249,115,22,0.07);">
      <div class="lp-feat-ico">🏆</div>
      <h3>Leaderboard Kompetitif</h3>
      <p>Bersaing sehat dengan teman sekelas, sejurusan, atau se-sekolah. Siapa Smeconer terbaik minggu ini?</p>
    </div>

    {{-- Forum --}}
    <div class="lp-feat-card" style="--fc:linear-gradient(90deg,#EC4899,#F472B6);--fi:rgba(236,72,153,0.07);">
      <div class="lp-feat-ico">💬</div>
      <h3>Forum Diskusi</h3>
      <p>Diskusi soal atau materi per mapel bersama teman dan guru. Belajar lebih efektif bersama!</p>
    </div>

  </div>
</section>

{{-- ════════════════ HOW IT WORKS ════════════════ --}}
<section class="lp-section" style="padding-top:2rem;">
  <div class="lp-section-head">
    <div class="overtag">🚀 Cara Mulai</div>
    <h2>3 Langkah ke Versi Terbaik Dirimu</h2>
    <p>Bergabung dan mulai belajar hanya dalam hitungan menit!</p>
  </div>
  <div class="lp-steps">
    <div class="lp-step">
      <div class="lp-step-num">1</div>
      <h3>Daftar Gratis</h3>
      <p>Buat akun gratis dengan email sekolahmu. Tidak perlu kartu kredit atau biaya apapun!</p>
    </div>
    <div class="lp-step">
      <div class="lp-step-num">2</div>
      <h3>Pilih Aktivitasmu</h3>
      <p>Kerjakan soal latihan, baca e-book, atau kelola study plan. Semua fitur bisa diakses langsung!</p>
    </div>
    <div class="lp-step">
      <div class="lp-step-num">3</div>
      <h3>Jaga Streak & Naik Rank</h3>
      <p>Konsisten belajar setiap hari untuk menjaga streak dan naik ke puncak leaderboard sekolah!</p>
    </div>
  </div>
</section>

{{-- ════════════════ CTA BOX ════════════════ --}}
<div class="lp-cta-section">
  <div class="lp-cta-box">
    <span class="lp-cta-mascot">🐱</span>
    <h2>Siap Jadi Smeconer Terbaik?</h2>
    <p>Kinners sudah nunggu kamu! Daftar gratis dan mulai streak pertamamu hari ini.<br>Bergabung bersama puluhan Smeconers yang sudah aktif belajar.</p>
    <div class="lp-cta-btns">
      <a href="{{ route('register') }}" class="lp-btn-white">🎉 Daftar Sekarang — Gratis!</a>
      @auth
        <a href="{{ route('dashboard') }}" class="lp-btn-outline-white">Ke Dashboard →</a>
      @else
        <a href="{{ route('login') }}" class="lp-btn-outline-white">Sudah punya akun? Masuk</a>
      @endauth
    </div>
  </div>
</div>

{{-- ════════════════ FOOTER ════════════════ --}}
<footer class="lp-footer">
  <strong><a href="/">Sinau</a></strong> — Platform Belajar Mandiri SMKN 1 Purwokerto &copy; {{ date('Y') }}
  &nbsp;·&nbsp; Dibuat dengan ❤️ oleh PPLG
</footer>

</body>
</html>


