<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Masuk — Sinau</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Nunito+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root{--blue:#1a8cff;--blue-dark:#0070e0;--blue-press:#005bb8;--blue-soft:#e6f2ff;--blue-mid:#bbd9ff;--orange:#ff9500;--orange-soft:#fff3da;--green:#2ec96b;--green-soft:#d6f5e6;--purple:#7c4dff;--purple-soft:#ede8ff;--red:#ff4757;--red-soft:#ffe3e6;--bg:#f4f8ff;--white:#ffffff;--text:#0d1f35;--text-mid:#3d5a7a;--text-muted:#7b96b2;--border:#d0e4f7;--border-mid:#b0ccee;}
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
    body{font-family:'Nunito Sans',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;}
    .auth-layout{display:flex;min-height:100vh;}

    /* LEFT */
    .auth-left{flex:0 0 420px;background:linear-gradient(160deg,#e6f2ff 0%,#f0f7ff 60%,#e8f5ff 100%);border-right:2px solid var(--border);padding:40px 36px;display:flex;flex-direction:column;position:relative;overflow:hidden;}
    .auth-left::before{content:'';position:absolute;width:300px;height:300px;background:radial-gradient(circle,rgba(26,140,255,.08),transparent 70%);top:-80px;right:-80px;border-radius:50%;pointer-events:none;}
    .auth-left::after{content:'';position:absolute;width:220px;height:220px;background:radial-gradient(circle,rgba(26,140,255,.06),transparent 70%);bottom:40px;left:-60px;border-radius:50%;pointer-events:none;}

    .auth-brand{display:flex;align-items:center;gap:10px;font-family:'Nunito',sans-serif;font-weight:900;font-size:24px;color:var(--blue);text-decoration:none;margin-bottom:40px;position:relative;z-index:1;}
    .logo-box{width:40px;height:40px;background:var(--blue-soft);border-radius:12px;border:2px solid var(--blue-mid);display:flex;align-items:center;justify-content:center;font-size:22px;}

    .mascot-wrap{display:flex;flex-direction:column;align-items:center;gap:16px;margin-bottom:36px;position:relative;z-index:1;}
    .mascot{animation:mascotBob 3.5s ease-in-out infinite;cursor:pointer;}
    .mascot-body{width:130px;height:130px;background:linear-gradient(145deg,#5bc8ff,var(--blue));border-radius:50%;border:5px solid var(--white);box-shadow:0 8px 0 var(--blue-press),0 16px 32px rgba(26,140,255,.22);display:flex;align-items:center;justify-content:center;font-size:62px;line-height:1;position:relative;transition:transform .2s;}
    .mascot-body::before,.mascot-body::after{content:'';position:absolute;top:-16px;width:32px;height:32px;background:linear-gradient(145deg,#5bc8ff,var(--blue));clip-path:polygon(50% 0%,0% 100%,100% 100%);}
    .mascot-body::before{left:20px;}.mascot-body::after{right:20px;}

    .speech-bubble{background:var(--white);border:2px solid var(--blue-mid);border-radius:16px 16px 16px 4px;padding:10px 18px;font-family:'Nunito',sans-serif;font-weight:700;font-size:13px;color:var(--text-mid);box-shadow:0 4px 12px rgba(26,140,255,.1);text-align:center;max-width:260px;line-height:1.5;}

    .stats-strip{display:flex;background:var(--white);border:2px solid var(--border);border-radius:18px;overflow:hidden;box-shadow:0 3px 0 var(--border);margin-bottom:24px;position:relative;z-index:1;}
    .stat-item{flex:1;padding:16px 12px;text-align:center;border-right:2px solid var(--border);}
    .stat-item:last-child{border-right:none;}
    .stat-num{display:block;font-family:'Nunito',sans-serif;font-size:22px;font-weight:900;color:var(--blue);line-height:1;}
    .stat-label{display:block;font-size:11px;font-weight:700;color:var(--text-muted);margin-top:4px;text-transform:uppercase;letter-spacing:.05em;}

    .float-card{position:absolute;background:var(--white);border-radius:14px;padding:10px 14px;box-shadow:0 4px 16px rgba(0,0,0,.08);display:flex;align-items:center;gap:8px;font-family:'Nunito',sans-serif;font-weight:800;font-size:13px;border:2px solid var(--border);z-index:2;}
    .float-card span{font-size:20px;}
    .fc-label{font-size:10px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.04em;}
    .fc-val{font-size:14px;font-weight:900;color:var(--text);}
    .fc-1{bottom:120px;right:-16px;color:var(--orange);background:var(--orange-soft);border-color:#ffd8a0;animation:floatBob 4s .3s ease-in-out infinite;}
    .fc-2{bottom:48px;left:-16px;color:var(--purple);background:var(--purple-soft);border-color:#c8b0ff;animation:floatBob 3.5s .8s ease-in-out infinite;}

    /* RIGHT */
    .auth-right{flex:1;display:flex;align-items:center;justify-content:center;padding:40px 32px;}
    .auth-card{background:var(--white);border:2px solid var(--border);border-radius:28px;padding:44px 40px;width:100%;max-width:460px;box-shadow:0 6px 0 var(--border),0 16px 48px rgba(26,140,255,.08);animation:slideUp .5s ease both;}

    .auth-title{font-family:'Nunito',sans-serif;font-weight:900;font-size:30px;color:var(--text);letter-spacing:-.5px;margin-bottom:8px;}
    .auth-subtitle{font-size:15px;color:var(--text-mid);line-height:1.5;margin-bottom:32px;}

    .alert-success{padding:12px 16px;border-radius:12px;font-size:14px;font-weight:600;background:var(--green-soft);border:2px solid #a0e8c4;color:#1fa355;margin-bottom:20px;font-family:'Nunito',sans-serif;}

    .form-group{margin-bottom:20px;}
    .form-label{display:block;font-family:'Nunito',sans-serif;font-weight:800;font-size:14px;color:var(--text);margin-bottom:6px;}
    .label-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;}
    .forgot-link{font-family:'Nunito',sans-serif;font-size:13px;font-weight:700;color:var(--blue);text-decoration:none;}
    .forgot-link:hover{text-decoration:underline;}

    .input-wrap{position:relative;display:flex;align-items:center;}
    .input-icon{position:absolute;left:14px;font-size:16px;pointer-events:none;z-index:1;}
    .sinau-input{width:100%;padding:13px 46px 13px 44px;background:var(--bg);border:2px solid var(--border);border-radius:14px;color:var(--text);font-family:'Nunito Sans',sans-serif;font-size:15px;font-weight:500;transition:all .18s;outline:none;}
    .sinau-input::placeholder{color:var(--text-muted);}
    .sinau-input:focus{border-color:var(--blue);background:var(--white);box-shadow:0 0 0 4px rgba(26,140,255,.1);}
    .sinau-input.is-error{border-color:var(--red);background:var(--red-soft);}
    .toggle-pw{position:absolute;right:14px;background:none;border:none;cursor:pointer;font-size:16px;padding:0;opacity:.6;transition:opacity .18s;}
    .toggle-pw:hover{opacity:1;}
    .error-msg{font-size:12px;font-weight:700;color:var(--red);margin-top:5px;padding-left:4px;font-family:'Nunito',sans-serif;}

    .remember-row{margin-bottom:20px;}
    .checkbox-label{display:flex;align-items:center;gap:10px;font-family:'Nunito',sans-serif;font-weight:700;font-size:14px;color:var(--text-mid);cursor:pointer;}
    .real-checkbox{display:none;}
    .checkbox-custom{width:22px;height:22px;border:2px solid var(--border-mid);border-radius:7px;background:var(--bg);display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:all .18s;}
    .real-checkbox:checked+.checkbox-custom{background:var(--blue);border-color:var(--blue);}
    .real-checkbox:checked+.checkbox-custom::after{content:'✓';color:#fff;font-weight:900;}

    .btn-submit{width:100%;padding:16px;background:var(--blue);border:none;border-radius:16px;color:#fff;font-family:'Nunito',sans-serif;font-weight:900;font-size:17px;cursor:pointer;transition:all .18s;box-shadow:0 6px 0 var(--blue-press);display:flex;align-items:center;justify-content:center;gap:8px;margin-bottom:20px;}
    .btn-submit:hover{transform:translateY(-3px);box-shadow:0 9px 0 var(--blue-press);}
    .btn-submit:active{transform:translateY(3px);box-shadow:0 2px 0 var(--blue-press);}

    .divider{display:flex;align-items:center;gap:12px;color:var(--text-muted);font-size:13px;font-weight:700;margin-bottom:16px;}
    .divider::before,.divider::after{content:'';flex:1;height:2px;background:var(--border);border-radius:2px;}

    .footer-text{text-align:center;font-size:15px;font-weight:600;color:var(--text-mid);}
    .auth-link{font-family:'Nunito',sans-serif;font-weight:900;color:var(--blue);text-decoration:none;margin-left:4px;}
    .auth-link:hover{text-decoration:underline;}

    @keyframes slideUp{from{opacity:0;transform:translateY(24px);}to{opacity:1;transform:translateY(0);}}
    @keyframes floatBob{0%,100%{transform:translateY(0);}50%{transform:translateY(-10px);}}
    @keyframes mascotBob{0%,100%{transform:translateY(0);}50%{transform:translateY(-10px);}}

    @media(max-width:860px){
      .auth-layout{flex-direction:column;}
      .auth-left{flex:none;padding:28px 24px;border-right:none;border-bottom:2px solid var(--border);}
      .mascot-wrap{flex-direction:row;align-items:center;gap:20px;margin-bottom:20px;}
      .mascot-body{width:90px;height:90px;font-size:44px;}
      .mascot-body::before{width:22px;height:22px;top:-11px;left:12px;}
      .mascot-body::after{width:22px;height:22px;top:-11px;right:12px;}
      .fc-1,.fc-2{display:none;}
      .auth-right{padding:28px 20px;}
      .auth-card{padding:32px 24px;}
    }
    @media(max-width:480px){.auth-title{font-size:24px;}.stats-strip{display:none;}}

    /* ── Blokir highlight kuning autofill Chrome ── */
    @keyframes onAutoFillStart { from {} to {} }
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:active {
      -webkit-animation-name: onAutoFillStart;
      animation-name: onAutoFillStart;
      -webkit-box-shadow: 0 0 0 1000px #f4f8ff inset !important;
      box-shadow: 0 0 0 1000px #f4f8ff inset !important;
      -webkit-text-fill-color: #0d1f35 !important;
      caret-color: #0d1f35;
      transition: background-color 99999s ease-in-out 0s;
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
      <div class="mascot" id="mascot"><div class="mascot-body">😺</div></div>
      <div class="speech-bubble">Halo! Ayo lanjut belajar bareng Kinners! 🎉</div>
    </div>
    <div class="stats-strip">
      <div class="stat-item"><span class="stat-num">20+</span><span class="stat-label">Siswa Aktif</span></div>
      <div class="stat-item"><span class="stat-num">10+</span><span class="stat-label">E-Book</span></div>
      <div class="stat-item"><span class="stat-num">22+</span><span class="stat-label">Soal</span></div>
    </div>
    <div class="float-card fc-1">
      <span>🔥</span>
      <div><div class="fc-label">Streak Aktif</div><div class="fc-val">14 Hari</div></div>
    </div>
    <div class="float-card fc-2">
      <span>🏅</span>
      <div><div class="fc-label">Badge Terbaru</div><div class="fc-val">Super Learner</div></div>
    </div>
  </div>

  <!-- RIGHT -->
  <div class="auth-right">
    <div class="auth-card">
      <h1 class="auth-title">Selamat Datang!</h1>
      <p class="auth-subtitle">Masuk ke akun Sinau-mu dan lanjut belajar 🚀</p>

      @if (session('status'))
        <div class="alert-success">{{ session('status') }}</div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
          <label class="form-label" for="email">Email</label>
          <div class="input-wrap">
            <span class="input-icon">✉️</span>
            {{-- honeypot: browser isi ini, bukan yang asli --}}
            <input type="email" name="fake_email" style="display:none" tabindex="-1" aria-hidden="true">
            <input type="email" id="email" name="email"
              value="{{ old('email') }}"
              placeholder="email@smkn1pwt.sch.id"
              class="sinau-input {{ $errors->has('email') ? 'is-error' : '' }}"
              required autofocus
              autocomplete="off"
              autocorrect="off"
              autocapitalize="off"
              spellcheck="false"
              data-lpignore="true"
              data-form-type="other"
              data-1p-ignore="true"
              x-autocompletetype="off"
            >
          </div>
          @error('email')<p class="error-msg">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
          <div class="label-row">
            <label class="form-label" for="password" style="margin-bottom:0">Password</label>
            @if (Route::has('password.request'))
              <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
            @endif
          </div>
          <div class="input-wrap">
            <span class="input-icon">🔒</span>
            {{-- honeypot password --}}
            <input type="password" name="fake_password" style="display:none" tabindex="-1" aria-hidden="true">
            <input type="text" id="password" name="password"
              placeholder="Masukkan password"
              class="sinau-input {{ $errors->has('password') ? 'is-error' : '' }}"
              required
              autocomplete="off"
              data-lpignore="true"
              data-form-type="other"
              data-1p-ignore="true"
              style="font-family:monospace;-webkit-text-security:disc;"
            >
            <button type="button" class="toggle-pw" onclick="togglePw('password',this)" tabindex="-1">👁️</button>
          </div>
          @error('password')<p class="error-msg">{{ $message }}</p>@enderror
        </div>
        <div class="remember-row">
          <label class="checkbox-label">
            <input type="checkbox" name="remember" id="remember" class="real-checkbox">
            <span class="checkbox-custom"></span>
            Ingat saya
          </label>
        </div>
        <button type="submit" class="btn-submit">Masuk Sekarang 🐱</button>
      </form>

      <div class="divider"><span>atau</span></div>
      <p class="footer-text">Belum punya akun? <a href="{{ route('register') }}" class="auth-link">Daftar Gratis</a></p>
    </div>
  </div>
</div>

<script>
  // ── Anti-autofill multi-layer ──────────────────
  (function() {
    const hasError = !!document.querySelector('.is-error');
    const oldEmail = "{{ old('email') }}";

    function clearFields() {
      const e = document.getElementById('email');
      const p = document.getElementById('password');

      // Email: kosongkan kalau bukan dari old() Laravel
      if (e && !hasError && !oldEmail) e.value = '';

      // Password: selalu kosong di fresh load
      if (p && !hasError) p.value = '';
    }

    function lockThenUnlock() {
      const e = document.getElementById('email');
      const p = document.getElementById('password');
      [e, p].forEach(el => {
        if (!el) return;
        el.setAttribute('readonly', 'readonly');
        el.setAttribute('autocomplete', 'off');
      });
      setTimeout(() => {
        [e, p].forEach(el => { if (el) el.removeAttribute('readonly'); });
        clearFields();
      }, 100);
    }

    // Jalankan saat DOM ready
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', lockThenUnlock);
    } else {
      lockThenUnlock();
    }

    // Jalankan lagi setelah 500ms (Chrome kadang autofill telat)
    setTimeout(clearFields, 500);

    // Jalankan lagi setelah 1000ms (Firefox lebih telat)
    setTimeout(clearFields, 1000);

    // Block autofill event dari browser
    document.addEventListener('animationstart', (e) => {
      if (e.animationName === 'onAutoFillStart') {
        const el = e.target;
        if (!hasError && !oldEmail) el.value = '';
      }
    }, true);
  })();

  function togglePw(id,btn){const i=document.getElementById(id);i.type=i.type==='password'?'text':'password';btn.textContent=i.type==='password'?'👁️':'🙈';}
  const m=document.getElementById('mascot');
  if(m){m.addEventListener('click',()=>{const b=m.querySelector('.mascot-body');b.style.transition='transform .12s';b.style.transform='scale(1.15) rotate(-8deg)';setTimeout(()=>{b.style.transform='scale(1.15) rotate(8deg)';},130);setTimeout(()=>{b.style.transform='';},260);});}
</script>
</body>
</html>
