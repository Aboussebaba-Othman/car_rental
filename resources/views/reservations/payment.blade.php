<!-- filepath: c:\Users\Youcode\Gestion-de-Location-des-Voitures\resources\views\reservations\payment.blade.php -->
@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-md rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Paiement de votre réservation</h2>
                
                @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif
                
                @if (session('warning'))
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
                        <p>{{ session('warning') }}</p>
                    </div>
                @endif

                <div class="mb-8 border-b border-gray-200 pb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-700">Détails de la réservation</h3>
                        <span class="px-3 py-1 rounded-full text-sm 
                            @if($reservation->status === 'pending') bg-yellow-100 text-yellow-800 
                            @elseif($reservation->status === 'payment_pending') bg-blue-100 text-blue-800
                            @elseif($reservation->status === 'confirmed') bg-green-100 text-green-800
                            @elseif($reservation->status === 'canceled') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                            @if($reservation->status === 'pending') En attente
                            @elseif($reservation->status === 'payment_pending') Paiement en cours
                            @elseif($reservation->status === 'confirmed') Confirmée
                            @elseif($reservation->status === 'canceled') Annulée
                            @else {{ $reservation->status }} @endif
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Véhicule:</p>
                            <p class="font-semibold">{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }} ({{ $reservation->vehicle->year }})</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600 mb-1">Période de location:</p>
                            <p class="font-semibold">{{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600 mb-1">Lieu de prise en charge:</p>
                            <p class="font-semibold">{{ $reservation->pickup_location }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600 mb-1">Lieu de retour:</p>
                            <p class="font-semibold">{{ $reservation->return_location }}</p>
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-700 mb-4">Récapitulatif du prix</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Prix par jour:</span>
                            <span>{{ number_format($reservation->vehicle->price_per_day, 2) }} €</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Durée de location:</span>
                            <span>{{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) ?: 1 }} jour(s)</span>
                        </div>
                        @if($reservation->promotion)
                        <div class="flex justify-between items-center mb-2 text-green-600">
                            <span>Promotion appliquée ({{ $reservation->promotion->name }}):</span>
                            <span>-{{ $reservation->promotion->discount_percentage }}%</span>
                        </div>
                        @endif
                        <div class="border-t border-gray-300 my-2 pt-2 flex justify-between items-center font-semibold">
                            <span>Total à payer:</span>
                            <span class="text-xl">{{ number_format($reservation->total_price, 2) }} €</span>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-700 mb-4">Choisissez votre méthode de paiement</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- PayPal Payment Option -->
                        <div class="bg-gray-50 p-4 rounded-lg border-2 border-blue-500">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="font-medium text-gray-800">PayPal</h4>
                                <img src="https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-100px.png" alt="PayPal Logo" class="h-6">
                            </div>
                            <p class="text-sm text-gray-600 mb-4">Payez de façon sécurisée avec votre compte PayPal ou votre carte bancaire via PayPal.</p>
                            <form action="{{ route('reservations.paypal.process', $reservation) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                                    Payer avec PayPal
                                </button>
                            </form>
                        </div>
                        
                        <!-- Additional payment methods could be added here -->
                    </div>
                </div>
                
                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <form action="{{ route('reservations.cancel', $reservation) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation?');">
                        @csrf
                        <button type="submit" class="py-2 px-4 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Annuler la réservation
                        </button>
                    </form>
                    
                    <a href="{{ route('reservations.show', $reservation) }}" class="text-gray-600 hover:text-gray-800 font-medium">
                        Retour aux détails
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection