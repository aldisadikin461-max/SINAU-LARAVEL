@php $eb = $ebook ?? null; @endphp

<style>
.sf-label  { display:block; font-family:'Nunito',sans-serif; font-size:.82rem; font-weight:800; color:#3d5a7a; margin-bottom:.4rem; }
.sf-label .opt { font-weight:600; color:#7b96b2; }
.sf-input  { width:100%; background:#f4f8ff; border:2px solid #d0e4f7; border-radius:14px; padding:.65rem 1rem; font-size:.9rem; font-weight:600; color:#0d1f35; outline:none; font-family:'Nunito Sans',sans-serif; transition:all .18s; }
.sf-input:focus { border-color:#1a8cff; background:#fff; box-shadow:0 0 0 4px rgba(26,140,255,.1); }
.sf-group  { margin-bottom:1rem; }
.sf-err    { color:#ff4757; font-size:.78rem; font-weight:700; margin-top:.25rem; font-family:'Nunito',sans-serif; }
.sf-grid2  { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
@media(max-width:600px){ .sf-grid2{ grid-template-columns:1fr; } }
.size-badge { background:#e6f2ff; border:2px solid #bbd9ff; color:#0070e0; border-radius:8px; padding:.15rem .6rem; font-size:.72rem; font-weight:900; font-family:'Nunito',sans-serif; margin-left:6px; }
.file-area  { position:relative; background:#f4f8ff; border:2px dashed #bbd9ff; border-radius:14px; padding:1rem; cursor:pointer; display:flex; align-items:center; gap:.75rem; transition:all .18s; }
.file-area:hover { border-color:#1a8cff; background:#e6f2ff; }
.file-area.has-file { border-style:solid; border-color:#1a8cff; background:#e6f2ff; }
.file-area input[type="file"] { position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; }
.file-icon { font-size:22px; flex-shrink:0; }
.file-name { font-family:'Nunito',sans-serif; font-weight:800; font-size:.88rem; color:#0d1f35; }
.file-hint { font-size:.76rem; color:#7b96b2; font-weight:600; margin-top:2px; }
.existing-file { background:#e6f2ff; border:2px solid #bbd9ff; border-radius:12px; padding:.65rem 1rem; margin-bottom:.6rem; display:flex; align-items:center; gap:.6rem; font-family:'Nunito',sans-serif; font-size:.82rem; font-weight:700; color:#0070e0; }
</style>

{{-- Judul --}}
<div class="sf-group">
  <label class="sf-label">Judul E-Book *</label>
  <input name="judul" type="text"
    value="{{ old('judul', $eb?->judul) }}"
    placeholder="Contoh: Matematika Kelas XI Semester 1"
    class="sf-input {{ $errors->has('judul') ? 'border-red-400' : '' }}">
  @error('judul')<p class="sf-err">{{ $message }}</p>@enderror
</div>

{{-- Penulis --}}
<div class="sf-group">
  <label class="sf-label">Penulis *</label>
  <input name="penulis" type="text"
    value="{{ old('penulis', $eb?->penulis) }}"
    placeholder="Nama penulis / penerbit"
    class="sf-input">
  @error('penulis')<p class="sf-err">{{ $message }}</p>@enderror
</div>

<div class="sf-grid2">

  {{-- Kategori — pakai category_id sesuai controller --}}
  <div class="sf-group">
    <label class="sf-label">Kategori *</label>
    <select name="category_id" class="sf-input">
      <option value="">— Pilih Kategori —</option>
      @forelse($categories as $cat)
        <option value="{{ $cat->id }}"
          {{ old('category_id', $eb?->category_id) == $cat->id ? 'selected' : '' }}>
          {{ $cat->nama ?? $cat->name ?? $cat->kategori ?? 'Kategori #'.$cat->id }}
        </option>
      @empty
        <option value="" disabled>Belum ada kategori — tambah dulu di admin</option>
      @endforelse
    </select>
    @error('category_id')<p class="sf-err">{{ $message }}</p>@enderror
  </div>

  {{-- Jurusan --}}
  <div class="sf-group">
    <label class="sf-label">Jurusan <span class="opt">(opsional)</span></label>
    @php $selJur = old('jurusan', $eb?->jurusan ?? 'Umum') @endphp
    <select name="jurusan" class="sf-input">
      @foreach([
        'Umum'  => 'Semua Jurusan (Umum)',
        'PPLG'  => 'PPLG – Pengembangan Perangkat Lunak',
        'TKJ'   => 'TKJ – Teknik Komputer Jaringan',
        'DKV'   => 'DKV – Desain Komunikasi Visual',
        'MM'    => 'MM – Multimedia',
        'AKL'   => 'AKL – Akuntansi',
        'OTKP'  => 'OTKP – Otomatisasi Tata Kelola',
        'BDP'   => 'BDP – Bisnis Daring & Pemasaran',
      ] as $val => $lbl)
        <option value="{{ $val }}" {{ $selJur === $val ? 'selected' : '' }}>{{ $lbl }}</option>
      @endforeach
    </select>
    @error('jurusan')<p class="sf-err">{{ $message }}</p>@enderror
  </div>

</div>

{{-- File PDF --}}
<div class="sf-group">
  <label class="sf-label">
    File PDF {{ !$eb ? '*' : '' }}
    <span class="opt">{{ $eb ? '(kosongkan jika tidak diganti)' : '' }}</span>
    <span class="size-badge">Maks 100 MB</span>
  </label>

  @if($eb && $eb->file_path)
    <div class="existing-file">
      📄 File saat ini: <strong>{{ basename($eb->file_path) }}</strong>
    </div>
  @endif

  <div class="file-area" id="pdfArea">
    <input type="file" name="file" accept=".pdf" id="pdfInput"
      onchange="sinauFile('pdfInput','pdfArea','pdfName','pdfHint',100)">
    <span class="file-icon">📄</span>
    <div>
      <div class="file-name" id="pdfName">Klik untuk pilih file PDF</div>
      <div class="file-hint" id="pdfHint">Format: PDF · Maksimal 100 MB</div>
    </div>
  </div>
  @error('file')<p class="sf-err">{{ $message }}</p>@enderror
</div>

{{-- Cover --}}
<div class="sf-group">
  <label class="sf-label">Gambar Cover <span class="opt">(opsional)</span></label>

  @if($eb && $eb->cover)
    <div style="margin-bottom:.6rem;">
      <img src="{{ asset('storage/'.$eb->cover) }}" alt="cover"
        style="height:72px;border-radius:10px;border:2px solid #d0e4f7;">
    </div>
  @endif

  <div class="file-area" id="coverArea">
    <input type="file" name="cover" accept="image/jpeg,image/png,image/webp" id="coverInput"
      onchange="sinauFile('coverInput','coverArea','coverName','coverHint',2)">
    <span class="file-icon">🖼️</span>
    <div>
      <div class="file-name" id="coverName">Klik untuk pilih gambar cover</div>
      <div class="file-hint" id="coverHint">Format: JPG, PNG, WebP · Maks 2 MB</div>
    </div>
  </div>
  @error('cover')<p class="sf-err">{{ $message }}</p>@enderror
</div>

<script>
function sinauFile(inputId, areaId, nameId, hintId, maxMB) {
  const input  = document.getElementById(inputId);
  const area   = document.getElementById(areaId);
  const nameEl = document.getElementById(nameId);
  const hintEl = document.getElementById(hintId);
  if (!input.files[0]) return;
  const file   = input.files[0];
  const sizeMB = (file.size / 1024 / 1024).toFixed(1);
  if (file.size > maxMB * 1024 * 1024) {
    alert(`❌ File terlalu besar!\nMaksimal: ${maxMB} MB\nFile kamu: ${sizeMB} MB`);
    input.value = '';
    return;
  }
  area.classList.add('has-file');
  nameEl.textContent = file.name;
  hintEl.textContent = `${sizeMB} MB · Siap diupload ✓`;
  hintEl.style.color = '#1fa355';
}
</script>
