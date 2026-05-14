{{-- resources/views/pension-edit.blade.php --}}
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Editar Habitación — UniRooms</title>

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

      <a href="{{ route('propietario.habitaciones') }}" id="nav-mishabitaciones" class="nav-link active">
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

      <a href="{{ route('propietario.solicitudes') }}" id="nav-solicitudes" class="nav-link">
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
  {{--           MAIN             --}}
  {{-- ========================== --}}
  @php
    // IDs de amenidades seleccionadas (ajusta según tu modelo/relación)
    $amenitiesSeleccionadas = isset($amenitiesSeleccionadas)
      ? (array) $amenitiesSeleccionadas
      : (isset($pension->amenities) && $pension->amenities instanceof \Illuminate\Support\Collection
          ? $pension->amenities->pluck('id')->toArray()
          : []);
  @endphp

  <main class="flex-1">
    <div class="container mx-auto px-4 py-10 max-w-5xl">
      <div style="min-height:100vh; background:transparent;">
        <div class="max-w-3xl mx-auto">
          <!-- Header del formulario -->
          <div class="text-center mb-10">

            <div style="width:64px;height:64px;margin:0 auto 0.75rem;background:var(--primary);border-radius:9999px;display:flex;align-items:center;justify-content:center;color:white;">
              <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                   viewBox="0 0 24 24" fill="none" stroke="currentColor"
                   stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 5h10"></path>
                <path d="M11 9h7"></path>
                <path d="M11 13h4"></path>
                <path d="M3 17l3 3 3-3"></path>
                <path d="M6 18V4"></path>
              </svg>
            </div>

            <h1>Editar habitación</h1>
            <p class="mt-2" style="color:var(--muted-foreground); font-size:1.05rem;">
              Actualiza la información de tu publicación
            </p>
          </div>

          <!-- Form -->
          <div class="card p-8">
            <div id="alert-container" class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md space-y-2">

              @if(session('success'))
                <div class="alert flex items-center gap-3 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg shadow-md">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none"
                       viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 13l4 4L19 7" />
                  </svg>
                  <span class="font-medium">{{ session('success') }}</span>
                </div>
              @endif

              @if(session('error'))
                <div class="alert flex items-center gap-3 bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg shadow-md">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none"
                       viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                  </svg>
                  <span class="font-medium">{{ session('error') }}</span>
                </div>
              @endif

              @if($errors->any())
                <div class="alert bg-red-50 border border-red-300 text-red-800 px-4 py-3 rounded-lg shadow-md">
                  <strong class="block mb-2">¡Atención!</strong>
                  <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

            </div>

            <form id="edit-room-form"
                  action="{{ route('pension.update', $pension) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  novalidate>
              @csrf
              @method('PUT')

              {{-- Información básica --}}
              <div class="mb-8">
                <h3 class="mb-4 text-[var(--primary)] flex items-center gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                       viewBox="0 0 24 24" fill="none" stroke="currentColor"
                       stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 16v-4"></path>
                    <path d="M12 8h.01"></path>
                  </svg>
                  Información Básica
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div>
                    <label for="room-title" class="block text-sm font-medium mb-2">
                      Título de la habitación *
                    </label>
                    <input
                      id="room-title"
                      name="nombre"
                      class="input"
                      type="text"
                      value="{{ old('nombre', $pension->nombre) }}"
                      placeholder="Ej: Habitación acogedora cerca del campus"
                      required
                    >
                    <small style="color:var(--muted-foreground);">
                      Escribe un título atractivo que describa tu habitación
                    </small>
                  </div>

                  <div>
                    <label for="room-price" class="block text-sm font-medium mb-2">
                      Precio mensual (COP) *
                    </label>
                    <input
                      id="room-price"
                      name="precio"
                      class="input"
                      type="number"
                      min="0"
                      value="{{ old('precio', $pension->precio) }}"
                      required
                    >
                    <small style="color:var(--muted-foreground);">
                      Precio competitivo según la zona
                    </small>
                  </div>
                </div>
              </div>

              {{-- Ubicación --}}
              <div class="mb-8">
                <h3 class="mb-4 text-[var(--primary)] flex items-center gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                       viewBox="0 0 24 24" fill="none" stroke="currentColor"
                       stroke-width="2">
                    <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                  </svg>
                  Ubicación
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div>
                    <label for="room-zone" class="block text-sm font-medium mb-2">
                      Zona *
                    </label>
                    <select id="room-zone" name="id_zona" class="select input" required>
                      <option value="">Selecciona una zona</option>
                      @foreach($zonas as $zona)
                        <option
                          value="{{ $zona->id }}"
                          {{ (string)old('id_zona', $pension->id_zona) === (string)$zona->id ? 'selected' : '' }}
                        >
                          {{ $zona->nombre }}
                        </option>
                      @endforeach
                    </select>
                  </div>

                  <div>
                    <label for="room-location" class="block text-sm font-medium mb-2">
                      Ubicación específica *
                    </label>
                    <input
                      id="room-location"
                      name="ubicacion_especifica"
                      class="input"
                      type="text"
                      value="{{ old('ubicacion_especifica', $pension->ubicacion_especifica) }}"
                      placeholder="Ej: Cerca al Campus Principal, Estación del Metro"
                      required
                    >
                  </div>
                </div>
              </div>

              {{-- Detalles habitación --}}
              <div class="mb-8">
                <h3 class="mb-4 text-[var(--primary)] flex items-center gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                       viewBox="0 0 24 24" fill="none" stroke="currentColor"
                       stroke-width="2">
                    <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path>
                    <path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                  </svg>
                  Detalles de la Habitación
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div>
                    <label for="room-type" class="block text-sm font-medium mb-2">
                      Tipo de habitación *
                    </label>
                    <select id="room-type" name="id_tipo_habitacion" class="select input" required>
                      <option value="">Selecciona un tipo</option>
                      @foreach($tiposHabitacion as $tipo)
                        <option
                          value="{{ $tipo->id }}"
                          {{ (string)old('id_tipo_habitacion', $pension->id_tipo_habitacion) === (string)$tipo->id ? 'selected' : '' }}
                        >
                          {{ $tipo->nombre }}
                        </option>
                      @endforeach
                    </select>
                  </div>

                  <div>
                    <label for="room-occupancy" class="block text-sm font-medium mb-2">
                      Capacidad máxima *
                    </label>
                    <select id="room-occupancy" name="capacidad" class="select input" required>
                      <option value="">Selecciona capacidad</option>
                      @for($i = 1; $i <= 6; $i++)
                        <option
                          value="{{ $i }}"
                          {{ (int)old('capacidad', $pension->capacidad) === $i ? 'selected' : '' }}
                        >
                          {{ $i }} persona{{ $i > 1 ? 's' : '' }}
                        </option>
                      @endfor
                    </select>
                  </div>
                </div>
              </div>

              {{-- Descripción --}}
              <div class="mb-8">
                <h3 class="mb-4 text-[var(--primary)] flex items-center gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                       viewBox="0 0 24 24" fill="none" stroke="currentColor"
                       stroke-width="2">
                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                  </svg>
                  Descripción
                </h3>

                <div>
                  <label for="room-description" class="block text-sm font-medium mb-2">
                    Descripción detallada *
                  </label>
                  <textarea
                    id="room-description"
                    name="descripcion"
                    class="input"
                    rows="6"
                    required
                    style="height:auto; resize:vertical;"
                  >{{ old('descripcion', $pension->descripcion) }}</textarea>
                  <small style="color:var(--muted-foreground);">
                    Mínimo 100 caracteres para una descripción completa
                  </small>
                </div>
              </div>

              {{-- Servicios / amenities --}}
              <div class="mb-8">
                <h3 class="mb-4 text-[var(--primary)] flex items-center gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                       viewBox="0 0 24 24" fill="none" stroke="currentColor"
                       stroke-width="2">
                    <path d="M21 10.656V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h12.344"></path>
                    <path d="m9 11 3 3L22 4"></path>
                  </svg>
                  Servicios Incluidos
                  <span id="amenities-count" class="ml-2 text-sm" style="color:var(--muted-foreground)"></span>
                </h3>





