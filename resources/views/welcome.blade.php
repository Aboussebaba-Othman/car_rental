<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoLocPro - Location de véhicules</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.8s ease forwards;
        }
        
        .animate-slide-up {
            animation: slideUp 0.8s ease forwards;
        }
        
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        
        /* Hero section */
        .hero-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
        }
        
        .curved-bottom {
            position: relative;
        }
        
        .curved-bottom::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 80px;
            background-color: #fff;
            border-top-left-radius: 50% 100%;
            border-top-right-radius: 50% 100%;
            transform: translateY(50%);
        }
        
        /* Vehicle gallery */
        .vehicle-gallery {
            position: relative;
            overflow: hidden;
            border-radius: 0.75rem 0.75rem 0 0;
        }
        
        .gallery-container {
            display: flex;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .gallery-slide {
            min-width: 100%;
        }
        
        .gallery-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            width: 2.5rem;
            height: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            opacity: 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .vehicle-gallery:hover .gallery-nav {
            opacity: 1;
        }
        
        .gallery-nav:hover {
            background-color: rgba(255, 255, 255, 0.95);
            transform: translateY(-50%) scale(1.1);
        }
        
        .gallery-prev {
            left: 0.75rem;
        }
        
        .gallery-next {
            right: 0.75rem;
        }
        
        .gallery-indicators {
            position: absolute;
            bottom: 0.75rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 0.35rem;
            padding: 0.25rem 0.5rem;
            background-color: rgba(0, 0, 0, 0.3);
            border-radius: 1rem;
        }
        
        .gallery-indicator {
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .gallery-indicator.active {
            background-color: white;
            transform: scale(1.2);
        }
        
        /* Card hover effects */
        .hover-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hover-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Feature cards */
        .feature-icon {
            transition: all 0.3s ease;
        }
        
        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }
        
        /* Mobile menu */
        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 80%;
            max-width: 300px;
            height: 100vh;
            background-color: white;
            z-index: 50;
            transition: right 0.3s ease-in-out;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }
        
        .mobile-menu.active {
            right: 0;
        }
        
        .menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease-in-out;
        }
        
        .menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        /* Buttons */
        .btn-primary {
            background-image: linear-gradient(to right, #f59e0b, #d97706);
            transition: all 0.3s;
            color: white; /* Ensuring text is white for better contrast */
            font-weight: 600; /* Making text slightly bolder */
        }
        
        .btn-primary:hover {
            background-image: linear-gradient(to right, #d97706, #b45309);
            box-shadow: 0 10px 15px -3px rgba(245, 158, 11, 0.3);
        }
        
        .btn-outline {
            transition: all 0.3s;
            border: 3px solid white;
            color: white; 
            font-weight: 700;
            display: inline-block;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 10;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            background-color: rgba(0, 0, 0, 0.2); /* Add slight background for contrast */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .btn-outline:hover {
            background-color: white;
            color: #f59e0b;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
        }
        
        /* Search form */
        .search-form-wrapper {
            position: relative;
            z-index: 10;
            margin-top: -100px;
        }
        
        /* Floating labels */
        .floating-label {
            position: relative;
        }
        
        .floating-label input:focus + label,
        .floating-label input:not(:placeholder-shown) + label {
            transform: translateY(-1.5rem) scale(0.85);
            color: #f59e0b;
        }
        
        .floating-label label {
            position: absolute;
            left: 1rem;
            top: 0.75rem;
            padding: 0 0.25rem;
            background-color: white;
            transition: all 0.2s ease;
            pointer-events: none;
        }
        
        /* Badge */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .badge-yellow {
            background-color: rgba(245, 158, 11, 0.1);
            color: #d97706;
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #f59e0b;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #d97706;
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Header/Navigation -->
    <header class="bg-white shadow-md sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-3xl font-extrabold">
                            <span class="text-yellow-500">Auto</span><span class="text-gray-800">Loc</span><span class="text-yellow-500">Pro</span>
                        </span>
                    </div>
                </div>
                <div class="flex items-center space-x-6">
                    <nav class="hidden md:flex space-x-6 text-gray-600">
                        <a href="#" class="font-medium hover:text-yellow-500 transition duration-300 border-b-2 border-transparent hover:border-yellow-500 py-2">Accueil</a>
                        <a href="{{ route('vehicles.index') }}" class="font-medium hover:text-yellow-500 transition duration-300 border-b-2 border-transparent hover:border-yellow-500 py-2">Véhicules</a>
                        <a href="#vehicles" class="font-medium hover:text-yellow-500 transition duration-300 border-b-2 border-transparent hover:border-yellow-500 py-2">Promotions</a>
                        <a href="#" class="font-medium hover:text-yellow-500 transition duration-300 border-b-2 border-transparent hover:border-yellow-500 py-2">À propos</a>
                        <a href="#" class="font-medium hover:text-yellow-500 transition duration-300 border-b-2 border-transparent hover:border-yellow-500 py-2">Contact</a>
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

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-900 overflow-hidden curved-bottom hero-pattern">
        <div class="container mx-auto px-6 py-24 relative z-10">
            <div class="flex flex-col lg:flex-row items-center">
                <div class="lg:w-1/2 text-center lg:text-left mb-12 lg:mb-0">
                    <span class="badge badge-yellow inline-block mb-4 animate-fade-in opacity-0">Location de véhicules</span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-6 animate-slide-up opacity-0 delay-100">
                        Trouvez la voiture <span class="text-yellow-200">idéale</span> pour tous vos déplacements
                    </h1>
                    <p class="text-xl md:text-2xl mb-8 text-gray-800 opacity-90 max-w-xl mx-auto lg:mx-0 animate-slide-up opacity-0 delay-200">
                        Réservez facilement et rapidement parmi notre large gamme de véhicules disponibles partout en France.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center lg:justify-start space-y-4 sm:space-y-0 sm:space-x-4 animate-slide-up opacity-0 delay-300">
                        <a href="#search" class="btn-primary bg-white text-yellow-500 px-8 py-4 rounded-full font-bold hover:bg-gray-100 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            Réserver maintenant
                        </a>
                        <a href="{{ route('vehicles.index') }}" class="btn-outline border-2 border-white text-white px-8 py-4 rounded-full font-bold hover:bg-white hover:text-yellow-500 transition duration-300">
                            Voir nos véhicules
                        </a>
                    </div>
                </div>
                <div class="lg:w-1/2 relative animate-slide-up opacity-0 delay-200">
                    <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Voiture de location" class="rounded-lg shadow-2xl transform -rotate-2 w-full max-w-lg mx-auto">
                    <div class="absolute -bottom-4 -right-4 bg-white rounded-lg shadow-lg p-4 transform rotate-3 animate-fade-in opacity-0 delay-400">
                        <div class="flex items-center">
                            <div class="bg-yellow-500 rounded-full p-2 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-800 font-bold">Réservation rapide</p>
                                <p class="text-gray-600 text-sm">En moins de 2 minutes</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Search Form -->
    <section id="search" class="py-12 bg-white relative z-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="search-form-wrapper">
                <div class="bg-white shadow-2xl rounded-2xl overflow-hidden border border-gray-100">
                    <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 p-6 text-center">
                        <h2 class="text-2xl font-bold text-white">Recherchez un véhicule disponible</h2>
                        <p class="text-white opacity-90">Entrez vos dates et votre lieu pour trouver les meilleures options</p>
                    </div>
                    <form action="{{ route('home') }}" method="GET" class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lieu de prise en charge</label>
                            <div class="relative">
                                <input id="location" name="location" type="text" placeholder="Ville, agence, aéroport..." 
                                    class="pl-10 transition-all duration-200 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="pickup_date" class="block text-sm font-medium text-gray-700 mb-1">Date de départ</label>
                            <div class="relative">
                                <input id="pickup_date" name="pickup_date" type="date" 
                                    class="pl-10 transition-all duration-200 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="return_date" class="block text-sm font-medium text-gray-700 mb-1">Date de retour</label>
                            <div class="relative">
                                <input id="return_date" name="return_date" type="date" 
                                    class="pl-10 transition-all duration-200 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">&nbsp;</label>
                            <button type="submit" class="btn-primary w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Rechercher
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Active Promotions Section -->
    @if(isset($activePromotions) && count($activePromotions) > 0)
        <section id="promotions" class="py-16 bg-gradient-to-r from-yellow-50 to-orange-50 relative">
            <!-- Decorative elements -->
            <div class="absolute top-0 left-0 w-32 h-32 bg-yellow-200 rounded-full opacity-20 transform -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-48 h-48 bg-yellow-300 rounded-full opacity-20 transform translate-x-1/3 translate-y-1/3"></div>
            
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-12">
                    <span class="badge badge-yellow inline-block mb-4">Offres spéciales</span>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Promotions en cours</h2>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">Profitez de nos offres spéciales pour économiser sur votre prochaine location.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($activePromotions as $promotion)
                    <div class="hover-card bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 border border-yellow-100">
                        <div class="relative bg-gradient-to-r from-yellow-400 to-yellow-500 p-6 flex justify-between items-center">
                            <h3 class="text-xl font-bold text-white">{{ $promotion->name }}</h3>
                            <div class="absolute top-0 right-0 bg-red-500 text-white px-4 py-1 rounded-bl-lg font-bold text-lg transform translate-y-0">
                                -{{ $promotion->discount_percentage }}%
                            </div>
                        </div>
                        <div class="p-6">
                            @if($promotion->description)
                            <p class="text-gray-600 mb-4">{{ $promotion->description }}</p>
                            @endif
                            <div class="text-sm text-gray-500 mb-5">
                                <div class="flex items-center mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>Valable du {{ \Carbon\Carbon::parse($promotion->start_date)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($promotion->end_date)->format('d/m/Y') }}</span>
                                </div>
                                
                                @if($promotion->applicable_vehicles !== null)
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    <span>Applicable sur {{ count($promotion->applicable_vehicles) }} véhicule(s) sélectionné(s)</span>
                                </div>
                                @else
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    <span>Applicable sur tous les véhicules</span>
                                </div>
                                @endif
                            </div>
                            
                            <a href="{{ route('home', ['promo' => $promotion->id]) }}" class="btn-primary block w-full py-3 px-4 text-center bg-yellow-500 rounded-lg text-white font-medium hover:bg-yellow-600 transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                Voir les véhicules éligibles
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Vehicles Section with Filtering and Pagination -->
    <section id="vehicles" class="py-16 bg-gray-50 relative">
        <!-- Decorative pattern with road and car elements -->
        <div class="absolute inset-0 opacity-5" 
             style="background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPgogIDxkZWZzPgogICAgPHBhdHRlcm4gaWQ9InJvYWRwYXR0ZXJuIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCI+CiAgICAgIDxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiBmaWxsPSJub25lIiAvPgogICAgICA8IS0tIFJvYWQgLS0+CiAgICAgIDxyZWN0IHg9IjEwIiB5PSI0MCIgd2lkdGg9IjgwIiBoZWlnaHQ9IjIwIiBmaWxsPSIjZjU5ZTBiIiBvcGFjaXR5PSIwLjEiIHJ4PSIyIiAvPgogICAgICA8IS0tIERhc2hlZCBsaW5lcyAtLT4KICAgICAgPHJlY3QgeD0iMTUiIHk9IjQ5IiB3aWR0aD0iMTAiIGhlaWdodD0iMiIgZmlsbD0iI2Y1OWUwYiIgb3BhY2l0eT0iMC4zIiAvPgogICAgICA8cmVjdCB4PSIzNSIgeT0iNDkiIHdpZHRoPSIxMCIgaGVpZ2h0PSIyIiBmaWxsPSIjZjU5ZTBiIiBvcGFjaXR5PSIwLjMiIC8+CiAgICAgIDxyZWN0IHg9IjU1IiB5PSI0OSIgd2lkdGg9IjEwIiBoZWlnaHQ9IjIiIGZpbGw9IiNmNTllMGIiIG9wYWNpdHk9IjAuMyIgLz4KICAgICAgPHJlY3QgeD0iNzUiIHk9IjQ5IiB3aWR0aD0iMTAiIGhlaWdodD0iMiIgZmlsbD0iI2Y1OWUwYiIgb3BhY2l0eT0iMC4zIiAvPgogICAgICA8IS0tIENhciBzaWxob3VldHRlIC0tPgogICAgICA8cGF0aCBkPSJNNzAgMzVjLTEtMS41LTIuNS0yLTUtMmgtMTBjLTIuNSAwLTQgMC41LTUgMmwtMyAzYy0yIDAtNCAxLTQgM3YyYzAgMSAwLjUgMSAxIDFoMmMwIDIgMyAzIDQgMXMxLTMgMS0xaDE4YzAtMiAzLTMgNC0xczEgMyAxIDFoMmMwLjUgMCAxIDAuMyAxLTF2LTJjMC0yLTItMy00LTNsLTMtM3oiIGZpbGw9IiNmNTllMGIiIG9wYWNpdHk9IjAuMiIgLz4KICAgIDwvcGF0dGVybj4KICA8L2RlZnM+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNyb2FkcGF0dGVybikiIC8+Cjwvc3ZnPg==');
                    background-size: 300px 300px;"></div>
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-10">
                <span class="badge badge-yellow inline-block mb-4">Notre flotte</span>
                <h2 class="text-3xl font-bold text-gray-800 mb-4">
                    @if(isset($selectedPromotion))
                        Véhicules avec {{ $selectedPromotion->discount_percentage }}% de réduction
                    @else
                        Nos véhicules disponibles
                    @endif
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    @if(isset($selectedPromotion))
                        Profitez de la promotion "{{ $selectedPromotion->name }}" sur ces véhicules.
                    @else
                        Découvrez notre sélection de véhicules les plus demandés pour tous vos besoins de déplacement.
                    @endif
                </p>
            </div>

            <!-- Filters and Sorting -->
            <div class="mb-8 bg-white rounded-xl shadow-md p-6 border border-yellow-100">
                <form action="{{ route('home') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    @if(isset($selectedPromotion))
                        <input type="hidden" name="promo" value="{{ $selectedPromotion->id }}">
                    @endif
                    
                    <!-- Brand Filter -->
                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Marque</label>
                        <select name="brand" id="brand" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50 py-3">
                            <option value="">Toutes les marques</option>
                            @foreach($brands ?? [] as $brand)
                                <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Fuel Type Filter -->
                    <div>
                        <label for="fuel_type" class="block text-sm font-medium text-gray-700 mb-1">Carburant</label>
                        <select name="fuel_type" id="fuel_type" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50 py-3">
                            <option value="">Tous types</option>
                            <option value="gasoline" {{ request('fuel_type') == 'gasoline' ? 'selected' : '' }}>Essence</option>
                            <option value="diesel" {{ request('fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                            <option value="electric" {{ request('fuel_type') == 'electric' ? 'selected' : '' }}>Électrique</option>
                            <option value="hybrid" {{ request('fuel_type') == 'hybrid' ? 'selected' : '' }}>Hybride</option>
                        </select>
                    </div>
                    
                    <!-- Price Range -->
                    <div>
                        <label for="price_range" class="block text-sm font-medium text-gray-700 mb-1">Prix par jour</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" name="price_min" id="price_min" placeholder="Min €" 
                                   value="{{ request('price_min') }}" min="0" 
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50 py-3">
                            <input type="number" name="price_max" id="price_max" placeholder="Max €" 
                                   value="{{ request('price_max') }}" min="0" 
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50 py-3">
                        </div>
                    </div>
                    
                    <!-- Sort Order -->
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Trier par</label>
                        <select name="sort" id="sort" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50 py-3">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Plus récents</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                        </select>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="flex items-end">
                        <button type="submit" class="btn-primary w-full bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-3 px-4 rounded-md transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filtrer
                        </button>
                    </div>
                </form>
            </div>

            <!-- Vehicles Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($vehicles as $vehicle)
                <!-- Vehicle Card -->
                <div class="hover-card bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 relative">
                    <!-- Promotion Badge (if applicable) -->
                    @if(isset($selectedPromotion) && ($selectedPromotion->applicable_vehicles === null || (is_array($selectedPromotion->applicable_vehicles) && in_array($vehicle->id, $selectedPromotion->applicable_vehicles))))
                    <div class="absolute top-0 left-0 z-20 bg-red-500 text-white font-bold px-3 py-1 rounded-br-lg">
                        -{{ $selectedPromotion->discount_percentage }}%
                    </div>
                    @endif
                    
                    <div class="relative h-56 vehicle-gallery">
                        @if($vehicle->photos->count() > 0)
                            <div class="gallery-container" data-index="0">
                                @foreach($vehicle->photos as $index => $photo)
                                    <div class="gallery-slide">
                                        <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }} - Photo {{ $index + 1 }}" class="w-full h-56 object-cover">
                                    </div>
                                @endforeach
                            </div>
                            
                            @if($vehicle->photos->count() > 1)
                                <!-- Navigation buttons -->
                                <button class="gallery-nav gallery-prev" onclick="moveGallery(this.parentNode, -1)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <button class="gallery-nav gallery-next" onclick="moveGallery(this.parentNode, 1)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                
                                <!-- Indicators -->
                                <div class="gallery-indicators">
                                    @foreach($vehicle->photos as $index => $photo)
                                        <div class="gallery-indicator {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></div>
                                    @endforeach
                                </div>
                                
                                <!-- Photo counter -->
                                <div class="absolute top-0 right-0 bg-black bg-opacity-50 text-white text-xs px-2 py-1 m-2 rounded-lg">
                                    <span class="current-photo">1</span>/<span>{{ $vehicle->photos->count() }}</span>
                                </div>
                            @endif
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-yellow-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        <div class="absolute bottom-0 right-0 bg-yellow-500 text-white px-3 py-1 m-3 rounded-lg font-medium shadow-md">
                            @if(isset($selectedPromotion) && ($selectedPromotion->applicable_vehicles === null || (is_array($selectedPromotion->applicable_vehicles) && in_array($vehicle->id, $selectedPromotion->applicable_vehicles))))
                                <span class="line-through text-yellow-200 mr-1">{{ $vehicle->price_per_day }}€</span>
                                {{ number_format($vehicle->price_per_day * (1 - $selectedPromotion->discount_percentage / 100), 2) }}€/jour
                            @else
                                {{ $vehicle->price_per_day }}€/jour
                            @endif
                        </div>
                    </div>
                    
                    <!-- Rest of vehicle card content -->
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-bold text-gray-800">{{ $vehicle->brand }} {{ $vehicle->model }}</h3>
                            @if(isset($vehicle->average_rating) && $vehicle->average_rating > 0)
                            <div class="flex items-center text-sm text-yellow-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span class="ml-1">{{ isset($vehicle->average_rating) ? number_format($vehicle->average_rating, 1) : "N/A" }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="flex flex-wrap text-sm text-gray-600 mb-4">
                            <div class="flex items-center mr-4 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H11a1 1 0 001-1v-1h2a1 1 0 001-1v-3a1 1 0 00-.2-.4l-3-4A1 1 0 0011 5H4a1 1 0 00-1 1z" />
                                </svg>
                                @switch($vehicle->fuel_type)
                                    @case('gasoline')
                                        Essence
                                        @break
                                    @case('diesel')
                                        Diesel
                                        @break
                                    @case('electric')
                                        Électrique
                                        @break
                                    @case('hybrid')
                                        Hybride
                                        @break
                                    @default
                                        {{ ucfirst($vehicle->fuel_type) }}
                                @endswitch
                            </div>
                            <div class="flex items-center mr-4 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                </svg>
                                {{ $vehicle->seats }} places
                            </div>
                            <div class="flex items-center mr-4 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                                @switch($vehicle->transmission)
                                    @case('automatic')
                                        Automatique
                                        @break
                                    @case('manual')
                                        Manuelle
                                        @break
                                    @default
                                        {{ ucfirst($vehicle->transmission) }}
                                @endswitch
                            </div>
                            
                            @if(is_array($vehicle->features) && count($vehicle->features) > 0)
                            <div class="w-full mt-2">
                                <div class="flex flex-wrap gap-2">
                                    @foreach(array_slice($vehicle->features, 0, 3) as $feature)
                                    <span class="inline-block bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">
                                        @switch($feature)
                                            @case('air_conditioning')
                                                Climatisation
                                                @break
                                            @case('gps')
                                                GPS
                                                @break
                                            @case('bluetooth')
                                                Bluetooth
                                                @break
                                            @case('usb')
                                                Port USB
                                                @break
                                            @case('heated_seats')
                                                Sièges chauffants
                                                @break
                                            @case('sunroof')
                                                Toit ouvrant
                                                @break
                                            @case('cruise_control')
                                                Régulateur
                                                @break
                                            @case('parking_sensors')
                                                Capteurs
                                                @break
                                            @case('backup_camera')
                                                Caméra
                                                @break
                                            @default
                                                {{ ucfirst(str_replace('_', ' ', $feature)) }}
                                        @endswitch
                                    </span>
                                    @endforeach
                                    @if(count($vehicle->features) > 3)
                                    <span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full">
                                        +{{ count($vehicle->features) - 3 }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                        <a href="{{ route('reservations.create', $vehicle->id) }}" class="btn-primary block w-full py-3 px-4 text-center border border-yellow-500 rounded-lg text-white font-medium hover:bg-yellow-500 hover:text-white transition duration-300 shadow-sm hover:shadow-md">
                            Réserver maintenant
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-10">
                    <div class="bg-white rounded-lg shadow-md p-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-yellow-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <p class="text-gray-700 text-lg mb-2 font-medium">Aucun véhicule disponible</p>
                        <p class="text-gray-500 mb-4">Aucun véhicule ne correspond à vos critères de recherche.</p>
                        <a href="{{ route('home') }}" class="btn-primary inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            Effacer les filtres
                        </a>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if(isset($vehicles) && method_exists($vehicles, 'hasPages') && $vehicles->hasPages())
            <div class="mt-8">
                <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 rounded-lg shadow-sm">
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Affichage de 
                                <span class="font-medium">{{ $vehicles->firstItem() ?? 0 }}</span>
                                à
                                <span class="font-medium">{{ $vehicles->lastItem() ?? 0 }}</span>
                                sur
                                <span class="font-medium">{{ $vehicles->total() }}</span>
                                véhicules
                            </p>
                        </div>
                        <div>
                            {{ $vehicles->links() }}
                        </div>
                    </div>
                    
                    <!-- Mobile pagination -->
                    <div class="flex items-center justify-between w-full sm:hidden">
                        @if($vehicles->onFirstPage())
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                                Précédent
                            </span>
                        @else
                            <a href="{{ $vehicles->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                Précédent
                            </a>
                        @endif
                        
                        <div class="text-sm text-gray-700">
                            <span class="font-medium">{{ $vehicles->currentPage() }}</span> sur <span class="font-medium">{{ $vehicles->lastPage() }}</span>
                        </div>
                        
                        @if($vehicles->hasMorePages())
                            <a href="{{ $vehicles->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                Suivant
                            </a>
                        @else
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                                Suivant
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <div class="text-center mt-10">
                @if(isset($selectedPromotion))
                    <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-300 font-medium mr-4 shadow-sm hover:shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Voir tous les véhicules
                    </a>
                @endif
                
                <a href="" class="btn-primary inline-flex items-center px-6 py-3 border border-transparent rounded-lg text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-300 font-medium shadow-md hover:shadow-lg">
                    Voir tous nos véhicules
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-16 bg-white relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-yellow-100 rounded-full opacity-50 transform translate-x-1/3 -translate-y-1/3"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-yellow-100 rounded-full opacity-50 transform -translate-x-1/3 translate-y-1/3"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-12">
                <span class="badge badge-yellow inline-block mb-4">Nos avantages</span>
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Pourquoi choisir AutoLocPro?</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">Profitez d'une expérience de location simple, rapide et sécurisée avec tous les avantages AutoLocPro.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="text-center bg-gray-50 rounded-xl p-8 hover:shadow-lg transition duration-300 feature-card border border-gray-100">
                    <div class="inline-flex items-center justify-center p-4 bg-yellow-100 rounded-full text-yellow-500 mb-5 feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Large gamme de véhicules</h3>
                    <p class="text-gray-600">Trouvez le véhicule idéal parmi notre large sélection de voitures, camions et utilitaires pour tous vos besoins.</p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center bg-gray-50 rounded-xl p-8 hover:shadow-lg transition duration-300 feature-card border border-gray-100">
                    <div class="inline-flex items-center justify-center p-4 bg-yellow-100 rounded-full text-yellow-500 mb-5 feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.532 1.532 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Réservation facile</h3>
                    <p class="text-gray-600">Réservez en quelques clics et recevez une confirmation instantanée de votre location sans tracas.</p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center bg-gray-50 rounded-xl p-8 hover:shadow-lg transition duration-300 feature-card border border-gray-100">
                    <div class="inline-flex items-center justify-center p-4 bg-yellow-100 rounded-full text-yellow-500 mb-5 feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Promotions exclusives</h3>
                    <p class="text-gray-600">Profitez régulièrement de nos offres spéciales et de nos tarifs préférentiels pour économiser sur vos locations.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-16 relative">
        <div class="absolute inset-0 opacity-10 hero-pattern"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-2xl font-bold mb-6 text-yellow-400">AutoLocPro</h3>
                    <p class="text-gray-400 mb-6">Votre partenaire de confiance pour la location de véhicules depuis 2010.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-gray-700 hover:bg-yellow-500 h-10 w-10 rounded-full flex items-center justify-center transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="bg-gray-700 hover:bg-yellow-500 h-10 w-10 rounded-full flex items-center justify-center transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>
                            </svg>
                        </a>
                        <a href="#" class="bg-gray-700 hover:bg-yellow-500 h-10 w-10 rounded-full flex items-center justify-center transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-6">Liens utiles</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-yellow-400 transition duration-300 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            À propos de nous</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-yellow-400 transition duration-300 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Nos services</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-yellow-400 transition duration-300 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            FAQ</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-yellow-400 transition duration-300 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Contact</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-6">Conditions</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-yellow-400 transition duration-300 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Conditions générales</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-yellow-400 transition duration-300 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Politique de confidentialité</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-yellow-400 transition duration-300 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Conditions de location</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-6">Contactez-nous</h3>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                            123 Avenue de la République, 75011 Paris
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                            </svg>
                            +212 123 456 789
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                            contact@autolocpro.fr
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 pt-8 border-t border-gray-700 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} AutoLocPro. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Script for gallery functionality and animations -->
    <script>
        function moveGallery(gallery, direction) {
            const container = gallery.querySelector('.gallery-container');
            const currentIndex = parseInt(container.dataset.index);
            const slides = container.querySelectorAll('.gallery-slide');
            const totalSlides = slides.length;
            
            // Calculate new index
            let newIndex = currentIndex + direction;
            if (newIndex < 0) newIndex = totalSlides - 1;
            if (newIndex >= totalSlides) newIndex = 0;
            
            // Update container position
            container.style.transform = `translateX(-${newIndex * 100}%)`;
            container.dataset.index = newIndex;
            
            // Update indicators
            const indicators = gallery.querySelectorAll('.gallery-indicator');
            indicators.forEach(indicator => {
                indicator.classList.remove('active');
                if (parseInt(indicator.dataset.index) === newIndex) {
                    indicator.classList.add('active');
                }
            });
            
            // Update counter
            const counter = gallery.querySelector('.current-photo');
            if (counter) counter.textContent = newIndex + 1;
        }
        
        // Initialize mobile menu and animations
        document.addEventListener('DOMContentLoaded', function() {
            // Gallery indicators click handlers
            const indicators = document.querySelectorAll('.gallery-indicator');
            indicators.forEach(indicator => {
                indicator.addEventListener('click', function() {
                    const gallery = this.closest('.vehicle-gallery');
                    const container = gallery.querySelector('.gallery-container');
                    const currentIndex = parseInt(container.dataset.index);
                    const targetIndex = parseInt(this.dataset.index);
                    
                    // Move gallery to clicked indicator
                    const direction = targetIndex - currentIndex;
                    moveGallery(gallery, direction);
                });
            });
            
            // Mobile menu functionality
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const closeMenuButton = document.getElementById('close-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuOverlay = document.getElementById('menu-overlay');
            
            if (mobileMenuButton && closeMenuButton && mobileMenu && menuOverlay) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.add('active');
                    menuOverlay.classList.add('active');
                    document.body.style.overflow = 'hidden';
                });
                
                closeMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.remove('active');
                    menuOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                });
                
                menuOverlay.addEventListener('click', function() {
                    mobileMenu.classList.remove('active');
                    menuOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                });
            }
            
            // Initialize date inputs with today's date and tomorrow
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            
            const pickupDateInput = document.getElementById('pickup_date');
            const returnDateInput = document.getElementById('return_date');
            
            if(pickupDateInput && returnDateInput) {
                pickupDateInput.valueAsDate = today;
                returnDateInput.valueAsDate = tomorrow;
                
                pickupDateInput.min = today.toISOString().split('T')[0];
                returnDateInput.min = tomorrow.toISOString().split('T')[0];
                
                pickupDateInput.addEventListener('change', function() {
                    const newMinReturn = new Date(this.value);
                    newMinReturn.setDate(newMinReturn.getDate() + 1);
                    returnDateInput.min = newMinReturn.toISOString().split('T')[0];
                    
                    if(new Date(returnDateInput.value) <= new Date(this.value)) {
                        returnDateInput.valueAsDate = newMinReturn;
                    }
                });
            }
            
            // Animate elements on scroll
            const animateOnScroll = function() {
                const elements = document.querySelectorAll('.animate-fade-in, .animate-slide-up');
                elements.forEach(element => {
                    const position = element.getBoundingClientRect();
                    // If element is in viewport
                    if(position.top < window.innerHeight * 0.9 && position.bottom >= 0) {
                        element.style.opacity = '1';
                    }
                });
            };
            
            // Run once on load
            animateOnScroll();
            
            // Add scroll event listener
            window.addEventListener('scroll', animateOnScroll);
            
            // Header scroll effect
            const header = document.querySelector('header');
            let lastScrollTop = 0;
            
            window.addEventListener('scroll', function() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                if (scrollTop > 100) {
                    header.classList.add('shadow-lg');
                    header.classList.add('bg-white/95');
                    header.classList.add('backdrop-blur-sm');
                } else {
                    header.classList.remove('shadow-lg');
                    header.classList.remove('bg-white/95');
                    header.classList.remove('backdrop-blur-sm');
                }
                
                lastScrollTop = scrollTop;
            });
        });
    </script>
</body>
</html>