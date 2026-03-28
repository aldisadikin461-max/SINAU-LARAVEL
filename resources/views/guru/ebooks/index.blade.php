@extends('layouts.guru')
@section('title','Kelola E-Book')
@section('content')

<div class="flex items-center justify-between mb-6">
  <h1 class="text-2xl font-bold">Kelola E-Book</h1>
  <a href="{{ route('guru.ebooks.create') }}"
     class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-semibold">
    + Upload E-Book
  </a>
</div>

<form method="GET" class="flex gap-3 mb-6 flex-wrap">
  <input name="search" value="{{ request('search') }}" placeholder="Cari judul..."
    class="bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white w-56 focus:outline-none focus:border-blue-500">
  <select name="category_id" class="bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white">
    <option value="">Semua Kategori</option>
    @foreach($categories as $c)
      <option value="{{ $c->id }}" {{ request('category_id')==$c->id?'selected':'' }}>{{ $c->nama_kategori }}</option>
    @endforeach
  </select>
  <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">Filter</button>
</form>

<div class="glass-card overflow-x-auto">
  <table class="w-full text-sm">
    <thead>
      <tr class="text-slate-400 border-b border-slate-700 text-left">
        <th class="px-4 py-3">Judul</th>
        <th class="px-4 py-3">Penulis</th>
        <th class="px-4 py-3">Kategori</th>
        <th class="px-4 py-3">Jurusan</th>
        <th class="px-4 py-3">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($ebooks as $e)
        <tr class="border-b border-slate-800 hover:bg-slate-800/40">
          <td class="px-4 py-3 font-medium">{{ $e->judul }}</td>
          <td class="px-4 py-3 text-slate-400">{{ $e->penulis }}</td>
          <td class="px-4 py-3"><span class="badge-pill text-xs">{{ $e->category->nama_kategori }}</span></td>
          <td class="px-4 py-3 text-slate-400">{{ $e->jurusan ?? 'Umum' }}</td>
          <td class="px-4 py-3 flex gap-2">
            <a href="{{ route('guru.ebooks.edit', $e) }}"
               class="text-xs bg-blue-600/20 text-blue-400 border border-blue-500/30 px-2 py-1 rounded">Edit</a>
            <form method="POST" action="{{ route('guru.ebooks.destroy', $e) }}" onsubmit="return confirm('Hapus e-book ini?')">
              @csrf @method('DELETE')
              <button class="text-xs bg-red-600/20 text-red-400 border border-red-500/30 px-2 py-1 rounded">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5" class="text-center py-8 text-slate-500">Belum ada e-book.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div class="p-4">{{ $ebooks->links() }}</div>
</div>

@endsection
