<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Car Rental System') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- Navbar Component -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center">
                            <span class="text-3xl font-bold text-yellow-500">AutoLocPro</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-6">
                        <nav class="hidden md:flex space-x-4 text-gray-600">
                            <a href="#" class="font-medium hover:text-yellow-500 transition duration-300">Accueil</a>
                            <a href="#" class="font-medium hover:text-yellow-500 transition duration-300">Véhicules</a>
                            <a href="#" class="font-medium hover:text-yellow-500 transition duration-300">Promotions</a>
                            <a href="#" class="font-medium hover:text-yellow-500 transition duration-300">À propos</a>
                            <a href="#" class="font-medium hover:text-yellow-500 transition duration-300">Contact</a>
                        </nav>
                        <div class="flex items-center space-x-4">
                            @auth
                                <a href="{{ route('reservations.index') }}" class="text-gray-600 hover:text-yellow-600 font-medium transition duration-300">Mes réservations</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="text-gray-600 hover:text-yellow-600 font-medium transition duration-300">Déconnexion</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-600 hover:text-yellow-600 font-medium transition duration-300">Connexion</a>
                                <a href="{{ route('register') }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-yellow-600 transition duration-300">S'inscrire</a>
                            @endauth
                        </div>
                    </div>
                    <!-- Mobile menu button -->
                    <div class="md:hidden flex items-center">
                        <button type="button" class="text-gray-500 hover:text-gray-600 focus:outline-none" aria-label="Menu">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </header>

<!-- Spacer to prevent content from being hidden behind fixed navbar -->
<div class="h-16"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuOpenIcon = document.getElementById('menu-open-icon');
    const menuCloseIcon = document.getElementById('menu-close-icon');
    
    mobileMenuButton.addEventListener('click', function() {
        mobileMenu.classList.toggle('hidden');
        menuOpenIcon.classList.toggle('hidden');
        menuCloseIcon.classList.toggle('hidden');
    });
    
    // Navbar scroll effect
    const navbar = document.getElementById('main-navbar');
    let lastScrollTop = 0;
    
    window.addEventListener('scroll', function() {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // Add shadow and change background when scrolling down
        if (scrollTop > 10) {
            navbar.classList.add('shadow-lg', 'bg-white/95', 'backdrop-blur-sm');
        } else {
            navbar.classList.remove('shadow-lg', 'bg-white/95', 'backdrop-blur-sm');
        }
        
        // Hide navbar when scrolling down, show when scrolling up
        if (scrollTop > lastScrollTop && scrollTop > 200) {
            navbar.style.transform = 'translateY(-100%)';
        } else {
            navbar.style.transform = 'translateY(0)';
        }
        
        lastScrollTop = scrollTop;
    });
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        const isClickInsideMenu = mobileMenu.contains(event.target);
        const isClickInsideButton = mobileMenuButton.contains(event.target);
        
        if (!isClickInsideMenu && !isClickInsideButton && !mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.add('hidden');
            menuOpenIcon.classList.remove('hidden');
            menuCloseIcon.classList.add('hidden');
        }
    });
    
    // Close mobile menu when window is resized to desktop size
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768 && !mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.add('hidden');
            menuOpenIcon.classList.remove('hidden');
            menuCloseIcon.classList.add('hidden');
        }
    });
});
</script>

        <main class="py-6">
            @yield('content')
        </main>
    </div>
</body>
</html>