@extends('layouts.guru')
@section('title','Edit E-Book')
@section('content')

<div class="mb-6">
  <a href="{{ route('guru.ebooks.index') }}" class="text-slate-400 hover:text-white text-sm">← Kembali</a>
  <h1 class="text-2xl font-bold mt-2">Edit E-Book</h1>
</div>

<div class="glass-card p-6 max-w-2xl">
  <form method="POST" action="{{ route('guru.ebooks.update', $ebook) }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="mb-4">
      <label class="block text-sm text-slate-400 mb-1">Judul E-Book</label>
      <input name="judul" value="{{ old('judul', $ebook->judul) }}"
        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-blue-500">
      @error('judul')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div class="mb-4">
      <label class="block text-sm text-slate-400 mb-1">Penulis</label>
      <input name="penulis" value="{{ old('penulis', $ebook->penulis) }}"
        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-blue-500">
    </div>

    <div class="grid grid-cols-2 gap-4 mb-4">
      <div>
        <label class="block text-sm text-slate-400 mb-1">Kategori</label>
        <select name="category_id" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm">
          @foreach($categories as $c)
            <option value="{{ $c->id }}" {{ old('category_id',$ebook->category_id)==$c->id?'selected':'' }}>{{ $c->nama_kategori }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-sm text-slate-400 mb-1">Jurusan</label>
        <input name="jurusan" value="{{ old('jurusan', $ebook->jurusan) }}"
          class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-blue-500">
      </div>
    </div>

    <div class="mb-4">
      <label class="block text-sm text-slate-400 mb-1">
        Ganti File PDF
        <span class="text-xs text-slate-500 ml-1">(kosongkan jika tidak ingin mengganti)</span>
      </label>
      <input name="file" type="file" accept=".pdf"
        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm">
    </div>

    <div class="mb-6">
      <label class="block text-sm text-slate-400 mb-1">Ganti Cover</label>
      <input name="cover" type="file" accept="image/*"
        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm">
      @if($ebook->cover)
        <p class="text-xs text-slate-500 mt-1">Cover saat ini: {{ $ebook->cover }}</p>
      @endif
    </div>

    <button class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-2 rounded-lg font-semibold">
      Simpan Perubahan
    </button>
  </form>
</div>

@endsection
