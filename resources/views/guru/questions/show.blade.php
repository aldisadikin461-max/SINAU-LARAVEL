@extends('layouts.guru')
@section('title', $quiz->nama)
@section('content')
<style>
.back{color:#0ea5e9;font-size:.88rem;font-weight:800;text-decoration:none;display:inline-block;margin-bottom:1rem;}
.page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:.4rem;}
.meta-row{display:flex;gap:.75rem;flex-wrap:wrap;align-items:center;margin-bottom:1.5rem;}
.chip{background:#e0f2fe;color:#0284c7;border-radius:999px;padding:.2rem .8rem;font-size:.78rem;font-weight:800;font-family:'Nunito',sans-serif;}
.s-draft{background:#fef9c3;color:#ca8a04;}
.s-published{background:#dcfce7;color:#16a34a;}
.top-actions{display:flex;gap:.6rem;flex-wrap:wrap;margin-bottom:1.5rem;}
.btn-a{padding:.5rem 1.2rem;border-radius:999px;font-size:.84rem;font-weight:800;text-decoration:none;display:inline-flex;align-items:center;gap:.3rem;border:none;cursor:pointer;font-family:'Nunito',sans-serif;transition:all .2s;}
.btn-blue{background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;box-shadow:0 3px 12px rgba(14,165,233,.3);}
.btn-blue:hover{transform:translateY(-1px);}
.btn-gray{background:#f1f5f9;color:#64748b;border:1.5px solid #e2e8f0;}
.btn-gray:hover{background:#e2e8f0;}
.card{background:#fff;border:1.5px solid rgba(14,165,233,.1);border-radius:1.25rem;overflow:hidden;box-shadow:0 4px 18px rgba(14,165,233,.07);}
.q-item{padding:1.1rem 1.25rem;border-bottom:1px solid rgba(14,165,233,.07);display:flex;gap:1rem;align-items:flex-start;}
.q-item:last-child{border-bottom:none;}
.q-num{width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;font-size:.78rem;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:.1rem;}
.q-body{flex:1;}
.q-text{font-weight:700;color:#0f172a;font-size:.9rem;margin-bottom:.4rem;}
.q-meta{display:flex;gap:.5rem;flex-wrap:wrap;margin-bottom:.3rem;}
.badge{border-radius:999px;padding:.15rem .6rem;font-size:.72rem;font-weight:800;font-family:'Nunito',sans-serif;}
.b-pilgan{background:#e0f2fe;color:#0284c7;}
.b-uraian{background:#f3e8ff;color:#7c3aed;}
.b-bs{background:#fef9c3;color:#ca8a04;}
.b-mudah{background:#dcfce7;color:#16a34a;}
.b-sedang{background:#fef9c3;color:#ca8a04;}
.b-sulit{background:#fee2e2;color:#dc2626;}
.q-poin{font-size:.75rem;font-weight:800;color:#94a3b8;}
.q-actions{display:flex;gap:.4rem;flex-shrink:0;}
.btn-sm{padding:.2rem .7rem;border-radius:999px;font-size:.72rem;font-weight:800;text-decoration:none;display:inline-block;border:none;cursor:pointer;font-family:'Nunito',sans-serif;}
.btn-edit-sm{background:#e0f2fe;color:#0284c7;}
.btn-del-sm{background:#fee2e2;color:#dc2626;}
.salert{background:#dcfce7;border:1px solid #bbf7d0;color:#16a34a;border-radius:1rem;padding:.875rem 1.25rem;margin-bottom:1.25rem;font-weight:700;font-size:.9rem;}
.info-box{background:#f0f9ff;border:1.5px solid rgba(14,165,233,.15);border-radius:1rem;padding:1rem 1.25rem;margin-bottom:1.5rem;display:flex;gap:2rem;flex-wrap:wrap;}
.info-item{font-family:'Nunito',sans-serif;}
.info-val{font-size:1.3rem;font-weight:900;color:#0284c7;}
.info-label{font-size:.75rem;font-weight:700;color:#94a3b8;}
</style>

@if(session('success'))<div class="salert">✅ {{ session('success') }}</div>@endif

<a href="{{ route('guru.quiz.index') }}" class="back">← Kembali ke Paket Soal</a>
<div class="page-title">{{ $quiz->nama }}</div>
<div class="meta-row">
  <span class="chip s-{{ $quiz->status }}">{{ ucfirst($quiz->status) }}</span>
  @if($quiz->kelas)<span class="chip">{{ $quiz->kelas }}</span>@endif
  @if($quiz->jurusan)<span class="chip">{{ $quiz->jurusan }}</span>@endif
</div>

@if($quiz->deskripsi)
  <p style="color:#64748b;font-size:.88rem;font-weight:600;margin-bottom:1.25rem;">{{ $quiz->deskripsi }}</p>
@endif

<div class="info-box">
  <div class="info-item">
    <div class="info-val">{{ $quiz->questions->count() }}</div>
    <div class="info-label">Total Soal</div>
  </div>
  <div class="info-item">
    <div class="info-val">{{ $quiz->totalPoin() }}</div>
    <div class="info-label">Total Poin</div>
  </div>
  <div class="info-item">
    <div class="info-val">{{ $quiz->questions->where('tipe','pilgan')->count() }}</div>
    <div class="info-label">Pilihan Ganda</div>
  </div>
  <div class="info-item">
    <div class="info-val">{{ $quiz->questions->where('tipe','uraian')->count() }}</div>
    <div class="info-label">Uraian</div>
  </div>
  <div class="info-item">
    <div class="info-val">{{ $quiz->questions->where('tipe','benar_salah')->count() }}</div>
    <div class="info-label">Benar/Salah</div>
  </div>
</div>

<div class="top-actions">
  <a href="{{ route('guru.quiz.question.create', $quiz) }}" class="btn-a btn-blue">➕ Tambah Soal</a>
  <a href="{{ route('guru.quiz.edit', $quiz) }}" class="btn-a btn-gray">⚙️ Setting Paket</a>
</div>

<div class="card">
  @forelse($quiz->questions as $i => $q)
    <div class="q-item">
      <div class="q-num">{{ $i + 1 }}</div>
      <div class="q-body">
        <div class="q-text">{{ Str::limit($q->pertanyaan, 120) }}</div>
        <div class="q-meta">
          @php
            $tLabel = ['pilgan'=>'Pilihan Ganda','uraian'=>'Uraian','benar_salah'=>'Benar/Salah'];
            $tClass = ['pilgan'=>'b-pilgan','uraian'=>'b-uraian','benar_salah'=>'b-bs'];
          @endphp
          <span class="badge {{ $tClass[$q->tipe] }}">{{ $tLabel[$q->tipe] }}</span>
          <span class="badge b-{{ $q->tingkat }}">{{ ucfirst($q->tingkat) }}</span>
          <span class="q-poin">{{ $q->poin }} poin</span>
        </div>
        @if($q->tipe === 'pilgan')
          <div style="font-size:.78rem;color:#94a3b8;font-weight:700;">
            Jawaban: <span style="color:#16a34a;">{{ $q->jawaban_benar }}</span>
          </div>
        @elseif($q->tipe === 'benar_salah')
          <div style="font-size:.78rem;color:#94a3b8;font-weight:700;">
            Jawaban: <span style="color:#16a34a;">{{ $q->jawaban_benar }}</span>
          </div>
        @endif
      </div>
      <div class="q-actions">
        <a href="{{ route('guru.quiz.question.edit', [$quiz, $q]) }}" class="btn-sm btn-edit-sm">✏️</a>
        <form method="POST" action="{{ route('guru.quiz.question.destroy', [$quiz, $q]) }}"
              onsubmit="return confirm('Hapus soal ini?')" style="display:inline;">
          @csrf @method('DELETE')
          <button class="btn-sm btn-del-sm">🗑️</button>
        </form>
      </div>
    </div>
  @empty
    <div style="text-align:center;padding:3rem;color:#94a3b8;font-weight:700;">
      📝 Belum ada soal. Klik "Tambah Soal" untuk mulai!
    </div>
  @endforelse
</div>
@endsection