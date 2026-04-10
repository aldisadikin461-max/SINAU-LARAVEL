@extends('layouts.siswa')
@section('title','Beasiswa — Sinau')
@section('content')
<style>
  .beasiswa-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.1rem;}
  @media(max-width:600px){.beasiswa-grid{grid-template-columns:1fr;}}

  .bcard{background:#fff;border:1.5px solid rgba(14,165,233,.12);border-radius:1.25rem;padding:1.25rem;display:flex;flex-direction:column;gap:.6rem;box-shadow:0 2px 12px rgba(14,165,233,.06);transition:all .2s;position:relative;}
  .bcard:hover{transform:translateY(-4px);box-shadow:0 10px 28px rgba(14,165,233,.14);border-color:rgba(14,165,233,.25);}

  .bcard-top{display:flex;align-items:start;justify-content:space-between;gap:.5rem;}
  .bcard-nama{font-family:'Fredoka One',sans-serif;font-size:1.05rem;color:#0f172a;line-height:1.3;flex:1;}

  .bcard-bookmark{background:none;border:none;cursor:pointer;font-size:1.2rem;padding:.2rem;line-height:1;transition:transform .2s;}
  .bcard-bookmark:hover{transform:scale(1.2);}

  .bcard-meta{display:flex;gap:.5rem;flex-wrap:wrap;}
  .bmeta{display:inline-flex;align-items:center;gap:.25rem;font-size:.75rem;font-weight:700;color:#64748b;background:#f8fafc;border-radius:999px;padding:.2rem .65rem;}

  .bcard-desc{font-size:.82rem;color:#64748b;font-weight:600;line-height:1.5;flex:1;}

  .bcard-deadline{font-size:.78rem;font-weight:800;color:#dc2626;display:flex;align-items:center;gap:.3rem;}
  .bcard-deadline.safe{color:#16a34a;}
  .bcard-deadline.warn{color:#d97706;}

  .bpill{display:inline-flex;align-items:center;padding:.2rem .7rem;border-radius:999px;font-size:.72rem;font-weight:900;}
  .bpill-aktif{background:#dcfce7;color:#15803d;border:1.5px solid #bbf7d0;}
  .bpill-tutup{background:#fee2e2;color:#dc2626;border:1.5px solid #fecaca;}
  .bpill-segera{background:#fef9c3;color:#a16207;border:1.5px solid #fef08a;}

  .bcard-footer{display:flex;align-items:center;justify-content:space-between;gap:.5rem;flex-wrap:wrap;margin-top:auto;padding-top:.5rem;border-top:1px solid rgba(14,165,233,.07);}

  .btn-detail{display:inline-flex;align-items:center;gap:.3rem;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;border-radius:999px;padding:.38rem 1rem;font-size:.8rem;font-weight:800;text-decoration:none;transition:all .2s;box-shadow:0 3px 10px rgba(14,165,233,.25);}
  .btn-detail:hover{transform:translateY(-1px);box-shadow:0 5px 14px rgba(14,165,233,.35);}

  .filter-chip{padding:.35rem .9rem;border-radius:999px;font-size:.82rem;font-weight:800;border:2px solid rgba(14,165,233,.2);background:#fff;color:#64748b;cursor:pointer;transition:all .18s;text-decoration:none;}
  .filter-chip:hover,.filter-chip.active{background:#0ea5e9;color:#fff;border-color:transparent;}

  .empty-bea{text-align:center;padding:3rem 1rem;color:#94a3b8;}
</style>

{{-- Header --}}
<div class="page-header">
  <div>
    <h1>🎓 Beasiswa</h1>
    <p style="color:#64748b;font-size:.9rem;font-weight:600;margin-top:.25rem;">
      Temukan beasiswa yang cocok untukmu!
    </p>
  </div>
</div>

{{-- Filter --}}
<form method="GET" action="{{ route('siswa.beasiswa') }}">
  <div class="filter-row">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Cari beasiswa..." class="finput" style="width:200px;">

    <select name="jenjang" class="finput">
      <option value="">Semua Jenjang</option>
      <option value="D3" {{ request('jenjang')=='D3'?'selected':'' }}>D3</option>
      <option value="D4" {{ request('jenjang')=='D4'?'selected':'' }}>D4</option>
      <option value="S1" {{ request('jenjang')=='S1'?'selected':'' }}>S1</option>
      <option value="S2" {{ request('jenjang')=='S2'?'selected':'' }}>S2</option>
    </select>

    <select name="tipe" class="finput">
      <option value="">Semua Tipe</option>
      <option value="penuh" {{ request('tipe')=='penuh'?'selected':'' }}>Beasiswa Penuh</option>
      <option value="parsial" {{ request('tipe')=='parsial'?'selected':'' }}>Beasiswa Parsial</option>
    </select>

    <select name="status" class="finput">
      <option value="">Semua Status</option>
      <option value="aktif" {{ request('status')=='aktif'?'selected':'' }}>Aktif</option>
      <option value="tutup" {{ request('status')=='tutup'?'selected':'' }}>Tutup</option>
    </select>

    <button type="submit" class="fbtn">🔍 Filter</button>
    @if(request()->hasAny(['search','jenjang','tipe','status']))
      <a href="{{ route('siswa.beasiswa') }}" class="fbtn" style="background:#64748b;box-shadow:none;">✕ Reset</a>
    @endif
  </div>
</form>

{{-- Summary --}}
<div style="margin-bottom:1.25rem;">
  <span style="font-weight:800;color:#64748b;font-size:.9rem;">
    📊 {{ $scholarships->total() }} beasiswa ditemukan
  </span>
</div>

{{-- Grid --}}
@if($scholarships->count() > 0)
<div class="beasiswa-grid">
  @foreach($scholarships as $s)
  @php
    $isBookmarked = in_array($s->id, $bookmarked);
    $deadline = $s->deadline ? \Carbon\Carbon::parse($s->deadline) : null;
    $daysLeft = $deadline ? now()->diffInDays($deadline, false) : null;

    if (!$deadline) {
      $deadlineClass = 'safe';
      $deadlineText = 'Tidak ada deadline';
    } elseif ($daysLeft < 0) {
      $deadlineClass = '';
      $deadlineText = 'Sudah tutup';
    } elseif ($daysLeft <= 7) {
      $deadlineClass = 'warn';
      $deadlineText = "⚠️ {$daysLeft} hari lagi";
    } else {
      $deadlineClass = 'safe';
      $deadlineText = '📅 ' . $deadline->format('d M Y');
    }

    $statusClass = match($s->status ?? 'aktif') {
      'aktif'  => 'bpill-aktif',
      'tutup'  => 'bpill-tutup',
      default  => 'bpill-segera',
    };
    $statusLabel = match($s->status ?? 'aktif') {
      'aktif'  => '✅ Aktif',
      'tutup'  => '❌ Tutup',
      default  => '⏳ Segera',
    };
  @endphp
  <div class="bcard">
    <div class="bcard-top">
      <div class="bcard-nama">{{ $s->nama }}</div>
      <div style="display:flex;align-items:center;gap:.4rem;">
        <span class="bpill {{ $statusClass }}">{{ $statusLabel }}</span>
        {{-- Bookmark --}}
        <form method="POST" action="{{ route('siswa.beasiswa.bookmark') }}" style="display:inline;">
          @csrf
          <input type="hidden" name="scholarship_id" value="{{ $s->id }}">
          <button type="submit" class="bcard-bookmark" title="{{ $isBookmarked ? 'Hapus bookmark' : 'Simpan' }}">
            {{ $isBookmarked ? '🔖' : '🏷️' }}
          </button>
        </form>
      </div>
    </div>

    <div class="bcard-meta">
      @if($s->jenjang)
        <span class="bmeta">🎓 {{ $s->jenjang }}</span>
      @endif
      @if($s->tipe)
        <span class="bmeta">💰 {{ ucfirst($s->tipe) }}</span>
      @endif
      @if($s->penyelenggara)
        <span class="bmeta">🏛️ {{ $s->penyelenggara }}</span>
      @endif
    </div>

    @if($s->deskripsi)
    <div class="bcard-desc">{{ Str::limit($s->deskripsi, 120) }}</div>
    @endif

    <div class="bcard-footer">
      <div class="bcard-deadline {{ $deadlineClass }}">
        ⏰ {{ $deadlineText }}
      </div>
      @if($s->link)
        <a href="{{ $s->link }}" target="_blank" rel="noopener" class="btn-detail">
          🔗 Detail
        </a>
      @endif
    </div>
  </div>
  @endforeach
</div>

<div style="margin-top:1.25rem;">
  {{ $scholarships->links() }}
</div>

@else
<div class="empty-bea">
  <div style="font-size:3rem;margin-bottom:.75rem;">🎓</div>
  <div style="font-weight:700;font-size:1rem;">Belum ada beasiswa yang tersedia</div>
  <div style="font-size:.85rem;margin-top:.35rem;">Coba ubah filter atau cek lagi nanti ya!</div>
</div>
@endif

@endsection