<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px,1fr)); gap:1rem; background:var(--muted); padding:1.25rem; border-radius:var(--radius);">
  @for ($idAmenity = 1; $idAmenity <= 12; $idAmenity++)
    @php
      $labelAmenity = match($idAmenity) {
        1  => 'Wi-Fi',
        2  => 'Escritorio',
        3  => 'Closet',
        4  => 'Calefacción',
        5  => 'Cocina',
        6  => 'Baño Privado',
        7  => 'Lavandería',
        8  => 'Parqueadero',
        9  => 'Sala Común',
        10 => 'Jardín',
        11 => 'Gimnasio',
        12 => 'Sala de Estudio',
        default => 'Servicio',
      };
    @endphp

    <label class="amenity-label flex items-center gap-3 p-2 rounded" style="cursor:pointer;">
      <input
        type="checkbox"
        name="amenities[]"
        value="{{ $idAmenity }}"
        class="amenity-checkbox"
        style="margin:0;"
        {{ in_array($idAmenity, old('amenities', $amenitiesSeleccionadas ?? [])) ? 'checked' : '' }}
      >

      {{-- Ícono según el ID, mismos que enviaste --}}
      @switch($idAmenity)
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
      @endswitch

      <span>{{ $labelAmenity }}</span>
    </label>
  @endfor
