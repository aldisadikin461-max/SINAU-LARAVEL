@php $task = $task ?? null; @endphp

<style>
.sf-label  { display:block; font-family:'Nunito',sans-serif; font-size:.82rem; font-weight:800; color:#3d5a7a; margin-bottom:.4rem; }
.sf-input  { width:100%; background:#f4f8ff; border:2px solid #d0e4f7; border-radius:14px; padding:.65rem 1rem; font-size:.9rem; font-weight:600; color:#0d1f35; outline:none; font-family:'Nunito Sans',sans-serif; transition:all .18s; }
.sf-input:focus { border-color:#1a8cff; background:#fff; box-shadow:0 0 0 4px rgba(26,140,255,.1); }
.sf-group  { margin-bottom:1rem; }
.sf-err    { color:#ff4757; font-size:.78rem; font-weight:700; margin-top:.25rem; font-family:'Nunito',sans-serif; }
.sf-grid2  { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
@media(max-width:600px){ .sf-grid2{ grid-template-columns:1fr; } }
</style>

<div class="sf-group">
  <label class="sf-label">Judul Tugas</label>
  <input name="judul" type="text" value="{{ old('judul', $task?->judul) }}" placeholder="Judul tugas..." class="sf-input">
  @error('judul')<p class="sf-err">{{ $message }}</p>@enderror
</div>

<div class="sf-grid2">
  <div class="sf-group">
    <label class="sf-label">Mata Pelajaran</label>
    <input name="mapel" type="text" value="{{ old('mapel', $task?->mapel) }}" placeholder="Matematika..." class="sf-input">
    @error('mapel')<p class="sf-err">{{ $message }}</p>@enderror
  </div>
  <div class="sf-group">
    <label class="sf-label">Target Kelas</label>
    <select name="kelas" class="sf-input">
      @foreach(['X','XI','XII'] as $k)
        <option value="{{ $k }}" {{ old('kelas', $task?->kelas) === $k ? 'selected' : '' }}>Kelas {{ $k }}</option>
      @endforeach
    </select>
    @error('kelas')<p class="sf-err">{{ $message }}</p>@enderror
  </div>
  <div class="sf-group">
    <label class="sf-label">Deadline</label>
    <input name="deadline" type="datetime-local" value="{{ old('deadline', $task?->deadline?->format('Y-m-d\TH:i')) }}" class="sf-input">
    @error('deadline')<p class="sf-err">{{ $message }}</p>@enderror
  </div>
  <div class="sf-group">
    <label class="sf-label">Poin Reward</label>
    <input name="poin" type="number" min="0" value="{{ old('poin', $task?->poin ?? 10) }}" class="sf-input">
    @error('poin')<p class="sf-err">{{ $message }}</p>@enderror
  </div>
</div>

<div class="sf-group">
  <label class="sf-label">Deskripsi Tugas</label>
  <textarea name="deskripsi" rows="4" class="sf-input" style="resize:vertical;" placeholder="Instruksi tugas yang jelas...">{{ old('deskripsi', $task?->deskripsi) }}</textarea>
  @error('deskripsi')<p class="sf-err">{{ $message }}</p>@enderror
</div>

<div class="sf-group">
  <label class="sf-label">Lampiran <span style="color:#7b96b2;font-weight:600;">(opsional)</span></label>
  <input name="lampiran" type="file" class="sf-input" style="padding:.5rem;">
  @error('lampiran')<p class="sf-err">{{ $message }}</p>@enderror
</div>
