@extends('layouts.siswa')
@section('title','Pomodoro')
@section('content')
<style>
/* ══ LAYOUT ══════════════════════════════════════ */
.pomo-page    { max-width:960px; margin:0 auto; padding:0 16px; }
.page-title   { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.8rem; color:#0d1f35; margin-bottom:.3rem; letter-spacing:-.5px; text-align:center; }
.page-sub     { color:#7b96b2; font-weight:700; font-size:.9rem; margin-bottom:2rem; text-align:center; }

/* ── 3-column: hourglass | card | hourglass ── */
.pomo-stage   { display:grid; grid-template-columns:140px 1fr 140px; gap:20px; align-items:center; }
.pomo-card    { background:#fff; border:2px solid #d0e4f7; border-radius:2rem; padding:2rem 1.75rem; box-shadow:0 6px 0 #d0e4f7; }

/* ══ HOURGLASS ═══════════════════════════════════ */
.hg-wrap { display:flex; flex-direction:column; align-items:center; gap:12px; }

.hourglass-svg { filter:drop-shadow(0 8px 20px rgba(26,140,255,.18)); }

/* sand fill controlled by JS via CSS var */
.hg-sand-top    { transition: all 1s linear; }
.hg-sand-bottom { transition: all 1s linear; }

.hg-label { font-family:'Nunito',sans-serif; font-weight:900; font-size:.72rem; color:#7b96b2; text-transform:uppercase; letter-spacing:.07em; text-align:center; }
.hg-pct   { font-family:'Nunito',sans-serif; font-weight:900; font-size:1rem; color:#1a8cff; }

/* ══ LIVE BADGE ══════════════════════════════════ */
.live-badge { display:none; align-items:center; gap:6px; background:#d6f5e6; border:2px solid #a0e8c4; color:#1fa355; border-radius:999px; padding:.2rem .8rem; font-family:'Nunito',sans-serif; font-weight:900; font-size:.72rem; margin-bottom:.75rem; justify-content:center; }
.live-dot   { width:7px; height:7px; background:#2ec96b; border-radius:50%; animation:blink 1.2s ease-in-out infinite; }
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:.3} }

/* ══ SESSION COUNTER ═════════════════════════════ */
.session-info { display:flex; justify-content:center; gap:1.5rem; margin-bottom:1.25rem; }
.sess-item    { text-align:center; }
.sess-num     { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.4rem; color:#1a8cff; line-height:1; }
.sess-label   { font-size:.68rem; font-weight:700; color:#7b96b2; text-transform:uppercase; letter-spacing:.05em; margin-top:2px; }

/* ══ RING ════════════════════════════════════════ */
.pomo-ring-wrap { display:flex; justify-content:center; margin-bottom:1.5rem; position:relative; width:200px; height:200px; margin-left:auto; margin-right:auto; }
.pomo-ring      { width:200px; height:200px; transform:rotate(-90deg); }
.pomo-ring .track { fill:none; stroke:#e6f2ff; stroke-width:13; }
.pomo-ring .prog  { fill:none; stroke:#1a8cff; stroke-width:13; stroke-linecap:round; stroke-dasharray:534.07; stroke-dashoffset:0; transition:stroke-dashoffset 1s linear, stroke .4s; }
/* r=85 → circ = 2π×85 = 534.07 */
.pomo-time { position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); text-align:center; pointer-events:none; }
.pomo-time .t   { font-family:'Nunito',sans-serif; font-weight:900; font-size:2.7rem; color:#0d1f35; line-height:1; letter-spacing:-1px; }
.pomo-time .lbl { font-size:.72rem; font-weight:900; color:#7b96b2; margin-top:.3rem; text-transform:uppercase; letter-spacing:.08em; }

/* ══ BUTTONS ═════════════════════════════════════ */
.ctrl-row { display:flex; gap:.6rem; justify-content:center; margin-bottom:.9rem; flex-wrap:wrap; }
.pbtn     { padding:.6rem 1.35rem; border-radius:14px; font-size:.88rem; font-weight:900; border:none; cursor:pointer; font-family:'Nunito',sans-serif; transition:all .18s; }
.pbtn-main  { background:#1a8cff; color:#fff; box-shadow:0 5px 0 #005bb8; }
.pbtn-main:hover  { transform:translateY(-2px); box-shadow:0 7px 0 #005bb8; }
.pbtn-main:active { transform:translateY(3px);  box-shadow:0 2px 0 #005bb8; }
.pbtn-ghost { background:#fff; border:2px solid #d0e4f7; color:#3d5a7a; box-shadow:0 4px 0 #d0e4f7; }
.pbtn-ghost:hover  { background:#f4f8ff; border-color:#bbd9ff; transform:translateY(-1px); }
.pbtn-ghost:active { transform:translateY(3px); box-shadow:0 1px 0 #d0e4f7; }

.mode-row { display:flex; gap:.45rem; justify-content:center; margin-bottom:1.1rem; flex-wrap:wrap; }
.mbtn     { padding:.38rem .9rem; border-radius:12px; font-size:.78rem; font-weight:800; border:2px solid #d0e4f7; background:#fff; color:#7b96b2; cursor:pointer; font-family:'Nunito',sans-serif; transition:all .18s; box-shadow:0 3px 0 #d0e4f7; }
.mbtn:hover  { background:#e6f2ff; color:#1a8cff; border-color:#bbd9ff; }
.mbtn.active { background:#e6f2ff; color:#1a8cff; border-color:#1a8cff; box-shadow:0 3px 0 #bbd9ff; }

/* ══ SOUND BOX ═══════════════════════════════════ */
.sound-box   { background:#f4f8ff; border:2px solid #d0e4f7; border-radius:16px; padding:.9rem 1.1rem; margin-top:1rem; text-align:left; }
.sound-title { font-family:'Nunito',sans-serif; font-weight:900; font-size:.82rem; color:#0d1f35; margin-bottom:.65rem; }
.sound-row   { display:flex; align-items:center; gap:.55rem; margin-bottom:.55rem; flex-wrap:wrap; }
.sound-row:last-child { margin-bottom:0; }
.sound-lbl   { font-family:'Nunito',sans-serif; font-size:.74rem; font-weight:800; color:#3d5a7a; min-width:58px; }
.sound-sel   { flex:1; background:#fff; border:2px solid #d0e4f7; border-radius:10px; padding:.3rem .65rem; font-size:.78rem; font-weight:700; color:#0d1f35; outline:none; font-family:'Nunito',sans-serif; cursor:pointer; transition:border-color .18s; min-width:120px; }
.sound-sel:focus { border-color:#1a8cff; }
.vol-wrap    { display:flex; align-items:center; gap:.5rem; flex:1; }
.vol-slider  { flex:1; height:5px; accent-color:#1a8cff; cursor:pointer; min-width:60px; }
.vol-val     { font-family:'Nunito',sans-serif; font-weight:900; font-size:.74rem; color:#1a8cff; min-width:32px; text-align:right; }
.btn-test    { padding:.28rem .8rem; border-radius:10px; background:#e6f2ff; border:2px solid #bbd9ff; color:#0070e0; font-size:.72rem; font-weight:900; cursor:pointer; font-family:'Nunito',sans-serif; transition:all .15s; white-space:nowrap; }
.btn-test:hover { background:#bbd9ff; }
.mute-btn    { width:28px; height:28px; border-radius:8px; border:2px solid #d0e4f7; background:#fff; display:flex; align-items:center; justify-content:center; font-size:14px; cursor:pointer; transition:all .15s; flex-shrink:0; }
.mute-btn:hover { border-color:#1a8cff; background:#e6f2ff; }
.mute-btn.on { background:#ffe3e6; border-color:#ffb0b8; }
.tts-switch  { position:relative; width:38px; height:20px; cursor:pointer; flex-shrink:0; }
.tts-switch input { opacity:0; width:0; height:0; }
.tts-track   { position:absolute; inset:0; background:#d0e4f7; border-radius:999px; transition:.3s; }
.tts-track::before { content:''; position:absolute; width:14px; height:14px; left:3px; top:3px; background:#fff; border-radius:50%; transition:.3s; }
.tts-switch input:checked + .tts-track { background:#1a8cff; }
.tts-switch input:checked + .tts-track::before { transform:translateX(18px); }
.tts-label   { font-family:'Nunito',sans-serif; font-size:.74rem; font-weight:800; color:#3d5a7a; }
.voice-sel   { flex:1; background:#fff; border:2px solid #d0e4f7; border-radius:10px; padding:.28rem .6rem; font-size:.74rem; font-weight:700; color:#0d1f35; outline:none; font-family:'Nunito',sans-serif; cursor:pointer; min-width:110px; }
.btn-test-tts { padding:.26rem .75rem; border-radius:10px; background:#d6f5e6; border:2px solid #a0e8c4; color:#1fa355; font-size:.7rem; font-weight:900; cursor:pointer; font-family:'Nunito',sans-serif; transition:all .15s; }
.btn-test-tts:hover { background:#a0e8c4; }

/* ══ TICK SETTINGS ══════════════════════════════════ */
.tick-row    { display:flex; align-items:center; gap:.55rem; flex-wrap:wrap; }
.tick-sel    { flex:1; background:#fff; border:2px solid #d0e4f7; border-radius:10px; padding:.3rem .65rem; font-size:.78rem; font-weight:700; color:#0d1f35; outline:none; font-family:'Nunito',sans-serif; cursor:pointer; min-width:120px; }
.tick-sel:focus { border-color:#1a8cff; }

/* ══ KINNERS ═════════════════════════════════════ */
.kinners-pomo { margin-top:1.25rem; text-align:center; }
.kinners-pomo svg { animation:kfloat 3.5s ease-in-out infinite; filter:drop-shadow(0 6px 16px rgba(26,140,255,.18)); }
@keyframes kfloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
.kbubble { background:#e6f2ff; border:2px solid #bbd9ff; border-radius:16px 16px 16px 4px; padding:.55rem 1rem; color:#0070e0; font-size:.82rem; font-style:italic; font-weight:700; display:inline-block; margin-top:.65rem; max-width:260px; line-height:1.5; }

/* ══ RESPONSIVE ══════════════════════════════════ */
@media(max-width:700px){
  .pomo-stage { grid-template-columns:1fr; }
  .hg-wrap    { display:none; }
}
@media(max-width:480px){
  .pomo-time .t { font-size:2.2rem; }
}
</style>

<div class="pomo-page">
  <div class="page-title">⏱️ Pomodoro Timer</div>
  <div class="page-sub">Fokus 25 menit, istirahat 5 menit. Kinners jagain kamu!</div>

  <div class="pomo-stage">

    <!-- ══ JAM PASIR KIRI ══ -->
    <div class="hg-wrap">
      <svg class="hourglass-svg" width="110" height="170" viewBox="0 0 110 170" id="hg-left">
        <defs>
          <clipPath id="clipTop-l">
            <rect id="clipTop-l-rect" x="18" y="10" width="74" height="70" rx="4"/>
          </clipPath>
          <clipPath id="clipBot-l">
            <rect id="clipBot-l-rect" x="18" y="90" width="74" height="70" rx="4"/>
          </clipPath>
          <linearGradient id="sandGradL" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0%" stop-color="#fbbf24"/>
            <stop offset="100%" stop-color="#f59e0b"/>
          </linearGradient>
          <linearGradient id="glassGrad" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0%" stop-color="#e6f2ff" stop-opacity=".9"/>
            <stop offset="100%" stop-color="#bbd9ff" stop-opacity=".6"/>
          </linearGradient>
        </defs>

        <!-- frame luar -->
        <rect x="8" y="2" width="94" height="16" rx="8" fill="#1a8cff"/>
        <rect x="8" y="152" width="94" height="16" rx="8" fill="#1a8cff"/>
        <!-- tiang kiri kanan -->
        <rect x="8" y="10" width="10" height="150" rx="5" fill="#3fa0ff"/>
        <rect x="92" y="10" width="10" height="150" rx="5" fill="#3fa0ff"/>

        <!-- kaca atas -->
        <path d="M18 10 Q18 80 55 85 Q92 80 92 10 Z" fill="url(#glassGrad)" stroke="#bbd9ff" stroke-width="1.5"/>
        <!-- kaca bawah -->
        <path d="M18 160 Q18 90 55 85 Q92 90 92 160 Z" fill="url(#glassGrad)" stroke="#bbd9ff" stroke-width="1.5"/>

        <!-- pasir atas (mengecil) -->
        <g clip-path="url(#clipTop-l)">
          <path id="sand-top-l" d="M18 80 Q18 80 55 85 Q92 80 92 80 L92 10 L18 10 Z" fill="url(#sandGradL)" opacity=".9"/>
        </g>
        <!-- pasir bawah (membesar) -->
        <g clip-path="url(#clipBot-l)">
          <path id="sand-bot-l" d="M18 160 Q18 160 55 155 Q92 160 92 160 L92 160 L18 160 Z" fill="url(#sandGradL)" opacity=".85"/>
        </g>

        <!-- butiran pasir jatuh -->
        <g id="sand-flow-l">
          <circle cx="55" cy="88" r="1.5" fill="#f59e0b" opacity=".8">
            <animate attributeName="cy" values="88;160" dur="1.2s" repeatCount="indefinite"/>
            <animate attributeName="opacity" values=".8;0" dur="1.2s" repeatCount="indefinite"/>
          </circle>
          <circle cx="53" cy="88" r="1" fill="#fbbf24" opacity=".6">
            <animate attributeName="cy" values="88;160" dur="1.2s" begin="0.4s" repeatCount="indefinite"/>
            <animate attributeName="opacity" values=".6;0" dur="1.2s" begin="0.4s" repeatCount="indefinite"/>
          </circle>
          <circle cx="57" cy="88" r="1" fill="#fbbf24" opacity=".6">
            <animate attributeName="cy" values="88;160" dur="1.2s" begin="0.8s" repeatCount="indefinite"/>
            <animate attributeName="opacity" values=".6;0" dur="1.2s" begin="0.8s" repeatCount="indefinite"/>
          </circle>
        </g>

        <!-- highlight kaca -->
        <path d="M22 15 Q30 50 38 80" stroke="white" stroke-width="2.5" fill="none" opacity=".25" stroke-linecap="round"/>
        <path d="M22 155 Q30 120 38 90" stroke="white" stroke-width="2.5" fill="none" opacity=".2" stroke-linecap="round"/>
      </svg>
      <div class="hg-pct" id="hg-pct-left">100%</div>
      <div class="hg-label">Tersisa</div>
    </div>

    <!-- ══ CARD TENGAH ══ -->
    <div class="pomo-card">

      <div class="live-badge" id="liveBadge">
        <span class="live-dot"></span> Timer berjalan di background
      </div>

      <div class="session-info">
        <div class="sess-item"><div class="sess-num" id="sessCount">0</div><div class="sess-label">Sesi Selesai</div></div>
        <div class="sess-item"><div class="sess-num" id="focusTotal">0</div><div class="sess-label">Menit Fokus</div></div>
      </div>

      <div class="pomo-ring-wrap">
        <svg class="pomo-ring" viewBox="0 0 200 200">
          <circle class="track" cx="100" cy="100" r="85"/>
          <circle class="prog"  id="timerRing" cx="100" cy="100" r="85"/>
        </svg>
        <div class="pomo-time">
          <div id="pomo-display" class="t">25:00</div>
          <div id="pomo-label"   class="lbl">Fokus</div>
        </div>
      </div>

      <div class="ctrl-row">
        <button id="btn-start" class="pbtn pbtn-main" onclick="startTimer()">▶ Mulai</button>
        <button class="pbtn pbtn-ghost" onclick="pauseTimer()">⏸ Jeda</button>
        <button class="pbtn pbtn-ghost" onclick="resetTimer()">↺ Reset</button>
      </div>

      <div class="mode-row">
        <button class="mbtn active" id="mode-focus" onclick="setMode('focus')">🍅 Fokus 25</button>
        <button class="mbtn"        id="mode-short" onclick="setMode('short')">☕ Istirahat 5</button>
        <button class="mbtn"        id="mode-long"  onclick="setMode('long')">🛋️ 15 Menit</button>
      </div>

      <!-- Sound -->
      <div class="sound-box">
        <div class="sound-title">🔔 Pengaturan Suara</div>
        <div class="sound-row">
          <span class="sound-lbl">Nada</span>
          <select class="sound-sel" id="soundPicker">
            <optgroup label="🚉 Stasiun &amp; Bandara">
              <option value="station">🚉 Ding-Dong Stasiun</option>
              <option value="airport">✈️ Chime Bandara</option>
              <option value="shinkansen">🚄 Shinkansen</option>
              <option value="announcement">📢 PA System</option>
            </optgroup>
            <optgroup label="🔔 Lainnya">
              <option value="bell">🔔 Bell</option>
              <option value="chime">🎵 Chime</option>
              <option value="digital">📟 Digital</option>
              <option value="gentle">🌸 Gentle</option>
              <option value="alarm">⏰ Alarm</option>
              <option value="success">🎉 Success</option>
            </optgroup>
          </select>
          <button class="btn-test" onclick="playSound(true)">▶ Tes</button>
        </div>
        <div class="sound-row">
          <span class="sound-lbl">Volume</span>
          <div class="vol-wrap">
            <button class="mute-btn" id="muteBtn" onclick="toggleMute()">🔊</button>
            <input type="range" class="vol-slider" id="volSlider" min="0" max="100" value="80" oninput="updateVol(this.value)">
            <span class="vol-val" id="volVal">80%</span>
          </div>
        </div>
        <div class="sound-row">
          <span class="sound-lbl">Suara</span>
          <label class="tts-switch">
            <input type="checkbox" id="ttsToggle" checked onchange="toggleTTS()">
            <span class="tts-track"></span>
          </label>
          <span class="tts-label" id="ttsLabel">Aktif</span>
        </div>
        <div class="sound-row" id="voiceRow">
          <span class="sound-lbl">Voice</span>
          <select class="voice-sel" id="voicePicker"></select>
          <button class="btn-test-tts" onclick="testTTS()">▶ Tes</button>
        </div>
        <div class="sound-row" id="ttsSpeedRow">
          <span class="sound-lbl">Speed</span>
          <div class="vol-wrap">
            <input type="range" class="vol-slider" id="ttsSpeed" min="50" max="150" value="90" oninput="updateSpeed(this.value)">
            <span class="vol-val" id="ttsSpeedVal">0.9x</span>
          </div>
        </div>
        <div class="sound-row">
          <span class="sound-lbl">Tik-Tik</span>
          <label class="tts-switch">
            <input type="checkbox" id="tickToggle" checked onchange="toggleTick()">
            <span class="tts-track"></span>
          </label>
          <select class="tick-sel" id="tickStyle">
            <option value="clock">🕐 Jam Dinding</option>
            <option value="soft">🌧️ Rain Drop</option>
            <option value="wood">🪵 Kayu Ketuk</option>
            <option value="digital">💻 Digital Soft</option>
            <option value="heart">💓 Heartbeat</option>
          </select>
        </div>
        <div class="sound-row">
          <span class="sound-lbl">Vol Tik</span>
          <div class="vol-wrap">
            <input type="range" class="vol-slider" id="tickVol" min="1" max="60" value="18" oninput="updateTickVol(this.value)">
            <span class="vol-val" id="tickVolVal">18%</span>
          </div>
        </div>
      </div>

      <!-- Kinners -->
      <div class="kinners-pomo">
        <svg width="72" height="72" viewBox="0 0 120 120" fill="none">
          <circle cx="60" cy="68" r="44" fill="white" stroke="#7dd3fc" stroke-width="2"/>
          <path d="M28 46 L16 14 L50 38 Z" fill="white" stroke="#7dd3fc" stroke-width="1.8" stroke-linejoin="round"/>
          <path d="M31 43 L21 18 L47 36 Z" fill="#bae6fd"/>
          <path d="M92 46 L104 14 L70 38 Z" fill="white" stroke="#7dd3fc" stroke-width="1.8" stroke-linejoin="round"/>
          <path d="M89 43 L99 18 L73 36 Z" fill="#bae6fd"/>
          <ellipse cx="46" cy="64" rx="10" ry="11" fill="white" stroke="#7dd3fc" stroke-width="1.2"/>
          <ellipse cx="74" cy="64" rx="10" ry="11" fill="white" stroke="#7dd3fc" stroke-width="1.2"/>
          <circle cx="47" cy="65" r="6" fill="#0f172a"/>
          <circle cx="75" cy="65" r="6" fill="#0f172a"/>
          <circle cx="50" cy="62" r="2.5" fill="white"/>
          <circle cx="78" cy="62" r="2.5" fill="white"/>
          <ellipse cx="36" cy="76" rx="9" ry="5.5" fill="#fda4af" opacity=".45"/>
          <ellipse cx="84" cy="76" rx="9" ry="5.5" fill="#fda4af" opacity=".45"/>
          <ellipse cx="60" cy="78" rx="4" ry="3" fill="#7dd3fc"/>
          <path d="M52 85 Q60 93 68 85" stroke="#7dd3fc" stroke-width="2" fill="none" stroke-linecap="round"/>
        </svg>
        <div class="kbubble" id="kinnersMsg">"Ayo fokus, Smeconer! Kinners ikut belajar bareng~ 📚"</div>
      </div>

    </div><!-- end card -->

    <!-- ══ JAM PASIR KANAN ══ -->
    <div class="hg-wrap">
      <svg class="hourglass-svg" width="110" height="170" viewBox="0 0 110 170" id="hg-right">
        <defs>
          <clipPath id="clipTop-r">
            <rect id="clipTop-r-rect" x="18" y="10" width="74" height="70" rx="4"/>
          </clipPath>
          <clipPath id="clipBot-r">
            <rect id="clipBot-r-rect" x="18" y="90" width="74" height="70" rx="4"/>
          </clipPath>
          <linearGradient id="sandGradR" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0%" stop-color="#818cf8"/>
            <stop offset="100%" stop-color="#6366f1"/>
          </linearGradient>
          <linearGradient id="glassGradR" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0%" stop-color="#ede8ff" stop-opacity=".9"/>
            <stop offset="100%" stop-color="#c8b0ff" stop-opacity=".6"/>
          </linearGradient>
        </defs>

        <!-- frame -->
        <rect x="8" y="2" width="94" height="16" rx="8" fill="#7c4dff"/>
        <rect x="8" y="152" width="94" height="16" rx="8" fill="#7c4dff"/>
        <rect x="8" y="10" width="10" height="150" rx="5" fill="#9c7cff"/>
        <rect x="92" y="10" width="10" height="150" rx="5" fill="#9c7cff"/>

        <!-- kaca -->
        <path d="M18 10 Q18 80 55 85 Q92 80 92 10 Z" fill="url(#glassGradR)" stroke="#c8b0ff" stroke-width="1.5"/>
        <path d="M18 160 Q18 90 55 85 Q92 90 92 160 Z" fill="url(#glassGradR)" stroke="#c8b0ff" stroke-width="1.5"/>

        <!-- pasir -->
        <g clip-path="url(#clipTop-r)">
          <path id="sand-top-r" d="M18 80 Q18 80 55 85 Q92 80 92 80 L92 10 L18 10 Z" fill="url(#sandGradR)" opacity=".9"/>
        </g>
        <g clip-path="url(#clipBot-r)">
          <path id="sand-bot-r" d="M18 160 Q18 160 55 155 Q92 160 92 160 L92 160 L18 160 Z" fill="url(#sandGradR)" opacity=".85"/>
        </g>

        <!-- aliran pasir -->
        <g id="sand-flow-r">
          <circle cx="55" cy="88" r="1.5" fill="#6366f1" opacity=".8">
            <animate attributeName="cy" values="88;160" dur="1.4s" repeatCount="indefinite"/>
            <animate attributeName="opacity" values=".8;0" dur="1.4s" repeatCount="indefinite"/>
          </circle>
          <circle cx="53" cy="88" r="1" fill="#818cf8" opacity=".6">
            <animate attributeName="cy" values="88;160" dur="1.4s" begin="0.5s" repeatCount="indefinite"/>
            <animate attributeName="opacity" values=".6;0" dur="1.4s" begin="0.5s" repeatCount="indefinite"/>
          </circle>
          <circle cx="57" cy="88" r="1" fill="#818cf8" opacity=".6">
            <animate attributeName="cy" values="88;160" dur="1.4s" begin="0.9s" repeatCount="indefinite"/>
            <animate attributeName="opacity" values=".6;0" dur="1.4s" begin="0.9s" repeatCount="indefinite"/>
          </circle>
        </g>

        <!-- highlight -->
        <path d="M22 15 Q30 50 38 80" stroke="white" stroke-width="2.5" fill="none" opacity=".25" stroke-linecap="round"/>
        <path d="M22 155 Q30 120 38 90" stroke="white" stroke-width="2.5" fill="none" opacity=".2" stroke-linecap="round"/>
      </svg>
      <div class="hg-pct" id="hg-pct-right">0%</div>
      <div class="hg-label">Terpakai</div>
    </div>

  </div><!-- end stage -->
</div>

<script>
// ════════════════════════════════════════════
//  CONFIG
// ════════════════════════════════════════════
const CIRC = 2 * Math.PI * 85; // 534.07
const MODES = {
  focus: { s:25*60, label:'Fokus',             color:'#1a8cff', msg:'"Ayo fokus, Smeconer! Kinners ikut belajar bareng~ 📚"' },
  short: { s: 5*60, label:'Istirahat Pendek',  color:'#2ec96b', msg:'"Sebentar istirahat dulu ya~ Kinners nungguin! ☕"' },
  long:  { s:15*60, label:'Istirahat Panjang', color:'#ff9500', msg:'"Istirahat panjang! Regangkan badan dulu~ 🛋️"' },
};
const SK = 'sinau_pomo';

// ════════════════════════════════════════════
//  STATE
// ════════════════════════════════════════════
let mode      = 'focus';
let total     = MODES.focus.s;
let remaining = total;
let running   = false;
let timerInt  = null;
let sess      = 0;
let focusMins = 0;
let vol       = 0.8;
let muted     = false;
let ttsEnabled= true;
let ttsVoice  = null;
let ttsRate   = 0.9;
let audioCtx  = null;
let tickEnabled  = true;
let tickVolume   = 0.18;
let tickStyle    = 'clock';
let tickInterval = null;

// ════════════════════════════════════════════
//  DOM
// ════════════════════════════════════════════
const dispEl   = document.getElementById('pomo-display');
const labelEl  = document.getElementById('pomo-label');
const ring     = document.getElementById('timerRing');
const btnStart = document.getElementById('btn-start');
const sessEl   = document.getElementById('sessCount');
const focusEl  = document.getElementById('focusTotal');
const kMsg     = document.getElementById('kinnersMsg');
const liveBadge= document.getElementById('liveBadge');
const picker   = document.getElementById('soundPicker');
const volSlider= document.getElementById('volSlider');
const volValEl = document.getElementById('volVal');
const muteBtn  = document.getElementById('muteBtn');

// hourglass elements
const sandTopL = document.getElementById('sand-top-l');
const sandBotL = document.getElementById('sand-bot-l');
const sandTopR = document.getElementById('sand-top-r');
const sandBotR = document.getElementById('sand-bot-r');
const flowL    = document.getElementById('sand-flow-l');
const flowR    = document.getElementById('sand-flow-r');
const pctLeft  = document.getElementById('hg-pct-left');
const pctRight = document.getElementById('hg-pct-right');

// ════════════════════════════════════════════
//  HOURGLASS UPDATE
//  pasir atas mengecil (makin tipis ke bawah)
//  pasir bawah membesar (makin penuh dari bawah)
// ════════════════════════════════════════════
function updateHourglass() {
  const pct = remaining / total; // 1.0 → 0.0
  const used = 1 - pct;          // 0.0 → 1.0

  // Pasir atas: y puncak tetap di 10, y bawah dari 80 → naik ke 10 (mengecil)
  // saat pct=1 → penuh (y dari 10 ke 80)
  // saat pct=0 → kosong (y dari 80 ke 80, collapsed)
  const topY = 10 + (80 - 10) * pct; // 80→10 seiring waktu
  sandTopL.setAttribute('d', `M18 80 Q18 80 55 85 Q92 80 92 80 L92 ${topY} L18 ${topY} Z`);
  sandTopR.setAttribute('d', `M18 80 Q18 80 55 85 Q92 80 92 80 L92 ${topY} L18 ${topY} Z`);

  // Pasir bawah: y puncak turun dari 160 → 90 seiring waktu (membesar dari bawah)
  const botY = 160 - (160 - 90) * used; // 160→90
  sandBotL.setAttribute('d', `M18 160 Q18 160 55 155 Q92 160 92 160 L92 160 L18 160 Z`);
  sandBotR.setAttribute('d', `M18 160 Q18 160 55 155 Q92 160 92 160 L92 160 L18 160 Z`);

  // Untuk pasir bawah yang terlihat naik, kita clip dari bawah ke atas
  // pakai rect clip yang y-nya berubah
  const clipBotY = botY;
  const clipBotH = 160 - clipBotY + 10;
  document.getElementById('clipBot-l-rect').setAttribute('y', clipBotY);
  document.getElementById('clipBot-l-rect').setAttribute('height', clipBotH);
  document.getElementById('clipBot-r-rect').setAttribute('y', clipBotY);
  document.getElementById('clipBot-r-rect').setAttribute('height', clipBotH);

  // pasir atas clip
  document.getElementById('clipTop-l-rect').setAttribute('y', topY);
  document.getElementById('clipTop-l-rect').setAttribute('height', 80 - topY + 10);
  document.getElementById('clipTop-r-rect').setAttribute('y', topY);
  document.getElementById('clipTop-r-rect').setAttribute('height', 80 - topY + 10);

  // persentase label
  pctLeft.textContent  = Math.round(pct * 100) + '%';
  pctRight.textContent = Math.round(used * 100) + '%';

  // aliran pasir: tampil hanya kalau running dan ada pasir di atas
  const showFlow = running && pct > 0.01;
  flowL.style.display = showFlow ? '' : 'none';
  flowR.style.display = showFlow ? '' : 'none';
}

// ════════════════════════════════════════════
//  BACKGROUND TIMER (localStorage)
// ════════════════════════════════════════════
function saveState() {
  localStorage.setItem(SK, JSON.stringify({
    mode, total, remaining, running,
    startedAt: running ? Date.now() : null,
    sess, focusMins,
    sound: picker.value,
    vol: volSlider.value,
  }));
}

function loadState() {
  try {
    const raw = localStorage.getItem(SK);
    if (!raw) return false;
    const st = JSON.parse(raw);
    if (st.running && st.startedAt) {
      const elapsed = Math.floor((Date.now() - st.startedAt) / 1000);
      st.remaining  = Math.max(0, st.remaining - elapsed);
    }
    mode      = st.mode      || 'focus';
    total     = st.total     || MODES[mode].s;
    remaining = st.remaining ?? total;
    sess      = st.sess      || 0;
    focusMins = st.focusMins || 0;
    if (st.sound)   picker.value      = st.sound;
    if (st.vol)   { volSlider.value   = st.vol; updateVol(st.vol); }
    document.querySelectorAll('.mbtn').forEach(b => b.classList.remove('active'));
    const mb = document.getElementById('mode-' + mode);
    if (mb) mb.classList.add('active');
    labelEl.textContent = MODES[mode].label;
    ring.style.stroke   = MODES[mode].color;
    sessEl.textContent  = sess;
    focusEl.textContent = focusMins;
    if (st.running) {
      remaining <= 0 ? setTimeout(onEnd, 200) : setTimeout(startTimer, 100);
    }
    return true;
  } catch(e) { return false; }
}

function clearState() { localStorage.removeItem(SK); }

// ════════════════════════════════════════════
//  DISPLAY
// ════════════════════════════════════════════
function fmt(s) {
  return String(Math.floor(s/60)).padStart(2,'0') + ':' + String(s%60).padStart(2,'0');
}

function redraw() {
  dispEl.textContent = fmt(remaining);
  const offset = CIRC * (1 - remaining / total);
  ring.style.strokeDasharray  = CIRC;
  ring.style.strokeDashoffset = offset;
  updateHourglass();
}

function setLiveBadge(on) {
  liveBadge.style.display = on ? 'flex' : 'none';
}

// ════════════════════════════════════════════
//  CONTROLS
// ════════════════════════════════════════════
function startTimer() {
  if (running) return;
  running = true;
  btnStart.textContent   = '▶ Berjalan...';
  btnStart.disabled      = true;
  btnStart.style.opacity = '.65';
  setLiveBadge(true);
  saveState();
  startTick(); // mulai suara tik-tik
  timerInt = setInterval(() => {
    if (remaining <= 0) { clearInterval(timerInt); running = false; stopTick(); onEnd(); return; }
    remaining--;
    redraw();
    saveState();
  }, 1000);
}

function pauseTimer() {
  if (!running) return;
  clearInterval(timerInt); running = false;
  btnStart.textContent   = '▶ Lanjut';
  btnStart.disabled      = false;
  btnStart.style.opacity = '1';
  setLiveBadge(false);
  stopTick();
  flowL.style.display = 'none';
  flowR.style.display = 'none';
  saveState();
}

function resetTimer() {
  clearInterval(timerInt); running = false; remaining = total;
  btnStart.textContent   = '▶ Mulai';
  btnStart.disabled      = false;
  btnStart.style.opacity = '1';
  setLiveBadge(false);
  stopTick();
  flowL.style.display = 'none';
  flowR.style.display = 'none';
  clearState(); redraw();
}

function setMode(m) {
  clearInterval(timerInt); running = false;
  mode = m; total = MODES[m].s; remaining = total;
  labelEl.textContent    = MODES[m].label;
  kMsg.textContent       = MODES[m].msg;
  ring.style.stroke      = MODES[m].color;
  btnStart.textContent   = '▶ Mulai';
  btnStart.disabled      = false;
  btnStart.style.opacity = '1';
  setLiveBadge(false);
  flowL.style.display = 'none';
  flowR.style.display = 'none';
  clearState(); redraw();
  document.querySelectorAll('.mbtn').forEach(b => b.classList.remove('active'));
  document.getElementById('mode-' + m).classList.add('active');
}

function onEnd() {
  running = false;
  btnStart.textContent   = '▶ Mulai';
  btnStart.disabled      = false;
  btnStart.style.opacity = '1';
  setLiveBadge(false);
  stopTick();
  flowL.style.display = 'none';
  flowR.style.display = 'none';
  clearState();
  playSound();
  if ('Notification' in window && Notification.permission === 'granted') {
    new Notification(mode==='focus' ? '🍅 Sesi fokus selesai!' : '☕ Istirahat selesai!', { body:'Sinau Pomodoro' });
  }
  const soundDurs = { station:6500, airport:10500, shinkansen:5000, announcement:6000, bell:2500, chime:2000, digital:1200, gentle:2500, alarm:1800, success:2000 };
  const delay = soundDurs[picker.value] || 2500;
  if (mode === 'focus') {
    sess++; focusMins += 25;
    sessEl.textContent  = sess;
    focusEl.textContent = focusMins;
    kMsg.textContent    = '"Hebat! Satu sesi selesai~ Istirahat dulu ya! 🎉"';
    setTimeout(() => speak('Perhatian. Waktu belajar telah selesai. Saatnya istirahat. Hebat, Smeconer!'), delay);
    setTimeout(() => setMode('short'), delay + 4000);
  } else {
    kMsg.textContent = '"Yuk, lanjut fokus lagi! Kinners siap menemani~ 📚"';
    setTimeout(() => speak('Perhatian. Waktu istirahat telah selesai. Ayo kembali belajar. Semangat!'), delay);
    setTimeout(() => setMode('focus'), delay + 4000);
  }
}

// ════════════════════════════════════════════
//  TTS
// ════════════════════════════════════════════
function initVoices() {
  const sel    = document.getElementById('voicePicker');
  const voices = window.speechSynthesis.getVoices();
  const idV    = voices.filter(v => v.lang.startsWith('id') || v.lang.startsWith('in'));
  const use    = idV.length ? idV : voices.slice(0, 10);
  sel.innerHTML = '';
  use.forEach((v, i) => {
    const o = document.createElement('option');
    o.value = i; o.textContent = v.name + ' (' + v.lang + ')';
    sel.appendChild(o);
  });
  ttsVoice = use[0] || null;
  sel.onchange = () => { ttsVoice = use[parseInt(sel.value)]; };
}

function speak(text) {
  if (!ttsEnabled || muted) return;
  if (!('speechSynthesis' in window)) return;
  window.speechSynthesis.cancel();
  setTimeout(() => {
    const u = new SpeechSynthesisUtterance(text);
    u.lang = 'id-ID'; u.rate = ttsRate; u.pitch = 1.05; u.volume = vol;
    if (ttsVoice) u.voice = ttsVoice;
    window.speechSynthesis.speak(u);
  }, 300);
}

function toggleTTS() {
  ttsEnabled = document.getElementById('ttsToggle').checked;
  document.getElementById('ttsLabel').textContent       = ttsEnabled ? 'Aktif' : 'Mati';
  document.getElementById('voiceRow').style.opacity     = ttsEnabled ? '1' : '.4';
  document.getElementById('ttsSpeedRow').style.opacity  = ttsEnabled ? '1' : '.4';
}
function updateSpeed(val) { ttsRate = val/100; document.getElementById('ttsSpeedVal').textContent = ttsRate.toFixed(1)+'x'; }
function testTTS()        { speak('Perhatian, waktu belajar telah selesai. Silakan beristirahat.'); }
if ('speechSynthesis' in window) { window.speechSynthesis.onvoiceschanged = initVoices; initVoices(); }

// ════════════════════════════════════════════
//  AUDIO
// ════════════════════════════════════════════
function ctx() {
  if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();
  if (audioCtx.state === 'suspended') audioCtx.resume();
  return audioCtx;
}
function tone(freq, start, dur, type='sine', g=0.4) {
  const c=ctx(), o=c.createOscillator(), gn=c.createGain();
  o.connect(gn); gn.connect(c.destination);
  o.type=type; o.frequency.value=freq;
  const v=muted?0:g*vol;
  gn.gain.setValueAtTime(v, c.currentTime+start);
  gn.gain.exponentialRampToValueAtTime(0.001, c.currentTime+start+dur);
  o.start(c.currentTime+start); o.stop(c.currentTime+start+dur+.05);
}

const SOUNDS = {
  station: (v) => {
    const c=ctx();
    const r=(f,t,d,g)=>{const o=c.createOscillator(),gn=c.createGain();o.connect(gn);gn.connect(c.destination);o.type='sine';o.frequency.value=f;const vv=muted?0:g*vol;gn.gain.setValueAtTime(0,c.currentTime+t);gn.gain.linearRampToValueAtTime(vv,c.currentTime+t+.04);gn.gain.setValueAtTime(vv,c.currentTime+t+d-.12);gn.gain.linearRampToValueAtTime(0,c.currentTime+t+d);o.start(c.currentTime+t);o.stop(c.currentTime+t+d+.05);};
    r(329.63,0.00,.60,v*.76);r(261.63,.65,.60,v*.74);r(293.66,1.30,.60,v*.74);r(392.00,1.95,1.00,v*.80);
    r(392.00,3.20,.60,v*.74);r(293.66,3.85,.60,v*.72);r(261.63,4.50,.60,v*.72);r(329.63,5.15,1.10,v*.70);
  },
  airport: (v) => {
    const c=ctx();
    const b=(f,t,d,g)=>{[1,2.76,5.4].forEach((m,i)=>{const o=c.createOscillator(),gn=c.createGain();o.connect(gn);gn.connect(c.destination);o.type='sine';o.frequency.value=f*m;const vv=muted?0:(g/(i+1))*vol;gn.gain.setValueAtTime(vv,c.currentTime+t);gn.gain.exponentialRampToValueAtTime(0.001,c.currentTime+t+d*(1/(i*.4+1)));o.start(c.currentTime+t);o.stop(c.currentTime+t+d+.1);});};
    b(659.25,0.00,1.4,v*.80);b(830.61,1.10,1.4,v*.78);b(739.99,2.20,1.4,v*.78);b(493.88,3.30,1.8,v*.82);
    b(493.88,5.40,1.4,v*.76);b(739.99,6.50,1.4,v*.76);b(830.61,7.60,1.4,v*.76);b(659.25,8.70,2.2,v*.80);
  },
  shinkansen: (v) => {
    [[659,0,.30,v*.70,'triangle'],[784,.33,.30,v*.72,'triangle'],[880,.66,.30,v*.74,'triangle'],[988,.99,.55,v*.78,'triangle'],
     [880,1.70,.25,v*.70,'triangle'],[784,1.97,.25,v*.68,'triangle'],[659,2.24,.25,v*.68,'triangle'],[587,2.51,.25,v*.65,'triangle'],
     [659,2.95,.25,v*.68,'triangle'],[784,3.22,.25,v*.70,'triangle'],[880,3.49,.25,v*.72,'triangle'],[1047,3.76,.90,v*.78,'triangle']]
    .forEach(([f,t,d,g,tp])=>tone(f,t,d,tp,g));
  },
  announcement: (v) => {
    const c=ctx();
    const p=(f,t,d,g)=>{const o=c.createOscillator(),gn=c.createGain();o.connect(gn);gn.connect(c.destination);o.type='sine';o.frequency.value=f;const vv=muted?0:g*vol;gn.gain.setValueAtTime(0,c.currentTime+t);gn.gain.linearRampToValueAtTime(vv,c.currentTime+t+.03);gn.gain.setValueAtTime(vv,c.currentTime+t+d-.15);gn.gain.linearRampToValueAtTime(0,c.currentTime+t+d);o.start(c.currentTime+t);o.stop(c.currentTime+t+d+.05);};
    p(392.00,0.00,.55,v*.70);p(523.25,.60,.55,v*.72);p(659.25,1.20,.80,v*.76);
    p(659.25,2.25,.50,v*.72);p(523.25,2.78,.50,v*.70);p(392.00,3.31,.50,v*.68);
    p(523.25,4.05,.50,v*.67);p(659.25,4.58,1.10,v*.65);
  },
  bell:    (v)=>{ [[880,0,.6],[1108,.7,.5],[880,1.4,.8]].forEach(([f,t,d])=>tone(f,t,d,'sine',v*.7)); },
  chime:   (v)=>{ [[523,0,.35],[659,.3,.35],[784,.6,.35],[1047,.9,.6]].forEach(([f,t,d])=>tone(f,t,d,'triangle',v*.9)); },
  digital: (v)=>{ [0,.35,.7].forEach(t=>tone(1000,t,.25,'square',v*.5)); },
  gentle:  (v)=>{ [[396,0,.8],[528,.6,.8],[660,1.2,1.0]].forEach(([f,t,d])=>tone(f,t,d,'sine',v*.55)); },
  alarm:   (v)=>{ for(let i=0;i<6;i++) tone(i%2?660:880,i*.25,.2,'sawtooth',v*.4); },
  success: (v)=>{ [[523,0,.2],[659,.2,.2],[784,.4,.2],[1047,.6,.5],[784,.9,.15],[1047,1.05,.6]].forEach(([f,t,d])=>tone(f,t,d,'triangle',v*.85)); },
};

function playSound(isTest=false) {
  if (muted && !isTest) return;
  try { SOUNDS[picker.value]?.(vol); } catch(e) {}
}
function updateVol(v)  { vol=v/100; volValEl.textContent=v+'%'; }
function toggleMute()  { muted=!muted; muteBtn.textContent=muted?'🔇':'🔊'; muteBtn.classList.toggle('on',muted); volSlider.style.opacity=muted?'.4':'1'; }

// ════════════════════════════════════════════
//  TICK ENGINE
// ════════════════════════════════════════════
const TICKS = {
  // 🕐 Jam dinding klasik — click mekanik
  clock: () => {
    const c = ctx();
    // click keras (tick)
    const buf = c.createBuffer(1, c.sampleRate * 0.04, c.sampleRate);
    const data = buf.getChannelData(0);
    for (let i = 0; i < data.length; i++) {
      data[i] = (Math.random() * 2 - 1) * Math.exp(-i / (c.sampleRate * 0.008));
    }
    const src = c.createBufferSource();
    const flt = c.createBiquadFilter();
    const gn  = c.createGain();
    src.buffer = buf;
    flt.type = 'bandpass'; flt.frequency.value = 1800; flt.Q.value = 3;
    src.connect(flt); flt.connect(gn); gn.connect(c.destination);
    gn.gain.setValueAtTime(muted ? 0 : tickVolume * 1.8, c.currentTime);
    gn.gain.exponentialRampToValueAtTime(0.001, c.currentTime + 0.04);
    src.start(); src.stop(c.currentTime + 0.05);
  },

  // 🌧️ Rain drop — tetesan air lembut
  soft: () => {
    const c = ctx();
    const o = c.createOscillator(), gn = c.createGain();
    o.connect(gn); gn.connect(c.destination);
    o.type = 'sine';
    o.frequency.setValueAtTime(1200, c.currentTime);
    o.frequency.exponentialRampToValueAtTime(600, c.currentTime + 0.06);
    const v = muted ? 0 : tickVolume * 0.9;
    gn.gain.setValueAtTime(v, c.currentTime);
    gn.gain.exponentialRampToValueAtTime(0.001, c.currentTime + 0.08);
    o.start(); o.stop(c.currentTime + 0.09);
  },

  // 🪵 Kayu ketuk — woodblock
  wood: () => {
    const c = ctx();
    const buf = c.createBuffer(1, c.sampleRate * 0.05, c.sampleRate);
    const data = buf.getChannelData(0);
    for (let i = 0; i < data.length; i++) {
      data[i] = (Math.random() * 2 - 1) * Math.exp(-i / (c.sampleRate * 0.012));
    }
    const src = c.createBufferSource();
    const flt = c.createBiquadFilter();
    const gn  = c.createGain();
    src.buffer = buf;
    flt.type = 'bandpass'; flt.frequency.value = 800; flt.Q.value = 8;
    src.connect(flt); flt.connect(gn); gn.connect(c.destination);
    gn.gain.setValueAtTime(muted ? 0 : tickVolume * 2.0, c.currentTime);
    gn.gain.exponentialRampToValueAtTime(0.001, c.currentTime + 0.05);
    src.start(); src.stop(c.currentTime + 0.06);
  },

  // 💻 Digital soft — click keyboard lembut
  digital: () => {
    const c = ctx();
    const o = c.createOscillator(), gn = c.createGain();
    o.connect(gn); gn.connect(c.destination);
    o.type = 'square'; o.frequency.value = 440;
    const v = muted ? 0 : tickVolume * 0.4;
    gn.gain.setValueAtTime(v, c.currentTime);
    gn.gain.exponentialRampToValueAtTime(0.001, c.currentTime + 0.03);
    o.start(); o.stop(c.currentTime + 0.035);
  },

  // 💓 Heartbeat — dua detakan lembut
  heart: () => {
    const c = ctx();
    const beat = (delay) => {
      const o = c.createOscillator(), gn = c.createGain();
      o.connect(gn); gn.connect(c.destination);
      o.type = 'sine'; o.frequency.value = 60;
      const v = muted ? 0 : tickVolume * 1.2;
      gn.gain.setValueAtTime(0, c.currentTime + delay);
      gn.gain.linearRampToValueAtTime(v, c.currentTime + delay + 0.02);
      gn.gain.exponentialRampToValueAtTime(0.001, c.currentTime + delay + 0.12);
      o.start(c.currentTime + delay); o.stop(c.currentTime + delay + 0.15);
    };
    beat(0); beat(0.18); // lub-dub
  },
};

function playTick() {
  if (!tickEnabled || muted) return;
  try { TICKS[tickStyle]?.(); } catch(e) {}
}

function startTick() {
  stopTick();
  if (!tickEnabled) return;
  playTick(); // langsung tick pertama
  tickInterval = setInterval(playTick, 1000);
}

function stopTick() {
  if (tickInterval) { clearInterval(tickInterval); tickInterval = null; }
}

function toggleTick() {
  tickEnabled = document.getElementById('tickToggle').checked;
  if (running) {
    tickEnabled ? startTick() : stopTick();
  }
}

function updateTickVol(v) {
  tickVolume = v / 100;
  document.getElementById('tickVolVal').textContent = v + '%';
}

// sync tickStyle dengan selector
document.getElementById('tickStyle').addEventListener('change', function() {
  tickStyle = this.value;
  if (running && tickEnabled) {
    stopTick(); startTick(); // restart dengan style baru
  }
});

// ════════════════════════════════════════════
//  VISIBILITY API
// ════════════════════════════════════════════
document.addEventListener('visibilitychange', () => {
  if (!document.hidden && running) {
    try {
      const st = JSON.parse(localStorage.getItem(SK));
      if (st?.running && st?.startedAt) {
        const elapsed = Math.floor((Date.now() - st.startedAt) / 1000);
        remaining = Math.max(0, st.remaining - elapsed);
        redraw();
        if (remaining <= 0) { clearInterval(timerInt); running = false; onEnd(); }
      }
    } catch(e) {}
  }
});

// ════════════════════════════════════════════
//  INIT
// ════════════════════════════════════════════
ring.style.strokeDasharray  = CIRC;
ring.style.strokeDashoffset = 0;
ring.style.stroke           = MODES.focus.color;
flowL.style.display = 'none';
flowR.style.display = 'none';
if (!loadState()) redraw();
else redraw();
if ('Notification' in window && Notification.permission === 'default') Notification.requestPermission();
</script>

@endsection
