{{-- resources/views/detalle-room.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $pension->nombre }} - UniRooms</title>

  <!-- TailwindCSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>

  <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
  <link rel="stylesheet" href="{{ asset('css/components.css') }}">
  <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
  <link rel="stylesheet" href="{{ asset('css/globals2.css') }}">
</head>

@php
    $zonaNombre = optional($pension->zona)->nombre ?? 'Zona sin especificar';
    $tipoNombre = optional($pension->tipoHabitacion)->nombre ?? 'Tipo sin especificar';

    $imagenesRaw = $pension->link_foto;
    if (is_array($imagenesRaw)) {
        $imagenes = $imagenesRaw;
    } else {
        $imagenes = json_decode($imagenesRaw ?? '[]', true) ?: [];
    }

    $imagenPrincipal = (is_array($imagenes) && count($imagenes) > 0)
        ? $imagenes[0]
        : 'https://via.placeholder.com/1200x700?text=Sin+imagen';

    $numFotos = is_array($imagenes) ? count($imagenes) : 0;

    // Datos del propietario
    $propietarioNombre   = $propietario->name     ?? 'Propietario';
    $propietarioCorreo   = $propietario->email    ?? 'correo@ejemplo.com';
    $propietarioTelefono = $propietario->telefono ?? '+57 300 000 0000';
    $propietarioId       = $propietario->propietario_id ?? null;

    $precio        = $pension->precio;
    $deposito      = $precio;
    $totalInicial  = $precio + $deposito;
@endphp

