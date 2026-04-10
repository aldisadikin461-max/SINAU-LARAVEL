@extends('layouts.admin')
@section('title','Dashboard Admin')
@section('content')

{{-- ── Page Header ── --}}
<div class="page-header">
  <div>
    <h1>Dashboard Admin</h1>
    <p>Selamat datang, <strong style="color:#0284c7;">{{ Auth::user()->name }}</strong> 🛡️</p>
  </div>
  <a href="{{ route('admin.users.create') }}" class="fbtn">
    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
    Tambah User
  </a>
</div>

{{-- ── Stat Cards ── --}}
<div class="stat-grid">
  <div class="stat-card">
    <div class="stat-icon">👨‍🎓</div>
    <div class="stat-value">{{ number_format($stats['total_siswa']) }}</div>
    <div class="stat-label">Total Siswa</div>
    <div class="stat-sub">{{ $stats['total_guru'] }} guru terdaftar</div>
  </div>
  <div class="stat-card">
    <div class="stat-icon">🔥</div>
    <div class="stat-value">{{ number_format($stats['siswa_aktif']) }}</div>
    <div class="stat-label">Siswa Aktif</div>
    <div class="stat-sub">aktif hari ini</div>
  </div>
  <div class="stat-card">
    <div class="stat-icon">✅</div>
    <div class="stat-value">{{ number_format($stats['soal_hari_ini']) }}</div>
    <div class="stat-label">Soal Dijawab</div>
    <div class="stat-sub">pertanyaan hari ini</div>
  </div>
  <div class="stat-card">
    <div class="stat-icon">🏅</div>
    <div class="stat-value">{{ number_format($stats['badge_hari_ini']) }}</div>
    <div class="stat-label">Badge Diraih</div>
    <div class="stat-sub">{{ $stats['beasiswa_buka'] }} beasiswa buka</div>
  </div>
</div>

{{-- ── Charts ── --}}
<div class="three-grid">
  <div class="card chart-card">
    <h3>📈 Siswa Aktif (7 Hari)</h3>
    <div style="height:180px;"><canvas id="chartAktif"></canvas></div>
  </div>
  <div class="card chart-card">
    <h3>📝 Soal Dijawab (7 Hari)</h3>
    <div style="height:180px;"><canvas id="chartSoal"></canvas></div>
  </div>
  <div class="card chart-card">
    <h3>🎯 Distribusi Level Siswa</h3>
    <div style="height:180px;"><canvas id="chartLevel"></canvas></div>
  </div>
</div>

{{-- ── Top Streak + Streak Warning ── --}}
<div class="two-grid">

  {{-- Top Streak --}}
  <div class="card">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
      <div class="section-title" style="margin-bottom:0;">🏆 Top Streak Smeconers</div>
      <a href="{{ route('admin.users.index') }}" style="font-size:.82rem;font-weight:700;color:#0284c7;text-decoration:none;">Lihat semua →</a>
    </div>
    @forelse($topStreak as $i => $s)
    <div class="list-item">
      <span style="font-family:'Fredoka One',sans-serif;font-size:.95rem;width:1.5rem;text-align:center;">
        {{ $i==0?'🥇':($i==1?'🥈':($i==2?'🥉':$i+1)) }}
      </span>
      <div class="avatar avatar-blue">{{ strtoupper(substr($s->name,0,1)) }}</div>
      <div style="flex:1;min-width:0;">
        <p style="font-weight:800;color:#0f172a;font-size:.88rem;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $s->name }}</p>
        <p style="font-size:.76rem;color:#94a3b8;margin:0;">{{ $s->kelas ?? '-' }}</p>
      </div>
      <span class="pill pill-orange">🔥 {{ $s->streak?->streak_count ?? 0 }}</span>
    </div>
    @empty
    <div style="text-align:center;padding:2rem;color:#94a3b8;">
      <div style="font-size:2rem;">📊</div>
      <p style="font-weight:700;margin:.5rem 0 0;">Belum ada data streak.</p>
    </div>
    @endforelse
  </div>

  {{-- Streak Warning --}}
  <div class="card">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
      <div class="section-title" style="margin-bottom:0;">⚠️ Streak Mau Putus</div>
      <a href="{{ route('admin.whatsapp.index', ['filter'=>'streak_putus']) }}" class="fbtn fbtn-sm">💬 WA Blast</a>
    </div>
    @forelse($streakWarning as $s)
    <div class="list-item list-item-warn">
      <div class="avatar avatar-red">{{ strtoupper(substr($s->name,0,1)) }}</div>
      <div style="flex:1;min-width:0;">
        <p style="font-weight:800;color:#0f172a;font-size:.88rem;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $s->name }}</p>
        <p style="font-size:.76rem;color:#94a3b8;margin:0;">{{ $s->kelas ?? '-' }} · {{ optional($s->streak?->last_active_date)->diffForHumans() ?? 'belum aktif' }}</p>
      </div>
      <span class="pill" style="background:#fee2e2;color:#dc2626;border:1.5px solid #fecaca;">🔥 {{ $s->streak?->streak_count ?? 0 }}</span>
      @if($s->phone)
      <a href="{{ $s->wa_link }}" target="_blank" class="fbtn fbtn-sm fbtn-green">WA</a>
      @endif
    </div>
    @empty
    <div style="text-align:center;padding:2rem;color:#94a3b8;">
      <div style="font-size:2.5rem;">🎉</div>
      <p style="font-weight:700;margin:.5rem 0 0;">Semua Smeconers aktif hari ini!</p>
    </div>
    @endforelse
  </div>

