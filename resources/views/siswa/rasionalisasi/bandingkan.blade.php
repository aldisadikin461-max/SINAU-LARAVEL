@extends('layouts.siswa')
@section('title','Bandingkan Rasionalisasi')
@section('content')
<style>
:root{--blue:#1a8cff;--blue-press:#005bb8;--border:#d0e4f7;}
.wrap{max-width:960px;margin:0 auto;}
.page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:.4rem;}
.page-sub{color:#64748b;font-weight:600;font-size:.9rem;margin-bottom:1.5rem;}
.picker-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:2rem;}
@media(max-width:600px){.picker-row{grid-template-columns:1fr;}}
.picker-card{background:#fff;border:2px solid var(--border);border-radius:1.25rem;padding:1.25rem;box-shadow:0 3px 0 var(--border);}
.picker-label{font-family:'Fredoka One',sans-serif;font-size:1rem;color:#0f172a;margin-bottom:.75rem;}
.fi{width:100%;background:#f8fafc;border:2px solid var(--border);border-radius:.875rem;padding:.6rem 1rem;font-size:.88rem;font-weight:700;color:#1e293b;outline:none;font-family:'Nunito',sans-serif;margin-bottom:.75rem;transition:border-color .2s;}
.fi:focus{border-color:var(--blue);}
.btn-bandingkan{width:100%;padding:.65rem;border-radius:999px;background:var(--blue);color:#fff;font-family:'Fredoka One',sans-serif;font-size:1rem;border:none;cursor:pointer;box-shadow:0 4px 0 var(--blue-press);transition:all .15s;}
.btn-bandingkan:hover{transform:translateY(2px);box-shadow:0 2px 0 var(--blue-press);}
/* Compare grid */
.compare-grid{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;}
@media(max-width:600px){.compare-grid{grid-template-columns:1fr;}}
.compare-col{display:flex;flex-direction:column;gap:1rem;}
.compare-header{background:var(--blue);color:#fff;border-radius:1rem;padding:1rem 1.25rem;text-align:center;}
.compare-header .mode{font-size:.8rem;font-weight:800;opacity:.8;margin-bottom:.2rem;}
.compare-header .jurusan{font-family:'Fredoka One',sans-serif;font-size:1.2rem;}
.compare-header .skor{font-size:2rem;font-weight:900;margin-top:.3rem;}
.compare-header.kerja{background:#f59e0b;}
.sec{background:#fff;border:1.5px solid var(--border);border-radius:1rem;padding:1rem 1.25rem;}
.sec-t{font-family:'Fredoka One',sans-serif;font-size:.95rem;color:var(--blue);margin-bottom:.6rem;}
.item-li{font-size:.85rem;font-weight:700;color:#1e293b;padding:.3rem 0;border-bottom:1px solid #f1f5f9;display:flex;gap:.5rem;}
.item-li:last-child{border-bottom:none;}
.item-li::before{content:'→';color:var(--blue);flex-shrink:0;}
.ringkasan{font-size:.85rem;font-weight:600;color:#64748b;line-height:1.6;}
.vs-divider{display:flex;align-items:center;justify-content:center;font-family:'Fredoka One',sans-serif;font-size:1.5rem;color:#94a3b8;grid-column:1/-1;}
</style>

<div class="wrap">
  <div class="page-title">⚖️ Bandingkan Hasil</div>
  <div class="page-sub">Pilih 2 hasil rasionalisasi untuk dibandingkan secara berdampingan.</div>

  <form method="GET" action="{{ route('siswa.rasionalisasi.bandingkan') }}">
    <div class="picker-row">
      <div class="picker-card">
        <div class="picker-label">📌 Hasil Kiri</div>
        <select name="kiri" class="fi">
          <option value="">-- Pilih hasil --</option>
          @foreach($semua as $r)
            <option value="{{ $r->id }}" {{ request('kiri')==$r->id?'selected':'' }}>
              {{ $r->mode==='kuliah'?'🎓':'💼' }} {{ ucfirst($r->mode) }} — {{ $r->input_data['jurusan']??'-' }} ({{ $r->created_at->format('d M Y') }}) · Skor: {{ $r->skor_kesiapan??'-' }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="picker-card">
        <div class="picker-label">📌 Hasil Kanan</div>
        <select name="kanan" class="fi">
          <option value="">-- Pilih hasil --</option>
          @foreach($semua as $r)
            <option value="{{ $r->id }}" {{ request('kanan')==$r->id?'selected':'' }}>
              {{ $r->mode==='kuliah'?'🎓':'💼' }} {{ ucfirst($r->mode) }} — {{ $r->input_data['jurusan']??'-' }} ({{ $r->created_at->format('d M Y') }}) · Skor: {{ $r->skor_kesiapan??'-' }}
            </option>
          @endforeach
        </select>
      </div>
    </div>
    <button type="submit" class="btn-bandingkan" style="max-width:300px;display:block;margin:0 auto 2rem;">⚖️ Bandingkan Sekarang</button>
  </form>

  @if($kiri && $kanan)
    <div class="compare-grid">
      {{-- Kiri --}}
      <div class="compare-col">
        <div class="compare-header {{ $kiri->mode }}">
          <div class="mode">{{ $kiri->mode==='kuliah'?'🎓 Kuliah':'💼 Karir' }}</div>
          <div class="jurusan">{{ $kiri->input_data['jurusan']??'-' }}</div>
          <div class="skor">{{ $kiri->skor_kesiapan??'-' }}</div>
          <div style="font-size:.75rem;opacity:.8;">{{ $kiri->created_at->format('d M Y') }}</div>
        </div>
        <div class="sec">
          <div class="sec-t">📝 Ringkasan</div>
          <div class="ringkasan">{{ $kiri->hasil_ai['ringkasan']??'-' }}</div>
        </div>
        @if($kiri->mode==='kuliah')
          <div class="sec">
            <div class="sec-t">🎯 Rekomendasi Jurusan</div>
            @foreach(array_slice($kiri->hasil_ai['rekomendasi_jurusan']??[], 0, 5) as $r)
              <div class="item-li">{{ $r['nama_prodi']??'-' }}</div>
            @endforeach
          </div>
          @if(!empty($kiri->hasil_ai['tingkat_peluang']))
            <div class="sec">
              <div class="sec-t">📊 Tingkat Peluang</div>
              <div style="font-weight:800;font-size:1.1rem;color:var(--blue);">{{ $kiri->hasil_ai['tingkat_peluang'] }}</div>
            </div>
          @endif
        @else
          <div class="sec">
            <div class="sec-t">💼 Rekomendasi Karir</div>
            @foreach(array_slice($kiri->hasil_ai['rekomendasi_karir']??[], 0, 5) as $r)
              <div class="item-li">{{ $r['posisi']??'-' }} — {{ $r['gaji_entry']??'' }}</div>
            @endforeach
          </div>
        @endif
        <div class="sec">
          <div class="sec-t">⚡ Action Plan</div>
          @foreach(array_slice($kiri->hasil_ai['action_plan']??[], 0, 3) as $a)
            <div class="item-li">{{ $a }}</div>
          @endforeach
        </div>
        <a href="{{ route('siswa.rasionalisasi.hasil', $kiri->id) }}"
           style="display:block;text-align:center;padding:.6rem;border-radius:999px;background:var(--blue);color:#fff;font-weight:800;text-decoration:none;">Lihat Detail →</a>
      </div>

      {{-- Kanan --}}
      <div class="compare-col">
        <div class="compare-header {{ $kanan->mode }}" style="background:{{ $kanan->mode==='kerja'?'#f59e0b':'#7c3aed' }};">
          <div class="mode">{{ $kanan->mode==='kuliah'?'🎓 Kuliah':'💼 Karir' }}</div>
          <div class="jurusan">{{ $kanan->input_data['jurusan']??'-' }}</div>
          <div class="skor">{{ $kanan->skor_kesiapan??'-' }}</div>
          <div style="font-size:.75rem;opacity:.8;">{{ $kanan->created_at->format('d M Y') }}</div>
        </div>
        <div class="sec">
          <div class="sec-t">📝 Ringkasan</div>
          <div class="ringkasan">{{ $kanan->hasil_ai['ringkasan']??'-' }}</div>
        </div>
        @if($kanan->mode==='kuliah')
          <div class="sec">
            <div class="sec-t">🎯 Rekomendasi Jurusan</div>
            @foreach(array_slice($kanan->hasil_ai['rekomendasi_jurusan']??[], 0, 5) as $r)
              <div class="item-li">{{ $r['nama_prodi']??'-' }}</div>
            @endforeach
          </div>
          @if(!empty($kanan->hasil_ai['tingkat_peluang']))
            <div class="sec">
              <div class="sec-t">📊 Tingkat Peluang</div>
              <div style="font-weight:800;font-size:1.1rem;color:#7c3aed;">{{ $kanan->hasil_ai['tingkat_peluang'] }}</div>
            </div>
          @endif
        @else
          <div class="sec">
            <div class="sec-t">💼 Rekomendasi Karir</div>
            @foreach(array_slice($kanan->hasil_ai['rekomendasi_karir']??[], 0, 5) as $r)
              <div class="item-li">{{ $r['posisi']??'-' }} — {{ $r['gaji_entry']??'' }}</div>
            @endforeach
          </div>
        @endif
        <div class="sec">
          <div class="sec-t">⚡ Action Plan</div>
          @foreach(array_slice($kanan->hasil_ai['action_plan']??[], 0, 3) as $a)
            <div class="item-li">{{ $a }}</div>
          @endforeach
        </div>
        <a href="{{ route('siswa.rasionalisasi.hasil', $kanan->id) }}"
           style="display:block;text-align:center;padding:.6rem;border-radius:999px;background:#7c3aed;color:#fff;font-weight:800;text-decoration:none;">Lihat Detail →</a>
      </div>
    </div>
  @elseif(request('kiri') || request('kanan'))
    <div style="text-align:center;padding:2rem;color:#94a3b8;font-weight:700;">
      🐱 Pilih 2 hasil yang berbeda untuk membandingkan.
    </div>
  @endif
</div>
@endsection
