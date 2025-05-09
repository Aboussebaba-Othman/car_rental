@extends('layouts.admin')

@section('content')
<div class="px-6 py-8">
    <!-- Page Header with Stats -->
    <div class="mb-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Gestion des Réservations</h1>
                <p class="mt-1 text-gray-600">Vue d'ensemble et gestion des réservations clients</p>
            </div>
            
            <div class="mt-4 md:mt-0">
                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-3 py-1.5 rounded-full">
                    {{ $reservations->total() }} résultat{{ $reservations->total() > 1 ? 's' : '' }}
                </span>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 flex items-center">
                <div class="p-3 rounded-full bg-purple-50 mr-4">
                    <i class="fas fa-credit-card text-purple-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">En attente de paiement</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $paymentPendingCount ?? 0 }}</p>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 flex items-center">
                <div class="p-3 rounded-full bg-yellow-50 mr-4">
                    <i class="fas fa-clock text-yellow-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">En attente</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $pendingCount ?? 0 }}</p>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 flex items-center">
                <div class="p-3 rounded-full bg-green-50 mr-4">
                    <i class="fas fa-check text-green-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Confirmées</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $confirmedCount ?? 0 }}</p>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 flex items-center">
                <div class="p-3 rounded-full bg-red-50 mr-4">
                    <i class="fas fa-times text-red-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Annulées</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $cancelledCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <!-- Quick Filters -->
        <div class="flex flex-wrap gap-2 mb-6">
            <a href="{{ route('admin.reservations.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-full text-sm font-medium transition-colors">
                Toutes
            </a>
            <a href="{{ route('admin.reservations.index', ['status' => 'payment_pending']) }}" class="px-4 py-2 bg-purple-50 hover:bg-purple-100 text-purple-700 rounded-full text-sm font-medium transition-colors">
                En attente de paiement
            </a>
            <a href="{{ route('admin.reservations.index', ['status' => 'pending']) }}" class="px-4 py-2 bg-yellow-50 hover:bg-yellow-100 text-yellow-700 rounded-full text-sm font-medium transition-colors">
                En attente
            </a>
            <a href="{{ route('admin.reservations.index', ['status' => 'confirmed']) }}" class="px-4 py-2 bg-green-50 hover:bg-green-100 text-green-700 rounded-full text-sm font-medium transition-colors">
                Confirmées
            </a>
            <a href="{{ route('admin.reservations.index', ['status' => 'completed']) }}" class="px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-full text-sm font-medium transition-colors">
                Terminées
            </a>
            <a href="{{ route('admin.reservations.index', ['status' => 'cancelled']) }}" class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 rounded-full text-sm font-medium transition-colors">
                Annulées
            </a>
        </div>
    </div>

    <!-- Advanced Search and Filters -->
    <form action="{{ route('admin.reservations.index') }}" method="GET" id="filter-form">
        <div class="p-4 mb-6 bg-white rounded-lg shadow-md">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <h3 class="mb-4 text-lg font-medium text-gray-700 md:mb-0">Filtres</h3>
                <div class="relative">
                    <input type="text" name="search" id="reservation-search" class="w-full py-2 pl-10 pr-4 text-sm bg-gray-100 border border-transparent rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-200 focus:border-yellow-400 md:w-64" placeholder="Rechercher par ID, client..." value="{{ request('search') }}">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 gap-4 mt-4 md:grid-cols-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                    <select id="status" name="status" class="block w-full px-3 py-2 mt-1 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-200 focus:border-yellow-400">
                        <option value="">Tous les statuts</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="payment_pending" {{ request('status') == 'payment_pending' ? 'selected' : '' }}>Paiement en attente</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmée</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Terminée</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Payée</option>
                    </select>
                </div>
                
                <div>
                    <label for="company_id" class="block text-sm font-medium text-gray-700">Entreprise</label>
                    <select id="company_id" name="company_id" class="block w-full px-3 py-2 mt-1 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-200 focus:border-yellow-400">
                        <option value="">Toutes les entreprises</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->company_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Date de début</label>
                    <input type="date" id="start_date" name="start_date" class="block w-full px-3 py-2 mt-1 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-200 focus:border-yellow-400" value="{{ request('start_date') }}">
                </div>
                
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Date de fin</label>
                    <input type="date" id="end_date" name="end_date" class="block w-full px-3 py-2 mt-1 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-200 focus:border-yellow-400" value="{{ request('end_date') }}">
                </div>
            </div>
            
            <div class="flex justify-end mt-4">
                <button type="submit" id="apply-filters" class="px-4 py-2 text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 rounded-md shadow-sm flex items-center">
                    <i class="fas fa-search mr-2"></i> Rechercher
                </button>
                <a href="{{ route('admin.reservations.index') }}" id="reset-filters" class="px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 flex items-center">
                    <i class="fas fa-redo text-gray-500 mr-2"></i> Réinitialiser
                </a>
            </div>
        </div>
    </form>

    <!-- Reservations Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        @if($reservations->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Véhicule</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($reservations as $reservation)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">#{{ $reservation->id }}</div>
                                    <div class="text-xs text-gray-500">{{ $reservation->created_at->format('d/m/Y H:i') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center mr-3">
                                            @if($reservation->user)
                                                @if($reservation->user->avatar)
                                                    <img src="{{ Storage::url($reservation->user->avatar) }}" alt="{{ $reservation->user->firstName }}" class="h-10 w-10 rounded-full object-cover">
                                                @else
                                                    <span class="text-sm font-medium text-gray-600">
                                                        {{ substr($reservation->user->firstName ?? '', 0, 1) }}{{ substr($reservation->user->lastName ?? '', 0, 1) }}
                                                    </span>
                                                @endif
                                            @else
                                                <i class="fas fa-user text-gray-400"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $reservation->user ? $reservation->user->firstName . ' ' . $reservation->user->lastName : 'Client inconnu' }}
                                            </div>
                                            <div class="text-xs text-gray-500">{{ $reservation->user->email ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $reservation->vehicle->brand ?? 'N/A' }} {{ $reservation->vehicle->model ?? '' }}</div>
                                    <div class="text-xs text-gray-500">{{ $reservation->vehicle->company->company_name ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }}</div>
                                    <div class="text-sm text-gray-500">au {{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ number_format($reservation->total_price, 2) }} €</div>
                                    @if($reservation->payment_status === 'paid')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i> Payé
                                        </span>
                                    @elseif($reservation->payment_status === 'pending')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i> En attente
                                        </span>
                                    @elseif($reservation->payment_status === 'refunded')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-undo mr-1"></i> Remboursé
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @switch($reservation->status)
                                        @case('pending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                En attente
                                            </span>
                                            @break
                                        @case('confirmed')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Confirmée
                                            </span>
                                            @break
                                        @case('completed')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Terminée
                                            </span>
                                            @break
                                        @case('cancelled')
                                        @case('canceled')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Annulée
                                            </span>
                                            @break
                                        @default
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $reservation->status }}
                                            </span>
                                    @endswitch
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.reservations.show', $reservation->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $reservations->appends(request()->query())->links() }}
            </div>
        @else
            <div class="p-8 text-center">
                <div class="inline-flex rounded-full bg-yellow-100 p-4 mb-4">
                    <div class="rounded-full bg-yellow-200 p-4">
                        <i class="fas fa-calendar-alt text-yellow-600 text-xl"></i>
                    </div>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">Aucune réservation trouvée</h3>
                <p class="text-gray-500 mb-4 max-w-md mx-auto">
                    Nous n'avons pas trouvé de réservations correspondant à vos critères de recherche. Essayez d'ajuster les filtres.
                </p>
                <a href="{{ route('admin.reservations.index') }}" class="text-yellow-500 hover:text-yellow-700 font-medium">
                    Réinitialiser les filtres
                </a>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Date validation
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        
        if (startDateInput && endDateInput) {
            startDateInput.addEventListener('change', function() {
                if (endDateInput.value && new Date(this.value) > new Date(endDateInput.value)) {
                    alert('La date de début ne peut pas être postérieure à la date de fin');
                    this.value = '';
                }
            });

            endDateInput.addEventListener('change', function() {
                if (startDateInput.value && new Date(this.value) < new Date(startDateInput.value)) {
                    alert('La date de fin ne peut pas être antérieure à la date de début');
                    this.value = '';
                }
            });
        }
    });
</script>
@endpush

@endsection
