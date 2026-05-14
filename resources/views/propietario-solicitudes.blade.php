{{-- resources/views/propietario-solicitudes.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Solicitudes de reserva - UniRooms</title>

  <!-- TailwindCSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>

  <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
  <link rel="stylesheet" href="{{ asset('css/components.css') }}">
  <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
  <link rel="stylesheet" href="{{ asset('css/globals2.css') }}">
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

                <!-- Dropdown -->
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
    <div class="max-w-6xl mx-auto px-4 py-8">

        {{-- Título principal --}}
        <div class="mb-6 flex flex-col items-center text-center gap-3 w-full">
            <h1 class="text-2xl font-semibold">Solicitudes de reserva</h1>
            <p class="text-sm text-gray-500">
                Aquí puedes ver las solicitudes que han hecho los estudiantes para tus habitaciones.
            </p>
        </div>

        {{-- Si no hay solicitudes --}}
        @if($solicitudes->isEmpty())
            <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-6 text-center">
                <h2 class="text-lg font-semibold mb-2">Aún no tienes solicitudes de reserva</h2>
                <p class="text-sm text-gray-500">
                    Cuando los estudiantes empiecen a reservar tus habitaciones, verás sus solicitudes aquí.
                </p>
            </div>

        @else

            <div class="space-y-4">
                @foreach($solicitudes as $solicitud)
                    @php
                        $pension      = $solicitud->pension;
                        $zonaNombre   = optional($pension->zona)->nombre ?? 'Zona sin especificar';
                        $tipoNombre   = optional($pension->tipoHabitacion)->nombre ?? 'Tipo sin especificar';
                        $imagenes     = $pension?->link_foto ?? [];
                        $imagen       = (is_array($imagenes) && count($imagenes) > 0)
                                        ? $imagenes[0]
                                        : 'https://via.placeholder.com/800x500?text=Sin+imagen';

                        $estadoNombre = strtolower($solicitud->estado->nombre ?? 'rechazado');

                        if ($estadoNombre === 'aceptado') {
                            $estadoTexto = 'Aceptado';
                            $estadoColor = 'text-green-600 bg-green-50';
                            $puntoColor  = 'bg-green-500';
                            $accion      = 'rechazar';
                            $textoBoton  = 'Marcar como rechazado';
                            $claseBoton  = 'border-red-500 text-red-600 hover:bg-red-50';
                        } else {
                            $estadoTexto = 'Rechazado';
                            $estadoColor = 'text-red-600 bg-red-50';
                            $puntoColor  = 'bg-red-500';
                            $accion      = 'aceptar';
                            $textoBoton  = 'Marcar como aceptado';
                            $claseBoton  = 'border-green-500 text-green-600 hover:bg-green-50';
                        }
                    @endphp

                    {{-- TARJETA --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex flex-col md:flex-row">

                        {{-- Imagen --}}
                        <div class="md:w-56 w-full border-b md:border-b-0 md:border-r border-gray-100">
                            <img src="{{ $imagen }}"
                                 alt="{{ $pension->nombre ?? 'Habitación' }}"
                                 class="w-full h-44 md:h-full object-cover">
                        </div>

                        {{-- Contenido --}}
                        <div class="flex-1 p-4 md:p-5 flex flex-col gap-3">

                            {{-- Encabezado --}}
                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">

                                <div>
                                    <h2 class="text-base md:text-lg font-semibold text-blue-600">
                                        {{ $pension->nombre ?? 'Habitación sin título' }}
                                    </h2>

                                    <p class="text-xs text-gray-500 flex items-center gap-1 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                        {{ $pension->ubicacion_especifica }} · {{ $zonaNombre }}
                                    </p>

                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $tipoNombre }} · Capacidad: {{ $pension->capacidad }} persona{{ $pension->capacidad > 1 ? 's' : '' }}
                                    </p>
                                </div>

                                {{-- Estado + fechas --}}
                                <div class="text-right space-y-1">
                                    @if(!is_null($solicitud->fecha_inicio))
                                        <div>
                                            <div class="text-[11px] text-gray-400 uppercase tracking-wide">Inicio</div>
                                            <div class="text-sm font-semibold text-gray-800">
                                                {{ \Carbon\Carbon::parse($solicitud->fecha_inicio)->format('d/m/Y') }}
                                            </div>
                                        </div>
                                    @endif

                                    @if(!is_null($solicitud->fecha_fin))
                                        <div>
                                            <div class="text-[11px] text-gray-400 uppercase tracking-wide">Fin</div>
                                            <div class="text-sm font-semibold text-gray-800">
                                                {{ \Carbon\Carbon::parse($solicitud->fecha_fin)->format('d/m/Y') }}
                                            </div>
                                        </div>
                                    @endif

                                    <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded-full text-[11px] {{ $estadoColor }}">
                                        <span class="w-2 h-2 rounded-full mr-1 {{ $puntoColor }}"></span>
                                        {{ $estadoTexto }}
                                    </span>
                                </div>

                            </div>

                            {{-- Mensaje del estudiante --}}
                            @if($solicitud->mensaje)
                                <p class="text-xs text-gray-500">
                                    <span class="font-semibold text-gray-700">Mensaje del estudiante:</span>
                                    {{ $solicitud->mensaje }}
                                </p>
                            @endif

                            {{-- Fecha de creación --}}
                            <div class="border-t pt-2 flex items-center gap-2 text-[11px] text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                    <path d="M16 2v4"></path>
                                    <path d="M8 2v4"></path>
                                    <path d="M3 10h18"></path>
                                </svg>
                                Creada el {{ optional($solicitud->created_at)->format('d/m/Y · H:i') }}
                            </div>

                            {{-- Acciones --}}
                            <div class="flex flex-wrap items-center justify-end gap-3 pt-1 text-xs">

                                {{-- Ver detalles de la reserva (perfil / info completa) --}}
                                <a href="{{ route('propietario.habitacion.perfilestudiante', $pension) }}"
                                   class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700 hover:underline">
                                    Ver detalles
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </a>

                                {{-- Ver ficha de la habitación --}}
                                <a href="{{ route('propietario.habitacion.detalle', $pension) }}"
                                   class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700 hover:underline">
                                    Ver habitación
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </a>

                                {{-- Botón cambiar estado --}}
                                <form method="POST" action="{{ route('propietario.solicitudes.cambiarEstado', $solicitud) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="accion" value="{{ $accion }}">

                                    <button type="submit"
                                            class="inline-flex items-center gap-1 border rounded-full px-3 py-1 text-xs font-medium transition {{ $claseBoton }}">
                                        @if($accion === 'aceptar')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M20 6 9 17l-5-5"></path>
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M6 18 18 6M6 6l12 12" />
                                            </svg>
                                        @endif
                                        {{ $textoBoton }}
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>

                @endforeach
            </div>

        @endif

    </div>
</main>




  <footer class="bg-gray-900 text-gray-200 mt-auto">
    <div class="max-w-7xl mx-auto px-6 py-16">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

        <!-- Logo / descripción -->
        <div>
          <h3 class="text-white font-semibold mb-3">UniRooms</h3>
          <p class="text-gray-400 leading-relaxed">
            La plataforma líder para encontrar alojamiento universitario.
            Conectamos estudiantes con propietarios de confianza en las mejores zonas de la ciudad.
          </p>
        </div>

        <!-- Zonas -->
        <div>
          <h4 class="text-white font-semibold mb-3">Zonas Disponibles</h4>
          <ul class="space-y-2 text-gray-400">
            @foreach($zonas as $zona)
              <li>{{ $zona->nombre }}</li>
            @endforeach
          </ul>
        </div>

        <!-- Servicios -->
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

        <!-- Contacto -->
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

            <!-- Redes -->
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
