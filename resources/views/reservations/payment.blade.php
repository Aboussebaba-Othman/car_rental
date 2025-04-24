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
                            
                            <!-- Vehicle Photos -->
                            @if($reservation->vehicle->photos->count() > 0)
                            <div class="flex mt-2 space-x-2 overflow-x-auto pb-2">
                                @foreach($reservation->vehicle->photos->take(4) as $photo)
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('storage/' . $photo->path) }}" 
                                         alt="{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}" 
                                         class="h-16 w-20 object-cover rounded">
                                </div>
                                @endforeach
                                @if($reservation->vehicle->photos->count() > 4)
                                <div class="flex-shrink-0 h-16 w-20 bg-gray-200 rounded flex items-center justify-center">
                                    <span class="text-gray-600 text-sm font-medium">+{{ $reservation->vehicle->photos->count() - 4 }}</span>
                                </div>
                                @endif
                            </div>
                            @endif
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
                        <div class="bg-gray-50 p-4 rounded-lg border-2 border-blue-500 hover:shadow-md transition-shadow duration-300">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="font-medium text-gray-800">PayPal</h4>
                                <img src="https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-100px.png" alt="PayPal Logo" class="h-6">
                            </div>
                            <p class="text-sm text-gray-600 mb-4">Payez de façon sécurisée avec votre compte PayPal ou votre carte bancaire via PayPal.</p>
                            <form action="{{ route('reservations.paypal.process', $reservation) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Payer avec PayPal
                                </button>
                            </form>
                        </div>
                        
                        <!-- Carte Bancaire Payment Option (Placeholder) -->
                        <div class="bg-gray-50 p-4 rounded-lg border-2 border-gray-300 hover:shadow-md transition-shadow duration-300">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="font-medium text-gray-800">Carte Bancaire</h4>
                                <div class="flex space-x-1">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" alt="Visa Logo" class="h-5">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png" alt="Mastercard Logo" class="h-5">
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 mb-4">Payez en ligne par carte bancaire via notre système sécurisé.</p>
                            <button type="button" class="w-full bg-gray-600 text-white py-2 px-4 rounded opacity-50 cursor-not-allowed flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                Bientôt disponible
                            </button>
                        </div>
                    </div>
                    
                    <!-- Security Information -->
                    <div class="mt-6 bg-blue-50 p-4 rounded-lg border border-blue-100">
                        <h4 class="flex items-center text-blue-800 font-medium mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Paiement 100% sécurisé
                        </h4>
                        <p class="text-sm text-blue-700 mb-2">
                            Vos informations de paiement sont sécurisées grâce à un chiffrement SSL 256 bits. Nous ne stockons jamais vos données de carte bancaire.
                        </p>
                        <div class="flex flex-wrap items-center mt-2 text-blue-600 text-xs gap-3">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Connexion sécurisée
                            </span>
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Paiement vérifié
                            </span>
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                </svg>
                                Protection des données
                            </span>
                        </div>
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
@include('layouts.footer')
@endsection