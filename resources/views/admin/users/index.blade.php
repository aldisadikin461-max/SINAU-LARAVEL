@extends('layouts.admin')
@section('title','Kelola User')
@section('content')
<style>
.page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:1.25rem;}
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
.r-admin{background:#fef9c3;color:#ca8a04;border-radius:999px;padding:.18rem .65rem;font-size:.75rem;font-weight:800;}
.r-guru{background:#dcfce7;color:#16a34a;border-radius:999px;padding:.18rem .65rem;font-size:.75rem;font-weight:800;}
.r-siswa{background:#e0f2fe;color:#0284c7;border-radius:999px;padding:.18rem .65rem;font-size:.75rem;font-weight:800;}
.btn-e{background:#e0f2fe;color:#0284c7;border-radius:999px;padding:.22rem .75rem;font-size:.76rem;font-weight:800;text-decoration:none;display:inline-block;}
.btn-wa{background:#dcfce7;color:#16a34a;border-radius:999px;padding:.22rem .75rem;font-size:.76rem;font-weight:800;text-decoration:none;display:inline-block;}
.btn-d{background:#fee2e2;color:#dc2626;border-radius:999px;padding:.22rem .75rem;font-size:.76rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;}
.summary{display:flex;gap:1rem;flex-wrap:wrap;margin-bottom:1.25rem;}
.sum-chip{background:#fff;border:1.5px solid rgba(14,165,233,.12);border-radius:999px;padding:.35rem 1rem;font-size:.82rem;font-weight:800;color:#64748b;box-shadow:0 2px 8px rgba(14,165,233,.06);}
.sum-chip span{color:#0ea5e9;}
</style>

<div class="top-row">
  <div class="page-title">Kelola User 👥</div>
  <a href="{{ route('admin.users.create') }}" class="btn-new">+ Tambah User</a>
</div>

{{-- Summary chips --}}
<div class="summary">
  <span class="sum-chip">Total: <span>{{ $users->total() }}</span> user</span>
  @foreach(['admin','guru','siswa'] as $r)
    <span class="sum-chip">{{ ucfirst($r) }}: <span>{{ \App\Models\User::where('role',$r)->count() }}</span></span>
  @endforeach
</div>

<form method="GET" class="filter-row">
  <input name="search" value="{{ request('search') }}" placeholder="Cari nama / email..." class="finput" style="width:220px;">
  <select name="role" class="finput">
    <option value="">Semua Role</option>
    @foreach(['admin','guru','siswa'] as $r)
      <option value="{{ $r }}" {{ request('role')===$r?'selected':'' }}>{{ ucfirst($r) }}</option>
    @endforeach
  </select>
  <button type="submit" class="fbtn">🔍 Filter</button>
  @if(request('search') || request('role'))
    <a href="{{ route('admin.users.index') }}" class="fbtn" style="background:#e0f2fe;color:#0284c7;box-shadow:none;text-decoration:none;">✕ Reset</a>
  @endif
</form>

<div class="card">
  <table>
    <thead>
      <tr>
        <th>Nama</th>
        <th>Email</th>
        <th>Role</th>
        <th>Jurusan</th>
        <th>Kelas</th>
        <th>Phone</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($users as $user)
        <tr>
          <td style="font-weight:800;">
            <div style="display:flex;align-items:center;gap:.5rem;">
              <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#0ea5e9,#0284c7);display:flex;align-items:center;justify-content:center;color:#fff;font-size:.8rem;font-weight:900;flex-shrink:0;">
                {{ strtoupper(substr($user->name,0,1)) }}
              </div>
              {{ $user->name }}
            </div>
          </td>
          <td style="color:#64748b;font-size:.82rem;">{{ $user->email }}</td>
          <td><span class="r-{{ $user->role }}">{{ ucfirst($user->role) }}</span></td>
          <td style="color:#94a3b8;">{{ $user->jurusan ?? '-' }}</td>
          <td style="color:#94a3b8;">{{ $user->kelas ?? '-' }}</td>
          <td style="color:#94a3b8;font-size:.82rem;">{{ $user->phone ?? '-' }}</td>
          <td>
            <div style="display:flex;gap:.4rem;align-items:center;flex-wrap:wrap;">
              <a href="{{ route('admin.users.edit', $user) }}" class="btn-e">✏️ Edit</a>

              @if($user->phone)
                <a href="https://wa.me/62{{ ltrim($user->phone, '0') }}"
                   target="_blank"
                   class="btn-wa">💬 WA</a>
              @endif

              @if($user->id !== auth()->id())
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                      onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                  @csrf @method('DELETE')
                  <button class="btn-d">🗑️ Hapus</button>
                </form>
              @endif
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="7" style="text-align:center;padding:2.5rem;color:#94a3b8;font-weight:700;">
            🐱 Tidak ada user ditemukan.
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
  <div style="padding:1rem;">{{ $users->links() }}</div>
</div>
@endsection
