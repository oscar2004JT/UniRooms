<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registro - Unirooms</title>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
  <div class="login-container">
    <div class="login-card">
      <div class="login-header">
        <div class="login-logo">
          <i data-lucide="user-plus"></i>
        </div>
        <h2>Crea tu cuenta en Unirooms</h2>
        <p class="login-subtitle">Regístrate como <span id="user-role">Estudiante</span></p>
      </div>

      <div class="login-toggle" role="tablist" aria-label="Tipo usuario">
        <button id="register-student-toggle" class="tabs-trigger active" data-role="student" aria-pressed="true">
          <i data-lucide="graduation-cap"></i>
          Estudiante
        </button>
        <button id="register-owner-toggle" class="tabs-trigger" data-role="owner" aria-pressed="false">
          <i data-lucide="key"></i>
          Propietario
        </button>
      </div>

      {{-- FORMULARIO ESTUDIANTE --}}
      <form id="form-student" class="login-form" method="POST" action="{{ route('register') }}">
        @csrf
        <input type="hidden" name="role" value="estudiante"> {{-- CAMBIO: campo role --}}

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
          <label for="name">Nombre</label>
          <input type="text" name="name" id="name" class="input" placeholder="Tu nombre" value="{{ old('name') }}" required>
          @error('name')
            <span class="error-text">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="email">Correo Electrónico</label>
          <input type="email" name="email" id="email" class="input" placeholder="estudiante@email.com" value="{{ old('email') }}" required>
          @error('email')
            <span class="error-text">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="password">Contraseña</label>
          <input type="password" name="password" id="password" class="input" placeholder="Tu contraseña" required>
          @error('password')
            <span class="error-text">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="password_confirmation">Confirmar Contraseña</label>
          <input type="password" name="password_confirmation" id="password_confirmation" class="input" placeholder="Repite tu contraseña" required>
          @error('password_confirmation')
            <span class="error-text">{{ $message }}</span>
          @enderror
        </div>

        <button type="submit" class="btn btn-primary login-btn">
          <i data-lucide="user-check"></i>
          <span>Crear Cuenta</span>
        </button>

        <div class="register-text">
          <span>¿Ya tienes cuenta?</span>
          <a href="{{ route('login') }}" class="register-link">Inicia sesión aquí</a>
        </div>
      </form>

      {{-- FORMULARIO PROPIETARIO --}}
      <form id="form-owner" class="login-form" method="POST" action="{{ route('register') }}" style="display:none;">
        @csrf
        <input type="hidden" name="role" value="propietario"> {{-- CAMBIO: campo role --}}

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
          <label for="name_owner">Nombre</label>
          <input type="text" name="name" id="name_owner" class="input" placeholder="Tu nombre" value="{{ old('name') }}" required>
          @error('name')
            <span class="error-text">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="email_owner">Correo Electrónico</label>
          <input type="email" name="email" id="email_owner" class="input" placeholder="propietario@email.com" value="{{ old('email') }}" required>
          @error('email')
            <span class="error-text">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="password_owner">Contraseña</label>
          <input type="password" name="password" id="password_owner" class="input" placeholder="Tu contraseña" required>
          @error('password')
            <span class="error-text">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="password_confirmation_owner">Confirmar Contraseña</label>
          <input type="password" name="password_confirmation" id="password_confirmation_owner" class="input" placeholder="Repite tu contraseña" required>
          @error('password_confirmation')
            <span class="error-text">{{ $message }}</span>
          @enderror
        </div>

        <button type="submit" class="btn btn-primary login-btn">
          <i data-lucide="user-check"></i>
          <span>Crear Cuenta</span>
        </button>

        <div class="register-text">
          <span>¿Ya tienes cuenta?</span>
          <a href="{{ route('login') }}" class="register-link">Inicia sesión aquí</a>
        </div>
      </form>

      <div class="back-home">
        <button id="back-to-home" class="btn btn-outline back-btn" onclick="window.location.href='{{ url('/') }}'">
          <i data-lucide="arrow-left"></i>
          Volver al Inicio
        </button>
      </div>
    </div>
  </div>

  <script>
    lucide.createIcons();

    const studentBtn = document.getElementById('register-student-toggle');
    const ownerBtn = document.getElementById('register-owner-toggle');
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
