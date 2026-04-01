@extends('layouts.guru')
@section('title','Edit Soal')
@section('content')
<style>
.back{color:#0ea5e9;font-size:.88rem;font-weight:800;text-decoration:none;display:inline-block;margin-bottom:1rem;}
.page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:1.25rem;}
.fcard{background:#fff;border:1.5px solid rgba(14,165,233,.1);border-radius:1.25rem;padding:2rem;max-width:700px;box-shadow:0 4px 18px rgba(14,165,233,.07);}
.sec{font-family:'Fredoka One',sans-serif;font-size:1rem;color:#0ea5e9;margin-bottom:.75rem;margin-top:.5rem;}
label{display:block;font-size:.82rem;font-weight:800;color:#64748b;margin-bottom:.35rem;}
.fi{width:100%;background:#f8fafc;border:2px solid rgba(14,165,233,.12);border-radius:.875rem;padding:.6rem 1rem;font-size:.9rem;font-weight:700;color:#1e293b;outline:none;font-family:'Nunito',sans-serif;margin-bottom:.85rem;transition:border-color .2s;}
.fi:focus{border-color:#0ea5e9;background:#fff;}
textarea.fi{resize:none;border-radius:.875rem;}
.g2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
.g3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;}
@media(max-width:600px){.g2,.g3{grid-template-columns:1fr;}}
.sbtn{padding:.7rem 2rem;border-radius:999px;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;font-size:.95rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;box-shadow:0 4px 14px rgba(14,165,233,.3);}
</style>
<a href="{{ route('guru.questions.index') }}" class="back">← Kembali ke Daftar Soal</a>
<div class="page-title">Edit Soal ✏️</div>
<div class="fcard">
  <form method="POST" action="{{ route('guru.questions.update',$question) }}">
    @csrf @method('PUT')
    <div class="sec">📝 Pertanyaan</div>
    <label>Teks Pertanyaan</label>
    <textarea name="pertanyaan" rows="3" class="fi">{{ old('pertanyaan',$question->pertanyaan) }}</textarea>
    <div class="sec">🔤 Pilihan Jawaban</div>
    <div class="g2">
      @foreach(['a'=>'Opsi A','b'=>'Opsi B','c'=>'Opsi C','d'=>'Opsi D'] as $k=>$l)
        <div>
          <label>{{ $l }}</label>
          <input name="opsi_{{ $k }}" value="{{ old('opsi_'.$k,$question->{'opsi_'.$k}) }}" class="fi">
        </div>
      @endforeach
    </div>
    <div class="sec">⚙️ Pengaturan Soal</div>
    <div class="g3">
      <div>
        <label>Jawaban Benar</label>
        <select name="jawaban_benar" class="fi">
          @foreach(['a'=>'A','b'=>'B','c'=>'C','d'=>'D'] as $v=>$l)
            <option value="{{ $v }}" {{ old('jawaban_benar',$question->jawaban_benar)===$v?'selected':'' }}>Opsi {{ $l }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label>Tingkat Kesulitan</label>
        <select name="tingkat_kesulitan" class="fi">
          @foreach(['mudah'=>'Mudah','sedang'=>'Sedang','sulit'=>'Sulit'] as $v=>$l)
            <option value="{{ $v }}" {{ old('tingkat_kesulitan',$question->tingkat_kesulitan)===$v?'selected':'' }}>{{ $l }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label>Kategori</label>
        <select name="category_id" class="fi">
          @foreach($categories as $c)
            <option value="{{ $c->id }}" {{ old('category_id',$question->category_id)===$c->id?'selected':'' }}>{{ $c->nama_kategori }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <button type="submit" class="sbtn">Simpan Perubahan ✅</button>
  </form>
</div>
@endsection
