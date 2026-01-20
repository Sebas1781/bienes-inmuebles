@props(['active' => ''])

<div id="sidebar-overlay" onclick="toggleSidebar()" 
     class="fixed inset-0 bg-black/20 backdrop-blur-sm z-40 hidden md:hidden transition-all duration-300">
</div>

<aside id="sidebar" 
       class="bg-white w-64 py-6 px-4 flex flex-col shadow-xl
              fixed inset-y-0 left-0 z-50 h-screen transition-transform duration-300 ease-in-out transform -translate-x-full
              md:relative md:translate-x-0 md:h-full md:shadow-[4px_0_15px_-3px_rgba(0,0,0,0.1)]">
    
    <div class="flex justify-end md:hidden mb-2">
        <button onclick="toggleSidebar()" class="text-gray-400 hover:text-maroon-700 p-2 transition-transform hover:scale-110">
            <i class="fas fa-times text-2xl"></i>
        </button>
    </div>

    <nav class="flex-1 flex flex-col gap-2">

    <a href="{{ route('properties.create') }}" 
       class="flex items-center gap-3 py-3 px-4 rounded-lg font-semibold transition-all duration-300 group
              {{ $active === 'create' ? 'bg-maroon-700 text-white shadow-lg scale-105' : 'text-maroon-700 hover:bg-maroon-100 hover:scale-105 hover:shadow-md' }}">
        <i class="fas fa-plus-square transition-transform duration-300 {{ $active === 'create' ? 'rotate-90' : 'group-hover:scale-125 group-hover:rotate-12' }}"></i> 
        <span class="transition-all duration-300">Agregar inmueble</span>
    </a>

    <a href="{{ route('dashboard') }}" 
       class="flex items-center gap-3 py-3 px-4 rounded-lg font-semibold transition-all duration-300 group
              {{ $active === 'dashboard' ? 'bg-maroon-700 text-white shadow-lg scale-105' : 'text-maroon-700 hover:bg-maroon-100 hover:scale-105 hover:shadow-md' }}">
        <i class="fas fa-warehouse transition-transform duration-300 {{ $active === 'dashboard' ? 'rotate-0' : 'group-hover:scale-125 group-hover:-rotate-12' }}"></i> 
        <span class="transition-all duration-300">Admin. inmuebles</span>
    </a>

    @if(auth()->user()->isSuperAdmin())
    <a href="{{ route('users.index') }}" 
       class="flex items-center gap-3 py-3 px-4 rounded-lg font-semibold transition-all duration-300 group
              {{ $active === 'users' ? 'bg-maroon-700 text-white shadow-lg scale-105' : 'text-maroon-700 hover:bg-maroon-100 hover:scale-105 hover:shadow-md' }}">
        <i class="fas fa-users transition-transform duration-300 {{ $active === 'users' ? 'rotate-0' : 'group-hover:scale-125 group-hover:rotate-12' }}"></i> 
        <span class="transition-all duration-300">Admin. usuarios</span>
    </a>
    @endif
    </nav>

    <div class="mt-auto pt-4 border-t border-gray-200">
        <div class="text-xs text-gray-400 text-center py-2">
            <i class="fas fa-code text-maroon-700"></i>
            <p class="mt-1">Versión 2.1.0</p>
        </div>
    </div>
</aside>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        
        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
    }
    
    const btn = document.getElementById('mobile-menu-btn');
    if(btn) btn.addEventListener('click', toggleSidebar);
</script>

<style>
    /* Animación para el enlace activo */
    @keyframes pulse-shadow {
        0%, 100% { box-shadow: 0 0 0 0 rgba(124, 42, 56, 0.4); }
        50% { box-shadow: 0 0 0 8px rgba(124, 42, 56, 0); }
    }
    
    .bg-maroon-700 {
        animation: pulse-shadow 2s infinite;
    }
    
    /* Hover suave en los iconos */
    @keyframes bounce-subtle {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-3px); }
    }
    
    a:hover i {
        animation: bounce-subtle 0.6s ease-in-out;
    }
</style>
