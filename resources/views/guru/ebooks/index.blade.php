@extends('layouts.guru')
@section('title','Kelola E-Book')
@section('content')
<style>
.page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;}
.top-row{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.25rem;}
.filter-row{display:flex;gap:.75rem;flex-wrap:wrap;margin-bottom:1.25rem;}
.finput{background:#fff;border:2px solid rgba(14,165,233,.15);border-radius:999px;padding:.45rem 1.1rem;font-size:.85rem;font-weight:700;color:#1e293b;outline:none;font-family:'Nunito',sans-serif;transition:border-color .2s;}
.finput:focus{border-color:#0ea5e9;}
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
.btn-e{background:#e0f2fe;color:#0284c7;border-radius:999px;padding:.22rem .75rem;font-size:.76rem;font-weight:800;text-decoration:none;display:inline-block;}
.btn-d{background:#fee2e2;color:#dc2626;border-radius:999px;padding:.22rem .75rem;font-size:.76rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;}
</style>
<div class="top-row">
  <div class="page-title">Kelola E-Book 📚</div>
  <a href="{{ route('guru.ebooks.create') }}" class="btn-new">+ Upload E-Book</a>
</div>
<form method="GET" class="filter-row">
  <input name="search" value="{{ request('search') }}" placeholder="Cari judul..." class="finput" style="width:200px;">
  <select name="category_id" class="finput">
    <option value="">Semua Kategori</option>
    @foreach($categories as $c)
      <option value="{{ $c->id }}" {{ request('category_id')==$c->id?'selected':'' }}>{{ $c->nama_kategori }}</option>
    @endforeach
  </select>
  <button type="submit" class="fbtn">Filter</button>
</form>
<div class="card">
  <table>
    <thead><tr><th>Judul</th><th>Penulis</th><th>Kategori</th><th>Jurusan</th><th>Aksi</th></tr></thead>
    <tbody>
      @forelse($ebooks as $e)
        <tr>
          <td style="font-weight:800;">{{ $e->judul }}</td>
          <td style="color:#64748b;">{{ $e->penulis }}</td>
          <td><span class="chip">{{ $e->category->nama_kategori }}</span></td>
          <td style="color:#94a3b8;">{{ $e->jurusan??'Umum' }}</td>
          <td style="display:flex;gap:.4rem;align-items:center;">
            <a href="{{ route('guru.ebooks.edit',$e) }}" class="btn-e">✏️ Edit</a>
            <form method="POST" action="{{ route('guru.ebooks.destroy',$e) }}" onsubmit="return confirm('Hapus e-book ini?')">
              @csrf @method('DELETE')
              <button class="btn-d">🗑️ Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5" style="text-align:center;padding:2rem;color:#94a3b8;font-weight:700;">Belum ada e-book. Upload yang pertama! 📚</td></tr>
      @endforelse
    </tbody>
  </table>
  <div style="padding:1rem;">{{ $ebooks->links() }}</div>
</div>
@endsection
