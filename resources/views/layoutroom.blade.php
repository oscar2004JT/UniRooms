<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>@yield('title', 'Habitaciones Estudiantiles')</title>

  <style>
    body {
      font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI";
      background: #f5f5f5;
      padding: 2rem;
    }

    .rooms-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 1.5rem;
    }

    .room-card {
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 10px 25px rgba(0,0,0,0.08);
      display: flex;
      flex-direction: column;
    }

    .room-image { width: 100%; height: 180px; object-fit: cover; }
    .room-info { padding: 1rem; }
    .room-title { font-size: 1rem; font-weight: 600; margin-bottom: 0.4rem; }
    .room-location { display: flex; align-items: center; gap: 0.4rem; font-size: 0.85rem; color: #666; }
    .room-price { font-weight: 700; margin-top: 0.4rem; }

    .room-amenities {
      display: flex;
      flex-wrap: wrap;
      gap: 0.35rem;
      margin: 0.8rem 0;
      font-size: 0.78rem;
    }

    .badge {
      border-radius: 999px;
      padding: 0.15rem 0.6rem;
      display: inline-flex;
      align-items: center;
      gap: 0.25rem;
      border: 1px solid transparent;
      white-space: nowrap;
    }

    .badge-secondary { background: #f3f4f6; color: #111827; }
    .badge-outline { background: white; border-color: #e5e7eb; color: #4b5563; }

    .room-actions { display: flex; gap: 0.5rem; margin-bottom: 0.6rem; }

    .btn {
      border-radius: 999px;
      padding: 0.35rem 0.8rem;
      font-size: 0.85rem;
      cursor: pointer;
      border: 1px solid transparent;
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
    }

    .btn-outline { background: white; border-color: #e5e7eb; color: #374151; }
    .btn-primary { background: #2563eb; color: white; }
    .btn-primary:hover { background: #1d4ed8; }

    .room-footer { display: flex; justify-content: space-between; font-size: 0.8rem; color: #6b7280; }
  </style>
</head>

<body>
  <h1>@yield('header', 'Habitaciones disponibles')</h1>

  <!-- Contenedor donde las tarjetas serán generadas -->
  <div id="rooms-container" class="rooms-grid"></div>

  <!-- Plantilla de tarjeta -->
  <template id="room-template">
    <div class="room-card">
      <img src="" alt="" class="room-image">

      <div class="room-info">
        <h3 class="room-title"></h3>

        <div class="room-location">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 10c0 5-5.5 10.2-7.4 11.8a1 1 0 0 1-1.2 0C9.5 20.2 4 15 4 10a8 8 0 0 1 16 0"/>
            <circle cx="12" cy="10" r="3"/>
          </svg>
          <span data-role="location"></span>
        </div>

        <div class="room-price" data-role="price"></div>

        <div class="room-amenities" data-role="amenities"></div>

        <div class="room-actions">
          <button class="btn btn-outline" data-role="btn-details">Ver Detalles</button>
          <button class="btn btn-primary" data-role="btn-contact">Contactar</button>
        </div>

        <div class="room-footer">
          <span data-role="capacity"></span>
          <span data-role="type"></span>
        </div>
      </div>
    </div>
  </template>

  <!-- Archivo JS externo -->
  <script src="rooms.js"></script>
</body>
</html>
