@extends('layouts.siswa')
@section('title','Leaderboard')
@section('content')
<style>
  .page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:1.25rem;}
  .tab-row{display:flex;gap:.5rem;margin-bottom:1.5rem;flex-wrap:wrap;}
  .tab{padding:.45rem 1.2rem;border-radius:999px;font-size:.88rem;font-weight:800;text-decoration:none;transition:all .18s;font-family:'Nunito',sans-serif;border:1.5px solid rgba(14,165,233,.2);color:#64748b;background:#fff;}
  .tab:hover{background:#f0f9ff;color:#0ea5e9;}
  .tab.on{background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;border-color:transparent;box-shadow:0 4px 14px rgba(14,165,233,.3);}
  .card{background:#fff;border:1px solid rgba(14,165,233,.1);border-radius:1.25rem;box-shadow:0 4px 20px rgba(14,165,233,.07);overflow:hidden;}
  table{width:100%;border-collapse:collapse;font-family:'Nunito',sans-serif;}
  thead tr{background:#f0f9ff;border-bottom:2px solid rgba(14,165,233,.1);}
  thead th{padding:.85rem 1.25rem;text-align:left;font-size:.82rem;font-weight:800;color:#0284c7;text-transform:uppercase;letter-spacing:.04em;}
  tbody tr{border-bottom:1px solid rgba(14,165,233,.07);transition:background .15s;}
  tbody tr:hover{background:#f0f9ff;}
  tbody td{padding:.85rem 1.25rem;font-size:.9rem;font-weight:700;}
  .rank-1{color:#f59e0b;font-size:1.3rem;}
  .rank-2{color:#94a3b8;font-size:1.15rem;}
  .rank-3{color:#cd7c2f;font-size:1.15rem;}
  .streak-pill{background:linear-gradient(135deg,#f97316,#ef4444);color:#fff;border-radius:999px;padding:.25rem .8rem;font-size:.82rem;font-weight:800;display:inline-flex;align-items:center;gap:.3rem;}
  .me-row{background:#e0f2fe!important;}
</style>
<div class="page-title">🏆 Leaderboard Streak</div>
<div class="tab-row">
  @foreach(['sekolah'=>'🏫 Sekolah','jurusan'=>'📚 Jurusan','kelas'=>'🏠 Kelas'] as $v=>$l)
    <a href="{{ route('siswa.leaderboard',['tab'=>$v]) }}" class="tab {{ $tab===$v?'on':'' }}">{{ $l }}</a>
  @endforeach
</div>
<div class="card">
  <table>
    <thead><tr><th>#</th><th>Nama</th><th>Jurusan</th><th>Kelas</th><th>Streak</th><th>Rekor</th></tr></thead>
    <tbody>
      @forelse($leaderboard as $i=>$s)
        <tr class="{{ $s->user_id===auth()->id()?'me-row':'' }}">
          <td>@if($i===0)<span class="rank-1">🥇</span>@elseif($i===1)<span class="rank-2">🥈</span>@elseif($i===2)<span class="rank-3">🥉</span>@else{{ $i+1 }}@endif</td>
          <td>{{ $s->user->name }}@if($s->user_id===auth()->id()) <span style="font-size:.75rem;color:#0ea5e9;">(Kamu)</span>@endif</td>
          <td style="color:#94a3b8;">{{ $s->user->jurusan??'-' }}</td>
          <td style="color:#94a3b8;">{{ $s->user->kelas??'-' }}</td>
          <td><span class="streak-pill">🔥 {{ $s->streak_count }}</span></td>
          <td style="color:#94a3b8;">{{ $s->longest_streak }} hari</td>
        </tr>
      @empty
        <tr><td colspan="6" style="text-align:center;padding:2.5rem;color:#94a3b8;font-weight:700;">Belum ada data streak 🐱</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection