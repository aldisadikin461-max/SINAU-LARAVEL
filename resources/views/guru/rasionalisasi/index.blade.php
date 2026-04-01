@extends('layouts.guru')
@section('title','Rasionalisasi Siswa')
@section('content')
<style>
:root{--blue:#1a8cff;--blue-press:#005bb8;--border:#d0e4f7;}
.page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:1.5rem;}
.stat-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:1rem;margin-bottom:1.75rem;}
.scard{background:#fff;border:2px solid var(--border);border-radius:1.25rem;padding:1.25rem;text-align:center;box-shadow:0 3px 0 var(--border);}
.scard .ico{font-size:1.8rem;margin-bottom:.4rem;}
.scard .val{font-family:'Fredoka One',sans-serif;font-size:1.9rem;color:#0f172a;}
.scard .lbl{font-size:.78rem;font-weight:800;color:#94a3b8;}
.filter-row{display:flex;gap:.75rem;flex-wrap:wrap;margin-bottom:1.25rem;}
.finput{background:#fff;border:2px solid var(--border);border-radius:999px;padding:.45rem 1.1rem;font-size:.85rem;font-weight:700;color:#1e293b;outline:none;font-family:'Nunito',sans-serif;}
.fbtn{padding:.45rem 1.3rem;border-radius:999px;background:var(--blue);color:#fff;font-size:.85rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;}
.card{background:#fff;border:2px solid var(--border);border-radius:1.25rem;overflow:hidden;box-shadow:0 3px 0 var(--border);}
table{width:100%;border-collapse:collapse;font-family:'Nunito',sans-serif;}
thead tr{background:#e8f4ff;border-bottom:2px solid var(--border);}
thead th{padding:.8rem 1rem;text-align:left;font-size:.78rem;font-weight:800;color:var(--blue);text-transform:uppercase;letter-spacing:.04em;}
tbody tr{border-bottom:1px solid var(--border);transition:background .15s;}
tbody tr:hover{background:#f0f9ff;}
tbody td{padding:.8rem 1rem;font-size:.86rem;font-weight:700;}
.mode-chip{border-radius:999px;padding:.18rem .65rem;font-size:.75rem;font-weight:800;}
.m-kuliah{background:#e8f4ff;color:var(--blue);}
.m-kerja{background:#fef9c3;color:#ca8a04;}
.skor-val{font-family:'Fredoka One',sans-serif;font-size:1.1rem;}
.btn-detail{background:#e8f4ff;color:var(--blue);border-radius:999px;padding:.22rem .75rem;font-size:.76rem;font-weight:800;text-decoration:none;display:inline-block;}
</style>

<div class="page-title">📊 Rasionalisasi Siswa</div>

<div class="stat-grid">
  <div class="scard"><div class="ico">🎓</div><div class="val">{{ $totalKuliah }}</div><div class="lbl">Rasionalisasi Kuliah</div></div>
  <div class="scard"><div class="ico">💼</div><div class="val">{{ $totalKerja }}</div><div class="lbl">Rasionalisasi Karir</div></div>
  <div class="scard"><div class="ico">⭐</div><div class="val">{{ round($rataScore??0) }}</div><div class="lbl">Rata-rata Skor</div></div>
  <div class="scard"><div class="ico">📋</div><div class="val">{{ $totalKuliah+$totalKerja }}</div><div class="lbl">Total Analisis</div></div>
</div>

<form method="GET" class="filter-row">
  <input name="search" value="{{ request('search') }}" placeholder="Cari nama siswa..." class="finput" style="width:200px;">
  <select name="mode" class="finput">
    <option value="">Semua Mode</option>
    <option value="kuliah" {{ request('mode')==='kuliah'?'selected':'' }}>🎓 Kuliah</option>
    <option value="kerja" {{ request('mode')==='kerja'?'selected':'' }}>💼 Karir</option>
  </select>
  <select name="jurusan" class="finput">
    <option value="">Semua Jurusan</option>
    @foreach(['AKL','MPLB','PPLG','PM','TF','TJKT','DKV'] as $j)
      <option value="{{ $j }}" {{ request('jurusan')===$j?'selected':'' }}>{{ $j }}</option>
    @endforeach
  </select>
  <button type="submit" class="fbtn">🔍 Filter</button>
  @if(request()->anyFilled(['search','mode','jurusan']))
    <a href="{{ route('guru.rasionalisasi.index') }}" class="fbtn" style="background:#e0f2fe;color:var(--blue);">✕ Reset</a>
  @endif
</form>

<div class="card">
  <table>
    <thead>
      <tr>
        <th>Nama Siswa</th>
        <th>Jurusan</th>
        <th>Kelas</th>
        <th>Mode</th>
        <th>Skor</th>
        @if(request('mode')!=='kerja')<th>Peluang</th>@endif
        <th>Tanggal</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($riwayat as $r)
        @php
          $skor=$r->skor_kesiapan??0;
          $warna=$skor>=75?'#16a34a':($skor>=50?'#d97706':'#dc2626');
        @endphp
        <tr>
          <td style="font-weight:800;">{{ $r->user->name }}</td>
          <td>{{ $r->user->jurusan??'-' }}</td>
          <td style="color:#94a3b8;">{{ $r->user->kelas??'-' }}</td>
          <td><span class="mode-chip m-{{ $r->mode }}">{{ $r->mode==='kuliah'?'🎓 Kuliah':'💼 Karir' }}</span></td>
          <td><span class="skor-val" style="color:{{ $warna }}">{{ $skor ?: '-' }}</span></td>
          @if(request('mode')!=='kerja')
            <td style="color:#64748b;font-size:.8rem;">{{ $r->hasil_ai['tingkat_peluang']??($r->mode==='kerja'?'-':'-') }}</td>
          @endif
          <td style="color:#94a3b8;font-size:.8rem;">{{ $r->created_at->format('d M Y') }}</td>
          <td><a href="{{ route('guru.rasionalisasi.show', $r->id) }}" class="btn-detail">Lihat Detail →</a></td>
        </tr>
      @empty
        <tr><td colspan="8" style="text-align:center;padding:2rem;color:#94a3b8;font-weight:700;">🐱 Belum ada data rasionalisasi siswa.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div style="padding:1rem;">{{ $riwayat->links() }}</div>
</div>
@endsection
