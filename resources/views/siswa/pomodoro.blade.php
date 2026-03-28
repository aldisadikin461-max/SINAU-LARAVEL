@extends('layouts.siswa')
@section('title','Pomodoro')
@section('content')
<style>
  .pomo-wrap{max-width:460px;margin:0 auto;text-align:center;}
  .page-title{font-family:'Fredoka One',sans-serif;font-size:1.8rem;color:#0f172a;margin-bottom:.4rem;}
  .page-sub{color:#94a3b8;font-weight:700;font-size:.9rem;margin-bottom:2rem;}
  .pomo-card{background:#fff;border:1.5px solid rgba(14,165,233,.12);border-radius:2rem;padding:2.5rem 2rem;box-shadow:0 8px 32px rgba(14,165,233,.1);}
  .pomo-ring-wrap{display:flex;justify-content:center;margin-bottom:1.75rem;position:relative;}
  .pomo-time{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;}
  .pomo-time .t{font-family:'Fredoka One',sans-serif;font-size:3rem;color:#0f172a;line-height:1;}
  .pomo-time .lbl{font-size:.8rem;font-weight:800;color:#94a3b8;margin-top:.25rem;}
  .pomo-ring{width:200px;height:200px;}
  .pomo-ring circle{fill:none;stroke-width:14;stroke-linecap:round;}
  .pomo-ring .track{stroke:#e0f2fe;}
  .pomo-ring .timer{stroke:url(#pg);transition:stroke-dashoffset 1s linear;transform-origin:center;transform:rotate(-90deg);}
  .ctrl-row{display:flex;gap:.75rem;justify-content:center;margin-bottom:1rem;}
  .pbtn{padding:.65rem 1.5rem;border-radius:999px;font-size:.9rem;font-weight:800;border:none;cursor:pointer;font-family:'Nunito',sans-serif;transition:all .2s;}
  .pbtn-main{background:linear-gradient(135deg,#0ea5e9,#0284c7);color:#fff;box-shadow:0 4px 14px rgba(14,165,233,.3);}
  .pbtn-main:hover{transform:translateY(-2px);}
  .pbtn-ghost{background:#fff;border:2px solid rgba(14,165,233,.2);color:#0284c7;}
  .pbtn-ghost:hover{background:#f0f9ff;}
  .mode-row{display:flex;gap:.5rem;justify-content:center;margin-bottom:2rem;}
  .mbtn{padding:.38rem 1rem;border-radius:999px;font-size:.82rem;font-weight:800;border:1.5px solid rgba(14,165,233,.2);background:#fff;color:#64748b;cursor:pointer;font-family:'Nunito',sans-serif;transition:all .18s;}
  .mbtn:hover{background:#f0f9ff;color:#0ea5e9;border-color:#0ea5e9;}
  .kinners-pomo{margin-top:1.5rem;}
  .kinners-pomo svg{animation:float 3.5s ease-in-out infinite;filter:drop-shadow(0 8px 18px rgba(14,165,233,.18));}
  @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
  .kbubble{background:#e0f2fe;border:1px solid rgba(14,165,233,.2);border-radius:1rem 1rem 1rem 0;padding:.55rem 1rem;color:#0284c7;font-size:.85rem;font-style:italic;font-weight:700;display:inline-block;margin-top:.6rem;}
</style>

<div class="pomo-wrap">
  <div class="page-title">⏱️ Pomodoro Timer</div>
  <div class="page-sub">Fokus 25 menit, istirahat 5 menit. Kinners jagain kamu!</div>

  <div class="pomo-card">
    <div class="pomo-ring-wrap">
      <svg class="pomo-ring" viewBox="0 0 200 200">
        <defs>
          <linearGradient id="pg" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#0ea5e9"/>
            <stop offset="100%" stop-color="#38bdf8"/>
          </linearGradient>
        </defs>
        <circle class="track" cx="100" cy="100" r="86"/>
        <circle class="timer" cx="100" cy="100" r="86" data-total="1500" style="stroke-dasharray:540.35;stroke-dashoffset:0;"/>
      </svg>
      <div class="pomo-time">
        <div id="pomodoro-time" class="t">25:00</div>
        <div id="pomodoro-label" class="lbl">Fokus</div>
      </div>
    </div>

    <div class="ctrl-row">
      <button id="btn-start" class="pbtn pbtn-main">▶ Mulai</button>
      <button id="btn-pause" class="pbtn pbtn-ghost">⏸ Jeda</button>
      <button id="btn-reset" class="pbtn pbtn-ghost">↺ Reset</button>
    </div>
    <div class="mode-row">
      <button class="mbtn" onclick="resetPomodoro(25);document.getElementById('pomodoro-label').textContent='Fokus'">🍅 Fokus 25</button>
      <button id="btn-break" class="mbtn" onclick="resetPomodoro(5);document.getElementById('pomodoro-label').textContent='Istirahat'">☕ Istirahat 5</button>
      <button class="mbtn" onclick="resetPomodoro(15);document.getElementById('pomodoro-label').textContent='Istirahat Panjang'">🛋️ 15 Menit</button>
    </div>

    <div class="kinners-pomo">
      <svg width="80" height="80" viewBox="0 0 120 120" fill="none">
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
      <div class="kbubble">"Ayo fokus, Smeconer! Kinners ikut belajar bareng~ 📚"</div>
    </div>
  </div>
</div>
@endsection