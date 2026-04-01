@extends('layouts.guru')
@section('title', isset($quiz) ? 'Edit Paket Soal' : 'Buat Paket Soal')
@section('content')
<style>
.back{color:#0ea5e9;font-size:.88rem;font-weight:800;text-decoration:none;display:inline-block;margin-bottom:1rem;}
.page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:1.5rem;}
.fcard{background:#fff;border:1.5px solid rgba(14,165,233,.1);border-radius:1.25rem;padding:2rem;max-width:600px;box-shadow:0 4px 18px rgba(14,165,233,.07);}
label{display:block;font-size:.82rem;font-weight:800;color:#64748b;margin-bottom:.35rem;margin-top:.9rem;}
label:first-of-type{margin-top:0;}
.fi{width:100%;background:#f8fafc;border:2px solid rgba(14,165,233,.12);border-radius:.875rem;padding:.65rem 1rem;font-size:.9rem;font-weight:700;color:#1e293b;outline:none;font-family:'Nunito',sans-serif;transition:border-color .2s;}
.fi:focus{border-color:#0ea5e9;background:#fff;}
textarea.fi{resize:vertical;}
.err{color:#ef4444;font-size:.78rem;font-weight:700;margin-top:.25rem;}
.g2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
@media(max-width:600px){.g2{grid-template-columns:1fr;}}
.sbtn{margin-top:1.5rem;padding:.7rem 2rem;border-radius:999px;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;font-size:.95rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;box-shadow:0 4px 14px rgba(14,165,233,.3);}
</style>

<a href="{{ route('guru.quiz.index') }}" class="back">← Kembali ke Paket Soal</a>
<div class="page-title">{{ isset($quiz) ? '✏️ Edit Paket Soal' : '📦 Buat Paket Soal Baru' }}</div>

<div class="fcard">
  <form method="POST" action="{{ isset($quiz) ? route('guru.quiz.update', $quiz) : route('guru.quiz.store') }}">
    @csrf
    @if(isset($quiz)) @method('PUT') @endif

    <label>Nama Paket Soal *</label>
    <input name="nama" value="{{ old('nama', $quiz->nama ?? '') }}" placeholder="Contoh: UTS Matematika Kelas XI" class="fi">
    @error('nama')<p class="err">{{ $message }}</p>@enderror

    <label>Deskripsi (opsional)</label>
    <textarea name="deskripsi" rows="3" placeholder="Keterangan paket soal..." class="fi">{{ old('deskripsi', $quiz->deskripsi ?? '') }}</textarea>

    <div class="g2">
      <div>
        <label>Kelas (opsional)</label>
        <input name="kelas" value="{{ old('kelas', $quiz->kelas ?? '') }}" placeholder="XI PPLG 1" class="fi">
      </div>
      <div>
        <label>Jurusan (opsional)</label>
        <input name="jurusan" value="{{ old('jurusan', $quiz->jurusan ?? '') }}" placeholder="PPLG" class="fi">
      </div>
    </div>

    @if(isset($quiz))
      <label>Status</label>
      <select name="status" class="fi">
        <option value="draft"     {{ ($quiz->status ?? '') === 'draft'     ? 'selected' : '' }}>Draft (tidak terlihat siswa)</option>
        <option value="published" {{ ($quiz->status ?? '') === 'published' ? 'selected' : '' }}>Published (siswa bisa mengerjakan)</option>
      </select>
    @endif

    <button type="submit" class="sbtn">
      {{ isset($quiz) ? '💾 Simpan Perubahan' : '➡️ Buat & Tambah Soal' }}
    </button>
  </form>
</div>
@endsection