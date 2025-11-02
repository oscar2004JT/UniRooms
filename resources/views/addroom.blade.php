<!-- resources/views/addroom.blade.php (vista estática, sin directivas Blade) -->
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Publicar Habitación — Vista estática</title>

  <!-- Tailwind CDN para prototipo rápido -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    :root{
      --primary: #234db7;
      --muted: #f3f6fb;
      --muted-foreground: #97a1b8;
      --foreground: #1f2937;
      --radius: 0.5rem;
    }

    body{ background: #fbfdff; color: var(--foreground); font-family: Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial; }

    .card{ background: #fff; border-radius: 12px; border: 1px solid #eef2f7; box-shadow: 0 1px 2px rgba(16,24,40,0.03); }
    .input, .select, textarea.input{ width:100%; border:1px solid #e6edf7; border-radius:8px; padding:0.75rem 1rem; background:#fbfdff; font-size:0.95rem; }
    h1{ font-size:1.25rem; font-weight:600; }
    h3{ font-size:1rem; font-weight:600; }
    .btn{ display:inline-flex; align-items:center; gap:0.5rem; padding:0.6rem 0.9rem; border-radius:10px; border:1px solid #e6edf7; background:white; cursor:pointer; }
    .btn-primary{ background:var(--primary); color:white; border-color:var(--primary); }
    .btn-outline{ background:white; color:var(--foreground); }
    /* amenity label highlight when active */
    .amenity-active{ background: rgba(35,77,183,0.08); box-shadow: inset 0 0 0 1px rgba(35,77,183,0.06); border-radius:8px; }
    /* small responsive spacing for small screens */
    @media (max-width:640px){ .max-w-800{ padding-left:1rem; padding-right:1rem } }
  </style>
</head>
<body>
  <div class="container mx-auto px-4 py-10 max-w-5xl">
    <div style="min-height:100vh; background:transparent;">
      <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-10">
          <button id="back-to-home" class="btn btn-outline mb-4">
            <!-- arrow-left -->
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
            Volver al Inicio
          </button>

          <div style="width:64px;height:64px;margin:0 auto 0.75rem;background:var(--primary);border-radius:9999px;display:flex;align-items:center;justify-content:center;color:white;">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M8 12h8"></path><path d="M12 8v8"></path></svg>
          </div>

          <h1>Publica tu Habitación</h1>
          <p class="mt-2" style="color:var(--muted-foreground); font-size:1.05rem;">
            Completa la información para atraer a los mejores inquilinos
          </p>
        </div>

        <!-- Form (estática) -->
        <div class="card p-8">
          <div id="alert-container" class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md space-y-2">

    @if(session('success'))
        <div class="alert flex items-center gap-3 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="alert flex items-center gap-3 bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
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

<script>
    // Selecciona todas las alertas y haz que desaparezcan después de 2 segundos
    document.addEventListener('DOMContentLoaded', () => {
        const alerts = document.querySelectorAll('#alert-container .alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = "opacity 0.5s";
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500); // eliminar del DOM después de la transición
            }, 2000); // 2 segundos
        });
    });
