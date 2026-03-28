@extends('layouts.admin')
@section('title','Statistik')
@section('content')

<style>
.page-title { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.8rem; color:#0d1f35; margin-bottom:1.5rem; letter-spacing:-0.5px; }
.grid2 { display:grid; grid-template-columns:1fr 1fr; gap:1.25rem; }
@media(max-width:700px){ .grid2{ grid-template-columns:1fr; } }
.card { background:#fff; border:2px solid #d0e4f7; border-radius:1.25rem; padding:1.5rem; box-shadow:0 4px 0 #d0e4f7; }
.card-title { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.05rem; color:#0d1f35; margin-bottom:1rem; }
.bar-row { display:flex; align-items:center; gap:.75rem; margin-bottom:.6rem; font-family:'Nunito Sans',sans-serif; font-size:.85rem; font-weight:700; }
.bar-label { width:56px; color:#7b96b2; text-align:right; font-size:.78rem; }
.bar-track { flex:1; background:#e6f2ff; border-radius:999px; height:12px; overflow:hidden; }
.bar-fill { background:linear-gradient(90deg,#1a8cff,#5bc8ff); height:100%; border-radius:999px; transition:width .6s cubic-bezier(.34,1.56,.64,1); }
.bar-num { width:28px; color:#0070e0; font-size:.8rem; font-weight:900; }
.role-row { display:flex; align-items:center; justify-content:space-between; padding:.65rem 0; border-bottom:1.5px solid #e6f2ff; font-family:'Nunito Sans',sans-serif; }
.role-row:last-child { border-bottom:none; }
.role-name { font-weight:800; text-transform:capitalize; color:#0d1f35; }
.role-count { background:#e6f2ff; color:#0070e0; border-radius:999px; padding:.2rem .85rem; font-size:.82rem; font-weight:900; font-family:'Nunito',sans-serif; }
</style>

<div class="page-title">📈 Statistik Platform</div>

<div class="grid2">
  <div class="card">
    <div class="card-title">Soal Dijawab (7 Hari Terakhir)</div>
    @foreach($soalPerHari as $row)
      @php $pct = $soalPerHari->max('total') > 0 ? ($row->total / $soalPerHari->max('total') * 100) : 0; @endphp
      <div class="bar-row">
        <span class="bar-label">{{ \Carbon\Carbon::parse($row->tanggal)->format('d M') }}</span>
        <div class="bar-track"><div class="bar-fill" style="width:{{ $pct }}%"></div></div>
        <span class="bar-num">{{ $row->total }}</span>
      </div>
    @endforeach
  </div>

  <div class="card">
    <div class="card-title">Distribusi Pengguna</div>
    @foreach($distribusiRole as $role => $total)
      <div class="role-row">
        <span class="role-name">{{ $role }}</span>
        <span class="role-count">{{ $total }} orang</span>
      </div>
    @endforeach
  </div>
</div>

@endsection
