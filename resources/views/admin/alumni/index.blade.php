@extends('layouts.admin')

@section('title', 'Kelola Alumni — Admin Sinau')

@section('content')
<style>
  .import-box {
    background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
    border: 2px dashed rgba(14,165,233,.35);
    border-radius: 1.25rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
  }
  .import-box-title {
    font-family: 'Fredoka One', sans-serif;
    font-size: 1.1rem;
    color: #0284c7;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: .5rem;
  }
  .import-form-row {
    display: flex;
    gap: .75rem;
    align-items: center;
    flex-wrap: wrap;
  }
  .import-file-input {
    flex: 1;
    min-width: 200px;
    padding: .45rem .9rem;
    border: 2px solid rgba(14,165,233,.2);
    border-radius: .875rem;
    font-size: .88rem;
    font-weight: 700;
    font-family: 'Nunito', sans-serif;
    background: #fff;
    cursor: pointer;
  }
  .import-note {
    font-size: .78rem;
    color: #64748b;
    font-weight: 600;
    margin-top: .75rem;
    line-height: 1.6;
  }
  .import-note code {
    background: rgba(14,165,233,.1);
    color: #0284c7;
    padding: .1rem .4rem;
    border-radius: .3rem;
    font-weight: 700;
  }

  /* Tahun pills */
  .tahun-filter-row {
    display: flex;
    gap: .5rem;
    flex-wrap: wrap;
    margin-bottom: 1.25rem;
    align-items: center;
  }
  .tahun-filter-pill {
    padding: .3rem .9rem;
    border-radius: 999px;
    font-size: .82rem;
    font-weight: 800;
    text-decoration: none;
    border: 2px solid rgba(14,165,233,.2);
    color: #64748b;
    background: #fff;
    transition: all .18s;
  }
  .tahun-filter-pill:hover { border-color: #0ea5e9; color: #0ea5e9; }
  .tahun-filter-pill.active {
    background: linear-gradient(135deg, #0ea5e9, #0284c7);
    color: #fff;
    border-color: transparent;
  }

  /* Badge */
  .badge-snbp { background:#dcfce7;color:#15803d;border:1.5px solid #bbf7d0; }
  .badge-snbt { background:#dbeafe;color:#1d4ed8;border:1.5px solid #bfdbfe; }
  .badge-mandiri { background:#fef9c3;color:#a16207;border:1.5px solid #fef08a; }
  .badge-jalur {
    display:inline-flex;align-items:center;padding:.2rem .65rem;
    border-radius:999px;font-size:.72rem;font-weight:900;
  }

  .logo-mini {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    object-fit: contain;
    border: 1px solid rgba(14,165,233,.1);
    vertical-align: middle;
    margin-right: .3rem;
  }

  /* Bulk delete */
  .bulk-delete-form {
    display: inline;
  }
</style>

{{-- Header --}}
<div class="page-header">
  <div>
    <h1>👥 Kelola Alumni Kuliah</h1>
    <p style="color:#64748b;font-size:.9rem;font-weight:600;margin-top:.25rem;">
      Total: <strong>{{ $total }}</strong> data alumni
    </p>
  </div>
  <div style="display:flex;gap:.6rem;">
    <a href="{{ route('admin.alumni.template') }}" class="fbtn" style="background:#f1f5f9;color:#0284c7;box-shadow:none;border:2px solid rgba(14,165,233,.2);">
      📥 Download Template
    </a>
    <a href="{{ route('admin.kemitraan.index') }}" class="fbtn">
      🤝 Kelola Kemitraan
    </a>
  </div>
</div>

{{-- Alerts --}}
@if(session('success'))
  <div class="salert-s">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="salert-e">⚠️ {{ session('error') }}</div>
@endif

{{-- Import Box --}}
<div class="import-box">
  <div class="import-box-title">📤 Import Data Alumni (Excel / CSV)</div>
  <form action="{{ route('admin.alumni.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="import-form-row">
      <input type="file" name="file" class="import-file-input"
             accept=".xlsx,.xls,.csv" required>
      <button type="submit" class="fbtn">
        🚀 Upload & Import
      </button>
    </div>
    @error('file')
      <div style="color:#dc2626;font-size:.82rem;font-weight:700;margin-top:.5rem;">⚠️ {{ $message }}</div>
    @enderror
  </form>
  <div class="import-note">
    📋 Kolom Excel: <code>Nama</code> <code>Kampus</code> <code>Domain Kampus</code> <code>Jurusan</code> <code>Jalur</code> <code>Tahun Lulus</code><br>
    Jalur diisi: <code>SNBP</code> / <code>SNBT</code> / <code>Mandiri</code> • Domain contoh: <code>ui.ac.id</code> (untuk logo otomatis)
  </div>
</div>

{{-- Filter + Search --}}
<div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.75rem;margin-bottom:1rem;">
  <div class="tahun-filter-row" style="margin-bottom:0;">
    <span style="font-size:.8rem;font-weight:800;color:#94a3b8;">TAHUN:</span>
    <a href="{{ route('admin.alumni.index') }}"
       class="tahun-filter-pill {{ !$tahun ? 'active' : '' }}">Semua</a>
    @foreach($tahunList as $t)
      <a href="{{ route('admin.alumni.index', ['tahun' => $t]) }}"
         class="tahun-filter-pill {{ $tahun == $t ? 'active' : '' }}">{{ $t }}</a>
    @endforeach
  </div>

  <form method="GET" action="{{ route('admin.alumni.index') }}" style="display:flex;gap:.5rem;">
    @if($tahun) <input type="hidden" name="tahun" value="{{ $tahun }}"> @endif
    <input type="text" name="search" value="{{ $search }}"
           placeholder="Cari nama / kampus..."
           class="finput" style="width:220px;">
    <button type="submit" class="fbtn">🔍</button>
  </form>
</div>

{{-- Bulk delete per tahun --}}
@if($tahun && $alumni->total() > 0)
<div style="margin-bottom:1rem;">
  <form method="POST" action="{{ route('admin.alumni.destroy-tahun') }}"
        onsubmit="return confirm('Hapus SEMUA {{ $alumni->total() }} data alumni tahun {{ $tahun }}? Tidak bisa dikembalikan!')">
    @csrf @method('DELETE')
    <input type="hidden" name="tahun" value="{{ $tahun }}">
    <button type="submit" class="fbtn" style="background:linear-gradient(135deg,#ef4444,#dc2626);box-shadow:0 3px 12px rgba(239,68,68,.3);">
      🗑️ Hapus Semua Data Tahun {{ $tahun }} ({{ $alumni->total() }})
    </button>
  </form>
</div>
@endif

{{-- Tabel --}}
<div class="card" style="padding:0;overflow:hidden;">
  <div style="overflow-x:auto;">
    <table class="sinau-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Nama</th>
          <th>Kampus</th>
          <th>Jurusan</th>
          <th>Jalur</th>
          <th>Tahun</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($alumni as $a)
        <tr>
          <td style="color:#94a3b8;font-size:.8rem;">{{ $alumni->firstItem() + $loop->index }}</td>
          <td style="font-weight:800;">{{ $a->nama }}</td>
          <td>
            @if($a->domain_kampus)
              <img src="{{ $a->logo_url }}"
                   class="logo-mini"
                   onerror="this.style.display='none'">
            @endif
            {{ $a->kampus }}
          </td>
          <td style="color:#475569;">{{ $a->jurusan }}</td>
          <td>
            @php
              $bc = match($a->jalur) {
                'SNBP'=>'badge-snbp','SNBT'=>'badge-snbt','Mandiri'=>'badge-mandiri',default=>'badge-snbp'
              };
            @endphp
            <span class="badge-jalur {{ $bc }}">{{ $a->jalur }}</span>
          </td>
          <td style="font-weight:800;color:#0ea5e9;">{{ $a->tahun_lulus }}</td>
          <td>
            <form method="POST" action="{{ route('admin.alumni.destroy', $a->id) }}"
                  onsubmit="return confirm('Hapus data {{ $a->nama }}?')">
              @csrf @method('DELETE')
              <button type="submit" class="fbtn"
                      style="background:linear-gradient(135deg,#ef4444,#dc2626);box-shadow:0 2px 8px rgba(239,68,68,.25);padding:.3rem .8rem;font-size:.78rem;">
                🗑️
              </button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" style="text-align:center;padding:2.5rem;color:#94a3b8;font-weight:700;">
            📭 Belum ada data alumni{{ $tahun ? ' untuk tahun ' . $tahun : '' }}
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- Pagination --}}
@if($alumni->hasPages())
<div style="margin-top:1.25rem;">
  {{ $alumni->links() }}
</div>
@endif

@endsection