@props(['active' => ''])

<div id="sidebar-overlay" onclick="toggleSidebar()"
     class="fixed inset-0 bg-black/30 backdrop-blur-sm z-40 hidden md:hidden transition-all duration-300">
</div>

<aside id="sidebar"
       class="sidebar-glass w-64 py-6 px-4 flex flex-col
              fixed top-0 left-0 bottom-0 z-[55] transition-transform duration-300 ease-in-out transform -translate-x-full
              md:relative md:translate-x-0 md:z-auto md:sticky md:top-0 md:h-[calc(100vh-56px)] overflow-y-auto">

    <div class="flex justify-end md:hidden mb-2">
        <button onclick="toggleSidebar()" class="text-gray-400 hover:text-maroon-700 p-2 transition-transform hover:scale-110">
            <i class="fas fa-times text-2xl"></i>
        </button>
    </div>

    <nav class="flex-1 flex flex-col gap-2">

    <a href="{{ route('properties.create') }}"
       class="sidebar-link flex items-center gap-3 py-3 px-4 rounded-xl font-semibold transition-all duration-300 group
              {{ $active === 'create' ? 'sidebar-link-active' : 'text-maroon-700 hover:bg-maroon-100/70 hover:shadow-md' }}">
        <div class="sidebar-icon-wrap {{ $active === 'create' ? 'bg-white/20' : 'bg-maroon-100' }}">
            <i class="fas fa-plus-square transition-transform duration-300 {{ $active === 'create' ? 'text-white' : 'text-maroon-700 group-hover:scale-110' }}"></i>
        </div>
        <span class="transition-all duration-300">Agregar inmueble</span>
    </a>

    <a href="{{ route('dashboard') }}"
       class="sidebar-link flex items-center gap-3 py-3 px-4 rounded-xl font-semibold transition-all duration-300 group
              {{ $active === 'dashboard' ? 'sidebar-link-active' : 'text-maroon-700 hover:bg-maroon-100/70 hover:shadow-md' }}">
        <div class="sidebar-icon-wrap {{ $active === 'dashboard' ? 'bg-white/20' : 'bg-maroon-100' }}">
            <i class="fas fa-warehouse transition-transform duration-300 {{ $active === 'dashboard' ? 'text-white' : 'text-maroon-700 group-hover:scale-110' }}"></i>
        </div>
        <span class="transition-all duration-300">Admin. inmuebles</span>
    </a>

    @if(auth()->user()->isSuperAdmin())
    <a href="{{ route('users.index') }}"
       class="sidebar-link flex items-center gap-3 py-3 px-4 rounded-xl font-semibold transition-all duration-300 group
              {{ $active === 'users' ? 'sidebar-link-active' : 'text-maroon-700 hover:bg-maroon-100/70 hover:shadow-md' }}">
        <div class="sidebar-icon-wrap {{ $active === 'users' ? 'bg-white/20' : 'bg-maroon-100' }}">
            <i class="fas fa-users transition-transform duration-300 {{ $active === 'users' ? 'text-white' : 'text-maroon-700 group-hover:scale-110' }}"></i>
        </div>
        <span class="transition-all duration-300">Admin. usuarios</span>
    </a>
    @endif
    </nav>

    <div class="mt-auto pt-4 border-t border-gray-200/60">
        <div class="text-xs text-gray-400 text-center py-2 flex flex-col items-center gap-1">
            <div class="w-8 h-8 rounded-full bg-maroon-100 flex items-center justify-center">
                <i class="fas fa-code text-maroon-700 text-xs"></i>
            </div>
            <p class="mt-1 font-medium">Versión 2.1.0</p>
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
    .sidebar-glass {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-right: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 4px 0 24px -6px rgba(0, 0, 0, 0.08);
    }

    .sidebar-icon-wrap {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .sidebar-link-active {
        background: linear-gradient(135deg, #7c2a38 0%, #a0374a 100%);
        color: white;
        box-shadow: 0 4px 15px -3px rgba(124, 42, 56, 0.5);
        transform: scale(1.02);
    }

    .sidebar-link {
        position: relative;
        overflow: hidden;
    }

    .sidebar-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 0;
        height: 60%;
        background: linear-gradient(135deg, #7c2a38, #a0374a);
        border-radius: 0 4px 4px 0;
        transition: width 0.3s ease;
    }

    .sidebar-link:hover::before {
        width: 3px;
    }

    .sidebar-link-active::before {
        display: none;
    }

    /* Scrollbar del sidebar */
    #sidebar::-webkit-scrollbar {
        width: 4px;
    }
    #sidebar::-webkit-scrollbar-track {
        background: transparent;
    }
    #sidebar::-webkit-scrollbar-thumb {
        background: rgba(124, 42, 56, 0.2);
        border-radius: 10px;
    }
    #sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(124, 42, 56, 0.4);
    }
</style>
