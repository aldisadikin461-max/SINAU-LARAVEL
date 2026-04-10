<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Masuk — Sinau</title>
  
  <!-- Google Fonts: Plus Jakarta Sans & Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="{{ asset('css/sinau.css') }}">
  <style>
    body { background-color: var(--bg-app); margin: 0; min-height: 100vh; font-family: 'Inter', sans-serif; overflow-x: hidden; }
  </style>
</head>
<body>

  <!-- Background Particles -->
  <canvas id="sinau-particles"></canvas>

  <div class="auth-wrapper">
    <div class="auth-glass">
      <div class="auth-brand-logo">🐱</div>
      <h1>Selamat Datang!</h1>
      <p>Masuk ke akun Sinau-mu dan lanjut belajar 🚀</p>

      @if (session('status'))
        <div class="alert alert-success" style="margin-bottom:1.5rem;">✅ {{ session('status') }}</div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div style="margin-bottom: 1.25rem;">
          <label style="display:block; font-weight:700; color:var(--text); margin-bottom:0.5rem; font-size:0.9rem;">Email</label>
          <div style="position:relative; display:flex; align-items:center;">
            <span style="position:absolute; left:1rem; font-size:1.1rem;">✉️</span>
            {{-- honeypot --}}
            <input type="email" name="fake_email" style="display:none" tabindex="-1" aria-hidden="true">
            
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="email@smkn1pwt.sch.id" class="sinau-input" style="padding-left: 2.75rem; width:100%; border-radius:var(--radius-md);" required autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" data-lpignore="true" data-form-type="other" data-1p-ignore="true" x-autocompletetype="off">
          </div>
          @error('email')<p style="color:var(--danger); font-size:0.8rem; font-weight:700; margin-top:0.4rem;">{{ $message }}</p>@enderror
        </div>

        <div style="margin-bottom: 1.25rem;">
          <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.5rem;">
            <label style="font-weight:700; color:var(--text); font-size:0.9rem;">Password</label>
            @if (Route::has('password.request'))
              <a href="{{ route('password.request') }}" class="auth-link" style="font-size:0.85rem;">Lupa password?</a>
            @endif
          </div>
          <div style="position:relative; display:flex; align-items:center;">
            <span style="position:absolute; left:1rem; font-size:1.1rem;">🔒</span>
            {{-- honeypot --}}
            <input type="password" name="fake_password" style="display:none" tabindex="-1" aria-hidden="true">
            
            <input type="password" id="password" name="password" placeholder="Masukkan password" class="sinau-input" style="padding-left: 2.75rem; width:100%; border-radius:var(--radius-md);" required autocomplete="new-password" data-lpignore="true" data-form-type="other" data-1p-ignore="true">
            <button type="button" onclick="togglePw('password',this)" style="position:absolute; right:1rem; background:none; border:none; cursor:pointer; font-size:1.1rem; padding:0; opacity:0.6; transition:opacity 0.2s;" tabindex="-1">👁️</button>
          </div>
          @error('password')<p style="color:var(--danger); font-size:0.8rem; font-weight:700; margin-top:0.4rem;">{{ $message }}</p>@enderror
        </div>

        <div style="margin-bottom: 2rem; display:flex; align-items:center; gap:0.5rem;">
          <input type="checkbox" name="remember" id="remember" style="width:1.1rem; height:1.1rem; border-radius:4px; border:2px solid var(--border); cursor:pointer;">
          <label for="remember" style="font-size:0.9rem; font-weight:600; color:var(--muted); cursor:pointer;">Ingat saya</label>
        </div>

        <button type="submit" class="btn-primary" style="width:100%; justify-content:center; padding:1rem; font-size:1.05rem;">Masuk Sekarang 🚀</button>
      </form>

      <div class="auth-divider">atau</div>
      
      <p style="text-align:center; font-size:0.9rem; font-weight:600; color:var(--muted); margin:0;">
        Belum punya akun? <a href="{{ route('register') }}" class="auth-link">Daftar Gratis</a>
      </p>
    </div>
  </div>

  <script src="{{ asset('js/sinau-particles.js') }}"></script>
  <script>
    // Toggle Password visibility
    function togglePw(id, btn) {
      const i = document.getElementById(id);
      if (i.type === 'password') {
        i.type = 'text';
        btn.textContent = '🙈';
      } else {
        i.type = 'password';
        btn.textContent = '👁️';
      }
    }

    // Anti-autofill multi-layer
    (function() {
      const hasError = !!document.querySelector('[style*="color:var(--danger)"]');
      const oldEmail = "{{ old('email') }}";

      function clearFields() {
        const e = document.getElementById('email');
        const p = document.getElementById('password');
        if (e && !hasError && !oldEmail) e.value = '';
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

      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', lockThenUnlock);
      } else {
        lockThenUnlock();
      }
      setTimeout(clearFields, 500);
      setTimeout(clearFields, 1000);
    })();
  </script>
</body>
</html>
