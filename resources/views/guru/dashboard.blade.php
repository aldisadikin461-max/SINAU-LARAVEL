@extends('layouts.guru')
@section('title','Dashboard Guru')
@section('content')

{{-- ── Page Header ── --}}
<div class="page-header">
  <div>
    <h1>Dashboard Guru 👨‍🏫</h1>
    <p>Selamat datang, <strong style="color:#0284c7;">{{ Auth::user()->name }}</strong>! Semangat mengajar hari ini! 🐱</p>
  </div>
  <a href="{{ route('guru.questions.create') }}" class="fbtn">
    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
    Buat Soal Baru
  </a>
</div>

{{-- ── Stat Cards ── --}}
<div class="stat-grid">
  <div class="stat-card">
    <div class="stat-icon">📚</div>
    <div class="stat-value">{{ number_format($totalEbook) }}</div>
    <div class="stat-label">Total E-Book</div>
    <div class="stat-sub">materi tersedia</div>
  </div>
  <div class="stat-card">
    <div class="stat-icon">❓</div>
    <div class="stat-value">{{ number_format($totalSoal) }}</div>
    <div class="stat-label">Total Soal</div>
    <div class="stat-sub">bank soal guru</div>
  </div>
  <div class="stat-card">
    <div class="stat-icon">📝</div>
    <div class="stat-value">{{ number_format($totalTugas) }}</div>
    <div class="stat-label">Total Tugas</div>
    <div class="stat-sub">telah di-assign</div>
  </div>
  <div class="stat-card">
    <div class="stat-icon">🔥</div>
    <div class="stat-value">{{ number_format($streakHariIni) }}</div>
    <div class="stat-label">Streak Aktif</div>
    <div class="stat-sub">siswa aktif hari ini</div>
  </div>
</div>

{{-- ── Soal Dijawab Hari Ini ── --}}
<div class="stat-grid" style="margin-top:-0.5rem;">
  <div class="stat-card">
    <div class="stat-icon">✅</div>
    <div class="stat-value">{{ number_format($soalDijawab) }}</div>
    <div class="stat-label">Soal Dijawab</div>
    <div class="stat-sub">pertanyaan hari ini</div>
  </div>
</div>

{{-- ── Action Cards ── --}}
<div class="three-grid">
  <a href="{{ route('guru.ebooks.create') }}" class="action-card">
    <span class="action-icon">📤</span>
    <div>
      <div class="action-title">Upload E-Book</div>
      <div class="action-desc">Tambah materi PDF baru</div>
    </div>
  </a>
  <a href="{{ route('guru.questions.create') }}" class="action-card">
    <span class="action-icon">➕</span>
    <div>
      <div class="action-title">Buat Soal Baru</div>
      <div class="action-desc">Soal pilihan ganda</div>
    </div>
  </a>
  <a href="{{ route('guru.tasks.create') }}" class="action-card">
    <span class="action-icon">📋</span>
    <div>
      <div class="action-title">Assign Tugas</div>
      <div class="action-desc">Ke kelas/jurusan</div>
    </div>
  </a>
</div>

{{-- ── Recent Activity ── --}}
<div class="card">
  <div class="section-title">📋 Aktivitas Terbaru</div>
  <div style="overflow-x:auto;">
    <table class="sinau-table">
      <thead>
        <tr>
          <th>Aktivitas</th>
          <th>Detail</th>
          <th>Waktu</th>
        </tr>
      </thead>
     {{-- ✅ Ganti jadi ini --}}
<tbody>
  @forelse($aktivitas as $a)
    <tr>
      <td>{{ $a['icon'] }} {{ $a['label'] }}</td>
      <td style="color:#64748b;max-width:300px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
        {{ Str::limit($a['detail'], 60) }}
      </td>
      <td style="color:#94a3b8;white-space:nowrap;">
        {{ $a['time']->diffForHumans() }}
      </td>
    </tr>
  @empty
    <tr>
      <td colspan="3" style="text-align:center;padding:2rem;color:#94a3b8;font-weight:700;">
        🐱 Belum ada aktivitas terbaru.
      </td>
    </tr>
  @endforelse
</tbody>
    </table>
  </div>
</div>

@endsection