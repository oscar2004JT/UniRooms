<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>UniRooms - Alojamiento Universitario</title>

  <!-- Tailwind y Lucide -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

  <!-- Estilos (puedes mantener tus archivos si existen) -->
  <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
  <link rel="stylesheet" href="{{ asset('css/components.css') }}">
  <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
  <link rel="stylesheet" href="{{ asset('css/globals2.css') }}">

  <style>
    /* Ajustes pequeños adicionales */
    .hero-title { font-size: clamp(2rem, 4.5vw, 4rem); }
    .hero-subtitle { max-width: 820px; margin: 0 auto; }
    /* Sombra para el botón flotante */
    .chat-fab { box-shadow: 0 10px 30px rgba(20,60,120,0.25); }
  </style>
</head>
<body class="min-h-screen bg-gray-50 flex flex-col">

  <!-- NAV -->
  <header class="bg-gradient-to-r from-blue-700 to-blue-500 text-white">
    <div class="max-w-7xl mx-auto px-4">
      <div class="flex items-center justify-between h-20">
        <!-- Logo -->
        <a href="#" class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-md bg-white/20 flex items-center justify-center">
            <i data-lucide="home" class="text-white"></i>
          </div>
          <span class="font-semibold text-xl">UniRooms</span>
        </a>

        
        <nav class="flex items-center gap-3">
  @guest
    <!-- Solo mostrar cuando NO está logueado -->
    <a href="{{ route('login') }}" 
       class="ml-4 inline-block bg-transparent border border-white/60 text-white font-medium rounded-md px-4 py-2 hover:bg-white/10 transition">
      Iniciar Sesión
    </a>
    <a href="{{ route('register') }}" 
       class="ml-2 inline-block bg-transparent border border-white/60 text-white font-medium rounded-md px-4 py-2 hover:bg-white/10 transition">
      Registrarse
    </a>
  @else
    <!-- Mostrar solo cuando SÍ está logueado -->
    @php 
      $rol = Auth::user()->id_rol; // 1 = Estudiante, 2 = Propietario
    @endphp 

    <div class="flex items-center gap-4 relative">
      <!-- Selector de rol -->
      <div class="inline-flex items-center bg-white/10 rounded-full p-1">
        <button class="px-4 py-2 rounded-full font-medium shadow-sm
            {{ $rol == 1 ? 'bg-white text-blue-700' : 'text-white/80' }}">
          Estudiante
        </button>
        <button class="px-4 py-2 rounded-full font-medium shadow-sm
            {{ $rol == 2 ? 'bg-white text-blue-700' : 'text-white/80' }}">
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

        <!-- Menú desplegable -->
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

  <!-- Botón menú móvil -->
  <button id="mobileMenuBtn" class="ml-2 md:hidden p-2 rounded-md hover:bg-white/10">
    <i data-lucide="menu"></i>
  </button>
</nav>

<!-- Script simple para mostrar/ocultar el dropdown -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const userMenuBtn = document.getElementById('userMenuBtn');
    const dropdown = document.getElementById('userDropdown');

    userMenuBtn?.addEventListener('click', () => {
      dropdown.classList.toggle('hidden');
    });

    // Cierra el dropdown al hacer clic fuera
    document.addEventListener('click', (e) => {
      if (!userMenuBtn.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.classList.add('hidden');
      }
    });
  });
</script>





      </div>
    </div>
  </header>

  <div id="app" class="flex-1">

    <!-- Hero Section -->
    <section class="hero-section text-center py-20 bg-gradient-to-r from-blue-900 to-blue-600 text-white">
      <div class="max-w-4xl mx-auto px-4">
        <h1 class="hero-title font-bold mb-4">Encuentra tu Hogar Universitario Perfecto</h1>
        <p class="hero-subtitle text-lg mb-6">
          Conectamos estudiantes con alojamientos verificados en las mejores zonas universitarias de Medellín
        </p>
        <div class="hero-buttons flex flex-wrap justify-center gap-4">
          <button id="btn-search-rooms" class="btn btn-primary btn-lg bg-white text-blue-900 font-semibold px-6 py-3 rounded-lg inline-flex items-center gap-2">
            <i data-lucide="search" class="inline"></i>
            Buscar Habitaciones
          </button>

          <form action="{{ route('addroom') }}" method="get">
    <button type="submit" 
            id="btn-publish-room" 
            class="btn btn-outline btn-lg text-white border-white/60 font-semibold px-6 py-3 rounded-lg inline-flex items-center gap-2">
        Agregar Habitación
    </button>
