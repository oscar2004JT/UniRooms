{{-- resources/views/reservar-habitacion.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar {{ $pension->nombre }} - UniRooms</title>

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

    $precio = $pension->precio;
@endphp

<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- HEADER / NAV ESTUDIANTE --}}
    <header class="bg-gradient-to-r from-blue-700 to-blue-500 text-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-20">

                <a href="{{ route('buscarroom') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-md bg-white/20 flex items-center justify-center">
                        <i data-lucide="home" class="text-white"></i>
                    </div>
                    <span class="font-semibold text-xl">UniRooms</span>
                </a>

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
                            <div class="inline-flex items-center bg-white/10 rounded-full p-1">
                                <button class="px-4 py-2 rounded-full font-medium shadow-sm {{ $rol == 1 ? 'bg-white text-blue-700' : 'text-white/80' }}">
                                    Estudiante
                                </button>

                                <button class="px-4 py-2 rounded-full font-medium shadow-sm {{ $rol == 2 ? 'bg-white text-blue-700' : 'text-white/80' }}">
                                    Propietario
                                </button>
                            </div>

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

                    <button id="mobileMenuBtn" class="ml-2 md:hidden p-2 rounded-md hover:bg-white/10">
                        <i data-lucide="menu"></i>
                    </button>
                </nav>
            </div>
        </div>
    </header>

    {{-- NAV SECUNDARIA ESTUDIANTE --}}
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

    {{-- CONTENIDO PRINCIPAL --}}
    <main class="flex-1">
        <div class="max-w-4xl mx-auto px-4 py-6 space-y-5">

            <div class="flex items-center gap-3 mb-1">
                <div class="truncate">
                    <h1 class="text-lg font-semibold truncate">
                        Reservar: {{ $pension->nombre }}
                    </h1>
                    <p class="text-sm text-[var(--muted-foreground)] flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="lucide lucide-map-pin">
                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span class="truncate">{{ $pension->ubicacion_especifica }} - {{ $zonaNombre }}</span>
                    </p>
                </div>
            </div>

            {{-- Resumen de la habitación --}}
            <section class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="grid md:grid-cols-[1.3fr_minmax(0,1fr)]">
                    <div class="relative">
                        <img src="{{ $imagenPrincipal }}"
                             alt="{{ $pension->nombre }}"
                             class="w-full h-full max-h-[260px] object-cover">
                        <div class="absolute top-3 left-3 bg-black/60 text-white text-xs px-2 py-1 rounded-full flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="lucide lucide-home">
                                <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path>
                                <path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            </svg>
                            {{ $tipoNombre }}
                        </div>
                    </div>

                    <div class="p-4 space-y-2 flex flex-col justify-between">
                        <div>
                            <h2 class="text-base font-semibold">{{ $pension->nombre }}</h2>
                            <p class="text-xs text-[var(--muted-foreground)] line-clamp-3 mt-1">
                                {{ $pension->descripcion }}
                            </p>

                            <div class="mt-3 flex flex-wrap items-center gap-3 text-xs text-[var(--muted-foreground)]">
                                <span class="inline-flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                         class="lucide lucide-users">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                        <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                    </svg>
                                    {{ $pension->capacidad }} persona{{ $pension->capacidad > 1 ? 's' : '' }}
                                </span>
                                <span class="text-gray-300">•</span>
                                <span class="inline-flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                         class="lucide lucide-map-pin">
                                        <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>
                                    {{ $zonaNombre }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-end justify-between mt-2">
                            <div class="text-xs text-[var(--muted-foreground)]">
                                <span class="block">Precio mensual</span>
                                <span class="text-lg font-bold text-[var(--primary)]">
                                    $ {{ number_format($precio, 0, ',', '.') }}
                                </span>
                            </div>
                            <div>
                                <span class="inline-flex items-center gap-1 text-xs text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                         class="lucide lucide-badge-check">
                                        <path d="M3.5 9a6.5 6.5 0 0 1 13 0c0 2.761-1.833 5.09-4.365 6.025L12 21l-2.135-5.975A6.502 6.502 0 0 1 3.5 9Z"></path>
                                        <path d="m9 9.5 1.5 1.5 3-3"></path>
                                    </svg>
                                    Reserva segura
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Formulario de reserva --}}
            <section class="bg-white rounded-2xl shadow-md p-5 space-y-5">
                <div class="flex items-center justify-between gap-2">
                    <h2 class="text-lg font-semibold">Datos de la reserva</h2>
                    <p class="text-xs text-[var(--muted-foreground)]">
                        Completa la información para enviar tu solicitud de arriendo.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-xs text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('arriendos.store') }}" class="space-y-4">
                    @csrf

                    <input type="hidden" name="id_pension" value="{{ $pension->id }}">
                    <input type="hidden" name="id_estudiante" value="{{ $usuario->id_estudiante ?? '' }}">

                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label for="fecha_inicio" class="text-sm font-medium">Fecha de inicio</label>
                            <input type="date"
                                   id="fecha_inicio"
                                   name="fecha_inicio"
                                   value="{{ old('fecha_inicio') }}"
                                   class="w-full rounded-xl border border-[var(--border)] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary)] focus:border-[var(--primary)]">
                        </div>

                        <div class="space-y-1.5">
                            <label for="fecha_fin" class="text-sm font-medium">
                                Fecha de fin <span class="text-xs text-[var(--muted-foreground)]">(opcional)</span>
                            </label>
                            <input type="date"
                                   id="fecha_fin"
                                   name="fecha_fin"
                                   value="{{ old('fecha_fin') }}"
                                   class="w-full rounded-xl border border-[var(--border)] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary)] focus:border-[var(--primary)]">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label for="mensaje" class="text-sm font-medium">
                            Mensaje para el propietario <span class="text-xs text-[var(--muted-foreground)]">(opcional)</span>
                        </label>
                        <textarea id="mensaje"
                                  name="mensaje"
                                  rows="3"
                                  class="w-full rounded-xl border border-[var(--border)] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary)] focus:border-[var(--primary)]"
                                  placeholder="Preséntate brevemente, indica desde cuándo deseas arrendar, si vienes a estudiar, etc.">{{ old('mensaje') }}</textarea>
                    </div>

                    <div class="rounded-2xl bg-[var(--muted)] px-4 py-3 text-sm flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="font-medium">Resumen estimado (sin contratos aún)</p>
                            <p class="text-xs text-[var(--muted-foreground)]">
                                El propietario deberá confirmar tu solicitud antes de que el arriendo sea efectivo.
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-[var(--muted-foreground)]">Precio mensual</p>
                            <p class="text-lg font-semibold text-[var(--primary)]">
                                $ {{ number_format($precio, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-2">
                        <p class="text-xs text-[var(--muted-foreground)] max-w-md">
                            Al enviar la solicitud, el propietario recibirá tus datos y podrá aceptar o rechazar la reserva.
                            No se realiza ningún cobro automático desde UniRooms.
                        </p>

                        <button type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-full bg-[var(--primary)] px-5 py-2.5 text-sm font-medium text-white shadow hover:bg-[color-mix(in_srgb,var(--primary)_80%,black_20%)] transition">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="lucide lucide-calendar-check">
                                <path d="M8 2v4"></path>
                                <path d="M16 2v4"></path>
                                <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                <path d="M3 10h18"></path>
                                <path d="m9 16 2 2 4-4"></path>
                            </svg>
                            Enviar solicitud de reserva
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </main>

    {{-- FOOTER --}}
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
            const userDropdown = document.getElementById('userDropdown');

            if (userMenuBtn && userDropdown) {
                userMenuBtn.addEventListener('click', () => {
                    userDropdown.classList.toggle('hidden');
                });

                document.addEventListener('click', (e) => {
                    if (!userMenuBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                        userDropdown.classList.add('hidden');
                    }
                });
            }

            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const navSecondary = document.querySelector('.navigation');

            if (mobileMenuBtn && navSecondary) {
                navSecondary.classList.remove('hidden');
                mobileMenuBtn.addEventListener('click', () => {
                    navSecondary.classList.toggle('hidden');
                });
            }
        });
    </script>

</body>
</html>
