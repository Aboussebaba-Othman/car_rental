<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Car Rental System') }} - Administration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        /* Other custom styles */
        .sidebar-menu-item {
            transition: all 0.2s;
            border-radius: 0.5rem;
            margin-bottom: 0.25rem;
        }
        
        .dropdown-animation {
            transition: all 0.3s ease;
        }
        
        .nav-shadow {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        
        .content-area {
            min-height: calc(100vh - 64px);
        }
        
        /* Statistics Card Styles */
        .stats-card {
            transition: all 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .stats-card .icon-bg {
            transition: all 0.3s ease;
        }
        
        .stats-card:hover .icon-bg {
            transform: scale(1.2);
        }
        
        /* Stat Grid Animation */
        .stat-grid-item {
            transition: all 0.2s ease;
        }
        
        .stat-grid-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar with updated color scheme -->
        <div class="fixed inset-y-0 left-0 z-30 w-64 bg-blue-900 shadow-lg transform transition-transform duration-300 lg:translate-x-0" id="sidebar">
            <!-- Logo and Brand -->
            <div class="flex items-center justify-between px-6 py-5 border-b border-blue-800">
                <div class="flex items-center">
                    <div class="flex items-center">
                        <div class="bg-yellow-500 text-white p-2 rounded-lg shadow-md mr-2">
                            <i class="fas fa-car text-xl"></i>
                        </div>
                        <span class="text-2xl font-bold">
                            <span class="text-yellow-400">Auto</span><span class="text-white">Loc</span><span class="text-yellow-400">Pro</span>
                        </span>
                    </div>
                </div>
                <button id="close-sidebar" class="p-2 rounded-md lg:hidden hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-700">
                    <i class="fas fa-times text-white"></i>
                </button>
            </div>
            
            <!-- User Profile Summary -->
            <div class="px-6 py-6">
                <div class="mb-6">
                    <div class="flex items-center px-2 pb-4 border-b border-blue-800">
                        <div class="bg-blue-800 h-12 w-12 rounded-full flex items-center justify-center mr-4">
                            @if(Auth::user()->avatar)
                                <img class="h-12 w-12 rounded-full object-cover" src="{{ Storage::url(Auth::user()->avatar) }}" alt="{{ Auth::user()->firstName }}">
                            @else
                                <span class="text-lg font-bold text-yellow-400">{{ substr(Auth::user()->firstName, 0, 1) }}{{ substr(Auth::user()->lastName, 0, 1) }}</span>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white">{{ Auth::user()->firstName }} {{ Auth::user()->lastName }}</p>
                            <div class="flex items-center mt-1">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-800 text-yellow-300">
                                    <i class="fas fa-shield-alt mr-1 text-xs"></i> Administrateur
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation Menu -->
                <nav class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-item group flex items-center px-4 py-3 text-base font-medium {{ Request::routeIs('admin.dashboard') ? 'bg-blue-800 text-white' : 'text-blue-100 hover:bg-blue-800 hover:text-white' }}">
                        <i class="fas fa-tachometer-alt text-xl w-6 mr-3 text-center {{ Request::routeIs('admin.dashboard') ? 'text-yellow-400' : 'text-blue-300 group-hover:text-yellow-400' }}"></i>
                        <span>Tableau de bord</span>
                    </a>
                    
                    <a href="{{ route('admin.companies.index') }}" class="sidebar-menu-item group flex items-center px-4 py-3 text-base font-medium {{ Request::routeIs('admin.companies.*') ? 'bg-blue-800 text-white' : 'text-blue-100 hover:bg-blue-800 hover:text-white' }}">
                        <i class="fas fa-building text-xl w-6 mr-3 text-center {{ Request::routeIs('admin.companies.*') ? 'text-yellow-400' : 'text-blue-300 group-hover:text-yellow-400' }}"></i>
                        <span>Entreprises</span>
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}" class="sidebar-menu-item group flex items-center px-4 py-3 text-base font-medium {{ Request::routeIs('admin.users.*') ? 'bg-blue-800 text-white' : 'text-blue-100 hover:bg-blue-800 hover:text-white' }}">
                        <i class="fas fa-users text-xl w-6 mr-3 text-center {{ Request::routeIs('admin.users.*') ? 'text-yellow-400' : 'text-blue-300 group-hover:text-yellow-400' }}"></i>
                        <span>Utilisateurs</span>
                    </a>
                    
                    <a href="{{ route('admin.vehicles.index') }}" class="sidebar-menu-item group flex items-center px-4 py-3 text-base font-medium {{ Request::routeIs('admin.vehicles.*') ? 'bg-blue-800 text-white' : 'text-blue-100 hover:bg-blue-800 hover:text-white' }}">
                        <i class="fas fa-car text-xl w-6 mr-3 text-center {{ Request::routeIs('admin.vehicles.*') ? 'text-yellow-400' : 'text-blue-300 group-hover:text-yellow-400' }}"></i>
                        <span>Véhicules</span>
                    </a>
                    
                    <a href="{{ route('admin.reservations.index') }}" class="sidebar-menu-item group flex items-center px-4 py-3 text-base font-medium {{ Request::routeIs('admin.reservations.*') ? 'bg-blue-800 text-white' : 'text-blue-100 hover:bg-blue-800 hover:text-white' }}">
                        <i class="fas fa-calendar-alt text-xl w-6 mr-3 text-center {{ Request::routeIs('admin.reservations.*') ? 'text-yellow-400' : 'text-blue-300 group-hover:text-yellow-400' }}"></i>
                        <span>Réservations</span>
                    </a>
                </nav>
            </div>
            
            <!-- Sidebar Footer -->
            <div class="absolute bottom-0 w-full p-4 border-t border-blue-800">
                <a href="{{ route('home') }}" class="flex items-center text-sm text-blue-200 hover:text-yellow-300">
                    <i class="fas fa-external-link-alt mr-2"></i>
                    Voir le site
                </a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-64">
            <!-- Top Navbar -->
            <div class="bg-white nav-shadow sticky top-0 z-20">
                <div class="flex justify-between items-center px-4 py-4 lg:px-8">
                    <button id="open-sidebar" class="p-2 rounded-md lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                        <i class="fas fa-bars text-gray-600"></i>
                    </button>
                    
                    <!-- Breadcrumb - could be dynamic based on routes -->
                    <div class="hidden md:block">
                        <ol class="flex items-center space-x-1 text-sm">
                            <li><a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-yellow-600">Admin</a></li>
                            @if(Request::route() && Request::route()->getName() !== 'admin.dashboard')
                                <li><span class="text-gray-400 mx-1">/</span></li>
                                <li class="text-gray-700 font-medium">{{ ucfirst(explode('.', Request::route()->getName())[1] ?? '') }}</li>
                            @endif
                        </ol>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="p-2 rounded-full hover:bg-gray-100 focus:outline-none">
                                <div class="relative">
                                    <i class="fas fa-bell text-gray-600"></i>
                                    <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500"></span>
                                </div>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-80 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 dropdown-animation hidden z-50">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-sm font-medium text-gray-700">Notifications</p>
                                </div>
                                <div class="max-h-64 overflow-y-auto">
                                    <a href="#" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                    <i class="fas fa-user-plus text-blue-500"></i>
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-700">Nouveau client inscrit</p>
                                                <p class="text-xs text-gray-500">Il y a 10 minutes</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="block px-4 py-3 hover:bg-gray-50">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <div class="h-8 w-8 rounded-full bg-yellow-100 flex items-center justify-center">
                                                    <i class="fas fa-calendar-check text-yellow-500"></i>
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-700">Nouvelle réservation</p>
                                                <p class="text-xs text-gray-500">Il y a 1 heure</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="border-t border-gray-100 py-2 px-4">
                                    <a href="#" class="text-xs text-center block text-blue-600 hover:text-blue-800">
                                        Voir toutes les notifications
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                <div class="bg-yellow-100 h-10 w-10 rounded-full flex items-center justify-center">
                                    @if(Auth::user()->avatar)
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Storage::url(Auth::user()->avatar) }}" alt="{{ Auth::user()->firstName }}">
                                    @else
                                        <span class="text-sm font-medium text-yellow-700">{{ substr(Auth::user()->firstName, 0, 1) }}{{ substr(Auth::user()->lastName, 0, 1) }}</span>
                                    @endif
                                </div>
                                <div class="hidden lg:block text-left">
                                    <p class="text-sm font-medium text-gray-700">{{ Auth::user()->firstName }}</p>
                                    <p class="text-xs text-gray-500">Admin</p>
                                </div>
                                <i class="hidden lg:block fas fa-chevron-down text-xs text-gray-400"></i>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 dropdown-animation hidden z-50">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2 text-gray-500"></i> Mon profil
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2 text-gray-500"></i> Paramètres
                                </a>
                                <div class="border-t border-gray-100"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2 text-gray-500"></i> Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Page Content Area -->
            <main class="flex-1 overflow-auto content-area p-2">
                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 py-4 px-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="text-center md:text-left mb-2 md:mb-0">
                        <p class="text-sm text-gray-500">&copy; {{ date('Y') }} AutoLocPro. Tous droits réservés.</p>
                    </div>
                    <div class="flex justify-center md:justify-end space-x-4">
                        <a href="#" class="text-gray-400 hover:text-gray-600">
                            <i class="fab fa-facebook-square text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-600">
                            <i class="fab fa-twitter-square text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-600">
                            <i class="fab fa-instagram-square text-lg"></i>
                        </a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const openSidebar = document.getElementById('open-sidebar');
            const closeSidebar = document.getElementById('close-sidebar');
            
            if (openSidebar) {
                openSidebar.addEventListener('click', function() {
                    sidebar.classList.remove('-translate-x-full');
                });
            }
            
            if (closeSidebar) {
                closeSidebar.addEventListener('click', function() {
                    sidebar.classList.add('-translate-x-full');
                });
            }
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    sidebar.classList.remove('-translate-x-full');
                }
            });
            
            // Initialize Alpine.js components
            document.querySelectorAll('[x-data]').forEach(element => {
                if (element.getAttribute('x-data') === '{ open: false }') {
                    const button = element.querySelector('button');
                    const dropdown = element.querySelector('[x-show="open"]');
                    
                    if (button && dropdown) {
                        button.addEventListener('click', function() {
                            const isOpen = dropdown.classList.contains('hidden');
                            if (isOpen) {
                                dropdown.classList.remove('hidden');
                            } else {
                                dropdown.classList.add('hidden');
                            }
                        });
                        
                        document.addEventListener('click', function(event) {
                            if (!element.contains(event.target)) {
                                dropdown.classList.add('hidden');
                            }
                        });
                    }
                }
            });
        });
    </script>
    @yield('scripts')
</body>
</html>