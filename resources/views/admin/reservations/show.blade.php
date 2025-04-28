@extends('layouts.admin')

@section('content')
<div class="px-6 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.reservations.index') }}" class="text-gray-600 hover:text-yellow-600 flex items-center transition duration-150 ease-in-out">
            <i class="fas fa-arrow-left mr-2"></i> Retour à la liste des réservations
        </a>
    </div>
    
    <!-- Reservation Header - Improved styling -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6 border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                <i class="fas fa-receipt text-yellow-500 mr-3"></i>
                Réservation #{{ $reservation->id }}
            </h2>
            <div>
                @switch($reservation->status)
                    @case('pending')
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                            <i class="fas fa-clock mr-2"></i> En attente
                        </span>
                        @break
                    @case('confirmed')
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-green-100 text-green-800 border border-green-200">
                            <i class="fas fa-check mr-2"></i> Confirmée
                        </span>
                        @break
                    @case('completed')
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800 border border-blue-200">
                            <i class="fas fa-flag-checkered mr-2"></i> Terminée
                        </span>
                        @break
                    @case('cancelled')
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-red-100 text-red-800 border border-red-200">
                            <i class="fas fa-times mr-2"></i> Annulée
                        </span>
                        @break
                    @default
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800 border border-gray-200">
                            {{ $reservation->status }}
                        </span>
                @endswitch
            </div>
        </div>
        
        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 bg-white">
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                <p class="text-sm font-medium text-gray-500 mb-1">Date de réservation</p>
                <p class="font-medium text-gray-900 flex items-center">
                    <i class="far fa-calendar-alt mr-2 text-yellow-500"></i>
                    {{ $reservation->created_at->format('d/m/Y H:i') }}
                </p>
            </div>
            
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                <p class="text-sm font-medium text-gray-500 mb-1">Période de location</p>
                <p class="font-medium text-gray-900 flex items-center">
                    <i class="fas fa-calendar-day mr-2 text-yellow-500"></i>
                    {{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }} - 
                    {{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}
                </p>
            </div>
            
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                <p class="text-sm font-medium text-gray-500 mb-1">Durée</p>
                <p class="font-medium text-gray-900 flex items-center">
                    <i class="far fa-clock mr-2 text-yellow-500"></i>
                    {{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) }} jours
                </p>
            </div>
            
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                <p class="text-sm font-medium text-gray-500 mb-1">Total</p>
                <p class="font-medium text-gray-900 flex items-center">
                    <i class="fas fa-euro-sign mr-2 text-yellow-500"></i>
                    <span class="text-lg font-bold">{{ number_format($reservation->total_price, 2) }} €</span>
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Client Information - Improved styling -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-800 flex items-center">
                        <i class="fas fa-user-circle text-yellow-500 mr-2"></i> Informations client
                    </h3>
                </div>
                
                @if($reservation->user)
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center mb-6 pb-6 border-b border-gray-100">
                            <div class="h-16 w-16 rounded-full bg-yellow-100 flex items-center justify-center mr-4 flex-shrink-0 mb-4 sm:mb-0">
                                @if($reservation->user->avatar)
                                    <img src="{{ Storage::url($reservation->user->avatar) }}" alt="{{ $reservation->user->firstName }}" class="h-16 w-16 rounded-full object-cover">
                                @else
                                    <span class="text-lg font-medium text-yellow-600">
                                        {{ substr($reservation->user->firstName ?? '', 0, 1) }}{{ substr($reservation->user->lastName ?? '', 0, 1) }}
                                    </span>
                                @endif
                            </div>
                            <div>
                                <h4 class="text-xl font-medium text-gray-900">{{ $reservation->user->firstName }} {{ $reservation->user->lastName }}</h4>
                                <div class="flex items-center mt-1 text-gray-600">
                                    <i class="fas fa-envelope text-gray-400 mr-2"></i>
                                    <p>{{ $reservation->user->email }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($reservation->user->phone)
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Téléphone</p>
                                    <p class="font-medium flex items-center">
                                        <i class="fas fa-phone text-yellow-500 mr-2"></i>
                                        {{ $reservation->user->phone }}
                                    </p>
                                </div>
                            @endif
                            
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Client depuis</p>
                                <p class="font-medium flex items-center">
                                    <i class="fas fa-user-clock text-yellow-500 mr-2"></i>
                                    {{ $reservation->user->created_at->format('d/m/Y') }}
                                </p>
                            </div>
                            
                            <!-- Additional client info could go here -->
                        </div>
                    </div>
                @else
                    <div class="p-6">
                        <div class="flex items-center justify-center">
                            <div class="text-center">
                                <div class="h-16 w-16 mx-auto rounded-full bg-yellow-100 flex items-center justify-center mb-3">
                                    <i class="fas fa-user-slash text-yellow-500 text-xl"></i>
                                </div>
                                <p class="text-gray-500">Les informations du client ne sont pas disponibles.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Vehicle Information - Improved styling -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-800 flex items-center">
                        <i class="fas fa-car text-yellow-500 mr-2"></i> Véhicule
                    </h3>
                </div>
                
                @if($reservation->vehicle)
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row">
                            <div class="md:w-1/3 mb-4 md:mb-0 md:mr-6 flex-shrink-0">
                                @php
                                    $hasImage = false;
                                    $imagePath = '';
                                    
                                    if($reservation->vehicle->photos && $reservation->vehicle->photos->count() > 0) {
                                        $primaryPhoto = $reservation->vehicle->photos->where('is_primary', true)->first();
                                        if (!$primaryPhoto) {
                                            $primaryPhoto = $reservation->vehicle->photos->first();
                                        }
                                        
                                        if ($primaryPhoto) {
                                            $hasImage = true;
                                            $imagePath = $primaryPhoto->path;
                                        }
                                    }
                                @endphp
                                
                                <div class="h-48 bg-gray-100 rounded-lg overflow-hidden shadow-inner border border-gray-200">
                                    @if($hasImage)
                                        <img src="{{ Storage::url($imagePath) }}" alt="{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full bg-gray-100">
                                            <i class="fas fa-car text-5xl text-gray-300"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="md:w-2/3">
                                <h4 class="text-xl font-medium text-gray-900 mb-3">{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}</h4>
                                
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-4 p-3 bg-gray-50 rounded-lg">
                                    <div class="flex flex-col items-center text-center p-2 bg-white rounded border border-gray-100">
                                        <i class="fas fa-calendar-alt text-yellow-500 mb-1"></i>
                                        <span class="text-xs text-gray-500">Année</span>
                                        <span class="font-medium text-gray-800">{{ $reservation->vehicle->year }}</span>
                                    </div>
                                    
                                    <div class="flex flex-col items-center text-center p-2 bg-white rounded border border-gray-100">
                                        <i class="fas fa-gas-pump text-yellow-500 mb-1"></i>
                                        <span class="text-xs text-gray-500">Carburant</span>
                                        <span class="font-medium text-gray-800">{{ $reservation->vehicle->fuel_type }}</span>
                                    </div>
                                    
                                    <div class="flex flex-col items-center text-center p-2 bg-white rounded border border-gray-100">
                                        <i class="fas fa-cog text-yellow-500 mb-1"></i>
                                        <span class="text-xs text-gray-500">Boîte</span>
                                        <span class="font-medium text-gray-800">{{ $reservation->vehicle->transmission === 'automatic' ? 'Auto' : 'Manuel' }}</span>
                                    </div>
                                    
                                    <div class="flex flex-col items-center text-center p-2 bg-white rounded border border-gray-100">
                                        <i class="fas fa-users text-yellow-500 mb-1"></i>
                                        <span class="text-xs text-gray-500">Places</span>
                                        <span class="font-medium text-gray-800">{{ $reservation->vehicle->seats }}</span>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 mb-1">Immatriculation</p>
                                        <p class="font-medium flex items-center">
                                            <i class="fas fa-id-card text-yellow-500 mr-2"></i>
                                            {{ $reservation->vehicle->license_plate }}
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 mb-1">Entreprise</p>
                                        <div class="flex items-center">
                                            <div class="h-6 w-6 rounded-full bg-yellow-100 flex items-center justify-center mr-2">
                                                <span class="text-xs font-medium text-yellow-700">
                                                    {{ substr($reservation->vehicle->company->company_name ?? '', 0, 1) }}
                                                </span>
                                            </div>
                                            <p class="font-medium">{{ $reservation->vehicle->company->company_name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="p-6">
                        <div class="flex items-center justify-center">
                            <div class="text-center">
                                <div class="h-16 w-16 mx-auto rounded-full bg-yellow-100 flex items-center justify-center mb-3">
                                    <i class="fas fa-car-crash text-yellow-500 text-xl"></i>
                                </div>
                                <p class="text-gray-500">Les informations du véhicule ne sont pas disponibles.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Reservation Notes/Comments - Improved styling -->
            @if(isset($reservation->notes) && !empty($reservation->notes))
                <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-800 flex items-center">
                            <i class="fas fa-comment-alt text-yellow-500 mr-2"></i> Notes
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-yellow-400">
                            <p class="text-gray-700 italic">{{ $reservation->notes }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Right Column -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Reservation Summary - Improved styling -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-800 flex items-center">
                        <i class="fas fa-receipt text-yellow-500 mr-2"></i> Résumé de la réservation
                    </h3>
                </div>
                
                <div class="p-6">
                    <div class="flex justify-between items-center py-3 px-4 bg-gray-50 rounded-lg mb-3">
                        <span class="text-gray-600">Prix par jour</span>
                        <span class="font-medium">{{ number_format($reservation->vehicle->price_per_day ?? 0, 2) }} €</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-3 px-4 bg-gray-50 rounded-lg mb-3">
                        <span class="text-gray-600">Durée</span>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::parse($reservation->end_date)) }} jours</span>
                    </div>
                    
                    @if(isset($reservation->extra_options) && is_array($reservation->extra_options))
                        @foreach($reservation->extra_options as $option)
                            <div class="flex justify-between items-center py-3 px-4 bg-gray-50 rounded-lg mb-3">
                                <span class="text-gray-600">{{ $option['name'] ?? 'Option' }}</span>
                                <span class="font-medium">{{ number_format($option['price'] ?? 0, 2) }} €</span>
                            </div>
                        @endforeach
                    @endif
                    
                    @if($reservation->discount_amount > 0)
                        <div class="flex justify-between items-center py-3 px-4 bg-green-50 rounded-lg mb-3 text-green-700">
                            <span>Réduction</span>
                            <span class="font-medium">-{{ number_format($reservation->discount_amount, 2) }} €</span>
                        </div>
                    @endif
                    
                    <div class="mt-6 p-4 bg-yellow-50 rounded-lg border border-yellow-100">
                        <div class="flex justify-between mb-1">
                            <span class="font-medium text-gray-700">Total</span>
                            <span class="text-lg font-bold text-yellow-600">{{ number_format($reservation->total_price, 2) }} €</span>
                        </div>
                        
                        @if($reservation->payment_status === 'paid')
                            <div class="flex justify-end mt-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Payé
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Payment Information - Improved styling and removed "Voir la facture" button -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-800 flex items-center">
                        <i class="fas fa-credit-card text-yellow-500 mr-2"></i> Informations de paiement
                    </h3>
                </div>
                
                <div class="p-6">
                    @if(in_array($reservation->status, ['confirmed', 'paid', 'completed']) && $reservation->payment_method)
                        <div class="bg-green-50 p-4 rounded-lg border border-green-200 mb-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-green-100 rounded-full p-2">
                                    <i class="fas fa-check-circle h-6 w-6 text-green-600"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-medium text-green-800">Paiement Effectué</h3>
                                    <p class="text-green-700">Le paiement du client a été traité avec succès.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-6">
                            <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                                <h4 class="text-sm font-medium text-gray-700 mb-3 pb-2 border-b border-gray-200">Détails du paiement</h4>
                                <div class="grid grid-cols-1 gap-4">
                                    <div class="flex justify-between items-center">
                                        <p class="text-sm text-gray-500">Méthode</p>
                                        <p class="font-medium">
                                            @if($reservation->payment_method == 'paypal')
                                                <span class="inline-flex items-center bg-blue-100 text-blue-800 px-2 py-1 rounded-md">
                                                    <i class="fab fa-paypal mr-1.5"></i> PayPal
                                                </span>
                                            @elseif($reservation->payment_method == 'card')
                                                <span class="inline-flex items-center bg-gray-100 text-gray-800 px-2 py-1 rounded-md">
                                                    <i class="fas fa-credit-card mr-1.5"></i> Carte bancaire
                                                </span>
                                            @else
                                                {{ ucfirst($reservation->payment_method) }}
                                            @endif
                                        </p>
                                    </div>
                                    
                                    <div class="flex justify-between items-center">
                                        <p class="text-sm text-gray-500">Date</p>
                                        <p class="font-medium">{{ $reservation->payment_date ? \Carbon\Carbon::parse($reservation->payment_date)->format('d/m/Y H:i') : 'Non spécifiée' }}</p>
                                    </div>
                                    
                                    @if($reservation->transaction_id)
                                        <div class="flex justify-between items-center">
                                            <p class="text-sm text-gray-500">Transaction ID</p>
                                            <p class="font-medium font-mono text-sm">{{ $reservation->transaction_id }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($reservation->payer_id)
                                        <div class="flex justify-between items-center">
                                            <p class="text-sm text-gray-500">Payer ID</p>
                                            <p class="font-medium font-mono text-sm">{{ $reservation->payer_id }}</p>
                                        </div>
                                    @endif
                                    
                                    <div class="flex justify-between items-center mt-2 pt-2 border-t border-gray-200">
                                        <p class="text-sm text-gray-500">Montant payé</p>
                                        <p class="text-lg font-bold text-green-600">{{ number_format($reservation->amount_paid ?? $reservation->total_price, 2) }} €</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    @elseif(in_array($reservation->status, ['pending', 'payment_pending']))
                        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200 mb-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-yellow-100 rounded-full p-2">
                                    <i class="fas fa-clock h-6 w-6 text-yellow-600"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-medium text-yellow-800">Paiement En Attente</h3>
                                    <p class="text-yellow-700">Le client n'a pas encore finalisé le paiement de cette réservation.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                            <h4 class="text-sm font-medium text-gray-700 mb-3 pb-2 border-b border-gray-200">État du paiement</h4>
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Statut</p>
                                <p class="font-medium text-yellow-600">En attente de paiement</p>
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <p class="text-sm text-gray-500 mb-1">Montant dû</p>
                                <p class="text-xl font-bold text-gray-800">{{ number_format($reservation->total_price, 2) }} €</p>
                            </div>
                        </div>
                    
                    @elseif($reservation->status === 'canceled')
                        <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-red-100 rounded-full p-2">
                                    <i class="fas fa-times h-6 w-6 text-red-600"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-medium text-red-800">Réservation Annulée</h3>
                                    <p class="text-red-700">Cette réservation a été annulée {{ isset($reservation->canceled_at) ? 'le ' . \Carbon\Carbon::parse($reservation->canceled_at)->format('d/m/Y') : '' }}.</p>
                                </div>
                            </div>
                            
                            @if(isset($reservation->cancellation_reason) && $reservation->cancellation_reason)
                                <div class="mt-4 p-3 bg-white rounded-lg border border-red-100">
                                    <p class="font-medium text-sm text-red-800 mb-1">Motif d'annulation :</p>
                                    <p class="text-red-700">{{ $reservation->cancellation_reason }}</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Review Information - Improved styling -->
            @if(isset($reservation->reviews) && $reservation->reviews->count() > 0)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-800 flex items-center">
                            <i class="fas fa-star text-yellow-500 mr-2"></i> Avis client
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        @foreach($reservation->reviews as $review)
                            <div class="mb-4 pb-4 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex text-yellow-400">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-500">{{ $review->created_at->format('d/m/Y') }}</span>
                                </div>
                                <p class="text-gray-700 bg-gray-50 p-3 rounded-lg border-l-4 border-yellow-300">{{ $review->comment }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Add some custom styles to enhance the design */
    .transition-all {
        transition: all 0.2s ease-in-out;
    }
    
    /* Improve hover interactions */
    .bg-gray-50:hover {
        background-color: #FAFAFA;
    }
    
    /* Add smooth scrolling */
    html {
        scroll-behavior: smooth;
    }
</style>
@endsection
