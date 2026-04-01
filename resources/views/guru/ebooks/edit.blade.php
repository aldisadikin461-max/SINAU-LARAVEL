@extends('layouts.guru')
@section('title','Edit E-Book')
@section('content')
<style>
.back{color:#0ea5e9;font-size:.88rem;font-weight:800;text-decoration:none;display:inline-block;margin-bottom:1rem;}
.page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:1.25rem;}
.fcard{background:#fff;border:1.5px solid rgba(14,165,233,.1);border-radius:1.25rem;padding:2rem;max-width:640px;box-shadow:0 4px 18px rgba(14,165,233,.07);}
label{display:block;font-size:.82rem;font-weight:800;color:#64748b;margin-bottom:.35rem;}
.fi{width:100%;background:#f8fafc;border:2px solid rgba(14,165,233,.12);border-radius:.875rem;padding:.6rem 1rem;font-size:.9rem;font-weight:700;color:#1e293b;outline:none;font-family:'Nunito',sans-serif;margin-bottom:.85rem;transition:border-color .2s;}
.fi:focus{border-color:#0ea5e9;background:#fff;}
.g2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
@media(max-width:600px){.g2{grid-template-columns:1fr;}}
.hint{font-size:.75rem;color:#94a3b8;font-weight:600;margin-top:-.6rem;margin-bottom:.7rem;}
.sbtn{padding:.7rem 2rem;border-radius:999px;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;font-size:.95rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;box-shadow:0 4px 14px rgba(14,165,233,.3);}
</style>
<a href="{{ route('guru.ebooks.index') }}" class="back">← Kembali ke Daftar E-Book</a>
<div class="page-title">Edit E-Book ✏️</div>
<div class="fcard">
  <form method="POST" action="{{ route('guru.ebooks.update',$ebook) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    <label>Judul E-Book</label>
    <input name="judul" value="{{ old('judul',$ebook->judul) }}" class="fi">

    <label>Penulis</label>
    <input name="penulis" value="{{ old('penulis',$ebook->penulis) }}" class="fi">

    <div class="g2">
      <div>
        <label>Kategori</label>
        <select name="category_id" class="fi">
          @foreach($categories as $c)
            <option value="{{ $c->id }}" {{ old('category_id',$ebook->category_id)==$c->id?'selected':'' }}>{{ $c->nama_kategori }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label>Jurusan</label>
        <input name="jurusan" value="{{ old('jurusan',$ebook->jurusan) }}" class="fi">
      </div>
    </div>

    <label>Ganti File PDF</label>
    <input name="file" type="file" accept=".pdf" class="fi" style="padding:.5rem;">
    <p class="hint">Kosongkan jika tidak ingin mengganti file PDF. File saat ini: {{ basename($ebook->file_path) }}</p>

    <label>Ganti Cover</label>
    <input name="cover" type="file" accept="image/*" class="fi" style="padding:.5rem;">
    @if($ebook->cover)<p class="hint">Cover saat ini: {{ basename($ebook->cover) }}</p>@endif

    <button type="submit" class="sbtn">Simpan Perubahan ✅</button>
  </form>
</div>
@endsection
