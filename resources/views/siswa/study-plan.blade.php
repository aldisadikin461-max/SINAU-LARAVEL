@extends('layouts.siswa')
@section('title','Study Plan')
@section('content')
<style>
  .sp-grid{display:grid;grid-template-columns:1fr 2fr;gap:1.25rem;}
  @media(max-width:768px){.sp-grid{grid-template-columns:1fr;}}

  /* Form card */
  .sp-form-card{background:#fff;border:1.5px solid rgba(14,165,233,.15);border-radius:1.25rem;padding:1.5rem;box-shadow:0 4px 20px rgba(14,165,233,.07);}
  .sp-form-title{font-family:'Fredoka One',sans-serif;font-size:1.1rem;color:#0284c7;margin-bottom:1.1rem;display:flex;align-items:center;gap:.4rem;}

  .sp-label{display:block;font-size:.82rem;font-weight:800;color:#64748b;margin-bottom:.4rem;}
  .sp-input{
    width:100%;background:#f0f9ff;
    border:2px solid rgba(14,165,233,.2);
    border-radius:.875rem;
    padding:.5rem 1rem;
    font-size:.9rem;font-weight:700;
    color:#1e293b;outline:none;
    font-family:'Nunito',sans-serif;
    transition:border-color .2s,background .2s;
    box-sizing:border-box;
  }
  .sp-input:focus{border-color:#0ea5e9;background:#fff;box-shadow:0 0 0 3px rgba(14,165,233,.1);}
  .sp-input::placeholder{color:#94a3b8;font-weight:600;}

  .sp-btn{
    width:100%;padding:.55rem 1rem;
    background:linear-gradient(135deg,#0ea5e9,#0284c7);
    color:#fff;border:none;border-radius:.875rem;
    font-size:.9rem;font-weight:800;
    font-family:'Nunito',sans-serif;
    cursor:pointer;transition:all .2s;
    box-shadow:0 3px 12px rgba(14,165,233,.3);
    margin-top:.25rem;
  }
  .sp-btn:hover{transform:translateY(-2px);box-shadow:0 6px 18px rgba(14,165,233,.35);}

  /* Plan list */
  .sp-list{display:flex;flex-direction:column;gap:.75rem;}

  .sp-item{
    background:#fff;border:1.5px solid rgba(14,165,233,.12);
    border-radius:1.1rem;padding:1rem 1.1rem;
    display:flex;align-items:center;justify-content:space-between;
    gap:1rem;box-shadow:0 2px 10px rgba(14,165,233,.06);
    transition:all .2s;
  }
  .sp-item:hover{border-color:rgba(14,165,233,.25);box-shadow:0 6px 20px rgba(14,165,233,.1);}
  .sp-item.done{background:#f0fdf4;border-color:rgba(22,163,74,.15);}

  .sp-item-left{display:flex;align-items:center;gap:.75rem;flex:1;min-width:0;}

  .sp-toggle{
    background:none;border:none;cursor:pointer;
    font-size:1.3rem;padding:.2rem;line-height:1;
    transition:transform .2s;flex-shrink:0;
  }
  .sp-toggle:hover{transform:scale(1.2);}

  .sp-item-title{font-weight:800;font-size:.9rem;color:#0f172a;line-height:1.3;}
  .sp-item-title.done-text{text-decoration:line-through;color:#94a3b8;}

  .sp-item-date{font-size:.75rem;font-weight:700;color:#64748b;margin-top:.2rem;display:flex;align-items:center;gap:.3rem;}
  .sp-late{color:#dc2626;font-weight:800;}
  .sp-done-badge{color:#16a34a;font-weight:800;}

  .sp-delete{
    background:none;border:none;cursor:pointer;
    font-size:1rem;color:#cbd5e1;padding:.3rem;
    transition:color .18s;flex-shrink:0;
  }
  .sp-delete:hover{color:#ef4444;}

  /* Empty */
  .sp-empty{text-align:center;padding:2.5rem 1rem;color:#94a3b8;background:#f8fafc;border:1.5px dashed rgba(14,165,233,.2);border-radius:1.25rem;}
</style>

<div class="page-header">
  <div>
    <h1>📅 Study Plan</h1>
    <p style="color:#64748b;font-size:.9rem;font-weight:600;margin-top:.25rem;">
      Rencanakan belajarmu, raih impianmu! 🎯
    </p>
  </div>
</div>

<div class="sp-grid">

  {{-- Form Tambah --}}
  <div class="sp-form-card">
    <div class="sp-form-title">➕ Tambah Rencana</div>
    <form method="POST" action="{{ route('siswa.study-plan.store') }}">
      @csrf
      <div style="margin-bottom:.9rem;">
        <label class="sp-label">Judul Rencana</label>
        <input name="judul" value="{{ old('judul') }}"
               placeholder="Belajar Laravel..."
               class="sp-input">
        @error('judul')
          <p style="color:#dc2626;font-size:.75rem;font-weight:700;margin-top:.3rem;">{{ $message }}</p>
        @enderror
      </div>
      <div style="margin-bottom:1.1rem;">
        <label class="sp-label">Target Tanggal</label>
        <input name="target_date" type="date"
               value="{{ old('target_date') }}"
               class="sp-input">
        @error('target_date')
          <p style="color:#dc2626;font-size:.75rem;font-weight:700;margin-top:.3rem;">{{ $message }}</p>
        @enderror
      </div>
      <button type="submit" class="sp-btn">
        📌 Tambahkan
      </button>
    </form>
  </div>

  {{-- Daftar Rencana --}}
  <div>
    @php
      $done    = $plans->where('status','done')->count();
      $total   = $plans->count();
    @endphp

    @if($total > 0)
    <div style="margin-bottom:1rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.5rem;">
      <span style="font-weight:800;color:#64748b;font-size:.88rem;">
        📋 {{ $total }} rencana
      </span>
      <span style="font-weight:800;font-size:.82rem;color:#16a34a;">
        ✅ {{ $done }}/{{ $total }} selesai
      </span>
    </div>
    @endif

    <div class="sp-list">
      @forelse($plans as $plan)
      <div class="sp-item {{ $plan->status === 'done' ? 'done' : '' }}">
        <div class="sp-item-left">
          <button onclick="togglePlan({{ $plan->id }}, this)"
                  class="sp-toggle" title="Toggle selesai">
            {{ $plan->status === 'done' ? '✅' : '⬜' }}
          </button>
          <div style="min-width:0;">
            <div class="sp-item-title {{ $plan->status === 'done' ? 'done-text' : '' }}">
              {{ $plan->judul }}
            </div>
            <div class="sp-item-date">
              🎯 {{ $plan->target_date->format('d M Y') }}
              @if($plan->status === 'done')
                <span class="sp-done-badge">· Selesai!</span>
              @elseif($plan->target_date->isPast())
                <span class="sp-late">· Terlambat!</span>
              @else
                @php $sisa = now()->diffInDays($plan->target_date, false); @endphp
                @if($sisa <= 3)
                  <span style="color:#d97706;font-weight:800;">· {{ $sisa }} hari lagi</span>
                @endif
              @endif
            </div>
          </div>
        </div>
        <form method="POST" action="{{ route('siswa.study-plan.destroy', $plan) }}"
              onsubmit="return confirm('Hapus rencana ini?')">
          @csrf @method('DELETE')
          <button type="submit" class="sp-delete" title="Hapus">🗑️</button>
        </form>
      </div>
      @empty
      <div class="sp-empty">
        <div style="font-size:3rem;margin-bottom:.75rem;">🐱</div>
        <div style="font-weight:700;font-size:1rem;">Belum ada rencana belajar</div>
        <div style="font-size:.85rem;margin-top:.35rem;">Kinners nunggu rencanamu!</div>
      </div>
      @endforelse
    </div>
  </div>

</div>

@push('scripts')
<script>
function togglePlan(id, btn) {
  const isDone = btn.textContent.trim() === '✅';
  const newStatus = isDone ? 'pending' : 'done';
  fetch(`/siswa/study-plan/${id}`, {
    method: 'PATCH',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({ status: newStatus }),
  }).then(() => location.reload());
}
</script>
@endpush
@endsection