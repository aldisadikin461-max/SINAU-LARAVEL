@extends('layouts.siswa')
@section('title','Latihan Soal Harian')
@section('content')
<style>
:root{--blue:#1a8cff;--blue-press:#005bb8;--blue-light:#e8f4ff;--border:#d0e4f7;--orange:#f97316;}
.latihan-wrap{max-width:680px;margin:0 auto;}
.page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:.4rem;}
.page-sub{color:#64748b;font-weight:600;font-size:.9rem;margin-bottom:1.5rem;}

/* Streak bar */
.streak-bar{background:#fff;border:2px solid var(--border);border-radius:1.25rem;padding:1rem 1.25rem;margin-bottom:1.25rem;display:flex;align-items:center;justify-content:space-between;gap:1rem;box-shadow:0 3px 0 var(--border);}
.streak-info{display:flex;align-items:center;gap:.6rem;}
.streak-num{font-family:'Fredoka One',sans-serif;font-size:1.5rem;color:var(--orange);}
.streak-label{font-size:.85rem;font-weight:700;color:#64748b;}
.streak-active{color:#16a34a;background:#dcfce7;border-radius:999px;padding:.2rem .75rem;font-size:.78rem;font-weight:800;}
.streak-dead{color:#94a3b8;background:#f1f5f9;border-radius:999px;padding:.2rem .75rem;font-size:.78rem;font-weight:800;}

/* Filter */
.filter-row{display:flex;gap:.6rem;flex-wrap:wrap;margin-bottom:1.25rem;}
.fi{background:#fff;border:2px solid var(--border);border-radius:999px;padding:.45rem 1.1rem;font-size:.85rem;font-weight:700;color:#1e293b;outline:none;font-family:'Nunito',sans-serif;transition:border-color .2s;}
.fi:focus{border-color:var(--blue);}
.fbtn{padding:.45rem 1.3rem;border-radius:999px;background:var(--blue);color:#fff;font-size:.85rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;box-shadow:0 4px 0 var(--blue-press);transition:all .15s;}
.fbtn:hover{transform:translateY(2px);box-shadow:0 2px 0 var(--blue-press);}

/* Soal card */
.soal-card{background:#fff;border:2px solid var(--border);border-radius:1.5rem;padding:2rem;box-shadow:0 4px 0 var(--border);margin-bottom:1.25rem;}
.soal-meta{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.5rem;margin-bottom:1.25rem;}
.cat-chip{background:var(--blue-light);color:var(--blue);border-radius:999px;padding:.25rem .8rem;font-size:.78rem;font-weight:800;}
.level-chip{border-radius:999px;padding:.25rem .8rem;font-size:.78rem;font-weight:800;}
.lm{background:#dcfce7;color:#16a34a;} .ls{background:#fef9c3;color:#ca8a04;} .lh{background:#fee2e2;color:#dc2626;}
.soal-q{font-size:1.1rem;font-weight:800;color:#0f172a;line-height:1.65;margin-bottom:1.5rem;}
.soal-hari{font-size:.75rem;color:#94a3b8;font-weight:700;margin-bottom:.75rem;}

/* Opsi */
.opsi-list{display:flex;flex-direction:column;gap:.75rem;margin-bottom:1rem;}
.opsi-btn{background:#f8fafc;border:2px solid var(--border);border-radius:1rem;padding:.9rem 1.2rem;color:#1e293b;cursor:pointer;transition:all .18s;text-align:left;width:100%;font-family:'Nunito',sans-serif;font-size:.95rem;font-weight:700;display:flex;align-items:center;gap:.75rem;}
.opsi-btn:hover:not(:disabled){background:var(--blue-light);border-color:var(--blue);}
.opsi-btn:disabled{cursor:not-allowed;}
.opsi-btn.correct{background:#dcfce7;border-color:#22c55e;color:#16a34a;}
.opsi-btn.wrong{background:#fee2e2;border-color:#ef4444;color:#dc2626;}
.opsi-btn.selected-wrong{background:#fee2e2;border-color:#ef4444;color:#dc2626;}
.opsi-key{font-family:'Fredoka One',sans-serif;font-size:1rem;width:1.8rem;height:1.8rem;border-radius:.5rem;background:rgba(0,0,0,.06);display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:all .18s;}
.opsi-btn.correct .opsi-key{background:#16a34a;color:#fff;}
.opsi-btn.wrong .opsi-key,.opsi-btn.selected-wrong .opsi-key{background:#ef4444;color:#fff;}

/* Feedback */
.feedback-card{border-radius:1.25rem;padding:1.25rem;margin-bottom:1rem;display:none;}
.feedback-card.benar{background:#dcfce7;border:2px solid #bbf7d0;}
.feedback-card.salah{background:#fee2e2;border:2px solid #fecaca;}
.feedback-title{font-family:'Fredoka One',sans-serif;font-size:1.2rem;margin-bottom:.4rem;}
.feedback-sub{font-size:.88rem;font-weight:700;color:#475569;}

/* Streak reward */
.streak-reward{background:linear-gradient(135deg,#fff7ed,#ffedd5);border:2px solid #fed7aa;border-radius:1.25rem;padding:1.25rem;margin-bottom:1rem;display:none;text-align:center;}
.streak-reward-num{font-family:'Fredoka One',sans-serif;font-size:2.5rem;color:var(--orange);}
.streak-reward-label{font-size:.9rem;font-weight:700;color:#92400e;}

/* Selesai hari ini */
.done-today{background:#fff;border:2px solid var(--border);border-radius:1.25rem;padding:1.5rem;text-align:center;margin-top:1rem;display:none;}
.done-today .ico{font-size:3rem;margin-bottom:.5rem;}
.done-today h3{font-family:'Fredoka One',sans-serif;font-size:1.3rem;color:#0f172a;margin-bottom:.4rem;}
.done-today p{color:#64748b;font-size:.9rem;font-weight:700;}
.btn-dashboard{display:inline-block;margin-top:1rem;padding:.65rem 1.5rem;border-radius:999px;background:var(--blue);color:#fff;font-weight:800;font-size:.9rem;text-decoration:none;box-shadow:0 4px 0 var(--blue-press);}

/* Readonly badge */
.readonly-badge{background:#f1f5f9;color:#94a3b8;border-radius:999px;padding:.25rem .75rem;font-size:.75rem;font-weight:800;display:inline-block;margin-bottom:.75rem;}

/* Empty state */
.empty-state{text-align:center;padding:3rem;background:#fff;border:2px dashed var(--border);border-radius:1.5rem;}
.empty-state .ei{font-size:3rem;margin-bottom:.75rem;}
</style>

<div class="latihan-wrap">
  <div class="page-title">❓ Latihan Soal Harian</div>
  <div class="page-sub">Satu soal spesial tiap hari — jawab untuk jaga streakmu!</div>

  {{-- Streak Bar --}}
  <div class="streak-bar">
    <div class="streak-info">
      <span style="font-size:1.5rem;">🔥</span>
      <span class="streak-num">{{ $streakData['current'] }}</span>
      <span class="streak-label">hari streak</span>
    </div>
    <div>
      @if($streakData['is_active'])
        <span class="streak-active">✅ Streak Aktif</span>
      @else
        <span class="streak-dead">💔 Streak Mati</span>
      @endif
    </div>
  </div>

  {{-- Filter --}}
  <form method="GET" class="filter-row">
    <select name="category_id" class="fi">
      <option value="">Semua Kategori</option>
      @foreach($categories as $c)
        <option value="{{ $c->id }}" {{ request('category_id')==$c->id?'selected':'' }}>{{ $c->nama_kategori }}</option>
      @endforeach
    </select>
    <select name="tingkat" class="fi">
      <option value="">Semua Tingkat</option>
      @foreach(['mudah','sedang','sulit'] as $t)
        <option value="{{ $t }}" {{ request('tingkat')===$t?'selected':'' }}>{{ ucfirst($t) }}</option>
      @endforeach
    </select>
    <button type="submit" class="fbtn">🔄 Ganti Filter</button>
  </form>

  @if($soal)
    <div class="soal-card">
      <div class="soal-meta">
        <span class="cat-chip">{{ $soal->category->nama_kategori }}</span>
        <span class="level-chip l{{ $soal->tingkat_kesulitan[0] }}">{{ ucfirst($soal->tingkat_kesulitan) }}</span>
      </div>

      @if($jawabanHariIni)
        <div class="readonly-badge">📋 Sudah dijawab hari ini — Read Only</div>
      @else
        <div class="soal-hari">📅 Soal hari ini, {{ now()->format('d M Y') }}</div>
      @endif

      <div class="soal-q">{{ $soal->pertanyaan }}</div>

      <div class="opsi-list" id="opsi-container">
        @foreach(['a','b','c','d'] as $opt)
          @php
            $isBenar = $opt === $soal->jawaban_benar;
            $isDipilih = $jawabanHariIni?->jawaban === $opt;
            $cls = '';
            if ($jawabanHariIni) {
              if ($isBenar) $cls = 'correct';
              elseif ($isDipilih) $cls = 'selected-wrong';
            }
          @endphp
          <button
            class="opsi-btn {{ $cls }}"
            data-jawaban="{{ $opt }}"
            @if($jawabanHariIni) disabled @endif
            @if(!$jawabanHariIni) onclick="jawabSoal({{ $soal->id }}, '{{ $opt }}', this)" @endif
          >
            <span class="opsi-key">{{ strtoupper($opt) }}</span>
            {{ $soal->{'opsi_'.$opt} }}
          </button>
        @endforeach
      </div>

      {{-- Feedback (muncul setelah jawab) --}}
      <div class="feedback-card" id="feedback-benar" style="display:none;">
        <div class="feedback-title" style="color:#16a34a;">✅ Jawaban Kamu Benar!</div>
        <div class="feedback-sub">Mantap Smeconer! Terus semangat belajar ya! 🎉</div>
      </div>
      <div class="feedback-card" id="feedback-salah" style="display:none;">
        <div class="feedback-title" style="color:#dc2626;">❌ Belum Tepat</div>
        <div class="feedback-sub" id="jawaban-benar-txt">Jawaban benar: -</div>
      </div>

      {{-- Streak Reward --}}
      <div class="streak-reward" id="streak-reward">
        <div class="streak-reward-num">🔥 <span id="streak-reward-num">0</span></div>
        <div class="streak-reward-label">hari streak! Kinners bangga! 🐱</div>
      </div>

      {{-- Sudah jawab hari ini --}}
      @if($jawabanHariIni)
        <div class="done-today" style="display:block;">
          <div class="ico">😸</div>
          <h3>Kamu sudah menjawab soal hari ini!</h3>
          <p>Kembali besok untuk soal baru dan jaga streakmu ya!</p>
          <p style="margin-top:.5rem;">🔥 Streak saat ini: <strong style="color:var(--orange);">{{ $streakData['current'] }} hari</strong></p>
          <a href="{{ route('siswa.dashboard') }}" class="btn-dashboard">Kembali ke Dashboard</a>
        </div>
      @endif

      {{-- Selesai setelah jawab (muncul via JS) --}}
      <div class="done-today" id="done-today-js">
        <div class="ico">😸</div>
        <h3>Kamu sudah selesai latihan hari ini!</h3>
        <p>Kembali besok ya! Kinners nunggu kamu 🐱</p>
        <a href="{{ route('siswa.dashboard') }}" class="btn-dashboard">Kembali ke Dashboard</a>
      </div>
    </div>

  @else
    <div class="empty-state">
      <div class="ei">🐱</div>
      <p style="font-weight:700;color:#94a3b8;">Kinners bingung... belum ada soal untuk filter ini!</p>
      <a href="{{ route('siswa.latihan') }}" style="color:var(--blue);font-weight:800;">Reset Filter →</a>
    </div>
  @endif
</div>

@push('scripts')
<script>
function jawabSoal(questionId, jawaban, btn) {
  // Disable semua tombol dulu
  document.querySelectorAll('.opsi-btn').forEach(b => b.disabled = true);

  fetch('{{ route("siswa.jawab") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({ question_id: questionId, jawaban }),
  })
  .then(r => r.json())
  .then(data => {
    if (data.error) {
      // Sudah jawab
      document.getElementById('done-today-js').style.display = 'block';
      return;
    }

    // Warnai tombol
    document.querySelectorAll('.opsi-btn').forEach(b => {
      if (b.dataset.jawaban === data.jawaban_benar) {
        b.classList.add('correct');
      }
    });
    if (!data.benar) {
      btn.classList.add('selected-wrong');
    }

    // Feedback
    if (data.benar) {
      document.getElementById('feedback-benar').style.display = 'block';
    } else {
      document.getElementById('feedback-salah').style.display = 'block';
      document.getElementById('jawaban-benar-txt').textContent =
        'Jawaban benar: ' + data.jawaban_benar.toUpperCase();
    }

    // Streak reward
    if (data.streak_increased && data.streak > 0) {
      document.getElementById('streak-reward-num').textContent = data.streak;
      document.getElementById('streak-reward').style.display = 'block';
    }

    // Update streak di bar
    document.getElementById('streak-count')?.innerText && (
      document.getElementById('streak-count').innerText = data.streak
    );

    // Pesan selesai hari ini
    setTimeout(() => {
      document.getElementById('done-today-js').style.display = 'block';
    }, 1500);
  })
  .catch(() => {
    document.querySelectorAll('.opsi-btn').forEach(b => b.disabled = false);
  });
}
</script>
@endpush
@endsection
