@extends('layouts.company')

@section('title', "{$vehicle->brand} {$vehicle->model}")
@section('header', 'Vehicle Details')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-2xl font-bold text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }} <span class="text-gray-500">({{ $vehicle->year }})</span></h2>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('company.vehicles.edit', $vehicle) }}" class="px-5 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors duration-300 shadow-sm hover:shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 flex items-center justify-center">
                    Modifier le véhicule
                </a>
                <a href="{{ route('company.vehicles.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-300 flex items-center justify-center">
                    Retour aux véhicules
                </a>
            </div>
        </div>
    </div>
    
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('company.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-primary-600 transition-colors duration-200">
                    Tableau de bord
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <span class="mx-2 text-gray-400">/</span>
                    <a href="{{ route('company.vehicles.index') }}" class="text-sm font-medium text-gray-500 hover:text-primary-600 transition-colors duration-200">Véhicules</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <span class="mx-2 text-gray-400">/</span>
                    <span class="text-sm font-medium text-primary-600">Voir les details</span>
                </div>
            </li>
        </ol>
    </nav>
    
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-100">
        <div class="md:flex">
            <!-- Photo Gallery Section -->
            <div class="md:w-1/2 p-6 md:p-8">
                @if($vehicle->photos->count() > 0)
                    <div class="mb-6">
                        <img id="main-photo" src="{{ asset('storage/' . $vehicle->photos->where('is_primary', true)->first()->path ?? $vehicle->photos->first()->path) }}" 
                             alt="{{ $vehicle->brand }} {{ $vehicle->model }}" 
                             class="w-full h-80 object-cover rounded-xl shadow-md transition-all duration-300">
                    </div>
                    
                    @if($vehicle->photos->count() > 1)
                        <div class="grid grid-cols-5 gap-3">
                            @foreach($vehicle->photos as $photo)
                                <div class="cursor-pointer transform hover:scale-105 transition-transform duration-300" onclick="changeMainPhoto('{{ asset('storage/' . $photo->path) }}')">
                                    <img src="{{ asset('storage/' . $photo->path) }}" 
                                         alt="{{ $vehicle->brand }} {{ $vehicle->model }}" 
                                         class="h-20 w-full object-cover rounded-lg shadow-sm hover:shadow {{ $photo->is_primary ? 'ring-2 ring-primary-500' : 'opacity-80 hover:opacity-100' }}">
                                </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="flex items-center justify-center h-80 bg-gray-100 rounded-xl">
                        <p class="text-gray-400 font-medium">Aucune photo disponible</p>
                    </div>
                    <p class="text-center text-gray-500 mt-4 text-sm">Ajoutez des photos pour améliorer la visibilité de ce véhicule</p>
                @endif
            </div>
            
            <!-- Vehicle Information Section -->
            <div class="md:w-1/2 p-6 md:p-8 bg-gray-50 border-t md:border-t-0 md:border-l border-gray-100">
                <div class="flex flex-col sm:flex-row justify-between gap-4 mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</h3>
                        <p class="text-sm text-gray-500 mt-1">{{ $vehicle->year }} · Immatriculation: {{ $vehicle->license_plate }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-primary-600">{{ number_format($vehicle->price_per_day, 2) }} €<span class="text-sm font-normal text-gray-500">/jour</span></p>
                        <div class="flex mt-2 justify-end">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $vehicle->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} mr-2">
                                {{ $vehicle->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $vehicle->is_available ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $vehicle->is_available ? 'Disponible' : 'Indisponible' }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-6 mb-8">
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                        <h4 class="text-xs font-medium text-gray-500 uppercase mb-1">Transmission</h4>
                        <p class="font-medium text-gray-800">{{ ucfirst($vehicle->transmission) }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                        <h4 class="text-xs font-medium text-gray-500 uppercase mb-1">Type de carburant</h4>
                        <p class="font-medium text-gray-800">{{ ucfirst($vehicle->fuel_type) }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                        <h4 class="text-xs font-medium text-gray-500 uppercase mb-1">Nombre de places</h4>
                        <p class="font-medium text-gray-800">{{ $vehicle->seats }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                        <h4 class="text-xs font-medium text-gray-500 uppercase mb-1">Réservations totales</h4>
                        <p class="font-medium text-gray-800">{{ $vehicle->reservations->count() ?? 0 }}</p>
                    </div>
                </div>
                
                @if($vehicle->features && count($vehicle->features) > 0)
                    <div class="mb-8">
                        <h4 class="text-sm font-medium text-gray-700 mb-3 pb-2 border-b border-gray-200">Caractéristiques</h4>
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
                            @endphp
                            
                            @foreach($vehicle->features as $feature)
                                <div class="flex items-center bg-white px-3 py-2 rounded-lg border border-gray-100">
                                    <span class="w-2 h-2 bg-primary-500 rounded-full mr-2"></span>
                                    <span class="text-sm text-gray-700">{{ $featuresLabels[$feature] ?? $feature }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <div class="mb-8">
                    <h4 class="text-sm font-medium text-gray-700 mb-3 pb-2 border-b border-gray-200">Description</h4>
                    <div class="bg-white p-4 rounded-xl border border-gray-100">
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $vehicle->description ?? 'Aucune description disponible' }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-3 pb-2 border-b border-gray-200">Emplacement</h4>
                        <div class="bg-white p-4 rounded-xl border border-gray-100">
                            <p class="text-sm text-gray-700">{{ $vehicle->location }}</p>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-3 pb-2 border-b border-gray-200">Date d'ajout</h4>
                        <div class="bg-white p-4 rounded-xl border border-gray-100">
                            <p class="text-sm text-gray-700">{{ $vehicle->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Additional actions -->
    <div class="mt-8 flex flex-col sm:flex-row justify-end gap-3">
        <a href="{{ route('company.vehicles.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-300 flex items-center justify-center">
            Retour aux véhicules
        </a>
        <a href="{{ route('company.vehicles.edit', $vehicle) }}" class="px-5 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors duration-300 shadow-sm hover:shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 flex items-center justify-center">
            Modifier le véhicule
        </a>
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
        transition: opacity 0.3s ease-in-out;
    }
    
    .opacity-0 {
        opacity: 0;
    }
</style>
@endsection