</script>

          <form id="add-room-form" action="{{ route('addroomC') }}" method="post" novalidate>
            @csrf
            <!-- Basic Info -->
            <div class="mb-8">
              <h3 class="mb-4 text-[var(--primary)] flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                Información Básica
              </h3>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label for="room-title" class="block text-sm font-medium mb-2">Título de la habitación *</label>
                  <input id="room-title" name = "nombre" class="input" type="text" placeholder="Ej: Habitación acogedora cerca del campus" required>
                  <small style="color:var(--muted-foreground);">Escribe un título atractivo que describa tu habitación</small>
                </div>

                <div>
                  <label for="room-price" class="block text-sm font-medium mb-2">Precio mensual (COP) *</label>
                  <input id="room-price" name = "precio"  class="input" type="number" min="0" placeholder="350000" required>
                  <small style="color:var(--muted-foreground);">Precio competitivo según la zona</small>
                </div>
              </div>
            </div>

            <!-- Location -->
            <div class="mb-8">
              <h3 class="mb-4 text-[var(--primary)] flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg>
                Ubicación
              </h3>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label for="room-zone" class="block text-sm font-medium mb-2">Zona *</label>
                  <select id="room-zone" name="id_zona" class="select input" required>
                    <option value="">Selecciona una zona</option>
                    <option value="1">Villa marbella</option>
                    <option value="2">Los laureles</option>
                    <option value="3">Las malvinas</option>
                    <option value="4">Santana</option>
                    <option value="5">Villa marina</option>
                  </select>
                </div>

                <div>
                  <label for="room-location" class="block text-sm font-medium mb-2">Ubicación específica *</label>
                  <input id="room-location" name="ubicacion_especifica" class="input" type="text" placeholder="Ej: Cerca al Campus Principal, Estación del Metro" required>
                </div>
              </div>
            </div>

            <!-- Room Details -->
            <div class="mb-8">
              <h3 class="mb-4 text-[var(--primary)] flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path><path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
                Detalles de la Habitación
              </h3>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label for="room-type" class="block text-sm font-medium mb-2">Tipo de habitación *</label>
                  <select id="room-type" name="id_tipo_habitacion" class="select input" required>
                    <option value="">Selecciona un tipo</option>
                    <option value="1">Individual</option>
                    <option value="2">Compartida</option>
                    <option value="3">Estudio</option>
                    <option value="4">Apartamento</option>
                  </select>
                </div>

                <div>
                  <label for="room-occupancy" class="block text-sm font-medium mb-2">Capacidad máxima *</label>
                  <select id="room-occupancy" name="capacidad" class="select input" required>
                    <option value="">Selecciona capacidad</option>
                    <option value="1">1 persona</option>
                    <option value="2">2 personas</option>
                    <option value="3">3 personas</option>
                    <option value="4">4 personas</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Description -->
            <div class="mb-8">
              <h3 class="mb-4 text-[var(--primary)] flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path></svg>
                Descripción
              </h3>

              <div>
                <label for="room-description" class="block text-sm font-medium mb-2">Descripción detallada *</label>
                <textarea id="room-description"  name="descripcion"  class="input" rows="6" placeholder="Describe tu habitación..." required style="height:auto; resize:vertical;"></textarea>
                <small style="color:var(--muted-foreground);">Mínimo 100 caracteres para una descripción completa</small>
              </div>
            </div>

            <!-- Amenities -->
            <div class="mb-8">
              <h3 class="mb-4 text-[var(--primary)] flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10.656V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h12.344"></path><path d="m9 11 3 3L22 4"></path></svg>
                Servicios Incluidos <span id="amenities-count" class="ml-2 text-sm" style="color:var(--muted-foreground)"></span>
              </h3>

              <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px,1fr)); gap:1rem; background:var(--muted); padding:1.25rem; border-radius:var(--radius);">
                <!-- Aquí están los íconos tal como pediste (lista estática). -->
                <!-- Cada label tendrá la clase .amenity-active cuando su checkbox esté marcado (se activa por JS). -->
                <label class="amenity-label flex items-center gap-3 p-2 rounded" style="cursor:pointer;">
  <input type="checkbox" name="amenities[]" value="1" class="amenity-checkbox" style="margin:0;">
  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--primary)">
    <path d="M12 20h.01"></path>
    <path d="M2 8.82a15 15 0 0 1 20 0"></path>
    <path d="M5 12.859a10 10 0 0 1 14 0"></path>
    <path d="M8.5 16.429a5 5 0 0 1 7 0"></path>
  </svg>
  <span>Wi-Fi</span>
</label>

<label class="amenity-label flex items-center gap-3 p-2 rounded" style="cursor:pointer;">
  <input type="checkbox" name="amenities[]" value="2" class="amenity-checkbox" style="margin:0;">
  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--primary)">
    <path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
    <rect width="20" height="14" x="2" y="6" rx="2"></rect>
  </svg>
  <span>Escritorio</span>
</label>

<label class="amenity-label flex items-center gap-3 p-2 rounded" style="cursor:pointer;">
  <input type="checkbox" name="amenities[]" value="3" class="amenity-checkbox" style="margin:0;">
  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--primary)">
    <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path>
    <path d="m3.3 7 8.7 5 8.7-5"></path>
    <path d="M12 22V12"></path>
  </svg>
  <span>Closet</span>
</label>

<label class="amenity-label flex items-center gap-3 p-2 rounded" style="cursor:pointer;">
  <input type="checkbox" name="amenities[]" value="4" class="amenity-checkbox" style="margin:0;">
  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--primary)">
    <path d="M14 4v10.54a4 4 0 1 1-4 0V4a2 2 0 0 1 4 0Z"></path>
  </svg>
  <span>Calefacción</span>
