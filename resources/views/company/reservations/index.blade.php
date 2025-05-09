@extends('layouts.company')

@section('title', 'Gérer les Réservations')
@section('header', 'Réservations')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Gérer les Réservations</h2>
            <p class="mt-1 text-sm text-gray-600">Consulter et gérer toutes les réservations de véhicules</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <div class="flex flex-wrap space-x-2">
                <a href="{{ route('company.reservations.export') }}" class="flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Exporter</span><span class="hidden sm:inline"> les Données</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Messages de notification -->
    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Filtres et Recherche -->
    <div class="sticky top-0 z-10 sm:relative sm:z-0 sm:mb-0">
        <button id="toggle-filters" class="flex items-center mb-4 px-4 py-2 text-sm font-medium text-indigo-600 bg-white rounded-md shadow-sm border border-gray-200 lg:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
            <span id="filter-text">Afficher les filtres</span>
        </button>
    </div>

    <form action="{{ route('company.reservations.index') }}" method="GET" id="filter-form" class="hidden lg:block mb-6">
        <div class="p-4 sm:p-6 bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <h3 class="mb-4 text-lg font-medium text-gray-700 md:mb-0 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filtres
                </h3>
                <div class="relative">
                    <input type="text" name="search" id="reservation-search" class="w-full py-2 pl-10 pr-4 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white focus:border-indigo-300 transition-colors duration-150 md:w-64" placeholder="Rechercher par client, véhicule..." value="{{ request('search') }}">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 gap-4 mt-6 sm:grid-cols-2 md:grid-cols-4">
                <div>
                    <label for="status-filter" class="block text-sm font-medium text-gray-700">Statut</label>
                    <select id="status-filter" name="status" class="block w-full px-3 py-2 mt-1 text-sm bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-150">
                        <option value="">Tous les statuts</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="payment_pending" {{ request('status') == 'payment_pending' ? 'selected' : '' }}>Paiement en attente</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmé</option>
                        <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Annulé</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Terminé</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Payé</option>
                    </select>
                </div>
                
                <div>
                    <label for="vehicle-filter" class="block text-sm font-medium text-gray-700">Véhicule</label>
                    <select id="vehicle-filter" name="vehicle_id" class="block w-full px-3 py-2 mt-1 text-sm bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-150">
                        <option value="">Tous les véhicules</option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}" {{ request('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                {{ $vehicle->brand }} {{ $vehicle->model }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="date-from" class="block text-sm font-medium text-gray-700">Date de début</label>
                    <input type="date" id="date-from" name="date_from" class="block w-full px-3 py-2 mt-1 text-sm bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-150" value="{{ request('date_from') }}">
                </div>
                
                <div>
                    <label for="date-to" class="block text-sm font-medium text-gray-700">Date de fin</label>
                    <input type="date" id="date-to" name="date_to" class="block w-full px-3 py-2 mt-1 text-sm bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-150" value="{{ request('date_to') }}">
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row sm:justify-end mt-6 space-y-3 sm:space-y-0 sm:space-x-3">
                <button type="submit" id="apply-filters" class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Appliquer
                </button>
                <a href="{{ route('company.reservations.index') }}" id="reset-filters" class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Réinitialiser
                </a>
            </div>
        </div>
    </form>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 gap-4 mb-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100 transition-transform duration-200 hover:shadow-md hover:-translate-y-1">
            <div class="flex items-center">
                <div class="p-3 mr-4 bg-indigo-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total des Réservations</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100 transition-transform duration-200 hover:shadow-md hover:-translate-y-1">
            <div class="flex items-center">
                <div class="p-3 mr-4 bg-green-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Confirmées</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['confirmed'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100 transition-transform duration-200 hover:shadow-md hover:-translate-y-1">
            <div class="flex items-center">
                <div class="p-3 mr-4 bg-yellow-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">En attente</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['pending'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100 transition-transform duration-200 hover:shadow-md hover:-translate-y-1">
            <div class="flex items-center">
                <div class="p-3 mr-4 bg-indigo-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Revenus</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['revenue'], 2) }} €</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tableau des Réservations -->
    <div class="overflow-hidden bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-4 sm:px-6 py-5 border-b border-gray-200 flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-2 sm:space-y-0">
            <div>
                <h3 class="text-lg font-medium leading-6 text-gray-900">Toutes les Réservations</h3>
                <p class="mt-1 text-sm text-gray-600">
                    @if(method_exists($reservations, 'total'))
                        {{ $reservations->total() }} réservation(s) trouvée(s)
                    @else
                        {{ $reservations->count() }} réservation(s) trouvée(s)
                    @endif
                </p>
            </div>
            <div class="flex flex-wrap items-center space-x-2 text-xs text-gray-500">
                <span class="flex items-center mb-1 sm:mb-0">
                    <div class="w-3 h-3 bg-yellow-100 rounded-full mr-1"></div>
                    En attente
                </span>
                <span class="flex items-center mb-1 sm:mb-0">
                    <div class="w-3 h-3 bg-green-100 rounded-full mr-1"></div>
                    Confirmée
                </span>
                <span class="flex items-center mb-1 sm:mb-0">
                    <div class="w-3 h-3 bg-blue-100 rounded-full mr-1"></div>
                    Terminée
                </span>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-3 sm:px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Client & Véhicule
                        </th>
                        <th scope="col" class="px-3 sm:px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase hidden sm:table-cell">
                            Dates
                        </th>
                        <th scope="col" class="px-3 sm:px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase hidden md:table-cell">
                            Prix
                        </th>
                        <th scope="col" class="px-3 sm:px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Statut
                        </th>
                        <th scope="col" class="px-3 sm:px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reservations as $reservation)
                        <tr class="hover:bg-gray-50 transition-colors duration-150 reservation-row">
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-8 h-8 sm:w-10 sm:h-10 hidden sm:block">
                                        <img class="w-8 h-8 sm:w-10 sm:h-10 rounded-full" src="https://ui-avatars.com/api/?name={{ substr($reservation->user->firstName, 0 ,1)}} {{ substr($reservation->user->lastName, 0, 1) }}  &color=7F9CF5&background=EBF4FF" alt="{{ $reservation->user->name }}">
                                    </div>
                                    <div class="sm:ml-4">
                                        <div class="text-sm font-medium text-gray-900 flex items-center">
                                            {{ $reservation->user->firstName }} {{ $reservation->user->lastName }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}
                                        </div>
                                        <!-- Date info for mobile -->
                                        <div class="text-xs text-blue-500 sm:hidden mt-1">
                                            {{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}
                                        </div>
                                        <!-- Prix for mobile -->
                                        <div class="text-xs font-semibold text-gray-800 sm:hidden mt-1">
                                            {{ number_format($reservation->total_price, 2) }} €
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }}</div>
                                <div class="text-sm text-gray-500">au {{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) + 1 }} jour(s)
                                </div>
                            </td>
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap hidden md:table-cell">
                                <div class="text-sm font-medium text-gray-900">{{ number_format($reservation->total_price, 2) }} €</div>
                                @if($reservation->promotion)
                                    <div class="text-xs text-green-600 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="hidden sm:inline">{{ $reservation->promotion->name }}</span> (-{{ $reservation->promotion->discount_percentage }}%)
                                    </div>
                                @endif
                            </td>
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full 
                                    @if($reservation->status == 'confirmed') bg-green-100 text-green-800 
                                    @elseif($reservation->status == 'pending') bg-yellow-100 text-yellow-800 
                                    @elseif($reservation->status == 'payment_pending') bg-blue-100 text-blue-800
                                    @elseif($reservation->status == 'canceled') bg-red-100 text-red-800
                                    @elseif($reservation->status == 'completed') bg-gray-100 text-gray-800
                                    @elseif($reservation->status == 'paid') bg-green-100 text-green-800
                                    @endif">
                                    @if($reservation->status == 'confirmed') Confirmé
                                    @elseif($reservation->status == 'pending') En attente
                                    @elseif($reservation->status == 'payment_pending') Paiement
                                    @elseif($reservation->status == 'canceled') Annulé
                                    @elseif($reservation->status == 'completed') Terminé
                                    @elseif($reservation->status == 'paid') Payé
                                    @else {{ ucfirst($reservation->status) }}
                                    @endif
                                </span>
                                <div class="mt-1 text-xs text-gray-500 hidden sm:block">
                                    {{ $reservation->created_at->format('d/m/Y H:i') }}
                                </div>
                            </td>
                            <td class="px-3 sm:px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <div class="flex justify-end space-x-1 sm:space-x-2">
                                    <a href="{{ route('company.reservations.show', $reservation) }}" class="text-indigo-600 hover:text-indigo-900 p-1 rounded hover:bg-indigo-50 transition-colors duration-150" title="Voir les détails">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    
                                    @if($reservation->status == 'pending')
                                        <form method="POST" action="{{ route('company.reservations.confirm', $reservation) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900 p-1 rounded hover:bg-green-50 transition-colors duration-150" title="Confirmer la réservation">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if(in_array($reservation->status, ['pending', 'payment_pending']))
                                        <form method="POST" action="{{ route('company.reservations.cancel', $reservation) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50 transition-colors duration-150" title="Annuler la réservation" 
                                                    onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <div class="dropdown-actions relative sm:hidden" x-data="{ open: false }">
                                        <button @click="open = !open" class="text-gray-500 hover:text-gray-700 p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                            </svg>
                                        </button>
                                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 border border-gray-100">
                                            @if(in_array($reservation->status, ['confirmed', 'paid']))
                                                <form method="POST" action="{{ route('company.reservations.complete', $reservation) }}" class="w-full">
                                                    @csrf
                                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center" title="Marquer comme terminé">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Terminer
                                                    </button>
                                                </form>
                                            @endif

                                            @if(in_array($reservation->status, ['confirmed', 'paid', 'completed']))
                                                <a href="{{ route('company.reservations.invoice', $reservation) }}" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    Facture
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="hidden sm:block">
                                        @if(in_array($reservation->status, ['confirmed', 'paid']))
                                            <form method="POST" action="{{ route('company.reservations.complete', $reservation) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-gray-600 hover:text-gray-900 p-1 rounded hover:bg-gray-50 transition-colors duration-150" title="Marquer comme terminé">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif

                                        @if(in_array($reservation->status, ['confirmed', 'paid', 'completed']))
                                            <a href="{{ route('company.reservations.invoice', $reservation) }}" target="_blank" class="text-gray-600 hover:text-gray-900 p-1 rounded hover:bg-gray-50 transition-colors duration-150" title="Générer une facture">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center whitespace-nowrap">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="mt-2 text-gray-500">Aucune réservation trouvée</p>
                                    <a href="{{ route('company.reservations.create') }}" class="mt-4 px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                                        Créer une nouvelle réservation
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-4 sm:px-6 py-3 bg-white border-t border-gray-200">
            @if(method_exists($reservations, 'links'))
                {{ $reservations->links() }}
            @endif
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle filters visibility
        const toggleFiltersBtn = document.getElementById('toggle-filters');
        const filterForm = document.getElementById('filter-form');
        const filterText = document.getElementById('filter-text');
        
        if (toggleFiltersBtn) {
            toggleFiltersBtn.addEventListener('click', function() {
                filterForm.classList.toggle('hidden');
                filterText.textContent = filterForm.classList.contains('hidden') 
                    ? 'Afficher les filtres' 
                    : 'Masquer les filtres';
            });
        }
        
        // Make reservation rows expandable on mobile
        const reservationRows = document.querySelectorAll('.reservation-row');
        
        reservationRows.forEach(row => {
            if (window.innerWidth < 640) { // Mobile view
                row.addEventListener('click', function(e) {
                    // Don't trigger if clicking on a button or link
                    if (e.target.closest('a') || e.target.closest('button') || e.target.closest('form')) {
                        return;
                    }
                    
                    this.classList.toggle('expanded-row');
                    
                    const details = this.querySelector('.mobile-details');
                    if (details) {
                        details.classList.toggle('hidden');
                    }
                });
            }
        });
        
        // Pre-populate filters from URL params
        const urlParams = new URLSearchParams(window.location.search);
        const searchInput = document.getElementById('reservation-search');
        const statusFilter = document.getElementById('status-filter');
        const vehicleFilter = document.getElementById('vehicle-filter');
        const dateFromFilter = document.getElementById('date-from');
        const dateToFilter = document.getElementById('date-to');
        const resetFiltersBtn = document.getElementById('reset-filters');
        
        // Responsive search
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                if (window.innerWidth < 768) { // Mobile view
                    const searchTerm = this.value.toLowerCase();
                    const tableRows = document.querySelectorAll('tbody tr');
                    
                    tableRows.forEach(row => {
                        if (!row.classList.contains('empty-row')) {
                            const content = row.textContent.toLowerCase();
                            if (content.includes(searchTerm)) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        }
                    });
                }
            });
        }
        
        // Enable enter key to submit the form
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.getElementById('filter-form').submit();
                }
            });
        }
        
        // Clear all filters
        if (resetFiltersBtn) {
            resetFiltersBtn.addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = "{{ route('company.reservations.index') }}";
            });
        }

        // Add date validation
        if (dateFromFilter && dateToFilter) {
            dateFromFilter.addEventListener('change', function() {
                if (dateToFilter.value && new Date(this.value) > new Date(dateToFilter.value)) {
                    alert('La date de début ne peut pas être postérieure à la date de fin');
                    this.value = '';
                }
            });

            dateToFilter.addEventListener('change', function() {
                if (dateFromFilter.value && new Date(this.value) < new Date(dateFromFilter.value)) {
                    alert('La date de fin ne peut pas être antérieure à la date de début');
                    this.value = '';
                }
            });
        }

        // Mettre en évidence les lignes des réservations récentes (moins de 24h)
        document.querySelectorAll('tbody tr').forEach(function(row) {
            const createdAtText = row.querySelector('td:nth-child(4) .text-xs')?.textContent?.trim();
            if (createdAtText) {
                const createdDate = new Date(createdAtText.split(' ')[0].split('/').reverse().join('-') + 'T' + createdAtText.split(' ')[1]);
                const now = new Date();
                const diff = (now - createdDate) / (1000 * 60 * 60); // heures

                if (diff < 24) {
                    row.classList.add('bg-blue-50');
                }
            }
        });
        
        // Responsive adjustments
        function adjustForScreenSize() {
            if (window.innerWidth < 640) { // Mobile
                document.querySelectorAll('table').forEach(table => {
                    table.classList.add('mobile-table');
                });
            } else {
                document.querySelectorAll('table').forEach(table => {
                    table.classList.remove('mobile-table');
                });
            }
        }
        
        // Call initially and on resize
        adjustForScreenSize();
        window.addEventListener('resize', adjustForScreenSize);
    });
</script>

<style>
    /* Responsive styles */
    @media (max-width: 640px) {
        .expanded-row {
            background-color: #f9fafb !important;
        }
        
        .expanded-row td {
            border-bottom: none;
        }
        
        .mobile-table th:not(:first-child):not(:last-child) {
            display: none;
        }
        
        .dropdown-actions {
            position: static;
        }
        
        .dropdown-actions [x-show="open"] {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            margin: 0;
            border-radius: 12px 12px 0 0;
            box-shadow: 0 -4px 6px -1px rgba(0, 0, 0, 0.1);
            z-index: 50;
            animation: slideUp 0.3s ease;
        }
        
        @keyframes slideUp {
            from { transform: translateY(100%); }
            to { transform: translateY(0); }
        }
        
        .dropdown-actions [x-show="open"] button,
        .dropdown-actions [x-show="open"] a {
            padding: 16px;
            border-bottom: 1px solid #f3f4f6;
        }
    }
    
    /* General responsive adjustments */
    .overflow-x-auto {
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
    }
    
    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 3px;
    }
</style>
@endsection