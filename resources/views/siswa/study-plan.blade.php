@extends('layouts.siswa')
@section('title','Study Plan')
@section('content')

<h1 class="text-2xl font-bold mb-6">📅 Study Plan</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
  {{-- Form tambah --}}
  <div class="glass-card p-5">
    <h2 class="font-bold mb-4">+ Tambah Rencana</h2>
    <form method="POST" action="{{ route('siswa.study-plan.store') }}">
      @csrf
      <div class="mb-3">
        <label class="block text-sm text-slate-400 mb-1">Judul Rencana</label>
        <input name="judul" value="{{ old('judul') }}" placeholder="Belajar Laravel..."
          class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-blue-500">
        @error('judul')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
      </div>
      <div class="mb-4">
        <label class="block text-sm text-slate-400 mb-1">Target Tanggal</label>
        <input name="target_date" type="date" value="{{ old('target_date') }}"
          class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-blue-500">
        @error('target_date')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
      </div>
      <button class="w-full bg-blue-600 hover:bg-blue-500 text-white py-2 rounded-lg text-sm font-semibold">
        Tambahkan
      </button>
    </form>
  </div>

  {{-- Daftar rencana --}}
  <div class="md:col-span-2 space-y-3">
    @forelse($plans as $plan)
      <div class="glass-card p-4 flex items-center justify-between gap-4">
        <div class="flex items-center gap-3">
          <button onclick="togglePlan({{ $plan->id }}, this)"
                  class="text-xl {{ $plan->status === 'done' ? 'text-green-400' : 'text-slate-500 hover:text-green-400' }}
                          transition" title="Toggle selesai">
            {{ $plan->status === 'done' ? '✅' : '⬜' }}
          </button>
          <div>
            <div class="font-medium {{ $plan->status === 'done' ? 'line-through text-slate-500' : '' }}">
              {{ $plan->judul }}
            </div>
            <div class="text-xs text-slate-400 mt-0.5">
              🎯 {{ $plan->target_date->format('d M Y') }}
              @if($plan->target_date->isPast() && $plan->status === 'pending')
                <span class="text-red-400 ml-1">Terlambat!</span>
              @endif
            </div>
          </div>
        </div>
        <form method="POST" action="{{ route('siswa.study-plan.destroy', $plan) }}" onsubmit="return confirm('Hapus rencana ini?')">
          @csrf @method('DELETE')
          <button class="text-slate-500 hover:text-red-400 transition text-sm">🗑️</button>
        </form>
      </div>
    @empty
      <div class="glass-card p-8 text-center text-slate-500">
        <div class="text-4xl mb-2">🐱</div>
        Belum ada rencana belajar. Kinners nunggu rencanamu!
      </div>
    @endforelse
  </div>
</div>

@push('scripts')
<script>
function togglePlan(id, btn) {
  const newStatus = btn.textContent.trim() === '⬜' ? 'done' : 'pending';
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
