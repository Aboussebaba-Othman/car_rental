<!-- filepath: c:\Users\Youcode\Gestion-de-Location-des-Voitures\resources\views\reservations\index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Mes réservations</h1>
            <p class="text-gray-600 mt-1">Consultez et gérez vos réservations de véhicules</p>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if(count($reservations) > 0)
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Véhicule
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Dates de location
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Prix
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Paiement
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($reservations as $reservation)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if($reservation->vehicle->photos->count() > 0)
                                                    @php $primaryPhoto = $reservation->vehicle->photos->firstWhere('is_primary', true) ?? $reservation->vehicle->photos->first(); @endphp
                                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $primaryPhoto->path) }}" alt="{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}">
                                                @else
                                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                        <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $reservation->vehicle->year }} - {{ $reservation->vehicle->license_plate }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }}</div>
                                        <div class="text-sm text-gray-500">au {{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ number_format($reservation->total_price, 2) }} €</div>
                                        @if($reservation->amount_paid)
                                            <div class="text-sm text-green-600">Payé: {{ number_format($reservation->amount_paid, 2) }} €</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($reservation->status == 'confirmed') bg-green-100 text-green-800 
                                            @elseif($reservation->status == 'pending') bg-yellow-100 text-yellow-800 
                                            @elseif($reservation->status == 'payment_pending') bg-blue-100 text-blue-800
                                            @elseif($reservation->status == 'canceled') bg-red-100 text-red-800
                                            @elseif($reservation->status == 'completed') bg-gray-100 text-gray-800
                                            @elseif($reservation->status == 'paid') bg-green-100 text-green-800
                                            @endif">
                                            @if($reservation->status == 'confirmed') Confirmée
                                            @elseif($reservation->status == 'pending') En attente
                                            @elseif($reservation->status == 'payment_pending') Paiement en cours
                                            @elseif($reservation->status == 'canceled') Annulée
                                            @elseif($reservation->status == 'completed') Terminée
                                            @elseif($reservation->status == 'paid') Payée
                                            @else {{ $reservation->status }}
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($reservation->payment_method)
                                            <div>{{ ucfirst($reservation->payment_method) }}</div>
                                            @if($reservation->payment_status)
                                                <div class="text-xs {{ $reservation->payment_status == 'COMPLETED' ? 'text-green-600' : 'text-gray-500' }}">
                                                    {{ $reservation->payment_status }}
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('reservations.show', $reservation) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Détails</a>
                                        
                                        @if(in_array($reservation->status, ['pending', 'payment_pending']))
                                            @if(in_array($reservation->status, ['pending', 'payment_pending']))
                                                <a href="{{ route('reservations.payment', $reservation) }}" class="text-blue-600 hover:text-blue-900 mr-3">Payer</a>
                                            @endif
                                            
                                            <form method="POST" action="{{ route('reservations.cancel', $reservation) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation?');">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-900">Annuler</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $reservations->links() }}
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <svg class="mx-auto h-16 w-16 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h3 class="mt-5 text-xl font-medium text-gray-900">Aucune réservation</h3>
                <p class="mt-2 text-gray-500">Vous n'avez pas encore effectué de réservation de véhicule.</p>
                <div class="mt-6">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700">
                        Explorer les véhicules
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection