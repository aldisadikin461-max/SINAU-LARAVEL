@extends('layouts.siswa')
@section('title', $packet->nama)
@section('content')
<style>
.page-title{font-family:'Fredoka One',sans-serif;font-size:1.6rem;color:#0f172a;margin-bottom:.4rem;}
.page-sub{color:#64748b;font-size:.85rem;font-weight:700;margin-bottom:1.5rem;}
.q-card{background:#fff;border:1.5px solid rgba(14,165,233,.1);border-radius:1.25rem;padding:1.5rem;margin-bottom:1.25rem;box-shadow:0 2px 12px rgba(14,165,233,.06);}
.q-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:.85rem;}
.q-num{font-family:'Fredoka One',sans-serif;font-size:.9rem;color:#0284c7;}
.q-badges{display:flex;gap:.4rem;}
.badge{border-radius:999px;padding:.15rem .6rem;font-size:.72rem;font-weight:800;font-family:'Nunito',sans-serif;}
.b-mudah{background:#dcfce7;color:#16a34a;}
.b-sedang{background:#fef9c3;color:#ca8a04;}
.b-sulit{background:#fee2e2;color:#dc2626;}
.b-poin{background:#e0f2fe;color:#0284c7;}
.q-text{font-weight:700;color:#0f172a;font-size:.95rem;margin-bottom:1rem;line-height:1.6;}
.opsi-list{display:flex;flex-direction:column;gap:.5rem;}
.opsi-label{display:flex;align-items:flex-start;gap:.75rem;padding:.65rem 1rem;border-radius:.875rem;border:2px solid rgba(14,165,233,.1);cursor:pointer;transition:all .18s;font-weight:700;font-size:.88rem;}
.opsi-label:hover{border-color:#0ea5e9;background:#f0f9ff;}
.opsi-label input{margin-top:.15rem;accent-color:#0ea5e9;flex-shrink:0;}
.opsi-label input:checked + span{color:#0284c7;}
.opsi-label:has(input:checked){border-color:#0ea5e9;background:#f0f9ff;}
.opsi-key{font-weight:900;color:#0284c7;min-width:1.2rem;}
.uraian-input{width:100%;background:#f8fafc;border:2px solid rgba(14,165,233,.12);border-radius:.875rem;padding:.65rem 1rem;font-size:.9rem;font-weight:600;color:#1e293b;outline:none;font-family:'Nunito',sans-serif;resize:vertical;transition:border-color .2s;}
.uraian-input:focus{border-color:#0ea5e9;background:#fff;}
.submit-bar{position:sticky;bottom:0;background:rgba(255,255,255,.95);backdrop-filter:blur(10px);border-top:1.5px solid rgba(14,165,233,.1);padding:1rem;text-align:center;margin-top:1.5rem;}
.sbtn{padding:.75rem 2.5rem;border-radius:999px;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;font-size:1rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;box-shadow:0 4px 14px rgba(14,165,233,.3);}
.sbtn:hover{transform:translateY(-2px);}
.progress-bar{background:#e0f2fe;border-radius:999px;height:8px;margin-bottom:1.25rem;overflow:hidden;}
.progress-fill{height:100%;background:linear-gradient(90deg,#0ea5e9,#0284c7);border-radius:999px;transition:width .3s;}
</style>

<div class="page-title">📝 {{ $packet->nama }}</div>
<div class="page-sub">
  {{ $packet->questions->count() }} soal ·
  Total {{ $packet->totalPoin() }} poin
  @if($packet->kelas) · {{ $packet->kelas }} @endif
</div>

<div class="progress-bar">
  <div class="progress-fill" id="progressFill" style="width:0%"></div>
</div>

<form method="POST" action="{{ route('siswa.quiz.submit', $packet) }}" id="quizForm">
  @csrf

  @foreach($packet->questions as $i => $q)
    <div class="q-card" id="qcard-{{ $q->id }}">
      <div class="q-header">
        <span class="q-num">Soal {{ $i + 1 }}</span>
        <div class="q-badges">
          <span class="badge b-{{ $q->tingkat }}">{{ ucfirst($q->tingkat) }}</span>
          <span class="badge b-poin">{{ $q->poin }} poin</span>
        </div>
      </div>
      <div class="q-text">{{ $q->pertanyaan }}</div>

      @if($q->tipe === 'pilgan')
        <div class="opsi-list">
          @foreach(['A' => $q->opsi_a, 'B' => $q->opsi_b, 'C' => $q->opsi_c, 'D' => $q->opsi_d] as $key => $val)
            <label class="opsi-label" onclick="updateProgress()">
              <input type="radio" name="jawaban[{{ $q->id }}]" value="{{ $key }}">
              <span class="opsi-key">{{ $key }}.</span>
              <span>{{ $val }}</span>
            </label>
          @endforeach
        </div>

      @elseif($q->tipe === 'benar_salah')
        <div class="opsi-list">
          @foreach(['Benar', 'Salah'] as $opt)
            <label class="opsi-label" onclick="updateProgress()">
              <input type="radio" name="jawaban[{{ $q->id }}]" value="{{ $opt }}">
              <span>{{ $opt }}</span>
            </label>
          @endforeach
        </div>

      @else
        <textarea name="jawaban[{{ $q->id }}]" rows="3"
                  placeholder="Tulis jawaban kamu di sini..."
                  class="uraian-input"
                  oninput="updateProgress()"></textarea>
      @endif
    </div>
  @endforeach

  <div class="submit-bar">
    <button type="submit" class="sbtn" onclick="return confirmSubmit()">
      ✅ Selesai & Lihat Skor
    </button>
  </div>
</form>

<script>
const totalSoal = {{ $packet->questions->count() }};

function updateProgress() {
  let filled = 0;
  @foreach($packet->questions as $q)
    @if($q->tipe === 'uraian')
      if (document.querySelector('[name="jawaban[{{ $q->id }}]"]')?.value?.trim()) filled++;
    @else
      if (document.querySelector('[name="jawaban[{{ $q->id }}]"]:checked')) filled++;
    @endif
  @endforeach
  const pct = Math.round((filled / totalSoal) * 100);
  document.getElementById('progressFill').style.width = pct + '%';
}

function confirmSubmit() {
  let unanswered = 0;
  @foreach($packet->questions as $q)
    @if($q->tipe === 'uraian')
      if (!document.querySelector('[name="jawaban[{{ $q->id }}]"]')?.value?.trim()) unanswered++;
    @else
      if (!document.querySelector('[name="jawaban[{{ $q->id }}]"]:checked')) unanswered++;
    @endif
  @endforeach
  if (unanswered > 0) {
    return confirm(`Masih ada ${unanswered} soal yang belum dijawab. Tetap kirim?`);
  }
  return true;
}
</script>
@endsection