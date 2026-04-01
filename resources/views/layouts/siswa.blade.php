<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title','Sinau') — BelajarSMK</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Fredoka+One&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/sinau.css') }}">
  <style>
    body{background:linear-gradient(160deg,#e8f4fd 0%,#f0f9ff 55%,#fef9ee 100%);min-height:100vh;}
    .snav{position:sticky;top:0;z-index:50;background:rgba(255,255,255,0.95);backdrop-filter:blur(20px);border-bottom:2.5px solid #0ea5e9;padding:.7rem 2rem;display:flex;align-items:center;justify-content:space-between;box-shadow:0 4px 20px rgba(14,165,233,0.12);}
    .snav-brand{display:flex;align-items:center;gap:.4rem;font-family:'Fredoka One',sans-serif;font-size:1.4rem;color:#0ea5e9;text-decoration:none;}
    .snav-brand .cat{animation:wiggle 3s ease-in-out infinite;font-size:1.6rem;}
    @keyframes wiggle{0%,100%{transform:rotate(0)}25%{transform:rotate(-9deg)}75%{transform:rotate(9deg)}}
    .snav-links{display:flex;align-items:center;gap:.15rem;}
    .snav-links a{padding:.38rem .85rem;border-radius:999px;font-size:.84rem;font-weight:700;color:#64748b;text-decoration:none;transition:all .18s;font-family:'Nunito',sans-serif;}
    .snav-links a:hover{background:#f0f9ff;color:#0ea5e9;}
    .snav-links a.on{background:rgba(14,165,233,.1);color:#0284c7;border:1px solid rgba(14,165,233,.2);}
    .snav-right{display:flex;align-items:center;gap:.6rem;}
    .spill{background:linear-gradient(135deg,#f97316,#ef4444);color:#fff;border-radius:999px;padding:.28rem .85rem;font-weight:800;font-size:.83rem;display:inline-flex;align-items:center;gap:.3rem;box-shadow:0 3px 10px rgba(249,115,22,.3);}
    .snotif{position:relative;font-size:1.2rem;background:#fff;border:1px solid rgba(14,165,233,.15);border-radius:999px;width:2.1rem;height:2.1rem;display:flex;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 2px 8px rgba(0,0,0,.05);transition:all .2s;}
    .snotif:hover{background:#f0f9ff;}
    .snotif .dot{position:absolute;top:-3px;right:-3px;background:#ef4444;color:#fff;font-size:.6rem;font-weight:800;border-radius:999px;width:1rem;height:1rem;display:flex;align-items:center;justify-content:center;}
    .slogout{padding:.35rem 1rem;border-radius:999px;background:#fee2e2;border:1px solid #fecaca;color:#dc2626;font-size:.82rem;font-weight:800;text-decoration:none;transition:all .2s;font-family:'Nunito',sans-serif;cursor:pointer;}
    .slogout:hover{background:#fecaca;}
    .smain{max-width:1200px;margin:0 auto;padding:2rem;}
    .salert{background:#dcfce7;border:1px solid #bbf7d0;color:#16a34a;border-radius:1rem;padding:.875rem 1.25rem;margin-bottom:1.25rem;font-weight:700;font-size:.9rem;}
  </style>
</head>
<body>
<nav class="snav">
  <a href="{{ route('siswa.dashboard') }}" class="snav-brand"><span class="cat">🐱</span> Sinau</a>
  <div class="snav-links">
    @foreach([
        ['siswa.dashboard','Beranda'],
        ['siswa.latihan','Latihan Soal'],
        ['siswa.leaderboard','Leaderboard'],
        ['siswa.beasiswa','Beasiswa'],
        ['siswa.forum','Forum'],
        ['siswa.riwayat','Riwayat'],
        ['siswa.pomodoro','Pomodoro'],
        ['siswa.rasionalisasi.index','Rasionalisasi']   // <-- menu baru
    ] as [$r,$l])
      <a href="{{ route($r) }}" class="{{ request()->routeIs($r)?'on':'' }}">{{ $l }}</a>
    @endforeach
  </div>
  <div class="snav-right">
    <span class="spill">🔥 <span id="streak-count">{{ auth()->user()->streak?->streak_count??0 }}</span></span>
    <button class="snotif" onclick="markNotifRead()">🔔
      @if(auth()->user()->notifications()->where('is_read',false)->count()>0)
        <span class="dot" id="notif-badge">{{ auth()->user()->notifications()->where('is_read',false)->count() }}</span>
      @endif
    </button>
    <form method="POST" action="{{ route('logout') }}">@csrf
      <button class="slogout">Logout</button>
    </form>
  </div>
</nav>
<main class="smain">
  @if(session('success'))<div class="salert">✅ {{ session('success') }}</div>@endif
  @yield('content')
</main>
<script src="{{ asset('js/sinau.js') }}"></script>
@stack('scripts')
</body>
</html>