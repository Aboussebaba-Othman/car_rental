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
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 relative vehicle-thumbnail-container" 
                                                 data-vehicle-id="{{ $reservation->vehicle_id }}">
                                                @if($reservation->vehicle->photos->count() > 0)
                                                    @php $primaryPhoto = $reservation->vehicle->photos->firstWhere('is_primary', true) ?? $reservation->vehicle->photos->first(); @endphp
                                                    <img class="h-10 w-10 rounded-full object-cover" 
                                                        src="{{ asset('storage/' . $primaryPhoto->path) }}" 
                                                        alt="{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}">
                                                    
                                                    <!-- Photo gallery popup on hover -->
                                                    @if($reservation->vehicle->photos->count() > 1)
                                                    <div class="vehicle-thumbnail-popup hidden absolute left-0 top-0 z-10 bg-white rounded-lg shadow-xl p-2 transform -translate-y-full">
                                                        <div class="grid grid-cols-{{ min(4, $reservation->vehicle->photos->count()) }} gap-1">
                                                            @foreach($reservation->vehicle->photos->take(8) as $photo)
                                                                <img src="{{ asset('storage/' . $photo->path) }}" 
                                                                    alt="{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}" 
                                                                    class="w-16 h-12 object-cover rounded">
                                                            @endforeach
                                                        </div>
                                                        @if($reservation->vehicle->photos->count() > 8)
                                                            <div class="text-xs text-center text-gray-500 mt-1">
                                                                +{{ $reservation->vehicle->photos->count() - 8 }} autres photos
                                                            </div>
                                                        @endif
                                                    </div>
                                                    @endif
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
                                        <div class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }}</div>
                                        <div class="text-sm text-gray-500">
                                            <span class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l4.293-4.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                                {{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}
                                            </span>
                                        </div>
                                        <div class="text-xs text-yellow-600 mt-1">
                                            ({{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) }} jours)
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ number_format($reservation->total_price, 2) }} €</div>
                                        @if($reservation->amount_paid)
                                            <div class="text-sm text-green-600 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                Payé: {{ number_format($reservation->amount_paid, 2) }} €
                                            </div>
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
                                            @if($reservation->status == 'confirmed') 
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1 inline" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                Confirmée
                                            @elseif($reservation->status == 'pending')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1 inline" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                </svg>
                                                En attente
                                            @elseif($reservation->status == 'payment_pending')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1 inline" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                                </svg>
                                                Paiement en cours
                                            @elseif($reservation->status == 'canceled')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1 inline" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                </svg>
                                                Annulée
                                            @elseif($reservation->status == 'completed')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1 inline" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                                Terminée
                                            @elseif($reservation->status == 'paid')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1 inline" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                                </svg>
                                                Payée
                                            @else {{ $reservation->status }}
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($reservation->payment_method)
                                            <div class="flex items-center">
                                                @if($reservation->payment_method == 'paypal')
                                                    <img src="https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-30px.png" alt="PayPal" class="h-4 mr-1">
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                    </svg>
                                                @endif
                                                {{ ucfirst($reservation->payment_method) }}
                                            </div>
                                            @if($reservation->payment_status)
                                                <div class="text-xs {{ $reservation->payment_status == 'COMPLETED' ? 'text-green-600' : 'text-gray-500' }} mt-1">
                                                    {{ $reservation->payment_status }}
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('reservations.show', $reservation) }}" class="text-yellow-600 hover:text-yellow-900 mr-3 hover:underline">
                                            <span class="flex items-center justify-end">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                </svg>
                                                Détails
                                            </span>
                                        </a>
                                        
                                        @if(in_array($reservation->status, ['pending', 'payment_pending']))
                                            @if(in_array($reservation->status, ['pending', 'payment_pending']))
                                                <a href="{{ route('reservations.payment', $reservation) }}" class="text-blue-600 hover:text-blue-900 mr-3 hover:underline">
                                                    <span class="flex items-center justify-end mt-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                                        </svg>
                                                        Payer
                                                    </span>
                                                </a>
                                            @endif
                                            
                                            <form method="POST" action="{{ route('reservations.cancel', $reservation) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation?');">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-900 hover:underline">
                                                    <span class="flex items-center justify-end mt-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293-1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                        </svg>
                                                        Annuler
                                                    </span>
                                                </button>
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

@section('scripts')
<script>
    // Photo thumbnail hover functionality
    document.addEventListener('DOMContentLoaded', function() {
        const thumbnailContainers = document.querySelectorAll('.vehicle-thumbnail-container');
        
        thumbnailContainers.forEach(container => {
            const popup = container.querySelector('.vehicle-thumbnail-popup');
            if (popup) {
                container.addEventListener('mouseenter', function() {
                    popup.classList.remove('hidden');
                });
                
                container.addEventListener('mouseleave', function() {
                    popup.classList.add('hidden');
                });
            }
        });
    });
</script>
@endsection