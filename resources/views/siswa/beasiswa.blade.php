@extends('layouts.siswa')
@section('title','Info Beasiswa')
@section('content')
<style>
  .page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:1.25rem;}
  .filter-row{display:flex;gap:.75rem;flex-wrap:wrap;margin-bottom:1.5rem;}
  .finput{background:#fff;border:2px solid rgba(14,165,233,.15);border-radius:999px;padding:.45rem 1.1rem;font-size:.88rem;font-weight:700;color:#1e293b;outline:none;font-family:'Nunito',sans-serif;}
  .finput:focus{border-color:#0ea5e9;}
  .fbtn{padding:.45rem 1.3rem;border-radius:999px;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;font-size:.88rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;}
  .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.25rem;}
  .bcard{background:#fff;border:1.5px solid rgba(14,165,233,.1);border-radius:1.25rem;padding:1.5rem;display:flex;flex-direction:column;gap:.75rem;box-shadow:0 4px 18px rgba(14,165,233,.07);transition:all .2s;}
  .bcard:hover{transform:translateY(-4px);box-shadow:0 14px 36px rgba(14,165,233,.13);}
  .bcard-head{display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;}
  .bcard-title{font-family:'Fredoka One',sans-serif;font-size:1.1rem;color:#0f172a;line-height:1.3;}
  .bmark{font-size:1.4rem;cursor:pointer;background:none;border:none;line-height:1;}
  .bcard-org{color:#94a3b8;font-size:.82rem;font-weight:700;}
  .bcard-desc{color:#64748b;font-size:.875rem;line-height:1.6;font-weight:600;}
  .bcard-tags{display:flex;gap:.4rem;flex-wrap:wrap;}
  .btag{display:inline-flex;padding:.2rem .7rem;border-radius:999px;font-size:.75rem;font-weight:800;font-family:'Nunito',sans-serif;}
  .btag-jenjang{background:#e0f2fe;color:#0284c7;}
  .btag-tipe{background:#f3e8ff;color:#7c3aed;}
  .status-buka{background:#dcfce7;color:#16a34a;border:1px solid #bbf7d0;border-radius:999px;padding:.15rem .65rem;font-size:.76rem;font-weight:800;}
  .status-tutup{background:#fee2e2;color:#dc2626;border:1px solid #fecaca;border-radius:999px;padding:.15rem .65rem;font-size:.76rem;font-weight:800;}
  .bdeadline{color:#94a3b8;font-size:.8rem;font-weight:700;}
  .blink{display:block;text-align:center;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;border-radius:999px;padding:.6rem;font-size:.88rem;font-weight:800;text-decoration:none;margin-top:auto;transition:all .2s;font-family:'Nunito',sans-serif;}
  .blink:hover{transform:translateY(-2px);box-shadow:0 6px 18px rgba(14,165,233,.3);}
  .empty-state{text-align:center;padding:4rem;color:#94a3b8;}
</style>
<div class="page-title">🎓 Info Beasiswa</div>
<form method="GET" class="filter-row">
  <select name="jenjang" class="finput">
    <option value="">Semua Jenjang</option>
    @foreach(['SMA','SMK','S1'] as $j)
      <option value="{{ $j }}" {{ request('jenjang')===$j?'selected':'' }}>{{ $j }}</option>
    @endforeach
  </select>
  <select name="status" class="finput">
    <option value="">Semua Status</option>
    <option value="buka" {{ request('status')==='buka'?'selected':'' }}>Buka</option>
    <option value="tutup" {{ request('status')==='tutup'?'selected':'' }}>Tutup</option>
  </select>
  <button type="submit" class="fbtn">Filter</button>
</form>
<div class="grid">
  @forelse($scholarships as $s)
    <div class="bcard">
      <div class="bcard-head">
        <div class="bcard-title">{{ $s->judul }}</div>
        <button class="bmark" onclick="toggleBookmark({{ $s->id }},this)" title="Bookmark">{{ in_array($s->id,$bookmarked)?'🔖':'🏷️' }}</button>
      </div>
      <div class="bcard-org">{{ $s->penyelenggara }}</div>
      @if($s->deskripsi)<div class="bcard-desc">{{ Str::limit($s->deskripsi,100) }}</div>@endif
      <div class="bcard-tags">
        <span class="btag btag-jenjang">{{ $s->jenjang }}</span>
        <span class="btag btag-tipe">{{ $s->tipe }}</span>
        <span class="status-{{ $s->status }}">{{ ucfirst($s->status) }}</span>
      </div>
      <div class="bdeadline">⏰ Deadline: {{ $s->deadline->format('d M Y') }}</div>
      <a href="{{ $s->link }}" target="_blank" class="blink">Daftar Sekarang →</a>
    </div>
  @empty
    <div class="empty-state" style="grid-column:1/-1;">
      <div style="font-size:3rem;margin-bottom:.75rem;">🐱</div>
      <p style="font-weight:700;">Kinners belum nemuin beasiswa yang sesuai filter kamu.</p>
    </div>
  @endforelse
</div>
<div style="margin-top:1.25rem;">{{ $scholarships->links() }}</div>
@endsection