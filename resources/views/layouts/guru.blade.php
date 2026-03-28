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
    body{background:linear-gradient(160deg,#e8f4fd 0%,#f0f9ff 55%,#fef9ee 100%);min-height:100vh;display:flex;font-family:'Nunito',sans-serif;}
    .sidebar{width:240px;flex-shrink:0;background:linear-gradient(180deg,#065f46 0%,#064e3b 60%,#022c22 100%);min-height:100vh;display:flex;flex-direction:column;padding:1.5rem 1rem;position:sticky;top:0;height:100vh;overflow-y:auto;}
    .sb-brand{display:flex;align-items:center;gap:.5rem;font-family:'Fredoka One',sans-serif;font-size:1.5rem;color:#fff;padding:.5rem .5rem 1.5rem;border-bottom:1px solid rgba(255,255,255,.1);margin-bottom:1rem;}
    .sb-brand .cat{animation:wiggle 3s ease-in-out infinite;}
    @keyframes wiggle{0%,100%{transform:rotate(0)}25%{transform:rotate(-9deg)}75%{transform:rotate(9deg)}}
    .sb-label{font-size:.7rem;font-weight:800;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:.08em;padding:.5rem .75rem .25rem;}
    .sb-link{display:flex;align-items:center;gap:.65rem;padding:.6rem .85rem;border-radius:.875rem;color:rgba(255,255,255,.6);font-size:.88rem;font-weight:700;text-decoration:none;transition:all .18s;margin-bottom:.15rem;}
    .sb-link:hover{background:rgba(255,255,255,.1);color:#fff;}
    .sb-link.on{background:rgba(52,211,153,.2);color:#fff;border:1px solid rgba(52,211,153,.3);}
    .sb-link .ico{font-size:1.1rem;width:1.4rem;text-align:center;}
    .sb-bottom{margin-top:auto;padding-top:1rem;border-top:1px solid rgba(255,255,255,.1);}
    .sb-logout{display:flex;align-items:center;gap:.65rem;padding:.6rem .85rem;border-radius:.875rem;color:rgba(255,100,100,.7);font-size:.88rem;font-weight:700;background:none;border:none;cursor:pointer;width:100%;transition:all .18s;}
    .sb-logout:hover{background:rgba(239,68,68,.15);color:#fca5a5;}
    .main-wrap{flex:1;overflow:auto;padding:2rem;max-height:100vh;}
    .page-content{max-width:1100px;margin:0 auto;}
    .salert{background:#dcfce7;border:1px solid #bbf7d0;color:#16a34a;border-radius:1rem;padding:.875rem 1.25rem;margin-bottom:1.25rem;font-weight:700;}
    .page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:.25rem;}
    .page-sub{color:#94a3b8;font-size:.9rem;font-weight:600;margin-bottom:1.5rem;}
  </style>
</head>
<body>
<aside class="sidebar">
  <div class="sb-brand"><span class="cat">🐱</span> Sinau</div>
  <div class="sb-label">Menu Guru</div>
  @foreach([['guru.dashboard','📊','Dashboard'],['guru.ebooks.index','📚','Kelola E-Book'],['guru.questions.index','❓','Kelola Soal'],['guru.tasks.index','📝','Kelola Tugas'],['guru.progres','📈','Progres Siswa']] as [$r,$ico,$l])
    <a href="{{ route($r) }}" class="sb-link {{ request()->routeIs($r)?'on':'' }}">
      <span class="ico">{{ $ico }}</span>{{ $l }}
    </a>
  @endforeach
  <div class="sb-bottom">
    <form method="POST" action="{{ route('logout') }}">@csrf
      <button class="sb-logout"><span class="ico">🚪</span> Logout</button>
    </form>
  </div>
</aside>
<div class="main-wrap">
  <div class="page-content">
    @if(session('success'))<div class="salert">✅ {{ session('success') }}</div>@endif
    @yield('content')
  </div>
</div>
<script src="{{ asset('js/sinau.js') }}"></script>
@stack('scripts')
</body>
</html>