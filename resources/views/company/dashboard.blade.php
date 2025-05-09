@extends('layouts.company')

@section('title', 'Tableau de Bord')
@section('header', 'Tableau de Bord de l\'Entreprise')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Active Vehicles Card -->
    <div class="bg-white rounded-lg shadow p-6 flex justify-between items-center">
        <div>
            <p class="text-sm font-medium text-gray-500">Véhicules Actifs</p>
            <p class="text-3xl font-bold text-gray-800">{{ $company->vehicles->where('is_active', true)->count() ?? 0 }}</p>
        </div>
        <div class="bg-blue-100 p-3 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
        </div>
    </div>
    
    <!-- Pending Reservations Card -->
    <div class="bg-white rounded-lg shadow p-6 flex justify-between items-center">
        <div>
            <p class="text-sm font-medium text-gray-500">Réservations en Attente</p>
            <p class="text-3xl font-bold text-gray-800">{{ $company->reservations->where('status', 'pending')->count() ?? 0 }}</p>
        </div>
        <div class="bg-yellow-100 p-3 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>
    
    <!-- Active Promotions Card -->
    <div class="bg-white rounded-lg shadow p-6 flex justify-between items-center">
        <div>
            <p class="text-sm font-medium text-gray-500">Promotions Actives</p>
            <p class="text-3xl font-bold text-gray-800">{{ $company->promotions->where('is_active', true)->count() ?? 0 }}</p>
        </div>
        <div class="bg-green-100 p-3 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>
    
    <!-- Total Revenue Card -->
    <div class="bg-white rounded-lg shadow p-6 flex justify-between items-center">
        <div>
            <p class="text-sm font-medium text-gray-500">Revenu Total</p>
            <p class="text-3xl font-bold text-gray-800">{{ number_format($company->reservations->whereIn('status', ['confirmed','paid','completed'])->sum('total_price'), 2) }} €</p>
        </div>
        <div class="bg-purple-100 p-3 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Recent Reservations -->
    <div class="bg-white rounded-lg shadow col-span-2">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h2 class="font-medium text-gray-700">Réservations Récentes</h2>
            <a href="{{ route('company.reservations.index') }}" class="text-xs text-indigo-600 hover:text-indigo-900 font-medium">Voir tout</a>
        </div>
        <div class="p-6">
            @if($company->reservations && $company->reservations->count() > 0)
                <div class="overflow-x-auto">
                    <div class="space-y-3">
                        @foreach($company->reservations->sortByDesc('created_at')->take(5) as $reservation)
                            <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition duration-150">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            @if($reservation->vehicle->photos->count() > 0)
                                                <img class="h-12 w-12 rounded-md object-cover" src="{{ asset('storage/' . $reservation->vehicle->photos->first()->path) }}" alt="{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}">
                                            @else
                                                <div class="h-12 w-12 rounded-md bg-gray-200 flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}</p>
                                            <div class="flex items-center text-xs text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                {{ $reservation->user->name }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center space-x-3">
                                        <div class="text-right">
                                            <div class="flex items-center text-xs text-gray-500 mb-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                {{ $reservation->start_date->format('d/m/Y') }} - {{ $reservation->end_date->format('d/m/Y') }}
                                            </div>
                                            
                                            @if($reservation->status == 'pending')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    En attente
                                                </span>
                                            @elseif($reservation->status == 'confirmed')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Confirmée
                                                </span>
                                            @elseif($reservation->status == 'canceled')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Annulée
                                                </span>
                                            @elseif($reservation->status == 'completed')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    Terminée
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <a href="{{ route('company.reservations.show', $reservation->id) }}" class="text-indigo-600 hover:text-indigo-900 p-1 rounded-full hover:bg-indigo-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="mt-6 flex justify-center">
                    <a href="{{ route('company.reservations.index') }}" class="inline-flex items-center px-4 py-2 border border-indigo-300 bg-white text-sm font-medium rounded-md text-indigo-700 hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Voir toutes les réservations
                    </a>
                </div>
            @else
                <div class="text-center py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="mt-2 text-gray-500">Aucune réservation trouvée.</p>
                    <button class="mt-4 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Ajouter votre premier véhicule
                    </button>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Nouvelles statistiques modernes -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h2 class="font-medium text-gray-700">Répartition des Réservations</h2>
        </div>
        <div class="p-6">
            @php
                $confirmed = $company->reservations->where('status', 'confirmed')->count();
                $pending = $company->reservations->where('status', 'pending')->count();
                $completed = $company->reservations->where('status', 'completed')->count();
                $canceled = $company->reservations->where('status', 'canceled')->count();
                $total = max(1, $confirmed + $pending + $completed + $canceled); // éviter division par zéro
                
                $confirmedPercent = round(($confirmed / $total) * 100);
                $pendingPercent = round(($pending / $total) * 100);
                $completedPercent = round(($completed / $total) * 100);
                $canceledPercent = round(($canceled / $total) * 100);
            @endphp
            
            <div class="space-y-4">
                <!-- Graphique en barres pour la répartition des statuts -->
                <div class="w-full h-8 bg-gray-200 rounded-full overflow-hidden">
                    <div class="flex h-full">
                        <div class="bg-green-500 h-full" style="width: {{ $confirmedPercent }}%"></div>
                        <div class="bg-yellow-500 h-full" style="width: {{ $pendingPercent }}%"></div>
                        <div class="bg-blue-500 h-full" style="width: {{ $completedPercent }}%"></div>
                        <div class="bg-red-500 h-full" style="width: {{ $canceledPercent }}%"></div>
                    </div>
                </div>
                
                <!-- Légende -->
                <div class="grid grid-cols-2 gap-2">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                        <span class="text-xs text-gray-600">Confirmées ({{ $confirmed }})</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                        <span class="text-xs text-gray-600">En attente ({{ $pending }})</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                        <span class="text-xs text-gray-600">Terminées ({{ $completed }})</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                        <span class="text-xs text-gray-600">Annulées ({{ $canceled }})</span>
                    </div>
                </div>
            </div>
            
            <!-- Taux d'occupation des véhicules -->
            <div class="mt-8">
                <h3 class="text-sm font-medium text-gray-700 mb-3">Taux d'occupation des véhicules</h3>
                @php
                    $totalVehicles = $company->vehicles->count();
                    $activeVehicles = $company->vehicles->where('is_active', true)->count();
                    $rentedVehicles = $company->vehicles->filter(function($vehicle) {
                        return $vehicle->reservations->where('status', 'confirmed')
                            ->where('start_date', '<=', now())
                            ->where('end_date', '>=', now())
                            ->count() > 0;
                    })->count();
                    
                    $occupationRate = $totalVehicles > 0 ? round(($rentedVehicles / $totalVehicles) * 100) : 0;
                @endphp
                
                <div class="relative pt-1">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <span class="text-xs font-semibold inline-block text-indigo-600">
                                Taux d'occupation: {{ $occupationRate }}%
                            </span>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-semibold inline-block text-indigo-600">
                                {{ $rentedVehicles }}/{{ $totalVehicles }} véhicules
                            </span>
                        </div>
                    </div>
                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-indigo-200">
                        <div style="width:{{ $occupationRate }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-500"></div>
                    </div>
                </div>
            </div>
            
            <!-- Statistiques des revenus -->
            <div class="mt-8">
                <h3 class="text-sm font-medium text-gray-700 mb-3">Revenus par Période</h3>
                @php
                    // Calculer les revenus par période
                    $today = now();
                    
                    $revenueThisMonth = $company->reservations
                        ->whereIn('status', ['confirmed', 'paid', 'completed'])
                        ->filter(function($reservation) use ($today) {
                            return $reservation->end_date->month == $today->month && 
                                   $reservation->end_date->year == $today->year;
                        })
                        ->sum('total_price');
                        
                    $revenueLastMonth = $company->reservations
                        ->whereIn('status', ['confirmed', 'paid', 'completed'])
                        ->filter(function($reservation) use ($today) {
                            $lastMonth = $today->copy()->subMonth();
                            return $reservation->end_date->month == $lastMonth->month && 
                                   $reservation->end_date->year == $lastMonth->year;
                        })
                        ->sum('total_price');
                        
                    $growthRate = $revenueLastMonth > 0 
                        ? round((($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100) 
                        : 100;
                @endphp
                
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm text-gray-500">Ce mois-ci</p>
                        <p class="text-lg font-bold text-gray-800">{{ number_format($revenueThisMonth, 2) }} €</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Le mois dernier</p>
                        <p class="text-lg font-bold text-gray-800">{{ number_format($revenueLastMonth, 2) }} €</p>
                    </div>
                    <div class="flex items-center {{ $growthRate >= 0 ? 'text-green-500' : 'text-red-500' }}">
                        @if($growthRate >= 0)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.586l-4.293-4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586l3.293-3.293A1 1 0 0112 7z" clip-rule="evenodd" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1v-5a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586l-4.293-4.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414l3.293 3.293A1 1 0 0012 13z" clip-rule="evenodd" />
                            </svg>
                        @endif
                        <span class="ml-1 text-sm font-medium">{{ abs($growthRate) }}%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Available & Rented Vehicles Overview -->
<div class="mt-6 bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b">
        <h2 class="font-medium text-gray-700">Aperçu de l'état des véhicules</h2>
    </div>
    <div class="p-6">
        @if(isset($company->vehicles) && $company->vehicles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Available Vehicles -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-3">Véhicules Disponibles</h3>
                    <div class="space-y-3">
                        @foreach($company->vehicles->where('is_available', true)->take(3) as $vehicle)
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="flex-shrink-0 h-12 w-12 bg-gray-200 rounded-md overflow-hidden">
                                    @if($vehicle->photos->count() > 0)
                                        <img src="{{ asset('storage/' . $vehicle->photos->first()->path) }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full w-full bg-gray-200 text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex justify-between">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</h4>
                                        <p class="text-sm font-medium text-gray-900">{{ number_format($vehicle->price_per_day, 2) }} €/jour</p>
                                    </div>
                                    <p class="text-xs text-gray-500">{{ $vehicle->year }} · {{ $vehicle->transmission }} · {{ $vehicle->fuel_type }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Currently Rented Vehicles -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-3">Actuellement Loués</h3>
                    <div class="space-y-3">
                        @php
                            $rentedVehicles = $company->vehicles->filter(function($vehicle) {
                                return $vehicle->reservations->where('status', 'confirmed')
                                    ->where('start_date', '<=', now())
                                    ->where('end_date', '>=', now())
                                    ->count() > 0;
                            })->take(3);
                        @endphp
                        
                        @if($rentedVehicles->count() > 0)
                            @foreach($rentedVehicles as $vehicle)
                                @php
                                    $activeReservation = $vehicle->reservations->where('status', 'confirmed')
                                        ->where('start_date', '<=', now())
                                        ->where('end_date', '>=', now())
                                        ->first();
                                @endphp
                                <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                                    <div class="flex-shrink-0 h-12 w-12 bg-gray-200 rounded-md overflow-hidden">
                                        @if($vehicle->photos->count() > 0)
                                            <img src="{{ asset('storage/' . $vehicle->photos->first()->path) }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="flex items-center justify-center h-full w-full bg-gray-200 text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="flex justify-between">
                                            <h4 class="text-sm font-medium text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</h4>
                                            <p class="text-xs text-gray-500">
                                                Retour: {{ $activeReservation->end_date->format('d/m/Y') }}
                                            </p>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            Loué par: {{ $activeReservation->user->firstName }} {{ $activeReservation->user->lastName }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="flex items-center justify-center p-6 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-500">Aucun véhicule actuellement loué.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p class="mt-2 text-gray-500">Aucun véhicule ajouté pour le moment.</p>
                <button class="mt-4 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Ajouter votre premier véhicule
                </button>
            </div>
        @endif
    </div>
</div>
@endsection