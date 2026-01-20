<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Carga los assets con Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Colores personalizados Maroon - Fallback para navegadores */
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

        /* Animación de desvanecimiento SOLO para el contenido principal */
        main {
            animation: fadeInContent 0.5s ease-in-out;
        }

        @keyframes fadeInContent {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Animación suave al hacer clic en enlaces */
        a {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Efecto de desvanecimiento al salir - SOLO MAIN */
        main.page-transition-exit {
            animation: fadeOutContent 0.3s ease-in-out forwards;
        }

        @keyframes fadeOutContent {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-10px);
            }
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen">
    @yield('content')
    @stack('scripts')

    <script>
        // Animación de transición suave entre páginas - SOLO CONTENIDO PRINCIPAL
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

                        // Aplicar animación solo al main
                        const mainContent = document.querySelector('main');
                        if (mainContent) {
                            mainContent.classList.add('page-transition-exit');
                        }

                        setTimeout(() => {
                            window.location.href = href;
                        }, 300);
                    }
                });
            });
        });
    </script>
</body>
</html>
