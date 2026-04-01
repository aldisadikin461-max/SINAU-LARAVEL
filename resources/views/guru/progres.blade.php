@extends('layouts.guru')
@section('title','Progres Siswa')
@section('content')
<style>
.page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:1.25rem;}
.card{background:#fff;border:1.5px solid rgba(14,165,233,.1);border-radius:1.25rem;overflow:hidden;box-shadow:0 4px 18px rgba(14,165,233,.07);}
table{width:100%;border-collapse:collapse;font-family:'Nunito',sans-serif;}
thead tr{background:#f0f9ff;border-bottom:2px solid rgba(14,165,233,.1);}
thead th{padding:.8rem 1rem;text-align:left;font-size:.78rem;font-weight:800;color:#0284c7;text-transform:uppercase;letter-spacing:.04em;}
tbody tr{border-bottom:1px solid rgba(14,165,233,.06);transition:background .15s;}
tbody tr:hover{background:#f0f9ff;}
tbody td{padding:.85rem 1rem;font-size:.86rem;font-weight:700;}
.sp{background:linear-gradient(135deg,#f97316,#ef4444);color:#fff;border-radius:999px;padding:.2rem .75rem;font-size:.78rem;font-weight:800;}
.bw{display:flex;align-items:center;gap:.5rem;}
.bt{width:80px;height:8px;background:#e0f2fe;border-radius:999px;overflow:hidden;}
.bf{height:100%;border-radius:999px;}
.bg{background:#22c55e;}.bm{background:#f59e0b;}.bb{background:#ef4444;}
.pct{font-size:.78rem;color:#64748b;}
</style>
<div class="page-title">📈 Progres Belajar Siswa</div>
<div class="card">
  <table>
    <thead><tr><th>Nama</th><th>Jurusan</th><th>Kelas</th><th>Streak</th><th>Total Soal</th><th>Benar</th><th>Akurasi</th></tr></thead>
    <tbody>
      @forelse($siswa as $s)
        @php
          $total=$s->userAnswers->count();
          $benar=$s->userAnswers->where('is_correct',true)->count();
          $pct=$total>0?round($benar/$total*100):0;
          $cls=$pct>=70?'bg':($pct>=40?'bm':'bb');
        @endphp
        <tr>
          <td style="font-weight:800;">{{ $s->name }}</td>
          <td style="color:#94a3b8;">{{ $s->jurusan??'-' }}</td>
          <td style="color:#94a3b8;">{{ $s->kelas??'-' }}</td>
          <td><span class="sp">🔥 {{ $s->streak?->streak_count??0 }}</span></td>
          <td style="text-align:center;">{{ $total }}</td>
          <td style="text-align:center;color:#16a34a;">{{ $benar }}</td>
          <td><div class="bw"><div class="bt"><div class="bf {{ $cls }}" style="width:{{ $pct }}%"></div></div><span class="pct">{{ $pct }}%</span></div></td>
        </tr>
      @empty
        <tr><td colspan="7" style="text-align:center;padding:2rem;color:#94a3b8;font-weight:700;">Belum ada data siswa.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div style="padding:1rem;">{{ $siswa->links() }}</div>
</div>
@endsection
