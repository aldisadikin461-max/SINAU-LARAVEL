@extends('layouts.admin')
@section('title','WA Blast')
@section('content')
<style>
.page-title  { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.8rem; color:#0d1f35; margin-bottom:.4rem; letter-spacing:-.5px; }
.page-sub    { color:#7b96b2; font-size:.88rem; font-weight:700; margin-bottom:1.5rem; }
.grid2       { display:grid; grid-template-columns:1fr 1fr; gap:1.25rem; }
@media(max-width:768px){ .grid2{ grid-template-columns:1fr; } }
.card        { background:#fff; border:2px solid #d0e4f7; border-radius:1.5rem; padding:1.75rem; box-shadow:0 4px 0 #d0e4f7; }
.card-title  { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.05rem; color:#0d1f35; margin-bottom:1.1rem; }
.flabel      { display:block; font-family:'Nunito',sans-serif; font-size:.82rem; font-weight:800; color:#3d5a7a; margin-bottom:.4rem; margin-top:.9rem; }
.flabel:first-child { margin-top:0; }
.finput      { width:100%; background:#f4f8ff; border:2px solid #d0e4f7; border-radius:13px; padding:.6rem 1rem; font-size:.9rem; font-weight:600; color:#0d1f35; outline:none; font-family:'Nunito Sans',sans-serif; transition:all .18s; }
.finput:focus{ border-color:#1a8cff; background:#fff; box-shadow:0 0 0 4px rgba(26,140,255,.1); }
textarea.finput { resize:vertical; }
.btn-row     { display:flex; gap:.75rem; margin-top:1.25rem; flex-wrap:wrap; }
.fbtn        { padding:.65rem 1.5rem; border-radius:14px; font-size:.9rem; font-weight:900; border:none; cursor:pointer; font-family:'Nunito',sans-serif; transition:all .18s; }
.fbtn-preview { background:#e6f2ff; color:#0070e0; border:2px solid #bbd9ff; box-shadow:0 4px 0 #bbd9ff; }
.fbtn-preview:hover { transform:translateY(-1px); }
.fbtn-blast  { background:#25d366; color:#fff; box-shadow:0 5px 0 #128c4a; }
.fbtn-blast:hover { transform:translateY(-2px); box-shadow:0 7px 0 #128c4a; }
.fbtn-blast:disabled { opacity:.4; cursor:not-allowed; transform:none; }
.preview-box { border-radius:14px; padding:.9rem 1.1rem; margin-top:1rem; font-weight:700; font-size:.88rem; display:none; font-family:'Nunito',sans-serif; }
.preview-ok    { background:#d6f5e6; border:2px solid #a0e8c4; color:#1fa355; }
.preview-empty { background:#ffe3e6; border:2px solid #ffb0b8; color:#ff4757; }
.blast-progress { margin-top:1rem; display:none; }
.blast-bar-wrap { background:#e6f2ff; border-radius:999px; height:10px; overflow:hidden; margin-bottom:.5rem; }
.blast-bar      { height:100%; background:linear-gradient(90deg,#25d366,#20bd5a); border-radius:999px; transition:width .3s; width:0%; }
.blast-info     { font-family:'Nunito',sans-serif; font-size:.8rem; font-weight:700; color:#3d5a7a; }
.recv-list   { margin-top:.5rem; max-height:300px; overflow-y:auto; }
.recv-item   { display:flex; align-items:center; justify-content:space-between; padding:.5rem .75rem; border-radius:10px; margin-bottom:.4rem; background:#f4f8ff; border:1.5px solid #d0e4f7; }
.recv-name   { font-family:'Nunito',sans-serif; font-weight:800; font-size:.82rem; color:#0d1f35; }
.recv-phone  { font-size:.74rem; color:#7b96b2; font-weight:600; }
.recv-status { font-size:.72rem; font-weight:900; padding:.15rem .6rem; border-radius:999px; font-family:'Nunito',sans-serif; }
.rs-waiting  { background:#e6f2ff; color:#0070e0; }
.rs-sent     { background:#d6f5e6; color:#1fa355; }
.rs-nophone  { background:#ffe3e6; color:#ff4757; }
.tpl-preview { background:#f4f8ff; border:2px solid #d0e4f7; border-radius:12px; padding:.75rem 1rem; margin-top:.75rem; font-size:.82rem; color:#3d5a7a; line-height:1.6; font-family:'Nunito Sans',sans-serif; white-space:pre-line; }

/* Siswa search dropdown */
.siswa-search-wrap { position:relative; }
.siswa-dropdown { position:absolute; top:calc(100% + 4px); left:0; right:0; background:#fff; border:2px solid #d0e4f7; border-radius:13px; max-height:200px; overflow-y:auto; z-index:50; box-shadow:0 8px 24px rgba(0,0,0,.1); display:none; }
.siswa-option { padding:.55rem 1rem; font-size:.85rem; font-weight:700; color:#0d1f35; cursor:pointer; font-family:'Nunito',sans-serif; transition:background .15s; border-bottom:1px solid #f0f6ff; }
.siswa-option:last-child { border-bottom:none; }
.siswa-option:hover { background:#e6f2ff; color:#0070e0; }
.siswa-option .siswa-phone { font-size:.75rem; color:#7b96b2; font-weight:600; }
.siswa-selected { display:flex; flex-wrap:wrap; gap:.4rem; margin-top:.6rem; }
.siswa-chip { display:inline-flex; align-items:center; gap:.3rem; background:#e6f2ff; border:1.5px solid #bbd9ff; color:#0070e0; border-radius:999px; padding:.2rem .75rem; font-size:.78rem; font-weight:800; font-family:'Nunito',sans-serif; }
.siswa-chip button { background:none; border:none; color:#0070e0; cursor:pointer; font-size:.85rem; line-height:1; padding:0; margin-left:.1rem; }
</style>

<div class="page-title">💬 WhatsApp Blast</div>
<div class="page-sub">Kirim pesan ke siswa via wa.me — otomatis buka satu per satu!</div>

<div class="grid2">

  <div class="card">
    <div class="card-title">⚙️ Pengaturan Blast</div>

    <label class="flabel">Filter Penerima</label>
    <select id="filter" class="finput">
      <option value="semua">Semua Siswa</option>
      <option value="streak_kosong">Siswa Streak = 0 Hari Ini</option>
      <option value="kelas">Per Kelas</option>
      <option value="jurusan">Per Jurusan</option>
      <option value="personal">👤 Per Siswa (Personal)</option>
    </select>

    <div id="kelas-wrap" style="display:none">
      <label class="flabel">Nama Kelas</label>
      <input id="kelas" placeholder="Contoh: XI PPLG 1" class="finput">
    </div>
    <div id="jurusan-wrap" style="display:none">
      <label class="flabel">Jurusan</label>
      <input id="jurusan" placeholder="Contoh: PPLG" class="finput">
    </div>

    {{-- Filter personal siswa --}}
    <div id="personal-wrap" style="display:none">
      <label class="flabel">Cari & Pilih Siswa</label>
      <div class="siswa-search-wrap">
        <input id="siswa-search" placeholder="Ketik nama siswa..." class="finput" autocomplete="off">
        <div class="siswa-dropdown" id="siswa-dropdown"></div>
      </div>
      <div class="siswa-selected" id="siswa-selected"></div>
    </div>

    <label class="flabel">Template Pesan</label>
    <select id="template" class="finput">
      <option value="streak">🔥 Streak Mau Putus</option>
      <option value="badge">🏅 Selamat Badge Baru</option>
      <option value="motivasi">💪 Motivasi Belajar</option>
      <option value="bebas">✏️ Pesan Bebas</option>
    </select>

    <div class="tpl-preview" id="tpl-preview"></div>

    <div id="pesan-wrap" style="display:none">
      <label class="flabel">Pesan Bebas <span style="color:#7b96b2;font-weight:600">(gunakan {nama} untuk nama siswa)</span></label>
      <textarea id="pesan" rows="3" placeholder="Hai {nama}! ..." class="finput"></textarea>
    </div>

    <div id="preview-box" class="preview-box"></div>

    <div class="blast-progress" id="blastProgress">
      <div class="blast-bar-wrap"><div class="blast-bar" id="blastBar"></div></div>
      <div class="blast-info" id="blastInfo">Mengirim... 0 / 0</div>
    </div>

    <div class="btn-row">
      <button class="fbtn fbtn-preview" onclick="previewBlast()">🔍 Preview</button>
      <button class="fbtn fbtn-blast" id="btn-blast" disabled onclick="doBlast()">💬 Mulai Blast</button>
    </div>
  </div>

  <div class="card">
    <div class="card-title">👥 Daftar Penerima</div>
    <div id="recv-list" class="recv-list">
      <div style="text-align:center;color:#7b96b2;font-size:.85rem;padding:2rem;font-family:'Nunito',sans-serif;font-weight:700;">
        Klik "Preview" untuk melihat daftar siswa
      </div>
    </div>
    <div style="margin-top:.75rem;font-family:'Nunito',sans-serif;font-size:.78rem;color:#7b96b2;font-weight:700" id="recv-count"></div>
  </div>

</div>

@push('scripts')
<script>
const TEMPLATES = {
  streak:   'Hai {nama}! 🔥\n\nStreak belajarmu di Sinau hampir putus nih. Yuk belajar sebentar hari ini biar streak-mu tetap terjaga!\n\nSemangat, Smeconer! 💪\n\n— Sinau SMKN 1 Purwokerto',
  badge:    'Hai {nama}! 🏅\n\nSelamat! Kamu baru saja meraih badge baru di Sinau! Terus pertahankan semangat belajarmu.\n\nBangga sama kamu, Smeconer! 🎉\n\n— Sinau SMKN 1 Purwokerto',
  motivasi: 'Hai {nama}! 💪\n\nJangan lupa belajar hari ini ya! Setiap langkah kecil membawamu lebih dekat ke impianmu.\n\nAyo, Smeconer!\n\n— Sinau SMKN 1 Purwokerto',
  bebas:    '',
};

let blastData       = [];
let selectedSiswa   = []; // [{id, name, phone}]
let allSiswa        = []; // cache semua siswa dari server

// ── Filter change ──────────────────────────────────────────
document.getElementById('filter').addEventListener('change', function() {
  document.getElementById('kelas-wrap').style.display    = this.value === 'kelas'    ? 'block' : 'none';
  document.getElementById('jurusan-wrap').style.display  = this.value === 'jurusan'  ? 'block' : 'none';
  document.getElementById('personal-wrap').style.display = this.value === 'personal' ? 'block' : 'none';

  // Load daftar siswa saat filter personal dipilih
  if (this.value === 'personal' && allSiswa.length === 0) loadSiswaList();
});

// ── Template change ────────────────────────────────────────
function updateTemplate() {
  const val    = document.getElementById('template').value;
  const isBebas = val === 'bebas';
  document.getElementById('pesan-wrap').style.display  = isBebas ? 'block' : 'none';
  document.getElementById('tpl-preview').style.display = isBebas ? 'none'  : 'block';
  if (!isBebas) document.getElementById('tpl-preview').textContent = TEMPLATES[val].replace('{nama}', 'Nama Siswa');
}
document.getElementById('template').addEventListener('change', updateTemplate);
updateTemplate();

// ── Load semua siswa untuk dropdown personal ───────────────
function loadSiswaList() {
  fetch('{{ route("admin.whatsapp.blast") }}', {
    method:  'POST',
    headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':'{{ csrf_token() }}' },
    body: JSON.stringify({ filter:'semua', template:'motivasi', pesan:'', kelas:'', jurusan:'' }),
  })
  .then(r => r.json())
  .then(data => {
    allSiswa = data.links || [];
  })
  .catch(() => {});
}

// ── Siswa search ───────────────────────────────────────────
document.getElementById('siswa-search').addEventListener('input', function() {
  const q   = this.value.toLowerCase().trim();
  const dd  = document.getElementById('siswa-dropdown');

  if (!q) { dd.style.display = 'none'; return; }

  const results = allSiswa.filter(s =>
    s.name.toLowerCase().includes(q) &&
    !selectedSiswa.find(x => x.name === s.name)
  ).slice(0, 8);

  if (!results.length) { dd.style.display = 'none'; return; }

  dd.innerHTML = results.map(s => `
    <div class="siswa-option" onclick="pilihSiswa('${s.name.replace(/'/g,"\\'")}','${s.phone||''}')">
      ${s.name}
      <div class="siswa-phone">${s.phone ? '📱 ' + s.phone : '❌ Belum ada nomor'}</div>
    </div>
  `).join('');
  dd.style.display = 'block';
});

// Tutup dropdown saat klik di luar
document.addEventListener('click', function(e) {
  if (!e.target.closest('.siswa-search-wrap')) {
    document.getElementById('siswa-dropdown').style.display = 'none';
  }
});

function pilihSiswa(name, phone) {
  selectedSiswa.push({ name, phone });
  document.getElementById('siswa-search').value = '';
  document.getElementById('siswa-dropdown').style.display = 'none';
  renderSelectedSiswa();
}

function hapusSiswa(name) {
  selectedSiswa = selectedSiswa.filter(s => s.name !== name);
  renderSelectedSiswa();
}

function renderSelectedSiswa() {
  const wrap = document.getElementById('siswa-selected');
  wrap.innerHTML = selectedSiswa.map(s => `
    <span class="siswa-chip">
      ${s.name}
      <button onclick="hapusSiswa('${s.name.replace(/'/g,"\\'")}')">×</button>
    </span>
  `).join('');
}

// ── Build WA URL ───────────────────────────────────────────
function buildWaUrl(name, phone, template, customMsg) {
  const msg = (template === 'bebas' ? customMsg : TEMPLATES[template]).replace(/\{nama\}/g, name);
  let p = phone.replace(/\D/g, '');
  if (p.startsWith('0'))   p = '62' + p.slice(1);
  if (!p.startsWith('62')) p = '62' + p;
  return 'https://wa.me/' + p + '?text=' + encodeURIComponent(msg);
}

// ── Preview ────────────────────────────────────────────────
function previewBlast() {
  const box      = document.getElementById('preview-box');
  const filterVal = document.getElementById('filter').value;
  box.className     = 'preview-box preview-ok';
  box.style.display = 'block';
  box.textContent   = '⏳ Memuat daftar penerima...';

  // Mode personal — langsung pakai selectedSiswa
  if (filterVal === 'personal') {
    if (!selectedSiswa.length) {
      box.className   = 'preview-box preview-empty';
      box.textContent = '❌ Pilih minimal 1 siswa dulu!';
      document.getElementById('btn-blast').disabled = true;
      return;
    }

    const tpl    = document.getElementById('template').value;
    const custom = document.getElementById('pesan').value || '';

    blastData = selectedSiswa.map(s => ({
      name:  s.name,
      phone: s.phone || '',
      waUrl: s.phone ? buildWaUrl(s.name, s.phone, tpl, custom) : null,
    }));

    finishPreview(box);
    return;
  }

  // Mode filter biasa — fetch ke server
  fetch('{{ route("admin.whatsapp.blast") }}', {
    method:  'POST',
    headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':'{{ csrf_token() }}' },
    body: JSON.stringify({
      filter:   filterVal,
      template: document.getElementById('template').value,
      pesan:    document.getElementById('pesan').value || '',
      kelas:    document.getElementById('kelas').value || '',
      jurusan:  document.getElementById('jurusan').value || '',
    }),
  })
  .then(r => r.json())
  .then(data => {
    const tpl    = document.getElementById('template').value;
    const custom = document.getElementById('pesan').value || '';
    blastData = (data.links || []).map(d => ({
      name:  d.name,
      phone: d.phone || '',
      waUrl: d.phone ? buildWaUrl(d.name, d.phone, tpl, custom) : null,
    }));
    finishPreview(box);
  })
  .catch(e => {
    box.className   = 'preview-box preview-empty';
    box.textContent = '❌ Gagal memuat data. Coba lagi.';
    console.error(e);
  });
}

function finishPreview(box) {
  const noPhone = blastData.filter(d => !d.phone).length;
  const valid   = blastData.filter(d => d.phone).length;

  if (!blastData.length) {
    box.className   = 'preview-box preview-empty';
    box.textContent = '❌ Tidak ada siswa dengan filter ini.';
    document.getElementById('btn-blast').disabled = true;
  } else {
    box.className   = 'preview-box preview-ok';
    box.textContent = `✅ ${blastData.length} siswa ditemukan · ${valid} punya nomor WA${noPhone ? ` · ${noPhone} tanpa nomor` : ''}`;
    document.getElementById('btn-blast').disabled = valid === 0;
  }

  renderList();
  document.getElementById('recv-count').textContent = `Total: ${blastData.length} siswa · Bisa dikirim: ${valid}`;
}

// ── Render list ────────────────────────────────────────────
function renderList(sentIdx = -1) {
  const list = document.getElementById('recv-list');
  if (!blastData.length) {
    list.innerHTML = '<div style="text-align:center;color:#7b96b2;padding:2rem">Belum ada data</div>';
    return;
  }
  list.innerHTML = blastData.map((d, i) => {
    let sc = 'rs-waiting', st = 'Menunggu';
    if (!d.phone)           { sc = 'rs-nophone'; st = 'Tanpa Nomor'; }
    else if (i < sentIdx)   { sc = 'rs-sent';    st = '✓ Terkirim'; }
    else if (i === sentIdx) { sc = 'rs-sent';    st = '↗ Dibuka'; }
    return `<div class="recv-item" id="ri-${i}">
      <div><div class="recv-name">${d.name}</div><div class="recv-phone">${d.phone || 'Belum diisi'}</div></div>
      <span class="recv-status ${sc}" id="rs-${i}">${st}</span>
    </div>`;
  }).join('');
}

// ── Blast ──────────────────────────────────────────────────
function doBlast() {
  const eligible = blastData.filter(d => d.phone && d.waUrl);
  if (!eligible.length) { alert('Tidak ada siswa dengan nomor WA valid.'); return; }

  if (!confirm(`Akan membuka ${eligible.length} tab WhatsApp satu per satu (jeda 2.5 detik).\n\nPastikan browser mengizinkan popup!\n\nLanjutkan?`)) return;

  document.getElementById('btn-blast').disabled          = true;
  document.getElementById('blastProgress').style.display = 'block';

  let idx = 0;
  function sendNext() {
    if (idx >= eligible.length) {
      document.getElementById('blastBar').style.width  = '100%';
      document.getElementById('blastInfo').textContent = `✅ Selesai! ${eligible.length} pesan dikirim.`;
      document.getElementById('btn-blast').disabled    = false;
      return;
    }

    const r   = eligible[idx];
    const pct = Math.round(((idx + 1) / eligible.length) * 100);

    document.getElementById('blastBar').style.width  = pct + '%';
    document.getElementById('blastInfo').textContent = `Mengirim ${idx + 1}/${eligible.length} — ${r.name}`;

    const globalIdx = blastData.indexOf(r);
    const badge     = document.getElementById('rs-' + globalIdx);
    if (badge) { badge.className = 'recv-status rs-sent'; badge.textContent = '↗ Dibuka'; }
    const item = document.getElementById('ri-' + globalIdx);
    if (item)  item.scrollIntoView({ behavior:'smooth', block:'nearest' });

    window.open(r.waUrl, '_blank');
    idx++;
    setTimeout(sendNext, 2500);
  }

  sendNext();
}
</script>
@endpush
@endsection