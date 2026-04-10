@extends('layouts.siswa')
@section('title', 'Daftar Quiz')
@section('content')
<style>
.page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:.5rem;}
.page-sub{color:#64748b;font-size:.88rem;font-weight:700;margin-bottom:1.5rem;}
.quiz-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.5rem;}
.quiz-card{background:#fff;border:1.5px solid rgba(14,165,233,.1);border-radius:1.25rem;padding:1.25rem;transition:all .2s;box-shadow:0 2px 10px rgba(14,165,233,.06);}
.quiz-card:hover{transform:translateY(-2px);border-color:#0ea5e9;box-shadow:0 8px 25px rgba(14,165,233,.1);}
.quiz-title{font-family:'Fredoka One',sans-serif;font-size:1.1rem;color:#0f172a;margin-bottom:.25rem;}
.quiz-meta{font-size:.7rem;font-weight:800;color:#94a3b8;margin-bottom:.5rem;display:flex;gap:.5rem;flex-wrap:wrap;}
.quiz-desc{font-size:.8rem;color:#475569;margin:.5rem 0;line-height:1.4;}
.quiz-stats{display:flex;gap:.8rem;margin:.75rem 0;font-size:.75rem;font-weight:800;}
.stat{background:#f1f5f9;border-radius:999px;padding:.2rem .6rem;color:#1e293b;}
.btn-start{display:inline-block;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;border-radius:999px;padding:.5rem 1rem;text-align:center;font-weight:800;font-size:.8rem;text-decoration:none;margin-top:.5rem;transition:all .2s;border:none;cursor:pointer;width:100%;}
.btn-start:hover{transform:translateY(-1px);box-shadow:0 4px 12px rgba(14,165,233,.3);}
.btn-disabled{background:#e2e8f0;color:#94a3b8;cursor:not-allowed;pointer-events:none;}
.done-badge{background:#dcfce7;color:#16a34a;border-radius:999px;padding:.2rem .6rem;font-size:.7rem;font-weight:800;display:inline-block;margin-bottom:.5rem;}
.empty-state{text-align:center;padding:3rem;background:#fff;border-radius:1.25rem;border:1.5px dashed rgba(14,165,233,.3);}
.empty-icon{font-size:3rem;margin-bottom:1rem;}
</style>

<div class="page-title">📚 Quiz Tersedia</div>
<div class="page-sub">Pilih paket soal untuk dikerjakan</div>

<div class="quiz-grid">
   @forelse($packets as $packet)
    @php
        $attempt = $packet->attempts->first();
        $isDone  = $attempt !== null;
    @endphp
    <div class="quiz-card">
        <div class="quiz-title">{{ $packet->nama }}</div>
        <div class="quiz-meta">
            @if($packet->kelas)<span>🏫 {{ $packet->kelas }}</span>@endif
            @if($packet->jurusan)<span>📖 {{ $packet->jurusan }}</span>@endif
            <span>📝 {{ $packet->questions_count }} soal</span>
            <span>⭐ {{ $packet->totalPoin() }} poin</span>
        </div>
        @if($packet->deskripsi)
            <div class="quiz-desc">{{ Str::limit($packet->deskripsi, 80) }}</div>
        @endif
        @if($isDone)
            <div class="done-badge">✅ Telah dikerjakan · Skor {{ $attempt->skor }}/{{ $attempt->total_poin }}</div>
            <a href="{{ route('siswa.quiz.hasil', $attempt) }}" class="btn-start">Lihat Hasil</a>
        @else
            <a href="{{ route('siswa.quiz.show', $packet) }}" class="btn-start">🚀 Kerjakan Sekarang</a>
        @endif
    </div>
@empty
    <div class="empty-state" style="grid-column:1/-1;">
        <div class="empty-icon">📭</div>
        <p style="font-weight:800;color:#94a3b8;">Belum ada paket soal tersedia.</p>
        <p style="font-size:.8rem;">Cek kembali nanti ya.</p>
    </div>
@endforelse
</div>
@endsection