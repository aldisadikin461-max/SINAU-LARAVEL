@extends('layouts.siswa')

@section('title', 'Kemitraan — Sinau')

@section('content')
<style>
  .mitra-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.25rem;
  }
  @media (max-width: 600px) {
    .mitra-grid { grid-template-columns: 1fr; }
  }

  .mitra-card {
    background: #fff;
    border: 1.5px solid rgba(14,165,233,.12);
    border-radius: 1.25rem;
    padding: 1.5rem;
    transition: all .2s;
    box-shadow: 0 2px 12px rgba(14,165,233,.06);
  }
  .mitra-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 28px rgba(14,165,233,.14);
    border-color: rgba(14,165,233,.25);
  }

  .mitra-card-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
  }
  .mitra-logo {
    width: 56px;
    height: 56px;
    border-radius: .875rem;
    object-fit: contain;
    border: 1.5px solid rgba(14,165,233,.1);
    padding: 4px;
    background: #f8fafc;
    flex-shrink: 0;
  }
  .mitra-logo-fallback {
    width: 56px;
    height: 56px;
    border-radius: .875rem;
    background: linear-gradient(135deg, #0ea5e9, #0284c7);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
  }
  .mitra-card-info {}
  .mitra-card-name {
    font-weight: 800;
    font-size: 1rem;
    color: #0f172a;
    line-height: 1.3;
  }
  .mitra-card-bidang {
    font-size: .8rem;
    font-weight: 700;
    color: #64748b;
    margin-top: .15rem;
  }

  .mitra-lowongan {
    background: rgba(14,165,233,.05);
    border: 1.5px solid rgba(14,165,233,.15);
    border-radius: 1rem;
    padding: .875rem 1rem;
    margin-top: .75rem;
  }
  .mitra-lowongan-title {
    font-size: .78rem;
    font-weight: 900;
    color: #0284c7;
    text-transform: uppercase;
    letter-spacing: .05em;
    margin-bottom: .4rem;
  }
  .mitra-lowongan-text {
    font-size: .82rem;
    color: #475569;
    font-weight: 600;
    line-height: 1.5;
  }

  .mitra-card-actions {
    display: flex;
    gap: .6rem;
    margin-top: 1rem;
    flex-wrap: wrap;
  }
  .mitra-btn-web {
    padding: .38rem 1rem;
    border-radius: 999px;
    font-size: .8rem;
    font-weight: 800;
    border: 2px solid rgba(14,165,233,.2);
    color: #0284c7;
    background: #f0f9ff;
    text-decoration: none;
    transition: all .18s;
  }
  .mitra-btn-web:hover {
    background: #0ea5e9;
    color: #fff;
    border-color: transparent;
  }
  .mitra-btn-apply {
    padding: .38rem 1rem;
    border-radius: 999px;
    font-size: .8rem;
    font-weight: 800;
    background: linear-gradient(135deg, #f97316, #ef4444);
    color: #fff;
    text-decoration: none;
    box-shadow: 0 3px 10px rgba(249,115,22,.3);
    transition: all .18s;
  }
  .mitra-btn-apply:hover {
    transform: translateY(-1px);
    box-shadow: 0 5px 14px rgba(249,115,22,.4);
  }

  /* Empty state */
  .mitra-empty {
    text-align: center;
    padding: 3rem 1rem;
    color: #94a3b8;
  }
</style>

{{-- Header --}}
<div class="page-header">
  <div>
    <h1>🤝 Kemitraan</h1>
    <p style="color:#64748b;font-size:.9rem;font-weight:600;margin-top:.25rem;">
      Perusahaan & instansi mitra sekolah kita
    </p>
  </div>
  <a href="{{ route('siswa.alumni.index') }}" class="fbtn" style="background:#f1f5f9;color:#64748b;box-shadow:none;">
    ← Kembali
  </a>
</div>

@if($mitra->count() > 0)

<div style="margin-bottom:1.25rem;">
  <span style="font-weight:800;color:#64748b;font-size:.9rem;">
    🏢 {{ $mitra->count() }} mitra aktif
  </span>
</div>

<div class="mitra-grid">
  @foreach($mitra as $m)
  <div class="mitra-card">
    <div class="mitra-card-header">
      {{-- Logo --}}
      @if($m->logo)
        <img
          src="{{ $m->logo_url }}"
          alt="{{ $m->nama }}"
          class="mitra-logo"
          onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"
        >
        <div class="mitra-logo-fallback" style="display:none;">🏢</div>
      @else
        <div class="mitra-logo-fallback">🏢</div>
      @endif

      <div class="mitra-card-info">
        <div class="mitra-card-name">{{ $m->nama }}</div>
        <div class="mitra-card-bidang">📌 {{ $m->bidang }}</div>
      </div>
    </div>

    {{-- Lowongan --}}
    @if($m->hasLowongan())
    <div class="mitra-lowongan">
      <div class="mitra-lowongan-title">💼 Lowongan Tersedia</div>
      <div class="mitra-lowongan-text">{{ Str::limit($m->lowongan, 120) }}</div>
    </div>
    @endif

    {{-- Actions --}}
    <div class="mitra-card-actions">
      @if($m->link_website)
        <a href="{{ $m->link_website }}" target="_blank" rel="noopener" class="mitra-btn-web">
          🌐 Website
        </a>
      @endif
      @if($m->hasLowongan())
        <a href="{{ $m->link_lowongan }}" target="_blank" rel="noopener" class="mitra-btn-apply">
          🚀 Apply Sekarang
        </a>
      @endif
    </div>
  </div>
  @endforeach
</div>

@else
<div class="mitra-empty">
  <div style="font-size:3rem;margin-bottom:.75rem;">🤝</div>
  <div style="font-weight:700;font-size:1rem;">Belum ada data kemitraan</div>
  <div style="font-size:.85rem;margin-top:.35rem;">Pantau terus ya, akan segera diupdate!</div>
</div>
@endif

@endsection