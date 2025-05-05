@extends('layouts.app')

@section('content')
<div class="py-16 bg-gradient-to-b from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Réserver un véhicule</h1>
            <p class="text-lg text-gray-600">Complétez le formulaire pour réserver {{ $vehicle->brand }} {{ $vehicle->model }}</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-5 mb-8 rounded-lg shadow-sm animate-pulse" role="alert">
                <p class="font-bold">Des erreurs sont survenues:</p>
                <ul class="list-disc pl-5 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Vehicle details -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 transition-all duration-300 hover:shadow-xl">
                    <div class="relative">
                        @if($vehicle->photos->count() > 0)
                            <div class="aspect-w-16 aspect-h-9">
                                <!-- Main Photo Display -->
                                <div id="mainPhotoContainer" class="w-full h-64 relative overflow-hidden">
                                    @foreach($vehicle->photos as $index => $photo)
                                        <img 
                                            src="{{ asset('storage/' . $photo->path) }}" 
                                            alt="{{ $vehicle->brand }} {{ $vehicle->model }}" 
                                            class="w-full h-64 object-cover absolute top-0 left-0 transition-all duration-500 ease-in-out {{ $index === 0 ? 'opacity-100 scale-100' : 'opacity-0 scale-105' }}"
                                            id="vehiclePhoto-{{ $index }}"
                                            data-index="{{ $index }}">
                                    @endforeach

                                    <!-- Photo Controls -->
                                    @if($vehicle->photos->count() > 1)
                                        <button type="button" id="prevPhoto" class="absolute left-3 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-70 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                            </svg>
                                        </button>
                                        <button type="button" id="nextPhoto" class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-70 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                        
                                        <!-- Photo Counter -->
                                        <div class="absolute bottom-3 right-3 bg-black bg-opacity-60 text-white text-xs px-2 py-1 rounded-full">
                                            <span id="currentPhotoIndex">1</span>/<span>{{ $vehicle->photos->count() }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Thumbnails Navigation -->
                            @if($vehicle->photos->count() > 1)
                                <div class="flex overflow-x-auto py-3 px-2 bg-gray-50 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-transparent">
                                    @foreach($vehicle->photos as $index => $photo)
                                        <div 
                                            class="w-16 h-16 flex-shrink-0 mx-1 cursor-pointer rounded-lg overflow-hidden thumbnail-item transition-all duration-300 transform hover:-translate-y-1 {{ $index === 0 ? 'ring-2 ring-yellow-500' : '' }}"
                                            data-index="{{ $index }}">
                                            <img 
                                                src="{{ asset('storage/' . $photo->path) }}" 
                                                alt="Thumbnail" 
                                                class="w-full h-full object-cover">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="w-full h-64 bg-gray-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $vehicle->brand }} {{ $vehicle->model }} <span class="text-gray-500">({{ $vehicle->year }})</span></h3>
                        <div class="text-yellow-500 font-bold text-xl mb-4 flex items-center">
                            {{ number_format($vehicle->price_per_day, 2) }}€ <span class="text-gray-500 text-base font-normal ml-1">/ jour</span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-5 mb-6">
                            <div class="bg-gray-50 p-3 rounded-xl">
                                <span class="text-gray-500 text-sm block mb-1">Transmission</span>
                                <p class="font-medium flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                    </svg>
                                    @if($vehicle->transmission === 'automatic') 
                                        Automatique
                                    @elseif($vehicle->transmission === 'manual')
                                        Manuelle
                                    @else
                                        {{ ucfirst($vehicle->transmission) }}
                                    @endif
                                </p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-xl">
                                <span class="text-gray-500 text-sm block mb-1">Carburant</span>
                                <p class="font-medium flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    @if($vehicle->fuel_type === 'gasoline') 
                                        Essence
                                    @elseif($vehicle->fuel_type === 'diesel')
                                        Diesel
                                    @elseif($vehicle->fuel_type === 'electric')
                                        Électrique
                                    @elseif($vehicle->fuel_type === 'hybrid')
                                        Hybride
                                    @else
                                        {{ ucfirst($vehicle->fuel_type) }}
                                    @endif
                                </p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-xl">
                                <span class="text-gray-500 text-sm block mb-1">Places</span>
                                <p class="font-medium flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    {{ $vehicle->seats }}
                                </p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-xl">
                                <span class="text-gray-500 text-sm block mb-1">Immatriculation</span>
                                <p class="font-medium flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                    </svg>
                                    {{ $vehicle->license_plate }}
                                </p>
                            </div>
                        </div>
                        
                        <!-- Features/Amenities -->
                        @php
                            $features = is_array($vehicle->features) 
                                ? $vehicle->features 
                                : (is_string($vehicle->features) ? json_decode($vehicle->features, true) : []);
                        @endphp

                        @if(!empty($features))
                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Équipements
                                </h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($features as $feature)
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 transition-all duration-300 hover:bg-yellow-200">
                                            {{ $feature }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Availability Calendar Preview -->
                <div class="mt-6 bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 transition-all duration-300 hover:shadow-xl">
                    <div class="p-4 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white">
                        <h3 class="font-bold flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Disponibilité
                        </h3>
                    </div>
                    <div class="p-5">
                        <div id="availability-calendar" class="text-center text-sm"></div>
                    </div>
                </div>
            </div>

            <!-- Reservation form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 transition-all duration-300 hover:shadow-xl">
                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 p-6 text-white">
                        <h2 class="text-2xl font-bold mb-1">Détails de votre réservation</h2>
                        <p class="opacity-90">Tous les champs marqués d'un * sont obligatoires</p>
                    </div>  
                    <form method="POST" action="{{ route('reservations.store') }}" class="p-8" id="reservation-form">
                        @csrf
                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                        <input type="hidden" id="price_per_day" value="{{ $vehicle->price_per_day }}">
                        <input type="hidden" id="hidden_total_price" name="total_price" value="{{ $totalPrice }}">
                        
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Dates de location
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Date de début *</label>
                                    <div class="relative">
                                        <input type="date" id="start_date" name="start_date" value="{{ $startDate }}" 
                                            class="w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50 pl-10 py-3 transition-all duration-300" required>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Date de fin *</label>
                                    <div class="relative">
                                        <input type="date" id="end_date" name="end_date" value="{{ $endDate }}" 
                                            class="w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50 pl-10 py-3 transition-all duration-300" required>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 text-sm text-gray-500 flex items-center bg-blue-50 p-3 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                <span>Vous pouvez louer ce véhicule pour un minimum de 1 jour et un maximum de 30 jours.</span>
                            </div>
                        </div>
                        
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Lieux de prise en charge et de retour
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="pickup_location" class="block text-sm font-medium text-gray-700 mb-2">Lieu de prise en charge *</label>
                                    <div class="relative">
                                        <input type="text" id="pickup_location" name="pickup_location" value="{{ old('pickup_location') }}" 
                                            placeholder="Adresse complète" 
                                            class="w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50 pl-10 py-3 transition-all duration-300" required>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="return_location" class="block text-sm font-medium text-gray-700 mb-2">Lieu de retour *</label>
                                    <div class="relative">
                                        <input type="text" id="return_location" name="return_location" value="{{ old('return_location') }}" 
                                            placeholder="Adresse complète" 
                                            class="w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50 pl-10 py-3 transition-all duration-300" required>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Quick address buttons -->
                            <div class="mt-3 flex flex-wrap gap-2">
                                <button type="button" id="same-address-btn" class="text-sm px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700 transition-all duration-300 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                    Même adresse pour le retour
                                </button>
                                <button type="button" id="home-address-btn" class="text-sm px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700 transition-all duration-300 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    Utiliser mon adresse
                                </button>
                                <button type="button" id="agency-address-btn" class="text-sm px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700 transition-all duration-300 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    À l'agence
                                </button>
                            </div>
                        </div>
                        
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                                Notes additionnelles
                            </h3>
                            <textarea id="notes" name="notes" rows="3" 
                                placeholder="Instructions spéciales, besoins particuliers, etc." 
                                class="w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50 py-3 transition-all duration-300">{{ old('notes') }}</textarea>
                        </div>
                        
                        <!-- Promotion selection -->
                        @if(isset($availablePromotions) && count($availablePromotions) > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                                </svg>
                                Promotion
                            </h3>
                            <div class="relative">
                                <select id="promotion_id" name="promotion_id" class="w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50 py-3 pl-10 transition-all duration-300 appearance-none">
                                    <option value="">Aucune promotion</option>
                                    @foreach($availablePromotions as $promo)
                                        <option value="{{ $promo->id }}" {{ isset($promotion) && $promotion->id == $promo->id ? 'selected' : '' }}>
                                            {{ $promo->name }} ({{ $promo->discount_percentage }}% de réduction)
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                </div>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        @elseif(isset($promotion))
                        <input type="hidden" name="promotion_id" value="{{ $promotion->id }}">
                        <div class="mb-8 bg-yellow-50 p-5 rounded-xl border border-yellow-200 shadow-sm">
                            <div class="flex items-center">
                                <div class="bg-yellow-100 p-2 rounded-full mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="font-semibold text-yellow-800">Promotion appliquée: {{ $promotion->name }}</span>
                                    <div class="text-yellow-700 text-sm mt-1">
                                        Réduction de {{ $promotion->discount_percentage }}% sur le prix total.
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Price summary -->
                        <div class="mb-8 bg-gray-50 p-6 rounded-xl shadow-sm">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Récapitulatif du prix
                            </h3>
                            <div class="flex justify-between items-center mb-3 text-gray-600">
                                <span>Prix par jour:</span>
                                <span class="font-medium">{{ number_format($pricePerDay, 2) }}€</span>
                            </div>
                            <div class="flex justify-between items-center mb-3 text-gray-600">
                                <span>Nombre de jours:</span>
                                <span id="number_of_days" class="font-medium transition-all duration-300">{{ $numberOfDays }}</span>
                            </div>
                            <div class="flex justify-between items-center mb-3 text-green-600 discount-row transition-all duration-300" 
                                 style="{{ isset($promotion) ? '' : 'display: none;' }}">
                                <span>Promotion:</span>
                                <span id="discount" class="font-medium">
                                    @if(isset($promotion))
                                        -{{ number_format(($pricePerDay * $numberOfDays) * ($promotion->discount_percentage / 100), 2) }}€ (-{{ $promotion->discount_percentage }}%)
                                    @else
                                        0,00€
                                    @endif
                                </span>
                            </div>
                            <div class="border-t border-gray-300 my-3 pt-3 flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-800">Total:</span>
                                <span id="total_price" class="text-2xl font-bold text-yellow-600 transition-all duration-300">{{ number_format($totalPrice, 2) }}€</span>
                            </div>
                        </div>
                        
                        <!-- Terms and conditions -->
                        <div class="mb-8">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="terms" name="terms" type="checkbox" class="h-5 w-5 text-yellow-500 focus:ring-yellow-400 border-gray-300 rounded transition-all duration-300" required>
                                </div>
                                <div class="ml-3">
                                    <label for="terms" class="font-medium text-gray-700">J'accepte les <a href="#" class="text-yellow-500 hover:text-yellow-600 underline">conditions générales</a></label>
                                    <p class="text-gray-500 text-sm mt-1">En cochant cette case, vous acceptez les conditions de location et notre politique de confidentialité.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <a href="{{ url()->previous() }}" class="inline-flex items-center px-5 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                </svg>
                                Retour
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-md text-white bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-300 transform hover:-translate-y-0.5">
                                Continuer vers le paiement
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.footer')

<script>
    /**
     * Calculateur de prix en temps réel pour les réservations
     */
    document.addEventListener('DOMContentLoaded', function() {
        // Éléments du formulaire
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const pricePerDay = parseFloat(document.getElementById('price_per_day').value || 0);
        const promotionElement = document.getElementById('promotion_id');
        const hiddenTotalPriceInput = document.getElementById('hidden_total_price');
        
        // Éléments d'affichage
        const numberOfDaysElement = document.getElementById('number_of_days');
        const subtotalElement = document.getElementById('subtotal');
        const discountElement = document.getElementById('discount');
        const totalPriceElement = document.getElementById('total_price');
        
        // Données des promotions
        const promotions = window.promotionsData || {};
        
        // Boutons d'adresse
        const pickupLocationInput = document.getElementById('pickup_location');
        const returnLocationInput = document.getElementById('return_location');
        const sameAddressBtn = document.getElementById('same-address-btn');
        const homeAddressBtn = document.getElementById('home-address-btn');
        const agencyAddressBtn = document.getElementById('agency-address-btn');
        const agencyAddress = "123 Rue de l'Agence, 75001 Paris";
        
        /**
         * Calcule le prix de la réservation et met à jour l'affichage
         */
        function calculatePrice() {
            if (!startDateInput || !endDateInput || !pricePerDay) {
                return;
            }
            
            // Obtenir les dates avec le temps réglé à minuit pour un calcul précis
            let startDate = new Date(startDateInput.value);
            let endDate = new Date(endDateInput.value);
            
            // Si les dates sont invalides, sortir
            if (isNaN(startDate.getTime()) || isNaN(endDate.getTime())) {
                return;
            }
            
            // Normaliser à minuit UTC pour un calcul cohérent
            startDate = new Date(startDate.getFullYear(), startDate.getMonth(), startDate.getDate());
            endDate = new Date(endDate.getFullYear(), endDate.getMonth(), endDate.getDate());
            
            // Calculer le nombre de jours (au moins 1 jour)
            const diffTime = Math.abs(endDate - startDate);
            const numberOfDays = Math.max(Math.ceil(diffTime / (1000 * 60 * 60 * 24)), 1);
            
            // Calculer le sous-total
            const subtotal = parseFloat((pricePerDay * numberOfDays).toFixed(2));
            
            // Vérifier promotion
            let discount = 0;
            let discountText = '';
            let promotionApplied = false;
            
            if (promotionElement && promotionElement.value) {
                const promotionId = parseInt(promotionElement.value);
                if (promotions[promotionId]) {
                    const discountPercentage = promotions[promotionId].discount_percentage;
                    discount = parseFloat(((subtotal * discountPercentage) / 100).toFixed(2));
                    discountText = `(-${discountPercentage}%)`;
                    promotionApplied = true;
                }
            }
            
            // Calculer le total (minimum 0.01)
            const totalPrice = Math.max(parseFloat((subtotal - discount).toFixed(2)), 0.01);
            
            console.log('Price calculation:', {
                startDate: startDate,
                endDate: endDate,
                numberOfDays: numberOfDays,
                pricePerDay: pricePerDay,
                subtotal: subtotal,
                discount: discount,
                total: totalPrice
            });
            
            // Mettre à jour l'affichage avec effet d'animation
            if (numberOfDaysElement) {
                const currentDays = parseInt(numberOfDaysElement.textContent) || 0;
                if (currentDays !== numberOfDays) {
                    numberOfDaysElement.classList.add('text-yellow-600');
                    numberOfDaysElement.textContent = numberOfDays;
                    setTimeout(() => numberOfDaysElement.classList.remove('text-yellow-600'), 500);
                }
            }
            
            if (subtotalElement) {
                subtotalElement.textContent = formatCurrency(subtotal);
            }
            
            if (discountElement) {
                discountElement.textContent = discount > 0 ? 
                    `${formatCurrency(discount)} ${discountText}` : 
                    '0,00€';
                
                // Afficher/masquer ligne de remise
                const discountRow = discountElement.closest('.discount-row');
                if (discountRow) {
                    if (promotionApplied) {
                        discountRow.style.display = 'flex';
                        discountRow.style.opacity = '1';
                    } else {
                        discountRow.style.opacity = '0';
                        setTimeout(() => discountRow.style.display = 'none', 300);
                    }
                }
            }
            
            if (totalPriceElement) {
                const currentPrice = parseFloat(totalPriceElement.textContent.replace('€', '').replace(',', '.')) || 0;
                if (Math.abs(currentPrice - totalPrice) > 0.01) {
                    totalPriceElement.classList.add('text-yellow-600');
                    totalPriceElement.textContent = formatCurrency(totalPrice);
                    setTimeout(() => totalPriceElement.classList.remove('text-yellow-600'), 500);
                }
            }
            
            // IMPORTANT: Mettre à jour le champ caché correctement
            if (hiddenTotalPriceInput) {
                hiddenTotalPriceInput.value = totalPrice.toFixed(2);
                console.log('Input prix total mis à jour:', hiddenTotalPriceInput.value, 'Valeur calculée:', totalPrice.toFixed(2));
            }
        }
        
        /**
         * Formater un montant en devise
         */
        function formatCurrency(amount) {
            return amount.toFixed(2).replace('.', ',') + '€';
        }
        
        /**
         * Valider et corriger les dates si nécessaire
         */
        function validateDates() {
            if (!startDateInput || !endDateInput) return;
            
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            
            if (isNaN(startDate.getTime()) || isNaN(endDate.getTime())) return;
            
            // Normaliser les dates pour un calcul cohérent
            const startMidnight = new Date(startDate.getFullYear(), startDate.getMonth(), startDate.getDate());
            const endMidnight = new Date(endDate.getFullYear(), endDate.getMonth(), endDate.getDate());
            
            // Si la date de fin est avant ou égale à la date de début, ajouter un jour
            if (endMidnight <= startMidnight) {
                // Ajouter un jour à la date de début
                const nextDay = new Date(startMidnight);
                nextDay.setDate(nextDay.getDate() + 1);
                
                // Formatage YYYY-MM-DD
                const year = nextDay.getFullYear();
                const month = String(nextDay.getMonth() + 1).padStart(2, '0');
                const day = String(nextDay.getDate()).padStart(2, '0');
                
                endDateInput.value = `${year}-${month}-${day}`;
            }
            
            // Recalculer le prix après validation des dates
            calculatePrice();
        }
        
        /**
         * Définir les dates minimales
         */
        function setMinDates() {
            if (!startDateInput || !endDateInput) return;
            
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            
            const formatDate = (date) => {
                return date.toISOString().split('T')[0];
            };
            
            startDateInput.min = formatDate(today);
            endDateInput.min = formatDate(tomorrow);
        }
        
        // Configuration des écouteurs d'événements
        
        // Dates
        if (startDateInput) {
            startDateInput.addEventListener('change', validateDates);
            startDateInput.addEventListener('input', validateDates);
        }
        
        if (endDateInput) {
            endDateInput.addEventListener('change', validateDates);
            endDateInput.addEventListener('input', validateDates);
        }
        
        // Promotion
        if (promotionElement) {
            promotionElement.addEventListener('change', calculatePrice);
        }
        
        // Ajouter écouteur au formulaire pour vérifier le prix avant soumission
        const reservationForm = document.getElementById('reservation-form');
        if (reservationForm) {
            reservationForm.addEventListener('submit', function(e) {
                // Recalculer le prix une dernière fois avant la soumission
                calculatePrice();
                
                // Si le prix est 0 ou non défini, empêcher la soumission
                if (!hiddenTotalPriceInput.value || parseFloat(hiddenTotalPriceInput.value) <= 0) {
                    e.preventDefault();
                    alert('Erreur de calcul du prix. Veuillez réessayer ou contacter l\'assistance.');
                    return false;
                }
            });
        }
        
        // Boutons d'adresse
        if (sameAddressBtn) {
            sameAddressBtn.addEventListener('click', function() {
                if (pickupLocationInput.value) {
                    returnLocationInput.value = pickupLocationInput.value;
                    returnLocationInput.classList.add('border-yellow-500');
                    setTimeout(() => returnLocationInput.classList.remove('border-yellow-500'), 800);
                }
            });
        }
        
        if (homeAddressBtn) {
            homeAddressBtn.addEventListener('click', function() {
                const userAddress = window.userAddressData || '';
                if (userAddress) {
                    pickupLocationInput.value = userAddress;
                    returnLocationInput.value = userAddress;
                    
                    pickupLocationInput.classList.add('border-yellow-500');
                    returnLocationInput.classList.add('border-yellow-500');
                    setTimeout(() => {
                        pickupLocationInput.classList.remove('border-yellow-500');
                        returnLocationInput.classList.remove('border-yellow-500');
                    }, 800);
                } else {
                    alert('Aucune adresse trouvée dans votre profil. Veuillez la saisir manuellement.');
                }
            });
        }
        
        if (agencyAddressBtn) {
            agencyAddressBtn.addEventListener('click', function() {
                pickupLocationInput.value = agencyAddress;
                returnLocationInput.value = agencyAddress;
                
                pickupLocationInput.classList.add('border-yellow-500');
                returnLocationInput.classList.add('border-yellow-500');
                setTimeout(() => {
                    pickupLocationInput.classList.remove('border-yellow-500');
                    returnLocationInput.classList.remove('border-yellow-500');
                }, 800);
            });
        }
        
        // Initialiser le calendrier de disponibilité
        initAvailabilityCalendar();
        
        // Galerie photos
        setupPhotoGallery();
        
        // Initialiser
        setMinDates();
        validateDates();
    });
    
    /**
     * Configure la galerie de photos
     */
    function setupPhotoGallery() {
        const photoElements = document.querySelectorAll('#mainPhotoContainer img');
        const photoCount = photoElements.length;
        if (photoCount <= 1) return;
        
        let currentPhotoIndex = 0;
        const thumbnailItems = document.querySelectorAll('.thumbnail-item');
        const prevButton = document.getElementById('prevPhoto');
        const nextButton = document.getElementById('nextPhoto');
        const photoCounter = document.getElementById('currentPhotoIndex');
        
        function showPhoto(index) {
            // Masquer toutes les photos avec effet de transition
            photoElements.forEach(photo => {
                photo.classList.remove('opacity-100', 'scale-100');
                photo.classList.add('opacity-0', 'scale-105');
            });
            
            // Afficher la photo sélectionnée avec effet de transition
            setTimeout(() => {
                photoElements[index].classList.remove('opacity-0', 'scale-105');
                photoElements[index].classList.add('opacity-100', 'scale-100');
            }, 200);
            
            // Mettre à jour les vignettes
            thumbnailItems.forEach(thumb => {
                thumb.classList.remove('ring-2', 'ring-yellow-500');
            });
            
            if (thumbnailItems[index]) {
                thumbnailItems[index].classList.add('ring-2', 'ring-yellow-500');
            }
            
            // Mettre à jour le compteur
            if (photoCounter) {
                photoCounter.textContent = index + 1;
            }
            
            currentPhotoIndex = index;
        }
        
        if (nextButton) {
            nextButton.addEventListener('click', function() {
                const newIndex = (currentPhotoIndex + 1) % photoCount;
                showPhoto(newIndex);
            });
        }
        
        if (prevButton) {
            prevButton.addEventListener('click', function() {
                const newIndex = (currentPhotoIndex - 1 + photoCount) % photoCount;
                showPhoto(newIndex);
            });
        }
        
        thumbnailItems.forEach(thumb => {
            thumb.addEventListener('click', function() {
                const index = parseInt(this.dataset.index);
                showPhoto(index);
            });
        });
        
        // Rotation automatique des photos (toutes les 5 secondes)
        let autoRotateInterval = setInterval(function() {
            // Vérifier que les éléments existent toujours (en cas de navigation)
            if (!document.body.contains(photoElements[0])) {
                clearInterval(autoRotateInterval);
                return;
            }
            
            const newIndex = (currentPhotoIndex + 1) % photoCount;
            showPhoto(newIndex);
        }, 5000);
        
        // Arrêter la rotation automatique si l'utilisateur interagit avec les photos
        const stopAutoRotate = () => {
            clearInterval(autoRotateInterval);
            autoRotateInterval = null;
        };
        
        // Ajouter des écouteurs d'événements pour arrêter la rotation automatique
        if (prevButton) prevButton.addEventListener('click', stopAutoRotate);
        if (nextButton) nextButton.addEventListener('click', stopAutoRotate);
        thumbnailItems.forEach(thumb => {
            thumb.addEventListener('click', stopAutoRotate);
        });
        
        // Ajouter des écouteurs pour les touches du clavier
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                if (prevButton) {
                    prevButton.click();
                    stopAutoRotate();
                }
            } else if (e.key === 'ArrowRight') {
                if (nextButton) {
                    nextButton.click();
                    stopAutoRotate();
                }
            }
        });
    }
    
    /**
     * Calendrier de disponibilité interactif
     */
    function initAvailabilityCalendar() {
        const calendarContainer = document.getElementById('availability-calendar');
        if (!calendarContainer) return;
        
        // Prepare calendar structure
        calendarContainer.innerHTML = `
            <div class="calendar-header flex justify-between items-center mb-4">
                <button id="prev-month" class="p-2 rounded-full hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <h4 id="calendar-month-year" class="text-lg font-medium text-gray-800"></h4>
                <button id="next-month" class="p-2 rounded-full hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
            <div class="calendar-grid"></div>
            
            <div class="mt-4 flex flex-wrap justify-center items-center gap-4 text-sm">
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-green-100 border border-green-400 rounded-sm mr-2"></div>
                    <span>Disponible</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-red-100 border border-red-400 rounded-sm mr-2"></div>
                    <span>Indisponible</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-blue-100 border border-blue-400 rounded-sm mr-2"></div>
                    <span>Sélectionné</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-gray-200 border border-gray-300 rounded-sm mr-2"></div>
                    <span>Passé</span>
                </div>
            </div>
            
            <div class="mt-4 text-xs text-gray-600 bg-blue-50 p-3 rounded-lg border border-blue-100">
                <p class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500 mr-1 flex-shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    <span>Cliquez sur une date pour sélectionner le début de votre réservation, puis cliquez sur une autre date pour définir la fin.</span>
                </p>
            </div>
        `;

        // Get calendar elements
        const prevMonthBtn = document.getElementById('prev-month');
        const nextMonthBtn = document.getElementById('next-month');
        const monthYearHeader = document.getElementById('calendar-month-year');
        const calendarGrid = calendarContainer.querySelector('.calendar-grid');
        
        // References to date inputs
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        
        // Get vehicle ID for availability check
        const vehicleId = document.querySelector('input[name="vehicle_id"]').value;
        
        // Current date and calendar state
        const today = new Date();
        let currentMonth = today.getMonth();
        let currentYear = today.getFullYear();
        let selectedStartDate = startDateInput.value ? new Date(startDateInput.value) : null;
        let selectedEndDate = endDateInput.value ? new Date(endDateInput.value) : null;
        
        // Normalize selected dates to midnight
        if (selectedStartDate) selectedStartDate.setHours(0, 0, 0, 0);
        if (selectedEndDate) selectedEndDate.setHours(0, 0, 0, 0);
        
        // Selection state
        let selectionMode = selectedStartDate && selectedEndDate ? 'complete' : (selectedStartDate ? 'start' : 'none');
        
        // Store unavailable dates
        const unavailableDates = [];
        
        // Format a date to YYYY-MM-DD string
        function formatYMD(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }
        
        // Check if a date is unavailable
        function isDateUnavailable(date) {
            return unavailableDates.includes(formatYMD(date));
        }
        
        // Check if a date is in the past
        function isDateInPast(date) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            return date < today;
        }
        
        // Check if a date is selected (start or end)
        function isDateSelected(date) {
            if (!date) return false;
            return (selectedStartDate && date.getTime() === selectedStartDate.getTime()) || 
                   (selectedEndDate && date.getTime() === selectedEndDate.getTime());
        }
        
        // Check if a date is in the selected range
        function isDateInRange(date) {
            if (!selectedStartDate || !selectedEndDate) return false;
            return date > selectedStartDate && date < selectedEndDate;
        }
        
        // Load real availability data from the server
        function loadAvailabilityData(month, year) {
            // Show loading indicator
            calendarGrid.innerHTML = `
                <div class="flex justify-center items-center py-12">
                    <div class="animate-spin rounded-full h-6 w-6 border-t-2 border-b-2 border-yellow-500"></div>
                    <span class="ml-2 text-gray-500 text-sm">Chargement...</span>
                </div>
            `;
            
            // Make API request to get unavailable dates
            return fetch(`/vehicles/${vehicleId}/availability?year=${year}&month=${month}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur lors du chargement des disponibilités');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Available dates loaded:', data);
                    return data.unavailableDates || [];
                })
                .catch(error => {
                    console.error('Error loading availability data:', error);
                    // In case of error, return empty array to avoid breaking the calendar
                    return [];
                });
        }
        
        // Generate calendar grid
        async function generateCalendar(month, year) {
            // Update month/year header
            const monthNames = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 
                               'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
            monthYearHeader.textContent = `${monthNames[month]} ${year}`;
            
            // Load availability data from the server
            const monthUnavailableDates = await loadAvailabilityData(month, year);
            
            // Update unavailable dates
            unavailableDates.length = 0;
            unavailableDates.push(...monthUnavailableDates);
            
            // Clear calendar
            calendarGrid.innerHTML = '';
            
            // Create weekday headers
            const weekdays = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
            const weekdaysRow = document.createElement('div');
            weekdaysRow.className = 'grid grid-cols-7 gap-1 mb-2';
            
            weekdays.forEach(day => {
                const dayHeader = document.createElement('div');
                dayHeader.className = 'text-center text-sm font-medium text-gray-700 py-1';
                dayHeader.textContent = day;
                weekdaysRow.appendChild(dayHeader);
            });
            
            calendarGrid.appendChild(weekdaysRow);
            
            // Create dates grid
            const daysGrid = document.createElement('div');
            daysGrid.className = 'grid grid-cols-7 gap-1';
            
            // Get first day of month (0 = Sunday)
            const firstDay = new Date(year, month, 1).getDay();
            // Adjust for Monday as first day (0 = Monday)
            const firstWeekday = firstDay === 0 ? 6 : firstDay - 1;
            
            // Get number of days in month
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            
            // Create empty cells for days before first day of month
            for (let i = 0; i < firstWeekday; i++) {
                const emptyCell = document.createElement('div');
                emptyCell.className = 'h-9';
                daysGrid.appendChild(emptyCell);
            }
            
            // Create cells for each day of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const date = new Date(year, month, day);
                const dateCell = document.createElement('div');
                dateCell.className = 'relative h-9';
                
                const dateBtn = document.createElement('button');
                dateBtn.type = 'button';
                dateBtn.className = 'w-full h-full flex items-center justify-center text-sm rounded-md transition-all duration-200';
                dateBtn.textContent = day;
                
                // Check date status
                const isPast = isDateInPast(date);
                const isUnavailable = isDateUnavailable(date);
                const isStart = selectedStartDate && date.getTime() === selectedStartDate.getTime();
                const isEnd = selectedEndDate && date.getTime() === selectedEndDate.getTime();
                const isRange = isDateInRange(date);
                const isToday = date.getTime() === new Date().setHours(0, 0, 0, 0);
                
                // Apply appropriate styling based on date status
                if (isPast) {
                    dateBtn.className += ' bg-gray-100 text-gray-400 cursor-not-allowed';
                    dateBtn.disabled = true;
                } else if (isUnavailable) {
                    dateBtn.className += ' bg-red-100 text-red-500 cursor-not-allowed';
                    dateBtn.disabled = true;
                } else if (isStart || isEnd) {
                    dateBtn.className += ' bg-yellow-500 text-white font-medium';
                } else if (isRange) {
                    dateBtn.className += ' bg-yellow-100 text-yellow-800';
                } else {
                    dateBtn.className += ' bg-green-50 text-gray-700 hover:bg-green-100';
                    
                    // Add click handler for date selection
                    dateBtn.addEventListener('click', () => {
                        handleDateSelection(date);
                    });
                }
                
                // Add indicator for today
                if (isToday) {
                    dateBtn.className += ' ring-2 ring-blue-400';
                }
                
                dateCell.appendChild(dateBtn);
                daysGrid.appendChild(dateCell);
            }
            
            calendarGrid.appendChild(daysGrid);
        }
        
        // Handle date selection
        function handleDateSelection(date) {
            switch (selectionMode) {
                case 'none':
                case 'complete':
                    // Start a new selection
                    selectedStartDate = date;
                    selectedEndDate = null;
                    selectionMode = 'start';
                    
                    // Update form inputs
                    startDateInput.value = formatYMD(date);
                    endDateInput.value = '';
                    
                    // Trigger form validation/calculation
                    startDateInput.dispatchEvent(new Event('change'));
                    break;
                    
                case 'start':
                    // Complete the selection
                    if (date < selectedStartDate) {
                        // If clicking earlier date, swap dates
                        selectedEndDate = selectedStartDate;
                        selectedStartDate = date;
                        
                        // Update inputs
                        startDateInput.value = formatYMD(date);
                        endDateInput.value = formatYMD(selectedEndDate);
                    } else {
                        selectedEndDate = date;
                        endDateInput.value = formatYMD(date);
                    }
                    
                    selectionMode = 'complete';
                    
                    // Trigger form validation/calculation
                    endDateInput.dispatchEvent(new Event('change'));
                    break;
            }
            
            // Regenerate calendar with new selection
            generateCalendar(currentMonth, currentYear);
        }
        
        // Event handlers for month navigation
        prevMonthBtn.addEventListener('click', () => {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            generateCalendar(currentMonth, currentYear);
        });
        
        nextMonthBtn.addEventListener('click', () => {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            generateCalendar(currentMonth, currentYear);
        });
        
        // Keep calendar in sync with form inputs
        startDateInput.addEventListener('change', () => {
            if (startDateInput.value) {
                selectedStartDate = new Date(startDateInput.value);
                selectedStartDate.setHours(0, 0, 0, 0);
                selectionMode = selectedEndDate ? 'complete' : 'start';
                
                // If selection changed month, update calendar view
                if (selectedStartDate.getMonth() !== currentMonth || 
                    selectedStartDate.getFullYear() !== currentYear) {
                    currentMonth = selectedStartDate.getMonth();
                    currentYear = selectedStartDate.getFullYear();
                }
                
                generateCalendar(currentMonth, currentYear);
            }
        });
        
        endDateInput.addEventListener('change', () => {
            if (endDateInput.value) {
                selectedEndDate = new Date(endDateInput.value);
                selectedEndDate.setHours(0, 0, 0, 0);
                if (selectedStartDate) {
                    selectionMode = 'complete';
                }
                generateCalendar(currentMonth, currentYear);
            }
        });
        
        // Initialize
        generateCalendar(currentMonth, currentYear);
    }
</script>
@endsection
