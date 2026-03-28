@extends('layouts.guru')
@section('title','Dashboard Guru')
@section('content')

<div class="mb-6">
  <h1 class="text-2xl font-bold">Dashboard Guru</h1>
  <p class="text-slate-400 text-sm mt-1">Halo, {{ auth()->user()->name }}! 🐱 Semangat mengajar hari ini!</p>
</div>

<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
  @foreach([
    ['📚','E-Book',$totalEbook,'blue'],
    ['❓','Soal',$totalSoal,'violet'],
    ['📝','Tugas Saya',$totalTugas,'amber'],
    ['🔥','Streak Aktif',$streakHariIni,'orange'],
    ['✅','Soal Dijawab Hari Ini',$soalDijawab,'green'],
  ] as [$icon,$label,$val,$color])
    <div class="glass-card p-5 text-center">
      <div class="text-3xl mb-1">{{ $icon }}</div>
      <div class="text-2xl font-bold">{{ $val }}</div>
      <div class="text-slate-400 text-xs mt-1">{{ $label }}</div>
    </div>
  @endforeach
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
  <a href="{{ route('guru.ebooks.create') }}" class="glass-card p-5 flex items-center gap-4 hover:bg-slate-800/60 transition">
    <span class="text-3xl">📤</span>
    <div><div class="font-semibold">Upload E-Book Baru</div><div class="text-slate-400 text-xs">Tambah materi PDF</div></div>
  </a>
  <a href="{{ route('guru.questions.create') }}" class="glass-card p-5 flex items-center gap-4 hover:bg-slate-800/60 transition">
    <span class="text-3xl">➕</span>
    <div><div class="font-semibold">Buat Soal Baru</div><div class="text-slate-400 text-xs">Pilihan ganda</div></div>
  </a>
  <a href="{{ route('guru.tasks.create') }}" class="glass-card p-5 flex items-center gap-4 hover:bg-slate-800/60 transition">
    <span class="text-3xl">📋</span>
    <div><div class="font-semibold">Assign Tugas</div><div class="text-slate-400 text-xs">Ke kelas/jurusan</div></div>
  </a>
</div>

@endsection
