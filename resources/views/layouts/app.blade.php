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
<nav class="bg-white shadow-md fixed w-full top-0 z-50 transition-all duration-300" id="main-navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo and Brand -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center">
                    <img class="h-10 w-auto" src="{{ asset('images/logo.png') }}" alt="Logo">
                    <span class="ml-3 text-xl font-bold text-gray-900">AutoLoc<span class="text-yellow-500">Pro</span></span>
                </a>
            </div>
            
            <!-- Main Navigation - Desktop -->
            <div class="hidden md:ml-6 md:flex md:items-center md:space-x-4">
                <a href="{{ route('home') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-900 hover:bg-yellow-50 hover:text-yellow-600 transition duration-150 ease-in-out {{ Request::routeIs('home') ? 'bg-yellow-50 text-yellow-600' : '' }}">
                    Accueil
                </a>
                <a href="" class="px-3 py-2 rounded-md text-sm font-medium text-gray-900 hover:bg-yellow-50 hover:text-yellow-600 transition duration-150 ease-in-out {{ Request::routeIs('vehicles') ? 'bg-yellow-50 text-yellow-600' : '' }}">
                    Véhicules
                </a>
                <a href="" class="px-3 py-2 rounded-md text-sm font-medium text-gray-900 hover:bg-yellow-50 hover:text-yellow-600 transition duration-150 ease-in-out {{ Request::routeIs('locations') ? 'bg-yellow-50 text-yellow-600' : '' }}">
                    Emplacements
                </a>
                <a href="" class="px-3 py-2 rounded-md text-sm font-medium text-gray-900 hover:bg-yellow-50 hover:text-yellow-600 transition duration-150 ease-in-out {{ Request::routeIs('about') ? 'bg-yellow-50 text-yellow-600' : '' }}">
                    À propos
                </a>
                <a href="" class="px-3 py-2 rounded-md text-sm font-medium text-gray-900 hover:bg-yellow-50 hover:text-yellow-600 transition duration-150 ease-in-out {{ Request::routeIs('contact') ? 'bg-yellow-50 text-yellow-600' : '' }}">
                    Contact
                </a>
            </div>
            
            <!-- Right Side Buttons -->
            <div class="hidden md:flex md:items-center md:ml-6">
                <div class="flex-shrink-0 flex items-center ml-4">
                    @auth
                        <!-- User Dropdown -->
                        <div class="ml-3 relative" x-data="{ open: false }">
                            <div>
                                <button @click="open = !open" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->avatar ?? asset('images/default-avatar.png') }}" alt="{{ Auth::user()->name }}">
                                    <span class="ml-2 flex items-center text-gray-700">
                                        {{ Auth::user()->name }}
                                        <svg class="ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </button>
                            </div>
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-100" 
                                 x-transition:enter-start="transform opacity-0 scale-95" 
                                 x-transition:enter-end="transform opacity-100 scale-100" 
                                 x-transition:leave="transition ease-in duration-75" 
                                 x-transition:leave-start="transform opacity-100 scale-100" 
                                 x-transition:leave-end="transform opacity-0 scale-95" 
                                 class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg">
                                <div class="py-1 rounded-md bg-white shadow-xs hidden">
                                    <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-600">
                                        Mon profil
                                    </a>
                                    <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-600">
                                        Mes réservations
                                    </a>
                                    @if(Auth::user()->isAdmin() || Auth::user()->isCompany())                                    <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-600">
                                        Tableau de bord
                                    </a>
                                    @endif
                                    <div class="border-t border-gray-100"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-600">
                                            Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Login and Register Buttons -->
                        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out">
                            Se connecter
                        </a>
                        <a href="{{ route('register') }}" class="ml-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out">
                            S'inscrire
                        </a>
                    @endauth
                </div>
            </div>
            
            <!-- Mobile menu button -->
            <div class="flex items-center md:hidden">
                <button id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-yellow-500 hover:bg-yellow-50 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-yellow-500">
                    <svg id="menu-open-icon" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="menu-close-icon" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 shadow-inner">
        <div class="pt-2 pb-3 space-y-1 px-4 sm:px-6">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium 'bg-yellow-50 text-yellow-600' : 'text-gray-900 hover:bg-yellow-50 hover:text-yellow-600' }}">
                Accueil
            </a>
            <a href="" class="block px-3 py-2 rounded-md text-base font-medium 'bg-yellow-50 text-yellow-600' : 'text-gray-900 hover:bg-yellow-50 hover:text-yellow-600' }}">
                Véhicules
            </a>
            <a href="" class="block px-3 py-2 rounded-md text-base font-medium  'bg-yellow-50 text-yellow-600' : 'text-gray-900 hover:bg-yellow-50 hover:text-yellow-600' }}">
                Emplacements
            </a>
            <a href="" class="block px-3 py-2 rounded-md text-base font-medium 'bg-yellow-50 text-yellow-600' : 'text-gray-900 hover:bg-yellow-50 hover:text-yellow-600' }}">
                À propos
            </a>
            <a href="" class="block px-3 py-2 rounded-md text-base font-medium 'bg-yellow-50 text-yellow-600' : 'text-gray-900 hover:bg-yellow-50 hover:text-yellow-600' }}">
                Contact
            </a>
        </div>
        
        <div class="pt-4 pb-3 border-t border-gray-200">
            @auth
                <!-- User Info -->
                <div class="flex items-center px-4 sm:px-6">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url ?? asset('images/default-avatar.png') }}" alt="{{ Auth::user()->name }}">
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                
                <!-- User Links -->
                <div class="mt-3 space-y-1 px-4 sm:px-6">
                    <a href=" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-yellow-50 hover:text-yellow-600">
                        Mon profil
                    </a>
                    <a href=" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-yellow-50 hover:text-yellow-600">
                        Mes réservations
                    </a>
                    @if(Auth::user()->isAdmin() || Auth::user()->isCompany())
                    <a href="" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-yellow-50 hover:text-yellow-600">
                        Tableau de bord
                    </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-yellow-50 hover:text-yellow-600">
                            Déconnexion
                        </button>
                    </form>
                </div>
            @else
                <!-- Login and Register Mobile -->
                <div class="space-y-1 px-4 sm:px-6">
                    <a href="{{ route('login') }}" class="flex items-center justify-center w-full px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out">
                        Se connecter
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center justify-center w-full mt-3 px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out">
                        S'inscrire
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>

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