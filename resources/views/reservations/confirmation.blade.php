@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-md rounded-lg">
            <div class="p-6">
                <div class="mb-6 text-center">
                    <div class="flex justify-center mb-4">
                        <div class="bg-green-100 rounded-full p-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Paiement confirmé !</h2>
                    <p class="text-gray-600 mt-2">Votre réservation a été confirmée et payée avec succès.</p>
                </div>

                <div class="bg-green-50 p-6 rounded-lg border border-green-100 mb-6">
                    <h3 class="text-lg font-medium text-green-800 mb-3">Récapitulatif de la transaction</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Référence de réservation:</p>
                            <p class="font-semibold">#{{ $reservation->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Date de paiement:</p>
                            <p class="font-semibold">{{ $reservation->payment_date ? Carbon\Carbon::parse($reservation->payment_date)->format('d/m/Y à H:i') : now()->format('d/m/Y à H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Montant payé:</p>
                            <p class="font-semibold">{{ number_format($reservation->amount_paid ?? $reservation->total_price, 2) }} €</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Méthode de paiement:</p>
                            <p class="font-semibold flex items-center">
                                @if($reservation->payment_method == 'paypal')
                                    <img src="https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-30px.png" alt="PayPal" class="h-4 mr-1">
                                    PayPal
                                @else
                                    {{ ucfirst($reservation->payment_method) }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mb-6 border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-700 mb-4">Détails de la réservation</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-700 mb-2">Véhicule</h4>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 mr-3">
                                        @if($reservation->vehicle->photos->count() > 0)
                                            @php $primaryPhoto = $reservation->vehicle->photos->firstWhere('is_primary', true) ?? $reservation->vehicle->photos->first(); @endphp
                                            <img class="h-14 w-14 rounded object-cover" 
                                                src="{{ asset('storage/' . $primaryPhoto->path) }}" 
                                                alt="{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}">
                                        @else
                                            <div class="h-14 w-14 rounded bg-gray-200 flex items-center justify-center">
                                                <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 6h1m-7 7v1m-6-6h-1M5.6 5.6l.8.8m12 12l-.8-.8" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold">{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}</p>
                                        <p class="text-sm text-gray-600">{{ $reservation->vehicle->year }} - {{ $reservation->vehicle->license_plate }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-700 mb-2">Dates de location</h4>
                                <div class="grid grid-cols-1 gap-2">
                                    <div>
                                        <p class="text-sm text-gray-600">Début:</p>
                                        <p class="font-semibold">{{ Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Fin:</p>
                                        <p class="font-semibold">{{ Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Durée:</p>
                                        <p class="font-semibold">{{ Carbon\Carbon::parse($reservation->start_date)->diffInDays(Carbon\Carbon::parse($reservation->end_date)) }} jour(s)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-6 border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-700 mb-4">Lieux</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-700 mb-2">Lieu de prise en charge</h4>
                                <p>{{ $reservation->pickup_location }}</p>
                            </div>
                        </div>
                        <div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-700 mb-2">Lieu de retour</h4>
                                <p>{{ $reservation->return_location }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-700 mb-3">Prochaines étapes</h3>
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                        <ol class="list-decimal list-inside space-y-2 text-blue-800">
                            <li>Un e-mail de confirmation vient de vous être envoyé avec tous les détails de votre réservation.</li>
                            <li>Présentez-vous au lieu de prise en charge à la date convenue avec votre permis de conduire valide.</li>
                            <li>En cas de besoin de modification ou d'annulation, contactez-nous au moins 24h à l'avance.</li>
                        </ol>
                    </div>
                </div>

                <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                    <a href="{{ route('reservations.show', $reservation) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6.672 1.911a1 1 0 10-1.932.518l.259.966a1 1 0 001.932-.518l-.26-.966zM2.429 4.74a1 1 0 10-.517 1.932l.966.259a1 1 0 00.517-1.932l-.966-.26zm8.814-.569a1 1 0 00-1.415-1.414l-.707.707a1 1 0 101.415 1.415l.707-.708zm-7.071 7.072l.707-.707A1 1 0 003.465 9.12l-.708.707a1 1 0 001.415 1.415zm3.2-5.171a1 1 0 00-1.3 1.3l4 10a1 1 0 001.823.075l1.38-2.759 3.018 3.02a1 1 0 001.414-1.415l-3.019-3.02 2.76-1.379a1 1 0 00-.076-1.822l-10-4z" clip-rule="evenodd" />
                        </svg>
                        Voir les détails de la réservation
                    </a>
                    
                    <a href="{{ route('reservations.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-500 hover:bg-yellow-600">
                        Mes réservations
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection