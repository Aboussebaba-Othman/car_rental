<!-- Header/Navigation -->
<header class="bg-white shadow-md sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
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
            <div class="flex items-center space-x-6">
                <nav class="hidden md:flex space-x-6 text-gray-600">
                    <a href="#" class="font-medium hover:text-yellow-500 transition duration-300 border-b-2 border-transparent hover:border-yellow-500 py-2">Accueil</a>
                    <a href="{{ route('vehicles.index') }}" class="font-medium hover:text-yellow-500 transition duration-300 border-b-2 border-transparent hover:border-yellow-500 py-2">Véhicules</a>
                    <a href="#vehicles" class="font-medium hover:text-yellow-500 transition duration-300 border-b-2 border-transparent hover:border-yellow-500 py-2">Promotions</a>
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
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white px-6 py-2 rounded-full font-medium hover:from-yellow-600 hover:to-yellow-700 transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">S'inscrire</a>
                    @endauth
                </div>
            </div>
            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button type="button" id="mobile-menu-button" class="text-gray-500 hover:text-gray-600 focus:outline-none" aria-label="Menu">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Menu -->
<div id="menu-overlay" class="menu-overlay"></div>
<div id="mobile-menu" class="mobile-menu p-6">
    <div class="flex justify-between items-center mb-8">
        <span class="text-2xl font-bold">
            <span class="text-yellow-500">Auto</span><span class="text-gray-800">Loc</span><span class="text-yellow-500">Pro</span>
        </span>
        <button id="close-menu-button" class="text-gray-500 hover:text-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    <nav class="flex flex-col space-y-4">
        <a href="#" class="font-medium text-gray-800 hover:text-yellow-500 py-2 border-b border-gray-100">Accueil</a>
        <a href="{{ route('vehicles.index') }}" class="font-medium text-gray-800 hover:text-yellow-500 py-2 border-b border-gray-100">Véhicules</a>
        <a href="#promotions" class="font-medium text-gray-800 hover:text-yellow-500 py-2 border-b border-gray-100">Promotions</a>
        <a href="#" class="font-medium text-gray-800 hover:text-yellow-500 py-2 border-b border-gray-100">À propos</a>
        <a href="#" class="font-medium text-gray-800 hover:text-yellow-500 py-2 border-b border-gray-100">Contact</a>
    </nav>
    <div class="mt-8 space-y-4">
        @auth
            <a href="{{ route('reservations.index') }}" class="block w-full text-center py-2 px-4 bg-gray-100 rounded-lg text-gray-800 font-medium hover:bg-gray-200 transition duration-300">Mes réservations</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-center py-2 px-4 bg-gray-100 rounded-lg text-gray-800 font-medium hover:bg-gray-200 transition duration-300">Déconnexion</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="block w-full text-center py-2 px-4 bg-gray-100 rounded-lg text-gray-800 font-medium hover:bg-gray-200 transition duration-300">Connexion</a>
            <a href="{{ route('register') }}" class="block w-full text-center py-3 px-4 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg text-white font-medium hover:from-yellow-600 hover:to-yellow-700 transition duration-300 shadow-md">S'inscrire</a>
        @endauth
    </div>
</div>
