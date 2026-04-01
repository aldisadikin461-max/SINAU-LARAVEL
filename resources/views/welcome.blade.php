<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sinau — Platform Belajar Mandiri SMKN 1 Purwokerto</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Fredoka+One&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/sinau.css') }}">
  <style>
    *{margin:0;padding:0;box-sizing:border-box;}
    body{
      font-family:'Nunito',sans-serif;
      background:linear-gradient(160deg,#e8f4fd 0%,#f0f9ff 40%,#fef9ee 100%);
      color:#1e293b;min-height:100vh;overflow-x:hidden;
    }
    /* Navbar */
    .navbar{
      position:fixed;top:0;width:100%;z-index:100;
      padding:1rem 3rem;display:flex;align-items:center;justify-content:space-between;
      background:rgba(255,255,255,0.92);backdrop-filter:blur(20px);
      border-bottom:2.5px solid #0ea5e9;
      box-shadow:0 4px 24px rgba(14,165,233,0.12);
    }
    .brand{display:flex;align-items:center;gap:0.5rem;font-family:'Fredoka One',sans-serif;font-size:1.7rem;color:#0ea5e9;text-decoration:none;}
    .brand-cat{animation:wiggle 3s ease-in-out infinite;font-size:1.9rem;}
    @keyframes wiggle{0%,100%{transform:rotate(0)}25%{transform:rotate(-9deg)}75%{transform:rotate(9deg)}}
    .nav-links{display:flex;gap:0.75rem;align-items:center;}
    .btn-masuk{padding:0.5rem 1.4rem;border-radius:999px;color:#0ea5e9;font-weight:800;font-size:0.9rem;text-decoration:none;border:2px solid rgba(14,165,233,0.25);background:rgba(14,165,233,0.06);transition:all 0.2s;}
    .btn-masuk:hover{background:rgba(14,165,233,0.12);border-color:#0ea5e9;}
    .btn-daftar{padding:0.5rem 1.5rem;border-radius:999px;background:linear-gradient(135deg,#0ea5e9,#38bdf8);color:#fff;font-weight:800;font-size:0.9rem;text-decoration:none;box-shadow:0 4px 16px rgba(14,165,233,0.3);transition:all 0.2s;}
    .btn-daftar:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(14,165,233,0.4);}

    /* Hero */
    .hero{
      min-height:100vh;display:grid;grid-template-columns:1fr 1fr;
      align-items:center;gap:4rem;
      max-width:1100px;margin:0 auto;padding:7rem 2rem 4rem;
    }
    @media(max-width:768px){.hero{grid-template-columns:1fr;padding-top:6rem;text-align:center;}.hero-right{order:-1;}}

    /* Kinners */
    .hero-left{display:flex;flex-direction:column;align-items:center;position:relative;}
    .kinners-anim{animation:float 4s ease-in-out infinite;position:relative;}
    @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-14px)}}
    .kinners-anim svg{filter:drop-shadow(0 16px 40px rgba(14,165,233,0.2));}
    .speech{
      position:absolute;top:-5px;right:-30px;
      background:white;border:2px solid rgba(14,165,233,0.2);
      border-radius:1.2rem 1.2rem 1.2rem 0;
      padding:0.7rem 1rem;font-size:0.88rem;font-weight:700;
      color:#0284c7;font-style:italic;line-height:1.5;
      box-shadow:0 8px 24px rgba(14,165,233,0.12);
      white-space:nowrap;
    }

    /* decorative circles */
    .deco{position:absolute;border-radius:50%;filter:blur(50px);opacity:0.18;}
    .deco-1{width:220px;height:220px;background:#0ea5e9;top:-30px;left:-50px;}
    .deco-2{width:160px;height:160px;background:#f97316;bottom:10px;right:10px;}
    .deco-3{width:120px;height:120px;background:#a78bfa;top:40%;right:-20px;}

    /* Hero text */
    .hero-tag{
      display:inline-flex;align-items:center;gap:0.4rem;
      background:rgba(14,165,233,0.1);border:1.5px solid rgba(14,165,233,0.2);
      color:#0284c7;border-radius:999px;padding:0.3rem 1rem;
      font-size:0.85rem;font-weight:800;margin-bottom:1.2rem;
    }
    .hero-title{
      font-family:'Fredoka One',sans-serif;
      font-size:clamp(2.5rem,5vw,4.2rem);
      line-height:1.08;color:#0f172a;margin-bottom:1.2rem;
    }
    .hero-title .accent-blue{color:#0ea5e9;}
    .hero-title .accent-orange{color:#f97316;}
    .hero-desc{font-size:1.05rem;color:#64748b;line-height:1.75;margin-bottom:2rem;max-width:460px;}
    .hero-desc .hl{color:#f97316;font-weight:800;}

    .hero-cta{display:flex;gap:1rem;flex-wrap:wrap;margin-bottom:2rem;}
    .btn-main{
      padding:0.95rem 2.2rem;border-radius:999px;
      background:linear-gradient(135deg,#0ea5e9,#0284c7);
      color:#fff;font-size:1rem;font-weight:800;text-decoration:none;
      box-shadow:0 8px 28px rgba(14,165,233,0.4);transition:all 0.25s;
      font-family:'Nunito',sans-serif;letter-spacing:0.5px;
    }
    .btn-main:hover{transform:translateY(-3px);box-shadow:0 14px 36px rgba(14,165,233,0.5);}
    .btn-outline{
      padding:0.95rem 2.2rem;border-radius:999px;
      background:white;border:2px solid rgba(14,165,233,0.25);
      color:#0ea5e9;font-size:1rem;font-weight:700;text-decoration:none;
      transition:all 0.2s;font-family:'Nunito',sans-serif;
    }
    .btn-outline:hover{border-color:#0ea5e9;transform:translateY(-2px);}

    /* Mini badges under CTA */
    .mini-badges{display:flex;gap:0.6rem;flex-wrap:wrap;}
    .mini-badge{
      background:white;border:1px solid rgba(0,0,0,0.07);
      border-radius:999px;padding:0.35rem 0.85rem;
      font-size:0.8rem;font-weight:700;color:#475569;
      display:flex;align-items:center;gap:0.3rem;
      box-shadow:0 2px 8px rgba(0,0,0,0.06);
    }

    /* Stats */
    .stats{
      display:flex;gap:1.25rem;flex-wrap:wrap;
      justify-content:center;max-width:900px;margin:0 auto;
      padding:0 2rem 5rem;
    }
    .stat-card{
      background:white;border:1px solid rgba(14,165,233,0.1);
      border-radius:1.25rem;padding:1.25rem 2rem;
      text-align:center;box-shadow:0 4px 20px rgba(14,165,233,0.07);
      flex:1;min-width:130px;transition:transform 0.2s;
    }
    .stat-card:hover{transform:translateY(-4px);}
    .stat-num{font-family:'Fredoka One',sans-serif;font-size:2.2rem;color:#0ea5e9;}
    .stat-label{font-size:0.8rem;color:#94a3b8;font-weight:700;margin-top:0.1rem;}

    /* Features */
    .section{max-width:1100px;margin:0 auto;padding:2rem 2rem 5rem;}
    .section-head{text-align:center;margin-bottom:2.5rem;}
    .section-head h2{font-family:'Fredoka One',sans-serif;font-size:2.5rem;color:#0f172a;margin-bottom:0.5rem;}
    .section-head p{color:#94a3b8;font-size:1rem;font-weight:600;}

    .feat-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:1.25rem;}
    .feat-card{
      background:white;border:1px solid rgba(0,0,0,0.05);
      border-radius:1.5rem;padding:1.75rem;
      transition:all 0.25s;position:relative;overflow:hidden;
    }
    .feat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:4px;background:var(--ac,#0ea5e9);border-radius:4px 4px 0 0;}
    .feat-card:hover{transform:translateY(-6px);box-shadow:0 16px 48px rgba(0,0,0,0.08);}
    .feat-icon{font-size:2.6rem;margin-bottom:0.85rem;display:block;}
    .feat-title{font-family:'Fredoka One',sans-serif;font-size:1.2rem;color:#0f172a;margin-bottom:0.4rem;}
    .feat-desc{font-size:0.9rem;color:#94a3b8;line-height:1.6;}

    /* CTA box */
    .cta-wrap{max-width:720px;margin:0 auto;padding:0 2rem 6rem;}
    .cta-box{
      background:linear-gradient(135deg,#0ea5e9 0%,#0284c7 100%);
      border-radius:2.5rem;padding:4rem 2.5rem;text-align:center;
      position:relative;overflow:hidden;
      box-shadow:0 20px 60px rgba(14,165,233,0.3);
    }
    .cta-box::before,.cta-box::after{
      content:'';position:absolute;border-radius:50%;
      background:rgba(255,255,255,0.08);
    }
    .cta-box::before{width:350px;height:350px;top:-100px;right:-100px;}
    .cta-box::after{width:200px;height:200px;bottom:-60px;left:-60px;}
    .cta-kinners{font-size:3.5rem;margin-bottom:0.75rem;position:relative;z-index:1;display:block;animation:float 3s ease-in-out infinite;}
    .cta-box h3{font-family:'Fredoka One',sans-serif;font-size:2.2rem;color:white;margin-bottom:0.75rem;position:relative;z-index:1;}
    .cta-box p{color:rgba(255,255,255,0.85);margin-bottom:2rem;font-size:1.05rem;position:relative;z-index:1;font-weight:600;}
    .btn-white{
      display:inline-block;padding:1rem 2.5rem;border-radius:999px;
      background:white;color:#0284c7;font-weight:800;font-size:1rem;
      text-decoration:none;box-shadow:0 4px 20px rgba(0,0,0,0.15);
      transition:all 0.2s;position:relative;z-index:1;font-family:'Nunito',sans-serif;
    }
    .btn-white:hover{transform:translateY(-3px);box-shadow:0 10px 32px rgba(0,0,0,0.2);}

    footer{text-align:center;padding:2rem;color:#cbd5e1;font-size:0.85rem;border-top:1px solid rgba(0,0,0,0.05);}
    footer span{color:#94a3b8;font-weight:700;}
  </style>
</head>
<body>

<nav class="navbar">
  <a href="/" class="brand">
    <span class="brand-cat">🐱</span> SINAU
  </a>
  <div class="nav-links">
    @auth
      <a href="{{ route('dashboard') }}" class="btn-daftar">Dashboard</a>
    @else
      <a href="{{ route('login') }}"    class="btn-masuk">MASUK</a>
      <a href="{{ route('register') }}" class="btn-daftar">DAFTAR</a>
    @endauth
  </div>
</nav>

<section class="hero">
  <!-- Kinners -->
  <div class="hero-left">
    <div class="deco deco-1"></div>
    <div class="deco deco-2"></div>
    <div class="deco deco-3"></div>
    <div class="kinners-anim">
      <div class="speech">"Halo Smeconers!<br>Aku Kinners, ayo belajar!"</div>
      <svg width="300" height="300" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Body -->
        <circle cx="100" cy="112" r="72" fill="white" stroke="#7dd3fc" stroke-width="2.5"/>
        <!-- Ear left -->
        <path d="M42 72 L26 26 L68 56 Z" fill="white" stroke="#7dd3fc" stroke-width="2.2" stroke-linejoin="round"/>
        <path d="M46 68 L34 36 L64 58 Z" fill="#bae6fd"/>
        <!-- Ear right -->
        <path d="M158 72 L174 26 L132 56 Z" fill="white" stroke="#7dd3fc" stroke-width="2.2" stroke-linejoin="round"/>
        <path d="M154 68 L166 36 L136 58 Z" fill="#bae6fd"/>
        <!-- Face tint -->
        <circle cx="100" cy="114" r="66" fill="#f0f9ff" opacity="0.6"/>
        <!-- Eyes whites -->
        <ellipse cx="76" cy="104" rx="15" ry="17" fill="white" stroke="#7dd3fc" stroke-width="1.5"/>
        <ellipse cx="124" cy="104" rx="15" ry="17" fill="white" stroke="#7dd3fc" stroke-width="1.5"/>
        <!-- Pupils big -->
        <circle cx="78" cy="106" r="10" fill="#0f172a"/>
        <circle cx="126" cy="106" r="10" fill="#0f172a"/>
        <!-- Pupil shine -->
        <circle cx="83" cy="101" r="4" fill="white"/>
        <circle cx="131" cy="101" r="4" fill="white"/>
        <circle cx="75" cy="110" r="2" fill="white"/>
        <circle cx="123" cy="110" r="2" fill="white"/>
        <!-- Blush -->
        <ellipse cx="58" cy="122" rx="13" ry="8" fill="#fda4af" opacity="0.5"/>
        <ellipse cx="142" cy="122" rx="13" ry="8" fill="#fda4af" opacity="0.5"/>
        <!-- Nose -->
        <ellipse cx="100" cy="128" rx="5" ry="3.5" fill="#7dd3fc"/>
        <!-- Mouth -->
        <path d="M88 136 Q100 148 112 136" stroke="#7dd3fc" stroke-width="2.5" fill="none" stroke-linecap="round"/>
        <!-- Whiskers -->
        <line x1="24" y1="122" x2="72" y2="126" stroke="#bae6fd" stroke-width="1.8" stroke-linecap="round"/>
        <line x1="24" y1="130" x2="72" y2="130" stroke="#bae6fd" stroke-width="1.8" stroke-linecap="round"/>
        <line x1="128" y1="126" x2="176" y2="122" stroke="#bae6fd" stroke-width="1.8" stroke-linecap="round"/>
        <line x1="128" y1="130" x2="176" y2="130" stroke="#bae6fd" stroke-width="1.8" stroke-linecap="round"/>
        <!-- Paw -->
        <ellipse cx="100" cy="178" rx="26" ry="14" fill="white" stroke="#7dd3fc" stroke-width="1.5"/>
        <ellipse cx="84" cy="174" rx="8" ry="6" fill="#bae6fd"/>
        <ellipse cx="100" cy="170" rx="8" ry="6" fill="#bae6fd"/>
        <ellipse cx="116" cy="174" rx="8" ry="6" fill="#bae6fd"/>
      </svg>
    </div>
  </div>

  <!-- Text -->
  <div class="hero-right">
    <div class="hero-tag">🏫 SMKN 1 Purwokerto</div>
    <h1 class="hero-title">
      Cara Terasyik<br>buat <span class="accent-blue">Pinter!</span>
    </h1>
    <p class="hero-desc">
      Kerjakan soal harian, jaga 🔥 <span class="hl">streak</span>-mu, dan
      raih badge keren bersama SMKN 1 Purwokerto. E-book, latihan soal,
      forum diskusi, dan info beasiswa — semua di sini!
    </p>
    <div class="hero-cta">
      <a href="{{ route('register') }}" class="btn-main">MULAI SEKARANG 🚀</a>
      <a href="#fitur"                  class="btn-outline">LIHAT FITUR</a>
    </div>
    <div class="mini-badges">
      <span class="mini-badge">🔥 Streak Harian</span>
      <span class="mini-badge">🏅 Badge Keren</span>
      <span class="mini-badge">📚 E-Book Gratis</span>
      <span class="mini-badge">🎓 Info Beasiswa</span>
    </div>
  </div>
</section>

<!-- Stats -->
<div class="stats">
  @php $stats=[['20+','Siswa Aktif'],['10+','E-Book'],['22+','Soal Latihan'],['5','Beasiswa'],['4','Daily Quest']]; @endphp
  @foreach($stats as [$num,$label])
    <div class="stat-card">
      <div class="stat-num">{{ $num }}</div>
      <div class="stat-label">{{ $label }}</div>
    </div>
  @endforeach
</div>

<!-- Features -->
<section class="section" id="fitur">
  <div class="section-head">
    <h2>Semua yang Kamu Butuhkan 🎯</h2>
    <p>Didesain khusus untuk Smeconers yang mau belajar lebih efektif dan seru!</p>
  </div>
  <div class="feat-grid">
    @php
      $fitur=[
        ['📚','E-Book Lengkap','Akses materi mapel umum & jurusan kapan saja, di mana saja.','#0ea5e9'],
        ['🔥','Streak Harian','Jaga streak dan bersaing di leaderboard sekolah.','#f97316'],
        ['🏅','Badge & Poin','Raih badge milestone di hari ke-7, 14, 30, 60, 100!','#f59e0b'],
        ['❓','Latihan Soal','Ratusan soal pilihan ganda berbagai tingkat.','#10b981'],
        ['🎓','Info Beasiswa','Beasiswa SMA/SMK/S1 terkurasi dan selalu update.','#8b5cf6'],
        ['💬','Forum Diskusi','Diskusi per mapel bareng teman dan guru.','#0ea5e9'],
        ['⏱️','Pomodoro Timer','Fokus 25 menit, Kinners menemanimu belajar!','#ef4444'],
        ['📅','Study Plan','Kelola rencana belajar dengan target tanggal.','#22c55e'],
        ['🏆','Leaderboard','Saingan streak di level kelas, jurusan, sekolah!','#f59e0b'],
      ];
    @endphp
    @foreach($fitur as [$icon,$title,$desc,$color])
      <div class="feat-card" style="--ac:{{ $color }}">
        <span class="feat-icon">{{ $icon }}</span>
        <div class="feat-title">{{ $title }}</div>
        <div class="feat-desc">{{ $desc }}</div>
      </div>
    @endforeach
  </div>
</section>

<!-- CTA -->
<div class="cta-wrap">
  <div class="cta-box">
    <span class="cta-kinners">🐱</span>
    <h3>Siap Jadi Smeconer Terbaik?</h3>
    <p>Kinners udah nunggu kamu! Daftar gratis dan mulai streak pertamamu hari ini.</p>
    <a href="{{ route('register') }}" class="btn-white">Daftar Sekarang — Gratis! 🎉</a>
  </div>
</div>

<footer>
  <span>Sinau</span> — Platform Belajar Mandiri SMKN 1 Purwokerto &bull; Laravel 11 + Breeze + Tailwind CSS
</footer>

</body>
</html>
