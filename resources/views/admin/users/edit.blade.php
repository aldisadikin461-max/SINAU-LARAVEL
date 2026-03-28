@extends('layouts.admin')
@section('title','Edit User')
@section('content')

<style>
.page-title  { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.8rem; color:#0d1f35; margin-bottom:1.5rem; letter-spacing:-0.5px; }
.back-link   { color:#1a8cff; font-size:.88rem; font-weight:800; text-decoration:none; display:inline-flex; align-items:center; gap:.3rem; margin-bottom:1rem; font-family:'Nunito',sans-serif; }
.back-link:hover { text-decoration:underline; }
.form-card   { background:#fff; border:2px solid #d0e4f7; border-radius:1.5rem; padding:2rem; max-width:520px; box-shadow:0 4px 0 #d0e4f7; }
.form-group  { margin-bottom:1rem; }
.form-label  { display:block; font-family:'Nunito',sans-serif; font-size:.82rem; font-weight:800; color:#3d5a7a; margin-bottom:.4rem; }
.finput      { width:100%; background:#f4f8ff; border:2px solid #d0e4f7; border-radius:14px; padding:.65rem 1rem; font-size:.9rem; font-weight:600; color:#0d1f35; outline:none; font-family:'Nunito Sans',sans-serif; transition:all .18s; }
.finput:focus{ border-color:#1a8cff; background:#fff; box-shadow:0 0 0 4px rgba(26,140,255,.1); }
.ferr        { color:#ff4757; font-size:.78rem; font-weight:700; margin-top:.3rem; font-family:'Nunito',sans-serif; }
.fbtn        { padding:.75rem 2rem; border-radius:14px; background:#1a8cff; color:#fff; font-size:.95rem; font-weight:900; border:none; cursor:pointer; font-family:'Nunito',sans-serif; box-shadow:0 5px 0 #005bb8; transition:all .18s; margin-top:.5rem; }
.fbtn:hover  { transform:translateY(-2px); box-shadow:0 7px 0 #005bb8; }
.fbtn:active { transform:translateY(3px); box-shadow:0 2px 0 #005bb8; }
</style>

<a href="{{ route('admin.users') }}" class="back-link">← Kembali</a>
<div class="page-title">✏️ Edit User</div>

<div class="form-card">
  <form method="POST" action="{{ route('admin.users.update', $user) }}">
    @csrf
    @method('PUT')

    @foreach([
      ['name',    'Nama Lengkap',   'text',  $user->name],
      ['email',   'Email',          'email', $user->email],
      ['phone',   'No. WhatsApp',   'text',  $user->phone],
      ['jurusan', 'Jurusan',        'text',  $user->jurusan],
      ['kelas',   'Kelas',          'text',  $user->kelas],
    ] as [$f, $l, $t, $v])
      <div class="form-group">
        <label class="form-label">{{ $l }}</label>
        <input name="{{ $f }}" type="{{ $t }}" value="{{ old($f, $v) }}" class="finput {{ $errors->has($f) ? 'border-red-400' : '' }}">
        @error($f)
          <p class="ferr">{{ $message }}</p>
        @enderror
      </div>
    @endforeach

    <div class="form-group">
      <label class="form-label">Role</label>
      <select name="role" class="finput">
        @foreach(['admin','guru','siswa'] as $r)
          <option value="{{ $r }}" {{ $user->role === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
        @endforeach
      </select>
      @error('role')
        <p class="ferr">{{ $message }}</p>
      @enderror
    </div>

    <button type="submit" class="fbtn">💾 Simpan Perubahan</button>
  </form>
</div>

@endsection
