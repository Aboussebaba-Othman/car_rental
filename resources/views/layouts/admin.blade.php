<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Car Rental System') }} - Administration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans antialiased">
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-lg transform transition-transform duration-300 lg:translate-x-0" id="sidebar">
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <div class="flex items-center">
                    <img class="h-8 w-auto" src="{{ asset('images/logo.png') }}" alt="Logo">
                    <span class="ml-3 text-xl font-bold text-gray-900">AdminPro</span>
                </div>
                <button id="close-sidebar" class="p-2 rounded-md lg:hidden hover:bg-gray-100">
                    <i class="fas fa-times text-gray-600"></i>
                </button>
            </div>
            
            <div class="px-4 py-6">
                <div class="mb-8">
                    <div class="flex items-center mb-4 px-2">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->avatar ?? asset('images/default-avatar.png') }}" alt="{{ Auth::user()->firstName }}">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-800">{{ Auth::user()->firstName }} {{ Auth::user()->lastName }}</p>
                            <p class="text-xs text-gray-500">Administrateur</p>
                        </div>
                    </div>
                    
                    <hr class="border-gray-200">
                </div>
                
                <nav class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ Request::routeIs('admin.dashboard') ? 'bg-yellow-50 text-yellow-600' : 'text-gray-600 hover:bg-yellow-50 hover:text-yellow-600' }}">
                        <i class="fas fa-tachometer-alt mr-3 text-gray-400 group-hover:text-yellow-500 {{ Request::routeIs('admin.dashboard') ? 'text-yellow-500' : '' }}"></i>
                        Tableau de bord
                    </a>
                    
                    <a href="{{ route('admin.companies.index') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ Request::routeIs('admin.companies.*') ? 'bg-yellow-50 text-yellow-600' : 'text-gray-600 hover:bg-yellow-50 hover:text-yellow-600' }}">
                        <i class="fas fa-building mr-3 text-gray-400 group-hover:text-yellow-500 {{ Request::routeIs('admin.companies.*') ? 'text-yellow-500' : '' }}"></i>
                        Entreprises
                    </a>
                    
                    <a href="#" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ Request::routeIs('admin.users.*') ? 'bg-yellow-50 text-yellow-600' : 'text-gray-600 hover:bg-yellow-50 hover:text-yellow-600' }}">
                        <i class="fas fa-users mr-3 text-gray-400 group-hover:text-yellow-500 {{ Request::routeIs('admin.users.*') ? 'text-yellow-500' : '' }}"></i>
                        Utilisateurs
                    </a>
                    
                    <a href="#" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ Request::routeIs('admin.vehicles.*') ? 'bg-yellow-50 text-yellow-600' : 'text-gray-600 hover:bg-yellow-50 hover:text-yellow-600' }}">
                        <i class="fas fa-car mr-3 text-gray-400 group-hover:text-yellow-500 {{ Request::routeIs('admin.vehicles.*') ? 'text-yellow-500' : '' }}"></i>
                        Véhicules
                    </a>
                    
                    <a href="#" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ Request::routeIs('admin.reservations.*') ? 'bg-yellow-50 text-yellow-600' : 'text-gray-600 hover:bg-yellow-50 hover:text-yellow-600' }}">
                        <i class="fas fa-calendar-alt mr-3 text-gray-400 group-hover:text-yellow-500 {{ Request::routeIs('admin.reservations.*') ? 'text-yellow-500' : '' }}"></i>
                        Réservations
                    </a>
                    
                    <a href="#" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ Request::routeIs('admin.reports.*') ? 'bg-yellow-50 text-yellow-600' : 'text-gray-600 hover:bg-yellow-50 hover:text-yellow-600' }}">
                        <i class="fas fa-chart-bar mr-3 text-gray-400 group-hover:text-yellow-500 {{ Request::routeIs('admin.reports.*') ? 'text-yellow-500' : '' }}"></i>
                        Rapports
                    </a>
                    
                    <a href="#" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ Request::routeIs('admin.settings.*') ? 'bg-yellow-50 text-yellow-600' : 'text-gray-600 hover:bg-yellow-50 hover:text-yellow-600' }}">
                        <i class="fas fa-cog mr-3 text-gray-400 group-hover:text-yellow-500 {{ Request::routeIs('admin.settings.*') ? 'text-yellow-500' : '' }}"></i>
                        Paramètres
                    </a>
                </nav>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 lg:ml-64">
            <!-- Top Navbar -->
            <div class="bg-white shadow-sm sticky top-0 z-20">
                <div class="flex justify-between items-center px-4 py-3 lg:px-8">
                    <button id="open-sidebar" class="p-2 rounded-md lg:hidden hover:bg-gray-100">
                        <i class="fas fa-bars text-gray-600"></i>
                    </button>
                    
                    <div class="flex items-center space-x-4">
                        <a href="#" class="p-2 rounded-full hover:bg-gray-100">
                            <i class="fas fa-bell text-gray-600"></i>
                        </a>
                        
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->avatar ?? asset('images/default-avatar.png') }}" alt="{{ Auth::user()->firstName }}">
                                <span class="hidden lg:block text-sm font-medium text-gray-700">{{ Auth::user()->firstName }}</span>
                                <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 hidden">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Mon profil
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Paramètres
                                </a>
                                <div class="border-t border-gray-100"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <main>
                @yield('content')
            </main>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const openSidebar = document.getElementById('open-sidebar');
            const closeSidebar = document.getElementById('close-sidebar');
            
            openSidebar.addEventListener('click', function() {
                sidebar.classList.remove('-translate-x-full');
            });
            
            closeSidebar.addEventListener('click', function() {
                sidebar.classList.add('-translate-x-full');
            });
            
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
</body>
</html>