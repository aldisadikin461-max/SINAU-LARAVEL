@extends('layouts.siswa')
@section('title','Dashboard')
@section('content')

<style>
/* ── Dashboard Hero Grid ─────────────────────────── */
.dash-hero-grid {
  display: grid;
  grid-template-columns: 1fr 300px;
  gap: 1.5rem;
  margin-bottom: 1.5rem;
  align-items: stretch;
}
@media (max-width: 900px) {
  .dash-hero-grid { grid-template-columns: 1fr; }
}
.streak-panel {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
</style>

{{-- Alerts --}}
@if(session('success'))
  <div class="salert-s">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="salert-e">⚠️ {{ session('error') }}</div>
@endif

{{-- ══ ROW 1: Greeting Hero + Streak ══ --}}
<div class="dash-hero-grid">

  {{-- Greeting Hero --}}
  <div class="greeting-bento">
    <div style="position:relative;z-index:1;flex:1;">
      <div style="font-size:0.72rem;font-weight:800;color:rgba(255,255,255,0.6);text-transform:uppercase;letter-spacing:0.12em;margin-bottom:0.6rem;">
        Dashboard Belajar
      </div>
      <div class="greeting-name">Halo, {{ explode(' ', auth()->user()->name)[0] }}! 👋</div>
      <div class="greeting-sub">Smeconer SMKN 1 Purwokerto — Ayo terus semangat belajar hari ini!</div>
      <div class="greeting-pills">
        <span class="g-pill g-pill-fire">🔥 {{ $streakData['current'] }} hari streak</span>
        <span class="g-pill">⭐ {{ number_format(auth()->user()->total_poin) }} Poin</span>
        <span class="g-pill">📊 Level {{ auth()->user()->level }}</span>
      </div>
    </div>
    <div class="greeting-mascot">
      <svg width="110" height="110" viewBox="0 0 120 120" fill="none">
        <circle cx="60" cy="68" r="44" fill="rgba(255,255,255,0.18)" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"/>
        <path d="M28 46 L16 14 L50 38 Z" fill="rgba(255,255,255,0.2)" stroke="rgba(255,255,255,0.5)" stroke-width="1.8" stroke-linejoin="round"/>
        <path d="M31 43 L21 18 L47 36 Z" fill="rgba(255,255,255,0.3)"/>
        <path d="M92 46 L104 14 L70 38 Z" fill="rgba(255,255,255,0.2)" stroke="rgba(255,255,255,0.5)" stroke-width="1.8" stroke-linejoin="round"/>
        <path d="M89 43 L99 18 L73 36 Z" fill="rgba(255,255,255,0.3)"/>
        <ellipse cx="46" cy="64" rx="10" ry="11" fill="rgba(255,255,255,0.92)" stroke="rgba(255,255,255,0.5)" stroke-width="1.2"/>
        <ellipse cx="74" cy="64" rx="10" ry="11" fill="rgba(255,255,255,0.92)" stroke="rgba(255,255,255,0.5)" stroke-width="1.2"/>
        <circle cx="47" cy="65" r="6" fill="#1E3A8A"/>
        <circle cx="75" cy="65" r="6" fill="#1E3A8A"/>
        <circle cx="50" cy="62" r="2.5" fill="white"/>
        <circle cx="78" cy="62" r="2.5" fill="white"/>
        <ellipse cx="36" cy="76" rx="9" ry="5.5" fill="#FDA4AF" opacity=".5"/>
        <ellipse cx="84" cy="76" rx="9" ry="5.5" fill="#FDA4AF" opacity=".5"/>
        <ellipse cx="60" cy="78" rx="4" ry="3" fill="rgba(255,255,255,0.6)"/>
        <path d="M52 85 Q60 93 68 85" stroke="rgba(255,255,255,0.7)" stroke-width="2" fill="none" stroke-linecap="round"/>
      </svg>
    </div>
  </div>

  {{-- Streak Panel --}}
  @if($streakData['is_active'])
    <div class="streak-bento streak-panel">
      <div style="display:flex;align-items:flex-start;justify-content:space-between;">
        <div>
          <div style="font-size:0.65rem;font-weight:800;color:#92400E;text-transform:uppercase;letter-spacing:0.1em;margin-bottom:0.5rem;">🔥 Status Streak</div>
          <div class="sb-num">{{ $streakData['current'] }}</div>
          <div class="sb-unit">hari berturut-turut!</div>
          <div class="sb-sub">🏆 Rekor: {{ $streakData['longest'] }} hari</div>
        </div>
        <div class="sb-fire-ico">🔥</div>
      </div>
      @if($streakData['longest'] > 0)
        @php $pct = min(100, round($streakData['current'] / $streakData['longest'] * 100)); @endphp
        <div>
          <div class="sb-prog-bar"><div class="sb-prog-fill" style="width:{{ $pct }}%"></div></div>
          <div class="sb-prog-labels"><span>0</span><span>Rekor {{ $streakData['longest'] }}h</span></div>
        </div>
      @endif
      @php
        $msgs = ['Pertahankan terus! 💪','Kamu sedang on fire! 🔥','Konsisten adalah kunci! 🗝️','Kinners bangga! 🐱'];
        $msg  = $msgs[$streakData['current'] % count($msgs)];
      @endphp
      <div class="sb-quote">"{{ $msg }}"</div>
    </div>

  @elseif($streakData['recovery_left'] > 0)
    <div class="streak-bento streak-bento-dead streak-panel">
      <div>
        <div style="font-size:0.65rem;font-weight:800;color:var(--muted);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:0.75rem;">Status Streak</div>
        <div style="font-size:2.5rem;margin-bottom:0.5rem;">😿</div>
        <div style="font-size:1.2rem;font-weight:800;color:var(--text);">Streak mati</div>
        <div style="font-size:0.85rem;color:var(--muted);margin-top:0.3rem;">Kamu masih punya {{ $streakData['recovery_left'] }}x recovery!</div>
      </div>
      <div style="display:flex;flex-direction:column;gap:0.6rem;margin-top:1rem;">
        <form method="POST" action="{{ route('siswa.streak.activate') }}">
          @csrf
          <button type="submit" class="btn-fire" style="width:100%;">🔥 Jawab Soal Dulu!</button>
        </form>
        <form method="POST" action="{{ route('siswa.streak.recover') }}">
          @csrf
          <button type="submit" class="btn-recover" style="width:100%;">♻️ Pulihkan (sisa {{ $streakData['recovery_left'] }}x)</button>
        </form>
      </div>
    </div>

  @else
    <div class="streak-bento streak-bento-dead streak-panel">
      <div>
        <div style="font-size:0.65rem;font-weight:800;color:var(--muted);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:0.75rem;">Status Streak</div>
        <div style="font-size:2.5rem;margin-bottom:0.5rem;">{{ $streakData['current'] > 0 ? '😢' : '🌱' }}</div>
        <div style="font-size:1.2rem;font-weight:800;color:var(--text);">{{ $streakData['current'] > 0 ? 'Streak mati' : 'Mulai streak!' }}</div>
        <div style="font-size:0.85rem;color:var(--muted);margin-top:0.3rem;">{{ $streakData['current'] > 0 ? 'Recovery bulan ini habis. Mulai dari awal!' : 'Jawab 1 soal untuk memulai!' }}</div>
      </div>
      <form method="POST" action="{{ route('siswa.streak.activate') }}" style="margin-top:1rem;">
        @csrf
        <button type="submit" class="btn-fire" style="width:100%;">🔥 Nyalakan Api Sekarang!</button>
      </form>
    </div>
  @endif

</div>{{-- end .dash-hero-grid --}}

{{-- ══ ROW 2: Quick Action Bento ══ --}}
<div class="quick-bento">
  <a href="{{ route('siswa.latihan') }}" class="qbento">
    <div class="qb-icon">📝</div>
    <div class="qb-label">Latihan Soal</div>
    <div class="qb-desc">Asah kemampuanmu</div>
  </a>
  <a href="{{ route('siswa.leaderboard') }}" class="qbento qbento-orange">
    <div class="qb-icon">🏆</div>
    <div class="qb-label">Leaderboard</div>
    <div class="qb-desc">Lihat peringkatmu</div>
  </a>
  <a href="{{ route('siswa.study-plan') }}" class="qbento qbento-purple">
    <div class="qb-icon">📅</div>
    <div class="qb-label">Study Plan</div>
    <div class="qb-desc">Jadwal belajar harian</div>
  </a>
  <a href="{{ route('siswa.pomodoro') }}" class="qbento qbento-green">
    <div class="qb-icon">⏱️</div>
    <div class="qb-label">Pomodoro</div>
    <div class="qb-desc">Fokus & produktif</div>
  </a>
</div>

{{-- ══ ROW 3: Paket Soal ══ --}}
@if($paketSoal->count())
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;">
  <div class="section-title" style="margin-bottom:0;">📝 Paket Soal Tersedia</div>
  <a href="{{ route('siswa.quiz.index') }}" style="font-size:0.85rem;font-weight:700;color:var(--primary);">Lihat Semua →</a>
</div>
<div class="paket-grid">
  @foreach($paketSoal as $paket)
    <div class="paket-card">
      <div class="paket-nama">{{ $paket->nama }}</div>
      <div class="paket-meta">
        <span class="paket-chip">📋 {{ $paket->quiz_questions_count }} soal</span>
        @if($paket->kelas)<span class="paket-chip">🏫 Kelas {{ $paket->kelas }}</span>@endif
        @if($paket->jurusan)<span class="paket-chip">🎓 {{ Str::limit($paket->jurusan, 20) }}</span>@endif
      </div>
      @if($paket->deskripsi)
        <div class="paket-desc">{{ Str::limit($paket->deskripsi, 90) }}</div>
      @endif
      <a href="{{ route('siswa.quiz.kerjakan', $paket->id) }}" class="btn-kerjakan">Kerjakan Sekarang →</a>
    </div>
  @endforeach
</div>
@endif

{{-- ══ ROW 4: Badges ══ --}}
@if($badges->count())
<div class="section-title">🏅 Badge Kamu</div>
<div class="badge-row">
  @foreach($badges as $ub)
    <div class="badge-chip">{{ $ub->badge->icon }} {{ $ub->badge->nama }}</div>
  @endforeach
</div>
@endif

{{-- ══ ROW 5: E-Book Catalog ══ --}}
<div class="section-title">📚 Katalog E-Book</div>
<form method="GET" class="filter-row">
  <input name="search" value="{{ request('search') }}" placeholder="🔍 Cari judul e-book..." class="sinau-input" style="width:220px;border-radius:999px;">
  <select name="category_id" class="sinau-input" style="width:auto;border-radius:999px;">
    <option value="">Semua Kategori</option>
    @foreach($categories as $c)
      <option value="{{ $c->id }}" {{ request('category_id')==$c->id?'selected':'' }}>{{ $c->nama_kategori }}</option>
    @endforeach
  </select>
  <button type="submit" class="btn-primary">Filter</button>
</form>

<div class="ebook-grid">
  @forelse($ebooks as $ebook)
    <div class="ebook-item">
      <div class="ebook-cover">
        @if($ebook->cover)
          <img src="{{ Storage::url($ebook->cover) }}" alt="{{ $ebook->judul }}">
        @else
          📄
        @endif
      </div>
      <div class="ebook-info">
        <div class="ebook-judul">{{ $ebook->judul }}</div>
        <div class="ebook-penulis">{{ $ebook->penulis }}</div>
        <a href="{{ Storage::url($ebook->file_path) }}" target="_blank" class="ebook-btn">Baca 📖</a>
      </div>
    </div>
  @empty
    <div class="empty-state" style="grid-column:1/-1;">
      <div class="ei">🐱</div>
      <p>Belum ada e-book. Kinners juga ikut menunggu!</p>
    </div>
  @endforelse
</div>
<div style="margin-top:1.25rem;">{{ $ebooks->links() }}</div>

@endsection
