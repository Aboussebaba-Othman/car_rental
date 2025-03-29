<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoLocPro - Location de véhicules</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">

    <!-- Header/Navigation -->
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
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-yellow-600 font-medium transition duration-300">Connexion</a>
                        <a href="{{ route('register') }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-yellow-600 transition duration-300">S'inscrire</a>
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

    <!-- Hero Section -->
    <section class="relative h-screen flex items-center bg-gradient-to-r from-yellow-400 to-yellow-500 text-white">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-4">Trouvez la voiture idéale pour tous vos déplacements</h1>
            <p class="text-xl md:text-2xl mb-8">Réservez facilement et rapidement parmi notre large gamme de véhicules disponibles partout en France.</p>
            <div class="flex justify-center space-x-4">
                <a href="#search" class="bg-white text-yellow-500 px-8 py-3 rounded-lg font-bold hover:bg-gray-100 transition duration-200">Réserver maintenant</a>
                <a href="#vehicles" class="border-2 border-white text-white px-8 py-3 rounded-lg font-bold hover:bg-white hover:text-yellow-500 transition duration-200">Voir nos véhicules</a>
            </div>
        </div>
    </section>
    <!-- Search Form -->
    <section id="search" class="py-12 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-xl overflow-hidden -mt-24 z-10">
                <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 p-6 text-center rounded-t-xl">
                    <h2 class="text-2xl font-bold text-white">Recherchez un véhicule disponible</h2>
                    <p class="text-white">Entrez vos dates et votre lieu pour trouver les meilleures options</p>
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
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Rechercher
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Active Promotions Section -->
    @if(isset($activePromotions) && count($activePromotions) > 0)
        <section id="promotions" class="py-16 bg-gradient-to-r from-yellow-50 to-orange-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Promotions en cours</h2>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">Profitez de nos offres spéciales pour économiser sur votre prochaine location.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($activePromotions as $promotion)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:shadow-xl transform hover:-translate-y-1 border border-yellow-200">
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
                            
                            <a href="{{ route('home', ['promo' => $promotion->id]) }}" class="block w-full py-3 px-4 text-center bg-yellow-500 rounded-lg text-white font-medium hover:bg-yellow-600 transition duration-200 transform hover:-translate-y-0.5">
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
    <section id="vehicles" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
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
            <div class="mb-8 bg-white rounded-lg shadow p-4">
                <form action="{{ route('home') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    @if(isset($selectedPromotion))
                        <input type="hidden" name="promo" value="{{ $selectedPromotion->id }}">
                    @endif
                    
                    <!-- Brand Filter -->
                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Marque</label>
                        <select name="brand" id="brand" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50">
                            <option value="">Toutes les marques</option>
                            @foreach($brands ?? [] as $brand)
                                <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Fuel Type Filter -->
                    <div>
                        <label for="fuel_type" class="block text-sm font-medium text-gray-700 mb-1">Carburant</label>
                        <select name="fuel_type" id="fuel_type" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50">
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
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50">
                            <input type="number" name="price_max" id="price_max" placeholder="Max €" 
                                   value="{{ request('price_max') }}" min="0" 
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50">
                        </div>
                    </div>
                    
                    <!-- Sort Order -->
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Trier par</label>
                        <select name="sort" id="sort" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Plus récents</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                        </select>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                            Filtrer
                        </button>
                    </div>
                </form>
            </div>

            <!-- Vehicles Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($vehicles as $vehicle)
                <!-- Vehicle Card -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:shadow-lg transform hover:-translate-y-1 relative">
                    <!-- Promotion Badge (if applicable) -->
                    @if(isset($selectedPromotion) && ($selectedPromotion->applicable_vehicles === null || (is_array($selectedPromotion->applicable_vehicles) && in_array($vehicle->id, $selectedPromotion->applicable_vehicles))))
                    <div class="absolute top-0 left-0 z-20 bg-red-500 text-white font-bold px-3 py-1 rounded-br-lg">
                        -{{ $selectedPromotion->discount_percentage }}%
                    </div>
                    @endif
                    
                    <div class="relative h-48">
                        @if($vehicle->photos->count() > 0)
                            @php $primaryPhoto = $vehicle->photos->firstWhere('is_primary', true) ?? $vehicle->photos->first(); @endphp
                            <img src="{{ asset('storage/' . $primaryPhoto->path) }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        <div class="absolute top-0 right-0 bg-yellow-500 text-white px-3 py-1 m-2 rounded-lg font-medium">
                            @if(isset($selectedPromotion) && ($selectedPromotion->applicable_vehicles === null || (is_array($selectedPromotion->applicable_vehicles) && in_array($vehicle->id, $selectedPromotion->applicable_vehicles))))
                                <span class="line-through text-yellow-200 mr-1">{{ $vehicle->price_per_day }}€</span>
                                {{ number_format($vehicle->price_per_day * (1 - $selectedPromotion->discount_percentage / 100), 2) }}€/jour
                            @else
                                {{ $vehicle->price_per_day }}€/jour
                            @endif
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
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
                        <a href="" class="block w-full py-2 px-4 text-center border border-yellow-500 rounded-lg text-yellow-500 font-medium hover:bg-yellow-500 hover:text-white transition duration-200">
                            Voir les détails
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
                        <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
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
                    <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-200 font-medium mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Voir tous les véhicules
                    </a>
                @endif
                
                <a href="" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-200 font-medium">
                    Voir tous nos véhicules
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </section>
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Pourquoi choisir AutoLocPro?</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">Profitez d'une expérience de location simple, rapide et sécurisée avec tous les avantages AutoLocPro.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="text-center bg-gray-50 rounded-xl p-8 hover:shadow-lg transition duration-300">
                    <div class="inline-flex items-center justify-center p-3 bg-yellow-100 rounded-full text-yellow-500 mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Large gamme de véhicules</h3>
                    <p class="text-gray-600">Trouvez le véhicule idéal parmi notre large sélection de voitures, camions et utilitaires.</p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center bg-gray-50 rounded-xl p-8 hover:shadow-lg transition duration-300">
                    <div class="inline-flex items-center justify-center p-3 bg-yellow-100 rounded-full text-yellow-500 mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.532 1.532 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Réservation facile</h3>
                    <p class="text-gray-600">Réservez en quelques clics et recevez une confirmation instantanée de votre location.</p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center bg-gray-50 rounded-xl p-8 hover:shadow-lg transition duration-300">
                    <div class="inline-flex items-center justify-center p-3 bg-yellow-100 rounded-full text-yellow-500 mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Promotions exclusives</h3>
                    <p class="text-gray-600">Profitez régulièrement de nos offres spéciales et de nos tarifs préférentiels.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">AutoLocPro</h3>
                    <p class="text-gray-400">Votre partenaire de confiance pour la location de véhicules depuis 2010.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Liens utiles</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-yellow-500 transition duration-200">À propos de nous</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-yellow-500 transition duration-200">Nos services</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-yellow-500 transition duration-200">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-yellow-500 transition duration-200">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Conditions</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-yellow-500 transition duration-200">Conditions générales</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-yellow-500 transition duration-200">Politique de confidentialité</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-yellow-500 transition duration-200">Conditions de location</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contactez-nous</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                            123 Avenue de la République, 75011 Paris
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                            </svg>
                            +212
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                            contact@autolocpro.fr
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} AutoLocPro. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
</body>
<html>