</div>

















                <small style="color:var(--muted-foreground); display:block; margin-top:0.5rem;">
                  Selecciona todos los servicios que incluye tu habitación
                </small>
              </div>

              {{-- Imágenes --}}
              <div class="mb-8 mt-6">
                <h3 class="mb-4 text-[var(--primary)] flex items-center gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                       viewBox="0 0 24 24" fill="none" stroke="currentColor"
                       stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                    <circle cx="8.5" cy="8.5" r="1.5"/>
                    <path d="M21 15l-5-5L5 21"></path>
                  </svg>
                  Imágenes de la habitación
                </h3>

                {{-- Imágenes actuales --}}
                @php
                  $imagenesActuales = $pension->link_foto ?? [];
                  if (!is_array($imagenesActuales)) {
                    $imagenesActuales = [];
                  }
                @endphp

                @if(count($imagenesActuales))
                  <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">Imágenes actuales:</p>
                    <div class="flex flex-wrap gap-3">
                      @foreach($imagenesActuales as $img)
                        <img src="{{ $img }}"
                             alt="Imagen actual"
                             class="w-24 h-24 object-cover rounded-lg border">
                      @endforeach
                    </div>
                  </div>
                @endif

                <input type="file" id="imagenes" name="imagenes[]" multiple accept="image/*" class="input">
                <small style="color:var(--muted-foreground);">
                  Puedes subir nuevas imágenes (JPG, PNG, WEBP). Si subes nuevas, se actualizarán junto con la publicación.
                </small>

                <div id="preview" class="flex flex-wrap gap-3 mt-4"></div>
              </div>

              {{-- (Opcional) Estado de la publicación --}}
              <div class="mb-8">
                <h3 class="mb-4 text-[var(--primary)] flex items-center gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                       viewBox="0 0 24 24" fill="none" stroke="currentColor"
                       stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 8v8"></path>
                    <path d="M8 12h8"></path>
                  </svg>
                  Estado de la publicación
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <label class="flex items-center gap-2">
                    <input
                      type="radio"
                      name="id_estado"
                      value="1"
                      {{ (int)old('id_estado', $pension->id_estado ?? 1) === 1 ? 'checked' : '' }}
                    >
                    <span>Borrador (no visible para estudiantes)</span>
                  </label>

                  <label class="flex items-center gap-2">
                    <input
                      type="radio"
                      name="id_estado"
                      value="2"
                      {{ (int)old('id_estado', $pension->id_estado ?? 2) === 2 ? 'checked' : '' }}
                    >
                    <span>Publicada (visible para estudiantes)</span>
                  </label>
                </div>
              </div>

              {{-- Acciones --}}
              <div class="flex justify-center gap-4 flex-wrap">
                <button type="submit" class="btn btn-primary">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                       viewBox="0 0 24 24" fill="none" stroke="currentColor"
                       stroke-width="2">
                    <path d="M20 6 9 17l-5-5"></path>
                  </svg>
                  Guardar cambios
                </button>

                <a href="{{ route('propietario.habitaciones') }}" class="btn btn-outline">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                       viewBox="0 0 24 24" fill="none" stroke="currentColor"
                       stroke-width="2">
                    <path d="M15 18l-6-6 6-6"></path>
                  </svg>
                  Volver a mis habitaciones
                </a>
              </div>
            </form>
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

      const mobileMenuBtn = document.getElementById('mobileMenuBtn');
      const navSecondary = document.querySelector('.navigation');

      if (mobileMenuBtn && navSecondary) {
        mobileMenuBtn.addEventListener('click', () => {
          navSecondary.classList.toggle('hidden');
        });
      }
    });

    // Alertas auto-cierre
    document.addEventListener('DOMContentLoaded', () => {
      const alerts = document.querySelectorAll('#alert-container .alert');
      alerts.forEach(alert => {
        setTimeout(() => {
          alert.style.transition = "opacity 0.5s";
          alert.style.opacity = '0';
          setTimeout(() => alert.remove(), 500);
        }, 20000);
      });
    });

    // Preview imágenes nuevas
    const input = document.getElementById('imagenes');
    const preview = document.getElementById('preview');
    if (input) {
      input.addEventListener('change', () => {
        preview.innerHTML = '';
        const files = input.files;
        if (!files.length) return;
        [...files].forEach(file => {
          if (!file.type.startsWith('image/')) return;
          const reader = new FileReader();
          reader.onload = e => {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('w-24', 'h-24', 'object-cover', 'rounded-lg', 'border');
            preview.appendChild(img);
          };
          reader.readAsDataURL(file);
        });
      });
    }

    // Amenidades: contador y resaltado
    (function(){
      const checkboxes = document.querySelectorAll('.amenity-checkbox');
      const countEl = document.getElementById('amenities-count');

      function refreshCount(){
        const checked = document.querySelectorAll('.amenity-checkbox:checked').length;
        countEl.textContent = checked ? `(${checked} seleccionados)` : '';
      }

      checkboxes.forEach(cb => {
        const label = cb.closest('.amenity-label');
        if(!label) return;
        if(cb.checked) label.classList.add('amenity-active');

        cb.addEventListener('change', () => {
          label.classList.toggle('amenity-active', cb.checked);
          refreshCount();
        });

        label.addEventListener('click', (e)=> {
          if (e.target.tagName.toLowerCase() === 'input') return;
          cb.checked = !cb.checked;
          label.classList.toggle('amenity-active', cb.checked);
          refreshCount();
          e.preventDefault();
        });
      });

      refreshCount();
    })();
  </script>
</body>
</html>
