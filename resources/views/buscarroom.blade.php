{{-- resources/views/buscarroom.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UniRooms</title>

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

      <a href="{{ route('buscarroom') }}" id="nav-search" class="nav-link active">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
             viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             data-lucide="search" class="lucide lucide-search">
          <path d="m21 21-4.34-4.34"></path>
          <circle cx="11" cy="11" r="8"></circle>
        </svg>
        Buscar Habitaciones
      </a>

      <a href="{{ route('favoritas.index') }}" id="nav-favorites" class="nav-link">
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




  <!-- ========================== -->
  <!--       CONTENIDO PAGE       -->
  <!-- ========================== -->
  <main class="flex-1">
    <div class="container mx-auto px-4 py-8">
      <div>
        <div class="search-header">
          <h1>Encuentra tu Habitación Ideal</h1>
          <p style="color: var(--muted-foreground);">
            Explora <span data-rooms-count>{{ $pensiones->count() }}</span> habitaciones disponibles en las mejores zonas universitarias
          </p>
        </div>

        <!-- Tabs para Student/Owner -->
        <div style="display: flex; justify-content: center; margin-bottom: 2rem;">
          <div class="tabs-list">
            <button id="tab-student" class="tabs-trigger active" data-state="active">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                   viewBox="0 0 24 24" fill="none" stroke="currentColor"
                   stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                   data-lucide="graduation-cap" class="lucide lucide-graduation-cap">
                <path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"></path>
                <path d="M22 10v6"></path>
                <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"></path>
              </svg>
              Para Estudiantes
            </button>
          </div>
        </div>

        <!-- Student Tab Content -->
        <div id="student-content" class="tabs-content">
          <div id="search-filters-container">
            <div class="search-filters">
              <div class="filters-grid">
                <!-- Buscar -->
                <div class="filter-group">
                  <label class="filter-label">Buscar</label>
                  <input
                    type="text"
                    id="search-input"
                    class="input"
                    placeholder="Buscar por título, ubicación..."
                    value=""
                  >
                </div>

                <!-- Zona -->
                <div class="filter-group">
                  <label class="filter-label">Zona</label>
                  <select id="zone-select" class="select">
                    <option value="all">Todas las zonas</option>
                    @foreach($zonas as $zona)
                      <option value="{{ $zona->id }}">{{ $zona->nombre }}</option>
                    @endforeach
                  </select>
                </div>

                <!-- Tipo de Habitación -->
                <div class="filter-group">
                  <label class="filter-label">Tipo de Habitación</label>
                  <select id="type-select" class="select">
                    <option value="all">Todos los tipos</option>
                    @foreach($tiposHabitacion as $tipo)
                      <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                    @endforeach
                  </select>
                </div>

                <!-- Precio -->
                <div class="filter-group">
                  <label class="filter-label">
                    Precio: $ {{ number_format($minPrecio, 0, ',', '.') }} - $ {{ number_format($maxPrecio, 0, ',', '.') }}
                  </label>
                  <div style="display: flex; gap: 0.5rem; align-items: center;">
                    <input
                      type="range"
                      id="price-min"
                      min="{{ $minPrecio }}"
                      max="{{ $maxPrecio }}"
                      value="{{ $minPrecio }}"
                      class="slider-thumb"
                      style="flex: 1;"
                    >
                    <input
                      type="range"
                      id="price-max"
                      min="{{ $minPrecio }}"
                      max="{{ $maxPrecio }}"
                      value="{{ $maxPrecio }}"
                      class="slider-thumb"
                      style="flex: 1;"
                    >
                  </div>
                </div>
              </div>

              <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                  <input type="checkbox" id="available-only">
                  <label for="available-only" class="filter-label" style="margin: 0;">
                    Solo habitaciones disponibles
                  </label>
                </div>

                <div style="display: flex; align-items: center; gap: 1rem;">
                  <label class="filter-label">Ordenar por:</label>
                  <select id="sort-select" class="select" style="width: auto; min-width: 150px;">
                    <option value="relevance" selected>Relevancia</option>
                    <option value="price-low">Precio: Menor a Mayor</option>
                    <option value="price-high">Precio: Mayor a Menor</option>
                    <option value="newest">Más Recientes</option>
                  </select>
                </div>
              </div>

              <div style="display: flex; justify-content: center; margin-top: 1rem;">
                <button id="clear-filters" class="btn btn-outline">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                       viewBox="0 0 24 24" fill="none" stroke="currentColor"
                       stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                       data-lucide="x" class="lucide lucide-x">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                  </svg>
                  Limpiar Filtros
                </button>
              </div>
            </div>
          </div>

          <div style="display: flex; justify-content: space-between; align-items: center; margin: 2rem 0 1rem;">
            <h2>Habitaciones Disponibles (<span data-rooms-count>{{ $pensiones->count() }}</span>)</h2>
            <div style="display: flex; gap: 0.5rem;">
              <button id="view-grid" class="btn btn-outline btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     data-lucide="grid-3x3" class="lucide lucide-grid-3x3">
                  <rect width="18" height="18" x="3" y="3" rx="2"></rect>
                  <path d="M3 9h18"></path>
                  <path d="M3 15h18"></path>
                  <path d="M9 3v18"></path>
                  <path d="M15 3v18"></path>
                </svg>
                Cuadrícula
              </button>
              <button id="view-list" class="btn btn-outline btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     data-lucide="list" class="lucide lucide-list">
                  <path d="M3 5h.01"></path>
                  <path d="M3 12h.01"></path>
                  <path d="M3 19h.01"></path>
                  <path d="M8 5h13"></path>
                  <path d="M8 12h13"></path>
                  <path d="M8 19h13"></path>
                </svg>
                Lista
              </button>
            </div>
          </div>

          <div id="rooms-container" class="rooms-grid">
            @foreach($pensiones as $pension)
              @php
                $zonaNombre   = optional($pension->zona)->nombre ?? 'Zona sin especificar';
                $tipoNombre   = optional($pension->tipoHabitacion)->nombre ?? 'Tipo sin especificar';
                $servicios    = $pension->servicios ?? collect();
                $maxBadges    = 3;

                $imagenes = $pension->link_foto ?? [];
                $imagenPrincipal = (is_array($imagenes) && count($imagenes) > 0)
                  ? $imagenes[0]
                  : 'https://via.placeholder.com/800x500?text=Sin+imagen';
              @endphp

              <div id="room-{{ $pension->id }}"
                   class="room-item"
                   data-room
                   data-zona-id="{{ $pension->id_zona }}"
                   data-tipo-id="{{ $pension->id_tipo_habitacion }}"
                   data-precio="{{ $pension->precio }}"
                   data-disponible="{{ $pension->disponible ? 1 : 0 }}"
                   data-created-at="{{ optional($pension->created_at)->timestamp ?? '' }}"
                   data-search-text="{{ $pension->nombre . ' ' . $pension->ubicacion_especifica . ' ' . $zonaNombre }}">
                <div class="room-card">
                  <img
                    src="{{ $imagenPrincipal }}"
                    alt="{{ $pension->nombre }}"
                    class="room-image"
                    loading="lazy"
                  >

                  <div class="room-info">
                    <h3 class="room-title">{{ $pension->nombre }}</h3>

                    <div class="room-location">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                           viewBox="0 0 24 24" fill="none" stroke="currentColor"
                           stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                           data-lucide="map-pin" class="lucide lucide-map-pin">
                        <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                      </svg>
                      <span>{{ $pension->ubicacion_especifica }} - {{ $zonaNombre }}</span>
                    </div>

                    <div class="room-price">
                      $ {{ number_format($pension->precio, 0, ',', '.') }}/mes
                    </div>

                    {{-- AMENITIES CON ÍCONOS SEGÚN EL SERVICIO --}}
                    <div class="room-amenities">
                      @foreach($servicios->take($maxBadges) as $servicio)
                        <div class="badge badge-secondary" style="display:flex; align-items:center; gap:0.25rem;">
                          @switch($servicio->id)
                            @case(1) {{-- Wi-Fi --}}
                              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                   viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                   stroke-width="2" style="color:var(--primary)">
                                <path d="M12 20h.01"></path>
                                <path d="M2 8.82a15 15 0 0 1 20 0"></path>
                                <path d="M5 12.859a10 10 0 0 1 14 0"></path>
                                <path d="M8.5 16.429a5 5 0 0 1 7 0"></path>
                              </svg>
                              @break

                            @case(2) {{-- Escritorio --}}
                              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                   viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                   stroke-width="2" style="color:var(--primary)">
                                <path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                <rect width="20" height="14" x="2" y="6" rx="2"></rect>
                              </svg>
                              @break

                            @case(3) {{-- Closet --}}
                              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                   viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                   stroke-width="2" style="color:var(--primary)">
                                <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path>
                                <path d="m3.3 7 8.7 5 8.7-5"></path>
                                <path d="M12 22V12"></path>
                              </svg>
                              @break

                            @case(4) {{-- Calefacción --}}
                              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                   viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                   stroke-width="2" style="color:var(--primary)">
                                <path d="M14 4v10.54a4 4 0 1 1-4 0V4a2 2 0 0 1 4 0Z"></path>
                              </svg>
                              @break

                            @case(5) {{-- Cocina --}}
                              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                   viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                   stroke-width="2" style="color:var(--primary)">
                                <path d="M17 21a1 1 0 0 0 1-1v-5.35c0-.457.316-.844.727-1.041a4 4 0 0 0-2.134-7.589 5 5 0 0 0-9.186 0 4 4 0 0 0-2.134 7.588c.411.198.727.585.727 1.041V20a1 1 0 0 0 1 1Z"></path>
                                <path d="M6 17h12"></path>
                              </svg>
                              @break

                            @case(6) {{-- Baño Privado --}}
                              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                   viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                   stroke-width="2" style="color:var(--primary)">
                                <path d="M10 4 8 6"></path>
                                <path d="M17 19v2"></path>
                                <path d="M2 12h20"></path>
                                <path d="M7 19v2"></path>
                                <path d="M9 5 7.621 3.621A2.121 2.121 0 0 0 4 5v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5"></path>
                              </svg>
                              @break

                            @case(7) {{-- Lavandería --}}
                              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                   viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                   stroke-width="2" style="color:var(--primary)">
                                <path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"></path>
                              </svg>
                              @break

                            @case(8) {{-- Parqueadero --}}
                              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                   viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                   stroke-width="2" style="color:var(--primary)">
                                <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"></path>
                                <circle cx="7" cy="17" r="2"></circle>
                                <path d="M9 17h6"></path>
                                <circle cx="17" cy="17" r="2"></circle>
                              </svg>
                              @break

                            @case(9) {{-- Sala Común --}}
                              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                   viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                   stroke-width="2" style="color:var(--primary)">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                              </svg>
                              @break

                            @case(10) {{-- Jardín --}}
                              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                   viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                   stroke-width="2" style="color:var(--primary)">
                                <path d="M10 10v.2A3 3 0 0 1 8.9 16H5a3 3 0 0 1-1-5.8V10a3 3 0 0 1 6 0Z"></path>
                                <path d="M7 16v6"></path>
                                <path d="M13 19v3"></path>
                                <path d="M12 19h8.3a1 1 0 0 0 .7-1.7L18 14h.3a1 1 0 0 0 .7-1.7L16 9h.2a1 1 0 0 0 .8-1.7L13 3l-1.4 1.5"></path>
                              </svg>
                              @break

                            @case(11) {{-- Gimnasio --}}
                              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                   viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                   stroke-width="2" style="color:var(--primary)">
                                <path d="M17.596 12.768a2 2 0 1 0 2.829-2.829l-1.768-1.767a2 2 0 0 0 2.828-2.829l-2.828-2.828a2 2 0 0 0-2.829 2.828l-1.767-1.768a2 2 0 1 0-2.829 2.829z"></path>
                                <path d="m2.5 21.5 1.4-1.4"></path>
                                <path d="m20.1 3.9 1.4-1.4"></path>
                                <path d="M5.343 21.485a2 2 0 1 0 2.829-2.828l1.767 1.768a2 2 0 1 0 2.829-2.829l-6.364-6.364a2 2 0 1 0-2.829 2.829l1.768 1.767a2 2 0 0 0-2.828 2.829z"></path>
                                <path d="m9.6 14.4 4.8-4.8"></path>
                              </svg>
                              @break

                            @case(12) {{-- Sala de Estudio --}}
                              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                   viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                   stroke-width="2" style="color:var(--primary)">
                                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"></path>
                              </svg>
                              @break

                            @default
                              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                   viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                   stroke-width="2" style="color:var(--primary)">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m9 12 2 2 4-4"></path>
                              </svg>
                          @endswitch

                          <span>{{ $servicio->nombre }}</span>
                        </div>
                      @endforeach

                      @if($servicios->count() > $maxBadges)
                        <div class="badge badge-outline">
                          +{{ $servicios->count() - $maxBadges }} más
                        </div>
                      @endif
                    </div>

                    <p class="mt-2 text-sm text-gray-600 line-clamp-2">
                      {{ $pension->descripcion }}
                    </p>

                    <div class="room-actions mt-3">
                      {{-- ENLACE NUEVO A LA RUTA rooms.show --}}
                      <a href="{{ route('rooms.show', $pension) }}" class="btn btn-outline">
                        Ver Detalles
                      </a>

                      <button class="btn btn-primary btn-contact" data-room-id="{{ $pension->id }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             data-lucide="message-circle" class="lucide lucide-message-circle">
                          <path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"></path>
                        </svg>
                        Contactar
                      </button>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem; font-size: 0.875rem; color: var(--muted-foreground);">
                      <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             data-lucide="users" style="width: 14px; height: 14px;"
                             class="lucide lucide-users">
                          <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                          <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
                          <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                          <circle cx="9" cy="7" r="4"></circle>
                        </svg>
                        Hasta {{ $pension->capacidad }} persona{{ $pension->capacidad > 1 ? 's' : '' }}
                      </span>

                      <span style="margin-left: auto; display:flex; align-items:center; gap:0.25rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             data-lucide="home" style="width: 14px; height: 14px;"
                             class="lucide lucide-home">
                          <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path>
                          <path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        </svg>
                        {{ $tipoNombre }}
                      </span>
                    </div>
                    {{-- NO mostramos el estado; se asume publicada si aparece aquí --}}
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <!-- Owner Tab Content (estático) -->
        <div id="owner-content" class="tabs-content hidden">
          <div style="text-align: center; padding: 3rem 1rem;">
            <div style="max-width: 600px; margin: 0 auto;">
              <div style="width: 4rem; height: 4rem; margin: 0 auto 2rem; background-color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     data-lucide="home" class="lucide lucide-home">
                  <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path>
                  <path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                </svg>
              </div>
              <h2>Publica tu Habitación</h2>
              <p style="color: var(--muted-foreground); margin-bottom: 2rem;">
                Conecta con estudiantes que buscan alojamiento y genera ingresos extra con tu propiedad
              </p>

              <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                <div class="card" style="padding: 1.5rem; text-align: center;">
                  <div style="width: 2.5rem; height: 2.5rem; margin: 0 auto 1rem; background-color: var(--secondary); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         data-lucide="upload" class="lucide lucide-upload">
                      <path d="M12 3v12"></path>
                      <path d="m17 8-5-5-5 5"></path>
                      <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    </svg>
                  </div>
                  <h4>Publicación Fácil</h4>
                  <p style="color: var(--muted-foreground); font-size: 0.875rem;">
                    Sube fotos y describe tu habitación en minutos
                  </p>
                </div>

                <div class="card" style="padding: 1.5rem; text-align: center;">
                  <div style="width: 2.5rem; height: 2.5rem; margin: 0 auto 1rem; background-color: var(--secondary); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         data-lucide="users" class="lucide lucide-users">
                      <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                      <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
                      <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                      <circle cx="9" cy="7" r="4"></circle>
                    </svg>
                  </div>
                  <h4>Estudiantes Verificados</h4>
                  <p style="color: var(--muted-foreground); font-size: 0.875rem;">
                    Conecta con estudiantes responsables y verificados
                  </p>
                </div>

                <div class="card" style="padding: 1.5rem; text-align: center;">
                  <div style="width: 2.5rem; height: 2.5rem; margin: 0 auto 1rem; background-color: var(--secondary); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         data-lucide="shield-check" class="lucide lucide-shield-check">
                      <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>
                      <path d="m9 12 2 2 4-4"></path>
                    </svg>
                  </div>
                  <h4>Proceso Seguro</h4>
                  <p style="color: var(--muted-foreground); font-size: 0.875rem;">
                    Plataforma segura con soporte 24/7
                  </p>
                </div>
              </div>

              <button id="btn-add-room" class="btn btn-primary btn-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     data-lucide="plus-circle" class="lucide lucide-plus-circle">
                  <circle cx="12" cy="12" r="10"></circle>
                  <path d="M8 12h8"></path>
                  <path d="M12 8v8"></path>
                </svg>
                Publicar mi Habitación
              </button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>

  <!-- ========================== -->
  <!--          FOOTER            -->
  <!-- ========================== -->
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

  <!-- Scripts -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      lucide.createIcons();

      const userMenuBtn = document.getElementById('userMenuBtn');
      const dropdown = document.getElementById('userDropdown');

      userMenuBtn?.addEventListener('click', () => {
        dropdown.classList.toggle('hidden');
      });

      document.addEventListener('click', (e) => {
        if (!userMenuBtn?.contains(e.target) && !dropdown?.contains(e.target)) {
          dropdown?.classList.add('hidden');
        }
      });

      // ======== FILTROS Y BÚSQUEDA ==========
      const roomsContainer   = document.getElementById('rooms-container');
      const roomCards        = Array.from(roomsContainer.querySelectorAll('[data-room]'));

      const searchInput      = document.getElementById('search-input');
      const zoneSelect       = document.getElementById('zone-select');
      const typeSelect       = document.getElementById('type-select');
      const priceMin         = document.getElementById('price-min');
      const priceMax         = document.getElementById('price-max');
      const availableOnly    = document.getElementById('available-only');
      const sortSelect       = document.getElementById('sort-select');
      const clearFiltersBtn  = document.getElementById('clear-filters');
      const viewGridBtn      = document.getElementById('view-grid');
      const viewListBtn      = document.getElementById('view-list');
      const countSpans       = document.querySelectorAll('[data-rooms-count]');

      // Normalizar texto de búsqueda en dataset
      roomCards.forEach((card, index) => {
        card.dataset.originalIndex = index;
        card.dataset.searchText = (card.dataset.searchText || '').toLowerCase();
      });

      function updateCount(visibleCount) {
        countSpans.forEach(span => span.textContent = visibleCount);
      }

      function applyFilters() {
        const search = (searchInput?.value || '').toLowerCase().trim();
        const zona   = zoneSelect?.value || 'all';
        const tipo   = typeSelect?.value || 'all';
        const minP   = priceMin ? parseInt(priceMin.value || '0', 10) : 0;
        const maxP   = priceMax ? parseInt(priceMax.value || '999999999', 10) : 999999999;
        const onlyAv = availableOnly?.checked || false;

        let visibleCount = 0;

        roomCards.forEach(card => {
          const text        = card.dataset.searchText || '';
          const zonaId      = card.dataset.zonaId || '';
          const tipoId      = card.dataset.tipoId || '';
          const precio      = parseFloat(card.dataset.precio || '0');
          const disponible  = card.dataset.disponible === '1';

          let visible = true;

          if (search && !text.includes(search)) visible = false;
          if (zona !== 'all' && zonaId !== zona) visible = false;
          if (tipo !== 'all' && tipoId !== tipo) visible = false;
          if (precio < minP || precio > maxP) visible = false;
          if (onlyAv && !disponible) visible = false;

          card.style.display = visible ? '' : 'none';
          if (visible) visibleCount++;
        });

        updateCount(visibleCount);
      }

      function applySort() {
        const sortValue = sortSelect?.value || 'relevance';

        // Tomar solo las cards visibles
        const visibleCards = roomCards.filter(card => card.style.display !== 'none');

        let sorted = [...visibleCards];

        if (sortValue === 'price-low') {
          sorted.sort((a, b) =>
            parseFloat(a.dataset.precio || '0') - parseFloat(b.dataset.precio || '0')
          );
        } else if (sortValue === 'price-high') {
          sorted.sort((a, b) =>
            parseFloat(b.dataset.precio || '0') - parseFloat(a.dataset.precio || '0')
          );
        } else if (sortValue === 'newest') {
          sorted.sort((a, b) =>
            parseInt(b.dataset.createdAt || '0', 10) - parseInt(a.dataset.createdAt || '0', 10)
          );
        } else { // relevance = orden original
          sorted.sort((a, b) =>
            parseInt(a.dataset.originalIndex || '0', 10) - parseInt(b.dataset.originalIndex || '0', 10)
          );
        }

        // Reinsertar visibles en el orden elegido
        sorted.forEach(card => roomsContainer.appendChild(card));
      }

      function refresh() {
        applyFilters();
        applySort();
      }

      // Eventos
      searchInput?.addEventListener('input', refresh);
      zoneSelect?.addEventListener('change', refresh);
      typeSelect?.addEventListener('change', refresh);
      priceMin?.addEventListener('input', refresh);
      priceMax?.addEventListener('input', refresh);
      availableOnly?.addEventListener('change', refresh);
      sortSelect?.addEventListener('change', () => {
        applySort();
      });

      clearFiltersBtn?.addEventListener('click', () => {
        if (searchInput) searchInput.value = '';
        if (zoneSelect) zoneSelect.value = 'all';
        if (typeSelect) typeSelect.value = 'all';
        if (priceMin)  priceMin.value  = priceMin.min || '0';
        if (priceMax)  priceMax.value  = priceMax.max || '999999999';
        if (availableOnly) availableOnly.checked = false;
        if (sortSelect) sortSelect.value = 'relevance';
        refresh();
      });

      // Vista grid / lista
      viewGridBtn?.addEventListener('click', () => {
        roomsContainer.classList.remove('rooms-list');
        roomsContainer.classList.add('rooms-grid');
      });

      viewListBtn?.addEventListener('click', () => {
        roomsContainer.classList.remove('rooms-grid');
        roomsContainer.classList.add('rooms-list');
      });

      // Primera ejecución
      refresh();
    });
  </script>

</body>
</html>
