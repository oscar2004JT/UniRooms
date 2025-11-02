<html lang="es"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniRooms - Alojamiento Universitario</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    
    <link rel="stylesheet" href="css/globals.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/pages.css">
    <link rel="stylesheet" href="css/globals2.css">

<body>
    <div id="app" class="min-h-screen bg-gray-50 flex flex-col"><header class="header">
      <div class="header-content">
        <div style="display: flex; align-items: center; gap: 1rem;">
          <button id="home-link" class="header-title" style="background: none; border: none; color: inherit; cursor: pointer;">
            🏠 UniRooms
          </button>
        </div>
        
        <div class="header-actions">
          <div class="user-type-toggle">
            <button id="student-toggle" class="user-type-btn active">
              Estudiante
            </button>
            <button id="owner-toggle" class="user-type-btn ">
              Propietario
            </button>
          </div>
          
          <div style="display: flex; align-items: center; gap: 0.5rem;">
            
              <span style="color: rgba(255, 255, 255, 0.9);">
                ¡Hola, Estudiante!
              </span>
              <button id="logout-btn" class="btn btn-outline" style="color: white; border-color: rgba(255, 255, 255, 0.3);">
                Cerrar Sesión
              </button>
            
          </div>
        </div>
      </div>
    </header><nav class="navigation" style="display: block;">
      <div class="navigation-content">
        <a href="#" id="nav-home" class="nav-link ">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="home" class="lucide lucide-home"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path><path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
          Inicio
        </a>
        <a href="#" id="nav-search" class="nav-link active">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="search" class="lucide lucide-search"><path d="m21 21-4.34-4.34"></path><circle cx="11" cy="11" r="8"></circle></svg>
          Buscar Habitaciones
        </a>
        
        <a href="#" id="nav-favorites" class="nav-link">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="heart" class="lucide lucide-heart"><path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5"></path></svg>
          Favoritos
        </a>
        <a href="#" id="nav-messages" class="nav-link">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="message-circle" class="lucide lucide-message-circle"><path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"></path></svg>
          Mensajes
        </a>
      </div>
    </nav><main class="flex-1"><div class="container mx-auto px-4 py-8"><div>
      <div class="search-header">
        <h1>Encuentra tu Habitación Ideal</h1>
        <p style="color: var(--muted-foreground);">
          Explora 4 habitaciones disponibles en las mejores zonas universitarias
        </p>
      </div>
      
      <!-- Tabs para Student/Owner -->
      <div style="display: flex; justify-content: center; margin-bottom: 2rem;">
        <div class="tabs-list">
          <button id="tab-student" class="tabs-trigger active" data-state="active">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="graduation-cap" class="lucide lucide-graduation-cap"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"></path><path d="M22 10v6"></path><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"></path></svg>
            Para Estudiantes
          </button>
          <button id="tab-owner" class="tabs-trigger " data-state="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="home" class="lucide lucide-home"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path><path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
            Para Propietarios
          </button>
        </div>
      </div>
      
      <!-- Student Tab Content -->
      <div id="student-content" class="tabs-content ">
        <div id="search-filters-container"><div class="search-filters">
      <div class="filters-grid">
        <div class="filter-group">
          <label class="filter-label">Buscar</label>
          <input type="text" id="search-input" class="input" placeholder="Buscar por título, ubicación..." value="">
        </div>
        
        <div class="filter-group">
          <label class="filter-label">Zona</label>
          <select id="zone-select" class="select">
            <option value="all">Todas las zonas</option>
            
              <option value="Villa marbella">
                Villa marbella
              </option>
            
              <option value="Los laureles">
                Los laureles
              </option>
            
              <option value="Las malvinas">
                Las malvinas
              </option>
            
              <option value="Santana">
                Santana
              </option>
            
              <option value="Villa marina">
                Villa marina
              </option>
            
          </select>
        </div>
        
        <div class="filter-group">
          <label class="filter-label">Tipo de Habitación</label>
          <select id="type-select" class="select">
            <option value="all">Todos los tipos</option>
            
              <option value="single">
                Individual
              </option>
            
              <option value="shared">
                Compartida
              </option>
            
              <option value="studio">
                Estudio
              </option>
            
              <option value="apartment">
                Apartamento
              </option>
            
          </select>
        </div>
        
        <div class="filter-group">
          <label class="filter-label">
            Precio: $&nbsp;0 - $&nbsp;1.000
          </label>
          <div style="display: flex; gap: 0.5rem; align-items: center;">
            <input type="range" id="price-min" min="0" max="1000" value="0" class="slider-thumb" style="flex: 1;">
            <input type="range" id="price-max" min="0" max="1000" value="1000" class="slider-thumb" style="flex: 1;">
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
            <option value="relevance" selected="">Relevancia</option>
            <option value="price-low">Precio: Menor a Mayor</option>
            <option value="price-high">Precio: Mayor a Menor</option>
            <option value="newest">Más Recientes</option>
          </select>
        </div>
      </div>
      
      <div style="display: flex; justify-content: center; margin-top: 1rem;">
        <button id="clear-filters" class="btn btn-outline">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="x" class="lucide lucide-x"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
          Limpiar Filtros
        </button>
      </div>
    </div></div>
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin: 2rem 0 1rem;">
          <h2>Habitaciones Disponibles (4)</h2>
          <div style="display: flex; gap: 0.5rem;">
            <button id="view-grid" class="btn btn-outline btn-sm">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="grid-3x3" class="lucide lucide-grid-3x3"><rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M3 9h18"></path><path d="M3 15h18"></path><path d="M9 3v18"></path><path d="M15 3v18"></path></svg>
              Cuadrícula
            </button>
            <button id="view-list" class="btn btn-outline btn-sm">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="list" class="lucide lucide-list"><path d="M3 5h.01"></path><path d="M3 12h.01"></path><path d="M3 19h.01"></path><path d="M8 5h13"></path><path d="M8 12h13"></path><path d="M8 19h13"></path></svg>
              Lista
            </button>
          </div>
        </div>
        
        <div id="rooms-container" class="rooms-grid">
          <div id="room-1"><div class="room-card">
    <img src="https://images.unsplash.com/photo-1611234688667-76b6d8fadd75?crop=entropy&amp;cs=tinysrgb&amp;fit=max&amp;fm=jpg&amp;ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtb2Rlcm4lMjB1bml2ZXJzaXR5JTIwc3R1ZGVudCUyMGJlZHJvb218ZW58MXx8fHwxNzU4ODkyNjkxfDA&amp;ixlib=rb-4.1.0&amp;q=80&amp;w=1080&amp;utm_source=figma&amp;utm_medium=referral" alt="Habitación Individual Acogedora Cerca del Campus" class="room-image" loading="lazy">
    
    <div class="room-info">
      <h3 class="room-title">Habitación Individual Acogedora Cerca del Campus</h3>
      
      <div class="room-location">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="map-pin" class="lucide lucide-map-pin"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg>
        <span>Área Central del Campus - Villa marbella</span>
      </div>
      
      <div class="room-price">
        $&nbsp;350/mes
      </div>
      
      <div class="room-amenities">
        
          <div class="badge badge-secondary" style="display: flex; align-items: center; gap: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="wifi" style="width: 12px; height: 12px;" class="lucide lucide-wifi"><path d="M12 20h.01"></path><path d="M2 8.82a15 15 0 0 1 20 0"></path><path d="M5 12.859a10 10 0 0 1 14 0"></path><path d="M8.5 16.429a5 5 0 0 1 7 0"></path></svg>
            Wi-Fi
          </div>
        
          <div class="badge badge-secondary" style="display: flex; align-items: center; gap: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="briefcase" style="width: 12px; height: 12px;" class="lucide lucide-briefcase"><path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path><rect width="20" height="14" x="2" y="6" rx="2"></rect></svg>
            Escritorio
          </div>
        
          <div class="badge badge-secondary" style="display: flex; align-items: center; gap: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="box" style="width: 12px; height: 12px;" class="lucide lucide-box"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path><path d="m3.3 7 8.7 5 8.7-5"></path><path d="M12 22V12"></path></svg>
            Closet
          </div>
        
        
          <div class="badge badge-outline">
            +1 más
          </div>
        
      </div>
      
      <div class="room-actions">
        <button class="btn btn-outline btn-view-details" data-room-id="1">
          Ver Detalles
        </button>
        <button class="btn btn-primary btn-contact" data-room-id="1">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="message-circle" class="lucide lucide-message-circle"><path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"></path></svg>
          Contactar
        </button>
      </div>
      
      <div style="display: flex; justify-content: between; align-items: center; margin-top: 0.5rem; font-size: 0.875rem; color: var(--muted-foreground);">
        <span>
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="users" style="width: 14px; height: 14px;" class="lucide lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><path d="M16 3.128a4 4 0 0 1 0 7.744"></path><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><circle cx="9" cy="7" r="4"></circle></svg>
          Hasta 1 persona
        </span>
        <span style="margin-left: auto;">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="home" style="width: 14px; height: 14px;" class="lucide lucide-home"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path><path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
          Individual
        </span>
      </div>
      
      
    </div>
  </div></div><div id="room-2"><div class="room-card">
    <img src="https://images.unsplash.com/photo-1646596549459-9ccf652c5d23?crop=entropy&amp;cs=tinysrgb&amp;fit=max&amp;fm=jpg&amp;ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxjb3p5JTIwc3R1ZGVudCUyMGFwYXJ0bWVudCUyMHN0dWRpb3xlbnwxfHx8fDE3NTg4OTI2OTR8MA&amp;ixlib=rb-4.1.0&amp;q=80&amp;w=1080&amp;utm_source=figma&amp;utm_medium=referral" alt="Estudio Moderno Amoblado" class="room-image" loading="lazy">
    
    <div class="room-info">
      <h3 class="room-title">Estudio Moderno Amoblado</h3>
      
      <div class="room-location">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="map-pin" class="lucide lucide-map-pin"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg>
        <span>Distrito Universitario - Los laureles</span>
      </div>
      
      <div class="room-price">
        $&nbsp;550/mes
      </div>
      
      <div class="room-amenities">
        
          <div class="badge badge-secondary" style="display: flex; align-items: center; gap: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="wifi" style="width: 12px; height: 12px;" class="lucide lucide-wifi"><path d="M12 20h.01"></path><path d="M2 8.82a15 15 0 0 1 20 0"></path><path d="M5 12.859a10 10 0 0 1 14 0"></path><path d="M8.5 16.429a5 5 0 0 1 7 0"></path></svg>
            Wi-Fi
          </div>
        
          <div class="badge badge-secondary" style="display: flex; align-items: center; gap: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="chef-hat" style="width: 12px; height: 12px;" class="lucide lucide-chef-hat"><path d="M17 21a1 1 0 0 0 1-1v-5.35c0-.457.316-.844.727-1.041a4 4 0 0 0-2.134-7.589 5 5 0 0 0-9.186 0 4 4 0 0 0-2.134 7.588c.411.198.727.585.727 1.041V20a1 1 0 0 0 1 1Z"></path><path d="M6 17h12"></path></svg>
            Cocina
          </div>
        
          <div class="badge badge-secondary" style="display: flex; align-items: center; gap: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="bath" style="width: 12px; height: 12px;" class="lucide lucide-bath"><path d="M10 4 8 6"></path><path d="M17 19v2"></path><path d="M2 12h20"></path><path d="M7 19v2"></path><path d="M9 5 7.621 3.621A2.121 2.121 0 0 0 4 5v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5"></path></svg>
            Baño Privado
          </div>
        
        
          <div class="badge badge-outline">
            +2 más
          </div>
        
      </div>
      
      <div class="room-actions">
        <button class="btn btn-outline btn-view-details" data-room-id="2">
          Ver Detalles
        </button>
        <button class="btn btn-primary btn-contact" data-room-id="2">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="message-circle" class="lucide lucide-message-circle"><path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"></path></svg>
          Contactar
        </button>
      </div>
      
      <div style="display: flex; justify-content: between; align-items: center; margin-top: 0.5rem; font-size: 0.875rem; color: var(--muted-foreground);">
        <span>
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="users" style="width: 14px; height: 14px;" class="lucide lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><path d="M16 3.128a4 4 0 0 1 0 7.744"></path><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><circle cx="9" cy="7" r="4"></circle></svg>
          Hasta 1 persona
        </span>
        <span style="margin-left: auto;">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="home" style="width: 14px; height: 14px;" class="lucide lucide-home"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path><path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
          Estudio
        </span>
      </div>
      
      
    </div>
  </div></div><div id="room-3"><div class="room-card">
    <img src="https://images.unsplash.com/photo-1697567673757-51a7d8499937?crop=entropy&amp;cs=tinysrgb&amp;fit=max&amp;fm=jpg&amp;ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxzaGFyZWQlMjBzdHVkZW50JTIwZG9ybSUyMHJvb218ZW58MXx8fHwxNzU4ODkyNjk3fDA&amp;ixlib=rb-4.1.0&amp;q=80&amp;w=1080&amp;utm_source=figma&amp;utm_medium=referral" alt="Habitación Compartida en Casa Estudiantil" class="room-image" loading="lazy">
    
    <div class="room-info">
      <h3 class="room-title">Habitación Compartida en Casa Estudiantil</h3>
      
      <div class="room-location">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="map-pin" class="lucide lucide-map-pin"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg>
        <span>Villa Estudiantil - Las malvinas</span>
      </div>
      
      <div class="room-price">
        $&nbsp;200/mes
      </div>
      
      <div class="room-amenities">
        
          <div class="badge badge-secondary" style="display: flex; align-items: center; gap: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="wifi" style="width: 12px; height: 12px;" class="lucide lucide-wifi"><path d="M12 20h.01"></path><path d="M2 8.82a15 15 0 0 1 20 0"></path><path d="M5 12.859a10 10 0 0 1 14 0"></path><path d="M8.5 16.429a5 5 0 0 1 7 0"></path></svg>
            Wi-Fi
          </div>
        
          <div class="badge badge-secondary" style="display: flex; align-items: center; gap: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="chef-hat" style="width: 12px; height: 12px;" class="lucide lucide-chef-hat"><path d="M17 21a1 1 0 0 0 1-1v-5.35c0-.457.316-.844.727-1.041a4 4 0 0 0-2.134-7.589 5 5 0 0 0-9.186 0 4 4 0 0 0-2.134 7.588c.411.198.727.585.727 1.041V20a1 1 0 0 0 1 1Z"></path><path d="M6 17h12"></path></svg>
            Cocina
          </div>
        
          <div class="badge badge-secondary" style="display: flex; align-items: center; gap: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="users" style="width: 12px; height: 12px;" class="lucide lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><path d="M16 3.128a4 4 0 0 1 0 7.744"></path><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><circle cx="9" cy="7" r="4"></circle></svg>
            Sala Común
          </div>
        
        
          <div class="badge badge-outline">
            +1 más
          </div>
        
      </div>
      
      <div class="room-actions">
        <button class="btn btn-outline btn-view-details" data-room-id="3">
          Ver Detalles
        </button>
        <button class="btn btn-primary btn-contact" data-room-id="3">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="message-circle" class="lucide lucide-message-circle"><path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"></path></svg>
          Contactar
        </button>
      </div>
      
      <div style="display: flex; justify-content: between; align-items: center; margin-top: 0.5rem; font-size: 0.875rem; color: var(--muted-foreground);">
        <span>
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="users" style="width: 14px; height: 14px;" class="lucide lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><path d="M16 3.128a4 4 0 0 1 0 7.744"></path><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><circle cx="9" cy="7" r="4"></circle></svg>
          Hasta 2 personas
        </span>
        <span style="margin-left: auto;">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="home" style="width: 14px; height: 14px;" class="lucide lucide-home"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path><path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
          Compartida
        </span>
      </div>
      
      
    </div>
  </div></div><div id="room-4"><div class="room-card">
    <img src="https://images.unsplash.com/photo-1638282504303-46f10708366b?crop=entropy&amp;cs=tinysrgb&amp;fit=max&amp;fm=jpg&amp;ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxsdXh1cnklMjBtb2Rlcm4lMjBiZWRyb29tfGVufDF8fHx8MTc1ODg5Mjc2MXww&amp;ixlib=rb-4.1.0&amp;q=80&amp;w=1080&amp;utm_source=figma&amp;utm_medium=referral" alt="Apartamento Estudiantil de Lujo" class="room-image" loading="lazy">
    
    <div class="room-info">
      <h3 class="room-title">Apartamento Estudiantil de Lujo</h3>
      
      <div class="room-location">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="map-pin" class="lucide lucide-map-pin"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg>
        <span>Distrito Premium - Santana</span>
      </div>
      
      <div class="room-price">
        $&nbsp;700/mes
      </div>
      
      <div class="room-amenities">
        
          <div class="badge badge-secondary" style="display: flex; align-items: center; gap: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="wifi" style="width: 12px; height: 12px;" class="lucide lucide-wifi"><path d="M12 20h.01"></path><path d="M2 8.82a15 15 0 0 1 20 0"></path><path d="M5 12.859a10 10 0 0 1 14 0"></path><path d="M8.5 16.429a5 5 0 0 1 7 0"></path></svg>
            Wi-Fi
          </div>
        
          <div class="badge badge-secondary" style="display: flex; align-items: center; gap: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="chef-hat" style="width: 12px; height: 12px;" class="lucide lucide-chef-hat"><path d="M17 21a1 1 0 0 0 1-1v-5.35c0-.457.316-.844.727-1.041a4 4 0 0 0-2.134-7.589 5 5 0 0 0-9.186 0 4 4 0 0 0-2.134 7.588c.411.198.727.585.727 1.041V20a1 1 0 0 0 1 1Z"></path><path d="M6 17h12"></path></svg>
            Cocina
          </div>
        
          <div class="badge badge-secondary" style="display: flex; align-items: center; gap: 0.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="bath" style="width: 12px; height: 12px;" class="lucide lucide-bath"><path d="M10 4 8 6"></path><path d="M17 19v2"></path><path d="M2 12h20"></path><path d="M7 19v2"></path><path d="M9 5 7.621 3.621A2.121 2.121 0 0 0 4 5v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5"></path></svg>
            Baño Privado
          </div>
        
        
          <div class="badge badge-outline">
            +4 más
          </div>
        
      </div>
      
      <div class="room-actions">
        <button class="btn btn-outline btn-view-details" data-room-id="4">
          Ver Detalles
        </button>
        <button class="btn btn-primary btn-contact" data-room-id="4">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="message-circle" class="lucide lucide-message-circle"><path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"></path></svg>
          Contactar
        </button>
      </div>
      
      <div style="display: flex; justify-content: between; align-items: center; margin-top: 0.5rem; font-size: 0.875rem; color: var(--muted-foreground);">
        <span>
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="users" style="width: 14px; height: 14px;" class="lucide lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><path d="M16 3.128a4 4 0 0 1 0 7.744"></path><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><circle cx="9" cy="7" r="4"></circle></svg>
          Hasta 1 persona
        </span>
        <span style="margin-left: auto;">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="home" style="width: 14px; height: 14px;" class="lucide lucide-home"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path><path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
          Apartamento
        </span>
      </div>
      
      
    </div>
  </div></div>
        </div>
      </div>
      
      <!-- Owner Tab Content -->
      <div id="owner-content" class="tabs-content hidden">
        <div style="text-align: center; padding: 3rem 1rem;">
          <div style="max-width: 600px; margin: 0 auto;">
            <div style="width: 4rem; height: 4rem; margin: 0 auto 2rem; background-color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="home" class="lucide lucide-home"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path><path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
            </div>
            <h2>Publica tu Habitación</h2>
            <p style="color: var(--muted-foreground); margin-bottom: 2rem;">
              Conecta con estudiantes que buscan alojamiento y genera ingresos extra con tu propiedad
            </p>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
              <div class="card" style="padding: 1.5rem; text-align: center;">
                <div style="width: 2.5rem; height: 2.5rem; margin: 0 auto 1rem; background-color: var(--secondary); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="upload" class="lucide lucide-upload"><path d="M12 3v12"></path><path d="m17 8-5-5-5 5"></path><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path></svg>
                </div>
                <h4>Publicación Fácil</h4>
                <p style="color: var(--muted-foreground); font-size: 0.875rem;">
                  Sube fotos y describe tu habitación en minutos
                </p>
              </div>
              
              <div class="card" style="padding: 1.5rem; text-align: center;">
                <div style="width: 2.5rem; height: 2.5rem; margin: 0 auto 1rem; background-color: var(--secondary); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="users" class="lucide lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><path d="M16 3.128a4 4 0 0 1 0 7.744"></path><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><circle cx="9" cy="7" r="4"></circle></svg>
                </div>
                <h4>Estudiantes Verificados</h4>
                <p style="color: var(--muted-foreground); font-size: 0.875rem;">
                  Conecta con estudiantes responsables y verificados
                </p>
              </div>
              
              <div class="card" style="padding: 1.5rem; text-align: center;">
                <div style="width: 2.5rem; height: 2.5rem; margin: 0 auto 1rem; background-color: var(--secondary); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="shield-check" class="lucide lucide-shield-check"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="m9 12 2 2 4-4"></path></svg>
                </div>
                <h4>Proceso Seguro</h4>
                <p style="color: var(--muted-foreground); font-size: 0.875rem;">
                  Plataforma segura con soporte 24/7
                </p>
              </div>
            </div>
            
            <button id="btn-add-room" class="btn btn-primary btn-lg">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="plus-circle" class="lucide lucide-plus-circle"><circle cx="12" cy="12" r="10"></circle><path d="M8 12h8"></path><path d="M12 8v8"></path></svg>
              Publicar mi Habitación
            </button>
          </div>
        </div>
      </div>
    </div></div></main><footer class="footer">
    <div class="footer-content">
      <div class="footer-section">
        <h3>RoomFinder</h3>
        <p>
          La plataforma líder para encontrar alojamiento universitario. 
          Conectamos estudiantes con propietarios de confianza en las mejores zonas de la ciudad.
        </p>
      </div>
      
      <div class="footer-section">
        <h3>Zonas Disponibles</h3>
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
          <a href="#">Villa Marbella</a>
          <a href="#">Los Laureles</a>
          <a href="#">Las Malvinas</a>
          <a href="#">Santana</a>
          <a href="#">Villa Marina</a>
        </div>
      </div>
      
      <div class="footer-section">
        <h3>Servicios</h3>
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
          <a href="#">Buscar Habitaciones</a>
          <a href="#">Publicar Habitación</a>
          <a href="#">Verificación de Propiedades</a>
          <a href="#">Soporte 24/7</a>
          <a href="#">Guía del Estudiante</a>
        </div>
      </div>
      
      <div class="footer-section">
        <h3>Contacto</h3>
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
          <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="phone" class="lucide lucide-phone"><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"></path></svg> +57 (300) 123-4567</p>
          <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="mail" class="lucide lucide-mail"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path><rect x="2" y="4" width="20" height="16" rx="2"></rect></svg> info@roomfinder.co</p>
          <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="map-pin" class="lucide lucide-map-pin"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg> Medellín, Colombia</p>
          <div style="display: flex; gap: 1rem; margin-top: 1rem;">
            <a href="#" style="display: flex; align-items: center; justify-content: center; width: 2rem; height: 2rem; background-color: #3b82f6; border-radius: 50%; color: white;">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="facebook" class="lucide lucide-facebook"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
            </a>
            <a href="#" style="display: flex; align-items: center; justify-content: center; width: 2rem; height: 2rem; background-color: #1da1f2; border-radius: 50%; color: white;">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="twitter" class="lucide lucide-twitter"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path></svg>
            </a>
            <a href="#" style="display: flex; align-items: center; justify-content: center; width: 2rem; height: 2rem; background-color: #e1306c; border-radius: 50%; color: white;">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="instagram" class="lucide lucide-instagram"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line></svg>
            </a>
            <a href="#" style="display: flex; align-items: center; justify-content: center; width: 2rem; height: 2rem; background-color: #25d366; border-radius: 50%; color: white;">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="message-circle" class="lucide lucide-message-circle"><path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"></path></svg>
            </a>
          </div>
        </div>
      </div>
    </div>
    
    <div class="footer-bottom">
      <p>© 2024 RoomFinder. Todos los derechos reservados. | Términos de Servicio | Política de Privacidad</p>
    </div>
  </footer><div>
        <button id="chat-toggle" class="chat-toggle">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="message-circle" class="lucide lucide-message-circle"><path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"></path></svg>
        </button>
      </div></div>