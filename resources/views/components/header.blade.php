@props(['title' => 'Dashboard'])

<header class="header-gradient text-white py-3 px-4 md:px-8 flex items-center justify-between sticky top-0 z-[60] transition-all duration-300">
    <div class="flex items-center gap-4">
        <button id="mobile-menu-btn" class="md:hidden text-white hover:text-gray-200 focus:outline-none p-1 transition-transform hover:scale-110 active:scale-95">
            <i class="fas fa-bars text-2xl"></i>
        </button>

        <div class="flex items-center gap-2 md:gap-4">
            <div class="header-logo-wrap">
                <img src="{{ asset('images/Recurso 8.png') }}" alt="Logo" class="h-8 md:h-10 transition-transform hover:scale-105 drop-shadow-lg">
            </div>
            <span class="text-lg md:text-2xl font-bold truncate tracking-tight drop-shadow-sm">Bienes Inmuebles</span>
        </div>
    </div>

    <div class="flex items-center gap-4">
        <h1 class="text-base md:text-xl font-semibold hidden sm:block opacity-90">{{ $title }}</h1>
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="header-logout-btn flex items-center gap-2 px-3 py-2 rounded-xl transition-all duration-300">
                <i class="fas fa-sign-out-alt"></i>
                <span class="hidden md:inline text-sm font-medium">Cerrar sesión</span>
            </button>
        </form>
    </div>
</header>

<style>
    .header-gradient {
        background: linear-gradient(135deg, #651f2e 0%, #7c2a38 30%, #9b4d5c 70%, #b0616f 100%);
        box-shadow: 0 4px 20px -4px rgba(101, 31, 46, 0.5);
    }

    .header-logo-wrap {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 4px;
        backdrop-filter: blur(4px);
    }

    .header-logout-btn {
        color: rgba(255, 200, 200, 0.9);
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .header-logout-btn:hover {
        color: #fff;
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.25);
        transform: scale(1.03);
    }
</style>
