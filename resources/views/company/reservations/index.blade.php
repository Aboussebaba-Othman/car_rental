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
                <a href="{{ route('company.reservations.export') }}" class="flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Exporter les Données
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
    <form action="{{ route('company.reservations.index') }}" method="GET" id="filter-form">
        <div class="p-4 mb-6 bg-white rounded-lg shadow-md">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <h3 class="mb-4 text-lg font-medium text-gray-700 md:mb-0">Filtres</h3>
                <div class="relative">
                    <input type="text" name="search" id="reservation-search" class="w-full py-2 pl-10 pr-4 text-sm bg-gray-100 border border-transparent rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white focus:border-transparent md:w-64" placeholder="Rechercher par ID, client..." value="{{ request('search') }}">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 gap-4 mt-4 md:grid-cols-4">
                <div>
                    <label for="status-filter" class="block text-sm font-medium text-gray-700">Statut</label>
                    <select id="status-filter" name="status" class="block w-full px-3 py-2 mt-1 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
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
                    <select id="vehicle-filter" name="vehicle_id" class="block w-full px-3 py-2 mt-1 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
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
                    <input type="date" id="date-from" name="date_from" class="block w-full px-3 py-2 mt-1 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="{{ request('date_from') }}">
                </div>
                
                <div>
                    <label for="date-to" class="block text-sm font-medium text-gray-700">Date de fin</label>
                    <input type="date" id="date-to" name="date_to" class="block w-full px-3 py-2 mt-1 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="{{ request('date_to') }}">
                </div>
            </div>
            
            <div class="flex justify-end mt-4">
                <button type="submit" id="apply-filters" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Appliquer les filtres
                </button>
                <a href="{{ route('company.reservations.index') }}" id="reset-filters" class="px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Réinitialiser
                </a>
            </div>
        </div>
    </form>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-4">
        <div class="p-4 bg-white rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 mr-4 bg-blue-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total des Réservations</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="p-4 bg-white rounded-lg shadow-md">
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
        
        <div class="p-4 bg-white rounded-lg shadow-md">
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
        
        <div class="p-4 bg-white rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 mr-4 bg-blue-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
    <div class="overflow-hidden bg-white rounded-lg shadow-md">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Toutes les Réservations</h3>
            <p class="mt-1 text-sm text-gray-600">{{ $reservations->total() }} réservation(s) trouvée(s)</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            ID/Client
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Véhicule
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Dates
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Prix
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Statut
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reservations as $reservation)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-10 h-10">
                                        <img class="w-10 h-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($reservation->user->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $reservation->user->name }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            #{{ $reservation->id }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $reservation->user->name }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $reservation->user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}</div>
                                <div class="text-xs text-gray-500">{{ $reservation->vehicle->license_plate }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }}</div>
                                <div class="text-sm text-gray-500">au {{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) + 1 }} jour(s)
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ number_format($reservation->total_price, 2) }} €</div>
                                @if($reservation->promotion)
                                    <div class="text-xs text-green-600">
                                        {{ $reservation->promotion->name }} (-{{ $reservation->promotion->discount_percentage }}%)
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full 
                                    @if($reservation->status == 'confirmed') bg-green-100 text-green-800 
                                    @elseif($reservation->status == 'pending') bg-yellow-100 text-yellow-800 
                                    @elseif($reservation->status == 'payment_pending') bg-blue-100 text-blue-800
                                    @elseif($reservation->status == 'canceled') bg-red-100 text-red-800
                                    @elseif($reservation->status == 'completed') bg-gray-100 text-gray-800
                                    @elseif($reservation->status == 'paid') bg-green-100 text-green-800
                                    @endif">
                                    @if($reservation->status == 'confirmed') Confirmé
                                    @elseif($reservation->status == 'pending') En attente
                                    @elseif($reservation->status == 'payment_pending') Paiement en attente
                                    @elseif($reservation->status == 'canceled') Annulé
                                    @elseif($reservation->status == 'completed') Terminé
                                    @elseif($reservation->status == 'paid') Payé
                                    @else {{ ucfirst($reservation->status) }}
                                    @endif
                                </span>
                                <div class="mt-1 text-xs text-gray-500">
                                    {{ $reservation->created_at->format('d/m/Y H:i') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('company.reservations.show', $reservation) }}" class="text-blue-600 hover:text-blue-900" title="Voir les détails">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    
                                    @if($reservation->status == 'pending')
                                        <form method="POST" action="{{ route('company.reservations.confirm', $reservation) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900" title="Confirmer la réservation">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if(in_array($reservation->status, ['pending', 'payment_pending']))
                                        <form method="POST" action="{{ route('company.reservations.cancel', $reservation) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Annuler la réservation" 
                                                    onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if(in_array($reservation->status, ['confirmed', 'paid']))
                                        <form method="POST" action="{{ route('company.reservations.complete', $reservation) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-gray-600 hover:text-gray-900" title="Marquer comme terminé">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif

                                    @if(in_array($reservation->status, ['confirmed', 'paid', 'completed']))
                                        <a href="{{ route('company.reservations.invoice', $reservation) }}" target="_blank" class="text-gray-600 hover:text-gray-900" title="Générer une facture">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="mt-2 text-gray-500">Aucune réservation trouvée</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
            {{ $reservations->links() }}
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Pre-populate filters from URL params
        const urlParams = new URLSearchParams(window.location.search);
        const searchInput = document.getElementById('reservation-search');
        const statusFilter = document.getElementById('status-filter');
        const vehicleFilter = document.getElementById('vehicle-filter');
        const dateFromFilter = document.getElementById('date-from');
        const dateToFilter = document.getElementById('date-to');
        const resetFiltersBtn = document.getElementById('reset-filters');
        
        // Enable enter key to submit the form
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('filter-form').submit();
            }
        });
        
        // Clear all filters
        resetFiltersBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = "{{ route('company.reservations.index') }}";
        });

        // Add date validation
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

        // Mettre en évidence les lignes des réservations récentes (moins de 24h)
        document.querySelectorAll('tbody tr').forEach(function(row) {
            const createdAtText = row.querySelector('td:nth-child(5) .text-xs').textContent.trim();
            const createdDate = new Date(createdAtText.split(' ')[0].split('/').reverse().join('-') + 'T' + createdAtText.split(' ')[1]);
            const now = new Date();
            const diff = (now - createdDate) / (1000 * 60 * 60); // heures

            if (diff < 24) {
                row.classList.add('bg-blue-50');
            }
        });
    });
</script>
@endsection