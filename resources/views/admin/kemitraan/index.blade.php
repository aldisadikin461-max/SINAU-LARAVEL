@extends('layouts.admin')

@section('title', 'Kelola Kemitraan — Admin Sinau')

@section('content')
<style>
  .mitra-admin-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.1rem;
  }
  @media (max-width: 600px) { .mitra-admin-grid { grid-template-columns: 1fr; } }

  .mitra-admin-card {
    background: #fff;
    border: 1.5px solid rgba(14,165,233,.12);
    border-radius: 1.25rem;
    padding: 1.25rem;
    display: flex;
    flex-direction: column;
    gap: .6rem;
    box-shadow: 0 2px 12px rgba(14,165,233,.06);
    transition: all .2s;
  }
  .mitra-admin-card:hover {
    box-shadow: 0 8px 24px rgba(14,165,233,.12);
    border-color: rgba(14,165,233,.25);
  }
  .mitra-admin-card-header {
    display: flex;
    align-items: center;
    gap: .75rem;
  }
  .mitra-admin-logo {
    width: 48px; height: 48px;
    border-radius: .75rem;
    object-fit: contain;
    border: 1.5px solid rgba(14,165,233,.1);
    padding: 3px;
    background: #f8fafc;
    flex-shrink: 0;
  }
  .mitra-admin-logo-fallback {
    width: 48px; height: 48px;
    border-radius: .75rem;
    background: linear-gradient(135deg, #0ea5e9, #0284c7);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem; flex-shrink: 0;
  }
  .mitra-admin-name {
    font-weight: 800;
    font-size: .95rem;
    color: #0f172a;
  }
  .mitra-admin-bidang {
    font-size: .78rem;
    font-weight: 700;
    color: #64748b;
  }
  .mitra-admin-lowongan {
    font-size: .78rem;
    color: #475569;
    font-weight: 600;
    background: #f8fafc;
    border-radius: .6rem;
    padding: .5rem .7rem;
    line-height: 1.5;
  }
  .mitra-admin-actions {
    display: flex;
    gap: .5rem;
    margin-top: .25rem;
  }
</style>

{{-- Header --}}
<div class="page-header">
  <div>
    <h1>🤝 Kelola Kemitraan</h1>
    <p style="color:#64748b;font-size:.9rem;font-weight:600;margin-top:.25rem;">
      {{ $mitra->total() }} mitra terdaftar
    </p>
  </div>
  <div style="display:flex;gap:.6rem;">
    <a href="{{ route('admin.alumni.index') }}" class="fbtn" style="background:#f1f5f9;color:#0284c7;box-shadow:none;border:2px solid rgba(14,165,233,.2);">
      👥 Alumni Kuliah
    </a>
    <a href="{{ route('admin.kemitraan.create') }}" class="fbtn">
      ➕ Tambah Mitra
    </a>
  </div>
</div>

@if(session('success'))
  <div class="salert-s">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="salert-e">⚠️ {{ session('error') }}</div>
@endif

@if($mitra->count() > 0)
<div class="mitra-admin-grid">
  @foreach($mitra as $m)
  <div class="mitra-admin-card">
    <div class="mitra-admin-card-header">
      @if($m->logo)
        <img src="{{ $m->logo_url }}" alt="{{ $m->nama }}" class="mitra-admin-logo"
             onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
        <div class="mitra-admin-logo-fallback" style="display:none;">🏢</div>
      @else
        <div class="mitra-admin-logo-fallback">🏢</div>
      @endif
      <div>
        <div class="mitra-admin-name">{{ $m->nama }}</div>
        <div class="mitra-admin-bidang">📌 {{ $m->bidang }}</div>
      </div>
    </div>

    @if($m->lowongan)
    <div class="mitra-admin-lowongan">
      💼 {{ Str::limit($m->lowongan, 100) }}
    </div>
    @endif

    @if($m->link_website)
      <div style="font-size:.78rem;font-weight:700;color:#0ea5e9;">
        🌐 <a href="{{ $m->link_website }}" target="_blank" style="color:#0ea5e9;">{{ $m->link_website }}</a>
      </div>
    @endif

    <div class="mitra-admin-actions">
      <a href="{{ route('admin.kemitraan.edit', $m->id) }}" class="fbtn"
         style="background:#f1f5f9;color:#0284c7;box-shadow:none;border:2px solid rgba(14,165,233,.2);padding:.3rem .85rem;font-size:.8rem;">
        ✏️ Edit
      </a>
      <form method="POST" action="{{ route('admin.kemitraan.destroy', $m->id) }}"
            onsubmit="return confirm('Hapus mitra {{ $m->nama }}?')">
        @csrf @method('DELETE')
        <button type="submit" class="fbtn"
                style="background:linear-gradient(135deg,#ef4444,#dc2626);box-shadow:0 2px 8px rgba(239,68,68,.25);padding:.3rem .85rem;font-size:.8rem;">
          🗑️ Hapus
        </button>
      </form>
    </div>
  </div>
  @endforeach
</div>

@if($mitra->hasPages())
  <div style="margin-top:1.25rem;">{{ $mitra->links() }}</div>
@endif

@else
<div style="text-align:center;padding:3rem 1rem;color:#94a3b8;">
  <div style="font-size:3rem;margin-bottom:.75rem;">🤝</div>
  <div style="font-weight:700;font-size:1rem;">Belum ada data kemitraan</div>
  <a href="{{ route('admin.kemitraan.create') }}" class="fbtn" style="margin-top:1rem;display:inline-flex;">
    ➕ Tambah Mitra Pertama
  </a>
</div>
@endif

@endsection