</form>



        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-white">
      <div class="max-w-6xl mx-auto text-center px-4">
        <h2 class="text-3xl font-bold mb-4">¿Por qué elegir UniRooms?</h2>
        <p class="text-gray-500 mb-12 text-lg">La plataforma más confiable para alojamiento estudiantil</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="feature-card p-6 rounded-lg shadow hover:shadow-lg transition">
            <div class="feature-icon mb-4 text-blue-600">
              <i data-lucide="home"></i>
            </div>
            <h3 class="font-semibold mb-2">Habitaciones Verificadas</h3>
            <p class="text-gray-500">Encuentra alojamientos con verificación garantizada.</p>
          </div>
          <div class="feature-card p-6 rounded-lg shadow hover:shadow-lg transition">
            <div class="feature-icon mb-4 text-blue-600">
              <i data-lucide="map"></i>
            </div>
            <h3 class="font-semibold mb-2">Zonas Estratégicas</h3>
            <p class="text-gray-500">A pocos minutos de las principales universidades.</p>
          </div>
          <div class="feature-card p-6 rounded-lg shadow hover:shadow-lg transition">
            <div class="feature-icon mb-4 text-blue-600">
              <i data-lucide="shield"></i>
            </div>
            <h3 class="font-semibold mb-2">Seguridad y Confianza</h3>
            <p class="text-gray-500">Propietarios verificados y procesos transparentes.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Zones Section -->
    <section class="py-20 bg-gray-100 text-center">
      <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-bold mb-4">Zonas Disponibles</h2>
        <p class="text-gray-500 mb-8">Encuentra habitaciones en las mejores ubicaciones universitarias</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
          <!-- Si usas blade o similar, conserva tu foreach. Aquí incluyo ejemplos estáticos -->
          <div class="card bg-white p-6 rounded-lg shadow hover:shadow-lg cursor-pointer transition">
            <div class="w-12 h-12 mx-auto mb-4 bg-blue-600 text-white rounded-full flex items-center justify-center">
              <i data-lucide="map-pin"></i>
            </div>
            <h4 class="font-semibold">El Poblado</h4>
            <p class="text-gray-500 text-sm">Habitaciones disponibles</p>
          </div>
          <div class="card bg-white p-6 rounded-lg shadow hover:shadow-lg cursor-pointer transition">
            <div class="w-12 h-12 mx-auto mb-4 bg-blue-600 text-white rounded-full flex items-center justify-center">
              <i data-lucide="map-pin"></i>
            </div>
            <h4 class="font-semibold">Belén</h4>
            <p class="text-gray-500 text-sm">Habitaciones disponibles</p>
          </div>
          <div class="card bg-white p-6 rounded-lg shadow hover:shadow-lg cursor-pointer transition">
            <div class="w-12 h-12 mx-auto mb-4 bg-blue-600 text-white rounded-full flex items-center justify-center">
              <i data-lucide="map-pin"></i>
            </div>
            <h4 class="font-semibold">Laureles</h4>
            <p class="text-gray-500 text-sm">Habitaciones disponibles</p>
          </div>
          <div class="card bg-white p-6 rounded-lg shadow hover:shadow-lg cursor-pointer transition">
            <div class="w-12 h-12 mx-auto mb-4 bg-blue-600 text-white rounded-full flex items-center justify-center">
              <i data-lucide="map-pin"></i>
            </div>
            <h4 class="font-semibold">Envigado</h4>
            <p class="text-gray-500 text-sm">Habitaciones disponibles</p>
          </div>
          <div class="card bg-white p-6 rounded-lg shadow hover:shadow-lg cursor-pointer transition">
            <div class="w-12 h-12 mx-auto mb-4 bg-blue-600 text-white rounded-full flex items-center justify-center">
              <i data-lucide="map-pin"></i>
            </div>
            <h4 class="font-semibold">Estadio</h4>
            <p class="text-gray-500 text-sm">Habitaciones disponibles</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-20 bg-white">
      <div class="max-w-6xl mx-auto grid grid-cols-2 sm:grid-cols-4 text-center gap-8 px-4">
        <div>
          <div class="text-4xl font-bold text-blue-600 mb-2">500+</div>
          <p class="text-gray-500">Habitaciones Verificadas</p>
        </div>
        <div>
          <div class="text-4xl font-bold text-blue-600 mb-2">1,200+</div>
          <p class="text-gray-500">Estudiantes Satisfechos</p>
        </div>
        <div>
          <div class="text-4xl font-bold text-blue-600 mb-2">50+</div>
          <p class="text-gray-500">Propietarios de Confianza</p>
        </div>
        <div>
          <div class="text-4xl font-bold text-blue-600 mb-2">5</div>
          <p class="text-gray-500">Zonas Universitarias</p>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 text-center text-white" style="background: linear-gradient(135deg, #1e40af, #3b82f6);">
      <div class="max-w-3xl mx-auto px-4">
        <h2 class="text-3xl font-bold mb-4">¿Listo para encontrar tu nuevo hogar?</h2>
        <p class="text-lg opacity-90 mb-8">Únete a miles de estudiantes que ya encontraron su alojamiento perfecto</p>
        <div class="flex flex-wrap justify-center gap-4">
          <a href="#" class="btn bg-white text-blue-900 font-semibold px-6 py-3 rounded-lg flex items-center gap-2">
            <i data-lucide="arrow-right"></i> Comenzar Búsqueda
          </a>
          <a href="#" class="btn border border-white text-white font-semibold px-6 py-3 rounded-lg flex items-center gap-2">
            <i data-lucide="info"></i> Saber Más
          </a>
        </div>
      </div>
    </section>

  </div> <!-- fin app -->

  <!-- Footer -->
  <footer class="bg-gray-900 text-gray-200">
    <div class="max-w-7xl mx-auto px-6 py-16">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
          <h3 class="text-white font-semibold mb-3">RoomFinder</h3>
          <p class="text-gray-400 leading-relaxed">
            La plataforma líder para encontrar alojamiento universitario.
            Conectamos estudiantes con propietarios de confianza en las mejores zonas de la ciudad.
          </p>
        </div>

        <div>
          <h4 class="text-white font-semibold mb-3">Zonas Disponibles</h4>
          <ul class="space-y-2 text-gray-400">
            <li>Villa Marbella</li>
            <li>Los Laureles</li>
            <li>Las Malvinas</li>
            <li>Santana</li>
            <li>Villa Marina</li>
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
            <div class="flex items-center gap-3"><i data-lucide="phone" class="text-gray-300"></i> <span>+57 (300) 123-4567</span></div>
            <div class="flex items-center gap-3"><i data-lucide="mail" class="text-gray-300"></i> <span>info@roomfinder.co</span></div>
            <div class="flex items-center gap-3"><i data-lucide="map-pin" class="text-gray-300"></i> <span>Medellín, Colombia</span></div>
            <div class="flex items-center gap-3 mt-2">
              <a href="#" class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-white/10 hover:bg-white/20"><i data-lucide="facebook" class="text-white"></i></a>
              <a href="#" class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-white/10 hover:bg-white/20"><i data-lucide="twitter" class="text-white"></i></a>
              <a href="#" class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-white/10 hover:bg-white/20"><i data-lucide="instagram" class="text-white"></i></a>
              <a href="#" class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-white/10 hover:bg-white/20"><i data-lucide="message-circle" class="text-white"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="border-t border-gray-800">
      <div class="max-w-7xl mx-auto px-6 py-4 text-center text-gray-500 text-sm">
        © 2024 RoomFinder. Todos los derechos reservados. | Términos de Servicio | Política de Privacidad
      </div>
    </div>
  </footer>

  <!-- Floating chat button -->
  <button id="chatFab" class="chat-fab fixed bottom-6 right-6 w-14 h-14 rounded-full bg-blue-600 text-white flex items-center justify-center shadow-lg hover:scale-105 transition z-50">
    <i data-lucide="message-circle" class="w-6 h-6"></i>
  </button>

  <script>
    // Inicializa iconos lucide
    lucide.createIcons();

    // Ejemplo de interacción simple para el botón móvil (mostrar/ocultar)
    const mobileBtn = document.getElementById('mobileMenuBtn');
    mobileBtn && mobileBtn.addEventListener('click', () => {
      // En proyecto real: mostrar menú mobile. Aquí lo dejamos como ejemplo.
      alert('Aquí abriría el menú móvil (implementa tu menú).');
    });

    // Comportamiento para botones de cabecera (ejemplo)
    document.getElementById('btn-estudiante')?.addEventListener('click', () => {
      // redirige o muestra modal:
      alert('Acción Estudiante (redirigir a área de estudiantes).');
    });
    document.getElementById('btn-propietario')?.addEventListener('click', () => {
      alert('Acción Propietario (redirigir a área de propietarios).');
    });
    document.getElementById('btn-register')?.addEventListener('click', () => {
      window.location.href = "{{ route('register') }}";
    });
    document.getElementById('btn-login')?.addEventListener('click', () => {
       window.location.href = "{{ route('login') }}";
    });

    // Chat FAB
    document.getElementById('chatFab')?.addEventListener('click', () => {
      // Abrir widget de chat o modal aquí
      alert('Abrir chat / WhatsApp / widget de atención.');
    });
  </script>

</body>
</html>
