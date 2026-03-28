@extends('layouts.guru')
@section('title','Edit Tugas')
@section('content')

<div class="mb-6">
  <a href="{{ route('guru.tasks.index') }}" class="text-slate-400 hover:text-white text-sm">← Kembali</a>
  <h1 class="text-2xl font-bold mt-2">Edit Tugas</h1>
</div>

<div class="glass-card p-6 max-w-xl">
  <form method="POST" action="{{ route('guru.tasks.update', $task) }}">
    @csrf @method('PUT')

    <div class="mb-4">
      <label class="block text-sm text-slate-400 mb-1">Judul Tugas</label>
      <input name="judul" value="{{ old('judul', $task->judul) }}"
        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-blue-500">
      @error('judul')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div class="grid grid-cols-2 gap-4 mb-4">
      <div>
        <label class="block text-sm text-slate-400 mb-1">Jurusan</label>
        <input name="jurusan" value="{{ old('jurusan', $task->jurusan) }}"
          class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-blue-500">
      </div>
      <div>
        <label class="block text-sm text-slate-400 mb-1">Kelas</label>
        <input name="kelas" value="{{ old('kelas', $task->kelas) }}"
          class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-blue-500">
      </div>
    </div>

    <div class="mb-4">
      <label class="block text-sm text-slate-400 mb-1">Deadline</label>
      <input name="deadline" type="datetime-local"
             value="{{ old('deadline', $task->deadline->format('Y-m-d\TH:i')) }}"
        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-blue-500">
      @error('deadline')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div class="mb-6">
      <label class="block text-sm text-slate-400 mb-1">Deskripsi</label>
      <textarea name="deskripsi" rows="4"
        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-blue-500 resize-none">{{ old('deskripsi', $task->deskripsi) }}</textarea>
    </div>

    <button class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-2 rounded-lg font-semibold">
      Simpan Perubahan
    </button>
  </form>
</div>

@endsection
