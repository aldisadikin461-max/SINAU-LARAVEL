<style>
  .form-card {
    max-width: 640px;
  }
  .form-group {
    margin-bottom: 1.1rem;
  }
  .form-label {
    display: block;
    font-size: .85rem;
    font-weight: 800;
    color: #374151;
    margin-bottom: .4rem;
  }
  .form-label span {
    color: #ef4444;
  }
  .form-input {
    width: 100%;
    background: #fff;
    border: 2px solid rgba(14,165,233,.15);
    border-radius: .875rem;
    padding: .5rem 1rem;
    font-size: .9rem;
    font-weight: 700;
    color: #1e293b;
    outline: none;
    font-family: 'Nunito', sans-serif;
    transition: border-color .2s;
  }
  .form-input:focus {
    border-color: #0ea5e9;
    box-shadow: 0 0 0 3px rgba(14,165,233,.1);
  }
  .form-textarea {
    resize: vertical;
    min-height: 90px;
  }
  .form-error {
    color: #dc2626;
    font-size: .78rem;
    font-weight: 700;
    margin-top: .3rem;
  }

  .logo-preview-wrap {
    margin-top: .6rem;
    display: flex;
    align-items: center;
    gap: .75rem;
  }
  .logo-preview {
    width: 60px;
    height: 60px;
    border-radius: .875rem;
    object-fit: contain;
    border: 2px solid rgba(14,165,233,.15);
    padding: 4px;
    background: #f8fafc;
  }
  .logo-current-label {
    font-size: .78rem;
    font-weight: 700;
    color: #64748b;
  }
</style>

{{-- Header --}}
<div class="page-header">
  <div>
    <h1>{{ $title }}</h1>
  </div>
  <a href="{{ route('admin.kemitraan.index') }}" class="fbtn"
     style="background:#f1f5f9;color:#64748b;box-shadow:none;">
    ← Kembali
  </a>
</div>

@if(session('success'))
  <div class="salert-s">✅ {{ session('success') }}</div>
@endif

<div class="card form-card">
  <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @if($method === 'PUT') @method('PUT') @endif

    {{-- Nama --}}
    <div class="form-group">
      <label class="form-label">Nama Mitra <span>*</span></label>
      <input type="text" name="nama" value="{{ old('nama', $mitra?->nama) }}"
             class="form-input" placeholder="Contoh: PT Telkom Indonesia" required>
      @error('nama') <div class="form-error">{{ $message }}</div> @enderror
    </div>

    {{-- Bidang --}}
    <div class="form-group">
      <label class="form-label">Bidang Kerja Sama <span>*</span></label>
      <input type="text" name="bidang" value="{{ old('bidang', $mitra?->bidang) }}"
             class="form-input" placeholder="Contoh: Teknologi Informasi, Manufaktur" required>
      @error('bidang') <div class="form-error">{{ $message }}</div> @enderror
    </div>

    {{-- Logo --}}
    <div class="form-group">
      <label class="form-label">Logo Mitra
        <span style="color:#94a3b8;font-weight:600;">(jpg, png, webp • maks 2MB)</span>
      </label>
      <input type="file" name="logo" class="form-input" accept="image/*"
             onchange="previewLogo(this)">
      @error('logo') <div class="form-error">{{ $message }}</div> @enderror

      {{-- Preview logo lama --}}
      @if($mitra?->logo)
      <div class="logo-preview-wrap">
        <img src="{{ $mitra->logo_url }}" class="logo-preview" id="logo-preview-img" alt="Logo saat ini">
        <span class="logo-current-label">Logo saat ini (upload baru untuk mengganti)</span>
      </div>
      @else
      <div class="logo-preview-wrap" style="display:none;" id="logo-preview-wrap">
        <img src="" class="logo-preview" id="logo-preview-img" alt="Preview">
        <span class="logo-current-label">Preview</span>
      </div>
      @endif
    </div>

    {{-- Link Website --}}
    <div class="form-group">
      <label class="form-label">Link Website</label>
      <input type="url" name="link_website" value="{{ old('link_website', $mitra?->link_website) }}"
             class="form-input" placeholder="https://www.contoh.com">
      @error('link_website') <div class="form-error">{{ $message }}</div> @enderror
    </div>

    {{-- Lowongan --}}
    <div class="form-group">
      <label class="form-label">Deskripsi Lowongan
        <span style="color:#94a3b8;font-weight:600;">(opsional)</span>
      </label>
      <textarea name="lowongan" class="form-input form-textarea"
                placeholder="Contoh: Membuka lowongan magang untuk jurusan RPL, TKJ, minimal kelas XI...">{{ old('lowongan', $mitra?->lowongan) }}</textarea>
      @error('lowongan') <div class="form-error">{{ $message }}</div> @enderror
    </div>

    {{-- Link Lowongan --}}
    <div class="form-group">
      <label class="form-label">Link Apply Lowongan
        <span style="color:#94a3b8;font-weight:600;">(opsional — siswa akan redirect ke sini)</span>
      </label>
      <input type="url" name="link_lowongan" value="{{ old('link_lowongan', $mitra?->link_lowongan) }}"
             class="form-input" placeholder="https://careers.contoh.com/apply">
      @error('link_lowongan') <div class="form-error">{{ $message }}</div> @enderror
    </div>

    {{-- Submit --}}
    <div style="display:flex;gap:.75rem;margin-top:1.5rem;">
      <button type="submit" class="fbtn">
        {{ $mitra ? '💾 Simpan Perubahan' : '➕ Tambah Mitra' }}
      </button>
      <a href="{{ route('admin.kemitraan.index') }}"
         class="fbtn" style="background:#f1f5f9;color:#64748b;box-shadow:none;">
        Batal
      </a>
    </div>

  </form>
</div>

@push('scripts')
<script>
function previewLogo(input) {
  const wrap = document.getElementById('logo-preview-wrap');
  const img  = document.getElementById('logo-preview-img');
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => {
      img.src = e.target.result;
      if (wrap) wrap.style.display = 'flex';
    };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
@endpush