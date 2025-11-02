<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>{{ __('Restablecer contraseña') }}</title>

  <link rel="stylesheet" href="{{ asset('css/restablecerC.css') }}">
</head>
<body>
  <div class="auth-card" role="main" aria-labelledby="forgot-password-title">
    <div class="auth-card-logo" aria-hidden="true">
      <!-- SVG del usuario -->
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
           stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
           data-lucide="home" class="lucide lucide-home" aria-hidden="true">
        <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path>
        <path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
      </svg>
    </div>

    <h2 id="forgot-password-title">{{ __('¿Olvidaste tu contraseña?') }}</h2>
    <p>{{ __('¿Olvidaste tu contraseña? No hay problema. Indícanos tu dirección de correo electrónico y te enviaremos un enlace para restablecer la contraseña que te permitirá elegir una nueva.') }}</p>

    {{-- Status message (usa la directiva @session tal cual) --}}
    @session('status')
        <div class="status-message">
            {{ $value }}
        </div>
    @endsession

    {{-- Validation errors --}}
    @if ($errors->any())
      <div class="validation-errors" role="alert">
        <ul style="margin:0; padding-left: 1rem;">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="auth-form" novalidate>
      @csrf

      <div class="form-group">
        <label for="email">{{ __('Correo electrónico') }}</label>
        <input id="email"
               type="email"
               name="email"
               value="{{ old('email') }}"
               required
               autofocus
               autocomplete="username"
               aria-required="true"
               aria-label="{{ __('Correo electrónico') }}">
      </div>

      <div class="form-group" style="margin-top: 12px;">
        <button type="submit">
          {{ __('Enviar enlace') }}
        </button>
      </div>
    </form>

    <div class="auth-footer">
      {{-- Enlaces opcionales --}}
      {{-- <a href="{{ route('login') }}">{{ __('Volver al inicio de sesión') }}</a> --}}
    </div>
  </div>
</body>
</html>
