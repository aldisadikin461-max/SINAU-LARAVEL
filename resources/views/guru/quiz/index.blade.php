@extends('layouts.guru')
@section('title','Paket Soal')
@section('content')
<style>
.page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:1.25rem;}
.top-row{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.25rem;}
.btn-new{padding:.55rem 1.4rem;border-radius:999px;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;font-size:.88rem;font-weight:800;text-decoration:none;box-shadow:0 4px 14px rgba(14,165,233,.3);}
.card{background:#fff;border:1.5px solid rgba(14,165,233,.1);border-radius:1.25rem;overflow:hidden;box-shadow:0 4px 18px rgba(14,165,233,.07);}
table{width:100%;border-collapse:collapse;font-family:'Nunito',sans-serif;}
thead tr{background:#f0f9ff;border-bottom:2px solid rgba(14,165,233,.1);}
thead th{padding:.8rem 1rem;text-align:left;font-size:.78rem;font-weight:800;color:#0284c7;text-transform:uppercase;letter-spacing:.04em;}
tbody tr{border-bottom:1px solid rgba(14,165,233,.06);transition:background .15s;}
tbody tr:hover{background:#f0f9ff;}
tbody td{padding:.85rem 1rem;font-size:.86rem;font-weight:700;}
.s-draft{background:#fef9c3;color:#ca8a04;border-radius:999px;padding:.18rem .65rem;font-size:.74rem;font-weight:800;}
.s-published{background:#dcfce7;color:#16a34a;border-radius:999px;padding:.18rem .65rem;font-size:.74rem;font-weight:800;}
.btn-e{background:#e0f2fe;color:#0284c7;border-radius:999px;padding:.22rem .75rem;font-size:.76rem;font-weight:800;text-decoration:none;display:inline-block;}
.btn-d{background:#fee2e2;color:#dc2626;border-radius:999px;padding:.22rem .75rem;font-size:.76rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;}
.salert{background:#dcfce7;border:1px solid #bbf7d0;color:#16a34a;border-radius:1rem;padding:.875rem 1.25rem;margin-bottom:1.25rem;font-weight:700;font-size:.9rem;}
</style>

@if(session('success'))<div class="salert">✅ {{ session('success') }}</div>@endif

<div class="top-row">
  <div class="page-title">📦 Paket Soal</div>
  <a href="{{ route('guru.quiz.create') }}" class="btn-new">+ Buat Paket Baru</a>
</div>

<div class="card">
  <table>
    <thead>
      <tr>
        <th>Nama Paket</th>
        <th>Kelas</th>
        <th>Jumlah Soal</th>
        <th>Status</th>
        <th>Dibuat</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($packets as $p)
        <tr>
          <td style="font-weight:800;">{{ $p->nama }}</td>
          <td style="color:#64748b;">{{ $p->kelas ?? '-' }} {{ $p->jurusan ? '· '.$p->jurusan : '' }}</td>
          <td><span style="color:#0284c7;font-weight:800;">{{ $p->questions_count }}</span> soal</td>
          <td><span class="s-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
          <td style="color:#94a3b8;font-size:.8rem;">{{ $p->created_at->format('d M Y') }}</td>
          <td>
            <div style="display:flex;gap:.4rem;align-items:center;">
              <a href="{{ route('guru.quiz.show', $p) }}" class="btn-e">📋 Detail</a>
              <a href="{{ route('guru.quiz.edit', $p) }}" class="btn-e">✏️ Edit</a>
              <form method="POST" action="{{ route('guru.quiz.destroy', $p) }}"
                    onsubmit="return confirm('Hapus paket {{ $p->nama }}?')">
                @csrf @method('DELETE')
                <button class="btn-d">🗑️</button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" style="text-align:center;padding:2.5rem;color:#94a3b8;font-weight:700;">
            📦 Belum ada paket soal. Buat paket pertamamu!
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
  <div style="padding:1rem;">{{ $packets->links() }}</div>
</div>
@endsection