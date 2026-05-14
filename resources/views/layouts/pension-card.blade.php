@php
    // Mapa servicio → ícono Lucide
    $icons = [
        'Wi-Fi' => 'wifi',
        'Escritorio' => 'briefcase',
        'Closet' => 'box',
        'Calefacción' => 'flame',
        'Cocina' => 'chef-hat',
        'Baño Privado' => 'bath',
        'Lavandería' => 'washing-machine',
        'Parqueadero' => 'car',
        'Sala Común' => 'users',
        'Jardín' => 'trees',
        'Gimnasio' => 'dumbbell',
        'Sala de Estudio' => 'notebook-pen',
    ];
@endphp

<div class="bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition">

    <img src="{{ $pension->link_foto }}" 
         alt="{{ $pension->nombre }}"
         class="w-full h-48 object-cover">

    <div class="p-4">

        <h3 class="text-lg font-semibold">
            {{ $pension->nombre }}
        </h3>

        <div class="flex items-center gap-2 text-sm text-gray-600 mt-1">
            <i data-lucide="map-pin" class="w-4 h-4"></i>
            {{ $pension->zona->nombre ?? 'Zona desconocida' }}
        </div>

        <div class="mt-2 text-blue-600 font-bold text-xl">
            ${{ $pension->precio }} / mes
        </div>

        <!-- Servicios -->
        <div class="flex flex-wrap gap-2 mt-3">
            @foreach ($pension->servicios->take(3) as $servicio)
                <span class="flex items-center gap-1 px-2 py-1 bg-gray-100 rounded-full text-xs">
                    <i data-lucide="{{ $icons[$servicio->nombre] ?? 'info' }}" class="w-3 h-3"></i>
                    {{ $servicio->nombre }}
                </span>
            @endforeach

            @if ($pension->servicios->count() > 3)
                <span class="px-2 py-1 bg-gray-200 text-gray-800 rounded-full text-xs">
                    +{{ $pension->servicios->count() - 3 }} más
                </span>
            @endif
        </div>

        <div class="flex justify-between items-center mt-4">
            <span class="text-sm flex items-center gap-1 text-gray-500">
                <i data-lucide="users" class="w-4 h-4"></i>
                Capacidad: {{ $pension->capacidad }}
            </span>

            <span class="text-sm flex items-center gap-1 text-gray-500">
                <i data-lucide="home" class="w-4 h-4"></i>
                {{ $pension->tipoHabitacion->nombre ?? 'Tipo' }}
            </span>
        </div>

        <div class="flex gap-2 mt-4">
            <button class="flex-1 bg-blue-600 text-white py-2 rounded-md">Ver detalles</button>
            <button class="flex-1 bg-white border border-blue-600 text-blue-600 py-2 rounded-md">
                Contactar
            </button>
        </div>
    </div>
</div>
