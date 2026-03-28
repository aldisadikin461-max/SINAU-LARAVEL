@extends('layouts.siswa')
@section('title','Latihan Soal')
@section('content')
<style>
  .card{background:#fff;border:1px solid rgba(14,165,233,.1);border-radius:1.25rem;box-shadow:0 4px 20px rgba(14,165,233,.07);padding:1.5rem;}
  .page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:1.25rem;}
  .filter-row{display:flex;gap:.75rem;flex-wrap:wrap;margin-bottom:1.5rem;}
  .finput{background:#fff;border:2px solid rgba(14,165,233,.15);border-radius:999px;padding:.45rem 1.1rem;font-size:.88rem;font-weight:700;color:#1e293b;outline:none;font-family:'Nunito',sans-serif;transition:border-color .2s;}
  .finput:focus{border-color:#0ea5e9;}
  .fbtn{padding:.45rem 1.3rem;border-radius:999px;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;font-size:.88rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;transition:all .2s;}
  .fbtn:hover{transform:translateY(-2px);}
  .soal-meta{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;}
  .soal-pertanyaan{font-size:1.1rem;font-weight:800;color:#0f172a;line-height:1.6;margin-bottom:1.5rem;}
  .opsi-list{display:flex;flex-direction:column;gap:.75rem;}
  .opsi-btn{background:#fff;border:2px solid rgba(14,165,233,.15);border-radius:1rem;padding:.9rem 1.2rem;color:#1e293b;cursor:pointer;transition:all .15s;text-align:left;width:100%;font-family:'Nunito',sans-serif;font-size:.95rem;font-weight:700;box-shadow:0 2px 8px rgba(0,0,0,.04);}
  .opsi-btn:hover{background:#f0f9ff;border-color:#0ea5e9;}
  .opsi-btn.correct{background:#dcfce7;border-color:#22c55e;color:#16a34a;}
  .opsi-btn.wrong{background:#fee2e2;border-color:#ef4444;color:#dc2626;}
  .opsi-btn:disabled{cursor:not-allowed;}
  .opsi-key{font-weight:900;color:#0ea5e9;margin-right:.6rem;}
  .btn-next{display:block;text-align:center;background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;padding:.9rem;border-radius:999px;font-weight:800;font-size:1rem;text-decoration:none;margin-top:1.25rem;box-shadow:0 4px 16px rgba(14,165,233,.3);transition:all .2s;font-family:'Nunito',sans-serif;}
  .btn-next:hover{transform:translateY(-2px);}
  .empty-state{text-align:center;padding:3rem;}
  .empty-state .ei{font-size:3.5rem;margin-bottom:.75rem;}
  .empty-state p{color:#94a3b8;font-weight:700;}
</style>

<div class="page-title">❓ Latihan Soal Harian</div>

<form method="GET" class="filter-row">
  <select name="category_id" class="finput">
    <option value="">Semua Kategori</option>
    @foreach($categories as $c)
      <option value="{{ $c->id }}" {{ request('category_id')==$c->id?'selected':'' }}>{{ $c->nama_kategori }}</option>
    @endforeach
  </select>
  <select name="tingkat" class="finput">
    <option value="">Semua Tingkat</option>
    @foreach(['mudah','sedang','sulit'] as $t)
      <option value="{{ $t }}" {{ request('tingkat')==$t?'selected':'' }}>{{ ucfirst($t) }}</option>
    @endforeach
  </select>
  <button type="submit" class="fbtn">🎲 Soal Baru</button>
</form>

@if($soal)
  <div class="card" style="max-width:700px;">
    <div class="soal-meta">
      <span style="background:#e0f2fe;color:#0284c7;border-radius:999px;padding:.25rem .8rem;font-size:.8rem;font-weight:800;">{{ $soal->category->nama_kategori }}</span>
      <span style="color:#94a3b8;font-size:.82rem;font-weight:700;text-transform:capitalize;">{{ $soal->tingkat_kesulitan }}</span>
    </div>
    <div class="soal-pertanyaan">{{ $soal->pertanyaan }}</div>
    <div class="opsi-list">
      @foreach(['a','b','c','d'] as $opt)
        <button class="opsi-btn" data-jawaban="{{ $opt }}" onclick="jawabSoal({{ $soal->id }},'{{ $opt }}',this)">
          <span class="opsi-key">{{ strtoupper($opt) }}.</span>{{ $soal->{'opsi_'.$opt} }}
        </button>
      @endforeach
    </div>
    <div id="btn-soal-berikutnya" class="hidden" style="display:none;">
      <a href="{{ route('siswa.latihan',request()->all()) }}" class="btn-next">Soal Berikutnya →</a>
    </div>
  </div>
@else
  <div class="card empty-state">
    <div class="ei">🐱</div>
    <p>Kinners bingung... belum ada soal untuk kategori ini!</p>
  </div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded',()=>{
  document.querySelectorAll('.opsi-btn').forEach(b=>{
    b.addEventListener('click',function(){
      jawabSoal({{ $soal?->id??0 }},this.dataset.jawaban,this);
    });
  });
});
</script>
@endpush
@endsection