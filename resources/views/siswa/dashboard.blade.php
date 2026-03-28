@extends('layouts.siswa')
@section('title','Dashboard')
@section('content')
<style>
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
  .quick-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem;}
  @media(max-width:700px){.quick-grid{grid-template-columns:repeat(2,1fr);}}
  .qcard{background:#fff;border:1.5px solid rgba(14,165,233,.1);border-radius:1.25rem;padding:1.25rem;text-align:center;text-decoration:none;transition:all .2s;box-shadow:0 2px 12px rgba(14,165,233,.06);}
  .qcard:hover{transform:translateY(-4px);box-shadow:0 12px 32px rgba(14,165,233,.14);border-color:rgba(14,165,233,.25);}
  .qcard .qi{font-size:2rem;margin-bottom:.4rem;}
  .qcard .ql{font-size:.82rem;font-weight:800;color:#475569;font-family:'Nunito',sans-serif;}
  .section-title{font-family:'Fredoka One',sans-serif;font-size:1.3rem;color:#0f172a;margin-bottom:1rem;display:flex;align-items:center;gap:.5rem;}
  .badge-row{display:flex;gap:.6rem;flex-wrap:wrap;margin-bottom:1.5rem;}
  .badge-chip{background:#fff;border:1.5px solid rgba(14,165,233,.15);border-radius:999px;padding:.35rem .9rem;display:inline-flex;align-items:center;gap:.4rem;font-size:.82rem;font-weight:800;color:#0284c7;box-shadow:0 2px 8px rgba(14,165,233,.08);}
  .filter-row{display:flex;gap:.75rem;flex-wrap:wrap;margin-bottom:1.25rem;}
  .finput{background:#fff;border:2px solid rgba(14,165,233,.15);border-radius:999px;padding:.45rem 1.1rem;font-size:.88rem;font-weight:700;color:#1e293b;outline:none;font-family:'Nunito',sans-serif;transition:border-color .2s;}
  .finput:focus{border-color:#0ea5e9;}
  .fbtn{padding:.45rem 1.3rem;border-radius:999px;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;font-size:.88rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;box-shadow:0 3px 12px rgba(14,165,233,.3);transition:all .2s;}
  .fbtn:hover{transform:translateY(-2px);}
  .ebook-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:1rem;}
  .ebook-item{background:#fff;border:1.5px solid rgba(14,165,233,.1);border-radius:1rem;overflow:hidden;transition:all .2s;box-shadow:0 2px 10px rgba(14,165,233,.06);}
  .ebook-item:hover{transform:translateY(-5px);box-shadow:0 12px 30px rgba(14,165,233,.14);}
  .ebook-cover{aspect-ratio:3/4;background:linear-gradient(135deg,#e0f2fe,#bae6fd);display:flex;align-items:center;justify-content:center;font-size:2.5rem;}
  .ebook-info{padding:.75rem;}
  .ebook-judul{font-size:.8rem;font-weight:800;color:#0f172a;line-height:1.35;margin-bottom:.3rem;}
  .ebook-penulis{font-size:.72rem;color:#94a3b8;font-weight:600;margin-bottom:.5rem;}
  .ebook-btn{display:block;text-align:center;background:#e0f2fe;color:#0284c7;border-radius:999px;padding:.3rem;font-size:.76rem;font-weight:800;text-decoration:none;transition:all .2s;font-family:'Nunito',sans-serif;}
  .ebook-btn:hover{background:#0ea5e9;color:#fff;}
  .empty-state{text-align:center;padding:3rem 1rem;color:#94a3b8;}
  .empty-state .ei{font-size:3rem;margin-bottom:.75rem;}
  .empty-state p{font-weight:700;font-size:.95rem;}
</style>

{{-- Greeting --}}
<div class="card greeting-card">
  <div class="greeting-kinners">
    <svg width="80" height="80" viewBox="0 0 120 120" fill="none">
      <circle cx="60" cy="68" r="44" fill="white" stroke="#7dd3fc" stroke-width="2"/>
      <path d="M28 46 L16 14 L50 38 Z" fill="white" stroke="#7dd3fc" stroke-width="1.8" stroke-linejoin="round"/>
      <path d="M31 43 L21 18 L47 36 Z" fill="#bae6fd"/>
      <path d="M92 46 L104 14 L70 38 Z" fill="white" stroke="#7dd3fc" stroke-width="1.8" stroke-linejoin="round"/>
      <path d="M89 43 L99 18 L73 36 Z" fill="#bae6fd"/>
      <ellipse cx="46" cy="64" rx="10" ry="11" fill="white" stroke="#7dd3fc" stroke-width="1.2"/>
      <ellipse cx="74" cy="64" rx="10" ry="11" fill="white" stroke="#7dd3fc" stroke-width="1.2"/>
      <circle cx="47" cy="65" r="6" fill="#0f172a"/>
      <circle cx="75" cy="65" r="6" fill="#0f172a"/>
      <circle cx="50" cy="62" r="2.5" fill="white"/>
      <circle cx="78" cy="62" r="2.5" fill="white"/>
      <ellipse cx="36" cy="76" rx="9" ry="5.5" fill="#fda4af" opacity=".45"/>
      <ellipse cx="84" cy="76" rx="9" ry="5.5" fill="#fda4af" opacity=".45"/>
      <ellipse cx="60" cy="78" rx="4" ry="3" fill="#7dd3fc"/>
      <path d="M52 85 Q60 93 68 85" stroke="#7dd3fc" stroke-width="2" fill="none" stroke-linecap="round"/>
    </svg>
  </div>
  <div class="greeting-text">
    <h1>Hai, {{ auth()->user()->name }}! 👋</h1>
    <p>Kinners menyapamu — Smeconer SMKN 1 Purwokerto!</p>
    <div class="pills">
      <span class="pill pill-streak">🔥 Streak: <span id="streak-count">{{ $streak?->streak_count??0 }}</span> hari</span>
      <span class="pill pill-poin">⭐ Poin: {{ auth()->user()->total_poin }}</span>
      <span class="pill pill-level">📊 Level {{ auth()->user()->level }}</span>
    </div>
  </div>
</div>

{{-- Quick actions --}}
<div class="quick-grid">
  @foreach([['siswa.latihan','❓','Latihan Soal'],['siswa.leaderboard','🏆','Leaderboard'],['siswa.study-plan','📅','Study Plan'],['siswa.pomodoro','⏱️','Pomodoro']] as [$r,$i,$l])
    <a href="{{ route($r) }}" class="qcard">
      <div class="qi">{{ $i }}</div>
      <div class="ql">{{ $l }}</div>
    </a>
  @endforeach
</div>

{{-- Badges --}}
@if($badges->count())
<div class="section-title">🏅 Badge Kamu</div>
<div class="badge-row">
  @foreach($badges as $ub)
    <div class="badge-chip">{{ $ub->badge->icon }} {{ $ub->badge->nama }}</div>
  @endforeach
</div>
@endif

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
@endsection