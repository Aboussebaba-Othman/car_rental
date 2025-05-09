@extends('layouts.app')

@section('content')
<div class="py-16 bg-gradient-to-b from-gray-50 to-gray-100">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-8 relative text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-3 inline-block">Paiement de votre réservation</h1>
            <div class="h-1 w-32 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-full mx-auto"></div>
            <p class="text-lg text-gray-600 mt-3">Finalisez votre réservation en toute sécurité</p>
        </div>
        
        <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-100">
            <div class="p-8">
                @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-5 mb-6 rounded-lg shadow-sm animate-pulse" role="alert">
                        <p class="font-medium flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            {{ session('error') }}
                        </p>
                    </div>
                @endif
                
                @if (session('warning'))
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-5 mb-6 rounded-lg shadow-sm" role="alert">
                        <p class="font-medium flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            {{ session('warning') }}
                        </p>
                    </div>
                @endif

                <div class="mb-10 border-b border-gray-200 pb-8">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                            <div class="flex items-center justify-center w-8 h-8 bg-yellow-100 rounded-full mr-3 text-yellow-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            Détails de la réservation
                        </h3>
                        <span class="px-4 py-1.5 rounded-full text-sm font-medium mt-2 md:mt-0
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="bg-gray-50 p-5 rounded-xl border border-gray-100 transition-all duration-300 hover:shadow-md">
                            <div class="flex items-start">
                                <div class="flex-grow">
                                    <p class="text-sm text-gray-500 mb-1">Véhicule:</p>
                                    <p class="font-semibold text-gray-800 text-lg">{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}</p>
                                    <p class="text-gray-600">Année {{ $reservation->vehicle->year }}</p>
                                    
                                    @if($reservation->vehicle->photos->count() > 0)
                                    <div class="flex mt-3 space-x-2 overflow-x-auto pb-2">
                                        @foreach($reservation->vehicle->photos->take(4) as $photo)
                                        <div class="flex-shrink-0 transition-transform duration-300 hover:-translate-y-1 hover:shadow-md">
                                            <img src="{{ asset('storage/' . $photo->path) }}" 
                                                alt="{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}" 
                                                class="h-16 w-20 object-cover rounded-lg">
                                        </div>
                                        @endforeach
                                        @if($reservation->vehicle->photos->count() > 4)
                                        <div class="flex-shrink-0 h-16 w-20 bg-gray-200 rounded-lg flex items-center justify-center transition-transform duration-300 hover:-translate-y-1 hover:shadow-md">
                                            <span class="text-gray-600 text-sm font-medium">+{{ $reservation->vehicle->photos->count() - 4 }}</span>
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-5 rounded-xl border border-gray-100 transition-all duration-300 hover:shadow-md">
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500 mb-1 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Période de location:
                                    </p>
                                    <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}</p>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) ?: 1 }} jour(s)
                                    </p>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Lieu de prise en charge:
                                        </p>
                                        <p class="font-medium text-gray-800">{{ $reservation->pickup_location }}</p>
                                    </div>

                                    <div>
                                        <p class="text-sm text-gray-500 mb-1 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Lieu de retour:
                                        </p>
                                        <p class="font-medium text-gray-800">{{ $reservation->return_location }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-10">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <div class="flex items-center justify-center w-8 h-8 bg-yellow-100 rounded-full mr-3 text-yellow-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        Récapitulatif du prix
                    </h3>
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-300">
                        <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-200">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-700 font-medium">Prix par jour:</span>
                            </div>
                            <span class="font-semibold text-gray-800">{{ number_format($reservation->vehicle->price_per_day, 2) }} <span class="text-yellow-500">€</span></span>
                        </div>
                        
                        <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-200">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-700 font-medium">Durée de location:</span>
                            </div>
                            <span class="font-semibold text-gray-800">
                                {{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) ?: 1 }} 
                                <span class="text-sm text-gray-500">jour(s)</span>
                            </span>
                        </div>
                        
                        @if($reservation->promotion)
                        <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-200">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 2a2 2 0 00-2 2v14l3.5-2 3.5 2 3.5-2 3.5 2V4a2 2 0 00-2-2H5zm4.707 3.707a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L8.414 9H10a3 3 0 013 3v1a1 1 0 102 0v-1a5 5 0 00-5-5H8.414l1.293-1.293z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-green-600 font-medium">Promotion appliquée ({{ $reservation->promotion->name }}):</span>
                            </div>
                            <span class="font-semibold text-green-600">-{{ $reservation->promotion->discount_percentage }}%</span>
                        </div>
                        @endif
                        
                        <div class="mt-6 pt-4 flex justify-between items-center bg-gradient-to-r from-yellow-50 to-yellow-100 p-5 rounded-lg border border-yellow-200">
                            <span class="text-gray-800 font-bold">Total à payer:</span>
                            <div class="flex items-baseline">
                                <span class="text-3xl font-bold text-yellow-600">{{ number_format($reservation->total_price, 2) }}</span>
                                <span class="ml-1 text-xl font-semibold text-yellow-500">€</span>
                            </div>
                        </div>
                        
                        <div class="mt-4 text-center">
                            <span class="text-xs text-gray-500 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Prix TTC incluant tous les frais
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mb-10">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <div class="flex items-center justify-center w-8 h-8 bg-yellow-100 rounded-full mr-3 text-yellow-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        Choisissez votre méthode de paiement
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gradient-to-br from-white to-blue-50 p-6 rounded-xl border-2 border-blue-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="font-semibold text-gray-800 text-lg">PayPal</h4>
                                <img src="https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-100px.png" alt="PayPal Logo" class="h-7">
                            </div>
                            <p class="text-sm text-gray-600 mb-5">Payez de façon sécurisée avec votre compte PayPal ou votre carte bancaire via PayPal.</p>
                            <form action="{{ route('reservations.paypal.process', $reservation) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 px-4 rounded-lg flex items-center justify-center transition-all duration-300 shadow-sm hover:shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Payer avec PayPal
                                </button>
                            </form>
                        </div>
                        
                        <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl border-2 border-gray-300 hover:shadow-md transition-all duration-300">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="font-semibold text-gray-800 text-lg">Carte Bancaire</h4>
                                <div class="flex space-x-2">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" alt="Visa Logo" class="h-6">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png" alt="Mastercard Logo" class="h-6">
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 mb-5">Payez en ligne par carte bancaire via notre système sécurisé.</p>
                            <button type="button" class="w-full bg-gray-600 text-white py-3 px-4 rounded-lg opacity-60 cursor-not-allowed flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                Bientôt disponible
                            </button>
                        </div>
                    </div>
                    
                    <div class="mt-8 bg-blue-50 p-5 rounded-xl border border-blue-100 shadow-sm">
                        <h4 class="flex items-center text-blue-800 font-medium mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Paiement 100% sécurisé
                        </h4>
                        <p class="text-sm text-blue-700 mb-3">
                            Vos informations de paiement sont sécurisées grâce à un chiffrement SSL 256 bits. Nous ne stockons jamais vos données de carte bancaire.
                        </p>
                        <div class="flex flex-wrap items-center mt-3 text-blue-600 text-xs gap-4">
                            <span class="flex items-center bg-blue-100 px-3 py-1.5 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Connexion sécurisée
                            </span>
                            <span class="flex items-center bg-blue-100 px-3 py-1.5 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Paiement vérifié
                            </span>
                            <span class="flex items-center bg-blue-100 px-3 py-1.5 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                </svg>
                                Protection des données
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row items-center justify-between pt-6 border-t border-gray-200">
                    <form action="{{ route('reservations.cancel', $reservation) }}" method="POST" class="w-full sm:w-auto mb-4 sm:mb-0" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation?');">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto py-3 px-6 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-all duration-300 flex items-center justify-center shadow-sm hover:shadow transform hover:-translate-y-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Annuler la réservation
                        </button>
                    </form>
                    
                    <a href="{{ route('reservations.show', $reservation) }}" class="w-full sm:w-auto py-3 px-6 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700 font-medium transition-all duration-300 flex items-center justify-center shadow-sm hover:shadow transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour aux détails
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')
@endsection