</label>

<label class="amenity-label flex items-center gap-3 p-2 rounded" style="cursor:pointer;">
  <input type="checkbox" name="amenities[]" value="5" class="amenity-checkbox" style="margin:0;">
  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--primary)">
    <path d="M17 21a1 1 0 0 0 1-1v-5.35c0-.457.316-.844.727-1.041a4 4 0 0 0-2.134-7.589 5 5 0 0 0-9.186 0 4 4 0 0 0-2.134 7.588c.411.198.727.585.727 1.041V20a1 1 0 0 0 1 1Z"></path>
    <path d="M6 17h12"></path>
  </svg>
  <span>Cocina</span>
</label>

<label class="amenity-label flex items-center gap-3 p-2 rounded" style="cursor:pointer;">
  <input type="checkbox" name="amenities[]" value="6" class="amenity-checkbox" style="margin:0;">
  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--primary)">
    <path d="M10 4 8 6"></path>
    <path d="M17 19v2"></path>
    <path d="M2 12h20"></path>
    <path d="M7 19v2"></path>
    <path d="M9 5 7.621 3.621A2.121 2.121 0 0 0 4 5v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5"></path>
  </svg>
  <span>Baño Privado</span>
</label>

<label class="amenity-label flex items-center gap-3 p-2 rounded" style="cursor:pointer;">
  <input type="checkbox" name="amenities[]" value="7" class="amenity-checkbox" style="margin:0;">
  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--primary)">
    <path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"></path>
  </svg>
  <span>Lavandería</span>
</label>

<label class="amenity-label flex items-center gap-3 p-2 rounded" style="cursor:pointer;">
  <input type="checkbox" name="amenities[]" value="8" class="amenity-checkbox" style="margin:0;">
  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--primary)">
    <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"></path>
    <circle cx="7" cy="17" r="2"></circle>
    <path d="M9 17h6"></path>
    <circle cx="17" cy="17" r="2"></circle>
  </svg>
  <span>Parqueadero</span>
</label>

<label class="amenity-label flex items-center gap-3 p-2 rounded" style="cursor:pointer;">
  <input type="checkbox" name="amenities[]" value="9" class="amenity-checkbox" style="margin:0;">
  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--primary)">
    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
    <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
    <circle cx="9" cy="7" r="4"></circle>
  </svg>
  <span>Sala Común</span>
</label>

<label class="amenity-label flex items-center gap-3 p-2 rounded" style="cursor:pointer;">
  <input type="checkbox" name="amenities[]" value="10" class="amenity-checkbox" style="margin:0;">
  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--primary)">
    <path d="M10 10v.2A3 3 0 0 1 8.9 16H5a3 3 0 0 1-1-5.8V10a3 3 0 0 1 6 0Z"></path>
    <path d="M7 16v6"></path>
    <path d="M13 19v3"></path>
    <path d="M12 19h8.3a1 1 0 0 0 .7-1.7L18 14h.3a1 1 0 0 0 .7-1.7L16 9h.2a1 1 0 0 0 .8-1.7L13 3l-1.4 1.5"></path>
  </svg>
  <span>Jardín</span>
</label>

<label class="amenity-label flex items-center gap-3 p-2 rounded" style="cursor:pointer;">
  <input type="checkbox" name="amenities[]" value="11" class="amenity-checkbox" style="margin:0;">
  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--primary)">
    <path d="M17.596 12.768a2 2 0 1 0 2.829-2.829l-1.768-1.767a2 2 0 0 0 2.828-2.829l-2.828-2.828a2 2 0 0 0-2.829 2.828l-1.767-1.768a2 2 0 1 0-2.829 2.829z"></path>
    <path d="m2.5 21.5 1.4-1.4"></path>
    <path d="m20.1 3.9 1.4-1.4"></path>
    <path d="M5.343 21.485a2 2 0 1 0 2.829-2.828l1.767 1.768a2 2 0 1 0 2.829-2.829l-6.364-6.364a2 2 0 1 0-2.829 2.829l1.768 1.767a2 2 0 0 0-2.828 2.829z"></path>
    <path d="m9.6 14.4 4.8-4.8"></path>
  </svg>
  <span>Gimnasio</span>
</label>

<label class="amenity-label flex items-center gap-3 p-2 rounded" style="cursor:pointer;">
  <input type="checkbox" name="amenities[]" value="12" class="amenity-checkbox" style="margin:0;">
  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--primary)">
    <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"></path>
  </svg>
  <span>Sala de Estudio</span>
