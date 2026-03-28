@extends('layouts.admin')
@section('title','Kelola Beasiswa')
@section('content')

<style>
.page-title   { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.8rem; color:#0d1f35; letter-spacing:-0.5px; }
.top-row      { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem; margin-bottom:1.25rem; }
.filter-row   { display:flex; gap:.75rem; flex-wrap:wrap; margin-bottom:1.25rem; }
.finput       { background:#fff; border:2px solid #d0e4f7; border-radius:12px; padding:.45rem 1.1rem; font-size:.85rem; font-weight:700; color:#0d1f35; outline:none; font-family:'Nunito',sans-serif; transition:all .18s; }
.finput:focus { border-color:#1a8cff; box-shadow:0 0 0 3px rgba(26,140,255,.1); }
.fbtn         { padding:.48rem 1.3rem; border-radius:12px; background:#1a8cff; color:#fff; font-size:.85rem; font-weight:800; border:none; cursor:pointer; font-family:'Nunito',sans-serif; box-shadow:0 4px 0 #005bb8; transition:all .18s; }
.fbtn:hover   { transform:translateY(-1px); box-shadow:0 5px 0 #005bb8; }
.fbtn:active  { transform:translateY(2px); box-shadow:0 1px 0 #005bb8; }
.btn-new      { padding:.6rem 1.4rem; border-radius:14px; background:#1a8cff; color:#fff; font-size:.88rem; font-weight:900; text-decoration:none; font-family:'Nunito',sans-serif; box-shadow:0 5px 0 #005bb8; transition:all .18s; display:inline-flex; align-items:center; gap:.4rem; }
.btn-new:hover{ transform:translateY(-2px); box-shadow:0 7px 0 #005bb8; color:#fff; }

.card         { background:#fff; border:2px solid #d0e4f7; border-radius:1.25rem; overflow:hidden; box-shadow:0 4px 0 #d0e4f7; }
table         { width:100%; border-collapse:collapse; font-family:'Nunito',sans-serif; }
thead tr      { background:#e6f2ff; border-bottom:2px solid #d0e4f7; }
thead th      { padding:.8rem 1rem; text-align:left; font-size:.75rem; font-weight:900; color:#0070e0; text-transform:uppercase; letter-spacing:.06em; }
tbody tr      { border-bottom:1.5px solid #e6f2ff; transition:background .15s; }
tbody tr:last-child { border-bottom:none; }
tbody tr:hover{ background:#f4f8ff; }
tbody td      { padding:.8rem 1rem; font-size:.86rem; font-weight:600; color:#0d1f35; }

.status-buka  { background:#d6f5e6; color:#1fa355; border-radius:999px; padding:.2rem .75rem; font-size:.75rem; font-weight:900; font-family:'Nunito',sans-serif; }
.status-tutup { background:#ffe3e6; color:#ff4757; border-radius:999px; padding:.2rem .75rem; font-size:.75rem; font-weight:900; font-family:'Nunito',sans-serif; }
.chip         { background:#e6f2ff; color:#0070e0; border-radius:999px; padding:.2rem .75rem; font-size:.75rem; font-weight:900; font-family:'Nunito',sans-serif; }

.btn-e        { background:#e6f2ff; color:#0070e0; border-radius:10px; padding:.25rem .8rem; font-size:.76rem; font-weight:900; text-decoration:none; font-family:'Nunito',sans-serif; transition:all .15s; display:inline-block; }
.btn-e:hover  { background:#bbd9ff; color:#005bb8; }
.btn-d        { background:#ffe3e6; color:#ff4757; border-radius:10px; padding:.25rem .8rem; font-size:.76rem; font-weight:900; border:none; cursor:pointer; font-family:'Nunito',sans-serif; transition:all .15s; }
.btn-d:hover  { background:#ffb0b8; color:#cc0011; }

.action-cell  { display:flex; gap:.4rem; align-items:center; }
.empty-state  { text-align:center; padding:3rem 1rem; color:#7b96b2; font-weight:700; font-family:'Nunito',sans-serif; }
.empty-emoji  { font-size:2.5rem; display:block; margin-bottom:.5rem; }
.pagination-wrap { padding:1rem 1rem .75rem; }
</style>

<div class="top-row">
  <div class="page-title">🎓 Kelola Beasiswa</div>
  <a href="{{ route('admin.scholarships.create') }}" class="btn-new">+ Tambah Beasiswa</a>
</div>

<form method="GET" class="filter-row">
  <select name="jenjang" class="finput">
    <option value="">Semua Jenjang</option>
    @foreach(['SMA','SMK','S1'] as $j)
      <option value="{{ $j }}" {{ request('jenjang') === $j ? 'selected' : '' }}>{{ $j }}</option>
    @endforeach
  </select>

  <select name="status" class="finput">
    <option value="">Semua Status</option>
    <option value="buka"  {{ request('status') === 'buka'  ? 'selected' : '' }}>Buka</option>
    <option value="tutup" {{ request('status') === 'tutup' ? 'selected' : '' }}>Tutup</option>
  </select>

  <button type="submit" class="fbtn">🔍 Filter</button>
  @if(request()->hasAny(['jenjang','status']))
    <a href="{{ route('admin.scholarships.index') }}" class="fbtn" style="background:#7b96b2;box-shadow:0 4px 0 #4a6080;text-decoration:none;">Reset</a>
  @endif
</form>

<div class="card">
  <table>
    <thead>
      <tr>
        <th>Judul</th>
        <th>Penyelenggara</th>
        <th>Jenjang</th>
        <th>Deadline</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($scholarships as $s)
        <tr>
          <td style="font-weight:800;">{{ $s->judul }}</td>
          <td style="color:#7b96b2;">{{ $s->penyelenggara }}</td>
          <td><span class="chip">{{ $s->jenjang }}</span></td>
          <td style="color:#7b96b2;">{{ $s->deadline->format('d M Y') }}</td>
          <td><span class="status-{{ $s->status }}">{{ ucfirst($s->status) }}</span></td>
          <td>
            <div class="action-cell">
              <a href="{{ route('admin.scholarships.edit', $s) }}" class="btn-e">✏️ Edit</a>
              <form method="POST" action="{{ route('admin.scholarships.destroy', $s) }}" onsubmit="return confirm('Yakin hapus beasiswa ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-d">🗑️ Hapus</button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6">
            <div class="empty-state">
              <span class="empty-emoji">🎓</span>
              Belum ada data beasiswa.
            </div>
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>

  <div class="pagination-wrap">
    {{ $scholarships->links() }}
  </div>
</div>

@endsection
