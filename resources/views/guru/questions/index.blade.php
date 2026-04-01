@extends('layouts.guru')
@section('title','Kelola Soal')
@section('content')
<style>
.page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;}
.top-row{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.25rem;}
.filter-row{display:flex;gap:.75rem;flex-wrap:wrap;margin-bottom:1.25rem;}
.finput{background:#fff;border:2px solid rgba(14,165,233,.15);border-radius:999px;padding:.45rem 1.1rem;font-size:.85rem;font-weight:700;color:#1e293b;outline:none;font-family:'Nunito',sans-serif;}
.fbtn{padding:.45rem 1.3rem;border-radius:999px;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;font-size:.85rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;}
.btn-new{padding:.55rem 1.4rem;border-radius:999px;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;font-size:.88rem;font-weight:800;text-decoration:none;box-shadow:0 4px 14px rgba(14,165,233,.3);}
.card{background:#fff;border:1.5px solid rgba(14,165,233,.1);border-radius:1.25rem;overflow:hidden;box-shadow:0 4px 18px rgba(14,165,233,.07);}
table{width:100%;border-collapse:collapse;font-family:'Nunito',sans-serif;}
thead tr{background:#f0f9ff;border-bottom:2px solid rgba(14,165,233,.1);}
thead th{padding:.8rem 1rem;text-align:left;font-size:.78rem;font-weight:800;color:#0284c7;text-transform:uppercase;letter-spacing:.04em;}
tbody tr{border-bottom:1px solid rgba(14,165,233,.06);transition:background .15s;}
tbody tr:hover{background:#f0f9ff;}
tbody td{padding:.8rem 1rem;font-size:.86rem;font-weight:700;}
.chip{background:#e0f2fe;color:#0284c7;border-radius:999px;padding:.18rem .65rem;font-size:.75rem;font-weight:800;}
.lm{background:#dcfce7;color:#16a34a;border-radius:999px;padding:.18rem .65rem;font-size:.75rem;font-weight:800;}
.ls{background:#fef9c3;color:#ca8a04;border-radius:999px;padding:.18rem .65rem;font-size:.75rem;font-weight:800;}
.lh{background:#fee2e2;color:#dc2626;border-radius:999px;padding:.18rem .65rem;font-size:.75rem;font-weight:800;}
.jwb{font-weight:900;text-transform:uppercase;color:#16a34a;}
.btn-e{background:#e0f2fe;color:#0284c7;border-radius:999px;padding:.22rem .75rem;font-size:.76rem;font-weight:800;text-decoration:none;display:inline-block;}
.btn-d{background:#fee2e2;color:#dc2626;border-radius:999px;padding:.22rem .75rem;font-size:.76rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;}
</style>
<div class="top-row">
  <div class="page-title">Kelola Soal ❓</div>
  <a href="{{ route('guru.questions.create') }}" class="btn-new">+ Buat Soal Baru</a>
</div>
<form method="GET" class="filter-row">
  <input name="search" value="{{ request('search') }}" placeholder="Cari pertanyaan..." class="finput" style="width:200px;">
  <select name="category_id" class="finput">
    <option value="">Semua Kategori</option>
    @foreach($categories as $c)
      <option value="{{ $c->id }}" {{ request('category_id')==$c->id?'selected':'' }}>{{ $c->nama_kategori }}</option>
    @endforeach
  </select>
  <select name="tingkat" class="finput">
    <option value="">Semua Tingkat</option>
    @foreach(['mudah','sedang','sulit'] as $t)
      <option value="{{ $t }}" {{ request('tingkat')===$t?'selected':'' }}>{{ ucfirst($t) }}</option>
    @endforeach
  </select>
  <button type="submit" class="fbtn">Filter</button>
</form>
<div class="card">
  <table>
    <thead><tr><th>Pertanyaan</th><th>Kategori</th><th>Jawaban Benar</th><th>Tingkat</th><th>Aksi</th></tr></thead>
    <tbody>
      @forelse($questions as $q)
        <tr>
          <td style="max-width:300px;">{{ Str::limit($q->pertanyaan,65) }}</td>
          <td><span class="chip">{{ $q->category->nama_kategori }}</span></td>
          <td class="jwb">{{ strtoupper($q->jawaban_benar) }}</td>
          <td>
            @if($q->tingkat_kesulitan==='mudah')<span class="lm">Mudah</span>
            @elseif($q->tingkat_kesulitan==='sedang')<span class="ls">Sedang</span>
            @else<span class="lh">Sulit</span>@endif
          </td>
          <td style="display:flex;gap:.4rem;align-items:center;">
            <a href="{{ route('guru.questions.edit',$q) }}" class="btn-e">✏️ Edit</a>
            <form method="POST" action="{{ route('guru.questions.destroy',$q) }}" onsubmit="return confirm('Hapus soal ini?')">
              @csrf @method('DELETE')
              <button class="btn-d">🗑️ Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5" style="text-align:center;padding:2rem;color:#94a3b8;font-weight:700;">Belum ada soal. Buat yang pertama! ❓</td></tr>
      @endforelse
    </tbody>
  </table>
  <div style="padding:1rem;">{{ $questions->links() }}</div>
</div>
@endsection
