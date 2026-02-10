<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookBlog | Curaduría Literaria</title>
    <!-- Tailwind -->
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
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap"
        rel="stylesheet">

    <style>
        body {
            background-color: #FFFBF5;
            color: #1C1917;
        }

        /* Subtle Grid Pattern */
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

    <!-- Navbar: Simple & Clean (Editorial Style) -->
    <nav class="fixed top-0 left-0 w-full z-50 bg-[#FFFBF5]/90 backdrop-blur-md border-b border-[#E7E5E4]">
        <div class="max-w-[1400px] mx-auto px-6 h-20 flex items-center justify-between">
            <!-- Logo -->
            <a href="<?= BASE_URL ?>" class="flex items-center gap-2 group">
                <div
                    class="w-8 h-8 bg-theme-primary rounded-lg flex items-center justify-center text-white text-sm shadow-md group-hover:rotate-3 transition-transform">
                    <i class="fas fa-book-open"></i>
                </div>
                <span class="font-serif font-bold text-xl text-theme-text tracking-tight">BookBlog.</span>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-8">
                <a href="<?= BASE_URL ?>"
                    class="text-sm font-bold text-theme-text hover:text-theme-primary transition-colors">Inicio</a>

                <?php if (!empty($_SESSION['user_id'])): ?>
                    <a href="<?= BASE_URL ?>?controller=post&action=create"
                        class="text-sm font-bold text-theme-text hover:text-theme-primary transition-colors">Publicar</a>
                <?php endif; ?>

                <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
                    <a href="<?= BASE_URL ?>?controller=admin&action=dashboard"
                        class="text-sm font-bold text-red-600 hover:text-theme-primary transition-colors">Admin</a>
                <?php endif; ?>


            </div>

            <!-- Auth/User -->
            <div class="flex items-center gap-3">
                <?php if (!empty($_SESSION['user_id'])): ?>
                    <span class="text-sm font-serif font-semibold text-theme-text hidden sm:block">Hola,
                        <?= htmlspecialchars($_SESSION['name']) ?></span>
                    <a href="<?= BASE_URL ?>?controller=user&action=logout"
                        class="w-10 h-10 rounded-full border border-[#E7E5E4] flex items-center justify-center text-theme-muted hover:text-red-500 hover:border-red-200 transition-colors bg-white">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>?controller=user&action=login"
                        class="text-sm font-semibold text-theme-text hover:text-theme-primary px-4 py-2">
                        Log In
                    </a>
                    <a href="<?= BASE_URL ?>?controller=user&action=register"
                        class="px-5 py-2.5 rounded-full bg-theme-text text-white text-sm font-medium hover:bg-theme-primary transition-colors shadow-lg">
                        Suscribirse
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="w-full pt-32 pb-20 px-4 md:px-8 max-w-[1400px] mx-auto flex-1">
        <?php if (isset($_SESSION['flash'])): ?>
            <?php
            $f = $_SESSION['flash'];
            $bg = $f['type'] === 'error' ? 'bg-red-100 border-red-200 text-red-700' : 'bg-green-100 border-green-200 text-green-700';
            $icon = $f['type'] === 'error' ? 'fa-exclamation-circle' : 'fa-check-circle';
            ?>
            <div class="<?= $bg ?> border px-4 py-3 rounded-xl mb-6 flex items-center gap-3 shadow-sm max-w-4xl mx-auto"
                role="alert">
                <i class="fas <?= $icon ?>"></i>
                <span class="block sm:inline font-medium"><?= htmlspecialchars($f['message']) ?></span>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>