@extends('layouts.guru')
@section('title','Edit Tugas')
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
.sbtn{padding:.7rem 2rem;border-radius:999px;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;font-size:.95rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;box-shadow:0 4px 14px rgba(14,165,233,.3);}
</style>
<a href="{{ route('guru.tasks.index') }}" class="back">← Kembali ke Daftar Tugas</a>
<div class="page-title">Edit Tugas ✏️</div>
<div class="fcard">
  <form method="POST" action="{{ route('guru.tasks.update',$task) }}">
    @csrf @method('PUT')
    <label>Judul Tugas</label>
    <input name="judul" value="{{ old('judul',$task->judul) }}" class="fi">
    <div class="g2">
      <div>
        <label>Jurusan</label>
        <input name="jurusan" value="{{ old('jurusan',$task->jurusan) }}" placeholder="Kosong = semua" class="fi">
      </div>
      <div>
        <label>Kelas</label>
        <input name="kelas" value="{{ old('kelas',$task->kelas) }}" placeholder="Kosong = semua" class="fi">
      </div>
    </div>
    <label>Deadline</label>
    <input name="deadline" type="datetime-local" value="{{ old('deadline',$task->deadline->format('Y-m-d\TH:i')) }}" class="fi">
    <label>Deskripsi</label>
    <textarea name="deskripsi" rows="4" class="fi">{{ old('deskripsi',$task->deskripsi) }}</textarea>
    <button type="submit" class="sbtn">Simpan Perubahan ✅</button>
  </form>
</div>
@endsection
