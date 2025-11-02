<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-100">

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

                <!-- Menú minimalista -->
                @auth
                @php $rol = Auth::user()->id_rol; @endphp
                <div class="flex items-center gap-4 relative">
                    <!-- Tipo de usuario -->
                    <div class="inline-flex items-center bg-white/10 rounded-full p-1">
                        <span class="px-4 py-2 rounded-full font-medium shadow-sm {{ $rol==1 ? 'bg-white text-blue-700' : 'text-white/80' }}">
                            Estudiante
                        </span>
                        <span class="px-4 py-2 rounded-full font-medium shadow-sm {{ $rol==2 ? 'bg-white text-blue-700' : 'text-white/80' }}">
                            Propietario
                        </span>
                    </div>

                    <!-- Dropdown de usuario -->
                    <div class="relative">
                        <button id="userMenuBtn" class="flex items-center gap-1 text-white font-medium hover:bg-white/10 px-4 py-2 rounded-md transition">
                            {{ Auth::user()->name }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white text-gray-700 rounded-md shadow-lg overflow-hidden z-50">
                            <div class="px-4 py-2 text-sm text-gray-500 border-b">Mi cuenta</div>
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Perfil</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Cerrar Sesión</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Contenido de la página -->
    <main class="max-w-7xl mx-auto px-4 py-6">
        {{ $slot }}
    </main>

    @livewireScripts
    <script>
        lucide.createIcons();

        // Dropdown usuario
        document.addEventListener('DOMContentLoaded', () => {
            const userMenuBtn = document.getElementById('userMenuBtn');
            const dropdown = document.getElementById('userDropdown');
            userMenuBtn?.addEventListener('click', () => {
                dropdown.classList.toggle('hidden');
            });
            document.addEventListener('click', e => {
                if (!userMenuBtn.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
