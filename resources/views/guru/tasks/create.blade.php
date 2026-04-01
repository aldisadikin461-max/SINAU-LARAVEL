@extends('layouts.guru')
@section('title','Assign Tugas')
@section('content')
<style>
.back{color:#0ea5e9;font-size:.88rem;font-weight:800;text-decoration:none;display:inline-block;margin-bottom:1rem;}
.page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:1.25rem;}
.fcard{background:#fff;border:1.5px solid rgba(14,165,233,.1);border-radius:1.25rem;padding:2rem;max-width:580px;box-shadow:0 4px 18px rgba(14,165,233,.07);}
label{display:block;font-size:.82rem;font-weight:800;color:#64748b;margin-bottom:.35rem;}
.fi{width:100%;background:#f8fafc;border:2px solid rgba(14,165,233,.12);border-radius:.875rem;padding:.6rem 1rem;font-size:.9rem;font-weight:700;color:#1e293b;outline:none;font-family:'Nunito',sans-serif;margin-bottom:.85rem;transition:border-color .2s;}
.fi:focus{border-color:#0ea5e9;background:#fff;}
textarea.fi{resize:none;border-radius:.875rem;}
.g2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
@media(max-width:600px){.g2{grid-template-columns:1fr;}}
.err{color:#ef4444;font-size:.78rem;font-weight:700;margin-top:-.6rem;margin-bottom:.6rem;}
.sbtn{padding:.7rem 2rem;border-radius:999px;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;font-size:.95rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;box-shadow:0 4px 14px rgba(14,165,233,.3);}
.info{background:#e0f2fe;border:1px solid #bae6fd;border-radius:.875rem;padding:.75rem 1rem;font-size:.82rem;font-weight:700;color:#0284c7;margin-bottom:1rem;}
</style>
<a href="{{ route('guru.tasks.index') }}" class="back">← Kembali ke Daftar Tugas</a>
<div class="page-title">Assign Tugas Baru 📋</div>
<div class="fcard">
  <div class="info">💡 Kosongkan jurusan/kelas jika tugas berlaku untuk semua siswa.</div>
  <form method="POST" action="{{ route('guru.tasks.store') }}">
    @csrf
    <label>Judul Tugas *</label>
    <input name="judul" value="{{ old('judul') }}" placeholder="Contoh: Membuat Website Portfolio" class="fi">
    @error('judul')<p class="err">{{ $message }}</p>@enderror

    <div class="g2">
      <div>
        <label>Jurusan (opsional)</label>
        <input name="jurusan" value="{{ old('jurusan') }}" placeholder="Contoh: RPL" class="fi">
      </div>
      <div>
        <label>Kelas (opsional)</label>
        <input name="kelas" value="{{ old('kelas') }}" placeholder="Contoh: XI" class="fi">
      </div>
    </div>

    <label>Deadline *</label>
    <input name="deadline" type="datetime-local" value="{{ old('deadline') }}" class="fi">
    @error('deadline')<p class="err">{{ $message }}</p>@enderror

    <label>Deskripsi Tugas (opsional)</label>
    <textarea name="deskripsi" rows="4" class="fi" placeholder="Jelaskan detail tugas yang harus dikerjakan...">{{ old('deskripsi') }}</textarea>

    <button type="submit" class="sbtn">Assign Tugas 🚀</button>
  </form>
</div>
@endsection
