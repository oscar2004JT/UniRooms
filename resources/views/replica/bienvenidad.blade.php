<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UniRooms - Alojamiento Universitario</title>

  <!-- Tailwind y Lucide -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

  <!-- Estilos -->
  <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
  <link rel="stylesheet" href="{{ asset('css/components.css') }}">
  <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
</head>
<body>
  <div id="app" class="min-h-screen bg-gray-50 flex flex-col">

    <!-- Hero Section -->
    <section class="hero-section text-center py-20 bg-gradient-to-r from-blue-900 to-blue-600 text-white">
      <div class="max-w-4xl mx-auto px-4">
        <h1 class="hero-title text-4xl font-bold mb-4">Encuentra tu Hogar Universitario Perfecto</h1>
        <p class="hero-subtitle text-lg mb-6">
          Conectamos estudiantes con alojamientos verificados en las mejores zonas universitarias de Medellín
        </p>
        <div class="hero-buttons flex flex-wrap justify-center gap-4">
          <button id="btn-search-rooms" class="btn btn-primary btn-lg bg-white text-blue-900 font-semibold px-6 py-3 rounded-lg">
            <i data-lucide="search" class="inline mr-2"></i>
            Buscar Habitaciones
          </button>
          <button id="btn-publish-room" class="btn btn-outline btn-lg text-white border-white font-semibold px-6 py-3 rounded-lg">
            <i data-lucide="plus-circle" class="inline mr-2"></i>
            Publicar Habitación
          </button>
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
      <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold mb-4">Zonas Disponibles</h2>
        <p class="text-gray-500 mb-8">Encuentra habitaciones en las mejores ubicaciones universitarias</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 px-4">
          @foreach (['El Poblado', 'Belén', 'Laureles', 'Envigado', 'Estadio'] as $zona)
            <div class="card bg-white p-6 rounded-lg shadow hover:shadow-lg cursor-pointer transition">
              <div class="w-12 h-12 mx-auto mb-4 bg-blue-600 text-white rounded-full flex items-center justify-center">
                <i data-lucide="map-pin"></i>
              </div>
              <h4 class="font-semibold">{{ $zona }}</h4>
              <p class="text-gray-500 text-sm">Habitaciones disponibles</p>
            </div>
          @endforeach
        </div>
      </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-20 bg-white">
      <div class="max-w-6xl mx-auto grid grid-cols-2 sm:grid-cols-4 text-center gap-8">
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
      <div class="max-w-3xl mx-auto">
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

  </div>

  <script>
    lucide.createIcons();
  </script>
</body>
</html>
