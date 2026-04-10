@extends('layouts.siswa')

@section('title', 'Alumni — Sinau')

@section('content')
<style>
  /* ── Alumni Landing ── */
  .alumni-hero {
    text-align: center;
    padding: 2rem 1rem 1.5rem;
  }
  .alumni-hero h1 {
    font-family: 'Fredoka One', sans-serif;
    font-size: 2.2rem;
    color: #0f172a;
    margin-bottom: .4rem;
  }
  .alumni-hero p {
    color: #64748b;
    font-size: 1rem;
    font-weight: 600;
  }

  .alumni-choice-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    max-width: 680px;
    margin: 2rem auto 0;
  }
  @media (max-width: 600px) {
    .alumni-choice-grid { grid-template-columns: 1fr; }
  }

  .alumni-choice-card {
    background: #fff;
    border: 2px solid rgba(14,165,233,.15);
    border-radius: 1.5rem;
    padding: 2rem 1.5rem;
    text-align: center;
    text-decoration: none;
    color: inherit;
    transition: all .2s;
    box-shadow: 0 4px 20px rgba(14,165,233,.07);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .75rem;
  }
  .alumni-choice-card:hover {
    transform: translateY(-5px);
    border-color: #0ea5e9;
    box-shadow: 0 12px 32px rgba(14,165,233,.18);
  }
  .alumni-choice-icon {
    font-size: 3rem;
    line-height: 1;
  }
  .alumni-choice-title {
    font-family: 'Fredoka One', sans-serif;
    font-size: 1.4rem;
    color: #0f172a;
  }
  .alumni-choice-desc {
    font-size: .85rem;
    color: #64748b;
    font-weight: 600;
    line-height: 1.5;
  }
  .alumni-choice-btn {
    margin-top: .5rem;
    padding: .45rem 1.4rem;
    background: linear-gradient(135deg, #0ea5e9, #0284c7);
    color: #fff;
    border-radius: 999px;
    font-size: .85rem;
    font-weight: 800;
    box-shadow: 0 3px 12px rgba(14,165,233,.3);
  }

  /* Stats mini */
  .alumni-stats {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin: 2.5rem auto 0;
    max-width: 400px;
    padding: 1.25rem 1.5rem;
    background: rgba(14,165,233,.05);
    border: 1.5px solid rgba(14,165,233,.1);
    border-radius: 1.25rem;
  }
  .alumni-stat-item {
    text-align: center;
  }
  .alumni-stat-num {
    font-family: 'Fredoka One', sans-serif;
    font-size: 1.8rem;
    color: #0ea5e9;
    line-height: 1;
  }
  .alumni-stat-lbl {
    font-size: .75rem;
    font-weight: 800;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: .05em;
    margin-top: .2rem;
  }
</style>

<div class="alumni-hero">
  <div style="font-size:2.5rem;margin-bottom:.5rem;">👥</div>
  <h1>Alumni Sinau</h1>
  <p>Temukan kisah sukses alumni kami — kuliah impian & peluang karir menarik</p>
</div>

@php
  $totalAlumni    = \App\Models\Alumni::count();
  $totalKemitraan = \App\Models\Kemitraan::count();
  $totalTahun     = count($tahunList);
@endphp

<div class="alumni-stats">
  <div class="alumni-stat-item">
    <div class="alumni-stat-num">{{ $totalAlumni }}</div>
    <div class="alumni-stat-lbl">Alumni Kuliah</div>
  </div>
  <div class="alumni-stat-item">
    <div class="alumni-stat-num">{{ $totalTahun }}</div>
    <div class="alumni-stat-lbl">Angkatan</div>
  </div>
  <div class="alumni-stat-item">
    <div class="alumni-stat-num">{{ $totalKemitraan }}</div>
    <div class="alumni-stat-lbl">Mitra Kerja</div>
  </div>
</div>

<div class="alumni-choice-grid">

  {{-- Kuliah --}}
  <a href="{{ route('siswa.alumni.kuliah', ['tahun' => $tahunList[0] ?? date('Y')]) }}"
     class="alumni-choice-card">
    <div class="alumni-choice-icon">🎓</div>
    <div class="alumni-choice-title">Alumni Kuliah</div>
    <div class="alumni-choice-desc">
      Lihat alumni yang berhasil masuk universitas impian via SNBP, SNBT, maupun Mandiri
    </div>
    <div class="alumni-choice-btn">Lihat Sekarang →</div>
  </a>

  {{-- Kemitraan --}}
  <a href="{{ route('siswa.alumni.kemitraan') }}" class="alumni-choice-card">
    <div class="alumni-choice-icon">🤝</div>
    <div class="alumni-choice-title">Kemitraan</div>
    <div class="alumni-choice-desc">
      Temukan perusahaan & instansi mitra sekolah — buka peluang magang & karir masa depanmu
    </div>
    <div class="alumni-choice-btn">Lihat Sekarang →</div>
  </a>

</div>
@endsection