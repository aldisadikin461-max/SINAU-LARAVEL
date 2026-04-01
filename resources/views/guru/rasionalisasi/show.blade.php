@extends('layouts.guru')
@section('title','Detail Rasionalisasi')
@section('content')
<style>
:root{--blue:#1a8cff;--border:#d0e4f7;}
.back{color:var(--blue);font-size:.88rem;font-weight:800;text-decoration:none;display:inline-block;margin-bottom:1rem;}
.page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:1.25rem;}
.siswa-info{background:#fff;border:2px solid var(--border);border-radius:1.25rem;padding:1.5rem;box-shadow:0 3px 0 var(--border);margin-bottom:1.5rem;display:flex;gap:1.5rem;flex-wrap:wrap;align-items:center;}
.si-avatar{width:3.5rem;height:3.5rem;border-radius:50%;background:#e8f4ff;display:flex;align-items:center;justify-content:center;font-size:1.5rem;flex-shrink:0;}
.si-name{font-family:'Fredoka One',sans-serif;font-size:1.2rem;color:#0f172a;}
.si-meta{font-size:.82rem;color:#94a3b8;font-weight:700;margin-top:.2rem;}
.skor-big{font-family:'Fredoka One',sans-serif;font-size:2.5rem;margin-left:auto;}
.card{background:#fff;border:2px solid var(--border);border-radius:1.25rem;padding:1.5rem;box-shadow:0 3px 0 var(--border);margin-bottom:1.25rem;}
.card-title{font-family:'Fredoka One',sans-serif;font-size:1.1rem;color:var(--blue);margin-bottom:1rem;}
.input-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:.75rem;}
.inp-item{background:#f8fafc;border-radius:.875rem;padding:.65rem 1rem;}
.inp-label{font-size:.75rem;font-weight:800;color:#94a3b8;margin-bottom:.15rem;}
.inp-val{font-weight:800;font-size:.95rem;color:#0f172a;}
.rek-item{border:1.5px solid var(--border);border-radius:1rem;padding:1rem;margin-bottom:.75rem;}
.rek-nama{font-family:'Fredoka One',sans-serif;font-size:1rem;color:var(--blue);margin-bottom:.35rem;}
.rek-desc{font-size:.85rem;color:#64748b;font-weight:600;margin-bottom:.6rem;}
.chips{display:flex;gap:.4rem;flex-wrap:wrap;}
.chip{background:#e8f4ff;color:var(--blue);border-radius:999px;padding:.2rem .65rem;font-size:.76rem;font-weight:800;}
.chip-o{background:#fef9c3;color:#ca8a04;}
.action-list{display:flex;flex-direction:column;gap:.5rem;}
.action-item{display:flex;gap:.6rem;align-items:flex-start;}
.an{background:var(--blue);color:#fff;border-radius:999px;width:1.4rem;height:1.4rem;display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:900;flex-shrink:0;}
.at{font-size:.85rem;font-weight:700;color:#1e293b;}
</style>

<a href="{{ route('guru.rasionalisasi.index') }}" class="back">← Kembali ke Daftar</a>

@php $h=$rasi->hasil_ai??[]; @endphp

<div class="siswa-info">
  <div class="si-avatar">👤</div>
  <div>
    <div class="si-name">{{ $rasi->user->name }}</div>
    <div class="si-meta">
      Jurusan: {{ $rasi->user->jurusan??'-' }} · Kelas: {{ $rasi->user->kelas??'-' }}
      · {{ $rasi->created_at->format('d M Y H:i') }}
    </div>
    <div style="margin-top:.4rem;">
      <span style="background:#e8f4ff;color:var(--blue);border-radius:999px;padding:.18rem .65rem;font-size:.78rem;font-weight:800;">
        {{ $rasi->mode==='kuliah'?'🎓 Kuliah':'💼 Karir' }}
      </span>
      @if(!empty($h['tingkat_peluang']))
        <span style="background:#dcfce7;color:#16a34a;border-radius:999px;padding:.18rem .65rem;font-size:.78rem;font-weight:800;margin-left:.4rem;">
          Peluang: {{ $h['tingkat_peluang'] }}
        </span>
      @endif
    </div>
  </div>
  @php $skor=$rasi->skor_kesiapan??0; $warna=$skor>=75?'#16a34a':($skor>=50?'#d97706':'#dc2626'); @endphp
  <div class="skor-big" style="color:{{ $warna }}">{{ $skor }}<span style="font-size:.9rem;color:#94a3b8;"> /100</span></div>
</div>

{{-- Input Data --}}
<div class="card">
  <div class="card-title">📋 Data Input Siswa</div>
  <div class="input-grid">
    @if($rasi->mode==='kuliah')
      @foreach($rasi->input_data['nilai_list']??[] as $mapel=>$val)
        <div class="inp-item">
          <div class="inp-label">{{ $mapel }}</div>
          <div class="inp-val">{{ $val }}</div>
        </div>
      @endforeach
      <div class="inp-item">
        <div class="inp-label">Nilai Produktif</div>
        <div class="inp-val">{{ $rasi->input_data['nilai_produktif']??'-' }}</div>
      </div>
      <div class="inp-item">
        <div class="inp-label">Rata-rata</div>
        <div class="inp-val" style="color:var(--blue);">{{ $rasi->input_data['rata_rata']??'-' }}</div>
      </div>
      <div class="inp-item">
        <div class="inp-label">Mapel Terkuat</div>
        <div class="inp-val" style="color:#16a34a;">{{ $rasi->input_data['mapel_terkuat']??'-' }}</div>
      </div>
    @else
      <div class="inp-item">
        <div class="inp-label">Minat Kerja</div>
        <div class="inp-val">{{ $rasi->input_data['minat']??'-' }}</div>
      </div>
      <div class="inp-item" style="grid-column:1/-1;">
        <div class="inp-label">Skill</div>
        <div class="chips" style="margin-top:.3rem;">
          @foreach($rasi->input_data['skills']??[] as $s)
            <span class="chip">{{ $s }}</span>
          @endforeach
        </div>
      </div>
    @endif
  </div>
</div>

{{-- Ringkasan AI --}}
<div class="card">
  <div class="card-title">💬 Ringkasan AI</div>
  <p style="font-size:.9rem;font-weight:600;color:#64748b;line-height:1.7;">{{ $h['ringkasan']??'-' }}</p>
</div>

{{-- Rekomendasi --}}
@if($rasi->mode==='kuliah' && !empty($h['rekomendasi_jurusan']))
  <div class="card">
    <div class="card-title">🎯 Rekomendasi Jurusan</div>
    @foreach($h['rekomendasi_jurusan'] as $i=>$rek)
      <div class="rek-item">
        <div class="rek-nama">{{ $i+1 }}. {{ $rek['nama_prodi']??'-' }}</div>
        <div class="rek-desc">{{ $rek['relevansi']??'' }}</div>
        @if(!empty($rek['prospek_karir']))
          <div class="chips">
            @foreach($rek['prospek_karir'] as $pk)
              <span class="chip">{{ $pk }}</span>
            @endforeach
          </div>
        @endif
        @if(!empty($rek['kampus']))
          <div style="margin-top:.6rem;font-size:.78rem;font-weight:800;color:#94a3b8;">Kampus:</div>
          <div class="chips" style="margin-top:.2rem;">
            @foreach($rek['kampus'] as $k)
              <span class="chip chip-o">{{ $k['nama']??'' }} ({{ $k['kota']??'' }})</span>
            @endforeach
          </div>
        @endif
      </div>
    @endforeach
  </div>
@endif

@if($rasi->mode==='kerja' && !empty($h['rekomendasi_karir']))
  <div class="card">
    <div class="card-title">💼 Rekomendasi Karir</div>
    @foreach($h['rekomendasi_karir'] as $i=>$rek)
      <div class="rek-item">
        <div class="rek-nama">{{ $i+1 }}. {{ $rek['posisi']??'-' }}</div>
        <div class="rek-desc">{{ $rek['deskripsi']??'' }}</div>
        <div style="margin-bottom:.4rem;"><span class="chip" style="background:#dcfce7;color:#16a34a;">💰 {{ $rek['gaji_entry']??'' }}</span></div>
        @if(!empty($rek['perusahaan']))
          <div style="font-size:.78rem;font-weight:800;color:#94a3b8;">Perusahaan:</div>
          <div class="chips" style="margin-top:.2rem;">
            @foreach($rek['perusahaan'] as $p)
              <span class="chip chip-o">{{ $p['nama']??'' }}</span>
            @endforeach
          </div>
        @endif
      </div>
    @endforeach
  </div>
@endif

{{-- Action Plan --}}
@if(!empty($h['action_plan']))
  <div class="card">
    <div class="card-title">⚡ Action Plan Siswa</div>
    <div class="action-list">
      @foreach($h['action_plan'] as $i=>$act)
        <div class="action-item"><div class="an">{{ $i+1 }}</div><div class="at">{{ $act }}</div></div>
      @endforeach
    </div>
  </div>
@endif
@endsection
