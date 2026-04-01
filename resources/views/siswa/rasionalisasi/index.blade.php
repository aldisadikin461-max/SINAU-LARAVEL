@extends('layouts.siswa')
@section('title','Rasionalisasi')
@section('content')
<style>
:root{--blue:#1a8cff;--blue-press:#005bb8;--blue-light:#e8f4ff;--border:#d0e4f7;}
.rasi-wrap{max-width:860px;margin:0 auto;}
.rasi-hero{text-align:center;padding:2rem 1rem 2.5rem;}
.rasi-hero h1{font-family:'Fredoka One',sans-serif;font-size:2.2rem;color:#0f172a;margin-bottom:.5rem;}
.rasi-hero p{color:#64748b;font-size:1rem;font-weight:600;max-width:520px;margin:0 auto;}
.kinners-row{display:flex;align-items:flex-end;justify-content:center;gap:1rem;margin:1.5rem 0;}
.kinners-row svg{animation:float 3.5s ease-in-out infinite;filter:drop-shadow(0 6px 16px rgba(26,140,255,.2));}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
.speech{background:#fff;border:2px solid var(--border);border-radius:1rem 1rem 1rem 0;padding:.6rem 1rem;font-size:.88rem;font-weight:700;color:var(--blue);font-style:italic;box-shadow:0 4px 0 var(--border);max-width:220px;text-align:center;}
.mode-grid{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:2rem;}
@media(max-width:600px){.mode-grid{grid-template-columns:1fr;}}
.mode-card{background:#fff;border:2px solid var(--border);border-radius:1.5rem;padding:2rem 1.5rem;text-align:center;box-shadow:0 4px 0 var(--border);transition:all .2s;text-decoration:none;display:block;}
.mode-card:hover{transform:translateY(-4px);box-shadow:0 8px 0 var(--border);border-color:var(--blue);}
.mode-card .ico{font-size:3.5rem;margin-bottom:1rem;display:block;}
.mode-card h2{font-family:'Fredoka One',sans-serif;font-size:1.5rem;color:#0f172a;margin-bottom:.5rem;}
.mode-card p{color:#64748b;font-size:.88rem;font-weight:600;line-height:1.6;margin-bottom:1.25rem;}
.mode-card ul{text-align:left;list-style:none;padding:0;margin-bottom:1.5rem;}
.mode-card ul li{font-size:.82rem;color:#475569;font-weight:600;padding:.25rem 0;display:flex;align-items:center;gap:.4rem;}
.mode-card ul li::before{content:'✓';color:var(--blue);font-weight:900;}
.btn-mode{display:block;padding:.75rem 1.5rem;border-radius:999px;background:var(--blue);color:#fff;font-weight:800;font-size:.95rem;box-shadow:0 5px 0 var(--blue-press);transition:all .15s;font-family:'Nunito',sans-serif;border:none;cursor:pointer;width:100%;text-decoration:none;}
.btn-mode:hover{transform:translateY(2px);box-shadow:0 3px 0 var(--blue-press);}
.btn-mode:active{transform:translateY(5px);box-shadow:0 0px 0 var(--blue-press);}
.riwayat-sec{margin-top:1rem;}
.riwayat-title{font-family:'Fredoka One',sans-serif;font-size:1.2rem;color:#0f172a;margin-bottom:1rem;display:flex;align-items:center;justify-content:space-between;}
.riwayat-title a{font-size:.82rem;font-weight:800;color:var(--blue);text-decoration:none;}
.riwayat-list{display:flex;flex-direction:column;gap:.75rem;}
.riwayat-item{background:#fff;border:1.5px solid var(--border);border-radius:1rem;padding:1rem 1.25rem;display:flex;align-items:center;justify-content:space-between;gap:1rem;text-decoration:none;transition:all .2s;box-shadow:0 3px 0 var(--border);}
.riwayat-item:hover{border-color:var(--blue);transform:translateX(4px);}
.ri-left{display:flex;align-items:center;gap:.75rem;}
.ri-ico{width:2.5rem;height:2.5rem;border-radius:.75rem;display:flex;align-items:center;justify-content:center;font-size:1.2rem;}
.ri-ico.kuliah{background:#e8f4ff;}
.ri-ico.kerja{background:#fef9c3;}
.ri-meta{font-family:'Fredoka One',sans-serif;font-size:1rem;color:#0f172a;}
.ri-sub{font-size:.78rem;color:#94a3b8;font-weight:700;}
.ri-skor{font-family:'Fredoka One',sans-serif;font-size:1.3rem;font-weight:900;}
.empty-state{text-align:center;padding:2.5rem;color:#94a3b8;font-weight:700;background:#fff;border:1.5px dashed var(--border);border-radius:1rem;}
</style>

<div class="rasi-wrap">
  <div class="rasi-hero">
    <div class="kinners-row">
      <div class="speech">"Yuk, cari tahu jalur terbaikmu setelah lulus! 🌟"</div>
      <svg width="90" height="90" viewBox="0 0 120 120" fill="none">
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
    <h1>Rasionalisasi Masa Depan 🚀</h1>
    <p>Dapatkan rekomendasi jurusan kuliah atau karir terbaik berdasarkan nilai dan minatmu — dianalisis oleh AI!</p>
  </div>

  <div class="mode-grid">
    <div class="mode-card">
      <span class="ico">🎓</span>
      <h2>Rasionalisasi Kuliah</h2>
      <p>Temukan jurusan kuliah & kampus terbaik yang sesuai dengan nilai akademikmu.</p>
      <ul>
        <li>5 rekomendasi jurusan relevan</li>
        <li>3 kampus per jurusan (PTN/PTS)</li>
        <li>Estimasi peluang masuk</li>
        <li>Tips persiapan UTBK/SNBT</li>
        <li>Action plan konkret</li>
      </ul>
      <a href="{{ route('siswa.rasionalisasi.kuliah') }}" class="btn-mode">Mulai Rasionalisasi Kuliah</a>
    </div>
    <div class="mode-card">
      <span class="ico">💼</span>
      <h2>Rasionalisasi Karir</h2>
      <p>Temukan posisi kerja & perusahaan yang cocok dengan skill dan minat karirmu.</p>
      <ul>
        <li>5 rekomendasi posisi karir</li>
        <li>3 perusahaan per posisi</li>
        <li>Estimasi gaji entry level</li>
        <li>Road map karir 1-3 tahun</li>
        <li>Rekomendasi sertifikasi</li>
      </ul>
      <a href="{{ route('siswa.rasionalisasi.kerja') }}" class="btn-mode" style="background:#f59e0b;box-shadow:0 5px 0 #b45309;">Mulai Rasionalisasi Karir</a>
    </div>
  </div>

  @if($riwayat->count())
  <div class="riwayat-sec">
    <div class="riwayat-title">
      <span>📋 Riwayat Terakhir</span>
      <a href="{{ route('siswa.rasionalisasi.riwayat') }}">Lihat Semua →</a>
    </div>
    <div class="riwayat-list">
      @foreach($riwayat as $r)
        <a href="{{ route('siswa.rasionalisasi.hasil', $r->id) }}" class="riwayat-item">
          <div class="ri-left">
            <div class="ri-ico {{ $r->mode }}">{{ $r->mode==='kuliah'?'🎓':'💼' }}</div>
            <div>
              <div class="ri-meta">{{ $r->mode==='kuliah'?'Rasionalisasi Kuliah':'Rasionalisasi Karir' }}</div>
              <div class="ri-sub">{{ $r->created_at->diffForHumans() }} · Jurusan: {{ $r->input_data['jurusan']??'-' }}</div>
            </div>
          </div>
          <div class="ri-skor" style="color:{{ $r->warna_skore }}">{{ $r->skor_kesiapan ?? '-' }}</div>
        </a>
      @endforeach
    </div>
  </div>
  @else
    <div class="empty-state">
      <div style="font-size:2.5rem;margin-bottom:.5rem;">🐱</div>
      Belum ada riwayat rasionalisasi. Mulai sekarang yuk!
    </div>
  @endif
</div>
@endsection
