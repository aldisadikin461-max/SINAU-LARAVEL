<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar — Sinau</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Nunito+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root{--blue:#1a8cff;--blue-dark:#0070e0;--blue-press:#005bb8;--blue-soft:#e6f2ff;--blue-mid:#bbd9ff;--orange:#ff9500;--orange-dark:#d47a00;--orange-soft:#fff3da;--green:#2ec96b;--green-dark:#1fa355;--green-soft:#d6f5e6;--purple:#7c4dff;--purple-soft:#ede8ff;--red:#ff4757;--red-soft:#ffe3e6;--yellow:#ffd100;--yellow-soft:#fffbe6;--bg:#f4f8ff;--white:#ffffff;--text:#0d1f35;--text-mid:#3d5a7a;--text-muted:#7b96b2;--border:#d0e4f7;--border-mid:#b0ccee;}
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
    body{font-family:'Nunito Sans',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;}
    .auth-layout{display:flex;min-height:100vh;}

    /* LEFT */
    .auth-left{flex:0 0 400px;background:linear-gradient(160deg,#e6f2ff 0%,#f0f7ff 60%,#e8f5ff 100%);border-right:2px solid var(--border);padding:36px 32px;display:flex;flex-direction:column;position:relative;overflow:hidden;}
    .auth-left::before{content:'';position:absolute;width:280px;height:280px;background:radial-gradient(circle,rgba(26,140,255,.08),transparent 70%);top:-70px;right:-70px;border-radius:50%;pointer-events:none;}

    .auth-brand{display:flex;align-items:center;gap:10px;font-family:'Nunito',sans-serif;font-weight:900;font-size:24px;color:var(--blue);text-decoration:none;margin-bottom:32px;position:relative;z-index:1;}
    .logo-box{width:40px;height:40px;background:var(--blue-soft);border-radius:12px;border:2px solid var(--blue-mid);display:flex;align-items:center;justify-content:center;font-size:22px;}

    .mascot-wrap{display:flex;flex-direction:column;align-items:center;gap:14px;margin-bottom:28px;position:relative;z-index:1;}
    .mascot{animation:mascotBob 3.5s ease-in-out infinite;cursor:pointer;}
    .mascot-body{width:110px;height:110px;background:linear-gradient(145deg,#5bc8ff,var(--blue));border-radius:50%;border:5px solid var(--white);box-shadow:0 8px 0 var(--blue-press),0 14px 28px rgba(26,140,255,.22);display:flex;align-items:center;justify-content:center;font-size:52px;line-height:1;position:relative;transition:transform .2s;}
    .mascot-body::before,.mascot-body::after{content:'';position:absolute;top:-14px;width:28px;height:28px;background:linear-gradient(145deg,#5bc8ff,var(--blue));clip-path:polygon(50% 0%,0% 100%,100% 100%);}
    .mascot-body::before{left:18px;}.mascot-body::after{right:18px;}

    .speech-bubble{background:var(--white);border:2px solid var(--blue-mid);border-radius:16px 16px 16px 4px;padding:10px 16px;font-family:'Nunito',sans-serif;font-weight:700;font-size:12px;color:var(--text-mid);box-shadow:0 4px 12px rgba(26,140,255,.1);text-align:center;max-width:240px;line-height:1.5;}

    .features-list{display:flex;flex-direction:column;gap:10px;margin-bottom:16px;position:relative;z-index:1;}
    .feat-item{display:flex;align-items:center;gap:10px;background:var(--white);border:2px solid var(--border);border-radius:14px;padding:10px 14px;transition:all .18s;}
    .feat-item:hover{border-color:var(--blue-mid);transform:translateX(4px);}
    .feat-icon{width:38px;height:38px;border-radius:10px;border:2px solid transparent;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;}
    .feat-name{font-family:'Nunito',sans-serif;font-weight:800;font-size:13px;color:var(--text);}
    .feat-desc{font-size:11px;color:var(--text-muted);}

    .float-card{position:absolute;background:var(--white);border-radius:14px;padding:10px 13px;box-shadow:0 4px 16px rgba(0,0,0,.08);display:flex;align-items:center;gap:8px;font-family:'Nunito',sans-serif;font-weight:800;font-size:12px;border:2px solid var(--border);z-index:2;}
    .float-card span{font-size:18px;}
    .fc-label{font-size:10px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.04em;}
    .fc-val{font-size:13px;font-weight:900;color:var(--text);}
    .fc-1{bottom:100px;right:-14px;color:var(--orange);background:var(--orange-soft);border-color:#ffd8a0;animation:floatBob 4s .3s ease-in-out infinite;}
    .fc-2{bottom:36px;left:-14px;color:var(--purple);background:var(--purple-soft);border-color:#c8b0ff;animation:floatBob 3.5s .8s ease-in-out infinite;}

    /* RIGHT */
    .auth-right{flex:1;display:flex;align-items:center;justify-content:center;padding:32px 28px;overflow-y:auto;}
    .auth-card{background:var(--white);border:2px solid var(--border);border-radius:28px;padding:40px 36px;width:100%;max-width:500px;box-shadow:0 6px 0 var(--border),0 16px 48px rgba(26,140,255,.08);animation:slideUp .5s ease both;}

    .auth-title{font-family:'Nunito',sans-serif;font-weight:900;font-size:28px;color:var(--text);letter-spacing:-.5px;margin-bottom:6px;}
    .auth-subtitle{font-size:14px;color:var(--text-mid);line-height:1.5;margin-bottom:28px;}

    .form-group{margin-bottom:16px;}
    .form-row{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;}
    @media(max-width:540px){.form-row{grid-template-columns:1fr;}}
    .form-label{display:block;font-family:'Nunito',sans-serif;font-weight:800;font-size:13px;color:var(--text);margin-bottom:5px;}

    .input-wrap{position:relative;display:flex;align-items:center;}
    .input-icon{position:absolute;left:13px;font-size:15px;pointer-events:none;z-index:1;}
    .sinau-input{width:100%;padding:12px 44px 12px 40px;background:var(--bg);border:2px solid var(--border);border-radius:13px;color:var(--text);font-family:'Nunito Sans',sans-serif;font-size:14px;font-weight:500;transition:all .18s;outline:none;}
    .sinau-input::placeholder{color:var(--text-muted);}
    .sinau-input:focus{border-color:var(--blue);background:var(--white);box-shadow:0 0 0 4px rgba(26,140,255,.1);}
    .sinau-input.is-error{border-color:var(--red);background:var(--red-soft);}
    .toggle-pw{position:absolute;right:12px;background:none;border:none;cursor:pointer;font-size:15px;padding:0;opacity:.6;transition:opacity .18s;}
    .toggle-pw:hover{opacity:1;}
    .error-msg{font-size:11px;font-weight:700;color:var(--red);margin-top:4px;padding-left:4px;font-family:'Nunito',sans-serif;}

    /* PW strength */
    .pw-strength{display:flex;align-items:center;gap:8px;margin-bottom:4px;}
    .pw-bars{display:flex;gap:3px;flex:1;}
    .pw-bar{flex:1;height:5px;border-radius:4px;background:#e2e8f0;transition:background .3s;}
    .pw-label{font-size:11px;font-weight:700;color:var(--text-muted);white-space:nowrap;min-width:100px;text-align:right;transition:color .3s;font-family:'Nunito',sans-serif;}

    .btn-submit{width:100%;padding:15px;background:var(--orange);border:none;border-radius:16px;color:#fff;font-family:'Nunito',sans-serif;font-weight:900;font-size:16px;cursor:pointer;transition:all .18s;box-shadow:0 6px 0 var(--orange-dark);display:flex;align-items:center;justify-content:center;gap:8px;margin-top:8px;margin-bottom:20px;}
    .btn-submit:hover{transform:translateY(-3px);box-shadow:0 9px 0 var(--orange-dark);}
    .btn-submit:active{transform:translateY(3px);box-shadow:0 2px 0 var(--orange-dark);}

    .divider{display:flex;align-items:center;gap:12px;color:var(--text-muted);font-size:13px;font-weight:700;margin-bottom:14px;}
    .divider::before,.divider::after{content:'';flex:1;height:2px;background:var(--border);border-radius:2px;}

    .footer-text{text-align:center;font-size:14px;font-weight:600;color:var(--text-mid);}
    .auth-link{font-family:'Nunito',sans-serif;font-weight:900;color:var(--blue);text-decoration:none;margin-left:4px;}
    .auth-link:hover{text-decoration:underline;}

    @keyframes slideUp{from{opacity:0;transform:translateY(24px);}to{opacity:1;transform:translateY(0);}}
    @keyframes floatBob{0%,100%{transform:translateY(0);}50%{transform:translateY(-10px);}}
    @keyframes mascotBob{0%,100%{transform:translateY(0);}50%{transform:translateY(-10px);}}

    @media(max-width:860px){
      .auth-layout{flex-direction:column;}
      .auth-left{flex:none;padding:24px 20px;border-right:none;border-bottom:2px solid var(--border);}
      .mascot-wrap{flex-direction:row;align-items:center;gap:16px;margin-bottom:16px;}
      .mascot-body{width:80px;height:80px;font-size:38px;}
      .mascot-body::before{width:20px;height:20px;top:-10px;left:10px;}
      .mascot-body::after{width:20px;height:20px;top:-10px;right:10px;}
      .features-list{display:none;}
      .fc-1,.fc-2{display:none;}
      .auth-right{padding:24px 16px;}
      .auth-card{padding:28px 20px;}
    }
  </style>
</head>
<body>
<div class="auth-layout">

  <!-- LEFT -->
  <div class="auth-left">
    <a href="/" class="auth-brand">
      <div class="logo-box">🐱</div>
      Sinau
    </a>
    <div class="mascot-wrap">
      <div class="mascot" id="mascot"><div class="mascot-body">😸</div></div>
      <div class="speech-bubble">Yay! Kinners senang kamu mau bergabung! 🎊</div>
    </div>
    <div class="features-list">
      <div class="feat-item">
        <div class="feat-icon" style="background:var(--blue-soft);border-color:var(--blue-mid);">📚</div>
        <div><div class="feat-name">E-Book Lengkap</div><div class="feat-desc">Akses semua materi kapan saja</div></div>
      </div>
      <div class="feat-item">
        <div class="feat-icon" style="background:var(--orange-soft);border-color:#ffd8a0;">🔥</div>
        <div><div class="feat-name">Streak Harian</div><div class="feat-desc">Bangun kebiasaan belajar konsisten</div></div>
      </div>
      <div class="feat-item">
        <div class="feat-icon" style="background:var(--yellow-soft);border-color:#ffe87a;">🏅</div>
        <div><div class="feat-name">Badge & Poin</div><div class="feat-desc">Raih penghargaan dari belajarmu</div></div>
      </div>
      <div class="feat-item">
        <div class="feat-icon" style="background:var(--purple-soft);border-color:#c8b0ff;">🎓</div>
        <div><div class="feat-name">Info Beasiswa</div><div class="feat-desc">Update beasiswa terkurasi</div></div>
      </div>
    </div>
    <div class="float-card fc-1">
      <span>⭐</span>
      <div><div class="fc-label">XP Pertama</div><div class="fc-val">+50 XP</div></div>
    </div>
    <div class="float-card fc-2">
      <span>🎁</span>
      <div><div class="fc-label">Bonus Daftar</div><div class="fc-val">Gratis!</div></div>
    </div>
  </div>

  <!-- RIGHT -->
  <div class="auth-right">
    <div class="auth-card">
      <h1 class="auth-title">Daftar Sekarang!</h1>
      <p class="auth-subtitle">Buat akun gratis dan mulai petualangan belajarmu 🎉</p>

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
          <label class="form-label" for="name">Nama Lengkap</label>
          <div class="input-wrap">
            <span class="input-icon">👤</span>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Nama kamu" class="sinau-input {{ $errors->has('name') ? 'is-error' : '' }}" required autofocus autocomplete="name">
          </div>
          @error('name')<p class="error-msg">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="email">Email</label>
          <div class="input-wrap">
            <span class="input-icon">✉️</span>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="email@smkn1pwt.sch.id" class="sinau-input {{ $errors->has('email') ? 'is-error' : '' }}" required autocomplete="username">
          </div>
          @error('email')<p class="error-msg">{{ $message }}</p>@enderror
        </div>

        <div class="form-row">
          <div class="form-group" style="margin-bottom:0">
            <label class="form-label" for="password">Password</label>
            <div class="input-wrap">
              <span class="input-icon">🔒</span>
              <input type="password" id="password" name="password" placeholder="Min. 8 karakter" class="sinau-input {{ $errors->has('password') ? 'is-error' : '' }}" required autocomplete="new-password">
              <button type="button" class="toggle-pw" onclick="togglePw('password',this)" tabindex="-1">👁️</button>
            </div>
            @error('password')<p class="error-msg">{{ $message }}</p>@enderror
          </div>
          <div class="form-group" style="margin-bottom:0">
            <label class="form-label" for="password_confirmation">Konfirmasi</label>
            <div class="input-wrap">
              <span class="input-icon">🔐</span>
              <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" class="sinau-input {{ $errors->has('password_confirmation') ? 'is-error' : '' }}" required autocomplete="new-password">
              <button type="button" class="toggle-pw" onclick="togglePw('password_confirmation',this)" tabindex="-1">👁️</button>
            </div>
            @error('password_confirmation')<p class="error-msg">{{ $message }}</p>@enderror
          </div>
        </div>

        <div class="pw-strength" style="margin-top:8px;">
          <div class="pw-bars">
            <div class="pw-bar" id="bar1"></div>
            <div class="pw-bar" id="bar2"></div>
            <div class="pw-bar" id="bar3"></div>
            <div class="pw-bar" id="bar4"></div>
          </div>
          <span class="pw-label" id="pwLabel">Masukkan password</span>
        </div>

        <button type="submit" class="btn-submit">Daftar Sekarang 🎉</button>
      </form>

      <div class="divider"><span>atau</span></div>
      <p class="footer-text">Sudah punya akun? <a href="{{ route('login') }}" class="auth-link">Masuk di sini</a></p>
    </div>
  </div>
</div>

<script>
  function togglePw(id,btn){const i=document.getElementById(id);i.type=i.type==='password'?'text':'password';btn.textContent=i.type==='password'?'👁️':'🙈';}

  const pw=document.getElementById('password');
  const bars=[document.getElementById('bar1'),document.getElementById('bar2'),document.getElementById('bar3'),document.getElementById('bar4')];
  const lbl=document.getElementById('pwLabel');
  const lvl=[{c:'#ff4757',t:'Terlalu lemah'},{c:'#ff9500',t:'Lumayan'},{c:'#ffd100',t:'Cukup kuat'},{c:'#2ec96b',t:'Kuat! 💪'}];
  function getStr(p){let s=0;if(p.length>=8)s++;if(/[A-Z]/.test(p))s++;if(/[0-9]/.test(p))s++;if(/[^A-Za-z0-9]/.test(p))s++;return s;}
  if(pw){pw.addEventListener('input',()=>{const v=pw.value,s=v.length?getStr(v):0;bars.forEach((b,i)=>{b.style.background=i<s?lvl[s-1].color:'#e2e8f0';});lbl.textContent=v.length?lvl[s-1]?.t||'Terlalu lemah':'Masukkan password';lbl.style.color=v.length?lvl[s-1]?.color||'#ff4757':'#7b96b2';});}

  const m=document.getElementById('mascot');
  if(m){m.addEventListener('click',()=>{const b=m.querySelector('.mascot-body');b.style.transition='transform .12s';b.style.transform='scale(1.15) rotate(-8deg)';setTimeout(()=>{b.style.transform='scale(1.15) rotate(8deg)';},130);setTimeout(()=>{b.style.transform='';},260);});}
</script>
</body>
</html>
