@extends('layouts.admin')
@section('title','Tambah Beasiswa')
@section('content')

<style>
.page-title { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.8rem; color:#0d1f35; margin:1rem 0 1.5rem; letter-spacing:-0.5px; }
.back-link  { color:#1a8cff; font-size:.88rem; font-weight:800; text-decoration:none; display:inline-flex; align-items:center; gap:.3rem; font-family:'Nunito',sans-serif; }
.back-link:hover { text-decoration:underline; }
.form-card  { background:#fff; border:2px solid #d0e4f7; border-radius:1.5rem; padding:2rem; max-width:680px; box-shadow:0 4px 0 #d0e4f7; }
.fbtn       { padding:.75rem 2rem; border-radius:14px; background:#1a8cff; color:#fff; font-size:.95rem; font-weight:900; border:none; cursor:pointer; font-family:'Nunito',sans-serif; box-shadow:0 5px 0 #005bb8; transition:all .18s; margin-top:.5rem; display:inline-flex; align-items:center; gap:.4rem; }
.fbtn:hover { transform:translateY(-2px); box-shadow:0 7px 0 #005bb8; }
.fbtn:active{ transform:translateY(3px);  box-shadow:0 2px 0 #005bb8; }
</style>

<a href="{{ route('admin.scholarships.index') }}" class="back-link">← Kembali</a>
<div class="page-title">🎓 Tambah Beasiswa</div>

<div class="form-card">
  <form method="POST" action="{{ route('admin.scholarships.store') }}">
    @csrf
    @include('admin.scholarships._form')
    <button type="submit" class="fbtn">💾 Simpan Beasiswa</button>
  </form>
</div>

@endsection
