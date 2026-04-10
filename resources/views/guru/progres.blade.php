@extends('layouts.guru')
@section('title','Progres Siswa')
@section('content')
<style>
:root{--blue:#1a8cff;--border:#d0e4f7;}
.page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:1.25rem;}
.filter-row{display:flex;gap:.75rem;flex-wrap:wrap;margin-bottom:1.25rem;}
.finput{background:#fff;border:2px solid var(--border);border-radius:999px;padding:.45rem 1.1rem;font-size:.85rem;font-weight:700;color:#1e293b;outline:none;font-family:'Nunito',sans-serif;}
.fbtn{padding:.45rem 1.3rem;border-radius:999px;background:var(--blue);color:#fff;font-size:.85rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;}
.card{background:#fff;border:1.5px solid var(--border);border-radius:1.25rem;overflow:hidden;box-shadow:0 4px 18px rgba(14,165,233,.07);}
table{width:100%;border-collapse:collapse;font-family:'Nunito',sans-serif;}
thead tr{background:#f0f9ff;border-bottom:2px solid var(--border);}
thead th{padding:.8rem 1rem;text-align:left;font-size:.78rem;font-weight:800;color:#0284c7;text-transform:uppercase;letter-spacing:.04em;}
tbody tr{border-bottom:1px solid rgba(14,165,233,.06);transition:background .15s;}
tbody tr:hover{background:#f0f9ff;}
tbody td{padding:.8rem 1rem;font-size:.86rem;font-weight:700;}
.streak-aktif{background:#dcfce7;color:#16a34a;border-radius:999px;padding:.2rem .7rem;font-size:.75rem;font-weight:800;}
.streak-mati{background:#fee2e2;color:#dc2626;border-radius:999px;padding:.2rem .7rem;font-size:.75rem;font-weight:800;}
.streak-num{font-family:'Fredoka One',sans-serif;font-size:1.1rem;color:#f97316;}
.rekor-num{font-family:'Fredoka One',sans-serif;font-size:1rem;color:#0284c7;}
.recovery-chip{background:#f3e8ff;color:#7c3aed;border-radius:999px;padding:.2rem .65rem;font-size:.75rem;font-weight:800;}
.bar-wrap{display:flex;align-items:center;gap:.5rem;}
.bar-track{width:70px;height:7px;background:#e0f2fe;border-radius:999px;overflow:hidden;}
.bar-fill{height:100%;border-radius:999px;}
.bg{background:#22c55e;}.bm{background:#f59e0b;}.bb{background:#ef4444;}
.pct{font-size:.78rem;color:#64748b;}
.no-data{text-align:center;padding:2.5rem;color:#94a3b8;font-weight:700;}
</style>

<div class="page-title">📈 Progres Belajar Siswa</div>

<form method="GET" class="filter-row">
  <input name="search" value="{{ request('search') }}" placeholder="Cari nama siswa..." class="finput" style="width:220px;">
  <button type="submit" class="fbtn">🔍 Cari</button>
  @if(request('search'))
    <a href="{{ route('guru.progres') }}" class="fbtn" style="background:#e0f2fe;color:#0284c7;">✕ Reset</a>
  @endif
</form>

<div class="card">
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Siswa</th>
        <th>Streak Aktif</th>
        <th>🔥 Saat Ini</th>
        <th>🏆 Rekor</th>
        <th>♻️ Recovery</th>
        <th>Total Soal</th>
        <th>Rata-rata</th>
      </tr>
    </thead>
    <tbody>
      @forelse($siswaList->filter(function($s) {
        return !request('search') || str_contains(strtolower($s->name), strtolower(request('search')));
      }) as $i => $siswa)
        <tr>
          <td style="color:#94a3b8;">{{ $i + 1 }}</td>
          <td>
            <div style="font-weight:800;">{{ $siswa->name }}</div>
            <div style="font-size:.75rem;color:#94a3b8;margin-top:.1rem;">
              {{ $siswa->kelas ?? '-' }} · {{ $siswa->jurusan ?? '-' }}
            </div>
          </td>
          <td>
            @if($siswa->streakData['is_active'])
              <span class="streak-aktif">✅ Aktif</span>
            @else
              <span class="streak-mati">💔 Mati</span>
            @endif
          </td>
          <td class="streak-num">🔥 {{ $siswa->streakData['current'] }}</td>
          <td class="rekor-num">🏆 {{ $siswa->streakData['longest'] }}</td>
          <td>
            <span class="recovery-chip">♻️ {{ $siswa->streakData['recovery_left'] }}x</span>
          </td>
          <td style="text-align:center;">{{ $siswa->totalSoal }}</td>
          <td>
            @php $pct=$siswa->rataRata; $cls=$pct>=70?'bg':($pct>=40?'bm':'bb'); @endphp
            <div class="bar-wrap">
              <div class="bar-track">
                <div class="bar-fill {{ $cls }}" style="width:{{ $pct }}%"></div>
              </div>
              <span class="pct">{{ $pct }}%</span>
            </div>
          </td>
        </tr>
      @empty
        <tr><td colspan="8" class="no-data">🐱 Belum ada data siswa.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
