@extends('layouts.admin')
@section('title','WhatsApp Blast')
@section('content')

<style>
.page-title  { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.8rem; color:#0d1f35; margin-bottom:1.5rem; letter-spacing:-0.5px; }
.grid2       { display:grid; grid-template-columns:1fr 1fr; gap:1.25rem; }
@media(max-width:768px){ .grid2{ grid-template-columns:1fr; } }
.card        { background:#fff; border:2px solid #d0e4f7; border-radius:1.5rem; padding:1.75rem; box-shadow:0 4px 0 #d0e4f7; }
.card-title  { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.05rem; color:#0d1f35; margin-bottom:1.25rem; display:flex; align-items:center; gap:.5rem; }
.sf-label    { display:block; font-family:'Nunito',sans-serif; font-size:.82rem; font-weight:800; color:#3d5a7a; margin-bottom:.4rem; }
.sf-input    { width:100%; background:#f4f8ff; border:2px solid #d0e4f7; border-radius:14px; padding:.65rem 1rem; font-size:.9rem; font-weight:600; color:#0d1f35; outline:none; font-family:'Nunito Sans',sans-serif; transition:all .18s; }
.sf-input:focus { border-color:#1a8cff; background:#fff; box-shadow:0 0 0 4px rgba(26,140,255,.1); }
.sf-group    { margin-bottom:1rem; }
.fbtn        { padding:.75rem 1.75rem; border-radius:14px; background:#25d366; color:#fff; font-size:.95rem; font-weight:900; border:none; cursor:pointer; font-family:'Nunito',sans-serif; box-shadow:0 5px 0 #128c4a; transition:all .18s; display:inline-flex; align-items:center; gap:.5rem; }
.fbtn:hover  { transform:translateY(-2px); box-shadow:0 7px 0 #128c4a; }
.fbtn:active { transform:translateY(3px);  box-shadow:0 2px 0 #128c4a; }
.fbtn-blue   { background:#1a8cff; box-shadow:0 5px 0 #005bb8; }
.fbtn-blue:hover  { box-shadow:0 7px 0 #005bb8; }
.fbtn-blue:active { box-shadow:0 2px 0 #005bb8; }
.log-table   { width:100%; border-collapse:collapse; font-family:'Nunito Sans',sans-serif; }
.log-table thead tr { background:#e6f2ff; border-bottom:2px solid #d0e4f7; }
.log-table thead th { padding:.7rem 1rem; text-align:left; font-size:.75rem; font-weight:900; color:#0070e0; text-transform:uppercase; letter-spacing:.06em; font-family:'Nunito',sans-serif; }
.log-table tbody tr { border-bottom:1.5px solid #e6f2ff; transition:background .15s; }
.log-table tbody tr:last-child { border-bottom:none; }
.log-table tbody tr:hover { background:#f4f8ff; }
.log-table tbody td { padding:.7rem 1rem; font-size:.85rem; font-weight:600; color:#0d1f35; }
.chip-sent   { background:#d6f5e6; color:#1fa355; border-radius:999px; padding:.2rem .75rem; font-size:.75rem; font-weight:900; font-family:'Nunito',sans-serif; }
.chip-fail   { background:#ffe3e6; color:#ff4757; border-radius:999px; padding:.2rem .75rem; font-size:.75rem; font-weight:900; font-family:'Nunito',sans-serif; }
.chip-pending{ background:#fff3da; color:#d47a00; border-radius:999px; padding:.2rem .75rem; font-size:.75rem; font-weight:900; font-family:'Nunito',sans-serif; }
.empty-state { text-align:center; padding:2.5rem 1rem; color:#7b96b2; font-weight:700; font-family:'Nunito',sans-serif; }
</style>

<div class="page-title">📲 WhatsApp Blast</div>

<div class="grid2">
  {{-- KIRIM PESAN --}}
  <div class="card">
    <div class="card-title">💬 Kirim Pesan Broadcast</div>
    <form method="POST" action="{{ route('admin.whatsapp.send') }}">
      @csrf

      <div class="sf-group">
        <label class="sf-label">Target Penerima</label>
        <select name="target" class="sf-input">
          <option value="all">Semua Pengguna</option>
          <option value="siswa">Siswa Saja</option>
          <option value="guru">Guru Saja</option>
        </select>
      </div>

      <div class="sf-group">
        <label class="sf-label">Pesan</label>
        <textarea name="pesan" rows="5" class="sf-input" style="resize:vertical;" placeholder="Tulis pesan broadcast di sini...">{{ old('pesan') }}</textarea>
        @error('pesan')<p style="color:#ff4757;font-size:.78rem;font-weight:700;margin-top:.25rem;font-family:'Nunito',sans-serif;">{{ $message }}</p>@enderror
      </div>

      <div class="sf-group">
        <label class="sf-label">Jadwal Kirim <span style="color:#7b96b2;font-weight:600;">(kosongkan = kirim sekarang)</span></label>
        <input name="jadwal" type="datetime-local" class="sf-input" value="{{ old('jadwal') }}">
      </div>

      <button type="submit" class="fbtn">📤 Kirim Sekarang</button>
    </form>
  </div>

  {{-- TEMPLATE --}}
  <div class="card">
    <div class="card-title">📋 Template Pesan</div>
    <div style="display:flex;flex-direction:column;gap:.75rem;">
      @php
        $templates = [
          ['label'=>'Pengingat Streak','icon'=>'🔥','text'=>'Hai {nama}! Jangan lupa belajar hari ini ya, streak kamu sudah {streak} hari! Tetap semangat Smeconer! 💪'],
          ['label'=>'Info Beasiswa','icon'=>'🎓','text'=>'Hai Smeconers! Ada info beasiswa baru di platform Sinau. Cek sekarang sebelum deadline! 📚'],
          ['label'=>'Pengumuman','icon'=>'📢','text'=>'Hai {nama}! Ada pengumuman penting dari SMKN 1 Purwokerto. Silakan cek dashboard Sinau kamu. 🐱'],
        ];
      @endphp
      @foreach($templates as $t)
        <div style="background:#f4f8ff;border:2px solid #d0e4f7;border-radius:14px;padding:1rem;cursor:pointer;transition:all .18s;" onclick="setTemplate(this)" data-text="{{ $t['text'] }}">
          <div style="font-family:'Nunito',sans-serif;font-weight:900;font-size:.88rem;color:#0d1f35;margin-bottom:.3rem;">{{ $t['icon'] }} {{ $t['label'] }}</div>
          <div style="font-size:.8rem;color:#7b96b2;line-height:1.5;">{{ Str::limit($t['text'],80) }}</div>
        </div>
      @endforeach
    </div>
    <p style="font-size:.75rem;color:#7b96b2;margin-top:1rem;font-family:'Nunito',sans-serif;">Klik template untuk mengisi form pesan secara otomatis.</p>
  </div>
</div>

{{-- LOG --}}
<div class="card" style="margin-top:1.25rem;">
  <div class="card-title">📜 Riwayat Pengiriman</div>
  <table class="log-table">
    <thead>
      <tr>
        <th>Waktu</th>
        <th>Target</th>
        <th>Pesan</th>
        <th>Terkirim</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @forelse($logs ?? [] as $log)
        <tr>
          <td style="color:#7b96b2;">{{ $log->created_at->format('d M Y H:i') }}</td>
          <td>{{ ucfirst($log->target) }}</td>
          <td style="max-width:260px;">{{ Str::limit($log->pesan, 60) }}</td>
          <td>{{ $log->terkirim ?? 0 }} orang</td>
          <td><span class="chip-{{ $log->status }}">{{ ucfirst($log->status) }}</span></td>
        </tr>
      @empty
        <tr><td colspan="5"><div class="empty-state">📭 Belum ada riwayat pengiriman.</div></td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<script>
function setTemplate(el) {
  document.querySelector('textarea[name="pesan"]').value = el.dataset.text;
  document.querySelectorAll('[data-text]').forEach(e => e.style.borderColor = '#d0e4f7');
  el.style.borderColor = '#1a8cff';
}
</script>

@endsection
