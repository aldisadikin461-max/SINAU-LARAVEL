@extends('layouts.guru')
@section('title', isset($question) ? 'Edit Soal' : 'Tambah Soal')
@section('content')
<style>
.back{color:#0ea5e9;font-size:.88rem;font-weight:800;text-decoration:none;display:inline-block;margin-bottom:1rem;}
.page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:1.5rem;}
.fcard{background:#fff;border:1.5px solid rgba(14,165,233,.1);border-radius:1.25rem;padding:2rem;max-width:680px;box-shadow:0 4px 18px rgba(14,165,233,.07);}
label{display:block;font-size:.82rem;font-weight:800;color:#64748b;margin-bottom:.35rem;margin-top:.9rem;}
label:first-of-type{margin-top:0;}
.fi{width:100%;background:#f8fafc;border:2px solid rgba(14,165,233,.12);border-radius:.875rem;padding:.65rem 1rem;font-size:.9rem;font-weight:700;color:#1e293b;outline:none;font-family:'Nunito',sans-serif;transition:border-color .2s;}
.fi:focus{border-color:#0ea5e9;background:#fff;}
textarea.fi{resize:vertical;}
.err{color:#ef4444;font-size:.78rem;font-weight:700;margin-top:.25rem;}
.g2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
@media(max-width:600px){.g2{grid-template-columns:1fr;}}
.sec{font-family:'Fredoka One',sans-serif;font-size:1rem;color:#0ea5e9;margin:1.25rem 0 .5rem;}
.sbtn{padding:.7rem 1.6rem;border-radius:999px;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;font-size:.9rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;box-shadow:0 4px 14px rgba(14,165,233,.3);}
.sbtn-outline{background:#f1f5f9;color:#64748b;border:1.5px solid #e2e8f0;box-shadow:none;}
.opsi-section{display:none;}
.bs-section{display:none;}
</style>

<a href="{{ route('guru.quiz.show', $quiz) }}" class="back">← Kembali ke {{ $quiz->nama }}</a>
<div class="page-title">{{ isset($question) ? '✏️ Edit Soal' : '➕ Tambah Soal Baru' }}</div>

<div class="fcard">
  <form method="POST" action="{{ isset($question)
    ? route('guru.quiz.question.update', [$quiz, $question])
    : route('guru.quiz.question.store', $quiz) }}">
    @csrf
    @if(isset($question)) @method('PUT') @endif

    <label>Pertanyaan *</label>
    <textarea name="pertanyaan" rows="3" placeholder="Tulis pertanyaan di sini..." class="fi">{{ old('pertanyaan', $question->pertanyaan ?? '') }}</textarea>
    @error('pertanyaan')<p class="err">{{ $message }}</p>@enderror

    <div class="g2">
      <div>
        <label>Tipe Soal *</label>
        <select name="tipe" id="tipeSelect" class="fi" onchange="updateTipe(this.value)">
          <option value="pilgan"      {{ old('tipe', $question->tipe ?? '') === 'pilgan'      ? 'selected' : '' }}>Pilihan Ganda</option>
          <option value="uraian"      {{ old('tipe', $question->tipe ?? '') === 'uraian'      ? 'selected' : '' }}>Uraian / Essay</option>
          <option value="benar_salah" {{ old('tipe', $question->tipe ?? '') === 'benar_salah' ? 'selected' : '' }}>Benar / Salah</option>
        </select>
        @error('tipe')<p class="err">{{ $message }}</p>@enderror
      </div>
      <div>
        <label>Tingkat Kesulitan *</label>
        <select name="tingkat" class="fi">
          @foreach(['mudah'=>'😊 Mudah','sedang'=>'😐 Sedang','sulit'=>'😤 Sulit'] as $v=>$l)
            <option value="{{ $v }}" {{ old('tingkat', $question->tingkat ?? 'sedang') === $v ? 'selected' : '' }}>{{ $l }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <label>Poin *</label>
    <input name="poin" type="number" min="1" max="100"
           value="{{ old('poin', $question->poin ?? 10) }}"
           placeholder="10" class="fi" style="max-width:160px;">
    @error('poin')<p class="err">{{ $message }}</p>@enderror

    {{-- Opsi Pilihan Ganda --}}
    <div class="opsi-section" id="opsiSection">
      <div class="sec">📝 Pilihan Jawaban</div>
      @foreach(['A','B','C','D'] as $huruf)
        <label>Opsi {{ $huruf }} *</label>
        <input name="opsi_{{ strtolower($huruf) }}"
               value="{{ old('opsi_'.strtolower($huruf), $question->{'opsi_'.strtolower($huruf)} ?? '') }}"
               placeholder="Isi opsi {{ $huruf }}..." class="fi">
        @error('opsi_'.strtolower($huruf))<p class="err">{{ $message }}</p>@enderror
      @endforeach
      <label>Jawaban Benar *</label>
      <select name="jawaban_benar" id="jwbPilgan" class="fi">
        @foreach(['A','B','C','D'] as $h)
          <option value="{{ $h }}" {{ old('jawaban_benar', $question->jawaban_benar ?? '') === $h ? 'selected' : '' }}>{{ $h }}</option>
        @endforeach
      </select>
    </div>

    {{-- Benar / Salah --}}
    <div class="bs-section" id="bsSection">
      <div class="sec">✅ Jawaban Benar / Salah</div>
      <label>Pilih Jawaban yang Benar *</label>
      <select name="jawaban_benar" id="jwbBS" class="fi">
        <option value="Benar" {{ old('jawaban_benar', $question->jawaban_benar ?? '') === 'Benar' ? 'selected' : '' }}>Benar</option>
        <option value="Salah" {{ old('jawaban_benar', $question->jawaban_benar ?? '') === 'Salah' ? 'selected' : '' }}>Salah</option>
      </select>
    </div>

    <label>Pembahasan (opsional)</label>
    <textarea name="pembahasan" rows="2" placeholder="Penjelasan jawaban yang benar..." class="fi">{{ old('pembahasan', $question->pembahasan ?? '') }}</textarea>

    <div style="display:flex;gap:.75rem;margin-top:1.5rem;flex-wrap:wrap;">
      <button type="submit" class="sbtn">
        {{ isset($question) ? '💾 Simpan' : '✅ Simpan Soal' }}
      </button>
      @if(!isset($question))
        <button type="submit" name="tambah_lagi" value="1" class="sbtn sbtn-outline">
          ➕ Simpan & Tambah Lagi
        </button>
      @endif
    </div>
  </form>
</div>

<script>
function updateTipe(val) {
  document.getElementById('opsiSection').style.display = val === 'pilgan'      ? 'block' : 'none';
  document.getElementById('bsSection').style.display   = val === 'benar_salah' ? 'block' : 'none';

  // Disable input yang tidak dipakai agar tidak ikut validasi
  const opsiInputs = document.querySelectorAll('#opsiSection input, #opsiSection select');
  const bsInputs   = document.querySelectorAll('#bsSection select');

  opsiInputs.forEach(el => el.disabled = val !== 'pilgan');
  bsInputs.forEach(el => el.disabled   = val !== 'benar_salah');
}

// Init on load
updateTipe(document.getElementById('tipeSelect').value);
</script>
@endsection