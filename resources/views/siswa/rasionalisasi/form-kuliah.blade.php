@extends('layouts.siswa')
@section('title','Rasionalisasi Kuliah')
@section('content')
<style>
:root{--blue:#1a8cff;--blue-press:#005bb8;--blue-light:#e8f4ff;--border:#d0e4f7;}
.form-wrap{max-width:640px;margin:0 auto;}
.back{color:var(--blue);font-size:.88rem;font-weight:800;text-decoration:none;display:inline-flex;align-items:center;gap:.3rem;margin-bottom:1.25rem;}
.page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:.4rem;}
.page-sub{color:#64748b;font-weight:600;font-size:.9rem;margin-bottom:2rem;}
.fcard{background:#fff;border:2px solid var(--border);border-radius:1.5rem;padding:2rem;box-shadow:0 4px 0 var(--border);}
.sec-title{font-family:'Fredoka One',sans-serif;font-size:1.05rem;color:var(--blue);margin-bottom:.85rem;margin-top:1.25rem;display:flex;align-items:center;gap:.4rem;}
.sec-title:first-child{margin-top:0;}
label{display:block;font-size:.82rem;font-weight:800;color:#64748b;margin-bottom:.35rem;}
.fi{width:100%;background:#f8fafc;border:2px solid var(--border);border-radius:.875rem;padding:.65rem 1rem;font-size:.9rem;font-weight:700;color:#1e293b;outline:none;font-family:'Nunito',sans-serif;margin-bottom:.85rem;transition:border-color .2s;}
.fi:focus{border-color:var(--blue);background:#fff;}
.nilai-grid{display:grid;grid-template-columns:1fr 1fr;gap:.75rem 1rem;}
@media(max-width:500px){.nilai-grid{grid-template-columns:1fr;}}
.nilai-item{margin-bottom:0;}
.nilai-item label{margin-bottom:.25rem;}
.nilai-item .fi{margin-bottom:0;}
.nilai-hint{font-size:.72rem;color:#94a3b8;font-weight:600;margin-top:.2rem;}
.jurusan-sel{display:grid;grid-template-columns:repeat(auto-fill,minmax(110px,1fr));gap:.6rem;margin-bottom:1rem;}
.jurusan-opt{display:none;}
.jurusan-lbl{display:block;padding:.55rem .85rem;border-radius:.875rem;border:2px solid var(--border);background:#f8fafc;font-size:.85rem;font-weight:800;color:#475569;cursor:pointer;text-align:center;transition:all .18s;}
.jurusan-opt:checked+.jurusan-lbl{background:var(--blue);color:#fff;border-color:var(--blue);}
.err{color:#ef4444;font-size:.78rem;font-weight:700;margin-bottom:.5rem;}
.btn-submit{width:100%;padding:.85rem;border-radius:999px;background:var(--blue);color:#fff;font-family:'Fredoka One',sans-serif;font-size:1.1rem;border:none;cursor:pointer;box-shadow:0 5px 0 var(--blue-press);transition:all .15s;margin-top:.5rem;}
.btn-submit:hover{transform:translateY(2px);box-shadow:0 3px 0 var(--blue-press);}
.btn-submit:active{transform:translateY(5px);box-shadow:none;}
/* Loading overlay */
.loading-overlay{display:none;position:fixed;inset:0;background:rgba(255,255,255,.95);z-index:9999;flex-direction:column;align-items:center;justify-content:center;gap:1.5rem;}
.loading-overlay.show{display:flex;}
.spinner{width:56px;height:56px;border:5px solid var(--blue-light);border-top-color:var(--blue);border-radius:50%;animation:spin 1s linear infinite;}
@keyframes spin{to{transform:rotate(360deg)}}
.loading-txt{font-family:'Fredoka One',sans-serif;font-size:1.3rem;color:var(--blue);}
.loading-sub{font-size:.88rem;color:#94a3b8;font-weight:700;}
</style>

{{-- Loading Overlay --}}
<div class="loading-overlay" id="loading">
  <svg width="90" height="90" viewBox="0 0 120 120" fill="none" style="animation:float 2s ease-in-out infinite;">
    <circle cx="60" cy="68" r="44" fill="white" stroke="#7dd3fc" stroke-width="2"/>
    <path d="M28 46 L16 14 L50 38 Z" fill="white" stroke="#7dd3fc" stroke-width="1.8" stroke-linejoin="round"/>
    <path d="M89 43 L99 18 L73 36 Z" fill="#bae6fd"/>
    <ellipse cx="46" cy="64" rx="10" ry="11" fill="white" stroke="#7dd3fc" stroke-width="1.2"/>
    <ellipse cx="74" cy="64" rx="10" ry="11" fill="white" stroke="#7dd3fc" stroke-width="1.2"/>
    <circle cx="47" cy="65" r="6" fill="#0f172a"/>
    <circle cx="75" cy="65" r="6" fill="#0f172a"/>
    <circle cx="50" cy="62" r="2.5" fill="white"/>
    <circle cx="78" cy="62" r="2.5" fill="white"/>
    <ellipse cx="60" cy="78" rx="4" ry="3" fill="#7dd3fc"/>
    <path d="M52 85 Q60 93 68 85" stroke="#7dd3fc" stroke-width="2" fill="none" stroke-linecap="round"/>
  </svg>
  <div class="spinner"></div>
  <div class="loading-txt">Kinners sedang menganalisis...</div>
  <div class="loading-sub">AI sedang memproses data nilaimu, harap tunggu 15-30 detik</div>
</div>

<div class="form-wrap">
  <a href="{{ route('siswa.rasionalisasi.index') }}" class="back">← Kembali</a>
  <div class="page-title">🎓 Rasionalisasi Kuliah</div>
  <div class="page-sub">Isi nilai akademikmu untuk mendapatkan rekomendasi jurusan kuliah yang tepat.</div>

  @if($errors->any())
    <div style="background:#fee2e2;border:1.5px solid #fecaca;border-radius:1rem;padding:1rem;margin-bottom:1rem;">
      @foreach($errors->all() as $e)
        <p class="err" style="margin:0;">⚠️ {{ $e }}</p>
      @endforeach
    </div>
  @endif

  <div class="fcard">
    <form method="POST" action="{{ route('siswa.rasionalisasi.kuliah.proses') }}" id="form-kuliah">
      @csrf

      <div class="sec-title">🏫 Jurusan SMK</div>
      <label>Pilih jurusanmu *</label>
      <div class="jurusan-sel">
        @foreach($jurusanList as $j)
          <div>
            <input type="radio" name="jurusan" id="j{{ $j }}" value="{{ $j }}" class="jurusan-opt"
                   {{ old('jurusan')===$j?'checked':'' }}>
            <label for="j{{ $j }}" class="jurusan-lbl">{{ $j }}</label>
          </div>
        @endforeach
      </div>
      @error('jurusan')<p class="err">{{ $message }}</p>@enderror

      <div class="sec-title">📊 Nilai Mapel Umum</div>
      <p style="font-size:.82rem;color:#64748b;font-weight:600;margin-bottom:1rem;">Masukkan nilai raport semester terakhir (0-100)</p>
      <div class="nilai-grid">
        @foreach([
          ['nilai_b_inggris','B. Inggris','📖'],
          ['nilai_b_indonesia','B. Indonesia','📝'],
          ['nilai_matematika','Matematika','🔢'],
          ['nilai_sejarah','Sejarah','🏛️'],
          ['nilai_pancasila','Pendidikan Pancasila','🇮🇩'],
          ['nilai_b_jawa','Bahasa Jawa','🌿'],
        ] as [$name,$label,$ico])
          <div class="nilai-item">
            <label>{{ $ico }} {{ $label }}</label>
            <input type="number" name="{{ $name }}" value="{{ old($name) }}"
                   min="0" max="100" step="0.1" placeholder="0-100" class="fi">
            @error($name)<p class="err" style="font-size:.72rem;">{{ $message }}</p>@enderror
          </div>
        @endforeach
      </div>

      <div class="sec-title">🛠️ Nilai Produktif/Jurusan</div>
      <label>Rata-rata nilai mapel jurusan (produktif) *</label>
      <input type="number" name="nilai_produktif" value="{{ old('nilai_produktif') }}"
             min="0" max="100" step="0.1" placeholder="Contoh: 85.5" class="fi">
      <p class="nilai-hint">Rata-rata semua nilai mapel kejuruan/produktif di jurusanmu</p>
      @error('nilai_produktif')<p class="err">{{ $message }}</p>@enderror

      <button type="submit" class="btn-submit" onclick="showLoading()">
        🔍 Analisis dengan AI →
      </button>
    </form>
  </div>
</div>

@push('scripts')
<script>
function showLoading(){
  // Validasi sederhana sebelum loading
  const jurusan = document.querySelector('input[name=jurusan]:checked');
  if(!jurusan) return;
  document.getElementById('loading').classList.add('show');
}
</script>
@endpush
@endsection
