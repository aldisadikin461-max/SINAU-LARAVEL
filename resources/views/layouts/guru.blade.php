<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title','Guru') — Sinau</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Fredoka+One&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/sinau.css') }}">
  <style>
    *{box-sizing:border-box;}
    body{background:linear-gradient(160deg,#e8f4fd 0%,#f0f9ff 55%,#fef9ee 100%);min-height:100vh;font-family:'Nunito',sans-serif;}

    /* ── Navbar (BIRU, sama persis dengan admin) ── */
    .snav{position:sticky;top:0;z-index:50;background:rgba(255,255,255,0.95);backdrop-filter:blur(20px);border-bottom:2.5px solid #0ea5e9;padding:.7rem 2rem;display:flex;align-items:center;justify-content:space-between;box-shadow:0 4px 20px rgba(14,165,233,0.12);}
    .snav-brand{display:flex;align-items:center;gap:.4rem;font-family:'Fredoka One',sans-serif;font-size:1.4rem;color:#0ea5e9;text-decoration:none;}
    .snav-brand .cat{animation:wiggle 3s ease-in-out infinite;font-size:1.6rem;}
    @keyframes wiggle{0%,100%{transform:rotate(0)}25%{transform:rotate(-9deg)}75%{transform:rotate(9deg)}}
    .snav-links{display:flex;align-items:center;gap:.15rem;}
    .snav-links a{padding:.38rem .85rem;border-radius:999px;font-size:.84rem;font-weight:700;color:#64748b;text-decoration:none;transition:all .18s;font-family:'Nunito',sans-serif;}
    .snav-links a:hover{background:#f0f9ff;color:#0ea5e9;}
    .snav-links a.on{background:rgba(14,165,233,.1);color:#0284c7;border:1px solid rgba(14,165,233,.2);}
    .snav-right{display:flex;align-items:center;gap:.6rem;}
    .sguru-pill{background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;border-radius:999px;padding:.28rem .85rem;font-weight:800;font-size:.83rem;display:inline-flex;align-items:center;gap:.3rem;box-shadow:0 3px 10px rgba(14,165,233,.3);}
    .slogout{padding:.35rem 1rem;border-radius:999px;background:#fee2e2;border:1px solid #fecaca;color:#dc2626;font-size:.82rem;font-weight:800;text-decoration:none;transition:all .2s;font-family:'Nunito',sans-serif;cursor:pointer;}
    .slogout:hover{background:#fecaca;}

    /* ── Main content ── */
    .smain{max-width:1200px;margin:0 auto;padding:2rem;}
    .salert{background:#dcfce7;border:1px solid #bbf7d0;color:#16a34a;border-radius:1rem;padding:.875rem 1.25rem;margin-bottom:1.25rem;font-weight:700;font-size:.9rem;}
    .serror{background:#fee2e2;border:1px solid #fecaca;color:#dc2626;border-radius:1rem;padding:.875rem 1.25rem;margin-bottom:1.25rem;font-weight:700;font-size:.9rem;}

    /* ── Cards ── */
    .card{background:#fff;border:1px solid rgba(14,165,233,.1);border-radius:1.25rem;box-shadow:0 4px 20px rgba(14,165,233,.07);padding:1.5rem;}
    .section-title{font-family:'Fredoka One',sans-serif;font-size:1.3rem;color:#0f172a;margin-bottom:1rem;display:flex;align-items:center;gap:.5rem;}

    /* ── Stat cards ── */
    .stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem;}
    @media(max-width:900px){.stat-grid{grid-template-columns:repeat(2,1fr);}}
    .stat-card{background:#fff;border:1.5px solid rgba(14,165,233,.1);border-radius:1.25rem;padding:1.25rem;transition:all .2s;box-shadow:0 2px 12px rgba(14,165,233,.06);}
    .stat-card:hover{transform:translateY(-3px);box-shadow:0 10px 28px rgba(14,165,233,.13);border-color:rgba(14,165,233,.25);}
    .stat-icon{font-size:2rem;margin-bottom:.5rem;}
    .stat-value{font-family:'Fredoka One',sans-serif;font-size:2rem;color:#0f172a;line-height:1;}
    .stat-label{font-size:.82rem;font-weight:800;color:#94a3b8;margin-top:.25rem;}
    .stat-sub{font-size:.76rem;color:#cbd5e1;font-weight:600;margin-top:.2rem;}

    /* ── Pills / badges ── */
    .pill{display:inline-flex;align-items:center;gap:.3rem;padding:.3rem .9rem;border-radius:999px;font-size:.82rem;font-weight:800;font-family:'Nunito',sans-serif;}
    .pill-blue{background:#e0f2fe;border:1.5px solid #bae6fd;color:#0284c7;}
    .pill-orange{background:linear-gradient(135deg,#f97316,#ef4444);color:#fff;box-shadow:0 3px 10px rgba(249,115,22,.3);}

    /* ── Grid action buttons ── */
    .action-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;margin-bottom:1.5rem;}
    @media(max-width:900px){.action-grid{grid-template-columns:1fr;}}
    .action-card{background:#fff;border:1.5px solid rgba(14,165,233,.1);border-radius:1.25rem;padding:1.25rem;display:flex;align-items:center;gap:1rem;text-decoration:none;transition:all .2s;box-shadow:0 2px 12px rgba(14,165,233,.06);}
    .action-card:hover{transform:translateY(-3px);box-shadow:0 10px 28px rgba(14,165,233,.13);border-color:rgba(14,165,233,.25);}
    .action-icon{font-size:2rem;}
    .action-title{font-family:'Fredoka One',sans-serif;font-size:1rem;color:#0f172a;}
    .action-desc{font-size:.76rem;font-weight:700;color:#94a3b8;margin-top:.2rem;}

    /* ── Buttons ── */
    .fbtn{padding:.45rem 1.3rem;border-radius:999px;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;font-size:.88rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;box-shadow:0 3px 12px rgba(14,165,233,.3);transition:all .2s;text-decoration:none;display:inline-flex;align-items:center;gap:.4rem;}
    .fbtn:hover{transform:translateY(-2px);box-shadow:0 6px 18px rgba(14,165,233,.35);}
    .fbtn-sm{padding:.3rem .85rem;font-size:.78rem;}

    /* ── Page header ── */
    .page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:.75rem;}
    .page-header h1{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin:0;}
    .page-header p{color:#94a3b8;font-weight:600;font-size:.9rem;margin:.2rem 0 0;}

    /* ── Table (sama dengan admin) ── */
    .sinau-table{width:100%;border-collapse:collapse;font-size:.88rem;}
    .sinau-table th{text-align:left;padding:.6rem 1rem;font-weight:800;color:#64748b;font-size:.78rem;text-transform:uppercase;letter-spacing:.04em;border-bottom:2px solid rgba(14,165,233,.1);}
    .sinau-table td{padding:.75rem 1rem;border-bottom:1px solid rgba(14,165,233,.06);color:#1e293b;vertical-align:middle;}
    .sinau-table tr:last-child td{border-bottom:none;}
    .sinau-table tr:hover td{background:rgba(14,165,233,.03);}
  </style>
</head>
<body>

{{-- ── Navbar ── --}}
<nav class="snav">
  <a href="{{ route('guru.dashboard') }}" class="snav-brand">
    <span class="cat">🐱</span> Sinau
  </a>
  <div class="snav-links">
    @foreach([
      ['guru.dashboard',        '📊 Dashboard'],
      ['guru.ebooks.index',     '📚 E-Book'],
      ['guru.questions.index',  '❓ Soal'],
      ['guru.tasks.index',      '📝 Tugas'],
      ['guru.progres',          '📈 Progres'],
    ] as [$r,$l])
      <a href="{{ route($r) }}" class="{{ request()->routeIs($r)?'on':'' }}">{{ $l }}</a>
    @endforeach
  </div>
  <div class="snav-right">
    <span class="sguru-pill">👨‍🏫 Guru</span>
    <form method="POST" action="{{ route('logout') }}">@csrf
      <button class="slogout">Logout</button>
    </form>
  </div>
</nav>

{{-- ── Content ── --}}
<main class="smain">
  @if(session('success'))<div class="salert">✅ {{ session('success') }}</div>@endif
  @if(session('error'))<div class="serror">❌ {{ session('error') }}</div>@endif
  @yield('content')
</main>

<script src="{{ asset('js/sinau.js') }}"></script>
@stack('scripts')
</body>
</html>