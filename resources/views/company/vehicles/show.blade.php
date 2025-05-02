@extends('layouts.company')

@section('title', "{$vehicle->brand} {$vehicle->model}")
@section('header', 'Détails du véhicule')

@section('content')
<div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Hero section with main info and actions -->
    <div class="mb-6 bg-gradient-to-r from-primary-600/10 to-primary-500/5 rounded-2xl p-6 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</h2>
                <p class="text-gray-600 mt-1 text-lg">{{ $vehicle->year }} · {{ $vehicle->license_plate }}</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 mt-4 md:mt-0">
                <a href="{{ route('company.vehicles.edit', $vehicle) }}" class="px-5 py-2.5 bg-blue-500 text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition-all duration-300 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Modifier
                </a>
                <a href="{{ route('company.vehicles.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-300 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour
                </a>
            </div>
        </div>
    </div>
    
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm">
            <li class="inline-flex items-center">
                <a href="{{ route('company.dashboard') }}" class="inline-flex items-center font-medium text-gray-500 hover:text-primary-600 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Tableau de bord
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <a href="{{ route('company.vehicles.index') }}" class="ml-1 font-medium text-gray-500 hover:text-primary-600 transition-colors duration-200">Véhicules</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="ml-1 font-medium text-primary-600">{{ $vehicle->brand }} {{ $vehicle->model }}</span>
                </div>
            </li>
        </ol>
    </nav>
    
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <div class="md:flex">
            <!-- Photo Gallery Section -->
            <div class="md:w-1/2 p-6 md:p-8 border-b md:border-b-0 md:border-r border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Galerie photos</h3>
                    <div class="flex items-center">
                        <div class="flex items-center mr-4">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $vehicle->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $vehicle->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </div>
                        <div class="flex items-center">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $vehicle->is_available ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $vehicle->is_available ? 'Disponible' : 'Indisponible' }}
                            </span>
                        </div>
                    </div>
                </div>
                
                @if($vehicle->photos->count() > 0)
                    <div class="relative mb-6 overflow-hidden group">
                        <img id="main-photo" src="{{ asset('storage/' . $vehicle->photos->where('is_primary', true)->first()->path ?? $vehicle->photos->first()->path) }}" 
                             alt="{{ $vehicle->brand }} {{ $vehicle->model }}" 
                             class="w-full h-96 object-cover rounded-xl shadow-md transition-all duration-500 ease-in-out group-hover:shadow-lg">
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <div class="absolute bottom-4 right-4 bg-white/80 backdrop-blur-sm rounded-lg px-3 py-1.5 text-sm font-medium text-gray-800 shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            {{ $vehicle->photos->count() }} photo{{ $vehicle->photos->count() > 1 ? 's' : '' }}
                        </div>
                    </div>
                    
                    @if($vehicle->photos->count() > 1)
                        <div class="grid grid-cols-5 gap-3">
                            @foreach($vehicle->photos as $photo)
                                <button type="button" 
                                        class="cursor-pointer transform hover:scale-105 transition-all duration-300 focus:outline-none" 
                                        onclick="changeMainPhoto('{{ asset('storage/' . $photo->path) }}')">
                                    <img src="{{ asset('storage/' . $photo->path) }}" 
                                         alt="{{ $vehicle->brand }} {{ $vehicle->model }}" 
                                         class="h-20 w-full object-cover rounded-lg shadow-sm hover:shadow-md {{ $photo->is_primary ? 'ring-2 ring-primary-500' : 'opacity-80 hover:opacity-100' }}">
                                </button>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="flex flex-col items-center justify-center h-96 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-gray-400 font-medium mb-2">Aucune photo disponible</p>
                        <p class="text-center text-gray-500 text-sm max-w-xs">Ajoutez des photos pour améliorer la visibilité de ce véhicule</p>
                        <a href="{{ route('company.vehicles.edit', $vehicle) }}" class="mt-4 px-4 py-2 text-xs font-medium text-primary-600 bg-primary-50 rounded-md hover:bg-primary-100 transition-colors duration-300">
                            Ajouter des photos
                        </a>
                    </div>
                @endif
            </div>
            
            <!-- Vehicle Information Section -->
            <div class="md:w-1/2 p-6 md:p-8 bg-gray-50">
                <div class="flex flex-col sm:flex-row justify-between gap-4 mb-6 pb-6 border-b border-gray-200">
                    <div>
                        <span class="text-xs font-medium text-primary-600 uppercase tracking-wider">Information véhicule</span>
                        <h3 class="text-xl font-bold text-gray-900 mt-1">{{ $vehicle->brand }} {{ $vehicle->model }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Année {{ $vehicle->year }} · Immatriculation: {{ $vehicle->license_plate }}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tarif journalier</span>
                        <p class="text-2xl font-bold text-primary-600 mt-1">{{ number_format($vehicle->price_per_day, 2) }} €<span class="text-sm font-normal text-gray-500">/jour</span></p>
                        <p class="text-xs text-gray-500 mt-1">{{ $vehicle->reservations->count() }} réservation{{ $vehicle->reservations->count() !== 1 ? 's' : '' }} au total</p>
                    </div>
                </div>
                
                <!-- Key specifications -->
                <div class="mb-8">
                    <h4 class="text-sm font-medium text-gray-800 mb-4">Spécifications techniques</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center">
                            <div class="bg-primary-50 p-2 rounded-lg mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase mb-1">Transmission</h4>
                                <p class="font-medium text-gray-800">{{ ucfirst($vehicle->transmission) }}</p>
                            </div>
                        </div>
                        
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center">
                            <div class="bg-primary-50 p-2 rounded-lg mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase mb-1">Type de carburant</h4>
                                <p class="font-medium text-gray-800">{{ ucfirst($vehicle->fuel_type) }}</p>
                            </div>
                        </div>
                        
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center">
                            <div class="bg-primary-50 p-2 rounded-lg mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase mb-1">Nombre de places</h4>
                                <p class="font-medium text-gray-800">{{ $vehicle->seats }}</p>
                            </div>
                        </div>
                        
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center">
                            <div class="bg-primary-50 p-2 rounded-lg mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase mb-1">Date d'ajout</h4>
                                <p class="font-medium text-gray-800">{{ $vehicle->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($vehicle->features && count($vehicle->features) > 0)
                    <div class="mb-8">
                        <h4 class="text-sm font-medium text-gray-800 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                            Caractéristiques
                        </h4>
                        <div class="grid grid-cols-2 gap-3">
                            @php
                                $featuresLabels = [
                                    'air_conditioning' => 'Climatisation',
                                    'gps' => 'GPS Navigation',
                                    'bluetooth' => 'Bluetooth',
                                    'usb' => 'Port USB',
                                    'heated_seats' => 'Sièges chauffants',
                                    'sunroof' => 'Toit ouvrant',
                                    'cruise_control' => 'Régulateur de vitesse',
                                    'parking_sensors' => 'Capteurs de stationnement',
                                    'backup_camera' => 'Caméra de recul',
                                    'child_seats' => 'Sièges enfant',
                                    'wifi' => 'Wi-Fi',
                                    'leather_seats' => 'Sièges en cuir'
                                ];
                                
                                $featureIcons = [
                                    'air_conditioning' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>',
                                    'gps' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" /></svg>',
                                    'bluetooth' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>',
                                    'default' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>'
                                ];
                            @endphp
                            
                            @foreach($vehicle->features as $feature)
                                <div class="flex items-center bg-white px-4 py-3 rounded-lg border border-gray-100 shadow-sm">
                                    <div class="mr-3 text-primary-600">
                                        @if(isset($featureIcons[$feature]))
                                            {!! $featureIcons[$feature] !!}
                                        @else
                                            {!! $featureIcons['default'] !!}
                                        @endif
                                    </div>
                                    <span class="text-sm text-gray-700">{{ $featuresLabels[$feature] ?? $feature }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <div class="mb-8">
                    <h4 class="text-sm font-medium text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Description
                    </h4>
                    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                        @if($vehicle->description)
                            <p class="text-gray-700 leading-relaxed">{{ $vehicle->description }}</p>
                        @else
                            <div class="flex flex-col items-center justify-center py-6">
                                <p class="text-gray-400 font-medium mb-2">Aucune description disponible</p>
                                <p class="text-center text-gray-500 text-sm">Ajoutez une description pour donner plus d'informations aux clients potentiels</p>
                                <a href="{{ route('company.vehicles.edit', $vehicle) }}" class="mt-4 px-4 py-2 text-xs font-medium text-primary-600 bg-primary-50 rounded-md hover:bg-primary-100 transition-colors duration-300">
                                    Ajouter une description
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-medium text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Emplacement
                    </h4>
                    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                        @if($vehicle->location)
                            <p class="text-gray-700">{{ $vehicle->location }}</p>
                        @else
                            <div class="flex flex-col items-center justify-center py-6">
                                <p class="text-gray-400 font-medium">Aucun emplacement spécifié</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Additional actions -->
    <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-between items-center">
        <div class="flex items-center text-gray-500 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Dernière mise à jour: {{ $vehicle->updated_at->diffForHumans() }}
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('company.vehicles.index') }}" class="order-2 sm:order-1 px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-300 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour aux véhicules
            </a>
            <a href="{{ route('company.vehicles.edit', $vehicle) }}" class="order-1 sm:order-2 px-5 py-2.5 bg-blue-500 text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition-colors duration-300 shadow-sm hover:shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Modifier le véhicule
            </a>
        </div>
    </div>
</div>

<script>
    function changeMainPhoto(photoUrl) {
        const mainPhoto = document.getElementById('main-photo');
        mainPhoto.classList.add('opacity-0');
        
        setTimeout(() => {
            mainPhoto.src = photoUrl;
            mainPhoto.classList.remove('opacity-0');
        }, 300);
    }
</script>

<style>
    #main-photo {
        transition: all 0.4s ease-in-out;
    }
    
    .opacity-0 {
        opacity: 0;
    }
</style>
@endsection