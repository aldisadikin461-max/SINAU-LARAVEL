<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title','Sinau') — BelajarSMK</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/sinau.css') }}">
  <script src="{{ asset('js/particles.js') }}" defer></script>
  <!-- Styles migrated to public/css/sinau.css -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body>

{{-- Overlay Mobile --}}
<div class="sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

{{-- ═══ SIDEBAR SISWA ═══ --}}
<aside class="sidebar" id="sidebar">
  <button class="sb-toggle" id="sb-toggle" onclick="toggleSidebar()" title="Toggle sidebar">❮</button>

  {{-- Brand --}}
  <div class="sb-brand">
    <span class="sb-brand-cat">🐱</span>
    <span class="sb-brand-text">Sinau</span>
  </div>

  {{-- Nav --}}
  <nav class="sb-nav">

    {{-- HOME --}}
    <a href="{{ route('home') }}" data-tooltip="Beranda"
       class="sb-link {{ request()->routeIs('home') ? 'active' : '' }}">
      <span class="sb-ico">🏠</span><span class="sb-lbl">Beranda</span>
    </a>
    <a href="{{ route('siswa.dashboard') }}" data-tooltip="Dashboard"
       class="sb-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
      <span class="sb-ico">📊</span><span class="sb-lbl">Dashboard</span>
    </a>

    <div class="sb-divider"></div>

    {{-- BELAJAR --}}
    <div class="sb-group">📚 Belajar</div>
    <a href="{{ route('siswa.latihan') }}" data-tooltip="Latihan Soal"
       class="sb-link {{ request()->routeIs('siswa.latihan') ? 'active' : '' }}">
      <span class="sb-ico">❓</span><span class="sb-lbl">Latihan Soal</span>
    </a>
    @if(Route::has('siswa.quiz.index'))
    <a href="{{ route('siswa.quiz.index') }}" data-tooltip="Paket Soal"
       class="sb-link {{ request()->routeIs('siswa.quiz.*') ? 'active' : '' }}">
      <span class="sb-ico">📦</span><span class="sb-lbl">Paket Soal</span>
    </a>
    @endif
    <a href="{{ route('siswa.study-plan') }}" data-tooltip="Study Plan"
       class="sb-link {{ request()->routeIs('siswa.study-plan') ? 'active' : '' }}">
      <span class="sb-ico">📅</span><span class="sb-lbl">Study Plan</span>
    </a>
    <a href="{{ route('siswa.pomodoro') }}" data-tooltip="Pomodoro"
       class="sb-link {{ request()->routeIs('siswa.pomodoro') ? 'active' : '' }}">
      <span class="sb-ico">⏱️</span><span class="sb-lbl">Pomodoro</span>
    </a>
    <a href="{{ route('siswa.riwayat') }}" data-tooltip="Riwayat"
       class="sb-link {{ request()->routeIs('siswa.riwayat') ? 'active' : '' }}">
      <span class="sb-ico">📜</span><span class="sb-lbl">Riwayat</span>
    </a>

    <div class="sb-divider"></div>

    {{-- SOSIAL --}}
    <div class="sb-group">🌐 Sosial</div>
    <a href="{{ route('siswa.leaderboard') }}" data-tooltip="Leaderboard"
       class="sb-link {{ request()->routeIs('siswa.leaderboard') ? 'active' : '' }}">
      <span class="sb-ico">🏆</span><span class="sb-lbl">Leaderboard</span>
    </a>
    <a href="{{ route('siswa.forum') }}" data-tooltip="Forum"
       class="sb-link {{ request()->routeIs('siswa.forum') ? 'active' : '' }}">
      <span class="sb-ico">💬</span><span class="sb-lbl">Forum</span>
    </a>

    <div class="sb-divider"></div>

    {{-- INFORMASI --}}
    <div class="sb-group">📋 Informasi</div>


   <a href="{{ route('siswa.beasiswa') }}" data-tooltip="Beasiswa"
   class="sb-link {{ request()->routeIs('siswa.beasiswa') ? 'active' : '' }}">
  <span class="sb-ico">🎓</span><span class="sb-lbl">Beasiswa</span>
