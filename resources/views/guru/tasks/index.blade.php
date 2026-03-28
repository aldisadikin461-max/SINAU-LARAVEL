@extends('layouts.guru')
@section('title','Kelola Tugas')
@section('content')

<div class="flex items-center justify-between mb-6">
  <h1 class="text-2xl font-bold">Kelola Tugas</h1>
  <a href="{{ route('guru.tasks.create') }}"
     class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-semibold">
    + Assign Tugas
  </a>
</div>

<div class="glass-card overflow-x-auto">
  <table class="w-full text-sm">
    <thead>
      <tr class="text-slate-400 border-b border-slate-700 text-left">
        <th class="px-4 py-3">Judul</th>
        <th class="px-4 py-3">Jurusan</th>
        <th class="px-4 py-3">Kelas</th>
        <th class="px-4 py-3">Deadline</th>
        <th class="px-4 py-3">Status</th>
        <th class="px-4 py-3">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($tasks as $task)
        @php $terlambat = $task->deadline->isPast(); @endphp
        <tr class="border-b border-slate-800 hover:bg-slate-800/40">
          <td class="px-4 py-3 font-medium">{{ $task->judul }}</td>
          <td class="px-4 py-3 text-slate-400">{{ $task->jurusan ?? 'Semua' }}</td>
          <td class="px-4 py-3 text-slate-400">{{ $task->kelas ?? 'Semua' }}</td>
          <td class="px-4 py-3 {{ $terlambat ? 'text-red-400 font-semibold' : 'text-slate-400' }}">
            {{ $task->deadline->format('d M Y H:i') }}
            @if($terlambat)<span class="text-xs ml-1">(Lewat)</span>@endif
          </td>
          <td class="px-4 py-3">
            <span class="{{ $terlambat ? 'status-tutup' : 'status-buka' }}">
              {{ $terlambat ? 'Lewat' : 'Aktif' }}
            </span>
          </td>
          <td class="px-4 py-3 flex gap-2">
            <a href="{{ route('guru.tasks.edit', $task) }}"
               class="text-xs bg-blue-600/20 text-blue-400 border border-blue-500/30 px-2 py-1 rounded">Edit</a>
            <form method="POST" action="{{ route('guru.tasks.destroy', $task) }}"
                  onsubmit="return confirm('Hapus tugas ini?')">
              @csrf @method('DELETE')
              <button class="text-xs bg-red-600/20 text-red-400 border border-red-500/30 px-2 py-1 rounded">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="text-center py-8 text-slate-500">Belum ada tugas.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div class="p-4">{{ $tasks->links() }}</div>
</div>

@endsection
