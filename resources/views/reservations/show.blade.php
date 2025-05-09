@extends('layouts.app')

@section('content')
<div class="py-16 bg-gradient-to-b from-gray-50 to-gray-100">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-5 rounded-lg shadow-sm animate-fade-in" role="alert">
                <p class="font-medium flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-5 rounded-lg shadow-sm animate-pulse" role="alert">
                <p class="font-medium flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    {{ session('error') }}
                </p>
            </div>
        @endif

        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between bg-white p-6 rounded-2xl shadow-md border border-gray-100">
            <div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-yellow-100 rounded-full mr-3 text-yellow-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800">Réservation #{{ $reservation->id }}</h1>
                </div>
                <p class="text-gray-600 mt-2 ml-13">Créée le {{ \Carbon\Carbon::parse($reservation->created_at)->format('d/m/Y à H:i') }}</p>
            </div>
            <span class="mt-4 md:mt-0 px-4 py-2 rounded-full text-sm font-medium inline-flex items-center
                @if($reservation->status === 'confirmed') bg-green-100 text-green-800 
                @elseif($reservation->status === 'pending') bg-yellow-100 text-yellow-800 
                @elseif($reservation->status === 'payment_pending') bg-blue-100 text-blue-800
                @elseif($reservation->status === 'canceled') bg-red-100 text-red-800
                @elseif($reservation->status === 'completed') bg-gray-100 text-gray-800
                @elseif($reservation->status === 'paid') bg-green-100 text-green-800
                @endif">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                    @if($reservation->status === 'confirmed' || $reservation->status === 'paid')
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    @elseif($reservation->status === 'pending' || $reservation->status === 'payment_pending')
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    @elseif($reservation->status === 'canceled')
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    @elseif($reservation->status === 'completed')
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
                    @endif
                </svg>
                @if($reservation->status === 'confirmed') Confirmée
                @elseif($reservation->status === 'pending') En attente
                @elseif($reservation->status === 'payment_pending') Paiement en cours
                @elseif($reservation->status === 'canceled') Annulée
                @elseif($reservation->status === 'completed') Terminée
                @elseif($reservation->status === 'paid') Payée
                @else {{ $reservation->status }}
                @endif
            </span>
        </div>

        <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-100">
            <div class="p-8 border-b border-gray-200">
                <h2 class="text-2xl font-semibold mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Détails du véhicule
                </h2>
                <div class="flex flex-col lg:flex-row">
                    <div class="w-full lg:w-2/5 mb-6 lg:mb-0">
                        @if($reservation->vehicle->photos->count() > 0)
                            <div class="vehicle-gallery relative">
                                <div class="main-photo mb-3">
                                    @php $primaryPhoto = $reservation->vehicle->photos->firstWhere('is_primary', true) ?? $reservation->vehicle->photos->first(); @endphp
                                    <div class="relative overflow-hidden rounded-xl shadow-md group">
                                        <img src="{{ asset('storage/' . $primaryPhoto->path) }}" alt="{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}" 
                                            class="w-full object-cover h-64 transition-transform duration-700 group-hover:scale-105" id="main-vehicle-photo">
                                        
                                        @if($reservation->vehicle->photos->count() > 1)
                                        <div class="absolute bottom-3 right-3 bg-black bg-opacity-60 text-white px-3 py-1.5 rounded-full text-xs font-medium backdrop-blur-sm">
                                            <span id="current-photo-index">1</span>/<span>{{ $reservation->vehicle->photos->count() }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                
                                @if($reservation->vehicle->photos->count() > 1)
                                    <div class="thumbnails flex space-x-2 overflow-x-auto pb-2 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-transparent">
                                        @foreach($reservation->vehicle->photos as $index => $photo)
                                            <div class="thumbnail-container flex-shrink-0 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md">
                                                <img src="{{ asset('storage/' . $photo->path) }}" 
                                                    alt="{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}" 
                                                    class="h-16 w-20 object-cover rounded-lg cursor-pointer hover:opacity-90 transition-all duration-300 
                                                    {{ $photo->id == $primaryPhoto->id ? 'ring-2 ring-yellow-500' : 'opacity-70' }}"
                                                    onclick="changeMainPhoto('{{ asset('storage/' . $photo->path) }}', this, {{ $index + 1 }})">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="w-full h-64 bg-gray-100 rounded-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="w-full lg:w-3/5 lg:pl-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            {{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }} 
                            <span class="text-gray-500 ml-2">({{ $reservation->vehicle->year }})</span>
                        </h3>
                        
                        <div class="grid grid-cols-2 gap-6 mb-6">
                            <div class="bg-gray-50 p-4 rounded-xl transition-all duration-300 hover:shadow-md hover:bg-gray-100 transform hover:-translate-y-0.5">
                                <span class="text-gray-500 text-sm block mb-1">Transmission:</span>
                                <p class="font-medium flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                    </svg>
                                    @if($reservation->vehicle->transmission === 'automatic') 
                                        Automatique
                                    @elseif($reservation->vehicle->transmission === 'manual')
                                        Manuelle
                                    @else
                                        {{ ucfirst($reservation->vehicle->transmission) }}
                                    @endif
                                </p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-xl transition-all duration-300 hover:shadow-md hover:bg-gray-100 transform hover:-translate-y-0.5">
                                <span class="text-gray-500 text-sm block mb-1">Carburant:</span>
                                <p class="font-medium flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    @if($reservation->vehicle->fuel_type === 'gasoline') 
                                        Essence
                                    @elseif($reservation->vehicle->fuel_type === 'diesel')
                                        Diesel
                                    @elseif($reservation->vehicle->fuel_type === 'electric')
                                        Électrique
                                    @elseif($reservation->vehicle->fuel_type === 'hybrid')
                                        Hybride
                                    @else
                                        {{ ucfirst($reservation->vehicle->fuel_type) }}
                                    @endif
                                </p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-xl transition-all duration-300 hover:shadow-md hover:bg-gray-100 transform hover:-translate-y-0.5">
                                <span class="text-gray-500 text-sm block mb-1">Nombre de places:</span>
                                <p class="font-medium flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    {{ $reservation->vehicle->seats }}
                                </p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-xl transition-all duration-300 hover:shadow-md hover:bg-gray-100 transform hover:-translate-y-0.5">
                                <span class="text-gray-500 text-sm block mb-1">Immatriculation:</span>
                                <p class="font-medium flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                    </svg>
                                    {{ $reservation->vehicle->license_plate }}
                                </p>
                            </div>
                        </div>
                        
                        @if(is_array($reservation->vehicle->features) && count($reservation->vehicle->features) > 0)
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Équipements
                            </h4>
                            <div class="flex flex-wrap gap-2 mt-1">
                                @foreach($reservation->vehicle->features as $feature)
                                <span class="inline-flex items-center px-3 py-1.5 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium border border-yellow-200 shadow-sm transition-all duration-300 hover:shadow-md hover:bg-yellow-200 hover:-translate-y-0.5 transform">
                                    @switch($feature)
                                        @case('air_conditioning')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            Climatisation
                                            @break
                                        @case('gps')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                            </svg>
                                            GPS
                                            @break
                                        @case('bluetooth')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                            </svg>
                                            Bluetooth
                                            @break
                                        @case('usb')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Port USB
                                            @break
                                        @case('heated_seats')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" />
                                            </svg>
                                            Sièges chauffants
                                            @break
                                        @case('sunroof')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                                            </svg>
                                            Toit ouvrant
                                            @break
                                        @case('cruise_control')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Régulateur
                                            @break
                                        @case('parking_sensors')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                            </svg>
                                            Capteurs
                                            @break
                                        @case('backup_camera')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Caméra
                                            @break
                                        @default
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ ucfirst(str_replace('_', ' ', $feature)) }}
                                    @endswitch
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="p-8 border-b border-gray-200">
                <h2 class="text-2xl font-semibold mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Détails de la réservation
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                            <div class="flex items-center justify-center w-8 h-8 bg-yellow-100 rounded-full mr-3 text-yellow-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1  stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            Dates et lieux
                        </h3>
                        <div class="bg-gray-50 p-5 rounded-xl border border-gray-100 transition-all duration-300 hover:shadow-md">
                            <div class="mb-4">
                                <span class="text-gray-500 text-sm flex items-center mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Période de location:
                                </span>
                                <p class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}</p>
                                <p class="text-sm text-gray-600 mt-1">
                                    ({{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) ?: 1 }} jours)
                                </p>
                            </div>
                            
                            <div class="mb-4">
                                <span class="text-gray-500 text-sm flex items-center mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Lieu de prise en charge:
                                </span>
                                <p class="font-medium text-gray-800">{{ $reservation->pickup_location }}</p>
                            </div>
                            
                            <div>
                                <span class="text-gray-500 text-sm flex items-center mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Lieu de retour:
                                </span>
                                <p class="font-medium text-gray-800">{{ $reservation->return_location }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                            <div class="flex items-center justify-center w-8 h-8 bg-yellow-100 rounded-full mr-3 text-yellow-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            Tarification
                        </h3>
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-5 rounded-xl border border-gray-200 transition-all duration-300 hover:shadow-md">
                            <div class="flex justify-between items-center mb-3 pb-3 border-b border-gray-200">
                                <span class="text-gray-700">Prix par jour:</span>
                                <span class="font-medium text-gray-800">{{ number_format($reservation->vehicle->price_per_day, 2) }} €</span>
                            </div>
                            
                            <div class="flex justify-between items-center mb-3 pb-3 border-b border-gray-200">
                                <span class="text-gray-700">Durée de location:</span>
                                <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) ?: 1 }} jours</span>
                            </div>
                            
                            @if($reservation->promotion)
                            <div class="flex justify-between items-center mb-3 pb-3 border-b border-gray-200 text-green-600">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    Promotion ({{ $reservation->promotion->name }}):
                                </span>
                                <span class="font-medium">-{{ $reservation->promotion->discount_percentage }}%</span>
                            </div>
                            @endif
                            
                            <div class="mt-4 pt-3 flex justify-between items-center bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                                <span class="font-bold text-gray-800">Total:</span>
                                <span class="text-xl font-bold text-yellow-600">{{ number_format($reservation->total_price, 2) }} €</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($reservation->driver_name || $reservation->license_number)
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                        <div class="flex items-center justify-center w-8 h-8 bg-yellow-100 rounded-full mr-3 text-yellow-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        Informations du conducteur
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="bg-gray-50 p-5 rounded-xl border border-gray-100 transition-all duration-300 hover:shadow-md">
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <span class="text-gray-500 text-sm flex items-center mb-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Conducteur principal:
                                    </span>
                                    <p class="font-medium text-gray-800">{{ $reservation->driver_name ?? 'Non spécifié' }}</p>
                                </div>
                                
                                <div>
                                    <span class="text-gray-500 text-sm flex items-center mb-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        Téléphone:
                                    </span>
                                    <p class="font-medium text-gray-800">{{ $reservation->driver_phone ?? 'Non spécifié' }}</p>
                                </div>
                                
                                <div>
                                    <span class="text-gray-500 text-sm flex items-center mb-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                        </svg>
                                        Numéro de permis:
                                    </span>
                                    <p class="font-medium text-gray-800">{{ $reservation->license_number ?? 'Non spécifié' }}</p>
                                </div>
                                
                                @if($reservation->license_country)
                                <div>
                                    <span class="text-gray-500 text-sm flex items-center mb-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                                        </svg>
                                        Pays d'émission:
                                    </span>
                                    <p class="font-medium text-gray-800">
                                        @switch($reservation->license_country)
                                            @case('FR') France @break
                                            @case('BE') Belgique @break
                                            @case('CH') Suisse @break
                                            @case('ES') Espagne @break
                                            @case('DE') Allemagne @break
                                            @case('IT') Italie @break
                                            @case('UK') Royaume-Uni @break
                                            @default {{ $reservation->license_country }} @break
                                        @endswitch
                                    </p>
                                </div>
                                @endif
                                
                                @if($reservation->license_expiry)
                                <div>
                                    <span class="text-gray-500 text-sm flex items-center mb-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Expiration du permis:
                                    </span>
                                    <p class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($reservation->license_expiry)->format('d/m/Y') }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        @if($reservation->additional_driver_name)
                        <div class="bg-gray-50 p-5 rounded-xl border border-gray-100 transition-all duration-300 hover:shadow-md">
                            <h4 class="font-medium text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Conducteur additionnel
                            </h4>
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <span class="text-gray-500 text-sm flex items-center mb-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Nom:
                                    </span>
                                    <p class="font-medium text-gray-800">{{ $reservation->additional_driver_name }}</p>
                                </div>
                                
                                @if($reservation->additional_driver_license)
                                <div>
                                    <span class="text-gray-500 text-sm flex items-center mb-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                        </svg>
                                        Numéro de permis:
                                    </span>
                                    <p class="font-medium text-gray-800">{{ $reservation->additional_driver_license }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                
                @if($reservation->notes)
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                        <div class="flex items-center justify-center w-8 h-8 bg-yellow-100 rounded-full mr-3 text-yellow-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                        </div>
                        Notes
                    </h3>
                    <div class="bg-gray-50 p-5 rounded-xl border border-gray-100 transition-all duration-300 hover:shadow-md">
                        <p class="text-gray-700 leading-relaxed">{{ $reservation->notes }}</p>
                    </div>
                </div>
                @endif
            </div>
            
            @if($reservation->status !== 'canceled')
            <div class="p-8 border-b border-gray-200">
                <h2 class="text-2xl font-semibold mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    Informations de paiement
                </h2>
                
                @if(in_array($reservation->status, ['confirmed', 'paid', 'completed']) && $reservation->payment_method)
                    <div class="bg-green-50 p-6 rounded-xl border border-green-100 shadow-sm">
                        <div class="flex items-center mb-5">
                            <div class="flex-shrink-0 bg-green-100 rounded-full p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-semibold text-green-800">Paiement effectué</h3>
                                <p class="text-green-600">Votre paiement a été traité avec succès.</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-white bg-opacity-60 p-4 rounded-lg border border-green-200">
                                <p class="text-sm text-gray-600 mb-1">Méthode de paiement:</p>
                                <p class="font-medium text-gray-800 flex items-center">
                                    @if($reservation->payment_method == 'paypal')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                        PayPal
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                        {{ ucfirst($reservation->payment_method) }}
                                    @endif
                                </p>
                            </div>
                            <div class="bg-white bg-opacity-60 p-4 rounded-lg border border-green-200">
                                <p class="text-sm text-gray-600 mb-1">Date de paiement:</p>
                                <p class="font-medium text-gray-800 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $reservation->payment_date ? \Carbon\Carbon::parse($reservation->payment_date)->format('d/m/Y à H:i') : 'N/A' }}
                                </p>
                            </div>
                            <div class="bg-white bg-opacity-60 p-4 rounded-lg border border-green-200">
                                <p class="text-sm text-gray-600 mb-1">Montant payé:</p>
                                <p class="font-medium text-gray-800 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ number_format($reservation->amount_paid ?? $reservation->total_price, 2) }} €
                                </p>
                            </div>
                            <div class="bg-white bg-opacity-60 p-4 rounded-lg border border-green-200">
                                <p class="text-sm text-gray-600 mb-1">Référence transaction:</p>
                                <p class="font-medium text-gray-800 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    {{ $reservation->transaction_id ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>
                
                @elseif(in_array($reservation->status, ['pending', 'payment_pending']))
                    <div class="bg-yellow-50 p-6 rounded-xl border border-yellow-100 shadow-sm">
                        <div class="flex items-center mb-5">
                            <div class="flex-shrink-0 bg-yellow-100 rounded-full p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-semibold text-yellow-800">Paiement en attente</h3>
                                <p class="text-yellow-600">Votre réservation nécessite un paiement pour être confirmée.</p>
                            </div>
                        </div>
                        
                        <div class="mt-5 flex justify-center">
                            <a href="{{ route('reservations.payment', $reservation) }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-md text-white bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                Procéder au paiement
                            </a>
                        </div>
                    </div>
                @endif
            </div>
            @endif
            
            <div class="p-8 flex flex-col sm:flex-row items-center justify-between">
                <div class="mb-4 sm:mb-0">
                    @if(in_array($reservation->status, ['pending', 'payment_pending']))
                        <form action="{{ route('reservations.cancel', $reservation) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation?');">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-5 py-2.5 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                Annuler la réservation
                            </button>
                        </form>
                    @elseif($reservation->status === 'confirmed' || $reservation->status === 'paid')
                        <a href="{{ route('reservations.invoice', $reservation) }}" class="inline-flex items-center px-5 py-2.5 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                            </svg>
                            Télécharger la facture
                        </a>
                    @endif
                </div>
                <a href="{{ route('reservations.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700 font-medium transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour à mes réservations
                </a>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')
@endsection

@section('scripts')
<script>
    function changeMainPhoto(src, thumbnail, index) {
        const mainPhoto = document.getElementById('main-vehicle-photo');
        mainPhoto.style.opacity = '0';
        
        setTimeout(() => {
            mainPhoto.src = src;
            mainPhoto.style.opacity = '1';
        }, 200);
        
        const thumbnails = document.querySelectorAll('.thumbnails img');
        thumbnails.forEach(thumb => {
            thumb.classList.remove('ring-2', 'ring-yellow-500');
            thumb.classList.add('opacity-70');
        });
        
        thumbnail.classList.remove('opacity-70');
        thumbnail.classList.add('ring-2', 'ring-yellow-500');
        
        const counterElement = document.getElementById('current-photo-index');
        if (counterElement && index) {
            counterElement.textContent = index;
        }
    }
</script>
@endsection
