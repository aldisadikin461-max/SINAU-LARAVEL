@extends('layouts.siswa')
@section('title','Riwayat')
@section('content')
<style>
  .page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:1.25rem;}
  .card{background:#fff;border:1px solid rgba(14,165,233,.1);border-radius:1.25rem;overflow:hidden;box-shadow:0 4px 20px rgba(14,165,233,.07);}
  table{width:100%;border-collapse:collapse;font-family:'Nunito',sans-serif;}
  thead tr{background:#f0f9ff;border-bottom:2px solid rgba(14,165,233,.1);}
  thead th{padding:.85rem 1.25rem;text-align:left;font-size:.8rem;font-weight:800;color:#0284c7;text-transform:uppercase;letter-spacing:.04em;}
  tbody tr{border-bottom:1px solid rgba(14,165,233,.06);transition:background .15s;}
  tbody tr:hover{background:#f0f9ff;}
  tbody td{padding:.85rem 1.25rem;font-size:.88rem;font-weight:700;}
  .cat-chip{background:#e0f2fe;color:#0284c7;border-radius:999px;padding:.18rem .7rem;font-size:.76rem;font-weight:800;}
  .benar{background:#dcfce7;color:#16a34a;border-radius:999px;padding:.18rem .7rem;font-size:.76rem;font-weight:800;}
  .salah{background:#fee2e2;color:#dc2626;border-radius:999px;padding:.18rem .7rem;font-size:.76rem;font-weight:800;}
  .jwb{font-weight:900;text-transform:uppercase;color:#64748b;}
  .ts{color:#94a3b8;font-size:.78rem;}
</style>
<div class="page-title">📋 Riwayat Jawaban</div>
<div class="card">
  <div style="overflow-x:auto;">
  <table>
    <thead><tr><th>Pertanyaan</th><th>Kategori</th><th>Jawaban</th><th>Hasil</th><th>Waktu</th></tr></thead>
    <tbody>
      @forelse($answers as $a)
        <tr>
          <td style="max-width:280px;">{{ Str::limit($a->question->pertanyaan,60) }}</td>
          <td><span class="cat-chip">{{ $a->question->category->nama_kategori }}</span></td>
          <td class="jwb">{{ $a->jawaban }}</td>
          <td>@if($a->is_correct)<span class="benar">✅ Benar</span>@else<span class="salah">❌ Salah</span>@endif</td>
          <td class="ts">{{ $a->answered_at?->format('d M Y H:i')??'-' }}</td>
        </tr>
      @empty
        <tr><td colspan="5" style="text-align:center;padding:2.5rem;color:#94a3b8;font-weight:700;">🐱 Belum ada jawaban. Yuk mulai latihan!</td></tr>
      @endforelse
    </tbody>
  </table>
  </div>
  <div style="padding:1rem;">{{ $answers->links() }}</div>
</div>
@endsection