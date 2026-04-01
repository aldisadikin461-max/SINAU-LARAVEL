@extends('layouts.siswa')
@section('title','Rasionalisasi Karir')
@section('content')
<style>
:root{--blue:#1a8cff;--blue-press:#005bb8;--border:#d0e4f7;--orange:#f59e0b;--orange-press:#b45309;}
.form-wrap{max-width:640px;margin:0 auto;}
.back{color:var(--blue);font-size:.88rem;font-weight:800;text-decoration:none;display:inline-flex;align-items:center;gap:.3rem;margin-bottom:1.25rem;}
.page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:.4rem;}
.page-sub{color:#64748b;font-weight:600;font-size:.9rem;margin-bottom:2rem;}
.fcard{background:#fff;border:2px solid var(--border);border-radius:1.5rem;padding:2rem;box-shadow:0 4px 0 var(--border);}
.sec-title{font-family:'Fredoka One',sans-serif;font-size:1.05rem;color:var(--orange);margin-bottom:.85rem;margin-top:1.25rem;display:flex;align-items:center;gap:.4rem;}
.sec-title:first-child{margin-top:0;}
label{display:block;font-size:.82rem;font-weight:800;color:#64748b;margin-bottom:.35rem;}
.jurusan-sel{display:grid;grid-template-columns:repeat(auto-fill,minmax(110px,1fr));gap:.6rem;margin-bottom:1rem;}
.jurusan-opt{display:none;}
.jurusan-lbl{display:block;padding:.55rem .85rem;border-radius:.875rem;border:2px solid var(--border);background:#f8fafc;font-size:.85rem;font-weight:800;color:#475569;cursor:pointer;text-align:center;transition:all .18s;}
.jurusan-opt:checked+.jurusan-lbl{background:var(--orange);color:#fff;border-color:var(--orange);}
/* Skill multi-select */
.skill-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:.5rem;margin-bottom:1rem;}
.skill-opt{display:none;}
.skill-lbl{display:flex;align-items:center;gap:.4rem;padding:.45rem .75rem;border-radius:.875rem;border:2px solid var(--border);background:#f8fafc;font-size:.82rem;font-weight:700;color:#475569;cursor:pointer;transition:all .18s;}
.skill-opt:checked+.skill-lbl{background:#dcfce7;color:#16a34a;border-color:#22c55e;}
.skill-count{font-size:.78rem;color:#94a3b8;font-weight:700;margin-bottom:.75rem;}
/* Minat */
.minat-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(130px,1fr));gap:.6rem;margin-bottom:1rem;}
.minat-opt{display:none;}
.minat-lbl{display:block;padding:.65rem .75rem;border-radius:.875rem;border:2px solid var(--border);background:#f8fafc;font-size:.85rem;font-weight:800;color:#475569;cursor:pointer;text-align:center;transition:all .18s;}
.minat-opt:checked+.minat-lbl{background:var(--blue);color:#fff;border-color:var(--blue);}
.err{color:#ef4444;font-size:.78rem;font-weight:700;margin-bottom:.5rem;}
.btn-submit{width:100%;padding:.85rem;border-radius:999px;background:var(--orange);color:#fff;font-family:'Fredoka One',sans-serif;font-size:1.1rem;border:none;cursor:pointer;box-shadow:0 5px 0 var(--orange-press);transition:all .15s;margin-top:.5rem;}
.btn-submit:hover{transform:translateY(2px);box-shadow:0 3px 0 var(--orange-press);}
.loading-overlay{display:none;position:fixed;inset:0;background:rgba(255,255,255,.95);z-index:9999;flex-direction:column;align-items:center;justify-content:center;gap:1.5rem;}
.loading-overlay.show{display:flex;}
.spinner{width:56px;height:56px;border:5px solid #fef9c3;border-top-color:var(--orange);border-radius:50%;animation:spin 1s linear infinite;}
@keyframes spin{to{transform:rotate(360deg)}}
.loading-txt{font-family:'Fredoka One',sans-serif;font-size:1.3rem;color:var(--orange);}
.loading-sub{font-size:.88rem;color:#94a3b8;font-weight:700;}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
</style>

<div class="loading-overlay" id="loading">
  <svg width="90" height="90" viewBox="0 0 120 120" fill="none" style="animation:float 2s ease-in-out infinite;">
    <circle cx="60" cy="68" r="44" fill="white" stroke="#7dd3fc" stroke-width="2"/>
    <path d="M28 46 L16 14 L50 38 Z" fill="white" stroke="#7dd3fc" stroke-width="1.8" stroke-linejoin="round"/>
    <path d="M89 43 L99 18 L73 36 Z" fill="#bae6fd"/>
    <ellipse cx="46" cy="64" rx="10" ry="11" fill="white" stroke="#7dd3fc" stroke-width="1.2"/>
    <ellipse cx="74" cy="64" rx="10" ry="11" fill="white" stroke="#7dd3fc" stroke-width="1.2"/>
    <circle cx="47" cy="65" r="6" fill="#0f172a"/>
    <circle cx="75" cy="65" r="6" fill="#0f172a"/>
    <ellipse cx="60" cy="78" rx="4" ry="3" fill="#7dd3fc"/>
    <path d="M52 85 Q60 93 68 85" stroke="#7dd3fc" stroke-width="2" fill="none" stroke-linecap="round"/>
  </svg>
  <div class="spinner"></div>
  <div class="loading-txt">Kinners sedang menganalisis...</div>
  <div class="loading-sub">AI sedang memproses data karirmu, harap tunggu 15-30 detik</div>
</div>

<div class="form-wrap">
  <a href="{{ route('siswa.rasionalisasi.index') }}" class="back">← Kembali</a>
  <div class="page-title">💼 Rasionalisasi Karir</div>
  <div class="page-sub">Pilih jurusan, skill, dan minat kerjamu untuk mendapatkan rekomendasi karir terbaik.</div>

  @if($errors->any())
    <div style="background:#fee2e2;border:1.5px solid #fecaca;border-radius:1rem;padding:1rem;margin-bottom:1rem;">
      @foreach($errors->all() as $e)
        <p class="err" style="margin:0;">⚠️ {{ $e }}</p>
      @endforeach
    </div>
  @endif

  <div class="fcard">
    <form method="POST" action="{{ route('siswa.rasionalisasi.kerja.proses') }}" id="form-kerja">
      @csrf

      <div class="sec-title">🏫 Jurusan SMK</div>
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

      <div class="sec-title">🛠️ Skill yang Dikuasai</div>
      <div class="skill-count" id="skill-count">0 skill dipilih (pilih minimal 1)</div>
      <div class="skill-grid">
        @foreach($skillList as $skill)
          <div>
            <input type="checkbox" name="skills[]" id="sk{{ $loop->index }}" value="{{ $skill }}"
                   class="skill-opt" {{ in_array($skill, old('skills',[])) ?'checked':'' }}
                   onchange="updateSkillCount()">
            <label for="sk{{ $loop->index }}" class="skill-lbl">✓ {{ $skill }}</label>
          </div>
        @endforeach
      </div>
      @error('skills')<p class="err">{{ $message }}</p>@enderror

      <div class="sec-title">🎯 Minat Kerja</div>
      <div class="minat-grid">
        @foreach(['Industri'=>'🏭','Startup'=>'🚀','Pemerintah'=>'🏛️','Wirausaha'=>'💡','Freelance'=>'🌐'] as $minat=>$ico)
          <div>
            <input type="radio" name="minat" id="m{{ $minat }}" value="{{ $minat }}" class="minat-opt"
                   {{ old('minat')===$minat?'checked':'' }}>
            <label for="m{{ $minat }}" class="minat-lbl">{{ $ico }}<br>{{ $minat }}</label>
          </div>
        @endforeach
      </div>
      @error('minat')<p class="err">{{ $message }}</p>@enderror

      <button type="submit" class="btn-submit" onclick="showLoading()">
        🔍 Analisis dengan AI →
      </button>
    </form>
  </div>
</div>

@push('scripts')
<script>
function updateSkillCount(){
  const c = document.querySelectorAll('.skill-opt:checked').length;
  document.getElementById('skill-count').textContent = c + ' skill dipilih (pilih minimal 1)';
}
function showLoading(){
  const jurusan = document.querySelector('input[name=jurusan]:checked');
  const skill = document.querySelector('.skill-opt:checked');
  const minat = document.querySelector('input[name=minat]:checked');
  if(!jurusan||!skill||!minat) return;
  document.getElementById('loading').classList.add('show');
}
document.addEventListener('DOMContentLoaded', updateSkillCount);
</script>
@endpush
@endsection