</a>

    @if(Route::has('siswa.alumni.index'))
    <a href="{{ route('siswa.alumni.index') }}" data-tooltip="Alumni"
       class="sb-link {{ request()->routeIs('siswa.alumni.*') ? 'active' : '' }}">
      <span class="sb-ico">👥</span><span class="sb-lbl">Alumni</span>
    </a>
    @endif
    @if(Route::has('siswa.rasionalisasi.index'))
    <a href="{{ route('siswa.rasionalisasi.index') }}" data-tooltip="Rasionalisasi"
       class="sb-link {{ request()->routeIs('siswa.rasionalisasi.*') ? 'active' : '' }}">
      <span class="sb-ico">🔮</span><span class="sb-lbl">Rasionalisasi</span>
    </a>
    @endif

  </nav>

  {{-- Bottom --}}
  <div class="sb-bottom">

    {{-- User info --}}
    <div class="sb-user">
      <div class="sb-user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
      <div class="sb-user-info">
        <div class="sb-user-name">{{ auth()->user()->name }}</div>
        <div class="sb-user-role">Siswa · {{ Str::limit(auth()->user()->jurusan ?? 'SMKN 1 Pwt', 20) }}</div>
      </div>
    </div>

    {{-- Streak mini --}}
    @php
      $streakCount = auth()->user()->streak?->streak_count ?? 0;
      $isActive    = auth()->user()->streak?->last_active_date?->isToday() ?? false;
    @endphp
    <a href="{{ route('siswa.latihan') }}" class="sb-link" data-tooltip="Streak: {{ $streakCount }} hari"
       style="{{ $isActive ? 'color:#f97316;' : 'color:#94a3b8;' }}">
      <span class="sb-ico">🔥</span>
      <span class="sb-lbl" style="font-family:'Fredoka One',sans-serif;">
        {{ $streakCount }} hari streak
      </span>
    </a>

    {{-- Notif --}}
    @php $notifCount = auth()->user()->notifications()->where('is_read',false)->count(); @endphp
    @if($notifCount > 0)
    <button class="sb-link" style="width:100%;background:none;border:none;cursor:pointer;text-align:left;" onclick="markNotifRead()">
      <span class="sb-ico">🔔</span>
      <span class="sb-lbl">{{ $notifCount }} Notifikasi</span>
    </button>
    @endif

    {{-- Profil --}}
    @if(Route::has('siswa.profil'))
    <a href="{{ route('siswa.profil') }}" data-tooltip="Profil"
       class="sb-link {{ request()->routeIs('siswa.profil') ? 'active' : '' }}">
      <span class="sb-ico">👤</span><span class="sb-lbl">Profil</span>
    </a>
    @endif

    <div class="sb-divider" style="margin:.35rem 0;"></div>

    {{-- Logout --}}
    <form method="POST" action="{{ route('logout') }}" class="logout-form">
      @csrf
      <button type="submit" class="sb-logout">
        <span class="sb-ico">🚪</span>
        <span class="sb-lbl">Logout</span>
      </button>
    </form>

  </div>
</aside>

{{-- ═══ MAIN WRAPPER ═══ --}}
<div class="main-wrapper" id="main-wrapper">

  {{-- Topbar mobile --}}
  <div class="topbar">
    <button class="hamburger" onclick="openSidebar()">☰</button>
    <div class="topbar-brand"><span>🐱</span> Sinau</div>
    <div class="topbar-right">
      <span class="streak-pill-top">🔥 {{ $streakCount }}</span>
      <button class="notif-btn-top" onclick="markNotifRead()">
        🔔
        @if($notifCount > 0)
          <span class="notif-dot" id="notif-badge">{{ $notifCount }}</span>
        @endif
      </button>
    </div>
  </div>

  {{-- Main Content --}}
  <div class="main-content">
    @if(session('success'))
      <div class="salert-s">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="salert-e">⚠️ {{ session('error') }}</div>
    @endif
    @yield('content')
  </div>

</div>

<script src="{{ asset('js/sinau.js') }}"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
const SIDEBAR_KEY = 'sinau_siswa_sidebar';
const sidebar     = document.getElementById('sidebar');
const toggleBtn   = document.getElementById('sb-toggle');
const overlay     = document.getElementById('sidebar-overlay');

function setSidebarState(collapsed){
  if(collapsed){
    sidebar.classList.add('collapsed');
    if(toggleBtn) toggleBtn.textContent='❯';
    localStorage.setItem(SIDEBAR_KEY,'1');
  } else {
    sidebar.classList.remove('collapsed');
    if(toggleBtn) toggleBtn.textContent='❮';
    localStorage.setItem(SIDEBAR_KEY,'0');
  }
}
function toggleSidebar(){ setSidebarState(!sidebar.classList.contains('collapsed')); }
function openSidebar(){
  sidebar.classList.add('mobile-open');
  overlay.classList.add('show');
  document.body.style.overflow='hidden';
}
function closeSidebar(){
  sidebar.classList.remove('mobile-open');
  overlay.classList.remove('show');
  document.body.style.overflow='';
}
document.addEventListener('DOMContentLoaded',()=>{
  if(localStorage.getItem(SIDEBAR_KEY)==='1') setSidebarState(true);
  window.addEventListener('resize',()=>{ if(window.innerWidth>768) closeSidebar(); });
  
  // Attach AOS attributes to cards dynamically
  const cards = document.querySelectorAll('.card, .stat-card, .action-card, .leaderboard-card');
  cards.forEach((el, i) => {
    el.setAttribute('data-aos', 'fade-up');
    el.setAttribute('data-aos-delay', (i % 4) * 50);
  });
  
  if (typeof AOS !== 'undefined') {
    AOS.init({duration:600, once:true});
  }
});
function markNotifRead(){
  fetch('{{ route("siswa.notif.read") }}',{
    method:'POST',
    headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}
  });
  const b=document.getElementById('notif-badge');
  if(b) b.remove();
}
</script>
@stack('scripts')
</body>
</html>

