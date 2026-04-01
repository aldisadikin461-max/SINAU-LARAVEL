@extends('layouts.siswa')
@section('title','Riwayat Rasionalisasi')
@section('content')
<style>
:root{--blue:#1a8cff;--blue-press:#005bb8;--border:#d0e4f7;}
.wrap{max-width:760px;margin:0 auto;}
.page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:.4rem;}
.top-row{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem;}
.filter-row{display:flex;gap:.6rem;flex-wrap:wrap;margin-bottom:1.25rem;}
.ftab{padding:.4rem 1.1rem;border-radius:999px;font-size:.85rem;font-weight:800;text-decoration:none;border:2px solid var(--border);background:#fff;color:#64748b;transition:all .18s;}
.ftab:hover,.ftab.on{background:var(--blue);color:#fff;border-color:var(--blue);}
.riwayat-list{display:flex;flex-direction:column;gap:.85rem;}
.rcard{background:#fff;border:2px solid var(--border);border-radius:1.25rem;padding:1.25rem 1.5rem;box-shadow:0 3px 0 var(--border);display:flex;align-items:center;gap:1rem;transition:all .2s;}
.rcard:hover{border-color:var(--blue);transform:translateY(-2px);box-shadow:0 6px 0 var(--border);}
.rcard-ico{font-size:2rem;background:var(--blue-light,#e8f4ff);width:3rem;height:3rem;border-radius:.875rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.rcard-ico.kerja{background:#fef9c3;}
.rcard-main{flex:1;}
.rcard-title{font-family:'Fredoka One',sans-serif;font-size:1rem;color:#0f172a;}
.rcard-sub{font-size:.78rem;color:#94a3b8;font-weight:700;margin-top:.15rem;}
.rcard-skor{font-family:'Fredoka One',sans-serif;font-size:1.4rem;}
.rcard-actions{display:flex;flex-direction:column;gap:.4rem;align-items:flex-end;}
.btn-detail{padding:.35rem .9rem;border-radius:999px;background:var(--blue);color:#fff;font-size:.78rem;font-weight:800;text-decoration:none;}
.btn-del{padding:.3rem .8rem;border-radius:999px;background:#fee2e2;color:#dc2626;font-size:.74rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;}
.empty-state{text-align:center;padding:3rem;background:#fff;border:2px dashed var(--border);border-radius:1.25rem;color:#94a3b8;font-weight:700;}
.btn-new{padding:.55rem 1.4rem;border-radius:999px;background:var(--blue);color:#fff;font-size:.88rem;font-weight:800;text-decoration:none;box-shadow:0 4px 0 var(--blue-press);}
</style>

<div class="wrap">
  <div class="top-row">
    <div class="page-title">📋 Riwayat Rasionalisasi</div>
    <a href="{{ route('siswa.rasionalisasi.index') }}" class="btn-new">+ Baru</a>
  </div>

  <div class="filter-row">
    <a href="{{ route('siswa.rasionalisasi.riwayat') }}" class="ftab {{ !request('mode')?'on':'' }}">Semua</a>
    <a href="{{ route('siswa.rasionalisasi.riwayat',['mode'=>'kuliah']) }}" class="ftab {{ request('mode')==='kuliah'?'on':'' }}">🎓 Kuliah</a>
    <a href="{{ route('siswa.rasionalisasi.riwayat',['mode'=>'kerja']) }}" class="ftab {{ request('mode')==='kerja'?'on':'' }}">💼 Karir</a>
  </div>

  <div class="riwayat-list">
    @forelse($riwayat as $r)
      @php
        $skor=$r->skor_kesiapan??0;
        $warna=$skor>=75?'#16a34a':($skor>=50?'#d97706':'#dc2626');
      @endphp
      <div class="rcard">
        <div class="rcard-ico {{ $r->mode }}">{{ $r->mode==='kuliah'?'🎓':'💼' }}</div>
        <div class="rcard-main">
          <div class="rcard-title">
            {{ $r->mode==='kuliah'?'Rasionalisasi Kuliah':'Rasionalisasi Karir' }}
            — <span style="color:var(--blue);">{{ $r->input_data['jurusan']??'-' }}</span>
          </div>
          <div class="rcard-sub">
            {{ $r->created_at->format('d M Y, H:i') }}
            @if($r->mode==='kuliah' && isset($r->hasil_ai['tingkat_peluang']))
              · Peluang: {{ $r->hasil_ai['tingkat_peluang'] }}
            @endif
            @if($r->mode==='kerja' && !empty($r->input_data['minat']))
              · Minat: {{ $r->input_data['minat'] }}
            @endif
          </div>
        </div>
        <div class="rcard-skor" style="color:{{ $warna }}">{{ $skor ?: '-' }}</div>
        <div class="rcard-actions">
          <a href="{{ route('siswa.rasionalisasi.hasil', $r->id) }}" class="btn-detail">Lihat →</a>
          <form method="POST" action="{{ route('siswa.rasionalisasi.destroy', $r->id) }}"
                onsubmit="return confirm('Hapus hasil ini?')">
            @csrf @method('DELETE')
            <button class="btn-del">🗑️ Hapus</button>
          </form>
        </div>
      </div>
    @empty
      <div class="empty-state">
        <div style="font-size:2.5rem;margin-bottom:.5rem;">🐱</div>
        Belum ada riwayat rasionalisasi.
        <br><a href="{{ route('siswa.rasionalisasi.index') }}" style="color:var(--blue);font-weight:800;">Mulai sekarang →</a>
      </div>
    @endforelse
  </div>
  <div style="margin-top:1rem;">{{ $riwayat->links() }}</div>
</div>
@endsection
