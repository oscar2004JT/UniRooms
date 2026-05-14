{{-- resources/views/favorita.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mis Habitaciones Favoritas - UniRooms</title>

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
  <!-- ========================== -->
  <!--        HEADER / NAV        -->
  <!-- ========================== -->
  <header class="bg-gradient-to-r from-blue-700 to-blue-500 text-white">
    <div class="max-w-7xl mx-auto px-4">
      <div class="flex items-center justify-between h-20">

        <!-- Logo -->
        <a href="{{ route('buscarroom') }}" class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-md bg-white/20 flex items-center justify-center">
            <i data-lucide="home" class="text-white"></i>
          </div>
          <span class="font-semibold text-xl">UniRooms</span>
        </a>

        <!-- NAVIGATION -->
        <nav class="flex items-center gap-3">
          @guest
            <!-- Solo cuando NO está logueado -->
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
              $rol = Auth::user()->id_rol;
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
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </button>

                <!-- Dropdown -->
                <div id="userDropdown"
                     class="hidden absolute right-0 mt-2 w-48 bg-white text-gray-700 rounded-md shadow-lg overflow-hidden z-50">
                  <div class="px-4 py-2 text-sm text-gray-500 border-b">Mi cuenta</div>
                  <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Perfil</a>

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

  <!-- NAV SECUNDARIA -->
  <nav class="navigation" style="display: block;">
    <div class="navigation-content">
      <a href="{{ route('inicio') }}" id="nav-home" class="nav-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
             stroke-linejoin="round" data-lucide="home" class="lucide lucide-home">
          <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path>
          <path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
        </svg>
        Inicio
      </a>

      <a href="{{ route('buscarroom') }}" id="nav-search" class="nav-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
             viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             data-lucide="search" class="lucide lucide-search">
          <path d="m21 21-4.34-4.34"></path>
          <circle cx="11" cy="11" r="8"></circle>
        </svg>
        Buscar Habitaciones
      </a>

      <a href="{{ route('favoritas.index') }}" id="nav-favorites" class="nav-link active">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
             viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             data-lucide="heart" class="lucide lucide-heart">
          <path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5"></path>
        </svg>
        Favoritos
      </a>

      <a href="{{ route('arriendos.index') }}" id="nav-reservas" class="nav-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            data-lucide="calendar-check" class="lucide lucide-calendar-check">
          <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
          <path d="M16 2v4"></path>
          <path d="M8 2v4"></path>
          <path d="m9 14 2 2 4-4"></path>
        </svg>
        Mis Reservas
      </a>

      <a href="#" id="nav-messages" class="nav-link">
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

  <!-- CONTENIDO PRINCIPAL -->
  <main class="flex-1">
    <div class="max-w-5xl mx-auto px-4 py-6">
      <h1 class="text-xl font-semibold mb-4">Mis habitaciones favoritas</h1>

      @if(session('success'))
        <div class="mb-4 rounded-md bg-green-50 border border-green-200 text-green-800 px-4 py-2 text-sm">
          {{ session('success') }}
        </div>
      @endif

      @if(session('info'))
        <div class="mb-4 rounded-md bg-blue-50 border border-blue-200 text-blue-800 px-4 py-2 text-sm">
          {{ session('info') }}
        </div>
      @endif

      @if(session('error'))
        <div class="mb-4 rounded-md bg-red-50 border border-red-200 text-red-800 px-4 py-2 text-sm">
          {{ session('error') }}
        </div>
      @endif

      @if($favoritas->isEmpty())
        <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-6 text-center">
          <h2 class="text-lg font-semibold mb-2">Aún no tienes habitaciones favoritas</h2>
          <p class="text-sm text-[var(--muted-foreground)] mb-4">
            Guarda habitaciones como favoritas desde la página de detalle para verlas aquí.
          </p>
          <a href="{{ route('buscarroom') }}"
             class="btn btn-primary inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 data-lucide="search" class="lucide lucide-search">
              <circle cx="11" cy="11" r="8"></circle>
              <path d="m21 21-4.3-4.3"></path>
            </svg>
            Buscar habitaciones
          </a>
        </div>
      @else
        <div class="space-y-4">
          @foreach($favoritas as $fav)
            @php
              $p = $fav->pension;
              if (!$p) continue;

              $zonaNombre = optional($p->zona)->nombre ?? 'Zona sin especificar';
              $tipoNombre = optional($p->tipoHabitacion)->nombre ?? 'Tipo sin especificar';

              $imagenesRaw = $p->link_foto;
              if (is_array($imagenesRaw)) {
                  $imagenes = $imagenesRaw;
              } else {
                  $imagenes = json_decode($imagenesRaw ?? '[]', true) ?: [];
              }
              $imagenPrincipal = (is_array($imagenes) && count($imagenes) > 0)
                  ? $imagenes[0]
                  : 'https://via.placeholder.com/600x400?text=Sin+imagen';
            @endphp

            <div class="bg-white rounded-2xl shadow-md border border-gray-200 overflow-hidden flex flex-col sm:flex-row">
              <div class="sm:w-1/3">
                <img src="{{ $imagenPrincipal }}"
                     alt="{{ $p->nombre }}"
                     class="w-full h-40 sm:h-full object-cover">
              </div>

              <div class="flex-1 p-4 flex flex-col justify-between">
                <div>
                  <div class="flex justify-between items-start gap-2">
                    <div>
                      <a href="{{ route('rooms.show', $p) }}"
                         class="text-base font-semibold text-blue-600 hover:text-blue-700">
                        {{ $p->nombre }}
                      </a>
                      <p class="text-xs text-[var(--muted-foreground)] flex items-center gap-1 mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             data-lucide="map-pin" class="lucide lucide-map-pin">
                          <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                          <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        {{ $p->ubicacion_especifica }} - {{ $zonaNombre }}
                      </p>
                      <p class="text-xs text-[var(--muted-foreground)] mt-1">
                        {{ $tipoNombre }} · Hasta {{ $p->capacidad }} persona{{ $p->capacidad > 1 ? 's' : '' }}
                      </p>
                    </div>
                    <div class="text-right">
                      <div class="text-lg font-bold text-blue-600">
                        $ {{ number_format($p->precio, 0, ',', '.') }}
                      </div>
                      <div class="text-[10px] text-[var(--muted-foreground)]">/ mes</div>
                    </div>
                  </div>

                  <p class="mt-2 text-xs text-[var(--muted-foreground)] line-clamp-2">
                    {{ $p->descripcion }}
                  </p>
                </div>

                <div class="mt-3 flex flex-wrap items-center justify-between gap-2">
                  <a href="{{ route('rooms.show', $p) }}"
                     class="inline-flex items-center gap-1.5 text-xs text-blue-600 hover:text-blue-700 hover:underline">
                    Ver detalles
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         data-lucide="arrow-right" class="lucide lucide-arrow-right">
                      <path d="M5 12h14"></path>
                      <path d="m12 5 7 7-7 7"></path>
                    </svg>
                  </a>

                  <form method="POST" action="{{ route('favoritas.destroy', $p) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 text-xs text-red-500 hover:underline">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                           viewBox="0 0 24 24" fill="none" stroke="currentColor"
                           stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                           data-lucide="trash-2" class="lucide lucide-trash-2">
                        <path d="M3 6h18"></path>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                        <path d="M10 11v6"></path>
                        <path d="M14 11v6"></path>
                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path>
                      </svg>
                      Quitar de favoritas
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

  <!-- FOOTER -->
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
      // Inicializar iconos de Lucide
      lucide.createIcons();

      // --- Dropdown de usuario ---
      const userMenuBtn = document.getElementById('userMenuBtn');
      const userDropdown = document.getElementById('userDropdown');

      if (userMenuBtn && userDropdown) {
        userMenuBtn.addEventListener('click', () => {
          userDropdown.classList.toggle('hidden');
        });

        // Cerrar al hacer click fuera
        document.addEventListener('click', (e) => {
          if (!userMenuBtn.contains(e.target) && !userDropdown.contains(e.target)) {
            userDropdown.classList.add('hidden');
          }
        });
      }

      // --- Menú móvil ---
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
