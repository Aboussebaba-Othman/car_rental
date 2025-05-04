@extends('layouts.company')

@section('title', 'Détails de la Réservation')
@section('header', 'Détails de la Réservation')

@section('content')
<!-- Header avec statut et actions -->
<div class="bg-white rounded-lg shadow-sm mb-6 overflow-hidden">
    <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between p-6">
        <div class="flex flex-col">
            <div class="flex items-center">
                <h2 class="text-2xl font-bold text-gray-900">Détails de la Réservation</h2>
                <span class="ml-4 px-3 py-1 text-sm font-medium rounded-full 
                    @if($reservation->status == 'confirmed') bg-green-100 text-green-800 
                    @elseif($reservation->status == 'pending') bg-yellow-100 text-yellow-800 
                    @elseif($reservation->status == 'payment_pending') bg-blue-100 text-blue-800
                    @elseif($reservation->status == 'canceled') bg-red-100 text-red-800
                    @elseif($reservation->status == 'completed') bg-gray-100 text-gray-800
                    @elseif($reservation->status == 'paid') bg-emerald-100 text-emerald-800
                    @endif">
                    @if($reservation->status == 'confirmed') Confirmée
                    @elseif($reservation->status == 'pending') En attente
                    @elseif($reservation->status == 'payment_pending') Paiement en attente
                    @elseif($reservation->status == 'canceled') Annulée
                    @elseif($reservation->status == 'completed') Terminée
                    @elseif($reservation->status == 'paid') Payée
                    @else {{ ucfirst($reservation->status) }}
                    @endif
                </span>
            </div>
            <div class="mt-1 text-sm text-gray-500 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Créée le {{ \Carbon\Carbon::parse($reservation->created_at)->format('d/m/Y \à H:i') }}
            </div>
        </div>
        <div class="flex flex-wrap gap-2 mt-4 lg:mt-0">
            @if(in_array($reservation->status, ['pending', 'payment_pending']))
                <form method="POST" action="{{ route('company.reservations.confirm', $reservation) }}" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-wider hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-900 focus:ring focus:ring-green-300 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Confirmer
                    </button>
                </form>
                <button type="button" onclick="openCancellationModal()" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-wider hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-900 focus:ring focus:ring-red-300 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Annuler
                </button>
            @endif

            @if($reservation->status === 'confirmed' || $reservation->status === 'paid')
                <form method="POST" action="{{ route('company.reservations.complete', $reservation) }}" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-wider hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Terminer
                    </button>
                </form>
            @endif

            <a href="{{ route('company.reservations.invoice', $reservation) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-wider hover:bg-gray-50 active:bg-gray-100 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Facture
            </a>
        </div>
    </div>
</div>

<!-- Tabs pour les différentes sections -->
<div class="mb-6">
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8" id="reservationTabs">
            <button type="button" onclick="switchTab('overview')" class="tab-link border-indigo-500 text-indigo-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm active-tab" data-tab="overview">
                Vue d'ensemble
            </button>
            <button type="button" onclick="switchTab('details')" class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" data-tab="details">
                Détails
            </button>
            <button type="button" onclick="switchTab('payment')" class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" data-tab="payment">
                Paiement
            </button>
            <button type="button" onclick="switchTab('notes')" class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" data-tab="notes">
                Notes
            </button>
            <button type="button" onclick="switchTab('activity')" class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" data-tab="activity">
                Activité
            </button>
        </nav>
    </div>
</div>

