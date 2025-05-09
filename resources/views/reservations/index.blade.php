@extends('layouts.app')

@section('content')
<div class="py-12 bg-gradient-to-b from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Mes réservations
            </h1>
            <p class="text-gray-600 mt-2 ml-11">Consultez et gérez vos réservations de véhicules</p>
        </div>

        <style>
            /* Dropdown styles removed as they are no longer needed */
        </style>

        <!-- Notifications -->
        @if (session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-5 rounded-lg shadow-sm animate-fade-in" role="alert">
                <p class="font-medium flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-5 rounded-lg shadow-sm animate-pulse" role="alert">
                <p class="font-medium flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    {{ session('error') }}
                </p>
            </div>
        @endif

        @if(count($reservations) > 0)
            <!-- Desktop View -->
            <div class="hidden md:block bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Véhicule
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Dates de location
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Prix
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Paiement
                                </th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($reservations as $reservation)
                                <tr class="hover:bg-gray-50 transition-all duration-200 transform hover:scale-[1.01]">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 relative vehicle-thumbnail-container" 
                                                 data-vehicle-id="{{ $reservation->vehicle_id }}">
                                                @if($reservation->vehicle->photos->count() > 0)
                                                    @php $primaryPhoto = $reservation->vehicle->photos->firstWhere('is_primary', true) ?? $reservation->vehicle->photos->first(); @endphp
                                                    <img class="h-10 w-10 rounded-full object-cover" 
                                                        src="{{ asset('storage/' . $primaryPhoto->path) }}" 
                                                        alt="{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}">
                                                    
                                            
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
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293-1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
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
                                                    <img src="{{ asset('images/payment-icons/paypal-logo.png') }}" 
                                                         alt="PayPal" 
                                                         class="h-5 mr-1"
                                                         onerror="this.onerror=null; this.src='https://www.paypalobjects.com/webstatic/en_US/i/buttons/PP_logo_h_100x26.png';">
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                    </svg>
                                                @endif
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
                                    
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <div class="flex flex-col space-y-2">
                                            <a href="{{ route('reservations.show', $reservation) }}" 
                                               class="flex items-center justify-center px-3 py-1.5 rounded-lg bg-yellow-50 text-yellow-600 hover:bg-yellow-100 transition-colors duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                </svg>
                                                Détails
                                            </a>
                                            
                                            @if(in_array($reservation->status, ['pending', 'payment_pending']))
                                                <a href="{{ route('reservations.payment', $reservation) }}" 
                                                   class="flex items-center justify-center px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors duration-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                                    </svg>
                                                    Payer
                                                </a>
                                            
                                                <form method="POST" action="{{ route('reservations.cancel', $reservation) }}" 
                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation?');" 
                                                      class="inline-block w-full">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="w-full flex items-center justify-center px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors duration-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293-1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                        </svg>
                                                        Annuler
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if(in_array($reservation->status, ['confirmed', 'paid', 'completed']))
                                                <a href="{{ route('reservations.invoice', $reservation) }}" 
                                                   class="flex items-center justify-center px-3 py-1.5 rounded-lg bg-green-50 text-green-600 hover:bg-green-100 transition-colors duration-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                                                    </svg>
                                                    Facture
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $reservations->links() }}
                </div>
            </div>
            
            <div class="md:hidden space-y-4">
                @foreach($reservations as $reservation)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 transition-all duration-200 hover:shadow-lg">
                        <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                            <div class="flex items-center">
                                @if($reservation->vehicle->photos->count() > 0)
                                    @php $primaryPhoto = $reservation->vehicle->photos->firstWhere('is_primary', true) ?? $reservation->vehicle->photos->first(); @endphp
                                    <img class="h-10 w-10 rounded-full object-cover" 
                                        src="{{ asset('storage/' . $primaryPhoto->path) }}" 
                                        alt="{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center">
                                        <svg class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 6h1m-7 7v1m-6-6H4" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}</h3>
                                    <p class="text-xs text-gray-500">{{ $reservation->vehicle->year }}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($reservation->status === 'confirmed') bg-green-100 text-green-800 
                                @elseif($reservation->status === 'pending') bg-yellow-100 text-yellow-800 
                                @elseif($reservation->status === 'payment_pending') bg-blue-100 text-blue-800
                                @elseif($reservation->status === 'canceled') bg-red-100 text-red-800
                                @elseif($reservation->status === 'completed') bg-gray-100 text-gray-800
                                @elseif($reservation->status === 'paid') bg-green-100 text-green-800
                                @endif">
                                @if($reservation->status === 'confirmed') Confirmée
                                @elseif($reservation->status === 'pending') En attente
                                @elseif($reservation->status === 'payment_pending') Paiement en cours
                                @elseif($reservation->status === 'canceled') Annulée
                                @elseif($reservation->status === 'completed') Terminée
                                @elseif($reservation->status === 'paid') Payée
                                @else {{ $reservation->status }}
                                @endif
                            </span>
                        </div>
                        <div class="p-4 space-y-3">
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-500">Dates</p>
                                    <p class="font-medium">{{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Prix</p>
                                    <p class="font-medium">{{ number_format($reservation->total_price, 2) }} €</p>
                                </div>
                                @if($reservation->payment_method)
                                    <div>
                                        <p class="text-gray-500">Paiement</p>
                                        <p class="font-medium flex items-center">
                                            @if($reservation->payment_method == 'paypal')
                                                <img src="{{ asset('images/payment-icons/paypal-logo.png') }}" 
                                                     alt="PayPal" 
                                                     class="h-4 mr-1"
                                                     onerror="this.onerror=null; this.src='https://www.paypalobjects.com/webstatic/en_US/i/buttons/PP_logo_h_100x26.png';">
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                </svg>
                                            @endif
                                        </p>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="border-t border-gray-100 pt-3 flex justify-between">
                                <a href="{{ route('reservations.show', $reservation) }}" class="text-yellow-600 flex items-center text-sm font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                    Détails
                                </a>
                                
                                @if(in_array($reservation->status, ['pending', 'payment_pending']))
                                    <a href="{{ route('reservations.payment', $reservation) }}" class="text-blue-600 flex items-center text-sm font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                        </svg>
                                        Payer
                                    </a>
                                @endif
                                
                                @if(in_array($reservation->status, ['confirmed', 'paid', 'completed']))
                                    <a href="{{ route('reservations.invoice', $reservation) }}" class="text-green-600 flex items-center text-sm font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                                        </svg>
                                        Facture
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
                
                <div class="mt-4">
                    {{ $reservations->links() }}
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-md p-8 text-center border border-gray-100">
                <div class="bg-yellow-50 p-4 rounded-full inline-flex items-center justify-center w-20 h-20 mx-auto mb-4">
                    <svg class="h-10 w-10 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900">Aucune réservation</h3>
                <p class="mt-2 text-gray-500 max-w-md mx-auto">Vous n'avez pas encore effectué de réservation de véhicule. Explorez notre catalogue pour trouver le véhicule idéal pour vos besoins.</p>
                <div class="mt-6">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1v-5h2a1 1 0 00.707-.293l3-3a1 1 0 00.293-.707V6a1 1 0 00-1-1H3z" />
                        </svg>
                        Explorer les véhicules
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@include('layouts.footer')
{{-- <script>
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
        
        const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.stopPropagation();
                const menu = this.nextElementSibling;
                
                document.querySelectorAll('.dropdown-menu').forEach(m => {
                    if (m !== menu) {
                        m.classList.add('hidden');
                        m.classList.remove('show');
                    }
                });
                
                menu.classList.toggle('hidden');
                if (!menu.classList.contains('hidden')) {
                    setTimeout(() => {
                        menu.classList.add('show');
                    }, 10);
                } else {
                    menu.classList.remove('show');
                }
            });
        });
        
        document.addEventListener('click', function() {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.add('hidden');
                menu.classList.remove('show');
            });
        });
    });
</script> --}}
@endsection