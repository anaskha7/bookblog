<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookBlog | Curaduría Literaria</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Inter"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    },
                    colors: {
                        theme: {
                            bg: '#FFFBF5',      // Warm Cream
                            text: '#1C1917',    // Warm Black
                            primary: '#A0522D', // Sienna/Brown for buttons
                            secondary: '#F59E0B', // Amber
                            surface: '#FFFFFF', // Pure white for cards
                            muted: '#78716c'    // Stone gray
                        }
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(28, 25, 23, 0.05)',
                        'hover': '0 10px 25px -5px rgba(28, 25, 23, 0.1)',
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap"
        rel="stylesheet">
    <style>
        body {
            background-color: #FFFBF5;
            color: #1C1917;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(#E7E5E4 1px, transparent 1px);
            background-size: 32px 32px;
            opacity: 0.6;
            pointer-events: none;
            z-index: -1;
        }
    </style>
</head>

<body class="antialiased min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 w-full z-50 bg-[#FFFBF5]/90 backdrop-blur-md border-b border-[#E7E5E4]">
        <div class="max-w-[1400px] mx-auto px-6 h-20 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <div
                    class="w-8 h-8 bg-theme-primary rounded-lg flex items-center justify-center text-white text-sm shadow-md group-hover:rotate-3 transition-transform">
                    <i class="fas fa-book-open"></i>
                </div>
                <span class="font-serif font-bold text-xl text-theme-text tracking-tight">BookBlog.</span>
            </a>

            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}"
                    class="text-sm font-bold text-theme-text hover:text-theme-primary transition-colors">Inicio</a>

                @auth
                    <a href="{{ route('posts.create') }}"
                        class="text-sm font-bold text-theme-text hover:text-theme-primary transition-colors">Publicar</a>

                    @if(Auth::user()->role === 'admin' || Auth::user()->is_super)
                        <a href="{{ route('admin.dashboard') }}"
                            class="text-sm font-bold text-red-600 hover:text-theme-primary transition-colors">Admin</a>
                    @endif
                @endauth
            </div>

            <!-- Auth/User -->
            <div class="flex items-center gap-3">
                @auth
                    <span class="text-sm font-serif font-semibold text-theme-text hidden sm:block">Hola,
                        {{ Auth::user()->username }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="w-10 h-10 rounded-full border border-[#E7E5E4] flex items-center justify-center text-theme-muted hover:text-red-500 hover:border-red-200 transition-colors bg-white">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm font-semibold text-theme-text hover:text-theme-primary px-4 py-2">Log In</a>
                    <a href="{{ route('register') }}"
                        class="px-5 py-2.5 rounded-full bg-theme-text text-white text-sm font-medium hover:bg-theme-primary transition-colors shadow-lg">Suscribirse</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="w-full pt-32 pb-20 px-4 md:px-8 max-w-[1400px] mx-auto flex-1">
        @if (session('success'))
            <div class="bg-green-100 border-green-200 text-green-700 border px-4 py-3 rounded-xl mb-6 flex items-center gap-3 shadow-sm max-w-4xl mx-auto"
                role="alert">
                <i class="fas fa-check-circle"></i>
                <span class="block sm:inline font-medium">{{ session('success') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 border-red-200 text-red-700 border px-4 py-3 rounded-xl mb-6 flex items-center gap-3 shadow-sm max-w-4xl mx-auto"
                role="alert">
                <i class="fas fa-exclamation-circle"></i>
                <span class="block sm:inline font-medium">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </span>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-[#E7E5E4] py-12">
        <div class="max-w-[1400px] mx-auto px-6 grid md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-2 mb-4">
                    <span class="font-serif font-bold text-xl text-theme-text">BookBlog.</span>
                </div>
                <p class="text-theme-muted text-sm leading-relaxed max-w-sm">
                    Un espacio dedicado a la literatura, donde cada libro tiene su propia historia más allá de las
                    páginas.
                </p>
            </div>
            <div>
                <h5 class="font-bold mb-4 text-theme-text">Enlaces</h5>
                <ul class="space-y-2 text-sm text-theme-muted">
                    <li><a href="{{ route('home') }}" class="hover:text-theme-primary transition-colors">Inicio</a></li>
                </ul>
            </div>
            <div>
                <h5 class="font-bold mb-4 text-theme-text">Síguenos</h5>
                <div class="flex gap-4">
                    <a href="#"
                        class="w-10 h-10 rounded-full bg-[#F5F5F4] flex items-center justify-center text-theme-text hover:bg-theme-primary hover:text-white transition-colors"><i
                            class="fab fa-twitter"></i></a>
                    <a href="#"
                        class="w-10 h-10 rounded-full bg-[#F5F5F4] flex items-center justify-center text-theme-text hover:bg-theme-primary hover:text-white transition-colors"><i
                            class="fab fa-instagram"></i></a>
                    <a href="#"
                        class="w-10 h-10 rounded-full bg-[#F5F5F4] flex items-center justify-center text-theme-text hover:bg-theme-primary hover:text-white transition-colors"><i
                            class="fab fa-github"></i></a>
                </div>
            </div>
        </div>
        <div
            class="max-w-[1400px] mx-auto px-6 mt-12 pt-8 border-t border-[#F5F5F4] text-center text-xs text-theme-muted">
            &copy; {{ date('Y') }} BookBlog Project. Todos los derechos reservados.
        </div>
    </footer>
</body>

</html>