<body class="bg-gray-100 min-h-screen flex flex-col">

  {{-- ========================== --}}
  {{--        HEADER / NAV        --}}
  {{-- ========================== --}}
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
  {{--     NAV SECUNDARIA EST     --}}
  {{-- ========================== --}}
  <nav class="navigation" style="display: block;">
    <div class="navigation-content">
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

  {{-- ========================== --}}
  {{--        CONTENIDO MAIN      --}}
  {{-- ========================== --}}
  <main class="flex-1">
    <div id="app">
      <div class="max-w-5xl mx-auto px-4 py-6">

        <!-- Imagen principal -->
        <div class="relative rounded-2xl overflow-hidden shadow-md">
          <img src="{{ $imagenPrincipal }}"
               alt="{{ $pension->nombre }}"
               class="w-full max-h-[480px] object-cover block">

          @if($numFotos > 1)
            <div class="absolute bottom-4 right-4">
              <button type="button"
                      id="open-gallery"
                      class="btn btn-secondary rounded-full gap-2 px-4 py-2 text-sm shadow-md bg-white/90 hover:bg-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     data-lucide="image" class="lucide lucide-image">
                  <rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect>
                  <circle cx="9" cy="9" r="2"></circle>
                  <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
                </svg>
                Ver todas las fotos ({{ $numFotos }})
              </button>
            </div>
          @endif
        </div>

        <!-- Grid de contenido -->
        <div class="mt-6 grid gap-5 lg:grid-cols-[minmax(0,2fr)_minmax(0,1fr)]">
          <!-- Columna principal -->
          <section>
            <div class="bg-white rounded-2xl shadow-md p-5 space-y-6">
              <!-- Título / tipo / capacidad / precio -->
              <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                <div>
                  <h2 class="text-xl font-semibold mb-1">{{ $pension->nombre }}</h2>
                  <p class="text-sm text-[var(--muted-foreground)] flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1.5">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                           viewBox="0 0 24 24" fill="none" stroke="currentColor"
                           stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                           data-lucide="home" class="lucide lucide-home">
                        <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path>
                        <path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                      </svg>
                      {{ $tipoNombre }}
                    </span>
                    <span class="text-gray-300">•</span>
                    <span class="inline-flex items-center gap-1.5">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                           viewBox="0 0 24 24" fill="none" stroke="currentColor"
                           stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                           data-lucide="users" class="lucide lucide-users">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                        <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                      </svg>
                      Hasta {{ $pension->capacidad }} persona{{ $pension->capacidad > 1 ? 's' : '' }}
                    </span>
                  </p>
                </div>

                <div class="text-right">
                  <div class="text-3xl font-bold text-[var(--primary)]">
                    $ {{ number_format($precio, 0, ',', '.') }}
                  </div>
                  <div class="text-xs text-[var(--muted-foreground)]">por mes</div>
                </div>
              </div>

              <!-- Descripción -->
              <div>
                <h3 class="text-base font-semibold mb-1.5">Descripción</h3>
                <p class="text-sm leading-relaxed text-[var(--foreground)]">
                  {{ $pension->descripcion }}
                </p>
              </div>

              <!-- Servicios incluidos -->
              <div>
                <h3 class="text-base font-semibold mb-1.5">Servicios incluidos</h3>
                <div class="grid gap-3 mt-3 sm:grid-cols-2">
                  @foreach($pension->servicios as $servicio)
                    <div class="flex items-center gap-3">
                      <div class="w-8 h-8 rounded-full bg-[var(--secondary)] flex items-center justify-center">
                        @switch($servicio->id)
                          @case(1)
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 data-lucide="wifi" class="lucide lucide-wifi">
                              <path d="M12 20h.01"></path>
                              <path d="M2 8.82a15 15 0 0 1 20 0"></path>
                              <path d="M5 12.859a10 10 0 0 1 14 0"></path>
                              <path d="M8.5 16.429a5 5 0 0 1 7 0"></path>
                            </svg>
                            @break
                          {{-- ... se mantiene TODO tu switch tal cual ... --}}
                          @default
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="lucide lucide-badge-check">
                              <path d="M3.5 9a6.5 6.5 0 0 1 13 0c0 2.761-1.833 5.09-4.365 6.025L12 21l-2.135-5.975A6.502 6.502 0 0 1 3.5 9Z"></path>
                              <path d="m9 9.5 1.5 1.5 3-3"></path>
                            </svg>
                        @endswitch
                      </div>
                      <span class="text-sm">{{ $servicio->nombre }}</span>
                    </div>
                  @endforeach
                </div>
              </div>

              <!-- Ubicación -->
              <div>
                <h3 class="text-base font-semibold mb-1.5">Ubicación</h3>
                <div class="bg-[var(--muted)] rounded-xl p-4 space-y-2">
                  <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         data-lucide="map-pin" class="lucide lucide-map-pin text-[var(--primary)]">
                      <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                      <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    <strong class="text-sm">{{ $pension->ubicacion_especifica }}</strong>
                  </div>
                  <p class="text-xs text-[var(--muted-foreground)]">
                    Zona: {{ $zonaNombre }}<br>
                    Dirección: {{ $pension->direccion ?? 'No especificada' }}
                  </p>
                  <div class="mt-2">
                    <button type="button"
                            class="btn btn-outline rounded-full px-3 py-1.5 text-xs inline-flex items-center gap-2">
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                           viewBox="0 0 24 24" fill="none" stroke="currentColor"
                           stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                           data-lucide="map" class="lucide lucide-map">
                        <path d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z"></path>
                        <path d="M15 5.764v15"></path>
                        <path d="M9 3.236v15"></path>
                      </svg>
                      Ver en el mapa
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <!-- Sidebar -->
          <aside class="flex flex-col gap-4">
            <!-- Booking card -->
            <div class="bg-white rounded-2xl shadow-md p-4 space-y-3">
              <h3 class="text-base font-semibold">Reservar ahora</h3>

              <div class="space-y-1 text-sm">
                <div class="flex justify-between">
                  <span>Precio por mes:</span>
                  <strong>$ {{ number_format($precio, 0, ',', '.') }}</strong>
                </div>
                <div class="flex justify-between">
                  <span>Depósito de seguridad:</span>
                  <span>$ {{ number_format($deposito, 0, ',', '.') }}</span>
                </div>
                <hr class="my-2 border-[var(--border)]">
                <div class="flex justify-between font-semibold">
                  <span>Total inicial:</span>
                  <span>$ {{ number_format($totalInicial, 0, ',', '.') }}</span>
                </div>
              </div>

              <a href="{{ route('arriendos.create', $pension->id) }}"
                 class="btn btn-primary w-full rounded-full mt-2 inline-flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     data-lucide="calendar-check" class="lucide lucide-calendar-check">
                  <path d="M8 2v4"></path>
                  <path d="M16 2v4"></path>
                  <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                  <path d="M3 10h18"></path>
                  <path d="m9 16 2 2 4-4"></path>
                </svg>
                Reservar habitación
              </a>

              <button id="contact-owner" type="button"
                      class="btn btn-outline w-full rounded-full inline-flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     data-lucide="message-circle" class="lucide lucide-message-circle">
                  <path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"></path>
                </svg>
                Contactar propietario
              </button>

              <p class="text-xs text-center text-[var(--muted-foreground)] mt-1">
                No se realizará ningún cargo hasta confirmar la reserva
              </p>
            </div>

            <!-- Owner card -->
            <div class="bg-white rounded-2xl shadow-md p-4 space-y-3">
              <h3 class="text-base font-semibold">Propietario</h3>

              <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-[var(--primary)] text-white flex items-center justify-center font-semibold text-lg">
                  {{ strtoupper(mb_substr($propietarioNombre, 0, 1)) }}
                </div>
                <div>
                  <div class="font-semibold text-sm">{{ $propietarioNombre }}</div>
                  <div class="text-xs text-[var(--muted-foreground)]">Propietario verificado</div>
                </div>
              </div>

              <div class="space-y-2 text-sm">
                <div class="flex items-center gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                       viewBox="0 0 24 24" fill="none" stroke="currentColor"
                       stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                       data-lucide="mail" class="lucide lucide-mail text-[var(--muted-foreground)]">
                    <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path>
                    <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                  </svg>
                  <span class="truncate">{{ $propietarioCorreo }}</span>
                </div>
                <div class="flex items-center gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                       viewBox="0 0 24 24" fill="none" stroke="currentColor"
                       stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                       data-lucide="phone" class="lucide lucide-phone text-[var(--muted-foreground)]">
                    <path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"></path>
                  </svg>
                  <span>{{ $propietarioTelefono }}</span>
                </div>
              </div>

              @if($propietarioId)
                <a href="{{ route('propietarios.perfil', $propietarioId) }}"
                   class="btn btn-outline w-full rounded-full inline-flex items-center justify-center gap-2 text-sm">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                       viewBox="0 0 24 24" fill="none" stroke="currentColor"
                       stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                       data-lucide="user" class="lucide lucide-user">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                  </svg>
                  Ver perfil completo
                </a>
              @else
                <button type="button"
                        class="btn btn-outline w-full rounded-full text-sm opacity-60 cursor-not-allowed">
                  Perfil no disponible
                </button>
              @endif
            </div>

            <!-- Actions card -->
            <div class="bg-white rounded-2xl shadow-md p-4 space-y-2">

              @if($yaEsFavorita)
                <form method="POST" action="{{ route('favoritas.destroy', $pension) }}">
                  @csrf
                  @method('DELETE')
                  <button type="submit"
                          class="btn w-full rounded-full inline-flex items-center justify-center gap-2 text-sm bg-gray-900 text-white hover:bg-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                         viewBox="0 0 24 24" fill="currentColor" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="lucide lucide-heart">
                      <path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5"></path>
                    </svg>
                    En tus favoritas
                  </button>
                </form>
              @else
                <form method="POST" action="{{ route('favoritas.store', $pension) }}">
                  @csrf
                  <button type="submit"
                          class="btn btn-outline w-full rounded-full inline-flex items-center justify-center gap-2 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="lucide lucide-heart">
                      <path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5"></path>
                    </svg>
                    Guardar en favoritos
                  </button>
                </form>
              @endif

              <button id="share-room" type="button"
                      class="btn btn-outline w-full rounded-full inline-flex items-center justify-center gap-2 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     data-lucide="share-2" class="lucide lucide-share-2">
                  <circle cx="18" cy="5" r="3"></circle>
                  <circle cx="6" cy="12" r="3"></circle>
                  <circle cx="18" cy="19" r="3"></circle>
                  <line x1="8.59" x2="15.42" y1="13.51" y2="17.49"></line>
                  <line x1="15.41" x2="8.59" y1="6.51" y2="10.49"></line>
                </svg>
                Compartir habitación
              </button>

              <button id="report-room" type="button"
                      class="btn btn-outline w-full rounded-full inline-flex items-center justify-center gap-2 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     data-lucide="flag" class="lucide lucide-flag">
                  <path d="M4 22V4a1 1 0 0 1 .4-.8A6 6 0 0 1 8 2c3 0 5 2 7.333 2q2 0 3.067-.8A1 1 0 0 1 20 4v10a1 1 0 0 1-.4.8A6 6 0 0 1 16 16c-3 0-5-2-8-2a6 6 0 0 0-4 1.528"></path>
                </svg>
                Reportar problema
              </button>
            </div>
          </aside>
        </div>
      </div>

      {{-- MODAL GALERÍA DE FOTOS --}}
      @if($numFotos > 1)
        <div id="gallery-modal"
             class="fixed inset-0 z-40 hidden items-center justify-center bg-black/60 backdrop-blur-sm">
          <div class="bg-white max-w-4xl w-full mx-4 rounded-2xl shadow-xl overflow-hidden flex flex-col max-h-[90vh]">
            <!-- Header modal -->
            <div class="flex items-center justify-between px-4 py-3 border-b border-[var(--border)]">
              <div class="text-sm">
                <div class="font-semibold">Fotos de {{ $pension->nombre }}</div>
                <div class="text-[var(--muted-foreground)]">{{ $numFotos }} foto{{ $numFotos > 1 ? 's' : '' }}</div>
              </div>
              <button type="button" id="close-gallery"
                      class="rounded-full p-1.5 hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     data-lucide="x" class="lucide lucide-x">
                  <path d="M18 6 6 18"></path>
                  <path d="m6 6 12 12"></path>
                </svg>
              </button>
            </div>

            <!-- Contenido imágenes -->
            <div class="p-4 overflow-auto">
              <div class="grid gap-3 sm:grid-cols-2 md:grid-cols-3">
                @foreach($imagenes as $img)
                  <div class="relative group">
                    <img src="{{ $img }}"
                         alt="Foto de {{ $pension->nombre }}"
                         class="w-full h-40 object-cover rounded-xl shadow-sm group-hover:opacity-90 transition">
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      @endif

      <!-- Botón flotante de chat -->
      <button id="chat-toggle" type="button"
              class="fixed right-6 bottom-6 bg-[var(--primary)] text-white rounded-full p-3 shadow-lg flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
             viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             data-lucide="message-circle" class="lucide lucide-message-circle">
          <path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"></path>
        </svg>
      </button>
    </div>
  </main>

  {{-- ========================== --}}
  {{--            FOOTER          --}}
  {{-- ========================== --}}
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

      // Menú móvil
      const mobileMenuBtn = document.getElementById('mobileMenuBtn');
      const navSecondary = document.querySelector('.navigation');

      if (mobileMenuBtn && navSecondary) {
        mobileMenuBtn.addEventListener('click', () => {
          navSecondary.classList.toggle('hidden');
        });
      }

      // Botón volver
      const backBtn = document.getElementById('back-to-search');
      backBtn?.addEventListener('click', () => {
        if (document.referrer) {
          window.history.back();
        } else {
          window.location.href = "{{ route('buscarroom') }}";
        }
      });

      // Contactar propietario (placeholder)
      const contactOwnerBtn = document.getElementById('contact-owner');
      contactOwnerBtn?.addEventListener('click', () => {
        console.log('Contactar propietario de pensión {{ $pension->id }}');
      });

      // ----- GALERÍA -----
      const openGalleryBtn  = document.getElementById('open-gallery');
      const galleryModal    = document.getElementById('gallery-modal');
      const closeGalleryBtn = document.getElementById('close-gallery');

      if (openGalleryBtn && galleryModal) {
        openGalleryBtn.addEventListener('click', () => {
          galleryModal.classList.remove('hidden');
          galleryModal.classList.add('flex');
        });
      }

      if (closeGalleryBtn && galleryModal) {
        closeGalleryBtn.addEventListener('click', () => {
          galleryModal.classList.add('hidden');
          galleryModal.classList.remove('flex');
        });
      }

      if (galleryModal) {
        galleryModal.addEventListener('click', (e) => {
          if (e.target === galleryModal) {
            galleryModal.classList.add('hidden');
            galleryModal.classList.remove('flex');
          }
        });

        document.addEventListener('keydown', (e) => {
          if (e.key === 'Escape' && !galleryModal.classList.contains('hidden')) {
            galleryModal.classList.add('hidden');
            galleryModal.classList.remove('flex');
          }
        });
      }
    });
  </script>

</body>
</html>
