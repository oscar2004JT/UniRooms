{{-- resources/views/detalle-reserva.blade.php --}}
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Detalle de reserva — UniRooms</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>

  <!-- CSS globales -->
  <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
  <link rel="stylesheet" href="{{ asset('css/components.css') }}">
  <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
  <link rel="stylesheet" href="{{ asset('css/globals2.css') }}">

  <style>
    :root{
      --primary: #234db7;
      --muted: #f3f6fb;
      --muted-foreground: #97a1b8;
      --foreground: #1f2937;
      --radius: 0.5rem;
    }

    body{
      background: #fbfdff;
      color: var(--foreground);
      font-family: Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial;
    }

    .card{
      background: #fff;
      border-radius: 12px;
      border: 1px solid #eef2f7;
      box-shadow: 0 1px 2px rgba(16,24,40,0.03);
    }
    .input, .select, textarea.input{
      width:100%;
      border:1px solid #e6edf7;
      border-radius:8px;
      padding:0.75rem 1rem;
      background:#fbfdff;
      font-size:0.95rem;
    }
    h1{ font-size:1.25rem; font-weight:600; }
    h3{ font-size:1rem; font-weight:600; }
    .btn{
      display:inline-flex;
      align-items:center;
      gap:0.5rem;
      padding:0.6rem 0.9rem;
      border-radius:10px;
      border:1px solid #e6edf7;
      background:white;
      cursor:pointer;
    }
    .btn-primary{ background:var(--primary); color:white; border-color:var(--primary); }
    .btn-outline{ background:white; color:var(--foreground); }
    .amenity-active{
      background: rgba(35,77,183,0.08);
      box-shadow: inset 0 0 0 1px rgba(35,77,183,0.06);
      border-radius:8px;
    }
    @media (max-width:640px){
      .max-w-800{ padding-left:1rem; padding-right:1rem }
    }
  </style>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
  {{-- ========================== --}}
  {{--        HEADER / NAV        --}}
  {{-- ========================== --}}
  <header class="bg-gradient-to-r from-blue-700 to-blue-500 text-white">
    <div class="max-w-7xl mx-auto px-4">
      <div class="flex items-center justify-between h-20">

        <!-- Logo -->
        <a href="{{ route('inicio') }}" class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-md bg-white/20 flex items-center justify-center">
            <i data-lucide="home" class="text-white"></i>
          </div>
          <span class="font-semibold text-xl">UniRooms</span>
        </a>

        <!-- NAVIGATION -->
        <nav class="flex items-center gap-3">
          @guest
            <a href="{{ route('login') }}"
               class="ml-4 inline-block bg-transparent border border-white/60 text-white font-medium rounded-md px-4 py-2 hover:bg-white/10 transition">
              Iniciar Sesión
            </a>

            <a href="{{ route('register') }}"
               class="ml-2 inline-block bg-transparent border border-white/60 text-white font-medium rounded-md px-4 py-2 hover:bg-white/10 transition">
              Registrarse
            </a>
          @else
            @php
              $rol = Auth::user()->id_rol ?? null;
            @endphp

            <div class="flex items-center gap-4 relative">
              <!-- Selector de rol -->
              <div class="inline-flex items-center bg-white/10 rounded-full p-1">
                <button class="px-4 py-2 rounded-full font-medium shadow-sm {{ $rol == 1 ? 'bg-white text-blue-700' : 'text-white/80' }}">
                  Estudiante
                </button>

                <button class="px-4 py-2 rounded-full font-medium shadow-sm {{ $rol == 2 ? 'bg-white text-blue-700' : 'text-white/80' }}">
                  Propietario
                </button>
              </div>

              <!-- Dropdown de usuario -->
              <div class="relative">
                <button id="userMenuBtn"
                        class="flex items-center gap-1 text-white font-medium hover:bg-white/10 px-4 py-2 rounded-md transition">
                  {{ Auth::user()->name }}
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                       viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 9l-7 7-7-7" />
                  </svg>
                </button>

                <div id="userDropdown"
                     class="hidden absolute right-0 mt-2 w-48 bg-white text-gray-700 rounded-md shadow-lg overflow-hidden z-50">
                  <div class="px-4 py-2 text-sm text-gray-500 border-b">Mi cuenta</div>
                  <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                    Perfil
                  </a>

                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100">
                      Cerrar Sesión
                    </button>
                  </form>
                </div>
              </div>
            </div>
          @endguest

          <!-- Botón móvil -->
          <button id="mobileMenuBtn" class="ml-2 md:hidden p-2 rounded-md hover:bg-white/10">
            <i data-lucide="menu"></i>
          </button>
        </nav>
      </div>
    </div>
  </header>

  {{-- ========================== --}}
  {{--     NAV SECUNDARIA PROP    --}}
  {{-- ========================== --}}
  <nav class="navigation w-full" style="display: block; overflow: visible; white-space: normal;">
    <div class="navigation-content flex flex-wrap gap-2">

      <a href="{{ route('inicio') }}" id="nav-home" class="nav-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
             viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             data-lucide="home" class="lucide lucide-home">
          <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path>
          <path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
        </svg>
        Inicio
      </a>

      <a href="{{ route('propietario.habitaciones') }}" id="nav-mishabitaciones" class="nav-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
             viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             data-lucide="building-2" class="lucide lucide-building-2">
          <path d="M3 21h18"></path>
          <path d="M4 21V8a1 1 0 0 1 1-1h5"></path>
          <path d="M15 3h5a1 1 0 0 1 1 1v17"></path>
          <path d="M9 21V5a1 1 0 0 1 1-1h4"></path>
        </svg>
        Mis habitaciones
      </a>

      <a href="{{ route('addroom') }}" id="nav-addroom" class="nav-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
             viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             data-lucide="plus-circle" class="lucide lucide-plus-circle">
          <circle cx="12" cy="12" r="10"></circle>
          <path d="M8 12h8"></path>
          <path d="M12 8v8"></path>
        </svg>
        Agregar Habitación
      </a>

      {{-- Marcamos "Solicitudes de reservas" como activo para esta vista --}}
      <a href="{{ route('propietario.solicitudes') }}" id="nav-solicitudes" class="nav-link active">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
             viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             data-lucide="clipboard-list" class="lucide lucide-clipboard-list">
          <rect width="8" height="4" x="8" y="2" rx="1"></rect>
          <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
          <path d="M12 11h4"></path>
          <path d="M12 16h4"></path>
          <path d="M8 11h.01"></path>
          <path d="M8 16h.01"></path>
        </svg>
        Solicitudes de reservas
      </a>

      <a href="#" id="nav-reservadas" class="nav-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
             viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             data-lucide="calendar-check" class="lucide lucide-calendar-check">
          <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
          <path d="M16 2v4"></path>
          <path d="M8 2v4"></path>
          <path d="m9 14 2 2 4-4"></path>
        </svg>
        Habitaciones reservadas
      </a>

      <a href="" id="nav-messages" class="nav-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
             viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             data-lucide="message-circle" class="lucide lucide-message-circle">
          <path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"></path>
        </svg>
        Mensajes
      </a>
    </div>
  </nav>

  {{-- ========================== --}}
  {{--        CONTENIDO MAIN      --}}
  {{-- ========================== --}}
  <main class="flex-1">
    <div class="py-10">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg overflow-hidden">

          {{-- Cabecera con avatar redondo --}}
          <div class="px-6 py-6 border-b border-gray-200 flex flex-col items-center text-center bg-gray-50">
            <div class="w-24 h-24 rounded-full bg-blue-700 text-white flex items-center justify-center text-3xl font-bold shadow-md">
              {{ strtoupper(mb_substr($estudiante->name ?? 'E', 0, 1, 'UTF-8')) }}
            </div>

            <h1 class="mt-4 text-2xl font-semibold text-gray-900">
              {{ ($estudiante->name ?? '') . ' ' . ($estudiante->apellido ?? '') }}
            </h1>

            <p class="mt-1 text-sm text-gray-500">
              {{ __('Estudiante que realizó la reserva') }}
            </p>

            @if (!empty($pension?->nombre))
              <p class="mt-2 text-sm text-gray-600">
                Habitación: <span class="font-semibold">{{ $pension->nombre }}</span>
              </p>
            @endif
          </div>

          {{-- Contenido principal --}}
          <div class="px-6 py-6 space-y-8">

            {{-- ================= DATOS DEL ESTUDIANTE ================= --}}
            <div>
              <h3 class="text-lg font-semibold text-gray-800 mb-4">
                Datos del estudiante
              </h3>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                {{-- Nombre --}}
                <div>
                  <span class="text-gray-700 text-sm font-medium">{{ __('Nombre') }}</span>
                  <p class="mt-1 text-gray-900 border border-gray-200 rounded-md px-3 py-2 bg-gray-50">
                    {{ $estudiante->name ?? 'No especificado' }}
                  </p>
                </div>

                {{-- Apellidos --}}
                <div>
                  <span class="text-gray-700 text-sm font-medium">{{ __('Apellidos') }}</span>
                  <p class="mt-1 text-gray-900 border border-gray-200 rounded-md px-3 py-2 bg-gray-50">
                    {{ $estudiante->apellido ?? 'No especificado' }}
                  </p>
                </div>

                {{-- Tipo de Documento --}}
                <div>
                  <span class="text-gray-700 text-sm font-medium">{{ __('Tipo de Documento') }}</span>
                  <p class="mt-1 text-gray-900 border border-gray-200 rounded-md px-3 py-2 bg-gray-50">
                    @php
                      $tipos = [
                          'CC' => 'Cédula de Ciudadanía',
                          'TI' => 'Tarjeta de Identidad',
                          'CE' => 'Cédula de Extranjería',
                          'PA' => 'Pasaporte',
                          'RC' => 'Registro Civil',
                      ];
                      $codigo = $estudiante->tipo_documento ?? '';
                    @endphp
                    {{ $codigo ? ($tipos[$codigo] ?? $codigo) : 'No especificado' }}
                  </p>
                </div>

                {{-- Documento --}}
                <div>
                  <span class="text-gray-700 text-sm font-medium">{{ __('Documento') }}</span>
                  <p class="mt-1 text-gray-900 border border-gray-200 rounded-md px-3 py-2 bg-gray-50">
                    {{ $estudiante->documento ?? 'No especificado' }}
                  </p>
                </div>

                {{-- Sexo --}}
                <div>
                  <span class="text-gray-700 text-sm font-medium">{{ __('Sexo') }}</span>
                  <p class="mt-1 text-gray-900 border border-gray-200 rounded-md px-3 py-2 bg-gray-50">
                    @php
                      $sexos = [
                          'M' => 'Masculino',
                          'F' => 'Femenino',
                          'O' => 'Otro',
                      ];
                      $sx = $estudiante->sexo ?? '';
                    @endphp
                    {{ $sx ? ($sexos[$sx] ?? $sx) : 'No especificado' }}
                  </p>
                </div>

                {{-- Teléfono --}}
                <div>
                  <span class="text-gray-700 text-sm font-medium">{{ __('Teléfono') }}</span>
                  <p class="mt-1 text-gray-900 border border-gray-200 rounded-md px-3 py-2 bg-gray-50">
                    {{ $estudiante->telefono ?? 'No registrado' }}
                  </p>
                </div>

                {{-- Correo Electrónico --}}
                <div class="sm:col-span-2">
                  <span class="text-gray-700 text-sm font-medium">{{ __('Correo Electrónico') }}</span>
                  <p class="mt-1 text-gray-900 border border-gray-200 rounded-md px-3 py-2 bg-gray-50 break-all">
                    {{ $estudiante->email ?? 'No especificado' }}
                  </p>
                </div>

                {{-- Fecha de nacimiento (opcional) --}}
                @if (!empty($estudiante->fecha_nacimiento))
                  <div>
                    <span class="text-gray-700 text-sm font-medium">{{ __('Fecha de Nacimiento') }}</span>
                    <p class="mt-1 text-gray-900 border border-gray-200 rounded-md px-3 py-2 bg-gray-50">
                      {{ \Carbon\Carbon::parse($estudiante->fecha_nacimiento)->format('d/m/Y') }}
                    </p>
                  </div>
                @endif

              </div>
            </div>

            {{-- ================= DETALLES DE LA RESERVA ================= --}}
            <div class="border-t border-gray-200 pt-6">
              <h3 class="text-lg font-semibold text-gray-800 mb-4">
                Detalles de la reserva
              </h3>

              @php
                $estadoNombre = strtolower($arriendo->estado->nombre ?? 'rechazado');

                if ($estadoNombre === 'aceptado') {
                    $estadoTexto = 'Aceptado';
                    $estadoColor = 'bg-green-100 text-green-800 border border-green-200';
                    $puntoColor  = 'bg-green-500';
                } else {
                    $estadoTexto = 'Rechazado';
                    $estadoColor = 'bg-red-100 text-red-800 border border-red-200';
                    $puntoColor  = 'bg-red-500';
                }
              @endphp

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                {{-- Habitación --}}
                <div>
                  <span class="text-gray-700 text-sm font-medium">{{ __('Habitación / Pensión') }}</span>
                  <p class="mt-1 text-gray-900 border border-gray-200 rounded-md px-3 py-2 bg-gray-50">
                    {{ $pension->nombre ?? 'No especificado' }}
                  </p>
                </div>

                {{-- Estado --}}
                <div>
                  <span class="text-gray-700 text-sm font-medium">{{ __('Estado de la reserva') }}</span>
                  <div class="mt-1 inline-flex items-center gap-2 px-3 py-2 rounded-full text-xs font-semibold {{ $estadoColor }}">
                    <span class="w-2 h-2 rounded-full {{ $puntoColor }}"></span>
                    {{ $estadoTexto }}
                  </div>
                </div>

                {{-- Fecha inicio --}}
                <div>
                  <span class="text-gray-700 text-sm font-medium">{{ __('Fecha de inicio') }}</span>
                  <p class="mt-1 text-gray-900 border border-gray-200 rounded-md px-3 py-2 bg-gray-50">
                    {{ $arriendo->fecha_inicio ? \Carbon\Carbon::parse($arriendo->fecha_inicio)->format('d/m/Y') : 'No especificada' }}
                  </p>
                </div>

                {{-- Fecha fin --}}
                <div>
                  <span class="text-gray-700 text-sm font-medium">{{ __('Fecha de fin') }}</span>
                  <p class="mt-1 text-gray-900 border border-gray-200 rounded-md px-3 py-2 bg-gray-50">
                    @if($arriendo->fecha_fin)
                      {{ \Carbon\Carbon::parse($arriendo->fecha_fin)->format('d/m/Y') }}
                    @else
                      En curso / sin definir
                    @endif
                  </p>
                </div>

                {{-- Fecha de creación de la solicitud --}}
                <div>
                  <span class="text-gray-700 text-sm font-medium">{{ __('Fecha de creación de la solicitud') }}</span>
                  <p class="mt-1 text-gray-900 border border-gray-200 rounded-md px-3 py-2 bg-gray-50">
                    {{ $arriendo->created_at ? $arriendo->created_at->format('d/m/Y H:i') : 'No registrada' }}
                  </p>
                </div>

                {{-- Mensaje del estudiante --}}
                <div class="sm:col-span-2">
                  <span class="text-gray-700 text-sm font-medium">{{ __('Mensaje del estudiante') }}</span>
                  <div class="mt-1 border border-gray-200 rounded-md px-3 py-3 bg-gray-50 text-gray-900 text-sm min-h-[60px]">
                    {{ $arriendo->mensaje ? $arriendo->mensaje : 'Sin mensaje adicional.' }}
                  </div>
                </div>

              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </main>

  {{-- ========================== --}}
  {{--          FOOTER            --}}
  {{-- ========================== --}}
  <footer class="bg-gray-900 text-gray-200 mt-auto">
    <div class="max-w-7xl mx-auto px-6 py-16">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

        <div>
          <h3 class="text-white font-semibold mb-3">UniRooms</h3>
          <p class="text-gray-400 leading-relaxed">
            La plataforma líder para encontrar alojamiento universitario.
            Conectamos estudiantes con propietarios de confianza en las mejores zonas de la ciudad.
          </p>
        </div>

        <div>
          <h4 class="text-white font-semibold mb-3">Zonas Disponibles</h4>
          <ul class="space-y-2 text-gray-400">
            @foreach($zonas as $zona)
              <li>{{ $zona->nombre }}</li>
            @endforeach
          </ul>
        </div>

        <div>
          <h4 class="text-white font-semibold mb-3">Servicios</h4>
          <ul class="space-y-2 text-gray-400">
            <li>Buscar Habitaciones</li>
            <li>Publicar Habitación</li>
            <li>Verificación de Propiedades</li>
            <li>Soporte 24/7</li>
            <li>Guía del Estudiante</li>
          </ul>
        </div>

        <div>
          <h4 class="text-white font-semibold mb-3">Contacto</h4>
          <div class="text-gray-400 space-y-3">
            <div class="flex items-center gap-3">
              <i data-lucide="phone" class="text-gray-300"></i>
              <span>+57 (300) 123-4567</span>
            </div>

            <div class="flex items-center gap-3">
              <i data-lucide="mail" class="text-gray-300"></i>
              <span>info@roomfinder.co</span>
            </div>

            <div class="flex items-center gap-3">
              <i data-lucide="map-pin" class="text-gray-300"></i>
              <span>Medellín, Colombia</span>
            </div>

            <div class="flex items-center gap-3 mt-2">
              <a href="#" class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-white/10 hover:bg-white/20">
                <i data-lucide="facebook" class="text-white"></i>
              </a>
              <a href="#" class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-white/10 hover:bg-white/20">
                <i data-lucide="twitter" class="text-white"></i>
              </a>
              <a href="#" class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-white/10 hover:bg-white/20">
                <i data-lucide="instagram" class="text-white"></i>
              </a>
              <a href="#" class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-white/10 hover:bg-white/20">
                <i data-lucide="message-circle" class="text-white"></i>
              </a>
            </div>

          </div>
        </div>

      </div>
    </div>

    <div class="border-t border-gray-800">
      <div class="max-w-7xl mx-auto px-6 py-4 text-center text-gray-500 text-sm">
        © 2024 UniRooms. Todos los derechos reservados. | Términos de Servicio | Política de Privacidad
      </div>
    </div>
  </footer>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      lucide.createIcons();

      // Dropdown usuario
      const userMenuBtn = document.getElementById('userMenuBtn');
      const dropdown = document.getElementById('userDropdown');

      if (userMenuBtn && dropdown) {
        userMenuBtn.addEventListener('click', () => {
          dropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', (e) => {
          if (!userMenuBtn.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
          }
        });
      }

      // Menú móvil: ocultar/mostrar nav secundaria
      const mobileMenuBtn = document.getElementById('mobileMenuBtn');
      const navSecondary = document.querySelector('.navigation');

      if (mobileMenuBtn && navSecondary) {
        mobileMenuBtn.addEventListener('click', () => {
          navSecondary.classList.toggle('hidden');
        });
      }
    });
  </script>
</body>
</html>
