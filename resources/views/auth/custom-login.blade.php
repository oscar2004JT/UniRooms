<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Unirooms</title>

  {{-- CSS personalizado --}}
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">

  {{-- Iconos Lucide --}}
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
  <div class="login-container">
    <div class="login-card">
      <div class="login-header">
        <div class="login-logo">
          <i data-lucide="home"></i>
        </div>
        <h2>Bienvenido a Unirooms</h2>
        <p class="login-subtitle">
          Inicia sesión como <span id="user-role">Estudiante</span>
        </p>
      </div>

      <!-- Toggle de tipo de usuario -->
      <div class="login-toggle" role="tablist" aria-label="Tipo usuario">
        <button id="login-student-toggle" class="tabs-trigger active" data-role="student" aria-pressed="true">
          <i data-lucide="graduation-cap"></i>
          Estudiante
        </button>
        <button id="login-owner-toggle" class="tabs-trigger" data-role="owner" aria-pressed="false">
          <i data-lucide="key"></i>
          Propietario
        </button>
      </div>

      {{-- FORMULARIO ESTUDIANTE (usa Jetstream) --}}
      <form id="form-student" method="POST" action="{{ route('login') }}" class="login-form">
        @csrf

        {{-- Mensajes de error --}}
        @if ($errors->any())
          <div class="error-messages">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="form-group">
          <label for="student-email">Email</label>
          <input type="email" id="student-email" class="input" name="email"
                 value="{{ old('email') }}" placeholder="estudiante@email.com"
                 required autofocus autocomplete="username">
        </div>

        <div class="form-group">
          <label for="student-password">Contraseña</label>
          <input type="password" id="student-password" class="input" name="password"
                 placeholder="Tu contraseña" required autocomplete="current-password">
        </div>

        <div class="login-options">
          <label class="remember-me">
            <input type="checkbox" name="remember" id="student-remember">
            Recordarme
          </label>
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="forgot-link">¿Olvidaste tu contraseña?</a>
          @endif
        </div>

        <button type="submit" class="btn btn-primary login-btn">
          <i data-lucide="log-in"></i>
          <span>Iniciar Sesión</span>
        </button>

        <div class="register-text">
          <span>¿No tienes cuenta?</span>
          <a href="{{ route('register') }}" class="register-link">Regístrate aquí</a>
        </div>

        <div class="divider">
          <div class="divider-line"></div>
          <span class="divider-text">O continúa con</span>
          <div class="divider-line"></div>
        </div>

        <div class="social-login">
          <button type="button" class="btn btn-outline social-btn">
            <i data-lucide="chrome"></i> Google
          </button>
          <button type="button" class="btn btn-outline social-btn">
            <i data-lucide="facebook"></i> Facebook
          </button>
        </div>
      </form>

      {{-- FORMULARIO PROPIETARIO (futuro login alternativo) --}}
      <form id="form-owner" method="POST" action="{{ route('login') }}" class="login-form" style="display:none;">
        @csrf
        <div class="form-group">
          <label for="owner-email">Email</label>
          <input type="email" id="owner-email" class="input" name="email"
                 placeholder="propietario@email.com" required>
        </div>

        <div class="form-group">
          <label for="owner-password">Contraseña</label>
          <input type="password" id="owner-password" class="input" name="password"
                 placeholder="Tu contraseña" required>
        </div>

        <div class="login-options">
          <label class="remember-me">
            <input type="checkbox" name="remember" id="owner-remember">
            Recordarme
          </label>
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="forgot-link">¿Olvidaste tu contraseña?</a>
          @endif
        </div>

        <button type="submit" class="btn btn-primary login-btn">
          <i data-lucide="log-in"></i>
          <span>Iniciar Sesión</span>
        </button>

        <div class="register-text">
          <span>¿No tienes cuenta?</span>
          <a href="{{ route('register') }}" class="register-link">Regístrate aquí</a>
        </div>
      </form>

      <div class="back-home">
        <a href="{{ url('/') }}" class="btn btn-outline back-btn">
          <i data-lucide="arrow-left"></i>
          Volver al Inicio
        </a>
      </div>
    </div>
  </div>

  {{-- JS --}}
  <script>
    lucide.createIcons();

    const studentBtn = document.getElementById('login-student-toggle');
    const ownerBtn = document.getElementById('login-owner-toggle');
    const studentForm = document.getElementById('form-student');
    const ownerForm = document.getElementById('form-owner');
    const roleText = document.getElementById('user-role');

    studentBtn.addEventListener('click', () => {
      studentBtn.classList.add('active');
      ownerBtn.classList.remove('active');
      studentForm.style.display = 'block';
      ownerForm.style.display = 'none';
      roleText.textContent = 'Estudiante';
    });

    ownerBtn.addEventListener('click', () => {
      ownerBtn.classList.add('active');
      studentBtn.classList.remove('active');
      ownerForm.style.display = 'block';
      studentForm.style.display = 'none';
      roleText.textContent = 'Propietario';
    });
  </script>
</body>
</html>