</div>

{{-- ── Siswa Terbaru ── --}}
<div class="card">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
    <div class="section-title" style="margin-bottom:0;">👤 Siswa Terbaru Daftar</div>
    <a href="{{ route('admin.users.index') }}" style="font-size:.82rem;font-weight:700;color:#0284c7;text-decoration:none;">Kelola semua →</a>
  </div>
  <div style="overflow-x:auto;">
    <table class="sinau-table">
      <thead><tr>
        <th>Nama</th><th>Email</th><th>Jurusan</th><th>Kelas</th><th>Level</th><th>Aksi</th>
      </tr></thead>
      <tbody>
        @forelse($recentSiswa as $s)
        <tr>
          <td>
            <div style="display:flex;align-items:center;gap:.6rem;">
              <div class="avatar avatar-blue" style="width:2rem;height:2rem;font-size:.8rem;">{{ strtoupper(substr($s->name,0,1)) }}</div>
              <span style="font-weight:800;color:#0f172a;">{{ $s->name }}</span>
            </div>
          </td>
          <td style="color:#94a3b8;font-size:.83rem;">{{ $s->email }}</td>
          <td><span class="pill pill-blue" style="font-size:.76rem;padding:.2rem .7rem;">{{ $s->jurusan ?? '-' }}</span></td>
          <td style="color:#64748b;font-size:.83rem;">{{ $s->kelas ?? '-' }}</td>
          <td>
            @php
              $lvlClass = match($s->level ?? '') {
                'platinum' => 'pill-purple',
                'gold'     => 'pill-orange',
                'silver'   => 'pill-blue',
                default    => '',
              };
              $lvlStyle = $s->level == null || $s->level == 'bronze'
                ? 'background:#fff7ed;border:1.5px solid #fed7aa;color:#ea580c;'
                : '';
            @endphp
            <span class="pill {{ $lvlClass }}" style="font-size:.76rem;padding:.2rem .7rem;{{ $lvlStyle }}">
              {{ ucfirst($s->level ?? 'bronze') }}
            </span>
          </td>
          <td>
            <div style="display:flex;align-items:center;gap:.4rem;">
              <a href="{{ route('admin.users.edit', $s) }}" class="btn-edit">Edit</a>
              @if($s->phone)
              <a href="{{ $s->wa_link }}" target="_blank" class="fbtn fbtn-sm fbtn-green">💬 WA</a>
              @endif
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;padding:2rem;color:#94a3b8;font-weight:700;">Belum ada siswa.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const chartOpts = () => ({
  responsive: true, maintainAspectRatio: false,
  plugins: { legend: { display: false } },
  scales: {
    y: { beginAtZero: true, ticks: { color: '#94a3b8', stepSize: 1 }, grid: { color: 'rgba(14,165,233,0.07)' } },
    x: { ticks: { color: '#94a3b8' }, grid: { display: false } }
  }
});

const aktifData = {!! json_encode($chartAktif) !!};
new Chart(document.getElementById('chartAktif'), {
  type: 'line',
  data: {
    labels: aktifData.map(d => d.label),
    datasets: [{ data: aktifData.map(d => d.count), borderColor: '#0ea5e9',
      backgroundColor: 'rgba(14,165,233,0.1)', fill: true, tension: 0.4,
      pointBackgroundColor: '#0ea5e9', pointRadius: 4 }]
  },
  options: chartOpts()
});

const soalData = {!! json_encode($chartSoal) !!};
new Chart(document.getElementById('chartSoal'), {
  type: 'bar',
  data: {
    labels: soalData.map(d => d.label),
    datasets: [{ data: soalData.map(d => d.count),
      backgroundColor: 'rgba(14,165,233,0.2)', borderColor: '#0ea5e9',
      borderWidth: 1.5, borderRadius: 6 }]
  },
  options: chartOpts()
});

const levelData = {!! json_encode($chartLevel) !!};
new Chart(document.getElementById('chartLevel'), {
  type: 'doughnut',
  data: {
    labels: ['Bronze', 'Silver', 'Gold', 'Platinum'],
    datasets: [{
      data: [levelData.bronze??0, levelData.silver??0, levelData.gold??0, levelData.platinum??0],
      backgroundColor: ['#f97316','#94a3b8','#f59e0b','#7c3aed'],
      borderWidth: 0, hoverOffset: 6
    }]
  },
  options: {
    responsive: true, maintainAspectRatio: false, cutout: '65%',
    plugins: { legend: { position: 'bottom', labels: { color: '#64748b', padding: 10, font: { size: 11, weight: '700' } } } }
  }
});
</script>
@endpush
@endsection
