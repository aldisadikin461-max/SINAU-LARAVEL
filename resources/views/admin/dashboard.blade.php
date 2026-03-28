@extends('layouts.admin')
@section('title','Dashboard Admin')
@section('content')
<style>
  .page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;}
  .page-sub{color:#94a3b8;font-size:.88rem;font-weight:700;margin-bottom:1.5rem;}
  .stat-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:1rem;margin-bottom:1.75rem;}
  .scard{background:#fff;border:1.5px solid rgba(14,165,233,.1);border-radius:1.25rem;padding:1.25rem;box-shadow:0 4px 18px rgba(14,165,233,.07);transition:all .2s;}
  .scard:hover{transform:translateY(-3px);box-shadow:0 10px 28px rgba(14,165,233,.12);}
  .scard .ico{font-size:1.8rem;margin-bottom:.5rem;}
  .scard .val{font-family:'Fredoka One',sans-serif;font-size:1.9rem;color:#0f172a;}
  .scard .lbl{font-size:.78rem;font-weight:800;color:#94a3b8;margin-top:.1rem;}
  .card{background:#fff;border:1.5px solid rgba(14,165,233,.1);border-radius:1.25rem;padding:1.5rem;box-shadow:0 4px 18px rgba(14,165,233,.07);}
  .card-title{font-family:'Fredoka One',sans-serif;font-size:1.15rem;color:#0f172a;margin-bottom:1rem;}
  table{width:100%;border-collapse:collapse;font-family:'Nunito',sans-serif;}
  thead tr{background:#f0f9ff;border-bottom:2px solid rgba(14,165,233,.1);}
  thead th{padding:.75rem 1rem;text-align:left;font-size:.78rem;font-weight:800;color:#0284c7;text-transform:uppercase;letter-spacing:.04em;}
  tbody tr{border-bottom:1px solid rgba(14,165,233,.06);transition:background .15s;}
  tbody tr:hover{background:#f0f9ff;}
  tbody td{padding:.8rem 1rem;font-size:.88rem;font-weight:700;}
  .streak-pill{background:linear-gradient(135deg,#f97316,#ef4444);color:#fff;border-radius:999px;padding:.2rem .75rem;font-size:.78rem;font-weight:800;}
  .rank-1{color:#f59e0b;}.rank-2{color:#94a3b8;}.rank-3{color:#cd7c2f;}
</style>
<div class="page-title">Dashboard Admin</div>
<div class="page-sub">Selamat datang, {{ auth()->user()->name }}! 🐱 Hai Smeconers!</div>

<div class="stat-grid">
  @foreach([['👥',$totalSiswa,'Total Siswa'],['👨‍🏫',$totalGuru,'Total Guru'],['📚',$totalEbook,'E-Book'],['🎓',$totalBeasiswa,'Beasiswa'],['🔥',$streakHariIni,'Streak Hari Ini'],['✅',$soalDijawab,'Soal Dijawab'],['💬',$totalForum,'Forum Thread']] as [$i,$v,$l])
    <div class="scard">
      <div class="ico">{{ $i }}</div>
      <div class="val">{{ $v }}</div>
      <div class="lbl">{{ $l }}</div>
    </div>
  @endforeach
</div>

<div class="card">
  <div class="card-title">🏆 Top 5 Streak Siswa</div>
  <table>
    <thead><tr><th>#</th><th>Nama</th><th>Jurusan</th><th>Streak</th></tr></thead>
    <tbody>
      @foreach($topStreak as $i=>$s)
        <tr>
          <td class="{{ ['rank-1','rank-2','rank-3'][$i]??'' }}" style="font-size:1.1rem;font-weight:900;">
            {{ ['🥇','🥈','🥉'][$i]??($i+1) }}
          </td>
          <td>{{ $s->user->name }}</td>
          <td style="color:#94a3b8;">{{ $s->user->jurusan??'-' }}</td>
          <td><span class="streak-pill">🔥 {{ $s->streak_count }}</span></td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection