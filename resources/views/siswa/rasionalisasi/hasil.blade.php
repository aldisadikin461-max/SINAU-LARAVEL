@extends('layouts.siswa')
@section('title','Hasil Rasionalisasi')
@section('content')
<style>
:root{--blue:#1a8cff;--blue-press:#005bb8;--blue-light:#e8f4ff;--border:#d0e4f7;--orange:#f59e0b;}
.hasil-wrap{max-width:860px;margin:0 auto;}
.back{color:var(--blue);font-size:.88rem;font-weight:800;text-decoration:none;display:inline-flex;align-items:center;gap:.3rem;margin-bottom:1.25rem;}
/* Hero skor */
.hero-skor{background:#fff;border:2px solid var(--border);border-radius:1.5rem;padding:2rem;box-shadow:0 4px 0 var(--border);margin-bottom:1.5rem;display:flex;gap:2rem;align-items:center;flex-wrap:wrap;}
.skor-ring{position:relative;width:100px;height:100px;flex-shrink:0;}
.skor-ring svg{transform:rotate(-90deg);}
.skor-ring .track{fill:none;stroke:#e0f2fe;stroke-width:10;}
.skor-ring .fill{fill:none;stroke:var(--blue);stroke-width:10;stroke-linecap:round;transition:stroke-dashoffset 1s ease;}
.skor-num{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-family:'Fredoka One',sans-serif;font-size:1.6rem;color:#0f172a;}
.hero-text h2{font-family:'Fredoka One',sans-serif;font-size:1.5rem;color:#0f172a;margin-bottom:.4rem;}
.hero-text p{color:#64748b;font-weight:600;font-size:.9rem;line-height:1.6;margin-bottom:.75rem;}
.badge-peluang{display:inline-flex;align-items:center;gap:.4rem;padding:.35rem 1rem;border-radius:999px;font-size:.85rem;font-weight:800;}
.p-tinggi{background:#dcfce7;color:#16a34a;}
.p-sedang{background:#fef9c3;color:#ca8a04;}
.p-perlu{background:#fee2e2;color:#dc2626;}
/* Section */
.sec-title{font-family:'Fredoka One',sans-serif;font-size:1.3rem;color:#0f172a;margin:2rem 0 1rem;display:flex;align-items:center;gap:.5rem;}
/* Card rekomendasi */
.rek-card{background:#fff;border:2px solid var(--border);border-radius:1.25rem;padding:1.5rem;box-shadow:0 4px 0 var(--border);margin-bottom:1.25rem;}
.rek-head{display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:1rem;}
.rek-nama{font-family:'Fredoka One',sans-serif;font-size:1.15rem;color:var(--blue);}
.rek-num{background:var(--blue-light);color:var(--blue);border-radius:999px;padding:.2rem .75rem;font-size:.78rem;font-weight:800;flex-shrink:0;}
.rek-relevansi{color:#64748b;font-size:.88rem;font-weight:600;line-height:1.6;margin-bottom:1rem;}
.prospek-list{display:flex;gap:.5rem;flex-wrap:wrap;margin-bottom:1.25rem;}
.prospek-chip{background:var(--blue-light);color:var(--blue);border-radius:999px;padding:.25rem .75rem;font-size:.78rem;font-weight:700;}
/* Kampus / Perusahaan cards */
.sub-title{font-size:.85rem;font-weight:800;color:#475569;margin-bottom:.75rem;}
.item-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:.75rem;}
.item-card{border:1.5px solid var(--border);border-radius:1rem;padding:1rem;transition:all .2s;}
.item-card:hover{border-color:var(--blue);transform:translateY(-2px);}
.item-nama{font-weight:800;font-size:.9rem;color:#0f172a;margin-bottom:.2rem;}
.item-kota{font-size:.78rem;color:#94a3b8;font-weight:700;margin-bottom:.5rem;}
.item-info{font-size:.76rem;color:#64748b;font-weight:600;margin-bottom:.6rem;}
.item-link{display:inline-flex;align-items:center;gap:.3rem;color:var(--blue);font-size:.78rem;font-weight:800;text-decoration:none;}
.item-link:hover{text-decoration:underline;}
.btn-bookmark{float:right;background:none;border:none;cursor:pointer;font-size:1.1rem;padding:.2rem;transition:transform .2s;}
.btn-bookmark:hover{transform:scale(1.25);}
/* Action plan */
.action-list{display:flex;flex-direction:column;gap:.6rem;}
.action-item{display:flex;align-items:flex-start;gap:.75rem;background:#fff;border:1.5px solid var(--border);border-radius:1rem;padding:.85rem 1rem;}
.action-num{background:var(--blue);color:#fff;border-radius:999px;width:1.6rem;height:1.6rem;display:flex;align-items:center;justify-content:center;font-size:.78rem;font-weight:900;flex-shrink:0;}
.action-txt{font-size:.88rem;font-weight:700;color:#1e293b;line-height:1.5;}
/* Tips */
.tips-list{display:grid;grid-template-columns:1fr 1fr;gap:.6rem;}
@media(max-width:500px){.tips-list{grid-template-columns:1fr;}}
.tip-item{background:var(--blue-light);border-radius:1rem;padding:.85rem 1rem;font-size:.85rem;font-weight:700;color:#0f172a;display:flex;gap:.5rem;}
/* Road map */
.road-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;}
@media(max-width:600px){.road-grid{grid-template-columns:1fr;}}
.road-card{background:#fff;border:2px solid var(--border);border-radius:1rem;padding:1.25rem;box-shadow:0 3px 0 var(--border);}
.road-period{font-family:'Fredoka One',sans-serif;font-size:.95rem;color:var(--orange);margin-bottom:.3rem;}
.road-fokus{font-weight:800;font-size:.88rem;color:#0f172a;margin-bottom:.6rem;}
.road-list{list-style:none;padding:0;}
.road-list li{font-size:.8rem;font-weight:600;color:#64748b;padding:.2rem 0;display:flex;gap:.4rem;}
.road-list li::before{content:'→';color:var(--orange);}
/* Sertifikasi */
.serti-list{display:flex;gap:.6rem;flex-wrap:wrap;}
.serti-chip{background:#f3e8ff;color:#7c3aed;border:1.5px solid #e9d5ff;border-radius:999px;padding:.35rem 1rem;font-size:.82rem;font-weight:800;}
/* Footer actions */
.footer-actions{display:flex;gap:.75rem;flex-wrap:wrap;margin:2rem 0;}
.btn-action{padding:.65rem 1.4rem;border-radius:999px;font-size:.9rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;text-decoration:none;display:inline-flex;align-items:center;gap:.4rem;transition:all .2s;}
.btn-primary{background:var(--blue);color:#fff;box-shadow:0 4px 0 var(--blue-press);}
.btn-primary:hover{transform:translateY(2px);box-shadow:0 2px 0 var(--blue-press);}
.btn-outline{background:#fff;border:2px solid var(--border);color:#475569;}
.btn-outline:hover{border-color:var(--blue);color:var(--blue);}
.btn-danger{background:#fee2e2;border:1.5px solid #fecaca;color:#dc2626;}
/* Notif bookmark */
#bm-notif{position:fixed;bottom:1.5rem;right:1.5rem;background:var(--blue);color:#fff;border-radius:1rem;padding:.75rem 1.25rem;font-weight:700;font-size:.88rem;display:none;box-shadow:0 4px 16px rgba(26,140,255,.4);z-index:999;}
</style>

<div id="bm-notif">✅ Berhasil!</div>

<div class="hasil-wrap">
  <a href="{{ route('siswa.rasionalisasi.riwayat') }}" class="back">← Riwayat</a>

  @php $h = $rasi->hasil_ai ?? []; @endphp

  {{-- Hero Skor --}}
  <div class="hero-skor">
    @php
      $skor = $rasi->skor_kesiapan ?? 0;
      $circ = 2 * M_PI * 42;
      $dash = $circ - ($circ * $skor / 100);
      $warna = $skor >= 75 ? '#16a34a' : ($skor >= 50 ? '#d97706' : '#dc2626');
    @endphp
    <div class="skor-ring">
      <svg width="100" height="100" viewBox="0 0 100 100">
        <circle class="track" cx="50" cy="50" r="42"/>
        <circle class="fill" cx="50" cy="50" r="42"
          style="stroke:{{ $warna }};stroke-dasharray:{{ $circ }};stroke-dashoffset:{{ $dash }};"/>
      </svg>
      <div class="skor-num" style="color:{{ $warna }}">{{ $skor }}</div>
    </div>
    <div class="hero-text">
      <h2>
        @if($rasi->mode==='kuliah') 🎓 Rasionalisasi Kuliah
        @else 💼 Rasionalisasi Karir @endif
        — {{ $rasi->input_data['jurusan_full'] ?? ($rasi->input_data['jurusan'] ?? '') }}
      </h2>
      <p>{{ $h['ringkasan'] ?? 'AI berhasil menganalisis profilmu.' }}</p>
      @if($rasi->mode==='kuliah' && isset($h['tingkat_peluang']))
        @php $p=$h['tingkat_peluang']; $pc=str_contains($p,'Tinggi')?'tinggi':(str_contains($p,'Sedang')?'sedang':'perlu'); @endphp
        <span class="badge-peluang p-{{ $pc }}">
          {{ $p==='Tinggi'?'🟢':($p==='Sedang'?'🟡':'🔴') }} Peluang: {{ $p }}
        </span>
      @endif
    </div>
    <div style="margin-left:auto;display:flex;flex-direction:column;align-items:flex-end;gap:.4rem;">
      <div style="font-size:.75rem;color:#94a3b8;font-weight:700;">{{ $rasi->created_at->format('d M Y H:i') }}</div>
      <a href="{{ route('siswa.rasionalisasi.bandingkan', ['kiri'=>$rasi->id]) }}" class="btn-action btn-outline" style="font-size:.78rem;padding:.4rem .9rem;">⚖️ Bandingkan</a>
    </div>
  </div>

  {{-- KULIAH: Rekomendasi Jurusan --}}
  @if($rasi->mode==='kuliah' && !empty($h['rekomendasi_jurusan']))
    <div class="sec-title">🎯 Rekomendasi Jurusan Kuliah</div>
    @foreach($h['rekomendasi_jurusan'] as $i => $rek)
      <div class="rek-card">
        <div class="rek-head">
          <div class="rek-nama">{{ $rek['nama_prodi'] ?? '-' }}</div>
          <span class="rek-num">{{ $i+1 }} / {{ count($h['rekomendasi_jurusan']) }}</span>
        </div>
        <div class="rek-relevansi">{{ $rek['relevansi'] ?? '' }}</div>
        @if(!empty($rek['prospek_karir']))
          <div class="prospek-list">
            @foreach($rek['prospek_karir'] as $pk)
              <span class="prospek-chip">{{ $pk }}</span>
            @endforeach
          </div>
        @endif
        @if(!empty($rek['kampus']))
          <div class="sub-title">🏛️ Rekomendasi Kampus</div>
          <div class="item-grid">
            @foreach($rek['kampus'] as $k)
              <div class="item-card">
                <button class="btn-bookmark" onclick="toggleBookmark({{ $rasi->id }}, 'kampus', '{{ addslashes($k['nama']??'') }}', '{{ $k['link']??'' }}', this)"
                        title="Simpan kampus ini">
                  {{ in_array($k['nama']??'', $bookmarkedNames) ? '🔖' : '🏷️' }}
                </button>
                <div class="item-nama">{{ $k['nama'] ?? '-' }}</div>
                <div class="item-kota">📍 {{ $k['kota'] ?? '' }}</div>
                @if(!empty($k['akreditasi']))
                  <div style="margin-bottom:.4rem;">
                    <span style="background:#e0f2fe;color:#0284c7;border-radius:999px;padding:.1rem .5rem;font-size:.72rem;font-weight:800;">Akreditasi {{ $k['akreditasi'] }}</span>
                  </div>
                @endif
                <div class="item-info">{{ $k['keterangan'] ?? '' }}</div>
                @if(!empty($k['link']))
                  <a href="{{ $k['link'] }}" target="_blank" class="item-link">🔗 Website Resmi</a>
                @endif
              </div>
            @endforeach
          </div>
        @endif
      </div>
    @endforeach
  @endif

  {{-- KERJA: Rekomendasi Karir --}}
  @if($rasi->mode==='kerja' && !empty($h['rekomendasi_karir']))
    <div class="sec-title">💼 Rekomendasi Posisi Karir</div>
    @foreach($h['rekomendasi_karir'] as $i => $rek)
      <div class="rek-card">
        <div class="rek-head">
          <div class="rek-nama">{{ $rek['posisi'] ?? '-' }}</div>
          <span class="rek-num" style="background:#fef9c3;color:#ca8a04;">{{ $i+1 }} / {{ count($h['rekomendasi_karir']) }}</span>
        </div>
        <div class="rek-relevansi">{{ $rek['deskripsi'] ?? '' }}</div>
        <div style="display:flex;gap:.75rem;flex-wrap:wrap;margin-bottom:1rem;">
          <span style="background:#dcfce7;color:#16a34a;border-radius:999px;padding:.25rem .75rem;font-size:.8rem;font-weight:800;">💰 {{ $rek['gaji_entry'] ?? '-' }}</span>
        </div>
        @if(!empty($rek['persyaratan']))
          <div style="margin-bottom:1rem;">
            <div class="sub-title">📋 Persyaratan Umum</div>
            <div class="prospek-list">
              @foreach($rek['persyaratan'] as $req)
                <span class="prospek-chip" style="background:#fef9c3;color:#ca8a04;">{{ $req }}</span>
              @endforeach
            </div>
          </div>
        @endif
        @if(!empty($rek['perusahaan']))
          <div class="sub-title">🏢 Rekomendasi Perusahaan</div>
          <div class="item-grid">
            @foreach($rek['perusahaan'] as $p)
              <div class="item-card">
                <button class="btn-bookmark" onclick="toggleBookmark({{ $rasi->id }}, 'karir', '{{ addslashes($p['nama']??'') }}', '{{ $p['link']??'' }}', this)" title="Simpan">
                  {{ in_array($p['nama']??'', $bookmarkedNames) ? '🔖' : '🏷️' }}
                </button>
                <div class="item-nama">{{ $p['nama'] ?? '-' }}</div>
                <div class="item-kota">📍 {{ $p['kota'] ?? '' }}</div>
                <div class="item-info">{{ $p['cara_melamar'] ?? '' }}</div>
                @if(!empty($p['link']))
                  <a href="{{ $p['link'] }}" target="_blank" class="item-link">🔗 Kunjungi</a>
                @endif
              </div>
            @endforeach
          </div>
        @endif
      </div>
    @endforeach

    {{-- Road Map --}}
    @if(!empty($h['road_map']))
      <div class="sec-title">🗺️ Road Map Karir</div>
      <div class="road-grid">
        @foreach($h['road_map'] as $rm)
          <div class="road-card">
            <div class="road-period">⏱ {{ $rm['periode'] ?? '' }}</div>
            <div class="road-fokus">{{ $rm['fokus'] ?? '' }}</div>
            <ul class="road-list">
              @foreach($rm['kegiatan'] ?? [] as $kg)
                <li>{{ $kg }}</li>
              @endforeach
            </ul>
          </div>
        @endforeach
      </div>
    @endif

    {{-- Sertifikasi --}}
    @if(!empty($h['sertifikasi_rekomendasi']))
      <div class="sec-title">🏅 Sertifikasi yang Direkomendasikan</div>
      <div class="serti-list">
        @foreach($h['sertifikasi_rekomendasi'] as $s)
          <span class="serti-chip">{{ $s }}</span>
        @endforeach
      </div>
    @endif
  @endif

  {{-- Action Plan --}}
  @if(!empty($h['action_plan']))
    <div class="sec-title">⚡ Action Plan — 5 Langkah Sekarang</div>
    <div class="action-list">
      @foreach($h['action_plan'] as $i => $act)
        <div class="action-item">
          <div class="action-num">{{ $i+1 }}</div>
          <div class="action-txt">{{ $act }}</div>
        </div>
      @endforeach
    </div>
  @endif

  {{-- Tips UTBK --}}
  @if($rasi->mode==='kuliah' && !empty($h['tips_utbk']))
    <div class="sec-title">📚 Tips Persiapan UTBK/SNBT</div>
    <div class="tips-list">
      @foreach($h['tips_utbk'] as $tip)
        <div class="tip-item">💡 {{ $tip }}</div>
      @endforeach
    </div>
  @endif

  {{-- Footer Actions --}}
  <div class="footer-actions">
    <a href="{{ route('siswa.rasionalisasi.index') }}" class="btn-action btn-primary">+ Rasionalisasi Baru</a>
    <a href="{{ route('siswa.rasionalisasi.riwayat') }}" class="btn-action btn-outline">📋 Riwayat</a>
    <a href="{{ route('siswa.rasionalisasi.bandingkan', ['kiri'=>$rasi->id]) }}" class="btn-action btn-outline">⚖️ Bandingkan</a>
    <form method="POST" action="{{ route('siswa.rasionalisasi.destroy', $rasi->id) }}"
          onsubmit="return confirm('Hapus hasil ini?')" style="display:inline;">
      @csrf @method('DELETE')
      <button class="btn-action btn-danger">🗑️ Hapus</button>
    </form>
  </div>
</div>

@push('scripts')
<script>
function toggleBookmark(rasiId, tipe, nama, link, btn){
  fetch('{{ route("siswa.rasionalisasi.bookmark") }}',{
    method:'POST',
    headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
    body:JSON.stringify({rasionalisasi_id:rasiId,tipe,nama,link}),
  })
  .then(r=>r.json())
  .then(d=>{
    btn.textContent = d.status==='added' ? '🔖' : '🏷️';
    const notif = document.getElementById('bm-notif');
    notif.textContent = d.status==='added' ? '🔖 '+nama+' disimpan!' : '🗑️ Bookmark dihapus';
    notif.style.display='block';
    setTimeout(()=>notif.style.display='none', 2500);
  });
}
</script>
@endpush
@endsection
