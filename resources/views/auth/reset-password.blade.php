<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restablecer Contraseña - Unirooms</title>
  <link rel="stylesheet" href="{{ asset('css/recuperar.css') }}">
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
  <div class="login-container">
    <div class="login-card">
      <div class="login-header">
        <i data-lucide="lock-reset" style="width:40px;height:40px;color:#4c6ef5;"></i>
         <div class="login-logo">
          <i data-lucide="home" style="width:40px;height:40px;color:#4c6ef5;"></i>
        </div>
        <h2>Restablecer contraseña</h2>
        <p class="login-subtitle">Introduce tu nueva contraseña para continuar</p>
      </div>

      @if ($errors->any())
        <div class="alert-errors">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="form-group">
          <label for="email">Correo electrónico</label>
          <input id="email" class="input" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus>
        </div>

        <div class="form-group">
          <label for="password">Nueva contraseña</label>
          <input id="password" class="input" type="password" name="password" required>
        </div>

        <div class="form-group">
          <label for="password_confirmation">Confirmar contraseña</label>
          <input id="password_confirmation" class="input" type="password" name="password_confirmation" required>
        </div>

        <div class="button-container">
          <button type="submit" class="btn btn-primary">
            <span>Restablecer Contraseña</span>
          </button>
        </div>

        <div class="extra-links">
          <a href="{{ route('login') }}">Volver al inicio de sesión</a>
        </div>
      </form>
    </div>
  </div>

  <script>lucide.createIcons();</script>
</body>
</html>
