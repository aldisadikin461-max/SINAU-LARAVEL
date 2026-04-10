<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title','Admin') — Sinau</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/sinau.css') }}">
  <script src="{{ asset('js/particles.js') }}" defer></script>
  <!-- Styles migrated to public/css/sinau.css -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body>

<div class="sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

{{-- ═══ SIDEBAR ADMIN ═══ --}}
<aside class="sidebar" id="sidebar">
  <button class="sb-toggle" id="sb-toggle" onclick="toggleSidebar()" title="Toggle sidebar">❮</button>

  <div class="sb-brand">
    <span class="sb-brand-cat">🐱</span>
    <span class="sb-brand-text">Sinau</span>
  </div>

  <nav class="sb-nav">

    {{-- HOME --}}
    <a href="{{ route('home') }}" data-tooltip="Beranda"
       class="sb-link {{ request()->routeIs('home') ? 'active' : '' }}">
      <span class="sb-ico">🏠</span><span class="sb-lbl">Beranda</span>
    </a>

    <div class="sb-divider"></div>

    {{-- OVERVIEW --}}
    <div class="sb-group">📊 Overview</div>
    <a href="{{ route('admin.dashboard') }}" data-tooltip="Dashboard"
       class="sb-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <span class="sb-ico">🏠</span><span class="sb-lbl">Dashboard</span>
    </a>
    <a href="{{ route('admin.statistik') }}" data-tooltip="Statistik"
       class="sb-link {{ request()->routeIs('admin.statistik') ? 'active' : '' }}">
      <span class="sb-ico">📈</span><span class="sb-lbl">Statistik</span>
    </a>

    <div class="sb-divider"></div>

    {{-- KELOLA --}}
    <div class="sb-group">👥 Kelola</div>
    <a href="{{ route('admin.users.index') }}" data-tooltip="Kelola User"
       class="sb-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
      <span class="sb-ico">👤</span><span class="sb-lbl">Kelola User</span>
    </a>
    <a href="{{ route('admin.scholarships.index') }}" data-tooltip="Beasiswa"
       class="sb-link {{ request()->routeIs('admin.scholarships.*') ? 'active' : '' }}">
      <span class="sb-ico">🎓</span><span class="sb-lbl">Beasiswa</span>
    </a>
    @if(Route::has('admin.alumni.index'))
    <a href="{{ route('admin.alumni.index') }}" data-tooltip="Alumni"
       class="sb-link {{ request()->routeIs('admin.alumni.*') ? 'active' : '' }}">
      <span class="sb-ico">👥</span><span class="sb-lbl">Alumni</span>
    </a>
    @endif

    <div class="sb-divider"></div>

    {{-- KOMUNIKASI --}}
    <div class="sb-group">📣 Komunikasi</div>
    <a href="{{ route('admin.whatsapp.index') }}" data-tooltip="WA Blast"
       class="sb-link {{ request()->routeIs('admin.whatsapp.*') ? 'active' : '' }}">
      <span class="sb-ico">💬</span><span class="sb-lbl">WA Blast</span>
    </a>
    @if(Route::has('chat.index'))
    <a href="{{ route('chat.index') }}" data-tooltip="Chat Guru"
       class="sb-link {{ request()->routeIs('chat.*') ? 'active' : '' }}">
      <span class="sb-ico">💭</span><span class="sb-lbl">Chat Guru</span>
    </a>
    @endif

  </nav>

  <div class="sb-bottom">
    <div class="sb-user">
      <div class="sb-user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
      <div class="sb-user-info">
        <div class="sb-user-name">{{ auth()->user()->name }}</div>
        <div class="sb-user-role">🛡️ Admin</div>
      </div>
    </div>

    @if(Route::has('admin.profil'))
    <a href="{{ route('admin.profil') }}" data-tooltip="Profil"
       class="sb-link {{ request()->routeIs('admin.profil') ? 'active' : '' }}">
      <span class="sb-ico">👤</span><span class="sb-lbl">Profil</span>
    </a>
    @endif

    <div class="sb-divider" style="margin:.35rem 0;"></div>

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

  <div class="topbar">
    <button class="hamburger" onclick="openSidebar()">☰</button>
    <div class="topbar-brand"><span>🐱</span> Sinau</div>
    <div class="topbar-right">
      <span class="role-pill-top">🛡️ Admin</span>
    </div>
  </div>

  <div class="main-content">
    @if(session('success'))<div class="salert">✅ {{ session('success') }}</div>@endif
    @if(session('error'))<div class="serror">❌ {{ session('error') }}</div>@endif
    @yield('content')
  </div>

</div>

<script src="{{ asset('js/sinau.js') }}"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
const SIDEBAR_KEY = 'sinau_admin_sidebar';
const sidebarWrap = document.getElementById('sidebar-wrapper');
const toggleBtn   = document.getElementById('sb-toggle');
const overlay     = document.getElementById('sidebar-overlay');

function setSidebarState(collapsed){
  if(collapsed){sidebarWrap.classList.add('collapsed');if(toggleBtn)toggleBtn.textContent='❯';localStorage.setItem(SIDEBAR_KEY,'1');}
  else{sidebarWrap.classList.remove('collapsed');if(toggleBtn)toggleBtn.textContent='❮';localStorage.setItem(SIDEBAR_KEY,'0');}
}
function toggleSidebar(){setSidebarState(!sidebarWrap.classList.contains('collapsed'));}
function openSidebar(){sidebarWrap.classList.add('mobile-open');overlay.classList.add('show');document.body.style.overflow='hidden';}
function closeSidebar(){sidebarWrap.classList.remove('mobile-open');overlay.classList.remove('show');document.body.style.overflow='';}
document.addEventListener('DOMContentLoaded',()=>{
  if(localStorage.getItem(SIDEBAR_KEY)==='1') setSidebarState(true);
  window.addEventListener('resize',()=>{if(window.innerWidth>768)closeSidebar();});
  
  // Attach AOS attributes to cards dynamically
  const cards = document.querySelectorAll('.card, .stat-card, .action-card, .chart-card');
  cards.forEach((el, i) => {
    el.setAttribute('data-aos', 'fade-up');
    el.setAttribute('data-aos-delay', (i % 4) * 50);
  });
  
  if (typeof AOS !== 'undefined') {
    AOS.init({duration:600, once:true});
  }
});
</script>
@stack('scripts')
</body>
</html>

