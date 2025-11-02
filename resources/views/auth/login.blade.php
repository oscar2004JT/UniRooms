<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Unirooms</title>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
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
          Inicia sesión como <span id="user-role">Usuario</span>
        </p>
      </div>

      <form class="login-form" method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Mostrar errores generales (credenciales inválidas, etc.) --}}
        @if ($errors->any())
          <div class="error-box">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="form-group">
          <label for="email">Correo Electrónico</label>
          <input 
            type="email" 
            id="email" 
            name="email" 
            class="input" 
            placeholder="usuario@email.com" 
            value="{{ old('email') }}" 
            required 
            autofocus
          >
          @error('email')
            <span class="error-text">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="password">Contraseña</label>
          <input 
            type="password" 
            id="password" 
            name="password" 
            class="input" 
            placeholder="Tu contraseña" 
            required
          >
          @error('password')
            <span class="error-text">{{ $message }}</span>
          @enderror
        </div>

        <div class="login-options">
          <label class="remember-me">
            <input type="checkbox" name="remember">
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
            <i data-lucide="chrome"></i>
            Google
          </button>
          <button type="button" class="btn btn-outline social-btn">
            <i data-lucide="facebook"></i>
            Facebook
          </button>
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

  <script>
    lucide.createIcons();
  </script>
</body>
</html>
