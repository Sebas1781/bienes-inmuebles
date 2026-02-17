<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Carga los assets con Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }

        /* Colores personalizados Maroon */
        .bg-header { background-color: #9b4d5c; }
        .bg-maroon-700 { background-color: #7c2a38; }
        .bg-maroon-800 { background-color: #651f2e; }
        .text-maroon-700 { color: #7c2a38; }
        .bg-maroon-100 { background-color: #f8e4ea; }
        .hover\:bg-maroon-100:hover { background-color: #f8e4ea; }
        .hover\:bg-maroon-800:hover { background-color: #651f2e; }
        .focus\:ring-maroon-700:focus {
            --tw-ring-color: #7c2a38;
            --tw-ring-opacity: 1;
        }
        .border-maroon-700 { border-color: #7c2a38; }

        /* Animación de entrada del contenido principal */
        main {
            animation: fadeInContent 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes fadeInContent {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Transiciones suaves en enlaces */
        a {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Efecto de salida */
        main.page-transition-exit {
            animation: fadeOutContent 0.25s ease-in-out forwards;
        }

        @keyframes fadeOutContent {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-8px);
            }
        }

        /* Scrollbar global elegante */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(124, 42, 56, 0.15); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(124, 42, 56, 0.3); }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen antialiased">
    @yield('content')
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('a[href^="/"]');

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.target === '_blank' || this.getAttribute('onclick')) {
                        return;
                    }

                    const href = this.getAttribute('href');

                    if (href && href !== '#' && !href.includes('logout')) {
                        e.preventDefault();

                        const mainContent = document.querySelector('main');
                        if (mainContent) {
                            mainContent.classList.add('page-transition-exit');
                        }

                        setTimeout(() => {
                            window.location.href = href;
                        }, 250);
                    }
                });
            });
        });
    </script>
</body>
</html>
