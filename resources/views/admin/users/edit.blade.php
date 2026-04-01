@extends('layouts.admin')
@section('title','Edit User')
@section('content')
<style>
.back{color:#0ea5e9;font-size:.88rem;font-weight:800;text-decoration:none;display:inline-block;margin-bottom:1rem;}
.page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:1.25rem;}
.fcard{background:#fff;border:1.5px solid rgba(14,165,233,.1);border-radius:1.25rem;padding:2rem;max-width:560px;box-shadow:0 4px 18px rgba(14,165,233,.07);}
.sec{font-family:'Fredoka One',sans-serif;font-size:1rem;color:#0ea5e9;margin-bottom:.75rem;margin-top:.5rem;}
label{display:block;font-size:.82rem;font-weight:800;color:#64748b;margin-bottom:.35rem;}
.fi{width:100%;background:#f8fafc;border:2px solid rgba(14,165,233,.12);border-radius:.875rem;padding:.6rem 1rem;font-size:.9rem;font-weight:700;color:#1e293b;outline:none;font-family:'Nunito',sans-serif;margin-bottom:.85rem;transition:border-color .2s;}
.fi:focus{border-color:#0ea5e9;background:#fff;}
.g2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
@media(max-width:600px){.g2{grid-template-columns:1fr;}}
.err{color:#ef4444;font-size:.78rem;font-weight:700;margin-top:-.6rem;margin-bottom:.6rem;}
.sbtn{padding:.7rem 2rem;border-radius:999px;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;font-size:.95rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;box-shadow:0 4px 14px rgba(14,165,233,.3);}
.hint{font-size:.75rem;color:#94a3b8;font-weight:600;margin-top:-.6rem;margin-bottom:.7rem;}
.user-badge{display:inline-flex;align-items:center;gap:.5rem;background:#f0f9ff;border:1.5px solid rgba(14,165,233,.2);border-radius:999px;padding:.35rem 1rem;font-size:.85rem;font-weight:800;color:#0284c7;margin-bottom:1.25rem;}
</style>

<a href="{{ route('admin.users.index') }}" class="back">← Kembali ke Kelola User</a>
<div class="page-title">Edit User ✏️</div>

<div class="fcard">
  <div class="user-badge">
    👤 {{ $user->name }} — <span style="text-transform:capitalize;">{{ $user->role }}</span>
  </div>

  <form method="POST" action="{{ route('admin.users.update', $user) }}">
    @csrf @method('PUT')

    <div class="sec">👤 Data Akun</div>
    <label>Nama Lengkap</label>
    <input name="name" value="{{ old('name', $user->name) }}" class="fi">
    @error('name')<p class="err">{{ $message }}</p>@enderror

    <label>Email</label>
    <input name="email" type="email" value="{{ old('email', $user->email) }}" class="fi">
    @error('email')<p class="err">{{ $message }}</p>@enderror

    <label>Role</label>
    <select name="role" class="fi">
      @foreach(['admin'=>'Admin','guru'=>'Guru','siswa'=>'Siswa'] as $v=>$l)
        <option value="{{ $v }}" {{ old('role',$user->role)===$v?'selected':'' }}>{{ $l }}</option>
      @endforeach
    </select>
    @error('role')<p class="err">{{ $message }}</p>@enderror

    <div class="sec">📋 Informasi Tambahan</div>
    <div class="g2">
      <div>
        <label>Jurusan</label>
        <input name="jurusan" value="{{ old('jurusan', $user->jurusan) }}" placeholder="RPL / TKJ / MM" class="fi">
      </div>
      <div>
        <label>Kelas</label>
        <input name="kelas" value="{{ old('kelas', $user->kelas) }}" placeholder="X / XI / XII" class="fi">
      </div>
    </div>

    <label>No. WhatsApp</label>
    <input name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx" class="fi">

    <div class="sec">🔒 Ganti Password</div>
    <div class="g2">
      <div>
        <label>Password Baru</label>
        <input name="password" type="password" placeholder="Kosongkan jika tidak diganti" class="fi">
        @error('password')<p class="err">{{ $message }}</p>@enderror
      </div>
      <div>
        <label>Konfirmasi Password</label>
        <input name="password_confirmation" type="password" placeholder="Ulangi password baru" class="fi">
      </div>
    </div>
    <p class="hint">Kosongkan kedua field di atas jika tidak ingin mengubah password.</p>

    <button type="submit" class="sbtn">Simpan Perubahan ✅</button>
  </form>
</div>
@endsection
