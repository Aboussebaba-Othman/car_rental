@extends('layouts.company')

@section('title', 'Gérer vos véhicules')
@section('header', 'Gestion de la flotte')

@section('content')
<div class="mb-8">
    <!-- Header avec background -->
    <div class="bg-gradient-to-r
bg-gradient-sidebar bg-gradient-sidebar rounded-xl shadow-lg p-6 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-white">Votre flotte de véhicules</h2>
                <p class="text-white opacity-90 mt-1">Gérez tous vos véhicules disponibles à la location</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('company.vehicles.create') }}" class="inline-flex items-center px-4 py-2 bg-white text-bg-gradient-sidebar border border-transparent rounded-lg text-sm font-medium shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Ajouter un véhicule
                </a>
            </div>
        </div>
    </div>
    
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 my-4 rounded-lg shadow-md flex items-center" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-4 rounded-lg shadow-md flex items-center" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <p>{{ session('error') }}</p>
        </div>
    @endif
</div>

@if($vehicles->count() > 0)
    <!-- Filtres rapides -->
    <div class="flex flex-wrap items-center space-x-2 mb-6">
        <span class="text-sm font-medium text-gray-700">Filtres rapides:</span>
        <a href="#" id="quickFilterAll" class="px-3 py-1 bg-yellow-500 text-white border border-transparent rounded-full text-sm font-medium hover:bg-yellow-600 transition-colors duration-200">
            Tous ({{ $vehicles->total() }})
        </a>
        <a href="#" id="quickFilterActive" class="px-3 py-1 bg-white border border-gray-300 rounded-full text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200">
            Actifs
        </a>
        <a href="#" id="quickFilterAvailable" class="px-3 py-1 bg-white border border-gray-300 rounded-full text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200">
            Disponibles
        </a>
        <a href="#" id="quickFilterReserved" class="px-3 py-1 bg-white border border-gray-300 rounded-full text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200">
            Réservés
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <!-- En-tête et options du tableau -->
        <div class="p-5 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Vos véhicules (<span id="resultsCounter">{{ $vehicles->total() }}</span>)</h3>
                <p class="text-sm text-gray-500 mt-1">Gérez facilement votre flotte de location</p>
            </div>
            <div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-3 w-full sm:w-auto">
                <div class="relative w-full sm:w-64">
                    <input type="text" id="searchVehicles" placeholder="Rechercher..." class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-2.5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="flex space-x-2 w-full sm:w-auto">
                    <div class="relative flex-1 sm:flex-none">
                        <select id="brandFilter" class="w-full pl-3 pr-8 py-2 border border-gray-300 rounded-lg text-sm appearance-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition duration-200">
                            <option value="">Toutes les marques</option>
                            @foreach($uniqueBrands as $brand)
                                <option value="{{ $brand }}">{{ $brand }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div class="relative flex-1 sm:flex-none">
                        <select id="statusFilter" class="w-full pl-3 pr-8 py-2 border border-gray-300 rounded-lg text-sm appearance-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition duration-200">
                            <option value="">Tous les statuts</option>
                            <option value="active">Actifs</option>
                            <option value="inactive">Inactifs</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div class="relative flex-1 sm:flex-none">
                        <select id="availabilityFilter" class="w-full pl-3 pr-8 py-2 border border-gray-300 rounded-lg text-sm appearance-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition duration-200">
                            <option value="">Toutes disponibilités</option>
                            <option value="available">Disponibles</option>
                            <option value="reserved">Réservés</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Contenu du tableau - vue carte pour mobile, tableau pour desktop -->
        <div class="hidden md:block">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Véhicule
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Caractéristiques
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tarif
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($vehicles as $vehicle)
                        <tr class="vehicle-row hover:bg-gray-50 transition-colors duration-200" 
                            data-brand="{{ strtolower($vehicle->brand) }}" 
                            data-model="{{ strtolower($vehicle->model) }}" 
                            data-license-plate="{{ strtolower($vehicle->license_plate) }}"
                            data-status="{{ $vehicle->is_active ? 'active' : 'inactive' }}"
                            data-availability="{{ $vehicle->is_available ? 'available' : 'reserved' }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-16 w-16 bg-gray-100 rounded-lg overflow-hidden">
                                        @if($vehicle->photos->where('is_primary', true)->first())
                                            <img class="h-16 w-16 object-cover" 
                                                 src="{{ asset('storage/' . $vehicle->photos->where('is_primary', true)->first()->path) }}" 
                                                 alt="{{ $vehicle->brand }} {{ $vehicle->model }}">
                                        @else
                                            <div class="h-16 w-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H11a1 1 0 001-1v-1h3.05a2.5 2.5 0 014.9 0H19a1 1 0 001-1v-6a1 1 0 00-.293-.707l-3-3A1 1 0 0016 3H3z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-base font-medium text-gray-900">
                                            {{ $vehicle->brand }} {{ $vehicle->model }}
                                        </div>
                                        <div class="flex items-center mt-1">
                                            <span class="text-sm text-gray-500 mr-2">{{ $vehicle->year }}</span>
                                            <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs">
                                                {{ $vehicle->license_plate }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-4">
                                    <div class="flex flex-col items-center text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mb-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H11a1 1 0 001-1v-1h3.05a2.5 2.5 0 014.9 0H19a1 1 0 001-1v-6a1 1 0 00-.293-.707l-3-3A1 1 0 0016 3H3z" />
                                        </svg>
                                        <span class="text-xs font-medium text-gray-700">{{ ucfirst($vehicle->transmission) }}</span>
                                    </div>
                                    <div class="flex flex-col items-center text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mb-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M2 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H3a1 1 0 01-1-1V4zM8 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H9a1 1 0 01-1-1V4zM15 3a1 1 0 00-1 1v12a1 1 0 001 1h2a1 1 0 001-1V4a1 1 0 00-1-1h-2z" />
                                        </svg>
                                        <span class="text-xs font-medium text-gray-700">{{ ucfirst($vehicle->fuel_type) }}</span>
                                    </div>
                                    <div class="flex flex-col items-center text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span class="text-xs font-medium text-gray-700">{{ $vehicle->seats }} places</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-lg font-bold text-gray-900">{{ number_format($vehicle->price_per_day, 2) }} €<span class="text-sm font-normal text-gray-500">/jour</span></div>
                                <div class="text-xs text-gray-500 mt-1 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 {{ ($vehicle->reservations_count ?? 0) ? 'text-yellow-500' : 'text-gray-400' }}" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                    @if($vehicle->reservations_count ?? 0)
                                        <span>{{ $vehicle->reservations_count }} réservations</span>
                                    @else
                                        <span>Aucune réservation</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col space-y-2">
                                    <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium {{ $vehicle->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        <span class="h-2 w-2 rounded-full {{ $vehicle->is_active ? 'bg-green-500' : 'bg-red-500' }} mr-1.5"></span>
                                        {{ $vehicle->is_active ? 'Actif' : 'Inactif' }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium {{ $vehicle->is_available ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        <span class="h-2 w-2 rounded-full {{ $vehicle->is_available ? 'bg-blue-500' : 'bg-yellow-500' }} mr-1.5"></span>
                                        {{ $vehicle->is_available ? 'Disponible' : 'Indisponible' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="p-1.5 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                        </svg>
                                    </button>
                                    <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10 py-1 divide-y divide-gray-100">
                                        <div class="py-1">
                                            <a href="{{ route('company.vehicles.show', $vehicle) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                </svg>
                                                Voir les détails
                                            </a>
                                            <a href="{{ route('company.vehicles.edit', $vehicle) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                                Modifier
                                            </a>
                                        </div>
                                        <div class="py-1">
                                            <form method="POST" action="{{ route('company.vehicles.toggle-active', $vehicle) }}" class="inline w-full">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="flex w-full items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                                                    </svg>
                                                    {{ $vehicle->is_active ? 'Désactiver' : 'Activer' }}
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('company.vehicles.toggle-availability', $vehicle) }}" class="inline w-full">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="flex w-full items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                                    </svg>
                                                    {{ $vehicle->is_available ? 'Marquer indisponible' : 'Marquer disponible' }}
                                                </button>
                                            </form>
                                        </div>
                                        <div class="py-1">
                                            <form method="POST" action="{{ route('company.vehicles.destroy', $vehicle) }}" class="inline w-full" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="flex w-full items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    
        <!-- Vue mobile - cartes -->
        <div class="md:hidden">
            @foreach($vehicles as $vehicle)
                <div class="vehicle-card border-b border-gray-200 p-4"
                     data-brand="{{ strtolower($vehicle->brand) }}" 
                     data-model="{{ strtolower($vehicle->model) }}" 
                     data-license-plate="{{ strtolower($vehicle->license_plate) }}"
                     data-status="{{ $vehicle->is_active ? 'active' : 'inactive' }}"
                     data-availability="{{ $vehicle->is_available ? 'available' : 'reserved' }}">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-24 h-24 bg-gray-100 rounded-lg overflow-hidden">
                            @if($vehicle->photos->where('is_primary', true)->first())
                                <img class="h-24 w-24 object-cover" 
                                     src="{{ asset('storage/' . $vehicle->photos->where('is_primary', true)->first()->path) }}" 
                                     alt="{{ $vehicle->brand }} {{ $vehicle->model }}">
                            @else
                                <div class="h-24 w-24 rounded-lg bg-gray-200 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H11a1 1 0 001-1v-1h3.05a2.5 2.5 0 014.9 0H19a1 1 0 001-1v-6a1 1 0 00-.293-.707l-3-3A1 1 0 0016 3H3z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="ml-4 flex-1">
                            <div class="flex justify-between">
                                <div>
                                    <h4 class="text-base font-medium text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</h4>
                                    <div class="flex items-center mt-1">
                                        <span class="text-sm text-gray-500 mr-2">{{ $vehicle->year }}</span>
                                        <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs">
                                            {{ $vehicle->license_plate }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-base font-bold text-gray-900">{{ number_format($vehicle->price_per_day, 2) }} €<span class="text-xs font-normal text-gray-500">/j</span></div>
                                </div>
                            </div>
                            
                            <div class="flex flex-wrap items-center mt-3 gap-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $vehicle->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $vehicle->is_active ? 'bg-green-500' : 'bg-red-500' }} mr-1"></span>
                                    {{ $vehicle->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $vehicle->is_available ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $vehicle->is_available ? 'bg-blue-500' : 'bg-yellow-500' }} mr-1"></span>
                                    {{ $vehicle->is_available ? 'Disponible' : 'Indisponible' }}
                                </span>
                                <div class="text-xs text-gray-500 inline-flex items-center ml-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-0.5 {{ ($vehicle->reservations_count ?? 0) ? 'text-yellow-500' : 'text-gray-400' }}" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                    @if($vehicle->reservations_count ?? 0)
                                        <span>{{ $vehicle->reservations_count }}</span>
                                    @else
                                        <span>0</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mt-4 flex justify-between items-center">
                                <div class="flex space-x-2">
                                    <a href="{{ route('company.vehicles.show', $vehicle) }}" class="inline-flex items-center justify-center px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                        Voir
                                    </a>
                                    <a href="{{ route('company.vehicles.edit', $vehicle) }}" class="inline-flex items-center justify-center px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                        Modifier
                                    </a>
                                </div>
                                
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="p-1.5 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10 py-1 divide-y divide-gray-100">
                                    <div class="py-1">
                                        <form method="POST" action="{{ route('company.vehicles.toggle-active', $vehicle) }}" class="inline w-full">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="flex w-full items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $vehicle->is_active ? 'Désactiver' : 'Activer' }}
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('company.vehicles.toggle-availability', $vehicle) }}" class="inline w-full">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="flex w-full items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $vehicle->is_available ? 'Indisponible' : 'Disponible' }}
                                            </button>
                                        </form>
                                    </div>
                                    <div class="py-1">
                                        <form method="POST" action="{{ route('company.vehicles.destroy', $vehicle) }}" class="inline w-full" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="flex w-full items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Message de "Aucun résultat" pour la recherche -->
    <div id="noResultsMessage" class="hidden py-12 px-6 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
            </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900">Aucun véhicule ne correspond à votre recherche</h3>
        <p class="mt-1 text-sm text-gray-500 max-w-sm mx-auto">Essayez de modifier vos critères de recherche ou de filtrage.</p>
    </div>

    <!-- États vides et chargement -->
    @if($vehicles->count() == 0)
        <div class="py-12 px-6 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H11a1 1 0 001-1v-1h3.05a2.5 2.5 0 014.9 0H19a1 1 0 001-1v-6a1 1 0 00-.293-.707l-3-3A1 1 0 0016 3H3z" />
                </svg>
            </div>
            <h3 class="text-base font-medium text-gray-900">Aucun véhicule trouvé</h3>
            <p class="mt-1 text-sm text-gray-500 max-w-sm mx-auto">Ajoutez votre premier véhicule pour commencer à proposer vos services de location.</p>
            <div class="mt-6">
                <a href="{{ route('company.vehicles.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Ajouter un véhicule
                </a>
            </div>
        </div>
    @endif

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex items-center justify-between">
        <div class="flex-1 flex justify-between sm:hidden">
            @if($vehicles->previousPageUrl())
                <a href="{{ $vehicles->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Précédent
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-300 bg-gray-50 cursor-not-allowed">
                    Précédent
                </span>
            @endif
            
            @if($vehicles->nextPageUrl())
                <a href="{{ $vehicles->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Suivant
                </a>
            @else
                <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-300 bg-gray-50 cursor-not-allowed">
                    Suivant
                </span>
            @endif
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Affichage de <span class="font-medium">{{ $vehicles->firstItem() ?? 0 }}</span> à <span class="font-medium">{{ $vehicles->lastItem() ?? 0 }}</span> sur <span class="font-medium">{{ $vehicles ->total() }}</span> véhicules
                </p>
            </div>
            <div>
                {{ $vehicles->links() }}
            </div>
        </div>
    </div>
</div>




@else
    <div class="bg-white shadow-md rounded-lg p-8 text-center">
        <div class="bg-yellow-50 inline-block p-4 rounded-full mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H11a1 1 0 001-1v-1h3.05a2.5 2.5 0 014.9 0H19a1 1 0 001-1v-6a1 1 0 00-.293-.707l-3-3A1 1 0 0016 3H3z" />
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900">Aucun véhicule dans votre flotte</h3>
        <p class="mt-2 text-gray-600 max-w-md mx-auto">Commencez par ajouter votre premier véhicule pour le proposer à la location et développer votre activité.</p>
        <div class="mt-6">
            <a href="{{ route('company.vehicles.create') }}" class="inline-flex items-center px-5 py-3 border border-transparent rounded-lg shadow-md text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Ajouter mon premier véhicule
            </a>
        </div>
    </div>
@endif

<!-- Ajoutez cette balise script à la fin de votre fichier -->
<script>
    // vehicles-filter.js - Gestion des filtres et recherches pour les véhicules
document.addEventListener('DOMContentLoaded', function() {
    // Éléments du DOM pour la recherche et les filtres
    const searchInput = document.getElementById('searchVehicles');
    const brandFilter = document.getElementById('brandFilter');
    const statusFilter = document.getElementById('statusFilter');
    const availabilityFilter = document.getElementById('availabilityFilter');
    
    // Éléments pour les filtres rapides
    const quickFilterAll = document.getElementById('quickFilterAll');
    const quickFilterActive = document.getElementById('quickFilterActive');
    const quickFilterAvailable = document.getElementById('quickFilterAvailable');
    const quickFilterReserved = document.getElementById('quickFilterReserved');
    
    // Éléments de la liste des véhicules
    const vehicleRows = document.querySelectorAll('.vehicle-row');
    const vehicleCards = document.querySelectorAll('.vehicle-card');
    const resultsCounter = document.getElementById('resultsCounter');
    const noResultsMessage = document.getElementById('noResultsMessage');
    
    // Variables de suivi des filtres
    let activeFilters = {
        search: '',
        brand: '',
        status: '',
        availability: ''
    };
    
    // Fonction principale pour filtrer les véhicules
    function filterVehicles() {
        let visibleCount = 0;
        
        // Fonction pour vérifier si un véhicule correspond aux critères de filtrage
        function matchesFilters(vehicle) {
            const brand = vehicle.dataset.brand ? vehicle.dataset.brand.toLowerCase() : '';
            const model = vehicle.dataset.model ? vehicle.dataset.model.toLowerCase() : '';
            const licensePlate = vehicle.dataset.licensePlate ? vehicle.dataset.licensePlate.toLowerCase() : '';
            const status = vehicle.dataset.status ? vehicle.dataset.status.toLowerCase() : '';
            const availability = vehicle.dataset.availability ? vehicle.dataset.availability.toLowerCase() : '';
            
            // Vérifier la correspondance avec la recherche
            const searchMatch = !activeFilters.search || 
                brand.includes(activeFilters.search) || 
                model.includes(activeFilters.search) || 
                licensePlate.includes(activeFilters.search);
            
            // Vérifier la correspondance avec les filtres
            const brandMatch = !activeFilters.brand || brand === activeFilters.brand.toLowerCase();
            const statusMatch = !activeFilters.status || status === activeFilters.status.toLowerCase();
            const availabilityMatch = !activeFilters.availability || availability === activeFilters.availability.toLowerCase();
            
            return searchMatch && brandMatch && statusMatch && availabilityMatch;
        }
        
        // Filtrer les lignes du tableau (vue desktop)
        vehicleRows.forEach(row => {
            const isVisible = matchesFilters(row);
            row.classList.toggle('hidden', !isVisible);
            if (isVisible) visibleCount++;
        });
        
        // Filtrer les cartes (vue mobile)
        vehicleCards.forEach(card => {
            const isVisible = matchesFilters(card);
            card.classList.toggle('hidden', !isVisible);
        });
        
        // Mettre à jour le compteur de résultats
        if (resultsCounter) {
            resultsCounter.textContent = visibleCount;
        }
        
        // Afficher/masquer le message "Aucun résultat"
        if (noResultsMessage) {
            noResultsMessage.classList.toggle('hidden', visibleCount > 0);
        }
    }
    
    // Fonction debounce pour éviter trop d'appels lors de la saisie
    function debounce(func, wait) {
        let timeout;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }
    
    // Écouteurs d'événements pour la recherche
    if (searchInput) {
        searchInput.addEventListener('input', debounce(function() {
            activeFilters.search = this.value.toLowerCase().trim();
            filterVehicles();
        }, 300));
    }
    
    // Écouteurs d'événements pour les filtres select
    if (brandFilter) {
        brandFilter.addEventListener('change', function() {
            activeFilters.brand = this.value;
            filterVehicles();
        });
    }
    
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            activeFilters.status = this.value;
            filterVehicles();
        });
    }
    
    if (availabilityFilter) {
        availabilityFilter.addEventListener('change', function() {
            activeFilters.availability = this.value;
            filterVehicles();
        });
    }
    
    function setQuickFilter(filterType, value) {
        activeFilters = {
            search: activeFilters.search,
            brand: '',
            status: '',
            availability: ''
        };
        
        if (filterType === 'status') {
            activeFilters.status = value;
            if (statusFilter) statusFilter.value = value;
        } else if (filterType === 'availability') {
            activeFilters.availability = value;
            if (availabilityFilter) availabilityFilter.value = value;
        }
        
        if (filterType !== 'brand' && brandFilter) brandFilter.value = '';
        if (filterType !== 'status' && statusFilter) statusFilter.value = '';
        if (filterType !== 'availability' && availabilityFilter) availabilityFilter.value = '';
        
        filterVehicles();
        
        updateQuickFilterStyles();
    }
    
    function updateQuickFilterStyles() {
        [quickFilterAll, quickFilterActive, quickFilterAvailable, quickFilterReserved].forEach(filter => {
            if (filter) {
                filter.classList.remove('bg-yellow-500', 'text-white');
                filter.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
            }
        });
        
        if (activeFilters.status === '' && activeFilters.availability === '' && activeFilters.brand === '') {
            if (quickFilterAll) {
                quickFilterAll.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
                quickFilterAll.classList.add('bg-yellow-500', 'text-white');
            }
        } else if (activeFilters.status === 'active') {
            if (quickFilterActive) {
                quickFilterActive.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
                quickFilterActive.classList.add('bg-yellow-500', 'text-white');
            }
        } else if (activeFilters.availability === 'available') {
            if (quickFilterAvailable) {
                quickFilterAvailable.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
                quickFilterAvailable.classList.add('bg-yellow-500', 'text-white');
            }
        } else if (activeFilters.availability === 'reserved') {
            if (quickFilterReserved) {
                quickFilterReserved.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
                quickFilterReserved.classList.add('bg-yellow-500', 'text-white');
            }
        }
    }
    
    if (quickFilterAll) {
        quickFilterAll.addEventListener('click', function(e) {
            e.preventDefault();
            setQuickFilter('all', '');
        });
    }
    
    if (quickFilterActive) {
        quickFilterActive.addEventListener('click', function(e) {
            e.preventDefault();
            setQuickFilter('status', 'active');
        });
    }
    
    if (quickFilterAvailable) {
        quickFilterAvailable.addEventListener('click', function(e) {
            e.preventDefault();
            setQuickFilter('availability', 'available');
        });
    }
    
    if (quickFilterReserved) {
        quickFilterReserved.addEventListener('click', function(e) {
            e.preventDefault();
            setQuickFilter('availability', 'reserved');
        });
    }
    
    updateQuickFilterStyles();
});
</script>
@endsection