<!-- Vue d'ensemble -->
<div id="overview" class="tab-content">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informations du client -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                <h3 class="text-lg font-medium text-gray-900">Informations du Client</h3>
                
            </div>
            <div class="p-6">
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0 w-16 h-16 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xl font-bold border-2 border-indigo-200">
                        {{ substr($reservation->user->firstName ?? '', 0, 1) }}{{ substr($reservation->user->lastName ?? '', 0, 1) }}
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-bold text-gray-900">{{ $reservation->user->firstName }} {{ $reservation->user->lastName }}</h4>
                        <p class="text-sm text-gray-500">Client depuis {{ \Carbon\Carbon::parse($reservation->user->created_at)->format('M Y') }}</p>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-3 text-sm">
                            <p class="text-gray-500">Adresse e-mail</p>
                            <p class="font-medium">{{ $reservation->user->email }}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div class="ml-3 text-sm">
                            <p class="text-gray-500">Numéro de téléphone</p>
                            <p class="font-medium">{{ $reservation->user->phone ?? 'Non fourni' }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h5 class="text-sm font-medium text-gray-700 mb-3">Réservations précédentes</h5>
                    
                    @php
                    $previousReservations = $reservation->user->reservations()
                        ->where('id', '!=', $reservation->id)
                        ->latest()
                        ->take(3)
                        ->get();
                    @endphp
                    
                    @if($previousReservations->count() > 0)
                        <div class="space-y-3">
                            @foreach($previousReservations as $prevReservation)
                                <div class="flex items-center justify-between text-sm">
                                    <div>
                                        <span class="font-medium">{{ $prevReservation->vehicle->brand }} {{ $prevReservation->vehicle->model }}</span>
                                        <div class="text-gray-500 text-xs">{{ \Carbon\Carbon::parse($prevReservation->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($prevReservation->end_date)->format('d/m/Y') }}</div>
                                    </div>
                                    <span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full 
                                        @if($prevReservation->status == 'confirmed') bg-green-100 text-green-800 
                                        @elseif($prevReservation->status == 'pending') bg-yellow-100 text-yellow-800 
                                        @elseif($prevReservation->status == 'payment_pending') bg-blue-100 text-blue-800
                                        @elseif($prevReservation->status == 'canceled') bg-red-100 text-red-800
                                        @elseif($prevReservation->status == 'completed') bg-gray-100 text-gray-800
                                        @elseif($prevReservation->status == 'paid') bg-emerald-100 text-emerald-800
                                        @endif">
                                        {{ ucfirst($prevReservation->status) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm italic">Aucune réservation précédente trouvée.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Informations du véhicule -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                <h3 class="text-lg font-medium text-gray-900">Informations du Véhicule</h3>
                <a href="{{ route('company.vehicles.show', $reservation->vehicle) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                    Voir détails
                </a>
            </div>
            <div class="p-6">
                <div class="aspect-w-16 aspect-h-9 mb-5">
                    @if($reservation->vehicle->photos->count() > 0)
                        @php $primaryPhoto = $reservation->vehicle->photos->firstWhere('is_primary', true) ?? $reservation->vehicle->photos->first(); @endphp
                        <img src="{{ asset('storage/' . $primaryPhoto->path) }}" alt="{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}" class="w-full h-52 object-cover rounded-lg">
                    @else
                        <div class="w-full h-52 bg-gray-200 flex items-center justify-center rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>
                
                <h4 class="text-lg font-bold text-gray-900 mb-4">{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }} ({{ $reservation->vehicle->year }})</h4>
                
                <div class="grid grid-cols-2 gap-y-4 gap-x-6">
                    <div>
                        <div class="flex items-center mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                            <p class="text-xs font-medium text-gray-500">Immatriculation</p>
                        </div>
                        <p class="font-medium">{{ $reservation->vehicle->license_plate }}</p>
                    </div>
                    <div>
                        <div class="flex items-center mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <p class="text-xs font-medium text-gray-500">Places</p>
                        </div>
                        <p class="font-medium">{{ $reservation->vehicle->seats }}</p>
                    </div>
                    <div>
                        <div class="flex items-center mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <p class="text-xs font-medium text-gray-500">Transmission</p>
                        </div>
                        <p class="font-medium">{{ ucfirst($reservation->vehicle->transmission) }}</p>
                    </div>
                    <div>
                        <div class="flex items-center mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <p class="text-xs font-medium text-gray-500">Carburant</p>
                        </div>
                        <p class="font-medium">{{ ucfirst($reservation->vehicle->fuel_type) }}</p>
                    </div>
                </div>
                
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <p class="text-gray-500 text-sm">Tarif journalier</p>
                        <p class="text-xl font-bold text-indigo-600">{{ number_format($reservation->vehicle->price_per_day, 2) }} €</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Détails de la réservation / résumé -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="border-b border-gray-200 px-6 py-4">
                <h3 class="text-lg font-medium text-gray-900">Résumé de la Réservation</h3>
            </div>
            <div class="p-6">
                <div class="mb-6 bg-indigo-50 rounded-lg p-4">
                    <div class="flex justify-between items-center mb-3">
                        <div class="flex items-center">
                            <div class="bg-indigo-100 rounded-full p-2 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-indigo-800 font-medium">Prise en charge</div>
                                <div class="font-semibold text-indigo-900">{{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        <div class="flex-shrink-0 hidden md:block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </div>
                        <div class="flex items-center">
                            <div class="bg-indigo-100 rounded-full p-2 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-indigo-800 font-medium">Retour</div>
                                <div class="font-semibold text-indigo-900">{{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 flex justify-center">
                        <div class="text-center px-4 py-2 bg-indigo-100 rounded-full text-sm text-indigo-800 font-medium">
                            {{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) + 1 }} jours
                        </div>
                    </div>
                </div>
                
                <div class="space-y-5">
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Lieux</h4>
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="bg-gray-100 rounded-full p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-2 text-sm">
                                    <p class="text-xs text-gray-500">Lieu de prise en charge</p>
                                    <p class="font-medium">{{ $reservation->pickup_location }}</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="bg-gray-100 rounded-full p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-2 text-sm">
                                    <p class="text-xs text-gray-500">Lieu de retour</p>
                                    <p class="font-medium">{{ $reservation->return_location }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($reservation->notes)
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Notes du Client</h4>
                        <div class="bg-gray-50 p-3 rounded-lg text-sm">
                            {{ $reservation->notes }}
                        </div>
                    </div>
                    @endif
                    
                    <div class="border-t border-gray-200 pt-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Récapitulatif des prix</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Tarif journalier</span>
                                <span>{{ number_format($reservation->vehicle->price_per_day, 2) }} €</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Nombre de jours</span>
                                <span>{{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) + 1 }}</span>
                            </div>
                            
                            @if($reservation->promotion)
                            <div class="flex justify-between">
                                <span class="text-gray-500">Sous-total</span>
                                <span>{{ number_format($reservation->vehicle->price_per_day * (\Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) + 1), 2) }} €</span>
                            </div>
                            <div class="flex justify-between text-green-600">
                                <span>Promotion ({{ $reservation->promotion->name }}, {{ $reservation->promotion->discount_percentage }}%)</span>
                                <span>-{{ number_format(($reservation->vehicle->price_per_day * (\Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) + 1)) * ($reservation->promotion->discount_percentage / 100), 2) }} €</span>
                            </div>
                            @endif
                            
                            <div class="flex justify-between font-bold pt-2 border-t text-base">
                                <span>Montant total</span>
                                <span class="text-indigo-600">{{ number_format($reservation->total_price, 2) }} €</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Détails de la réservation (onglet détails) -->
<div id="details" class="tab-content hidden">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="border-b border-gray-200 px-6 py-4 bg-gradient-to-r from-gray-50 to-white">
            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Détails Complets de la Réservation
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h4 class="text-base font-medium text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Informations de Base
                    </h4>
                    
                    <div class="bg-gray-50 rounded-lg p-4 space-y-4 border border-gray-100 hover:shadow-md transition-shadow duration-300">
                        <div class="flex justify-between items-center">
                            <p class="text-sm text-gray-500">Créée le</p>
                            <p class="font-medium text-sm bg-gray-100 px-2 py-1 rounded flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ \Carbon\Carbon::parse($reservation->created_at)->format('d/m/Y \à H:i') }}
                            </p>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <p class="text-sm text-gray-500">Statut</p>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full inline-flex items-center
                                @if($reservation->status == 'confirmed') bg-green-100 text-green-800 
                                @elseif($reservation->status == 'pending') bg-yellow-100 text-yellow-800 
                                @elseif($reservation->status == 'payment_pending') bg-blue-100 text-blue-800
                                @elseif($reservation->status == 'canceled') bg-red-100 text-red-800
                                @elseif($reservation->status == 'completed') bg-gray-100 text-gray-800
                                @elseif($reservation->status == 'paid') bg-emerald-100 text-emerald-800
                                @endif">
                                @if($reservation->status == 'confirmed')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Confirmée
                                @elseif($reservation->status == 'pending')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    En attente
                                @elseif($reservation->status == 'payment_pending')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    Paiement en attente
                                @elseif($reservation->status == 'canceled')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Annulée
                                @elseif($reservation->status == 'completed')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Terminée
                                @elseif($reservation->status == 'paid')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                    </svg>
                                    Payée
                                @else
                                    {{ ucfirst($reservation->status) }}
                                @endif
                            </span>
                        </div>

                        <div class="flex justify-between items-center">
                            <p class="text-sm text-gray-500">Durée totale</p>
                            <p class="font-medium text-sm bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) + 1 }} jours
                            </p>
                        </div>

                        <div class="border-t border-gray-200 pt-3 mt-2">
                            <h5 class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Informations client
                            </h5>
                            <div class="flex justify-between items-center py-1">
                                <p class="text-sm text-gray-500">Client</p>
                                <p class="font-medium text-sm">{{ $reservation->user->firstName }} {{ $reservation->user->lastName }}</p>
                            </div>
                            <div class="flex justify-between items-center py-1">
                                <p class="text-sm text-gray-500">Email</p>
                                <a href="mailto:{{ $reservation->user->email }}" class="font-medium text-sm text-indigo-600 hover:text-indigo-800 hover:underline transition-colors">{{ $reservation->user->email }}</a>
                            </div>
                            @if($reservation->user->phone)
                            <div class="flex justify-between items-center py-1">
                                <p class="text-sm text-gray-500">Téléphone</p>
                                <a href="tel:{{ $reservation->user->phone }}" class="font-medium text-sm text-indigo-600 hover:text-indigo-800 hover:underline transition-colors">{{ $reservation->user->phone }}</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-base font-medium text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Véhicule Réservé
                    </h4>
                    
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-100 hover:shadow-md transition-shadow duration-300">
                        <div class="flex items-center mb-4">
                            <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded bg-gray-200 border border-gray-300">
                                @if($reservation->vehicle->photos->count() > 0)
                                    @php $primaryPhoto = $reservation->vehicle->photos->firstWhere('is_primary', true) ?? $reservation->vehicle->photos->first(); @endphp
                                    <img src="{{ asset('storage/' . $primaryPhoto->path) }}" alt="{{ $reservation->vehicle->brand }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full w-full bg-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <h5 class="font-bold text-gray-800">{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}</h5>
                                <p class="text-sm text-gray-500">{{ $reservation->vehicle->year }} • {{ ucfirst($reservation->vehicle->transmission) }} • {{ ucfirst($reservation->vehicle->fuel_type) }}</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div class="bg-white p-2 rounded border border-gray-200 hover:border-indigo-200 transition-colors">
                                <p class="text-xs text-gray-500 mb-1">Immatriculation</p>
                                <p class="font-medium">{{ $reservation->vehicle->license_plate }}</p>
                            </div>
                            <div class="bg-white p-2 rounded border border-gray-200 hover:border-indigo-200 transition-colors">
                                <p class="text-xs text-gray-500 mb-1">Places</p>
                                <p class="font-medium">{{ $reservation->vehicle->seats }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-4 p-3 bg-indigo-50 rounded-lg border border-indigo-100">
                            <h5 class="text-sm font-medium text-indigo-900 mb-2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Période de location
                            </h5>
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-xs text-indigo-700">Prise en charge</p>
                                    <p class="font-semibold text-indigo-900">{{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }}</p>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                                <div>
                                    <p class="text-xs text-indigo-700">Retour</p>
                                    <p class="font-semibold text-indigo-900">{{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 space-y-2">
                            <div class="flex justify-between items-center">
                                <p class="text-sm text-gray-500 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Lieu de prise en charge
                                </p>
                                <p class="text-sm font-medium">{{ $reservation->pickup_location }}</p>
                            </div>
                            <div class="flex justify-between items-center">
                                <p class="text-sm text-gray-500 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Lieu de retour
                                </p>
                                <p class="text-sm font-medium">{{ $reservation->return_location }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-200 mt-8 pt-8">
                <h4 class="text-base font-medium text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                    </svg>
                    Informations Financières
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-100 hover:shadow-md transition-shadow duration-300">
                        <h5 class="text-sm font-medium text-gray-700 mb-3 pb-2 border-b border-gray-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Tarification
                        </h5>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <p class="text-sm text-gray-500">Tarif journalier</p>
                                <p class="font-medium">{{ number_format($reservation->vehicle->price_per_day, 2) }} €</p>
                            </div>
                            <div class="flex justify-between items-center">
                                <p class="text-sm text-gray-500">Nombre de jours</p>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) + 1 }}</p>
                            </div>
                            
                            <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                                <p class="text-sm text-gray-500">Sous-total</p>
                                <p class="font-medium">{{ number_format($reservation->vehicle->price_per_day * (\Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) + 1), 2) }} €</p>
                            </div>
                            
                            @if($reservation->promotion)
                            <div class="flex justify-between items-center text-green-600">
                                <p class="text-sm flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    Promotion appliquée
                                </p>
                                <div class="text-right">
                                    <p class="font-medium">{{ $reservation->promotion->name }}</p>
                                    <p class="text-xs">-{{ $reservation->promotion->discount_percentage }}%</p>
                                </div>
                            </div>
                            <div class="flex justify-between items-center text-green-600">
                                <p class="text-sm">Réduction</p>
                                <p class="font-medium">-{{ number_format(($reservation->vehicle->price_per_day * (\Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) + 1)) * ($reservation->promotion->discount_percentage / 100), 2) }} €</p>
                            </div>
                            @endif
                            
                            <div class="flex justify-between items-center pt-2 mt-2 border-t border-gray-200">
                                <p class="text-sm font-bold">Montant total</p>
                                <p class="text-lg font-bold text-indigo-600">{{ number_format($reservation->total_price, 2) }} €</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-100 hover:shadow-md transition-shadow duration-300">
                        <h5 class="text-sm font-medium text-gray-700 mb-3 pb-2 border-b border-gray-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                            </svg>
                            État du paiement
                        </h5>
                        <div class="flex items-center mb-4">
                            <div class="rounded-full w-10 h-10 flex items-center justify-center mr-3
                                @if(in_array($reservation->status, ['confirmed', 'paid', 'completed'])) bg-green-100 text-green-600 
                                @elseif(in_array($reservation->status, ['pending', 'payment_pending'])) bg-yellow-100 text-yellow-600
                                @elseif($reservation->status == 'canceled') bg-red-100 text-red-600
                                @endif">
                                
                                @if(in_array($reservation->status, ['confirmed', 'paid', 'completed']))
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                @elseif(in_array($reservation->status, ['pending', 'payment_pending']))
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @elseif($reservation->status == 'canceled')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="font-medium 
                                    @if(in_array($reservation->status, ['confirmed', 'paid', 'completed'])) text-green-600 
                                    @elseif(in_array($reservation->status, ['pending', 'payment_pending'])) text-yellow-600
                                    @elseif($reservation->status == 'canceled') text-red-600
                                    @endif">
                                    @if(in_array($reservation->status, ['confirmed', 'paid', 'completed'])) Payé
                                    @elseif(in_array($reservation->status, ['pending', 'payment_pending'])) En attente
                                    @elseif($reservation->status == 'canceled') Annulé
                                    @endif
                                </p>
                                @if(in_array($reservation->status, ['confirmed', 'paid', 'completed']))
                                    <p class="text-xs text-gray-500">Le paiement a été reçu et confirmé</p>
                                @elseif(in_array($reservation->status, ['pending', 'payment_pending']))
                                    <p class="text-xs text-gray-500">En attente de paiement de la part du client</p>
                                @elseif($reservation->status == 'canceled')
                                    <p class="text-xs text-gray-500">La réservation a été annulée</p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            @if($reservation->payment_method)
                            <div class="flex justify-between items-center">
                                <p class="text-sm text-gray-500">Méthode de paiement</p>
                                <p class="font-medium">{{ ucfirst($reservation->payment_method) }}</p>
                            </div>
                            @endif
                            
                            @if($reservation->payment_date)
                            <div class="flex justify-between items-center">
                                <p class="text-sm text-gray-500">Date de paiement</p>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($reservation->payment_date)->format('d/m/Y \à H:i') }}</p>
                            </div>
                            @endif
                            
                            @if($reservation->transaction_id)
                            <div class="flex justify-between items-center">
                                <p class="text-sm text-gray-500">Identifiant de transaction</p>
                                <p class="font-medium font-mono text-xs bg-gray-100 px-2 py-1 rounded">{{ $reservation->transaction_id }}</p>
                            </div>
                            @endif
                            
                            @if(in_array($reservation->status, ['confirmed', 'paid', 'completed']))
                            <div class="mt-4 pt-2 border-t border-gray-200">
                                <a href="{{ route('company.reservations.invoice', $reservation) }}" class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    Télécharger la facture
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            @if($reservation->notes)
            <div class="border-t border-gray-200 mt-8 pt-8">
                <h4 class="text-base font-medium text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Notes du Client
                </h4>
                <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                    <div class="flex items-start mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-2 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        <p class="text-sm text-gray-700 whitespace-pre-line">{{ $reservation->notes }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Onglet Notes -->
<div id="notes" class="tab-content hidden">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Notes Internes</h3>
        </div>
        
        <div class="p-6">
            <div class="mb-6">
                <form method="POST" action="{{ route('company.reservations.add-note', $reservation) }}">
                    @csrf
                    <div class="mb-4">
                        <label for="note" class="block text-sm font-medium text-gray-700 mb-1">Ajouter une Note</label>
                        <textarea id="note" name="note" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Ajoutez des notes internes concernant cette réservation..."></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Ajouter une Note
                        </button>
                    </div>
                </form>
            </div>
            
            <div>
                <h4 class="text-sm font-medium text-gray-700 mb-3">Notes Précédentes</h4>
                
                @if(isset($reservation->notes_history) && count($reservation->notes_history) > 0)
                    <div class="space-y-4">
                        @foreach($reservation->notes_history as $note)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex justify-between items-start">
                                    <div class="flex items-center">
                                        <img class="h-8 w-8 rounded-full mr-3" src="https://ui-avatars.com/api/?name={{ urlencode($note->user->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $note->user->name }}">
                                        <div>
                                            <p class="font-medium">{{ $note->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($note->created_at)->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="text-gray-400 hover:text-gray-500" title="Options">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-3 text-sm text-gray-700 whitespace-pre-line">
                                    {{ $note->content }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-50 p-6 rounded-lg text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-gray-500 text-sm italic">Aucune note disponible pour cette réservation.</p>
                        <p class="text-gray-500 text-xs mt-1">Ajoutez la première note ci-dessus.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Onglet Paiement -->
<div id="payment" class="tab-content hidden">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Informations de Paiement</h3>
        </div>
        
        <div class="p-6">
            @if(in_array($reservation->status, ['confirmed', 'paid', 'completed']))
                <div class="bg-green-50 p-5 rounded-lg border border-green-100 mb-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-100 rounded-full p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-green-800">Paiement Effectué</h3>
                            <p class="text-green-600">Le paiement du client a été traité avec succès.</p>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Détails du Paiement</h4>
                        <div class="bg-gray-50 p-5 rounded-lg">
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-500">Méthode de Paiement</p>
                                    <p class="font-medium">{{ ucfirst($reservation->payment_method ?? 'Non spécifié') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Date de Paiement</p>
                                    <p class="font-medium">{{ $reservation->payment_date ? \Carbon\Carbon::parse($reservation->payment_date)->format('d/m/Y H:i') : 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Statut du Paiement</p>
                                    <p class="font-medium text-green-600">Terminé</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Montant du Paiement</h4>
                        <div class="bg-gray-50 p-5 rounded-lg">
                            <div class="mb-5">
                                <p class="text-sm text-gray-500">Montant Payé</p>
                                <p class="text-2xl font-bold text-green-600">{{ number_format($reservation->total_price, 2) }} €</p>
                            </div>
                            
                            <div>
                                <a href="{{ route('company.reservations.invoice', $reservation) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    Voir la Facture
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            
            @elseif(in_array($reservation->status, ['pending', 'payment_pending']))
                <div class="bg-yellow-50 p-5 rounded-lg border border-yellow-100 mb-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-100 rounded-full p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-yellow-800">Paiement en Attente</h3>
                            <p class="text-yellow-600">Le client n'a pas encore effectué le paiement pour cette réservation.</p>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Informations de Paiement</h4>
                        <div class="bg-gray-50 p-5 rounded-lg">
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Statut</p>
                                <p class="font-medium text-yellow-600">En attente de paiement</p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Montant Total Dû</p>
                                <p class="text-2xl font-bold text-gray-800">{{ number_format($reservation->total_price, 2) }} €</p>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Actions</h4>
                        <div class="bg-gray-50 p-5 rounded-lg">
                            <div class="space-y-4">
                                <form method="POST" action="{{ route('company.reservations.send-payment-reminder', $reservation) }}" id="payment-reminder-form">
                                    @csrf
                                    <button type="submit" id="send-reminder-btn" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        Envoyer un Email de Rappel
                                    </button>
                                </form>
                                
                                <form method="POST" action="{{ route('company.reservations.mark-paid', $reservation) }}">
                                    @csrf
                                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Marquer comme Payé
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($reservation->status === 'canceled')
                <div class="bg-red-50 p-5 rounded-lg border border-red-100">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-red-100 rounded-full p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-red-800">Réservation Annulée</h3>
                            <p class="text-red-600">Cette réservation a été annulée et aucun paiement n'est requis.</p>
                        </div>
                    </div>
                    
                    @if($reservation->cancellation_reason)
                        <div class="mt-4 text-sm text-red-700">
                            <p class="font-medium">Motif d'annulation :</p>
                            <p class="mt-1">{{ $reservation->cancellation_reason }}</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Onglet Activité -->
<div id="activity" class="tab-content hidden">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Journal d'Activité</h3>
        </div>
        
        <div class="p-6">
            @if(isset($reservation->activities) && count($reservation->activities) > 0)
                <div class="flow-root">
                    <ul role="list" class="-mb-8">
                        @foreach($reservation->activities as $activity)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white 
                                                @if($activity->type === 'status_change') bg-indigo-500
                                                @elseif($activity->type === 'payment') bg-green-500
                                                @elseif($activity->type === 'note') bg-yellow-500
                                                @elseif($activity->type === 'cancellation') bg-red-500
                                                @else bg-gray-500
                                                @endif">
                                                @if($activity->type === 'status_change')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                    </svg>
                                                @elseif($activity->type === 'payment')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                    </svg>
                                                @elseif($activity->type === 'note')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                @elseif($activity->type === 'cancellation')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-700">{{ $activity->description }}</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                <p>{{ \Carbon\Carbon::parse($activity->created_at)->format('d/m/Y H:i') }}</p>
                                                @if(isset($activity->user) && $activity->user)
                                                    <p class="text-xs">par {{ $activity->user->firstName }} {{ $activity->user->lastName }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="bg-gray-50 p-6 rounded-lg text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-gray-500 text-sm italic">Aucune activité enregistrée pour cette réservation.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal pour annulation -->
<div id="cancellationModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form method="POST" action="{{ route('company.reservations.cancel', $reservation) }}">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Annuler la réservation
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Êtes-vous sûr de vouloir annuler cette réservation ? Cette action ne peut pas être annulée.
                                </p>
                                <div class="mt-4">
                                    <label for="cancellation_reason" class="block text-sm font-medium text-gray-700">Raison de l'annulation (facultatif)</label>
                                    <textarea name="cancellation_reason" id="cancellation_reason" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler la réservation
                    </button>
                    <button type="button" onclick="closeCancellationModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Retour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Debugging et initialisation
    console.log('Détails de réservation: script chargé');
    
    // Sélectionner tous les onglets et contenus
    const tabs = document.querySelectorAll('.tab-link');
    const tabContents = document.querySelectorAll('.tab-content');
    
    console.log(`${tabs.length} onglets trouvés, ${tabContents.length} contenus d'onglets trouvés`);
    
    // Fonction améliorée pour la gestion des onglets
    window.switchTab = function(tabId) {
        console.log(`Activation de l'onglet: ${tabId}`);
        
        // 1. Désactiver tous les onglets
        tabs.forEach(tab => {
            tab.classList.remove('border-indigo-500', 'text-indigo-600', 'active-tab');
            tab.classList.add('border-transparent', 'text-gray-500');
        });
        
        // 2. Activer l'onglet sélectionné
        const activeTab = document.querySelector(`.tab-link[data-tab="${tabId}"]`);
        if (activeTab) {
            activeTab.classList.remove('border-transparent', 'text-gray-500');
            activeTab.classList.add('border-indigo-500', 'text-indigo-600', 'active-tab');
        } else {
            console.error(`Onglet avec id ${tabId} non trouvé`);
            return;
        }
        
        // 3. Masquer tous les contenus d'onglets
        tabContents.forEach(content => {
            content.style.opacity = '0';
            content.classList.add('hidden');
        });
        
        // 4. Afficher le contenu de l'onglet sélectionné avec animation
        const activeContent = document.getElementById(tabId);
        if (activeContent) {
            // D'abord afficher l'élément
            activeContent.classList.remove('hidden');
            
            // Puis animer l'opacité
            setTimeout(() => {
                activeContent.style.opacity = '1';
            }, 50);
        } else {
            console.error(`Contenu d'onglet avec id ${tabId} non trouvé`);
        }
        
        // 5. Mettre à jour l'URL
        history.pushState(null, null, `#${tabId}`);
    };
    
    // Ajouter les écouteurs d'événements aux onglets
    tabs.forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            const tabId = this.getAttribute('data-tab');
            switchTab(tabId);
            return false;
        });
    });
    
    // Initialisation des onglets et du style
    function initializeTabs() {
        // Configurer les transitions pour tous les contenus d'onglets
        tabContents.forEach(content => {
            content.style.transition = 'opacity 0.25s ease-in-out';
            content.style.opacity = content.classList.contains('hidden') ? '0' : '1';
        });
        
        // Vérifier l'URL pour l'onglet actif
        const hash = window.location.hash.substring(1);
        const validTabs = ['overview', 'details', 'payment', 'notes', 'activity'];
        
        if (hash && validTabs.includes(hash)) {
            console.log(`Onglet trouvé dans l'URL: ${hash}`);
            switchTab(hash);
        } else {
            console.log('Aucun onglet valide dans l\'URL, affichage de l\'aperçu par défaut');
            switchTab('overview');
        }
    }
    
    // Initialiser les onglets
    initializeTabs();
    
    // Exposer les fonctions pour le modal d'annulation
    window.openCancellationModal = function() {
        document.getElementById('cancellationModal').classList.remove('hidden');
    };
    
    window.closeCancellationModal = function() {
        document.getElementById('cancellationModal').classList.add('hidden');
    };
});
</script>
@endsection