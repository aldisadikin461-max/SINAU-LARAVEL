@extends('layouts.guru')
@section('title','Kelola Tugas')
@section('content')
<style>
.page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;}
.top-row{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.25rem;}
.btn-new{padding:.55rem 1.4rem;border-radius:999px;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;font-size:.88rem;font-weight:800;text-decoration:none;box-shadow:0 4px 14px rgba(14,165,233,.3);}
.card{background:#fff;border:1.5px solid rgba(14,165,233,.1);border-radius:1.25rem;overflow:hidden;box-shadow:0 4px 18px rgba(14,165,233,.07);}
table{width:100%;border-collapse:collapse;font-family:'Nunito',sans-serif;}
thead tr{background:#f0f9ff;border-bottom:2px solid rgba(14,165,233,.1);}
thead th{padding:.8rem 1rem;text-align:left;font-size:.78rem;font-weight:800;color:#0284c7;text-transform:uppercase;letter-spacing:.04em;}
tbody tr{border-bottom:1px solid rgba(14,165,233,.06);transition:background .15s;}
tbody tr:hover{background:#f0f9ff;}
tbody td{padding:.8rem 1rem;font-size:.86rem;font-weight:700;}
.sa{background:#dcfce7;color:#16a34a;border-radius:999px;padding:.18rem .65rem;font-size:.75rem;font-weight:800;}
.sl{background:#fee2e2;color:#dc2626;border-radius:999px;padding:.18rem .65rem;font-size:.75rem;font-weight:800;}
.lt{color:#dc2626;}
.btn-e{background:#e0f2fe;color:#0284c7;border-radius:999px;padding:.22rem .75rem;font-size:.76rem;font-weight:800;text-decoration:none;display:inline-block;}
.btn-d{background:#fee2e2;color:#dc2626;border-radius:999px;padding:.22rem .75rem;font-size:.76rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;}
</style>
<div class="top-row">
  <div class="page-title">Kelola Tugas 📝</div>
  <a href="{{ route('guru.tasks.create') }}" class="btn-new">+ Assign Tugas Baru</a>
</div>
<div class="card">
  <table>
    <thead><tr><th>Judul Tugas</th><th>Jurusan</th><th>Kelas</th><th>Deadline</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
      @forelse($tasks as $task)
        @php $late=$task->deadline->isPast(); @endphp
        <tr>
          <td style="font-weight:800;">{{ $task->judul }}</td>
          <td style="color:#94a3b8;">{{ $task->jurusan??'Semua Jurusan' }}</td>
          <td style="color:#94a3b8;">{{ $task->kelas??'Semua Kelas' }}</td>
          <td class="{{ $late?'lt':'' }}">{{ $task->deadline->format('d M Y H:i') }}@if($late) ⚠️@endif</td>
          <td><span class="{{ $late?'sl':'sa' }}">{{ $late?'Lewat':'Aktif' }}</span></td>
          <td style="display:flex;gap:.4rem;align-items:center;">
            <a href="{{ route('guru.tasks.edit',$task) }}" class="btn-e">✏️ Edit</a>
            <form method="POST" action="{{ route('guru.tasks.destroy',$task) }}" onsubmit="return confirm('Hapus tugas ini?')">
              @csrf @method('DELETE')
              <button class="btn-d">🗑️ Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" style="text-align:center;padding:2rem;color:#94a3b8;font-weight:700;">Belum ada tugas. Assign yang pertama! 📋</td></tr>
      @endforelse
    </tbody>
  </table>
  <div style="padding:1rem;">{{ $tasks->links() }}</div>
</div>
@endsection
