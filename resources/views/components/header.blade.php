@props(['title' => 'Dashboard'])

<header class="bg-header text-white py-4 px-4 md:px-8 flex items-center justify-between shadow sticky top-0 z-30 transition-all duration-300">
    <div class="flex items-center gap-4">
        <button id="mobile-menu-btn" class="md:hidden text-white hover:text-gray-200 focus:outline-none p-1 transition-transform hover:scale-110 active:scale-95">
            <i class="fas fa-bars text-2xl"></i>
        </button>

        <div class="flex items-center gap-2 md:gap-4">
            <img src="{{ asset('images/Recurso 8.png') }}" alt="Logo" class="h-8 md:h-10 transition-transform hover:scale-105">
            <span class="text-lg md:text-3xl font-bold truncate">Bienes Inmuebles</span>
        </div>
    </div>
    
    <div class="flex items-center gap-4">
        <h1 class="text-lg md:text-2xl font-semibold hidden sm:block">{{ $title }}</h1>
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="text-red-200 hover:text-white flex items-center gap-2 transition-all duration-300 hover:scale-105 px-3 py-2 rounded-lg hover:bg-white/10">
                <i class="fas fa-sign-out-alt"></i> 
                <span class="hidden md:inline">Cerrar sesión</span>
            </button>
        </form>
    </div>
</header>
