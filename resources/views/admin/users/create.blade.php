@extends('layouts.admin')
@section('title','Tambah User')
@section('content')

<style>
.page-title { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.8rem; color:#0d1f35; margin:1rem 0 1.5rem; letter-spacing:-0.5px; }
.back-link  { color:#1a8cff; font-size:.88rem; font-weight:800; text-decoration:none; display:inline-flex; align-items:center; gap:.3rem; font-family:'Nunito',sans-serif; }
.back-link:hover { text-decoration:underline; }
.form-card  { background:#fff; border:2px solid #d0e4f7; border-radius:1.5rem; padding:2rem; max-width:680px; box-shadow:0 4px 0 #d0e4f7; }
.fbtn       { padding:.75rem 2rem; border-radius:14px; background:#1a8cff; color:#fff; font-size:.95rem; font-weight:900; border:none; cursor:pointer; font-family:'Nunito',sans-serif; box-shadow:0 5px 0 #005bb8; transition:all .18s; margin-top:.5rem; display:inline-flex; align-items:center; gap:.4rem; }
.fbtn:hover { transform:translateY(-2px); box-shadow:0 7px 0 #005bb8; }
.fbtn:active{ transform:translateY(3px);  box-shadow:0 2px 0 #005bb8; }
.finput     { background:#fff; border:2px solid rgba(14,165,233,.15); border-radius:999px; padding:.6rem 1.2rem; font-size:.9rem; font-weight:700; color:#1e293b; outline:none; font-family:'Nunito',sans-serif; transition:border-color .2s; width:100%; box-sizing:border-box;}
.finput:focus{border-color:#0ea5e9;}
.form-group { margin-bottom:1.25rem; }
.form-label { display:block; margin-bottom:.5rem; font-weight:800; color:#475569; font-size:.85rem;}
</style>

<a href="{{ route('admin.users.index') }}" class="back-link">← Kembali</a>
<div class="page-title">➕ Tambah User Profile</div>

<div class="form-card">
  <form method="POST" action="{{ route('admin.users.store') }}">
    @csrf

    <div class="form-group">
      <label class="form-label">Nama Lengkap</label>
      <input type="text" name="name" class="finput" required>
      @error('name')<div style="color:red;font-size:0.8rem;margin-top:0.2rem;">{{$message}}</div>@enderror
    </div>

    <div class="form-group">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="finput" required>
      @error('email')<div style="color:red;font-size:0.8rem;margin-top:0.2rem;">{{$message}}</div>@enderror
    </div>

    <div class="form-group">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="finput" required>
      @error('password')<div style="color:red;font-size:0.8rem;margin-top:0.2rem;">{{$message}}</div>@enderror
    </div>

    <div class="form-group">
      <label class="form-label">Konfirmasi Password</label>
      <input type="password" name="password_confirmation" class="finput" required>
    </div>

    <div class="form-group">
      <label class="form-label">Role Akses</label>
      <select name="role" class="finput" required>
        <option value="siswa">Siswa</option>
        <option value="guru">Guru</option>
        <option value="admin">Admin</option>
      </select>
    </div>

    <div class="form-group">
      <label class="form-label">Jurusan (Opsional - untuk Siswa)</label>
      <input type="text" name="jurusan" class="finput" placeholder="Contoh: Rekayasa Perangkat Lunak">
    </div>

    <div class="form-group">
      <label class="form-label">Kelas (Opsional)</label>
      <input type="text" name="kelas" class="finput" placeholder="Contoh: XII RPL 1">
    </div>

    <div class="form-group" style="margin-bottom:1.75rem;">
      <label class="form-label">Nomor WhatsApp (Opsional)</label>
      <input type="text" name="phone" class="finput" placeholder="08xxxxxxxx">
    </div>

    <button type="submit" class="fbtn">💾 Simpan Area User</button>
  </form>
</div>

@endsection
