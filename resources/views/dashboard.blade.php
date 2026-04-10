@extends('layouts.siswa')
@section('title','Dashboard')
@section('content')
<style>
  /* --- BASE & GREETING --- */
  .card{background:#fff;border:1px solid rgba(14,165,233,.1);border-radius:1.25rem;box-shadow:0 4px 20px rgba(14,165,233,.07);padding:1.5rem;}
  .greeting-card{display:flex;align-items:center;gap:1.5rem;margin-bottom:1.5rem;}
  .greeting-kinners svg{filter:drop-shadow(0 8px 20px rgba(14,165,233,.2));animation:float 3.5s ease-in-out infinite;}
  @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
  .greeting-text h1{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;}
  .greeting-text p{color:#94a3b8;font-weight:600;font-size:.9rem;margin:.25rem 0 .75rem;}
  .pills{display:flex;gap:.6rem;flex-wrap:wrap;}
  .pill{display:inline-flex;align-items:center;gap:.3rem;padding:.3rem .9rem;border-radius:999px;font-size:.82rem;font-weight:800;font-family:'Nunito',sans-serif;}
  .pill-streak{background:linear-gradient(135deg,#f97316,#ef4444);color:#fff;box-shadow:0 3px 10px rgba(249,115,22,.3);}
  .pill-poin{background:#fef9c3;border:1.5px solid #fde68a;color:#ca8a04;}
  .pill-level{background:#e0f2fe;border:1.5px solid #bae6fd;color:#0284c7;}

  /* --- QUICK ACTIONS --- */
  .quick-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem;}
  @media(max-width:700px){.quick-grid{grid-template-columns:repeat(2,1fr);}}
  .qcard{background:#fff;border:1.5px solid rgba(14,165,233,.1);border-radius:1.25rem;padding:1.25rem;text-align:center;text-decoration:none;transition:all .2s;box-shadow:0 2px 12px rgba(14,165,233,.06);}
  .qcard:hover{transform:translateY(-4px);box-shadow:0 12px 32px rgba(14,165,233,.14);border-color:rgba(14,165,233,.25);}
  .qcard .qi{font-size:2rem;margin-bottom:.4rem;}
  .qcard .ql{font-size:.82rem;font-weight:800;color:#475569;font-family:'Nunito',sans-serif;}


  /* --- OTHERS --- */
  .section-title{font-family:'Fredoka One',sans-serif;font-size:1.3rem;color:#0f172a;margin:1.5rem 0 1rem;display:flex;align-items:center;gap:.5rem;}
  .quiz-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1rem;}
  .quiz-card{background:#fff;border:1.5px solid rgba(99,102,241,.12);border-radius:1.25rem;padding:1.25rem;position:relative;display:flex;flex-direction:column;}
  .btn-kerjakan{display:inline-flex;align-items:center;gap:.4rem;background:linear-gradient(135deg,#0ea5e9,#6366f1);color:#fff;border-radius:999px;padding:.45rem 1.1rem;font-size:.82rem;font-weight:800;text-decoration:none;margin-top:auto;}
  .finput{border:2px solid rgba(14,165,233,.15);border-radius:999px;padding:.45rem 1.1rem;outline:none;}
  .fbtn{padding:.45rem 1.3rem;border-radius:999px;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;border:none;cursor:pointer;font-weight:800;}
</style>

@php
    $streakSvc  = app(\App\Services\StreakService::class);
    $streakData = $streakSvc->getStreakData(auth()->id());
@endphp

<div class="card greeting-card">
  <div class="greeting-kinners">
    <svg width="80" height="80" viewBox="0 0 120 120" fill="none">
      <circle cx="60" cy="68" r="44" fill="white" stroke="#7dd3fc" stroke-width="2"/>
      <circle cx="47" cy="65" r="6" fill="#0f172a"/><circle cx="75" cy="65" r="6" fill="#0f172a"/>
      <path d="M52 85 Q60 93 68 85" stroke="#7dd3fc" stroke-width="2" fill="none" stroke-linecap="round"/>
    </svg>
  </div>
  <div class="greeting-text">
    <h1>Hai, {{ auth()->user()->name }}! 👋</h1>
    <p>Kinners menyapamu — Smeconer SMKN 1 Purwokerto!</p>
    <div class="pills">
      <span class="pill pill-streak">🔥 Streak: {{ $streakData['current'] }} hari</span>
      <span class="pill pill-poin">⭐ Poin: {{ auth()->user()->total_poin ?? 0 }}</span>
      <span class="pill pill-level">📊 Level {{ auth()->user()->level ?? 1 }}</span>
    </div>
  </div>
</div>

<div class="quick-grid">
  @foreach([['siswa.latihan','❓','Latihan'],['siswa.leaderboard','🏆','Ranking'],['siswa.study-plan','📅','Jadwal'],['siswa.pomodoro','⏱️','Fokus']] as [$r,$i,$l])
    <a href="{{ route($r) }}" class="qcard">
      <div class="qi">{{ $i }}</div><div class="ql">{{ $l }}</div>
    </a>
  @endforeach
</div>

<div class="section-title">📝 Paket Soal</div>
<div class="quiz-grid">
  @foreach($quizPackets ?? [] as $packet)
  <div class="quiz-card">
    <div style="font-weight:800; margin-bottom:0.5rem;">{{ $packet->nama }}</div>
    <div style="font-size:0.8rem; color:#94a3b8; margin-bottom:1rem; flex-grow:1;">{{ Str::limit($packet->deskripsi, 80) }}</div>
    <a href="{{ route('siswa.quiz.show', $packet) }}" class="btn-kerjakan">✏️ Mulai</a>
  </div>
  @endforeach
</div>

{{-- Ebook catalog --}}
<div class="section-title">📚 Katalog E-Book</div>
<form method="GET" class="filter-row">
  <input name="search" value="{{ request('search') }}" placeholder="Cari e-book..." class="finput" style="width:200px;">
  <select name="category_id" class="finput">
    <option value="">Semua Kategori</option>
    @foreach($categories as $c)
      <option value="{{ $c->id }}" {{ request('category_id')==$c->id?'selected':'' }}>{{ $c->nama_kategori }}</option>
    @endforeach
  </select>
  <button type="submit" class="fbtn">Filter</button>
</form>

<div class="ebook-grid">
  @forelse($ebooks as $ebook)
    <div class="ebook-item">
      <div class="ebook-cover">
        @if($ebook->cover)
          <img src="{{ Storage::url($ebook->cover) }}" style="width:100%;height:100%;object-fit:cover;" alt="">
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
<div style="margin-top:1rem;">{{ $ebooks->links() }}</div>
@endif

@endsection