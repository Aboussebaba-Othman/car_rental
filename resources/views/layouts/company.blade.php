<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Car Rental') }} - @yield('title', 'Company Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        /* Custom styles that can't be done with utility classes */
        .bg-gradient-sidebar {
            background: linear-gradient(to bottom, #1e40af, #1e3a8a);
        }
        
        .menu-item-hover:hover {
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.1);
            transform: translateX(4px);
        }
        
        .sidebar-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.1), transparent);
        }
        
        /* Animation for sidebar */
        .sidebar-enter-active,
        .sidebar-leave-active {
            transition: transform 0.3s ease, opacity 0.3s ease;
        }
        
        .sidebar-enter-from,
        .sidebar-leave-to {
            opacity: 0;
            transform: translateX(-100%);
        }
        
        /* Mobile responsive styles */
        @media (max-width: 768px) {
            .sidebar-mobile {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                z-index: 50;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                width: 256px;
            }
            
            .sidebar-mobile.open {
                transform: translateX(0);
                box-shadow: 4px 0 15px rgba(0, 0, 0, 0.2);
            }
            
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 40;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.3s ease;
            }
            
            .sidebar-overlay.active {
                opacity: 1;
                pointer-events: auto;
            }
            
            /* Animations for menu items */
            .mobile-menu-item {
                transform: translateX(-20px);
                opacity: 0;
                transition: transform 0.3s ease, opacity 0.3s ease;
            }
            
            .sidebar-mobile.open .mobile-menu-item {
                transform: translateX(0);
                opacity: 1;
            }
            
            .sidebar-mobile.open .mobile-menu-item:nth-child(1) { transition-delay: 0.05s; }
            .sidebar-mobile.open .mobile-menu-item:nth-child(2) { transition-delay: 0.1s; }
            .sidebar-mobile.open .mobile-menu-item:nth-child(3) { transition-delay: 0.15s; }
            .sidebar-mobile.open .mobile-menu-item:nth-child(4) { transition-delay: 0.2s; }
            .sidebar-mobile.open .mobile-menu-item:nth-child(5) { transition-delay: 0.25s; }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex">
        <!-- Mobile Sidebar Toggle -->
        <div 
            @click="sidebarOpen = false" 
            class="sidebar-overlay"
            :class="{'active': sidebarOpen}">
        </div>
        
        <!-- Mobile Menu Button -->
        <button 
            @click="sidebarOpen = !sidebarOpen" 
            class="md:hidden fixed bottom-6 right-6 z-50 p-3 rounded-full bg-indigo-600 text-white shadow-lg focus:outline-none hover:bg-indigo-700 transition duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :class="{'hidden': sidebarOpen}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :class="{'hidden': !sidebarOpen}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        
        <!-- Sidebar Navigation -->
        <aside 
            class="w-64 bg-gradient-sidebar h-screen md:sticky top-0 shadow-xl sidebar-mobile"
            :class="{'open': sidebarOpen}">
            <div class="py-6 px-4">
                <!-- Logo Section -->
                <div class="flex items-center justify-center mb-8">
                    <a href="{{ route('company.dashboard') }}" class="text-white text-xl font-bold">
                        <div class="flex items-center">
                            <div class="bg-white p-2 rounded-lg shadow-lg mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-xl font-bold tracking-wider">AutoLoc<span class="text-yellow-500">Pro</span> </span>
                        </div>
                    </a>
                </div>
                
                <nav>
                    <ul class="space-y-1">
                        <!-- Dashboard -->
                        <li class="mobile-menu-item">
                            <a href="{{ route('company.dashboard') }}" 
                               class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 menu-item-hover {{ request()->routeIs('company.dashboard') ? 'bg-blue-600 shadow-md' : 'hover:bg-blue-700/30' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span class="font-medium">Dashboard</span>
                            </a>
                        </li>
                        
                        <!-- Vehicles -->
                        <li class="mobile-menu-item">
                            <a href="{{ route('company.vehicles.index') }}" 
                               class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 menu-item-hover {{ request()->routeIs('company.vehicles.*') ? 'bg-blue-600 shadow-md' : 'hover:bg-blue-700/30' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <span class="font-medium">Vehicles</span>
                            </a>
                        </li>
                        
                        <div class="sidebar-divider my-4"></div>
                        
                        <!-- Reservations -->
                        <li class="mobile-menu-item">
                            <a href="{{ route('company.reservations.index') }}" 
                               class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 menu-item-hover {{ request()->routeIs('company.reservations.*') ? 'bg-blue-600 shadow-md' : 'hover:bg-blue-700/30' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="font-medium">Reservations</span>
                            </a>
                        </li>
                        
                        <!-- Offers & Promotions -->
                        <li class="mobile-menu-item">
                            <a href="{{ route('company.promotions.index') }}" 
                               class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 menu-item-hover hover:bg-blue-700/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="font-medium">Offers & Promotions</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                
                <!-- User Profile Section -->
                <div class="mt-8">
                    <div class="sidebar-divider mb-4"></div>
                    <div class="flex items-center p-3 bg-blue-700/20 rounded-lg">
                        <img class="h-10 w-10 rounded-full object-cover border-2 border-white" 
                             src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF" 
                             alt="User avatar">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-blue-200">Company Admin</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Top Navigation -->
            <header class="bg-white shadow-md">
                <div class="py-4 px-6 flex justify-between items-center">
                    <div class="flex items-center">
                        <!-- Mobile Menu Toggle for header -->
                        <button 
                            @click="sidebarOpen = !sidebarOpen"
                            class="text-gray-500 hover:text-indigo-600 md:hidden mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        
                        <h1 class="text-xl font-bold text-gray-800">@yield('header', 'Dashboard')</h1>
                        <span class="ml-3 px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 hidden md:inline-block">Company Portal</span>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Search -->
                        <div class="relative hidden md:block">
                            <input type="text" class="bg-gray-100 rounded-lg pl-10 pr-4 py-2 text-sm w-64 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white" placeholder="Search...">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        
                       
                        
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-gray-700 hover:text-blue-600 focus:outline-none transition">
                                <span class="mr-2 font-medium">{{ Auth::user()->firstName }} {{ Auth::user()->lastName }}</span>
                                <img class="h-9 w-9 rounded-full object-cover border-2 border-blue-100" 
                                     src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->fisrtName) }} {{ urlencode(Auth::user()->lastName) }}&color=7F9CF5&background=EBF4FF" 
                                     alt="User avatar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50">
                                <div class="px-4 py-2 border-b">
                                    <p class="text-xs text-gray-500">Signed in as</p>
                                    <p class="text-sm font-medium text-gray-800">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Profile
                                    </div>
                                </a>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-red-600">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            Logout
                                        </div>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="py-6 px-4 md:px-6">
                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="bg-white py-4 px-6 border-t">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-sm text-gray-500 mb-3 md:mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'Car Rental') }}. All rights reserved.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-sm text-gray-500 hover:text-blue-600">Privacy Policy</a>
                        <a href="#" class="text-sm text-gray-500 hover:text-blue-600">Terms of Service</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('dropdown', () => ({
                open: false,
                toggle() {
                    this.open = !this.open;
                },
                closeOnClickOutside(event) {
                    if (!this.$el.contains(event.target)) {
                        this.open = false;
                    }
                }
            }));
        });

        // Fermer le sidebar lorsqu'on clique sur un lien (pour mobile)
        document.querySelectorAll('.sidebar-mobile a').forEach(link => {
            link.addEventListener('click', () => {
                const sidebarEl = document.querySelector('.sidebar-mobile');
                if (window.innerWidth < 768 && sidebarEl.classList.contains('open')) {
                    // Accès à Alpine.js state
                    const alpineComponent = Alpine.getComponent(document.body);
                    if (alpineComponent) {
                        alpineComponent.sidebarOpen = false;
                    }
                }
            });
        });

        // Ajoutez cet événement global pour fermer les menus au clic en dehors
        document.addEventListener('click', (event) => {
            document.querySelectorAll('[x-data]').forEach((element) => {
                if (element.__x) {
                    element.__x.callMethod('closeOnClickOutside', event);
                }
            });
        });
    </script>
</body>
</html>