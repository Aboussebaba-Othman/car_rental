@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        @if (session('error'))
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif
        
        <div class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $vehicle->brand }} {{ $vehicle->model }}</h1>
                    <p class="text-gray-600 text-lg">Année {{ $vehicle->year }}</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Retour
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Vehicle Details -->
            <div class="lg:col-span-2">
                <div class="bg-white overflow-hidden shadow-md rounded-lg">
                    <!-- Photo Gallery -->
                    <div class="relative">
                        @if($vehicle->photos->count() > 0)
                            <div class="carousel">
                                <!-- Primary photo -->
                                @php $primaryPhoto = $vehicle->photos->firstWhere('is_primary', true) ?? $vehicle->photos->first(); @endphp
                                <div class="carousel-main h-96 bg-gray-200">
                                    <img src="{{ asset('storage/' . $primaryPhoto->path) }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}" class="w-full h-full object-cover">
                                </div>
                                
                                <!-- Thumbnails -->
                                @if($vehicle->photos->count() > 1)
                                <div class="grid grid-cols-5 gap-2 mt-2">
                                    @foreach($vehicle->photos as $photo)
                                    <div class="h-20 cursor-pointer {{ $photo->is_primary ? 'ring-2 ring-yellow-500' : '' }}">
                                        <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}" class="w-full h-full object-cover rounded">
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        @else
                            <div class="h-96 flex items-center justify-center bg-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Price Badge -->
                        <div class="absolute top-0 right-0 bg-yellow-500 text-white px-4 py-2 m-4 rounded-lg font-bold text-xl">
                            @if(isset($promotion) && $promotion->is_active)
                                <span class="line-through text-yellow-200 mr-2">{{ number_format($vehicle->price_per_day, 2) }}€</span>
                                {{ number_format($vehicle->price_per_day * (1 - $promotion->discount_percentage / 100), 2) }}€/jour
                            @else
                                {{ number_format($vehicle->price_per_day, 2) }}€/jour
                            @endif
                        </div>
                    </div>
                    
                    <!-- Vehicle Specifications -->
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Détails du véhicule</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-700 mb-3">Caractéristiques principales</h3>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Marque</p>
                                            <p class="font-medium">{{ $vehicle->brand }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Modèle</p>
                                            <p class="font-medium">{{ $vehicle->model }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Année</p>
                                            <p class="font-medium">{{ $vehicle->year }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Immatriculation</p>
                                            <p class="font-medium">{{ $vehicle->license_plate }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-700 mb-3">Spécifications techniques</h3>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Transmission</p>
                                            <p class="font-medium">
                                                @if($vehicle->transmission === 'automatic') 
                                                    Automatique
                                                @elseif($vehicle->transmission === 'manual')
                                                    Manuelle
                                                @else
                                                    {{ ucfirst($vehicle->transmission) }}
                                                @endif
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Carburant</p>
                                            <p class="font-medium">
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
                                        <div>
                                            <p class="text-sm text-gray-500">Nombre de places</p>
                                            <p class="font-medium">{{ $vehicle->seats }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if(is_array($vehicle->features) && count($vehicle->features) > 0)
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-700 mb-3">Équipements</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($vehicle->features as $feature)
                                <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">
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
                                            Régulateur de vitesse
                                            @break
                                        @case('parking_sensors')
                                            Capteurs de stationnement
                                            @break
                                        @case('backup_camera')
                                            Caméra de recul
                                            @break
                                        @default
                                            {{ ucfirst(str_replace('_', ' ', $feature)) }}
                                    @endswitch
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        @if($vehicle->description)
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-700 mb-3">Description</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-600">{{ $vehicle->description }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Reservation Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow-md rounded-lg overflow-hidden  top-6">
                    <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 p-4">
                        <h2 class="text-xl font-bold text-white">Réservez ce véhicule</h2>
                    </div>
                    
                    <div class="p-6">
                        <form action="{{ route('reservations.create', $vehicle->id) }}" method="GET">
                            <div class="mb-4">
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                                <div class="relative">
                                    <input type="date" id="start_date" name="start_date" 
                                           value="{{ request('start_date', \Carbon\Carbon::now()->addDay()->format('Y-m-d')) }}" 
                                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50" 
                                           min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-6">
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                                <div class="relative">
                                    <input type="date" id="end_date" name="end_date" 
                                           value="{{ request('end_date', \Carbon\Carbon::now()->addDays(3)->format('Y-m-d')) }}" 
                                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50" 
                                           min="{{ \Carbon\Carbon::now()->addDay()->format('Y-m-d') }}">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            @if(isset($promotion) && $promotion->is_active)
                            <div class="mb-6 bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="font-medium text-yellow-800">Promotion: {{ $promotion->name }}</span>
                                </div>
                                <div class="mt-1 text-yellow-700">
                                    -{{ $promotion->discount_percentage }}% sur le prix de location.
                                </div>
                                <input type="hidden" name="promotion_id" value="{{ $promotion->id }}">
                            </div>
                            @endif
                            
                            <div class="mb-6">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-gray-600">Prix par jour:</span>
                                        <span>{{ number_format($vehicle->price_per_day, 2) }}€</span>
                                    </div>
                                    @if(isset($promotion) && $promotion->is_active)
                                    <div class="flex justify-between items-center mb-2 text-green-600">
                                        <span>Réduction ({{ $promotion->discount_percentage }}%):</span>
                                        <span>-{{ number_format($vehicle->price_per_day * $promotion->discount_percentage / 100, 2) }}€</span>
                                    </div>
                                    <div class="border-t border-gray-300 my-2 pt-2 flex justify-between items-center font-semibold">
                                        <span>Prix après réduction:</span>
                                        <span>{{ number_format($vehicle->price_per_day * (1 - $promotion->discount_percentage / 100), 2) }}€</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            
                            @auth
                            <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-3 px-4 rounded-lg shadow-sm transition duration-200 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                </svg>
                                Réserver maintenant
                            </button>
                            @else
                            <a href="{{ route('login') }}?redirect={{ url()->current() }}" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-3 px-4 rounded-lg shadow-sm transition duration-200 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Connectez-vous pour réserver
                            </a>
                            @endauth
                        </form>
                    </div>
                </div>
                
                @if(isset($vehicle->company))
                <div class="mt-6 bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="border-b border-gray-200 bg-gradient-to-r from-yellow-50 to-white">
                        <h3 class="text-lg font-medium p-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            À propos de l'entreprise
                        </h3>
                    </div>
                    <div class="p-5">
                        <div class="flex flex-col sm:flex-row sm:items-center mb-4 pb-4 border-b border-gray-100">
                            <div class="flex items-center mb-3 sm:mb-0 sm:mr-6">
                                @if(isset($vehicle->company->logo) && $vehicle->company->logo)
                                    <img src="{{ asset('storage/' . $vehicle->company->logo) }}" alt="{{ $vehicle->company->company_name }}" class="h-16 w-16 rounded-full object-cover mr-4 border-2 border-yellow-200 shadow-sm">
                                @else
                                    <div class="h-16 w-16 rounded-full bg-yellow-100 flex items-center justify-center mr-4 shadow-sm border-2 border-yellow-200">
                                        <span class="text-yellow-800 font-bold text-xl">{{ strtoupper(substr($vehicle->company->company_name, 0, 2)) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <h4 class="font-bold text-lg text-gray-800">{{ $vehicle->company->company_name }}</h4>
                                    <p class="text-sm text-gray-500">Membre depuis {{ $vehicle->company->created_at->locale('fr')->format('M Y') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-3 mb-4">
                            {{-- Address & City Display --}}
                            <div class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-2 mt-0.5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-600">
                                    @if(($vehicle->company->address ?? false) || ($vehicle->company->city ?? false))
                                        {{ $vehicle->company->address ?? '' }}
                                        @if(($vehicle->company->address ?? false) && ($vehicle->company->city ?? false)), @endif
                                        {{ $vehicle->company->city ?? '' }}
                                    @else
                                        <span class="text-gray-400 italic">Adresse non renseignée</span>
                                    @endif
                                </span>
                            </div>
                            
                            {{-- Véhicules disponibles --}}
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H11a1 1 0 001-1v-1h2a1 1 0 001-1v-3a1 1 0 00-.2-.4l-3-4A1 1 0 0011 5H4a1 1 0 00-1 1z" />
                                </svg>
                                <span class="text-sm text-gray-600">
                                    @php
                                        $vehicleCount = $vehicle->company->vehicles_count ?? 
                                            ($vehicle->company->vehicles ? $vehicle->company->vehicles->count() : 1);
                                    @endphp
                                    {{ $vehicleCount }} véhicule{{ $vehicleCount > 1 ? 's' : '' }} disponible{{ $vehicleCount > 1 ? 's' : '' }}
                                </span>
                            </div>
                            
                            {{-- Phone Display (from user) --}}
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                                <span class="text-sm text-gray-600">
                                    @if($vehicle->company->user && $vehicle->company->user->phone)
                                        <a href="tel:{{ $vehicle->company->user->phone }}" class="hover:text-yellow-700">{{ $vehicle->company->user->phone }}</a>
                                    @else
                                        <span class="text-gray-400 italic">Téléphone non renseigné</span>
                                    @endif
                                </span>
                            </div>
                            
                            {{-- Email Display (from user) --}}
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                                <span class="text-sm text-gray-600">
                                    @if($vehicle->company->user && $vehicle->company->user->email)
                                        <a href="mailto:{{ $vehicle->company->user->email }}" class="hover:text-yellow-700">{{ $vehicle->company->user->email }}</a>
                                    @else
                                        <span class="text-gray-400 italic">Email non renseigné</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap gap-3 mt-5 pt-3 border-t border-gray-100">
                            <a href="{{ route('vehicles.index', ['company_id' => $vehicle->company_id]) }}" class="inline-flex items-center px-3 py-1.5 bg-yellow-100 text-yellow-800 rounded-md hover:bg-yellow-200 transition-colors text-sm font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H11a1 1 0 001-1v-1h2a1 1 0 001-1v-3a1 1 0 00-.2-.4l-3-4A1 1 0 0011 5H4a1 1 0 00-1 1z" />
                                </svg>
                                Voir tous les véhicules
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Social Sharing -->
                <div class="mt-6 bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="border-b border-gray-200">
                        <h3 class="text-lg font-medium p-4">Partagez ce véhicule</h3>
                    </div>
                    <div class="p-4 flex space-x-4 justify-center">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($vehicle->brand . ' ' . $vehicle->model . ' - Location de voiture') }}&url={{ urlencode(request()->url()) }}" target="_blank" class="text-blue-400 hover:text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723 9.99 9.99 0 01-3.127 1.195 4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.937 4.937 0 004.604 3.417 9.868 9.868 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63a9.936 9.936 0 002.46-2.548l-.047-.02z"/>
                            </svg>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode('Découvrez ce véhicule: ' . $vehicle->brand . ' ' . $vehicle->model . ' ' . request()->url()) }}" target="_blank" class="text-green-500 hover:text-green-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Avis clients</h2>
            
            @if(isset($reviews) && $reviews->count() > 0)
                <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="mr-4">
                                <span class="text-4xl font-bold text-gray-800">{{ number_format($reviews->avg('rating'), 1) }}</span>
                                <div class="flex mt-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($reviews->avg('rating')))
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <p class="text-sm text-gray-500 mt-1">{{ $reviews->count() }} avis</p>
                            </div>
                            <div class="flex-1">
                                @for($i = 5; $i >= 1; $i--)
                                    <div class="flex items-center mt-1">
                                        <span class="text-sm text-gray-600 w-2">{{ $i }}</span>
                                        <div class="w-full h-2 bg-gray-200 rounded-full mx-2">
                                            @php
                                                $percent = $reviews->count() > 0 ? ($reviews->where('rating', $i)->count() / $reviews->count()) * 100 : 0;
                                            @endphp
                                            <div class="h-2 bg-yellow-500 rounded-full" style="width: {{ $percent }}%"></div>
                                        </div>
                                        <span class="text-sm text-gray-600">{{ $reviews->where('rating', $i)->count() }}</span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                    
                    <!-- Individual Reviews -->
                    <div class="divide-y divide-gray-200">
                        @foreach($reviews->take(5) as $review)
                            <div class="p-6">
                                <div class="flex items-center mb-2">
                                    <div class="flex mr-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                    <h4 class="font-medium text-gray-800">{{ $review->title }}</h4>
                                </div>
                                <p class="text-gray-600 mb-2">{{ $review->comment }}</p>
                                <div class="flex items-center text-sm text-gray-500">
                                    <span>{{ $review->user->name ?? 'Utilisateur anonyme' }} • {{ $review->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    {{-- @if($reviews->count() > 5)
                        <div class="p-4 text-center">
                            <a href="#" class="text-yellow-500 hover:text-yellow-700 font-medium">Voir tous les avis</a>
                        </div>
                    @endif --}}
                </div>
            @else
                <div class="bg-white shadow-md rounded-lg p-6 text-center">
                    <p class="text-gray-600 mb-4">Aucun avis pour ce véhicule pour le moment.</p>
                    @auth
                        <a href="" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            Laisser un avis
                        </a>
                    @else
                        <a href="{{ route('login') }}?redirect={{ url()->current() }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Connectez-vous pour laisser un avis
                        </a>
                    @endauth
                </div>
            @endif
        </div>

        <!-- Similar Vehicles Section -->
        @if(isset($similarVehicles) && $similarVehicles->count() > 0)
        <div class="mt-12 mb-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Véhicules similaires</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($similarVehicles as $similarVehicle)
                <div class="bg-white shadow-md rounded-lg overflow-hidden transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg">
                    <a href="{{ route('vehicles.show', $similarVehicle->id) }}">
                        <div class="h-48 bg-gray-200 relative">
                            @php $photo = $similarVehicle->photos->firstWhere('is_primary', true) ?? $similarVehicle->photos->first(); @endphp
                            @if($photo)
                                <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $similarVehicle->brand }} {{ $similarVehicle->model }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute top-0 right-0 bg-yellow-500 text-white px-2 py-1 m-2 rounded font-bold">
                                {{ number_format($similarVehicle->price_per_day, 2) }}€/jour
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-lg text-gray-800">{{ $similarVehicle->brand }} {{ $similarVehicle->model }}</h3>
                            <p class="text-gray-600 text-sm">{{ $similarVehicle->year }} • {{ ucfirst($similarVehicle->transmission === 'automatic' ? 'Automatique' : 'Manuelle') }}</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Photo Gallery Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mainImage = document.querySelector('.carousel-main img');
    const thumbnails = document.querySelectorAll('.carousel .grid img');
    
    thumbnails.forEach(thumb => {
        thumb.addEventListener('click', function() {
            mainImage.src = this.src;
            
            // Remove highlight from all thumbnails
            thumbnails.forEach(t => t.parentElement.classList.remove('ring-2', 'ring-yellow-500'));
            
            // Add highlight to selected thumbnail
            this.parentElement.classList.add('ring-2', 'ring-yellow-500');
        });
    });
});
</script>

@include('layouts.footer')
@endsection