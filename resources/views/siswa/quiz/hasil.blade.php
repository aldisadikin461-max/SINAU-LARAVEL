@extends('layouts.siswa')
@section('title','Hasil Quiz')
@section('content')
<style>
.hasil-wrap{max-width:680px;margin:0 auto;}
.skor-card{background:linear-gradient(135deg,#0ea5e9,#0284c7);border-radius:1.5rem;padding:2.5rem;text-align:center;color:#fff;margin-bottom:1.5rem;box-shadow:0 8px 32px rgba(14,165,233,.3);}
.skor-val{font-family:'Fredoka One',sans-serif;font-size:4rem;line-height:1;}
.skor-label{font-size:.9rem;font-weight:700;opacity:.85;margin-top:.25rem;}
.skor-sub{font-size:.82rem;opacity:.7;margin-top:.5rem;}
.stats-row{display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1.5rem;}
.stat-box{background:#fff;border:1.5px solid rgba(14,165,233,.1);border-radius:1.1rem;padding:1rem;text-align:center;box-shadow:0 2px 10px rgba(14,165,233,.06);}
.stat-val{font-family:'Fredoka One',sans-serif;font-size:1.6rem;}
.stat-label{font-size:.75rem;font-weight:800;color:#94a3b8;margin-top:.15rem;}
.green{color:#16a34a;} .red{color:#dc2626;} .blue{color:#0284c7;}
.review-title{font-family:'Fredoka One',sans-serif;font-size:1.2rem;color:#0f172a;margin-bottom:1rem;}
.q-card{background:#fff;border:1.5px solid rgba(14,165,233,.1);border-radius:1.1rem;padding:1.25rem;margin-bottom:.875rem;box-shadow:0 2px 10px rgba(14,165,233,.06);}
.q-num{font-size:.78rem;font-weight:800;color:#94a3b8;margin-bottom:.4rem;}
.q-text{font-weight:700;color:#0f172a;font-size:.9rem;margin-bottom:.75rem;}
.jwb-row{font-size:.82rem;font-weight:700;display:flex;align-items:center;gap:.5rem;margin-bottom:.3rem;}
.jwb-siswa-ok{color:#16a34a;}
.jwb-siswa-salah{color:#dc2626;}
.jwb-benar{color:#16a34a;}
.jwb-uraian{color:#7c3aed;}
.pembahasan{background:#f0f9ff;border-left:3px solid #0ea5e9;padding:.6rem .875rem;border-radius:0 .5rem .5rem 0;font-size:.82rem;color:#0284c7;font-weight:600;margin-top:.5rem;}
.action-row{display:flex;gap:.75rem;justify-content:center;margin-top:2rem;flex-wrap:wrap;}
.btn-a{padding:.65rem 1.5rem;border-radius:999px;font-size:.9rem;font-weight:800;text-decoration:none;display:inline-flex;align-items:center;gap:.3rem;border:none;cursor:pointer;font-family:'Nunito',sans-serif;transition:all .2s;}
.btn-blue{background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;box-shadow:0 3px 12px rgba(14,165,233,.3);}
.btn-gray{background:#f1f5f9;color:#64748b;border:1.5px solid #e2e8f0;}
.uraian-note{background:#f3e8ff;border:1.5px solid #e9d5ff;border-radius:.875rem;padding:.75rem 1rem;font-size:.82rem;color:#7c3aed;font-weight:700;margin-bottom:1.25rem;}
</style>

<div class="hasil-wrap">

  @php
    $pct = $attempt->persentase();
    $emoji = $pct >= 80 ? '🏆' : ($pct >= 60 ? '👍' : ($pct >= 40 ? '😐' : '💪'));
  @endphp

  <div class="skor-card">
    <div style="font-size:2.5rem;margin-bottom:.5rem;">{{ $emoji }}</div>
    <div class="skor-val">{{ $pct }}%</div>
    <div class="skor-label">{{ $attempt->packet->nama }}</div>
    <div class="skor-sub">{{ $attempt->skor }} / {{ $attempt->total_poin }} poin</div>
  </div>

  <div class="stats-row">
    <div class="stat-box">
      <div class="stat-val green">{{ $attempt->benar }}</div>
      <div class="stat-label">Benar</div>
    </div>
    <div class="stat-box">
      <div class="stat-val red">{{ $attempt->salah }}</div>
      <div class="stat-label">Salah</div>
    </div>
    <div class="stat-box">
      <div class="stat-val blue">{{ $attempt->uraian_count }}</div>
      <div class="stat-label">Uraian</div>
    </div>
  </div>

  @if($attempt->uraian_count > 0)
    <div class="uraian-note">
      📝 Soal uraian belum dihitung otomatis — guru akan menilai dan memperbarui skor uraian kamu.
    </div>
  @endif

  <div class="review-title">📋 Review Jawaban</div>

  @foreach($attempt->packet->questions as $i => $q)
    @php $detail = $attempt->jawaban[$q->id] ?? null; @endphp
    <div class="q-card">
      <div class="q-num">Soal {{ $i + 1 }} · {{ ucfirst($q->tingkat) }} · {{ $q->poin }} poin</div>
      <div class="q-text">{{ $q->pertanyaan }}</div>

      @if($q->tipe === 'uraian')
        <div class="jwb-row jwb-uraian">
          ✏️ Jawaban kamu: {{ $detail['jawaban'] ?? '(tidak dijawab)' }}
        </div>
      @else
        <div class="jwb-row {{ ($detail['benar'] ?? false) ? 'jwb-siswa-ok' : 'jwb-siswa-salah' }}">
          {{ ($detail['benar'] ?? false) ? '✅' : '❌' }}
          Jawaban kamu: {{ $detail['jawaban'] ?? '(tidak dijawab)' }}
        </div>
        @if(!($detail['benar'] ?? false) && $detail['jawaban'] ?? false)
          <div class="jwb-row jwb-benar">
            💡 Jawaban benar: {{ $q->jawaban_benar }}
          </div>
        @endif
      @endif

      @if($q->pembahasan)
        <div class="pembahasan">📖 {{ $q->pembahasan }}</div>
      @endif
    </div>
  @endforeach

  <div class="action-row">
    <a href="{{ route('siswa.quiz.show', $attempt->packet) }}" class="btn-a btn-blue">🔄 Kerjakan Lagi</a>
    <a href="{{ route('siswa.quiz.index') }}" class="btn-a btn-gray">📦 Paket Soal Lain</a>
    <a href="{{ route('siswa.quiz.riwayat') }}" class="btn-a btn-gray">📜 Riwayat Saya</a>
  </div>

</div>
@endsection