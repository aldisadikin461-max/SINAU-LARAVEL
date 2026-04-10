@extends('layouts.siswa')

@section('title', 'Alumni Kuliah ' . $tahun . ' — Sinau')

@section('content')
<style>
  /* ── Filter Tahun ── */
  .tahun-tabs {
    display: flex;
    flex-wrap: wrap;
    gap: .5rem;
    margin-bottom: 1.5rem;
  }
  .tahun-tab {
    padding: .4rem 1.1rem;
    border-radius: 999px;
    font-size: .85rem;
    font-weight: 800;
    text-decoration: none;
    border: 2px solid rgba(14,165,233,.2);
    color: #64748b;
    background: #fff;
    transition: all .18s;
  }
  .tahun-tab:hover {
    border-color: #0ea5e9;
    color: #0ea5e9;
  }
  .tahun-tab.active {
    background: linear-gradient(135deg, #0ea5e9, #0284c7);
    color: #fff;
    border-color: transparent;
    box-shadow: 0 3px 10px rgba(14,165,233,.35);
  }

  /* ── Alumni Card Grid ── */
  .alumni-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 1.1rem;
  }
  @media (max-width: 600px) {
    .alumni-grid { grid-template-columns: repeat(2, 1fr); }
  }
  @media (max-width: 380px) {
    .alumni-grid { grid-template-columns: 1fr; }
  }

  .alumni-card {
    background: #fff;
    border: 1.5px solid rgba(14,165,233,.12);
    border-radius: 1.25rem;
    padding: 1.25rem 1rem 1rem;
    text-align: center;
    transition: all .2s;
    box-shadow: 0 2px 12px rgba(14,165,233,.06);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .5rem;
  }
  .alumni-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 28px rgba(14,165,233,.14);
    border-color: rgba(14,165,233,.25);
  }

  .alumni-card-logo {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: contain;
    border: 2px solid rgba(14,165,233,.1);
    padding: 4px;
    background: #f8fafc;
  }
  .alumni-card-logo-fallback {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #0ea5e9, #0284c7);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
  }

  .alumni-card-name {
    font-weight: 800;
    font-size: .9rem;
    color: #0f172a;
    line-height: 1.3;
  }
  .alumni-card-kampus {
    font-size: .8rem;
    font-weight: 700;
    color: #0284c7;
  }
  .alumni-card-jurusan {
    font-size: .75rem;
    color: #64748b;
    font-weight: 600;
  }

  /* Badge jalur */
  .badge-jalur {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    padding: .22rem .75rem;
    border-radius: 999px;
    font-size: .72rem;
    font-weight: 900;
    letter-spacing: .02em;
    margin-top: .1rem;
  }
  .badge-snbp {
    background: #dcfce7;
    color: #15803d;
    border: 1.5px solid #bbf7d0;
  }
  .badge-snbt {
    background: #dbeafe;
    color: #1d4ed8;
    border: 1.5px solid #bfdbfe;
  }
  .badge-mandiri {
    background: #fef9c3;
    color: #a16207;
    border: 1.5px solid #fef08a;
  }

  /* Empty state */
  .alumni-empty {
    text-align: center;
    padding: 3rem 1rem;
    color: #94a3b8;
  }
  .alumni-empty-icon {
    font-size: 3rem;
    margin-bottom: .75rem;
  }
  .alumni-empty-text {
    font-weight: 700;
    font-size: 1rem;
  }
</style>

{{-- Header --}}
<div class="page-header">
  <div>
    <h1>🎓 Alumni Kuliah</h1>
    <p style="color:#64748b;font-size:.9rem;font-weight:600;margin-top:.25rem;">
      Bangga dengan prestasi alumni kita! 🌟
    </p>
  </div>
  <a href="{{ route('siswa.alumni.index') }}" class="fbtn" style="background:#f1f5f9;color:#64748b;box-shadow:none;">
    ← Kembali
  </a>
</div>

{{-- Filter Tahun --}}
@if(count($tahunList) > 0)
<div class="tahun-tabs">
  @foreach($tahunList as $t)
    <a href="{{ route('siswa.alumni.kuliah', ['tahun' => $t]) }}"
       class="tahun-tab {{ $t == $tahun ? 'active' : '' }}">
      {{ $t }}
    </a>
  @endforeach
</div>
@endif

{{-- Summary --}}
<div style="margin-bottom:1.25rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.5rem;">
  <span style="font-weight:800;color:#64748b;font-size:.9rem;">
    📊 {{ $alumni->count() }} alumni angkatan {{ $tahun }}
  </span>
  @php
    $snbp = $alumni->where('jalur', 'SNBP')->count();
    $snbt = $alumni->where('jalur', 'SNBT')->count();
    $mand = $alumni->where('jalur', 'Mandiri')->count();
  @endphp
  <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
    @if($snbp) <span class="badge-jalur badge-snbp">✅ SNBP: {{ $snbp }}</span> @endif
    @if($snbt) <span class="badge-jalur badge-snbt">📝 SNBT: {{ $snbt }}</span> @endif
    @if($mand) <span class="badge-jalur badge-mandiri">🏫 Mandiri: {{ $mand }}</span> @endif
  </div>
</div>

{{-- Card Grid --}}
@if($alumni->count() > 0)
<div class="alumni-grid">
  @foreach($alumni as $a)
  <div class="alumni-card">

    {{-- Logo kampus --}}
    @if($a->domain_kampus)
      <img
        src="{{ $a->logo_url }}"
        alt="{{ $a->kampus }}"
        class="alumni-card-logo"
        onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"
      >
      <div class="alumni-card-logo-fallback" style="display:none;">🏛️</div>
    @else
      <div class="alumni-card-logo-fallback">🏛️</div>
    @endif

    <div class="alumni-card-name">{{ $a->nama }}</div>
    <div class="alumni-card-kampus">{{ $a->kampus }}</div>
    <div class="alumni-card-jurusan">{{ $a->jurusan }}</div>

    {{-- Badge jalur --}}
    @php
      $badgeClass = match($a->jalur) {
        'SNBP'    => 'badge-snbp',
        'SNBT'    => 'badge-snbt',
        'Mandiri' => 'badge-mandiri',
        default   => 'badge-snbp',
      };
      $badgeIcon = match($a->jalur) {
        'SNBP'    => '✅',
        'SNBT'    => '📝',
        'Mandiri' => '🏫',
        default   => '✅',
      };
    @endphp
    <span class="badge-jalur {{ $badgeClass }}">{{ $badgeIcon }} {{ $a->jalur }}</span>

  </div>
  @endforeach
</div>

@else
<div class="alumni-empty">
  <div class="alumni-empty-icon">🔍</div>
  <div class="alumni-empty-text">Belum ada data alumni untuk tahun {{ $tahun }}</div>
  <div style="font-size:.85rem;margin-top:.35rem;">Coba pilih tahun lain di atas</div>
</div>
@endif

@endsection