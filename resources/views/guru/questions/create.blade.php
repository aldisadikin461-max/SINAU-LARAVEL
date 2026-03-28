@extends('layouts.guru')
@section('title','Buat Soal')
@section('content')

<div class="mb-6">
  <a href="{{ route('guru.questions.index') }}" class="text-slate-400 hover:text-white text-sm">← Kembali</a>
  <h1 class="text-2xl font-bold mt-2">Buat Soal Baru</h1>
</div>

<div class="glass-card p-6 max-w-2xl">
  <form method="POST" action="{{ route('guru.questions.store') }}">
    @csrf

    <div class="mb-4">
      <label class="block text-sm text-slate-400 mb-1">Pertanyaan</label>
      <textarea name="pertanyaan" rows="3"
        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-blue-500 resize-none">{{ old('pertanyaan') }}</textarea>
      @error('pertanyaan')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div class="grid grid-cols-2 gap-4 mb-4">
      @foreach(['a'=>'Opsi A','b'=>'Opsi B','c'=>'Opsi C','d'=>'Opsi D'] as $key => $label)
        <div>
          <label class="block text-sm text-slate-400 mb-1">{{ $label }}</label>
          <input name="opsi_{{ $key }}" value="{{ old('opsi_'.$key) }}"
            class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-blue-500">
        </div>
      @endforeach
    </div>

    <div class="grid grid-cols-2 gap-4 mb-6">
      <div>
        <label class="block text-sm text-slate-400 mb-1">Jawaban Benar</label>
        <select name="jawaban_benar" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm">
          @foreach(['a','b','c','d'] as $opt)
            <option value="{{ $opt }}" {{ old('jawaban_benar')==$opt?'selected':'' }}>{{ strtoupper($opt) }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-sm text-slate-400 mb-1">Tingkat Kesulitan</label>
        <select name="tingkat_kesulitan" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm">
          @foreach(['mudah','sedang','sulit'] as $t)
            <option value="{{ $t }}" {{ old('tingkat_kesulitan')==$t?'selected':'' }}>{{ ucfirst($t) }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-sm text-slate-400 mb-1">Kategori</label>
        <select name="category_id" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm">
          @foreach($categories as $c)
            <option value="{{ $c->id }}" {{ old('category_id')==$c->id?'selected':'' }}>{{ $c->nama_kategori }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <button class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-2 rounded-lg font-semibold">
      Simpan Soal
    </button>
  </form>
</div>

@endsection
