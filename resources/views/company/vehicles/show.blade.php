@extends('layouts.company')

@section('title', "{$vehicle->brand} {$vehicle->model}")
@section('header', 'Détails du véhicule')

@section('content')
<div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm">
            <li class="inline-flex items-center">
                <a href="{{ route('company.dashboard') }}" class="inline-flex items-center font-medium text-gray-500 hover:text-indigo-600 transition-colors duration-200">
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
                    <a href="{{ route('company.vehicles.index') }}" class="ml-1 font-medium text-gray-500 hover:text-indigo-600 transition-colors duration-200">Véhicules</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="ml-1 font-medium text-indigo-600">{{ $vehicle->brand }} {{ $vehicle->model }}</span>
                </div>
            </li>
        </ol>
    </nav>
    <!-- Hero section with main info and actions -->
    <div class="relative mb-8 bg-gradient-to-r from-indigo-600/10 via-blue-500/10 to-purple-500/5 rounded-2xl p-6 shadow-md overflow-hidden">
        <!-- Background pattern -->
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" viewBox="0 0 800 800" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="50" height="50" patternUnits="userSpaceOnUse">
                        <path d="M 50 0 L 0 0 0 50" fill="none" stroke="currentColor" stroke-width="1"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>
        
        <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center mb-2">
                    <div class="h-10 w-10 rounded-lg bg-gradient-to-r from-indigo-600 to-blue-500 flex items-center justify-center text-white mr-3 shadow-lg">
                        <i class="fas fa-car"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</h2>
                </div>
                <div class="flex flex-wrap items-center gap-2 mt-2">
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm font-medium rounded-full flex items-center">
                        <i class="fas fa-calendar-alt mr-1.5 text-indigo-600"></i> {{ $vehicle->year }}
                    </span>
                    <span class="px-3 py-1 bg-gray-100 text-gray-800 text-sm font-medium rounded-full flex items-center">
                        <i class="fas fa-id-card mr-1.5 text-gray-600"></i> {{ $vehicle->license_plate }}
                    </span>
                    <span class="px-3 py-1 {{ $vehicle->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} text-sm font-medium rounded-full flex items-center">
                        <i class="fas {{ $vehicle->is_active ? 'fa-check-circle' : 'fa-times-circle' }} mr-1.5"></i> {{ $vehicle->is_active ? 'Actif' : 'Inactif' }}
                    </span>
                    <span class="px-3 py-1 {{ $vehicle->is_available ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }} text-sm font-medium rounded-full flex items-center">
                        <i class="fas {{ $vehicle->is_available ? 'fa-calendar-check' : 'fa-calendar-times' }} mr-1.5"></i> {{ $vehicle->is_available ? 'Disponible' : 'Indisponible' }}
                    </span>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 mt-4 md:mt-0">
                <a href="{{ route('company.vehicles.edit', $vehicle) }}" class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-blue-500 text-white text-sm font-semibold rounded-lg hover:from-indigo-700 hover:to-blue-600 transition-all duration-300 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center justify-center transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Modifier
                </a>
                <a href="{{ route('company.vehicles.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-300 flex items-center justify-center shadow-sm hover:shadow transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour
                </a>
            </div>
        </div>
    </div>
    
    <!-- Breadcrumb -->
   
    
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <div class="md:flex">
            <!-- Photo Gallery Section -->
            <div class="md:w-1/2 p-6 md:p-8 border-b md:border-b-0 md:border-r border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-images text-indigo-600 mr-2"></i>
                        Galerie photos
                    </h3>
                    <div class="flex gap-2">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $vehicle->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            <span class="flex h-2 w-2 rounded-full {{ $vehicle->is_active ? 'bg-green-500' : 'bg-red-500' }} mr-1.5 mt-1"></span>
                            {{ $vehicle->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $vehicle->is_available ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                            <span class="flex h-2 w-2 rounded-full {{ $vehicle->is_available ? 'bg-blue-500' : 'bg-yellow-500' }} mr-1.5 mt-1"></span>
                            {{ $vehicle->is_available ? 'Disponible' : 'Indisponible' }}
                        </span>
                    </div>
                </div>
                
                @if($vehicle->photos->count() > 0)
                    <div class="relative mb-6 overflow-hidden rounded-xl group">
                        <img id="main-photo" src="{{ asset('storage/' . $vehicle->photos->where('is_primary', true)->first()->path ?? $vehicle->photos->first()->path) }}" 
                             alt="{{ $vehicle->brand }} {{ $vehicle->model }}" 
                             class="w-full h-96 object-cover rounded-xl shadow-md transition-all duration-500 ease-in-out group-hover:shadow-lg">
                        
                        <!-- Overlay and controls -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></div>
                        
                        <div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-sm rounded-lg px-3 py-1.5 text-sm font-medium text-gray-800 shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            {{ $vehicle->photos->count() }} photo{{ $vehicle->photos->count() > 1 ? 's' : '' }}
                        </div>
                        
                        <!-- Navigation arrows if more than one photo -->
                        @if($vehicle->photos->count() > 1)
                        <div class="absolute inset-y-0 left-0 flex items-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <button type="button" id="prev-photo" class="bg-white/80 text-gray-800 hover:bg-indigo-100 hover:text-indigo-600 rounded-full p-2 m-4 shadow-lg transition-all duration-300 transform hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                        </div>
                        <div class="absolute inset-y-0 right-0 flex items-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <button type="button" id="next-photo" class="bg-white/80 text-gray-800 hover:bg-indigo-100 hover:text-indigo-600 rounded-full p-2 m-4 shadow-lg transition-all duration-300 transform hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                        @endif
                    </div>
                    
                    @if($vehicle->photos->count() > 1)
                        <div class="grid grid-cols-5 gap-3">
                            @foreach($vehicle->photos as $index => $photo)
                                <button type="button" 
                                        class="thumbnail-btn cursor-pointer transform hover:scale-105 transition-all duration-300 focus:outline-none" 
                                        data-index="{{ $index }}"
                                        onclick="changeMainPhoto('{{ asset('storage/' . $photo->path) }}', this)">
                                    <img src="{{ asset('storage/' . $photo->path) }}" 
                                         alt="{{ $vehicle->brand }} {{ $vehicle->model }}" 
                                         class="h-20 w-full object-cover rounded-lg shadow-sm hover:shadow-md {{ $photo->is_primary ? 'ring-2 ring-indigo-500' : 'opacity-80 hover:opacity-100' }}">
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
                        <a href="{{ route('company.vehicles.edit', $vehicle) }}" class="mt-4 px-4 py-2 text-xs font-medium text-indigo-600 bg-indigo-50 rounded-md hover:bg-indigo-100 transition-colors duration-300 flex items-center">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Ajouter des photos
                        </a>
                    </div>
                @endif
                
                <!-- Moved Reservation Statistics below photos -->
                <div class="mt-8">
                    <h4 class="text-sm font-medium text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-calendar-check text-indigo-600 mr-2"></i>
                        Statistiques de réservation
                    </h4>
                    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300">
                        @if($vehicle->reservations && $vehicle->reservations->count() > 0)
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-gray-700 font-medium">Total des réservations</span>
                                <span class="text-2xl font-bold text-indigo-600">{{ $vehicle->reservations->count() }}</span>
                            </div>
                            
                            <!-- Graphique des réservations par mois avec données réelles -->
                            <div class="mt-4">
                                <h5 class="text-xs text-gray-500 uppercase mb-2">Réservations des derniers mois</h5>
                                <div class="h-16 flex items-end space-x-2">
                                    @php
                                        $months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
                                        $currentMonth = date('n') - 1; // 0-based index for current month
                                        
                                        // Last 6 months
                                        $chartData = [];
                                        $maxCount = 1; // Prevent division by zero
                                        
                                        for ($i = 5; $i >= 0; $i--) {
                                            $monthIndex = ($currentMonth - $i + 12) % 12;
                                            $monthName = $months[$monthIndex];
                                            
                                            // Get year and month for query
                                            $year = date('Y');
                                            $month = $monthIndex + 1;
                                            if ($monthIndex > $currentMonth) {
                                                $year--; // Previous year
                                            }
                                            
                                            // Count reservations for this month
                                            $count = $vehicle->reservations()
                                                ->whereYear('created_at', $year)
                                                ->whereMonth('created_at', $month)
                                                ->count();
                                            
                                            $chartData[] = ['month' => $monthName, 'count' => $count];
                                            $maxCount = max($maxCount, $count);
                                        }
                                    @endphp
                                    
                                    @foreach($chartData as $data)
                                        <div class="flex flex-col items-center flex-1">
                                            <div class="w-full bg-gradient-to-b from-blue-50 to-indigo-50 rounded-t-sm" style="height: {{ $maxCount > 0 ? (($data['count'] / $maxCount) * 100) : 0 }}%;max-height:100%;min-height:10%;">
                                                <div class="bg-gradient-to-t from-indigo-600 to-blue-500 w-full h-full rounded-t-sm relative group transition-all duration-300 hover:from-indigo-700 hover:to-blue-600 hover:shadow-md">
                                                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-indigo-600 to-blue-500 text-white text-xs py-1 px-2 rounded shadow-md opacity-0 group-hover:opacity-100 transition-all duration-200 mb-1 whitespace-nowrap">
                                                        {{ $data['count'] }} réservation{{ $data['count'] != 1 ? 's' : '' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <span class="text-xs text-gray-600 font-medium mt-1.5">{{ $data['month'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <!-- Latest Reservations Summary -->
                            @if($vehicle->reservations->count() > 0)
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <h5 class="text-xs text-gray-500 uppercase mb-2">Dernière réservation</h5>
                                    @php
                                        $latestReservation = $vehicle->reservations()->latest()->first();
                                    @endphp
                                    @if($latestReservation)
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="flex items-center text-gray-600">
                                                <i class="fas fa-calendar-day text-indigo-400 mr-2"></i>
                                                {{ $latestReservation->start_date->format('d/m/Y') }} - {{ $latestReservation->end_date->format('d/m/Y') }}
                                            </span>
                                            <span class="text-indigo-600 font-medium">
                                                {{ $latestReservation->total_price }} €
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            @endif
                            
                        @else
                            <div class="flex flex-col items-center justify-center py-6">
                                <div class="h-16 w-16 bg-indigo-50 rounded-full flex items-center justify-center mb-3">
                                    <i class="fas fa-calendar-day text-indigo-400 text-xl"></i>
                                </div>
                                <p class="text-gray-400 font-medium">Aucune réservation</p>
                                <p class="text-center text-gray-500 text-sm mt-1">Ce véhicule n'a pas encore été réservé</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Vehicle Information Section -->
            <div class="md:w-1/2 p-6 md:p-8 bg-gradient-to-br from-gray-50 to-white">
                <div class="flex flex-col sm:flex-row justify-between gap-4 mb-6 pb-6 border-b border-gray-200">
                    <div>
                        <span class="text-xs font-medium text-indigo-600 uppercase tracking-wider">Information véhicule</span>
                        <h3 class="text-xl font-bold text-gray-900 mt-1">{{ $vehicle->brand }} {{ $vehicle->model }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Année {{ $vehicle->year }} · Immatriculation: {{ $vehicle->license_plate }}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tarif journalier</span>
                        <p class="text-2xl font-bold text-indigo-600 mt-1">{{ number_format($vehicle->price_per_day, 2) }} €<span class="text-sm font-normal text-gray-500">/jour</span></p>
                        <p class="text-xs text-gray-500 mt-1 flex items-center justify-end gap-1">
                            <i class="fas fa-chart-line text-indigo-400"></i>
                            {{ $vehicle->reservations->count() }} réservation{{ $vehicle->reservations->count() !== 1 ? 's' : '' }} au total
                        </p>
                    </div>
                </div>
                
                <!-- Key specifications -->
                <div class="mb-8">
                    <h4 class="text-sm font-medium text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-clipboard-list text-indigo-600 mr-2"></i>
                        Spécifications techniques
                    </h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-indigo-100 transition-all duration-300 transform hover:-translate-y-1">
                            <div class="bg-gradient-to-br from-indigo-50 to-blue-50 p-2 rounded-lg mr-3 mb-3 inline-flex">
                                <i class="fas fa-cog text-indigo-600"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase mb-1">Transmission</h4>
                                <p class="font-medium text-gray-800">{{ $vehicle->transmission === 'automatic' ? 'Automatique' : 'Manuelle' }}</p>
                            </div>
                        </div>
                        
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-indigo-100 transition-all duration-300 transform hover:-translate-y-1">
                            <div class="bg-gradient-to-br from-indigo-50 to-blue-50 p-2 rounded-lg mr-3 mb-3 inline-flex">
                                <i class="fas fa-gas-pump text-indigo-600"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase mb-1">Type de carburant</h4>
                                <p class="font-medium text-gray-800">
                                    @if($vehicle->fuel_type == 'gasoline')
                                        Essence
                                    @elseif($vehicle->fuel_type == 'diesel')
                                        Diesel
                                    @elseif($vehicle->fuel_type == 'electric')
                                        Électrique
                                    @elseif($vehicle->fuel_type == 'hybrid')
                                        Hybride
                                    @else
                                        {{ ucfirst($vehicle->fuel_type) }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-indigo-100 transition-all duration-300 transform hover:-translate-y-1">
                            <div class="bg-gradient-to-br from-indigo-50 to-blue-50 p-2 rounded-lg mr-3 mb-3 inline-flex">
                                <i class="fas fa-users text-indigo-600"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase mb-1">Nombre de places</h4>
                                <p class="font-medium text-gray-800">{{ $vehicle->seats }} places</p>
                            </div>
                        </div>
                        
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-indigo-100 transition-all duration-300 transform hover:-translate-y-1">
                            <div class="bg-gradient-to-br from-indigo-50 to-blue-50 p-2 rounded-lg mr-3 mb-3 inline-flex">
                                <i class="fas fa-calendar-day text-indigo-600"></i>
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
                            <i class="fas fa-star text-indigo-600 mr-2"></i>
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
                                    'air_conditioning' => 'fa-snowflake',
                                    'gps' => 'fa-map-marker-alt',
                                    'bluetooth' => 'fa-bluetooth-b',
                                    'usb' => 'fa-usb',
                                    'heated_seats' => 'fa-fire',
                                    'sunroof' => 'fa-sun',
                                    'cruise_control' => 'fa-tachometer-alt',
                                    'parking_sensors' => 'fa-parking',
                                    'backup_camera' => 'fa-camera',
                                    'child_seats' => 'fa-baby',
                                    'wifi' => 'fa-wifi',
                                    'leather_seats' => 'fa-couch',
                                    'default' => 'fa-check'
                                ];
                            @endphp
                            
                            @foreach($vehicle->features as $feature)
                                <div class="flex items-center bg-white px-4 py-3 rounded-lg border border-gray-100 shadow-sm hover:shadow-md hover:border-indigo-200 transition-all duration-300 transform hover:-translate-y-1">
                                    <div class="mr-3 text-indigo-600">
                                        <i class="fas {{ $featureIcons[$feature] ?? $featureIcons['default'] }}"></i>
                                    </div>
                                    <span class="text-sm text-gray-700">{{ $featuresLabels[$feature] ?? $feature }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <div class="mb-8">
                    <h4 class="text-sm font-medium text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-align-left text-indigo-600 mr-2"></i>
                        Description
                    </h4>
                    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300">
                        @if($vehicle->description)
                            <p class="text-gray-700 leading-relaxed">{{ $vehicle->description }}</p>
                        @else
                            <div class="flex flex-col items-center justify-center py-6">
                                <p class="text-gray-400 font-medium mb-2">Aucune description disponible</p>
                                <p class="text-center text-gray-500 text-sm">Ajoutez une description pour donner plus d'informations aux clients potentiels</p>
                                <a href="{{ route('company.vehicles.edit', $vehicle) }}" class="mt-4 px-4 py-2 text-xs font-medium text-indigo-600 bg-indigo-50 rounded-md hover:bg-indigo-100 transition-colors duration-300 flex items-center">
                                    <i class="fas fa-plus-circle mr-2"></i>
                                    Ajouter une description
                                </a>
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
            <i class="fas fa-history mr-2 text-indigo-400"></i>
            Dernière mise à jour: {{ $vehicle->updated_at->diffForHumans() }}
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('company.vehicles.index') }}" class="order-2 sm:order-1 px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-300 flex items-center justify-center shadow-sm hover:shadow transform hover:scale-105">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour aux véhicules
            </a>
            <a href="{{ route('company.vehicles.edit', $vehicle) }}" class="order-1 sm:order-2 px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-blue-500 text-white text-sm font-semibold rounded-lg hover:from-indigo-700 hover:to-blue-600 transition-colors duration-300 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center justify-center transform hover:scale-105">
                <i class="fas fa-edit mr-2"></i>
                Modifier le véhicule
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mainPhoto = document.getElementById('main-photo');
        const thumbnails = document.querySelectorAll('.thumbnail-btn');
        let currentIndex = 0;
        const photoUrls = [];
        
        // Collect all photo URLs
        thumbnails.forEach(thumb => {
            const imgSrc = thumb.querySelector('img').src;
            photoUrls.push(imgSrc);
        });
        
        // Handle next/prev buttons
        const prevBtn = document.getElementById('prev-photo');
        const nextBtn = document.getElementById('next-photo');
        
        if (prevBtn && nextBtn) {
            prevBtn.addEventListener('click', function() {
                currentIndex = (currentIndex - 1 + photoUrls.length) % photoUrls.length;
                changeMainPhoto(photoUrls[currentIndex], thumbnails[currentIndex]);
            });
            
            nextBtn.addEventListener('click', function() {
                currentIndex = (currentIndex + 1) % photoUrls.length;
                changeMainPhoto(photoUrls[currentIndex], thumbnails[currentIndex]);
            });
        }
        
        // Set initial index
        thumbnails.forEach((thumb, index) => {
            if (thumb.querySelector('img').classList.contains('ring-indigo-500')) {
                currentIndex = index;
            }
            thumb.setAttribute('data-index', index);
        });
    });

    function changeMainPhoto(photoUrl, thumbElement) {
        const mainPhoto = document.getElementById('main-photo');
        const thumbnails = document.querySelectorAll('.thumbnail-btn img');
        const mainContainer = mainPhoto.parentElement;
        
        // Add fade effect
        mainPhoto.classList.add('opacity-0');
        
        // Update current index if thumbElement is provided
        if (thumbElement) {
            currentIndex = parseInt(thumbElement.getAttribute('data-index') || 0);
            
            // Remove highlight from all thumbnails
            thumbnails.forEach(thumb => {
                thumb.classList.remove('ring-2', 'ring-indigo-500');
                thumb.classList.add('opacity-80');
            });
            
            // Add highlight to selected thumbnail
            const selectedThumb = thumbElement.querySelector('img');
            if (selectedThumb) {
                selectedThumb.classList.add('ring-2', 'ring-indigo-500');
                selectedThumb.classList.remove('opacity-80');
            }
        }
        
        // Slight delay for transition
        setTimeout(() => {
            mainPhoto.src = photoUrl;
            
            // Add a temporary loading animation
            mainContainer.classList.add('pulse-bg');
            
            // When image is loaded, remove animation and restore opacity
            mainPhoto.onload = function() {
                mainPhoto.classList.remove('opacity-0');
                mainContainer.classList.remove('pulse-bg');
            };
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
    
    .pulse-bg {
        animation: pulse 1.5s infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            background-color: rgba(79, 70, 229, 0.05);
        }
        50% {
            background-color: rgba(79, 70, 229, 0.1);
        }
    }
    
    /* Smooth hover transitions */
    a, button {
        transition: all 0.3s ease;
    }
    
    /* Custom scrollbar for better UX */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #c7d2fe;
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #818cf8;
    }
</style>
@endsection