@extends('layouts.guru')
@section('title','Progres Siswa')
@section('content')

<h1 class="text-2xl font-bold mb-6">📈 Progres Belajar Siswa</h1>

<div class="glass-card overflow-x-auto">
  <table class="w-full text-sm">
    <thead>
      <tr class="text-slate-400 border-b border-slate-700 text-left">
        <th class="px-4 py-3">Nama</th>
        <th class="px-4 py-3">Jurusan</th>
        <th class="px-4 py-3">Kelas</th>
        <th class="px-4 py-3">Streak</th>
        <th class="px-4 py-3">Total Soal Dijawab</th>
        <th class="px-4 py-3">Benar</th>
        <th class="px-4 py-3">Akurasi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($siswa as $s)
        @php
          $total  = $s->userAnswers->count();
          $benar  = $s->userAnswers->where('is_correct', true)->count();
          $akurasi = $total > 0 ? round($benar / $total * 100) : 0;
        @endphp
        <tr class="border-b border-slate-800 hover:bg-slate-800/40">
          <td class="px-4 py-3 font-medium">{{ $s->name }}</td>
          <td class="px-4 py-3 text-slate-400">{{ $s->jurusan ?? '-' }}</td>
          <td class="px-4 py-3 text-slate-400">{{ $s->kelas ?? '-' }}</td>
          <td class="px-4 py-3">
            <span class="streak-badge text-xs">🔥 {{ $s->streak?->streak_count ?? 0 }}</span>
          </td>
          <td class="px-4 py-3 text-center">{{ $total }}</td>
          <td class="px-4 py-3 text-center text-green-400 font-semibold">{{ $benar }}</td>
          <td class="px-4 py-3">
            <div class="flex items-center gap-2">
              <div class="flex-1 bg-slate-800 rounded-full h-2 w-20">
                <div class="h-2 rounded-full {{ $akurasi >= 70 ? 'bg-green-500' : ($akurasi >= 40 ? 'bg-yellow-500' : 'bg-red-500') }}"
                     style="width:{{ $akurasi }}%"></div>
              </div>
              <span class="text-xs text-slate-400">{{ $akurasi }}%</span>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="7" class="text-center py-8 text-slate-500">Belum ada data siswa.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
  <div class="p-4">{{ $siswa->links() }}</div>
</div>

@endsection
