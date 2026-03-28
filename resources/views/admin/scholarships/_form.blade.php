@php $s = $scholarship ?? null; @endphp

<style>
.sf-label    { display:block; font-family:'Nunito',sans-serif; font-size:.82rem; font-weight:800; color:#3d5a7a; margin-bottom:.4rem; }
.sf-input    { width:100%; background:#f4f8ff; border:2px solid #d0e4f7; border-radius:14px; padding:.65rem 1rem; font-size:.9rem; font-weight:600; color:#0d1f35; outline:none; font-family:'Nunito Sans',sans-serif; transition:all .18s; }
.sf-input:focus { border-color:#1a8cff; background:#fff; box-shadow:0 0 0 4px rgba(26,140,255,.1); }
.sf-err      { color:#ff4757; font-size:.78rem; font-weight:700; margin-top:.25rem; font-family:'Nunito',sans-serif; }
.sf-group    { margin-bottom:1rem; }
.sf-grid2    { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
@media(max-width:600px){ .sf-grid2{ grid-template-columns:1fr; } }
</style>

{{-- Judul --}}
<div class="sf-group">
  <label class="sf-label">Judul Beasiswa</label>
  <input name="judul" type="text" value="{{ old('judul', $s?->judul) }}" placeholder="Nama beasiswa..." class="sf-input">
  @error('judul')<p class="sf-err">{{ $message }}</p>@enderror
</div>

<div class="sf-grid2">

  {{-- Penyelenggara --}}
  <div class="sf-group">
    <label class="sf-label">Penyelenggara</label>
    <input name="penyelenggara" type="text" value="{{ old('penyelenggara', $s?->penyelenggara) }}" placeholder="Nama lembaga..." class="sf-input">
    @error('penyelenggara')<p class="sf-err">{{ $message }}</p>@enderror
  </div>

  {{-- Tipe --}}
  <div class="sf-group">
    <label class="sf-label">Tipe</label>
    <input name="tipe" type="text" value="{{ old('tipe', $s?->tipe) }}" placeholder="Beasiswa Penuh / Parsial" class="sf-input">
    @error('tipe')<p class="sf-err">{{ $message }}</p>@enderror
  </div>

  {{-- Jenjang --}}
  <div class="sf-group">
    <label class="sf-label">Jenjang</label>
    <select name="jenjang" class="sf-input">
      @foreach(['SMA','SMK','S1'] as $j)
        <option value="{{ $j }}" {{ old('jenjang', $s?->jenjang) === $j ? 'selected' : '' }}>{{ $j }}</option>
      @endforeach
    </select>
    @error('jenjang')<p class="sf-err">{{ $message }}</p>@enderror
  </div>

  {{-- Status --}}
  <div class="sf-group">
    <label class="sf-label">Status</label>
    <select name="status" class="sf-input">
      <option value="buka"  {{ old('status', $s?->status) === 'buka'  ? 'selected' : '' }}>Buka</option>
      <option value="tutup" {{ old('status', $s?->status) === 'tutup' ? 'selected' : '' }}>Tutup</option>
    </select>
    @error('status')<p class="sf-err">{{ $message }}</p>@enderror
  </div>

  {{-- Deadline --}}
  <div class="sf-group">
    <label class="sf-label">Deadline</label>
    <input name="deadline" type="date" value="{{ old('deadline', $s?->deadline?->format('Y-m-d')) }}" class="sf-input">
    @error('deadline')<p class="sf-err">{{ $message }}</p>@enderror
  </div>

  {{-- Link --}}
  <div class="sf-group">
    <label class="sf-label">Link Pendaftaran</label>
    <input name="link" type="url" value="{{ old('link', $s?->link) }}" placeholder="https://..." class="sf-input">
    @error('link')<p class="sf-err">{{ $message }}</p>@enderror
  </div>

</div>

{{-- Deskripsi --}}
<div class="sf-group">
  <label class="sf-label">Deskripsi <span style="font-weight:600;color:#7b96b2;">(opsional)</span></label>
  <textarea name="deskripsi" rows="4" class="sf-input" style="resize:vertical;">{{ old('deskripsi', $s?->deskripsi) }}</textarea>
  @error('deskripsi')<p class="sf-err">{{ $message }}</p>@enderror
</div>