</label>

              </div>

              <small style="color:var(--muted-foreground); display:block; margin-top:0.5rem;">Selecciona todos los servicios que incluye tu habitación</small>
            </div>

            <!-- Contact Info -->
            <div class="mb-8">
              <h3 class="mb-4 text-[var(--primary)] flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                Información de Contacto
              </h3>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label for="owner-name" class="block text-sm font-medium mb-2">Nombre completo *</label>
                  <input id="owner-name" class="input" type="text" placeholder="Tu nombre completo" required>
                </div>

                <div>
                  <label for="owner-email" class="block text-sm font-medium mb-2">Email *</label>
                  <input id="owner-email" class="input" type="email" placeholder="tu@email.com" required>
                  <small style="color:var(--muted-foreground);">Los estudiantes te contactarán por este email</small>
                </div>

                <div class="md:col-span-2">
                  <label for="owner-phone" class="block text-sm font-medium mb-2">Teléfono *</label>
                  <input id="owner-phone" class="input" type="tel" placeholder="+57 300 123 4567" required>
                  <small style="color:var(--muted-foreground);">Incluye código de país (+57)</small>
                </div>
              </div>
            </div>

            <!-- Terms -->
            <div class="mb-8 p-5" style="background:var(--muted); border-radius:var(--radius);">
              <label style="display:flex; gap:0.75rem; align-items:flex-start; cursor:pointer;">
                <input type="checkbox" id="accept-terms" required style="margin-top:0.3rem;">
                <div>
                  <strong>Acepto los términos y condiciones</strong>
                  <p style="margin:0.5rem 0 0; color:var(--muted-foreground); font-size:0.9rem;">
                    Al publicar mi habitación, confirmo que la información es veraz y autorizo a RoomFinder a verificar los datos proporcionados.
                    <a href="#" style="color:var(--primary)">Leer términos completos</a>
                  </p>
                </div>
              </label>
            </div>

            <!-- Actions -->
            <div class="flex justify-center gap-4 flex-wrap">
             <!-- Campo oculto para el estado -->
<input type="hidden" name="id_estado" id="id_estado" value="1">

<!-- Botón Guardar Borrador -->
<button type="button" class="btn btn-outline" 
        onclick="document.getElementById('id_estado').value=1; this.form.submit();">
  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"></path>
    <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7"></path>
  </svg>
  Guardar Borrador
</button>

<!-- Botón Publicar Habitación -->
<button type="submit" class="btn btn-primary" 
        onclick="document.getElementById('id_estado').value=2;">
  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M20 6 9 17l-5-5"></path>
  </svg>
  Publicar Habitación
</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>

  <script>
    // Simple enhancement: toggle .amenity-active on label when checkbox checked
    (function(){
      const checkboxes = document.querySelectorAll('.amenity-checkbox');
      const labels = document.querySelectorAll('.amenity-label');
      const countEl = document.getElementById('amenities-count');

      function refreshCount(){
        const checked = document.querySelectorAll('.amenity-checkbox:checked').length;
        countEl.textContent = checked ? `(${checked} seleccionados)` : '';
      }

      checkboxes.forEach(cb=>{
        // make parent label clickable highlight works even if user clicks label area
        const label = cb.closest('.amenity-label');
        if(!label) return;
        // initial sync
        if(cb.checked) label.classList.add('amenity-active');
        cb.addEventListener('change', ()=>{
          label.classList.toggle('amenity-active', cb.checked);
          refreshCount();
        });
        // clicking label toggles checkbox (native), but we also toggle style when label clicked outside checkbox
        label.addEventListener('click', (e)=> {
          if (e.target.tagName.toLowerCase() === 'input') return;
          // toggle checkbox manually when clicking label area (avoid double toggle)
          cb.checked = !cb.checked;
          label.classList.toggle('amenity-active', cb.checked);
          refreshCount();
          e.preventDefault();
        });
      });

      refreshCount();

      // sample "Guardar Borrador" action (demo)
      document.getElementById('save-draft').addEventListener('click', ()=>{
        alert('Modo demo: Borrador guardado (simulado).');
      });

      // prevent actual submit (since this is a static demo)
      document.getElementById('add-room-form').addEventListener('submit', function(e){
        e.preventDefault();
        alert('Modo demo: formulario enviado (simulado).');
      });
    })();
  </script>
</body>
</html>
